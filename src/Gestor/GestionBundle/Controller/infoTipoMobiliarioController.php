<?php

namespace Gestor\GestionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Gestor\GestionBundle\Entity\infoTipoMobiliario;
use Gestor\GestionBundle\Form\infoTipoMobiliarioType;
use Gestor\MensajeBundle\Entity\Mensaje;

/**
 * infoTipoMobiliario controller.
 *
 */
class infoTipoMobiliarioController extends Controller
{

    /**
     * Lists all infoTipoMobiliario entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('GestionBundle:infoTipoMobiliario')->findBy(array(),array('descripcion'=>'ASC'));

        $descripcion = 'INFO: Gestion, consulta de  tipo de material mobiliario';
        $mensaje = new Mensaje($this->getUser()->getId(),new \DateTime(),$descripcion);
        $em->getRepository('MensajeBundle:Mensaje')->altaMensaje($mensaje);
        
        return $this->render('GestionBundle:infoTipoMobiliario:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Displays a form to create a new infoTipoMobiliario entity.
     *
     */
    public function newAction(Request $peticion){
        
        $entity = new infoTipoMobiliario();
        
        $formulario = $this->createForm(new infoTipoMobiliarioType(),$entity);
        
        $formulario->handleRequest($peticion);
        
        if ($formulario->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $flash = 'El tipo de material ha sido dado de alta';
            $this->get('session')->getFlashBag()->add('info', $flash);
            
           $descripcion = 'INFO: Alta tipo de material mobiliario ID: ' .$entity->getId().', descripción: '. $entity->getDescripcion();
           $mensaje = new Mensaje($this->getUser()->getId(),new \DateTime(),$descripcion);
           $em->getRepository('MensajeBundle:Mensaje')->altaMensaje($mensaje);
           
           return $this->redirect($this->generateUrl(
                   'mobiliario_index'));                   
        }
        
        return $this->render('GestionBundle:infoTipoMobiliario:new.html.twig',array(
            'formulario'    => $formulario->createView()
        ));
    }       
              
    /**
     * Displays a form to edit an existing infoTipoMobiliario entity.
     *
     */
    public function editAction($id,Request $peticion)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('GestionBundle:infoTipoMobiliario')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se ha encontrado el tipo de material.');
        }

        $formulario = $this->createForm(new infoTipoMobiliarioType(),$entity);
        
        $formulario->handleRequest($peticion);
        
        if ($formulario->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $flash = 'El tipo de material ha sido modificado';
            $this->get('session')->getFlashBag()->add('info', $flash);
            
           $descripcion = 'INFO: Modificación tipo de material mobiliario ID: ' .$entity->getId().', descripción: '. $entity->getDescripcion();
           $mensaje = new Mensaje($this->getUser()->getId(),new \DateTime(),$descripcion);
           $em->getRepository('MensajeBundle:Mensaje')->altaMensaje($mensaje);
           
           return $this->redirect($this->generateUrl(
                   'mobiliario_index'));                   
        }
        
        return $this->render('GestionBundle:infoTipoMobiliario:edit.html.twig',array(
            'formulario'    => $formulario->createView(),
            'id'            => $id
        ));
    }

}
