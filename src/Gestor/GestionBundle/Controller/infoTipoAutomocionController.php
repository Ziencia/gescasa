<?php

namespace Gestor\GestionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Gestor\GestionBundle\Entity\infoTipoAutomocion;
use Gestor\GestionBundle\Form\infoTipoAutomocionType;
use Gestor\MensajeBundle\Entity\Mensaje;

/**
 * infoTipoAutomocion controller.
 *
 */
class infoTipoAutomocionController extends Controller
{

    /**
     * Lists all infoTipoAutomocion entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('GestionBundle:infoTipoAutomocion')->findBy(array(),array('descripcion'=>'ASC'));

        return $this->render('GestionBundle:infoTipoAutomocion:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Displays a form to create a new infoTipoAutomocion entity.
     *
     */
    public function newAction(Request $peticion){
        
        $entity = new infoTipoAutomocion();
        
        $formulario = $this->createForm(new infoTipoAutomocionType(),$entity);
        
        $formulario->handleRequest($peticion);
        
        if ($formulario->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $flash = 'El tipo de material ha sido dado de alta';
            $this->get('session')->getFlashBag()->add('info', $flash);
            
           $descripcion = 'INFO: Alta tipo de material automoción ID: ' .$entity->getId().', descripción: '. $entity->getDescripcion();
           $mensaje = new Mensaje($this->getUser()->getId(),new \DateTime(),$descripcion);
           $em->getRepository('MensajeBundle:Mensaje')->altaMensaje($mensaje);
           
           return $this->redirect($this->generateUrl(
                   'automocion_index'));                   
        }
        
        return $this->render('GestionBundle:infoTipoAutomocion:new.html.twig',array(
            'formulario'    => $formulario->createView()
        ));
    }       
              
    /**
     * Displays a form to edit an existing infoTipoAutomocion entity.
     *
     */
    public function editAction($id,Request $peticion)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('GestionBundle:infoTipoAutomocion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se ha encontrado el tipo de material de vestuario.');
        }

        $formulario = $this->createForm(new infoTipoAutomocionType(),$entity);
        
        $formulario->handleRequest($peticion);
        
        if ($formulario->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $flash = 'El tipo de material ha sido modificado';
            $this->get('session')->getFlashBag()->add('info', $flash);
            
           $descripcion = 'INFO: Modificación tipo de material automoción ID: ' .$entity->getId().', descripción: '. $entity->getDescripcion();
           $mensaje = new Mensaje($this->getUser()->getId(),new \DateTime(),$descripcion);
           $em->getRepository('MensajeBundle:Mensaje')->altaMensaje($mensaje);
           
           return $this->redirect($this->generateUrl(
                   'automocion_index'));                   
        }
        
        return $this->render('GestionBundle:infoTipoAutomocion:edit.html.twig',array(
            'formulario'    => $formulario->createView(),
            'id'            => $id
        ));
    }

}
