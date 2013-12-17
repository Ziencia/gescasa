<?php

namespace Gestor\ExpedientesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class ExpedienteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder                
                ->add('titulo','text',array(
                    'max_length'=>'200',
                    'label'=>'Titulo:'
                    ))
                ->add('referencia','text',array(
                    'max_length'=>'45',
                    'label'=>'N. de expediente:'                    
                    ))
                ->add('estado', 'entity', array(
                    'class'         => 'GestionBundle:infoTipoEstadoExpediente',
                    'empty_value'   => 'Seleccione el estado',
                    'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('e')
                            ->orderBy('e.descripcion', 'ASC');
                    },
                    'label'         => 'Estado:'
                    ))  
                 ->add('empresa', 'entity', array(
                    'class'         => 'GestionBundle:infoTipoEmpresa',
                    'empty_value'   => 'Seleccione la empresa',
                    'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('e')
                            ->orderBy('e.descripcion', 'ASC');
                    },
                    'label'         => 'Empresa:'
                    ))
                 ->add('adjudicatario', 'entity', array(
                    'class'         => 'GestionBundle:infoTipoAdjudicatario',
                    'empty_value'   => 'Seleccione el adjudicatario',
                    'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('a')
                            ->orderBy('a.descripcion', 'ASC');
                    },
                    'label'         => 'Adjudicatario:'
                    ))
                ->add('fechaInicio','date', array(
                    'widget' => 'single_text',
                    'label'=>'F. de inicio:'
                    ))
                ->add('fechaFin','date', array(
                    'widget' => 'single_text',
                    'required'=>false,
                    'label'=>'F. de cierre:'
                    ))
                ->add('importe','text', array(
                    'required'=>false,
                    'label'=>'Importe:'
                    ))            
                ->add('descripcion0','textarea',array(
                    'max_length'=>'200',
                    'label'=>'Descripción (0):',
                    'required' => false
                    ))
                ->add('descripcion1','textarea',array(
                    'max_length'=>'200',
                    'label'=>'Descripción (1):',
                    'required' => false
                    ))
                ->add('descripcion2','textarea',array(
                    'max_length'=>'200',
                    'label'=>'Descripción (2):',
                    'required' => false
                    ))               
         ;
    }
 
    public function setDefaultOptions(OptionsResolverInterface $resolver){
        $resolver->setDefaults(array(
            'data_class' => 'Gestor\ExpedientesBundle\Entity\Expediente'));
    }

    public function getName(){
        return 'gestor_expedientesbundle_expedientetype';        
    }
}

?>

