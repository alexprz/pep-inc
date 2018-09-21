<?php

namespace GS\MailerBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use GS\MailerBundle\Form\MailSoftType;
use GS\UserBundle\User;

use Symfony\Component\Form\CallbackTransformer;

class ProspeMailUpdateType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $sendAsUsers = $options['sendAsUsers'];
        $artificial = $options['artificial'];
        // $user = $options['user'];
        if(!$artificial){
            $builder->add('sendAsUser',   EntityType::class, array(
                'class'        => 'GSUserBundle:User',
                'choice_label' => 'email',
                'choices'      => $sendAsUsers,
                'multiple'     => false,
                'attr' => array('class' => 'form-control-dark'),
                'label' => 'Envoyer en tant que :'
            ));
        }
        $builder
            ->add('company', TextType::class, array(
                'attr' => array('class' => 'form-control-dark'),
                'label' => 'Entreprise',
                'required' => false
            ))
            ->add('specialization', EntityType::class, array(
                    'class'        => 'GSMailerBundle:Specialization',
                    'choice_label' => 'name',
                    'multiple'     => true,
                    'expanded' => true,
                    'label' => 'Spécialisation'
            ))
            ->add('gender', EntityType::class, array(
                    'class'        => 'GSMailerBundle:Gender',
                    'choice_label' => 'name',
                    'multiple'     => false,
                    'required' => false,
                    'expanded' => true,
                    'label' => 'Civilité'
            ))
            // ->add('specialization', CollectionType::class, array(
            // 'entry_type'   => ChoiceType::class,
            // 'allow_add'    => true,
            // 'allow_delete' => true
            // ))
            ->add('recipientName', TextType::class, array(
                'attr' => array('class' => 'form-control-dark'),
                'label' => 'Nom',
                'required' => false
            ))
            ->add('mail', MailSoftUpdateType::class, array(
                'artificial' => $artificial,
                'label' => false
            ));
            if(!$artificial){
                $builder->add('toggleDelayedInput', CheckboxType::class, array(
                    'required' => false,
                    'mapped' => false,
                    'label' => 'Envoi différé'
                ));
            }
            // ->add('user', HiddenType::class, array(
            //     'data' => $user->getId()
            // ))
            // ->add('user', EntityType::class, array(
            //         'class'        => 'GSUserBundle:User',
            //         'choices' => array($user),
            //         // 'attr' => array('style' => "display: none;")
            // ))


        $builder->add('Ajouter', SubmitType::class, array(
            'attr' => array('class' => 'btn btn-outline-success')
        ));
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
        $resolver->setRequired('sendAsUsers');
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
