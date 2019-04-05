<?php
// src/AppBundle/Form/RegistrationType.php

namespace GS\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
        ->add('gender', EntityType::class, array(
            'class'        => 'GSMailerBundle:Gender',
            'choice_label' => 'name',
            'multiple'     => false,
            'expanded' => true,
            'label' => 'Civilité'
        ))
          ->add('phone', TextType::class, array(
              'label' => 'Numéro',
              'required' => false
          ))
          ->add('mail_perso', TextType::class, array(
              'label' => 'Mail perso',
              'required' => false
          ))
          ->add('Enregistrer', SubmitType::class)
          // ->add('expiration_date', DateType::class)
          // ->add('post', EntityType::class, array(
          //   'class'        => 'JEPlatformBundle:Post',
          //   'choice_label' => 'name',
          //   'multiple'     => false,))
        ;
        // $builder
        //   ->remove('username')
        //   ->remove('plainPassword')
        // ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
          'data_class' => $this->class,
        ));
    }
}
