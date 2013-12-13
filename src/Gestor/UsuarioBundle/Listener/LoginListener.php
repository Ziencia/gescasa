<?php

namespace Gestor\UsuarioBundle\Listener;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Routing\Router;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Doctrine\Bundle\DoctrineBundle\Registry as Doctrine;

use Gestor\MensajeBundle\Entity\Mensaje;

class LoginListener {

    private $contexto, $router, $em,$rol = null;

    public function __construct(SecurityContext $context, Router $router, Doctrine $doctrine) {
       
        $this->contexto = $context;
        $this->router = $router;
        $this->em = $doctrine;
    }

    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event) {
      $user = $event->getAuthenticationToken()->getUser();
      
      $this->rol = $user->getRoles()[0];
      
      $descripcion = 'INFO: INICIO SESION, ROL: ' . $this->rol;
      $mensaje = new Mensaje($user->getID(),new \DateTime(),$descripcion);
      
      $em = $this->em->getManager();
      $em->persist($mensaje);        
      $em->flush();
       
    }

    public function onKernelResponse(FilterResponseEvent $event){   
        if (null!=$this->rol){
        
            if ($this->contexto->isGranted('ROLE_SUPER_ADMIN')) {
                $response = new RedirectResponse($this->router->generate('administracion_usuario'));
            } else if ($this->contexto->isGranted('ROLE_ADMIN')){
                $response = new RedirectResponse($this->router->generate('gestion_indice'));
            } else if ($this->contexto->isGranted('ROLE_USER')){
                $response = new RedirectResponse($this->router->generate('expediente_indice'));
            }else {
                $response = new RedirectResponse($this->router->generate('portada'));
            }
            
        $event->setResponse($response);
        $event->stopPropagation();
    }}

}

?>
