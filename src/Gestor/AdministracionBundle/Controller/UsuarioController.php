<?php

namespace Gestor\AdministracionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Gestor\UsuarioBundle\Entity\Usuario;
use \Gestor\AdministracionBundle\Form\UsuarioType;
use \Gestor\AdministracionBundle\Form\UsuarioAdministracionType;
use Gestor\MensajeBundle\Entity\Mensaje;

class UsuarioController extends Controller {

    public function indexAction() {

        $em = $this->getDoctrine()->getManager();
        
        $paginador = $this->get('ideup.simple_paginator');
        $paginador->setItemsPerPage(10);

        $entities  = $paginador->paginate(
            $em->getRepository('UsuarioBundle:Usuario')->queryTodosUsuarios())->getResult();
               
        $descripcion = 'INFO: Administracion indice';
        $mensaje = new Mensaje($this->getUser()->getId(),new \DateTime(),$descripcion);
        $em->getRepository('MensajeBundle:Mensaje')->altaMensaje($mensaje);
        
        $em->flush();
        
        return $this->render('AdministracionBundle:Usuario:index.html.twig', array(
            'entities'  => $entities,
            'paginador' => $paginador,
            'ruta_paginador' => 'administracion_indice'
        ));
    }

    public function registroAction() {
        $peticion = $this->getRequest();

        $entity = new Usuario();

        $entity->setFechaAlta(new \DateTime('today'));
        $entity->setSalt(md5(time()));
        $entity->setRoles('ROL_INICIO');

        $formulario = $this->createForm(new UsuarioType(), $entity);
            
        $formulario->handleRequest($peticion);
        
        if ($formulario->isValid()) {
            $encoder = $this->get('security.encoder_factory')
                    ->getEncoder($entity);
            $entity->setSalt(md5(time()));
            $passwordCodificado = $encoder->encodePassword(
                    $entity->getPassword(), $entity->getSalt()
            );
            $entity->setPassword($passwordCodificado);
            $entity->setRoles($formulario['rol']->getData());
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            
            $descripcion = 'INFO: Administracion, nuevo usuario ' . $entity->getTip();
            $mensaje = new Mensaje($this->getUser()->getId(),new \DateTime(),$descripcion);
            $em->getRepository('MensajeBundle:Mensaje')->altaMensaje($mensaje);
        
            $em->flush();
        
            $this->get('session')->getFlashBag()->add('info', 'Usuario dado de alta con fecha ' . $entity->getFechaAlta()->format('d-m-yy'));
            
            return $this->redirect($this->generateUrl('administracion_usuario'));
        }

        return $this->render(
                        'AdministracionBundle:Usuario:registro.html.twig', array('formulario' => $formulario->createView()));
    }

    public function verAction($id) {

        $em = $this->getDoctrine()->getManager();
        $usuario = $em->getRepository('UsuarioBundle:Usuario')->find($id);

        if (!$usuario) {
            throw $this->createNotFoundException('No existe este usuario');
        }
       
        $deleteForm = $this->createDeleteForm($id);

                    $descripcion = 'INFO: Administracion, consulta usuario ' . $usuario->getTip();
            $mensaje = new Mensaje($this->getUser()->getId(),new \DateTime(),$descripcion);
            $em->getRepository('MensajeBundle:Mensaje')->altaMensaje($mensaje);
            
        return $this->render('AdministracionBundle:Usuario:ver.html.twig', array(
                    'entity' => $usuario,
                    'delete_form' => $deleteForm->createView(),
                    'delete_form_eliminar' => $deleteForm->createView()
        ));
    }

    public function editarAction($id) {       

        $em = $this->getDoctrine()->getManager();        
        $entity = $em->getRepository('UsuarioBundle:Usuario')->find($id);
        
        if (!$entity) {
            throw $this->createNotFoundException('No existe este usuario');
        }
        
        $formulario = $this->createForm(new UsuarioAdministracionType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        // PHP 5.4 $formulario->get('rol')->setData($entity->getRoles()[0]);
        
        $tmp = $entity->getRoles();
        $formulario->get('rol')->setData($tmp[0]);
        
        return $this->render('AdministracionBundle:Usuario:modificar.html.twig', array(
            'entity'      => $entity,
            'formulario'   => $formulario->createView(),
            'delete_form' => $deleteForm->createView()
        ));
    }
       
    public function actualizarAction($id){
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UsuarioBundle:Usuario')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se ha encontrado el usuario solicitado');
        }

        $old_password = $entity->getPassword();
        $old_salt = $entity->getSalt();
        
