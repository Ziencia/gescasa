<?php

namespace Gestor\GestionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Gestor\GestionBundle\Entity\infoTipoPolicial;
use Gestor\GestionBundle\Form\infoTipoOperativoType;
use Gestor\MensajeBundle\Entity\Mensaje;

/**
 * infoTipoOperativo controller.
 *
 */
class infoTipoOperativoController extends Controller
{

    /**
     * Lists all infoTipoOperativo entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('GestionBundle:infoTipoPolicial')->findBy(array(),array('descripcion'=>'ASC'));

        $descripcion = 'INFO: Gestion, consulta de  tipo de material operativo';
        $mensaje = new Mensaje($this->getUser()->getId(),new \DateTime(),$descripcion);
        $em->getRepository('MensajeBundle:Mensaje')->altaMensaje($mensaje);
        
        return $this->render('GestionBundle:infoTipoOperativo:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Displays a form to create a new infoTipoOperativo entity.
     *
     */
    public function newAction(Request $peticion){
        
        $entity = new infoTipoPolicial();
        
        $formulario = $this->createForm(new infoTipoOperativoType(),$entity);
        
        $formulario->handleRequest($peticion);
        
        if ($formulario->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $flash = 'El tipo de material ha sido dado de alta';
            $this->get('session')->getFlashBag()->add('info', $flash);
            
           $descripcion = 'INFO: Alta tipo de material operativo ID: ' .$entity->getId().', descripción: '. $entity->getDescripcion();
           $mensaje = new Mensaje($this->getUser()->getId(),new \DateTime(),$descripcion);
           $em->getRepository('MensajeBundle:Mensaje')->altaMensaje($mensaje);
           
           return $this->redirect($this->generateUrl(
                   'operativo_index'));                   
        }
        
        return $this->render('GestionBundle:infoTipoOperativo:new.html.twig',array(
            'formulario'    => $formulario->createView()
        ));
    }       
              
    /**
     * Displays a form to edit an existing infoTipoOperativo entity.
     *
     */
    public function editAction($id,Request $peticion)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('GestionBundle:infoTipoPolicial')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se ha encontrado el tipo de material.');
        }

        $formulario = $this->createForm(new infoTipoOperativoType(),$entity);
        
        $formulario->handleRequest($peticion);
        
        if ($formulario->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $flash = 'El tipo de material ha sido modificado';
            $this->get('session')->getFlashBag()->add('info', $flash);
            
           $descripcion = 'INFO: Modificación tipo de material operativo ID: ' .$entity->getId().', descripción: '. $entity->getDescripcion();
           $mensaje = new Mensaje($this->getUser()->getId(),new \DateTime(),$descripcion);
           $em->getRepository('MensajeBundle:Mensaje')->altaMensaje($mensaje);
           
           return $this->redirect($this->generateUrl(
                   'operativo_index'));                   
        }
        
        return $this->render('GestionBundle:infoTipoOperativo:edit.html.twig',array(
            'formulario'    => $formulario->createView(),
            'id'            => $id
        ));
    }

}
