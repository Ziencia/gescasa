<?php

namespace Gestor\MaterialBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Gestor\MaterialBundle\Form\VestuarioType;
use Gestor\MensajeBundle\Entity\Mensaje;

class MaterialVestuarioController extends Controller
{
    public function vestuarioAction($id){
        
        $peticion = $this->getRequest();
        
        $em = $this->getDoctrine()->getManager();
        
        $expediente = $em->getRepository('ExpedientesBundle:Expediente')->findOneBy(array(
            'id' => $id
        ));
        
        $formulario = $this->createForm(new VestuarioType());
        
        $formulario->handleRequest($peticion);
        
        if ($formulario->isValid()) {
           $data = $formulario->getData();
            
           $material = $em->getRepository('MaterialBundle:MaterialVestuario')->altaMaterialVestuario($data,$expediente);

            $flash = 'El material ha sido dado de alta';
            $this->get('session')->getFlashBag()->add('info', $flash);
            
           $descripcion = 'INFO: Alta material vestuario. ID: ' .$material->getId() . ' Expediente ' . $expediente->getReferencia() ;
           $mensaje = new Mensaje($this->getUser()->getId(),new \DateTime(),$descripcion);
           $em->getRepository('MensajeBundle:Mensaje')->altaMensaje($mensaje);
           
           return $this->redirect($this->generateUrl(
                   'material_indice',
                   array('id'=>$id)));                   
        }
        
        return $this->render('MaterialBundle:Material:Vestuario/vestuario.html.twig',array(
            'expediente_ref' => $expediente->getReferencia(),
            'expediente_id'  => $id,
            'formulario'    => $formulario->createView()
        ));
    }
    
    public function vestuarioVerAction($id){
        
        $em = $this->getDoctrine()->getManager();
        
        $material = $em->getRepository('MaterialBundle:MaterialVestuario')->find($id);
        
        if (!$material) {
            throw $this->createNotFoundException('No existe este material');
        }
        
        $expediente = $material->getfkExpediente();
                
        $deleteForm = $this->createDeleteForm($id);

        $descripcion = 'INFO: Consulta material vestuario. ID: ' .$material->getId() . ' Expediente ' . $expediente->getReferencia() ;
        $mensaje = new Mensaje($this->getUser()->getId(),new \DateTime(),$descripcion);
        $em->getRepository('MensajeBundle:Mensaje')->altaMensaje($mensaje);
           
        return $this->render('MaterialBundle:Material:Vestuario/ver.html.twig', array(
                    'material' => $material,
                    'expediente' => $expediente,
                    'delete_form_eliminar' => $deleteForm->createView()
        ));
        
    }
    
    public function vestuarioEditarAction($id){
        $em = $this->getDoctrine()->getManager();

        $material = $em->getRepository('MaterialBundle:MaterialVestuario')->find($id);

        if (!$material) {
            throw $this->createNotFoundException('No se ha encontrado el material solicitado');
        }

        $expediente = $material->getfkExpediente();
        $formulario   = $this->createForm(new VestuarioType(), $material);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $formulario->handleRequest($request);

        if ($formulario->isValid()) {
            
            $em->persist($material);

            $flash = 'El material ha sido actualizado';
            $this->get('session')->getFlashBag()->add('info', $flash);
            
            $descripcion = 'INFO: Modicación material vestuario. ID: ' .$material->getId() . ' Expediente ' . $expediente->getReferencia() ;
            $mensaje = new Mensaje($this->getUser()->getId(),new \DateTime(),$descripcion);
            $em->getRepository('MensajeBundle:Mensaje')->altaMensaje($mensaje);
        
            $em->flush();
                        
            return $this->redirect($this->generateUrl('material_indice', array(
                'id' => $expediente->getId()
            )));
        }

        return $this->render('MaterialBundle:Material:Vestuario/modificar.html.twig', array(
            'material'      => $material,
            'expediente'    => $expediente,
            'formulario'   => $formulario->createView(),
            'delete_form_eliminar' => $deleteForm->createView(),
        ));        
    }
    
    public function vestuarioBorrarAction($id){
        
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();
        
        $form->handleRequest($request);       

        if ($form->isValid()) {
            
            $em = $this->getDoctrine()->getManager();
            $material = $em->getRepository('MaterialBundle:MaterialVestuario')->find($id);

            if (!$material) {
                throw $this->createNotFoundException('No se ha encontrado el material solicitado');
            }

            $expediente = $material->getfkExpediente();
                        
            $this->get('session')->getFlashBag()->add('info', 'Material vestuario con ID:'. $material->getId() . ', dado de baja del expediente ' . $expediente->getReferencia());
                    
            $em->remove($material);
               
            $descripcion = 'INFO: Borrado material vestuario. ID: ' .$material->getId() . ' Expediente ' . $expediente->getReferencia() ;
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

