<?php

namespace Gestor\GestionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Gestor\GestionBundle\Entity\infoTipoEmpresa;
use Gestor\GestionBundle\Form\infoTipoEmpresaType;
use Gestor\MensajeBundle\Entity\Mensaje;

/**
 * infoTipoEmpresa controller.
 *
 */
class infoTipoEmpresaController extends Controller
{

    /**
     * Lists all infoTipoEmpresa entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('GestionBundle:infoTipoEmpresa')->findBy(array(),array('descripcion'=>'ASC'));

        return $this->render('GestionBundle:infoTipoEmpresa:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Displays a form to create a new infoTipoEmpresa entity.
     *
     */
    public function newAction(Request $peticion){
        
        $entity = new infoTipoEmpresa();
        
        $formulario = $this->createForm(new infoTipoEmpresaType(),$entity);
        
        $formulario->handleRequest($peticion);
        
        if ($formulario->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $flash = 'La empresa ha sido dado de alta';
            $this->get('session')->getFlashBag()->add('info', $flash);
            
           $descripcion = 'INFO: Alta empresa ID: ' .$entity->getId().', descripción: '. $entity->getDescripcion();
           $mensaje = new Mensaje($this->getUser()->getId(),new \DateTime(),$descripcion);
           $em->getRepository('MensajeBundle:Mensaje')->altaMensaje($mensaje);
           
           return $this->redirect($this->generateUrl(
                   'empresa_index'));                   
        }
        
        return $this->render('GestionBundle:infoTipoEmpresa:new.html.twig',array(
            'formulario'    => $formulario->createView()
        ));
    }       
              
    /**
     * Displays a form to edit an existing infoTipoEmpresa entity.
     *
     */
    public function editAction($id,Request $peticion)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('GestionBundle:infoTipoEmpresa')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se ha encontrado el tipo de material de vestuario.');
        }

        $formulario = $this->createForm(new infoTipoEmpresaType(),$entity);
        
        $formulario->handleRequest($peticion);
        
        if ($formulario->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $flash = 'El tipo de empresa ha sido modificado';
            $this->get('session')->getFlashBag()->add('info', $flash);
            
           $descripcion = 'INFO: Modificación tipo de empresa vestuario ID: ' .$entity->getId().', descripción: '. $entity->getDescripcion();
           $mensaje = new Mensaje($this->getUser()->getId(),new \DateTime(),$descripcion);
           $em->getRepository('MensajeBundle:Mensaje')->altaMensaje($mensaje);
           
           return $this->redirect($this->generateUrl(
                   'empresa_index'));                   
        }
        
        return $this->render('GestionBundle:infoTipoEmpresa:edit.html.twig',array(
            'formulario'    => $formulario->createView(),
            'id'            => $id
        ));
    }

}
