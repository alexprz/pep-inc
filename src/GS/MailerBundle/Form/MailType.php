<?php

namespace GS\MailerBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class MailType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $sendAsUsers = $options['sendAsUsers'];

        $builder
            ->add('sendAs',   EntityType::class, array(
                'class'        => 'GSUserBundle:User',
                'choice_label' => 'email',
                'choices'      => $sendAsUsers,
                'multiple'     => false,
                "mapped" => false,
            ))
            ->add('delayedDate',   DateTimeType::class, array(
              'attr' => array('class' => "datePicker"),
              'data' => new \DateTime("now", new \DateTimeZone("EUROPE/Paris")),
              "mapped" => false,
            ))
        ;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        // $resolver->setDefaults(array(
        //     'sendAsUsers' => null
        // ));
        $resolver->setRequired('sendAsUsers');
    }

    /**
     * {@inheritdoc}
     */
    // public function getBlockPrefix()
    // {
    //     return 'gs_mailerbundle_sendmail';
    // }


}
