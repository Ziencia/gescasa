<?php

namespace Gestor\UsuarioBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormError;
use Gestor\MensajeBundle\Entity\Mensaje;

class DefaultController extends Controller {

    public function loginAction() {

        $peticion = $this->getRequest();
        $sesion = $peticion->getSession();
        $error = $peticion->attributes->get(
                SecurityContext::AUTHENTICATION_ERROR, $sesion->get(SecurityContext::AUTHENTICATION_ERROR)
        );
                
        return $this->render('UsuarioBundle:Default:login.html.twig', array(
                    'last_username' => $sesion->get(SecurityContext::LAST_USERNAME),
                    'error' => $error
        ));
    }

    
    public function indexAction() {
        return $this->redirect($this->generateUrl('usuario_login'), 301);
    }
    
    public function perfilAction(Request $peticion){
        
          $usuario = $this->getUser();
                  
          $formulario = $this->createFormBuilder()
                 ->add('old_password','password',array(
                    'max_length'=>'20',
                    'label'=>'Actual:',
                    'required' => true,
                    'data' => ''
                    ))
                ->add('new_password','repeated',array(
                    'type'=>'password',
                    'max_length' =>'20',
                    'invalid_message'=>'Las dos contraseñas deben coincidir',
                    'options'=>array('label'=>'Nueva:'),
                    'label'=>'Nueva:',
                    'required' => true,
                    'data'=>''
                    ))
                ->getForm();
          
          
          $formulario->handleRequest($peticion);
          
          if ($formulario->isValid()){
              $data = $formulario->getData();
              
              $old_pass = $data['old_password'];
              $new_pass = $data['new_password'];
              
              $encoder = $this->get('security.encoder_factory')->getEncoder($usuario);
              $salt = $usuario->getSalt();
              $pass = $usuario->getPassword();
              
              $old_pass_codificado = $encoder->encodePassword($old_pass, $salt);
              
              if ($old_pass_codificado!=$pass){                  
                  $formulario->get('old_password')->addError(new FormError('El password introducido no coincide con el actual'));
              }else if (strlen($new_pass)<6){
                  $formulario->get('new_password')->addError(new FormError('La longitud mínima del password debe de ser de 6 caracteres'));
              }else{
                  $em = $this->getDoctrine()->getManager();
                  
                  $new_pass_codificado = $encoder->encodePassword($new_pass,$salt);
                  $usuario->setPassword($new_pass_codificado);
                  
                  $em->persist($usuario);
                  $em->flush();
                
                $flash = 'Contraseña actualizada';
                $this->get('session')->getFlashBag()->add('info', $flash);
            
                $descripcion = 'INFO: Usuario cambio de contraseña';
                $mensaje = new Mensaje($this->getUser()->getId(),new \DateTime(),$descripcion);
                $em->getRepository('MensajeBundle:Mensaje')->altaMensaje($mensaje);
              }            
          }
          
        return $this->render('UsuarioBundle:Default:perfil.html.twig',array(
            'usuario' => $usuario,
            'formulario' => $formulario->createView()
        ));
    }

}