        $formulario   = $this->createForm(new UsuarioAdministracionType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $formulario->handleRequest($request);

        if ($formulario->isValid()) {
            
            if ($old_password!=$entity->getPassword() || $old_salt!=$entity->getSalt()){
                $encoder = $this->get('security.encoder_factory')
                    ->getEncoder($entity);
            
                $entity->setSalt(md5(time()));
                $passwordCodificado = $encoder->encodePassword(
                    $entity->getPassword(), $entity->getSalt()
                );
                $entity->setPassword($passwordCodificado);
            }
            else{
                $entity->setPassword($old_password);
                $entity->setSalt($old_salt);
            }
            
            $entity->setRoles($formulario['rol']->getData());
            
            $em->persist($entity);
            
                        $descripcion = 'INFO: Administracion, modificacion usuario ' . $entity->getTip();
            $mensaje = new Mensaje($this->getUser()->getId(),new \DateTime(),$descripcion);
            $em->getRepository('MensajeBundle:Mensaje')->altaMensaje($mensaje);
            
            $em->flush();

            $flash = 'El usuario ha sido actualizado';
            $this->get('session')->getFlashBag()->add('info', $flash);
            
            return $this->redirect($this->generateUrl('administracion_usuario_editar', array('id' => $id)));
        }

        return $this->render('AdministracionBundle:Usuario:modificar.html.twig', array(
            'entity'      => $entity,
            'formulario'   => $formulario->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    
    public function borrarAction($id) {
        
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();
        
        $form->handleRequest($request);       

        if ($form->isValid()) {
            
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('UsuarioBundle:Usuario')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('No se ha encontrado el usuario solicitado');
            }

            $this->get('session')->getFlashBag()->add('info', 'Usuario '. $entity->getTIP() . ' dado de baja con fecha ' . $entity->getFechaAlta()->format('d-m-yy'));
                    
                        $descripcion = 'INFO: Administracion, baja usuario ' . $entity->getTip();
            $mensaje = new Mensaje($this->getUser()->getId(),new \DateTime(),$descripcion);
            $em->getRepository('MensajeBundle:Mensaje')->altaMensaje($mensaje);
            
            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('administracion_usuario'));
    }
    
    public function habilitarAction($id){
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();
        
        $form->handleRequest($request);       

        if ($form->isValid()) {
            
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('UsuarioBundle:Usuario')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('No se ha encontrado el usuario solicitado');
            }        
            
            $entity->setAutorizado(true);
 
            $em->persist($entity);
            
                                    $descripcion = 'INFO: Administracion, usuario habilitado ' . $entity->getTip();
            $mensaje = new Mensaje($this->getUser()->getId(),new \DateTime(),$descripcion);
            $em->getRepository('MensajeBundle:Mensaje')->altaMensaje($mensaje);
            
            $em->flush();
        }
        
        $flash = 'El usuario ha sido habilitado';
        $this->get('session')->getFlashBag()->add('info', $flash);
        
        return $this->redirect($this->generateUrl('administracion_usuario_ver', array('id' => $id)));
    }
    
   public function deshabilitarAction($id){
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();
        
        $form->handleRequest($request);       

        if ($form->isValid()) {
            
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('UsuarioBundle:Usuario')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('No se ha encontrado el usuario solicitado');
            }      
            
            $entity->setAutorizado(false);

            $em->persist($entity);
            
                                    $descripcion = 'INFO: Administracion, usuario deshabilitado ' . $entity->getTip();
            $mensaje = new Mensaje($this->getUser()->getId(),new \DateTime(),$descripcion);
            $em->getRepository('MensajeBundle:Mensaje')->altaMensaje($mensaje);
            
            $em->flush();
        }
        
        $flash = 'El usuario ha sido deshabilitado';
        $this->get('session')->getFlashBag()->add('info', $flash);
        
        return $this->redirect($this->generateUrl('administracion_usuario_ver', array('id' => $id)));
    }
    
    private function createDeleteForm($id){
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }

    public function listarAutorizadosAction(){
        
        $em = $this->getDoctrine()->getManager();
        
        $paginador = $this->get('ideup.simple_paginator');
        $paginador->setItemsPerPage(10);

        $entities  = $paginador->paginate(
            $em->getRepository('UsuarioBundle:Usuario')->queryUsuariosAutorizados())->getResult();
        
                                $descripcion = 'INFO: Administracion, listar autorizado';
            $mensaje = new Mensaje($this->getUser()->getId(),new \DateTime(),$descripcion);
            $em->getRepository('MensajeBundle:Mensaje')->altaMensaje($mensaje);
            
            $em->flush();

        return $this->render('AdministracionBundle:Usuario:index.html.twig', array(
            'entities'  => $entities,
            'paginador' => $paginador,
            'ruta_paginador' => 'administracion_usuario_autorizados'
        ));
    }
    
}