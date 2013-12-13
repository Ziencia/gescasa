<?php

namespace Gestor\MaterialBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Gestor\MaterialBundle\Form\InformaticoType;
use Gestor\MensajeBundle\Entity\Mensaje;

class MaterialController extends Controller
{
    public function indexAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        
        $expediente = $em->getRepository('ExpedientesBundle:Expediente')->findOneBy(array(
            'id' => $id
        ));
        
        $informatica = $em->getRepository('MaterialBundle:MaterialInformatico')->findBy(array(
            'fkExpediente' => $expediente
        ));
        
        $policial = $em->getRepository('MaterialBundle:MaterialPolicial')->findBy(array(
            'fkExpediente' => $expediente
        ));
        
        $mobiliario = $em->getRepository('MaterialBundle:MaterialMobiliario')->findBy(array(
            'fkExpediente' => $expediente
        ));
        
        $automocion = $em->getRepository('MaterialBundle:MaterialAutomocion')->findBy(array(
            'fkExpediente' => $expediente
        ));
         
        $vestuario = $em->getRepository('MaterialBundle:MaterialVestuario')->findBy(array(
            'fkExpediente' => $expediente
        ));
                
        return $this->render('MaterialBundle:Material:index.html.twig',array(
            'expediente_ref' => $expediente->getReferencia(),
            'expediente_id'  => $id,
            'informatica'    => $informatica,
            'policial'       => $policial,
            'mobiliario'     => $mobiliario,
            'automocion'     => $automocion,
            'vestuario'      => $vestuario
        ));
    }
    
    public function AutomocionAction($id){
        

    }
    

    
    public function MobiliarioAction($id){

    }
    
    public function VestuarioAction($id){

    }    
    
    
    public function InformaticoAction($id){
        
        $peticion = $this->getRequest();
        
        $em = $this->getDoctrine()->getManager();
        
        $expediente = $em->getRepository('ExpedientesBundle:Expediente')->findOneBy(array(
            'id' => $id
        ));
        
        $formulario = $this->createForm(new InformaticoType());
        
        $formulario->handleRequest($peticion);
        
        if ($formulario->isValid()) {
           $data = $formulario->getData();
            
           $material = $em->getRepository('MaterialBundle:MaterialInformatico')->altaMaterialInformatico($data,$expediente);

            $flash = 'El material ha sido dado de alta';
            $this->get('session')->getFlashBag()->add('info', $flash);
            
           $descripcion = 'INFO: Alta material informático. ID: ' .$material->getId() . ' Expediente ' . $expediente->getReferencia() ;
           $mensaje = new Mensaje($this->getUser()->getId(),new \DateTime(),$descripcion);
           $em->getRepository('MensajeBundle:Mensaje')->altaMensaje($mensaje);
           
           return $this->indexAction($id);
        }
        
        return $this->render('MaterialBundle:Material:Informatico/informatico.html.twig',array(
            'expediente_ref' => $expediente->getReferencia(),
            'expediente_id'  => $id,
            'formulario'    => $formulario->createView()
        ));
    }
    
    public function informaticoVerAction($id){
        
        $em = $this->getDoctrine()->getManager();
        
        $material = $em->getRepository('MaterialBundle:MaterialInformatico')->find($id);
        
        if (!$material) {
            throw $this->createNotFoundException('No existe este material');
        }
        
        $expediente = $material->getfkExpediente();
                
        $deleteForm = $this->createDeleteForm($id);

        $descripcion = 'INFO: Consulta material informático. ID: ' .$material->getId() . ' Expediente ' . $expediente->getReferencia() ;
        $mensaje = new Mensaje($this->getUser()->getId(),new \DateTime(),$descripcion);
        $em->getRepository('MensajeBundle:Mensaje')->altaMensaje($mensaje);
           
        return $this->render('MaterialBundle:Material:Informatico/ver.html.twig', array(
                    'material' => $material,
                    'expediente' => $expediente,
                    'delete_form_eliminar' => $deleteForm->createView()
        ));
        
    }
    
    public function informaticoEditarAction($id){
        $em = $this->getDoctrine()->getManager();

        $material = $em->getRepository('MaterialBundle:MaterialInformatico')->find($id);

        if (!$material) {
            throw $this->createNotFoundException('No se ha encontrado el material solicitado');
        }

        $expediente = $material->getfkExpediente();
        $formulario   = $this->createForm(new InformaticoType(), $material);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $formulario->handleRequest($request);

        if ($formulario->isValid()) {
            
            $em->persist($material);

            $flash = 'El material ha sido actualizado';
            $this->get('session')->getFlashBag()->add('info', $flash);
            
            $descripcion = 'INFO: Modicación material informático. ID: ' .$material->getId() . ' Expediente ' . $expediente->getReferencia() ;
            $mensaje = new Mensaje($this->getUser()->getId(),new \DateTime(),$descripcion);
            $em->getRepository('MensajeBundle:Mensaje')->altaMensaje($mensaje);
        
            $em->flush();
                        
            return $this->redirect($this->generateUrl('material_indice', array(
                'id' => $expediente->getId()
            )));
        }

        return $this->render('MaterialBundle:Material:Informatico/modificar.html.twig', array(
            'material'      => $material,
            'expediente'    => $expediente,
            'formulario'   => $formulario->createView(),
            'delete_form_eliminar' => $deleteForm->createView(),
        ));        
    }
    
    public function informaticoBorrarAction($id){
        
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();
        
        $form->handleRequest($request);       

        if ($form->isValid()) {
            
            $em = $this->getDoctrine()->getManager();
            $material = $em->getRepository('MaterialBundle:MaterialInformatico')->find($id);

            if (!$material) {
                throw $this->createNotFoundException('No se ha encontrado el material solicitado');
            }

            $expediente = $material->getfkExpediente();
                        
            $this->get('session')->getFlashBag()->add('info', 'Material informático con ID:'. $material->getId() . ', dado de baja del expediente ' . $expediente->getReferencia());
                    
            $em->remove($material);
               
            $descripcion = 'INFO: Borrado material informático. ID: ' .$material->getId() . ' Expediente ' . $expediente->getReferencia() ;
            $mensaje = new Mensaje($this->getUser()->getId(),new \DateTime(),$descripcion);
            $em->getRepository('MensajeBundle:Mensaje')->altaMensaje($mensaje);
            
            $em->flush();
        }

        return $this->redirect($this->generateUrl('material_indice',array(
            'id' => $expediente->getId()
        )));
    }
    
    private function createDeleteForm($id){
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}