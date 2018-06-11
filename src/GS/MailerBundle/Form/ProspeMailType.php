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

use GS\MailerBundle\Form\MailSoftType;
use GS\UserBundle\User;

use Symfony\Component\Form\CallbackTransformer;

class ProspeMailType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $user = $options['user'];
        $builder
            ->add('company', TextType::class)
            ->add('specialization', EntityType::class, array(
                    'class'        => 'GSMailerBundle:Specialization',
                    'choice_label' => 'name',
                    'multiple'     => true,
                    'expanded' => true,
            ))
            ->add('gender', EntityType::class, array(
                    'class'        => 'GSMailerBundle:Gender',
                    'choice_label' => 'name',
                    'multiple'     => true,
                    'expanded' => true,
            ))
            // ->add('specialization', CollectionType::class, array(
            // 'entry_type'   => ChoiceType::class,
            // 'allow_add'    => true,
            // 'allow_delete' => true
            // ))
            ->add('recipientName', TextType::class)
            ->add('mail', MailSoftType::class)
            // ->add('user', HiddenType::class, array(
            //     'data' => $user->getId()
            // ))
            ->add('user', EntityType::class, array(
                    'class'        => 'GSUserBundle:User',
                    'choices' => array($user),
                    // 'attr' => array('style' => "display: none;")
            ))
            ->add('Ajouter', SubmitType::class)
        ;
        // $builder->get('user')
        //    ->addModelTransformer(new CallbackTransformer(
        //        function ($property) {
        //            return (string) $property;
        //        },
        //        function ($property) {
        //            return (object) $property;
        //        }
        //  ));
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GS\MailerBundle\Entity\ProspeMail'
        ));
        $resolver->setRequired('user');
    }

    /**
     * {@inheritdoc}
     */
    // public function getBlockPrefix()
    // {
    //     return 'gs_mailerbundle_sendmail';
    // }


}
