<?php

namespace GS\FeedbackBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;

use GS\MailerBundle\Form\MailSoftType;
use GS\UserBundle\User;
use GS\FeedbackBundle\Entity\Question;


use Symfony\Component\Form\CallbackTransformer;

class QuestionType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // $title = $options['title'];
        // $builder->addEventListener(FormEvents::POST_LOAD,
        //     function (FormEvent $event) use ($builder)
        //     {
        //         $form = $event->getForm();
        //         $question = $event->getData();
        //
        //         // if ($question instanceof \GS\FeedbackBundle\Entity\Question) {
        //
        //             // Do what ever you like with $child entity data
        //             $builder->add('booleanAnswer', ChoiceType::class, array(
        //                 'label' => 'bite',//$question->getQuestionModel()->getTitle(),
        //                 'choices' => array(array('Oui' => true), array('Non' => false)),
        //                 'expanded' => true,
        //                 'data' => true
        //             ));
        //         // }
        //     }
        // );
        $question = $builder->getData();
        $builder->add('questionModel', QuestionModelAnswerType::class, array(
            'label' => false,
            'disabled' => true,
            'attr' => array('class' => 'disabled-textarea')
        ));
        $builder->add('booleanAnswer', ChoiceType::class, array(
            'label' => false,//$question->getQuestionModel()->getTitle(),
            'choices' => array(array('Oui' => true), array('Non' => false), array('Sans avis' => null)),
            'expanded' => true
        ));
        $builder->add('textAnswer', TextareaType::class, array(
            'label' => false,//$question->getQuestionModel()->getTitle(),
            'required' => false
        ));
        // $question = $builder->getData();
        // $questionList = $options['questionList'];
        // foreach ($questionList as $i => $question) {
            // if($question->getQuestionModel()->getAnswerType() == 1) //Boolean
            // {
                // $builder->add('booleanAnswer', ChoiceType::class, array(
                //     'label' => $question->getQuestionModel()->getTitle(),
                //     'choices' => array(array('Oui' => true), array('Non' => false)),
                //     'expanded' => true,
                //     'data' => true
                // ));
            // }
        // }
        // $builder->add('questionList', CollectionType::class, array(
        //     'entry_type' => QuestionType::class,
        //     'entry_options' => array('label' => false),
        // ));
        // $builder
        //
        //     ->add('Envoyer', SubmitType::class)
        // ;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GS\FeedbackBundle\Entity\Question'
        ));
        // $resolver->setRequired('title');
    }

    /**
     * {@inheritdoc}
     */
    // public function getBlockPrefix()
    // {
    //     return 'gs_mailerbundle_sendmail';
    // }


}
