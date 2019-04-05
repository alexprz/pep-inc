<?php

namespace GS\FeedbackBundle\Form;

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
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


use Symfony\Component\Form\CallbackTransformer;

class QuestionModelType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', TextType::class, array(
            'label' => 'Intitulé'
        ))
        ->add('fbType', ChoiceType::class, array(
            'choices'  => array(
                'Étudiant' => 1,
                'Client' => 2,
                'Refus Client' => 3,
            ),
            'label' => 'Ajouter cette question aux questionnaires suivants :',
            'expanded' => true,
            'multiple' => true
        ))
        ->add('answerType', ChoiceType::class, array(
            'choices'  => array(
                'Oui/Non' => 1,
                'Texte' => 2,
            ),
            'label' => 'Type de la réponse',
            'expanded' => true
        ))
            ->add('Enregistrer', SubmitType::class)
        ;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GS\FeedbackBundle\Entity\QuestionModel'
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
