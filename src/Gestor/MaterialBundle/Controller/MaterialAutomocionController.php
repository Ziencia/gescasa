<?php

namespace Gestor\MaterialBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Gestor\MaterialBundle\Form\AutomocionType;
use Gestor\MensajeBundle\Entity\Mensaje;

class MaterialAutomocionController extends Controller
{
    public function automocionAction($id){
        
        $peticion = $this->getRequest();
        
        $em = $this->getDoctrine()->getManager();
        
        $expediente = $em->getRepository('ExpedientesBundle:Expediente')->findOneBy(array(
            'id' => $id
        ));
        
        $formulario = $this->createForm(new AutomocionType());
        
        $formulario->handleRequest($peticion);
        
        if ($formulario->isValid()) {
           $data = $formulario->getData();
            
           $material = $em->getRepository('MaterialBundle:MaterialAutomocion')->altaMaterialAutomocion($data,$expediente);

            $flash = 'El material ha sido dado de alta';
            $this->get('session')->getFlashBag()->add('info', $flash);
            
           $descripcion = 'INFO: Alta material automocion. ID: ' .$material->getId() . ' Expediente ' . $expediente->getReferencia() ;
           $mensaje = new Mensaje($this->getUser()->getId(),new \DateTime(),$descripcion);
           $em->getRepository('MensajeBundle:Mensaje')->altaMensaje($mensaje);
           
           return $this->redirect($this->generateUrl(
                   'material_indice',
                   array('id'=>$id)));                   
        }
        
        return $this->render('MaterialBundle:Material:Automocion/automocion.html.twig',array(
            'expediente_ref' => $expediente->getReferencia(),
            'expediente_id'  => $id,
            'formulario'    => $formulario->createView()
        ));
    }
    
    public function automocionVerAction($id){
        
        $em = $this->getDoctrine()->getManager();
        
        $material = $em->getRepository('MaterialBundle:MaterialAutomocion')->find($id);
        
        if (!$material) {
            throw $this->createNotFoundException('No existe este material');
        }
        
        $expediente = $material->getfkExpediente();
                
        $deleteForm = $this->createDeleteForm($id);

        $descripcion = 'INFO: Consulta material automoción. ID: ' .$material->getId() . ' Expediente ' . $expediente->getReferencia() ;
        $mensaje = new Mensaje($this->getUser()->getId(),new \DateTime(),$descripcion);
        $em->getRepository('MensajeBundle:Mensaje')->altaMensaje($mensaje);
           
        return $this->render('MaterialBundle:Material:Automocion/ver.html.twig', array(
                    'material' => $material,
                    'expediente' => $expediente,
                    'delete_form_eliminar' => $deleteForm->createView()
        ));
        
    }
    
    public function automocionEditarAction($id){
        $em = $this->getDoctrine()->getManager();

        $material = $em->getRepository('MaterialBundle:MaterialAutomocion')->find($id);

        if (!$material) {
            throw $this->createNotFoundException('No se ha encontrado el material solicitado');
        }

        $expediente = $material->getfkExpediente();
        $formulario   = $this->createForm(new AutomocionType(), $material);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $formulario->handleRequest($request);

        if ($formulario->isValid()) {
            
            $em->persist($material);

            $flash = 'El material ha sido actualizado';
            $this->get('session')->getFlashBag()->add('info', $flash);
            
            $descripcion = 'INFO: Modicación material automoción. ID: ' .$material->getId() . ' Expediente ' . $expediente->getReferencia() ;
            $mensaje = new Mensaje($this->getUser()->getId(),new \DateTime(),$descripcion);
            $em->getRepository('MensajeBundle:Mensaje')->altaMensaje($mensaje);
        
            $em->flush();
                        
            return $this->redirect($this->generateUrl('material_indice', array(
                'id' => $expediente->getId()
            )));
        }

        return $this->render('MaterialBundle:Material:Automocion/modificar.html.twig', array(
            'material'      => $material,
            'expediente'    => $expediente,
            'formulario'   => $formulario->createView(),
            'delete_form_eliminar' => $deleteForm->createView(),
        ));        
    }
    
    public function automocionBorrarAction($id){
        
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();
        
        $form->handleRequest($request);       

        if ($form->isValid()) {
            
            $em = $this->getDoctrine()->getManager();
            $material = $em->getRepository('MaterialBundle:MaterialAutomocion')->find($id);

            if (!$material) {
                throw $this->createNotFoundException('No se ha encontrado el material solicitado');
            }

            $expediente = $material->getfkExpediente();
                        
            $this->get('session')->getFlashBag()->add('info', 'Material automoción con ID:'. $material->getId() . ', dado de baja del expediente ' . $expediente->getReferencia());
                    
            $em->remove($material);
               
            $descripcion = 'INFO: Borrado material automoción. ID: ' .$material->getId() . ' Expediente ' . $expediente->getReferencia() ;
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

