<?php
 
namespace Gestor\UsuarioBundle\Listener;
 
use Symfony\Component\Security\Http\Logout\LogoutSuccessHandlerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\Security\Core\SecurityContext;
use Gestor\MensajeBundle\Entity\Mensaje;
use Doctrine\Bundle\DoctrineBundle\Registry as Doctrine;

class LogoutSuccessHandler implements LogoutSuccessHandlerInterface
{
    
    private $router,$contexto,$em=null;
    
    public function __construct(SecurityContext $context, Router $router,Doctrine $doctrine)
    {
        $this->router = $router;
        $this->contexto = $context;
        $this->em = $doctrine;
    }
    
    public function onLogoutSuccess(Request $request)
    {
        $usuario = $this->contexto->getToken()->getUser();
        
        $descripcion = "INFO: FIN SESION";
        $mensaje = new Mensaje($usuario->getID(),new \DateTime(),$descripcion);
      
        $em = $this->em->getManager();
        $em->persist($mensaje);        
        $em->flush();
      
        $response = new RedirectResponse($this->router->generate('portada'));
        return $response;
    }
    
}
