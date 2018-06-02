<?php

namespace GS\MailerBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class DatabaseType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
          ->add('sentDate',   DateType::class, array(
              'attr' => array('class' => "datePicker"),
              'required' =>false,
          ))
          ->add('stateSelector',   EntityType::class, array(
              'class'        => 'GSMailerBundle:State',
              'choice_label' => 'name',
              'required' => false,
              'placeholder' => 'Aucune réponse',
              'multiple'     => false,
              "mapped" => false,
          ))
        ;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        // $resolver->setDefaults(array(
        //     'data_class' => 'JE\PlatformBundle\Entity\Client'
        // ));
    }

    /**
     * {@inheritdoc}
     */
    // public function getBlockPrefix()
    // {
    //     return 'gs_mailerbundle_sendmail';
    // }


}
