<?php

namespace Gestor\AdministracionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Gestor\UsuarioBundle\Entity\Usuario;
use \Gestor\AdministracionBundle\Form\UsuarioType;

class DefaultController extends Controller {

    public function indexAction() {
        return $this->render('::administracion.html.twig');
    }

    public function registroAction() {
        $peticion = $this->getRequest();

        $usuario = new Usuario();
        
        $usuario->setFechaAlta(new \DateTime('today'));
        $usuario->setSalt(md5(time()));
        
        $formulario = $this->createForm(new UsuarioType(), $usuario);

        $formulario->handleRequest($peticion);

        if ($formulario->isValid()) {
            $encoder = $this->get('security.encoder_factory')
                    ->getEncoder($usuario);
            $usuario->setSalt(md5(time()));
            $passwordCodificado = $encoder->encodePassword(
                    $usuario->getPassword(), $usuario->getSalt()
            );
            $usuario->setPassword($passwordCodificado);
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($usuario);
            $em->flush();
            
            $this->get('session')->getFlashBag()->add('info', 'Usuario dado de alta con fecha '.$usuario->getFechaAlta()->format('dd-MM-yy'));
            
            return $this->redirect($this->generateUrl('portada'));
        }

        return $this->render(
                        'AdministracionBundle:Default:registro.html.twig', array('formulario' => $formulario->createView()));
    }

}
