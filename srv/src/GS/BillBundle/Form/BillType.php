<?php

namespace GS\BillBundle\Form;

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
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use GS\MailerBundle\Form\MailSoftType;
use GS\UserBundle\User;

use Symfony\Component\Form\CallbackTransformer;

class BillType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('billNumber', TextType::class, array(
                'label' => 'Numéro de facture'
            ))
            ->add('billType', EntityType::class, array(
                'class'        => 'GSBillBundle:BillType',
                'choice_label' => 'name',
                'label' => 'Type de facture'
            ))
            ->add('clientMember', EntityType::class, array(
                'class'        => 'GSUserBundle:User',
                'choice_label' => 'email',
                'multiple'     => false,
                'label' => 'Membre de la PEP'
            ))
            ->add('clientName', TextType::class, array(
                'label' => 'Nom du client'
            ))
            // ->add('billPdf', FileType::class, array(
            //     'label' => 'Uploader la facture',
            //     'required' => false,
            //     'data_class' => null
            // ))
            ->add('dueDate', DateType::class, array(
                'label' => 'Date d\'échéance'
            ))
            ->add('amount', TextType::class, array(
                'label' => 'Montant TTC (€)'
            ))
            ->add('billState', EntityType::class, array(
                'class'        => 'GSBillBundle:BillState',
                'choice_label' => 'name',
                'multiple'     => false,
                'label' => 'État'
            ))
            ->add('paymentMean', EntityType::class, array(
                'class'        => 'GSBillBundle:PaymentMeans',
                'choice_label' => 'name',
                'multiple'     => false,
                'required'     => false,
                'label' => 'Moyen de paiement'
            ))
            ->add('paymentDate', DateType::class, array(
                'label' => 'Date de paiement',
                'required' => false
            ))
            ->add('followerMember', EntityType::class, array(
                'class'        => 'GSUserBundle:User',
                'choice_label' => 'email',
                'placeholder'  => 'Autre',
                'multiple'     => false,
                'required'     => false,
                'label' => 'Suiveur'
            ))
            ->add('followerEmail', TextType::class, array(
                'label' => 'Spécifier l\'adresse mail du suiveur : ',
                'required'     => false
            ))
            ->add('Enregistrer', SubmitType::class)
        ;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GS\BillBundle\Entity\Bill'
        ));
    }

    /**
     * {@inheritdoc}
     */
    // public function getBlockPrefix()
    // {
    //     return 'gs_mailerbundle_sendmail';
    // }


}
