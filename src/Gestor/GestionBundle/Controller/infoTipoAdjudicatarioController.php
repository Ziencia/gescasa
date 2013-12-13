<?php

namespace Gestor\GestionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Gestor\GestionBundle\Entity\infoTipoAdjudicatario;
use Gestor\GestionBundle\Form\infoTipoAdjudicatarioType;
use Gestor\MensajeBundle\Entity\Mensaje;

/**
 * infoTipoAdjudicatario controller.
 *
 */
class infoTipoAdjudicatarioController extends Controller
{

    /**
     * Lists all infoTipoAdjudicatario entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('GestionBundle:infoTipoAdjudicatario')->findBy(array(),array('descripcion'=>'ASC'));

        return $this->render('GestionBundle:infoTipoAdjudicatario:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Displays a form to create a new infoTipoAdjudicatario entity.
     *
     */
    public function newAction(Request $peticion){
        
        $entity = new infoTipoAdjudicatario();
        
        $formulario = $this->createForm(new infoTipoAdjudicatarioType(),$entity);
        
        $formulario->handleRequest($peticion);
        
        if ($formulario->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $flash = 'El adjudicatario ha sido dado de alta';
            $this->get('session')->getFlashBag()->add('info', $flash);
            
           $descripcion = 'INFO: Alta de adjudicatario: ' .$entity->getId().', descripción: '. $entity->getDescripcion();
           $mensaje = new Mensaje($this->getUser()->getId(),new \DateTime(),$descripcion);
           $em->getRepository('MensajeBundle:Mensaje')->altaMensaje($mensaje);
           
           return $this->redirect($this->generateUrl(
                   'adjudicatario_index'));                   
        }
        
        return $this->render('GestionBundle:infoTipoAdjudicatario:new.html.twig',array(
            'formulario'    => $formulario->createView()
        ));
    }       
              
    /**
     * Displays a form to edit an existing infoTipoAdjudicatario entity.
     *
     */
    public function editAction($id,Request $peticion)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('GestionBundle:infoTipoAdjudicatario')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se ha encontrado el tipo de material de vestuario.');
        }

        $formulario = $this->createForm(new infoTipoAdjudicatarioType(),$entity);
        
        $formulario->handleRequest($peticion);
        
        if ($formulario->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $flash = 'El tipo de material ha sido modificado';
            $this->get('session')->getFlashBag()->add('info', $flash);
            
           $descripcion = 'INFO: Modificación de adjudicatario ID: ' .$entity->getId().', descripción: '. $entity->getDescripcion();
           $mensaje = new Mensaje($this->getUser()->getId(),new \DateTime(),$descripcion);
           $em->getRepository('MensajeBundle:Mensaje')->altaMensaje($mensaje);
           
           return $this->redirect($this->generateUrl(
                   'adjudicatario_index'));                   
        }
        
        return $this->render('GestionBundle:infoTipoAdjudicatario:edit.html.twig',array(
            'formulario'    => $formulario->createView(),
            'id'            => $id
        ));
    }

}
