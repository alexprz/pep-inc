<?php

namespace GS\MailerBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\Form\CallbackTransformer;

class MailSoftType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $artificial = $options['artificial'];

        $builder
            ->add('recipientEmail', TextType::class)
        ;
        if($artificial){
            $builder->add('sentDate', DateTimeType::class, array(
                'data' => new \DateTime("now", new \DateTimeZone("EUROPE/Paris")),
            ));
        }
        if(!$artificial){

            $builder->add('subject', TextType::class, array(
                'attr' => array('value' => 'Ponts Études Projets')
            ))
            ;
            $builder->add('scheduledDate',   DateTimeType::class, array(
                'attr' => array('class' => "datePicker"),
                'data' => new \DateTime("now", new \DateTimeZone("EUROPE/Paris"))
            ));
        }
        // $builder->get('artificial')
        //    ->addModelTransformer(new CallbackTransformer(
        //        function ($property) {
        //            return (bool) $property;
        //        },
        //        function ($property) {
        //            return (int) $property;
        //        }
        //  ));
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
          'data_class' => 'GS\MailBundle\Entity\Mail'
        ));
        $resolver->setRequired('artificial');
    }

    /**
     * {@inheritdoc}
     */
    // public function getBlockPrefix()
    // {
    //     return 'gs_mailerbundle_sendmail';
    // }


}
