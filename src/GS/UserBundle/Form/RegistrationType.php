<?php
// src/AppBundle/Form/RegistrationType.php

namespace GS\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
          ->add('last_name', TextType::class)
          ->add('first_name', TextType::class)
          // ->add('expiration_date', DateType::class)
          // ->add('post', EntityType::class, array(
          //   'class'        => 'JEPlatformBundle:Post',
          //   'choice_label' => 'name',
          //   'multiple'     => false,))
        ;
        $builder
          ->remove('username')
          ->remove('plainPassword')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
          'data_class' => $this->class,
        ));
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }

    public function getName()
    {
        return 'app_user_registration';
    }
}
