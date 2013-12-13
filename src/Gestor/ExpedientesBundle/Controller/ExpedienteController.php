<?php

namespace Gestor\ExpedientesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Request;
use Gestor\ExpedientesBundle\Entity\Expediente;
use Gestor\MensajeBundle\Entity\Mensaje;
use \Gestor\ExpedientesBundle\Form\ExpedienteType;
use Doctrine\ORM\EntityRepository;

class ExpedienteController extends Controller {

    public function indexAction() {
       
        $em = $this->getDoctrine()->getManager();
        
        $paginador = $this->get('ideup.simple_paginator');
        $paginador->setItemsPerPage(9);

        $entities  = $paginador->paginate(        
            $em->getRepository('ExpedientesBundle:Expediente')->queryTodosExpedientesDesc())->getResult();
        
        $exp_info='';
        
        return $this->render('ExpedientesBundle:Expediente:index.html.twig', array(
            'entities'  => $entities,
            'paginador' => $paginador,
            'expedientes_info' => $exp_info
        ));       
      
    }
    
    public function listarAction(){
        $em = $this->getDoctrine()->getManager();

        $entities  = $em->getRepository('ExpedientesBundle:Expediente')->findTodosExpedientesDesc();
               
        return $this->render('ExpedientesBundle:Expediente:listar.html.twig', array(
            'entities'  => $entities
        ));
    }
    
    public function nuevoAction(){
        $peticion = $this->getRequest();
        
        $entity = new Expediente();
        $entity->setFechaInicio(new \DateTime('today'));
        
        $formulario = $this->createForm(new ExpedienteType(), $entity);
        
        $formulario->handleRequest($peticion);

        if ($formulario->isValid()) {
         // $this->get('session')->getFlashBag()->add('info', 'Usuario dado de alta con fecha ' . $expediente->getTitulo() . ' ' . $expediente->getEstado() );
            //$entity->getFechaAlta()->format('d-m-yy')
          
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            
            return $this->redirect($this->generateUrl('expediente_indice'));
        }
        //$this->get('session')->getFlashBag()->add('info', 'Usuario dado de alta con fecha ' . $expediente->getTitulo() . ' ' . $expediente->getEstado() );
          
        return $this->render('ExpedientesBundle:Expediente:nuevo.html.twig',
                array('formulario' => $formulario->createView())
    );
    }
    
    public function verAction($id){
        
    }

    public function filtrarAction($estado){
        
        $em = $this->getDoctrine()->getManager();
        
        $paginador = $this->get('ideup.simple_paginator');
        $paginador->setItemsPerPage(9);

        $entities  = $paginador->paginate(        
            $em->getRepository('ExpedientesBundle:Expediente')->queryFiltrarExpedientesEstado($estado))->getResult();
        
        if ($paginador->getTotalItems()>0)
            $exp_info='<div class="expedientes_info">Se han encontrado '.$paginador->getTotalItems().' expedientes que cumplen los criterios de búsqueda</div>';
        else
            $exp_info='<div class="expedientes_info">No se han encontrado expedientes que cumplan los criterios de búsqueda</div>';
       
        return $this->render('ExpedientesBundle:Expediente:index.html.twig', array(
            'entities'  => $entities,
            'paginador' => $paginador,
            'expedientes_info' => $exp_info
        )); 
    }
    
    public function buscarBasicoAction(Request $request){
        
        $cadenaTitulo= $request->request->get('exp_tit');
        $paginador = $this->get('ideup.simple_paginator');
        $paginador->setItemsPerPage(9);
                    $em = $this->getDoctrine()->getManager();
        $exp_info='';
        
        if (!empty($cadenaTitulo)){
            $entities  = $paginador->paginate(        
                $em->getRepository('ExpedientesBundle:Expediente')->queryFiltrarExpedientesTitulo($cadenaTitulo))->getResult();
            
            if ($paginador->getTotalItems()>0)
                $exp_info='<div class="expedientes_info">Se han encontrado '.$paginador->getTotalItems().' expedientes que cumplen los criterios de búsqueda</div>';
            else
                $exp_info='<div class="expedientes_info">No se han encontrado expedientes que cumplan los criterios de búsqueda</div>';
        
            return $this->render('ExpedientesBundle:Expediente:index.html.twig', array(
                'entities'  => $entities,
                'paginador' => $paginador,
                'expedientes_info' => $exp_info
            )); 
        }else{

            $entities  = $paginador->paginate(        
                $em->getRepository('ExpedientesBundle:Expediente')->queryTodosExpedientesDesc())->getResult();
               
            return $this->render('ExpedientesBundle:Expediente:index.html.twig', array(
            'entities'  => $entities,
            'paginador' => $paginador,
            'expedientes_info' => $exp_info
        ));       
            
        }
    }
    
