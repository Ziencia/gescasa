<?php

namespace Gestor\AdministracionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UsuarioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder                
                ->add('nombre','text',array(
                    'max_length'=>'100',
                    'label'=>'Nombre'
                    ))
                ->add('apellidos','text',array(
                    'max_length'=>'200',
                    'label'=>'Apellidos'                    
                    ))
                ->add('tip','text',array(
                    'max_length'=>'7',
                    'label'=>'TIP'
                    ))
                ->add('password','repeated',array(
                    'type'=>'password',
                    'invalid_message'=>'Las dos contraseñas deben coincidir.',
                    'options'=>array('label'=>'Contraseña'),
                    'label'=>'Password'
                    ))
                ->add('salt','text',array(
                    'max_length'=>'100',
                    'read_only'=>true,
                    'label'=>'Salt'
                ))
                ->add('fechaAlta','date', array(
                    'widget' => 'single_text',
                    'read_only'=>true,
                    'label'=>'F. de alta'
                    ))
                ->add('fechaBaja','date', array(
                    'widget' => 'single_text',
                    'required'=>false,
                    'read_only'=>true,
                    'label'=>'F. de baja'
                    ))
                ->add('dni','text',array(
                    'max_length'=>'9',
                    'label'=>'DNI'
                    ))
                ->add('autorizado','checkbox',array(
                    'required'=>false,
                    'label'=>'Autorizado'                    
                ))
                ->add('rol','choice',array(
                    'choices'=>array(
                        'ROLE_USER'=>'GESTOR',
                        'ROLE_ADMIN'=>'ADMINISTRADOR',
                        'ROLE_SUPER_ADMIN'=>'SUPER ADMINISTRADOR'
                     ),
                    'label'=>'ROL',
                    'mapped'=>false
                ))                
         ;
    }
 
    public function setDefaultOptions(OptionsResolverInterface $resolver){
        $resolver->setDefaults(array(
            'data_class' => 'Gestor\UsuarioBundle\Entity\Usuario'));
    }

    public function getName(){
        return 'gestor_administracionbundle_usuariotype';        
    }
}

?>
