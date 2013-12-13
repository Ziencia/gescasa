<?php

namespace Gestor\GestionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class infoTipoMobiliarioType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('descripcion','textarea',array(
                    'max_length'=>'255',
                    'label'     =>'Descripción:',
                    'required'  => true
                    ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Gestor\GestionBundle\Entity\infoTipoMobiliario'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gestor_gestionbundle_infotipomobiliario';
    }
}