    public function buscarAvanzadoAction(){
        $peticion = $this->getRequest();
        
        $paginador = $this->get('ideup.simple_paginator');
        $paginador->setItemsPerPage(9);
                    $em = $this->getDoctrine()->getManager();
        
        $exp_info='';
        
        $formulario = $this->createFormBuilder()
                 ->add('titulo','text',array(
                    'max_length'=>'200',
                    'label'=>'Titulo:',
                     'required' => false
                    ))
                ->add('referencia','text',array(
                    'max_length'=>'45',
                    'label'=>'N. de expediente:'         ,
                    'required' => false
                    ))
                ->add('estado', 'entity', array(
                    'class'         => 'GestionBundle:infoTipoEstadoExpediente',
                    'empty_value'   => 'Seleccione el estado',
                    'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('e')
                            ->orderBy('e.descripcion', 'ASC');
                    },
                    'label'         => 'Estado:',
                            'required' => false
                    ))  
                 ->add('empresa', 'entity', array(
                    'class'         => 'GestionBundle:infoTipoEmpresa',
                    'empty_value'   => 'Seleccione la empresa',
                    'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('e')
                            ->orderBy('e.descripcion', 'ASC');
                    },
                    'label'         => 'Empresa:',
                            'required' => false
                    ))
                 ->add('adjudicatario', 'entity', array(
                    'class'         => 'GestionBundle:infoTipoAdjudicatario',
                    'empty_value'   => 'Seleccione el adjudicatario',
                    'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('a')
                            ->orderBy('a.descripcion', 'ASC');
                    },
                    'label'         => 'Adjudicatario:',
                            'required' => false
                    ))
                ->add('fechaInicioDe','date', array(
                    'widget' => 'single_text',
                    'label'=>'Desde:',
                    'required' => false
                    ))
                ->add('fechaInicioA','date', array(
                    'widget' => 'single_text',
                    'label'=>'Hasta:',
                    'required' => false
                    ))
                ->add('fechaFinDe','date', array(
                    'widget' => 'single_text',
                    'required'=>false,
                    'label'=>'Desde:',
                    'required' => false
                    ))
                ->add('fechaFinA','date', array(
                    'widget' => 'single_text',
                    'required'=>false,
                    'label'=>'Hasta:',
                    'required' => false
                    ))
                ->add('importeDe','text', array(
                    'required'=>false,
                    'label'=>'Desde:',
                    'required' => false
                    ))
                ->add('importeA','text', array(
                    'required'=>false,
                    'label'=>'Hasta:',
                    'required' => false,
                    ))   
            ->getForm();

        $formulario->handleRequest($peticion);
        
        if ($formulario->isValid()) {
        
            $data = $formulario->getData();
            /*
            $texto='Texto de prueba </br> Valores: </br>';
            foreach($data as $item => $value){
                if ($value instanceof \DateTime)
                    $texto.= $item. ": ".$value->format('Y-m-d').'</br>';
                else
                    $texto.= $item. ": ".$value.'</br>';
            }                                      
      
            $f= $data['fechaInicioDe']->format('Y-m-d');
            
            $texto .= " AND e.fechaInicio BETWEEN '$f'";
            $response='<h1>'.$texto.'</h1>';*/
            
            $entities  = $paginador->paginate(        
                $em->getRepository('ExpedientesBundle:Expediente')->queryFiltrarExpedientesAvanzado($data))->getResult();
             
           if ($paginador->getTotalItems()>0)
                $exp_info='<div class="expedientes_info">Se han encontrado '.$paginador->getTotalItems().' expedientes que cumplen los criterios de búsqueda</div>';
            else
                $exp_info='<div class="expedientes_info">No se han encontrado expedientes que cumplan los criterios de búsqueda</div>';   
            
            return $this->render('ExpedientesBundle:Expediente:index.html.twig', array(
                'entities'  => $entities,
                'paginador' => $paginador,
                'expedientes_info' => $exp_info
            ));
            //return new Response($response);
        }
    
        return $this->render('ExpedientesBundle:Expediente:buscar.html.twig',
                array('formulario'=>$formulario->createView())
        );
    }
}
