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
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use GS\MailerBundle\Form\MailSoftType;
use GS\FeedbackBundle\Form\QuestionAnswerType;
use GS\FeedbackBundle\Form\QuestionType;
use GS\UserBundle\User;

use Symfony\Component\Form\CallbackTransformer;

class FbAnswerType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $nbQuestions = $options['nb_questions'];
        // foreach ($questionList as $i => $question) {
        //     if($question->getQuestionModel()->getAnswerType() == 1) //Boolean
        //     {
        //         // $builder->add('q'.$i, ChoiceType::class, array(
        //         //     'label' => $question->getQuestionModel()->getTitle(),
        //         //     'choices' => array(array('Oui' => true), array('Non' => false)),
        //         //     'expanded' => true,
        //         //     'data' => true
        //         // ));
        //         // $builder->add('')
        //     }
        // }
        // $builder->add('question', QuestionType::class, array('questionList' => $questionList));
        $builder->add('nb_questions', HiddenType::class, array(
            'data' => $nbQuestions,
            'mapped' => false
        ));
        $builder->add('question', CollectionType::class, array(
            'entry_type' => QuestionType::class,
            // 'entry_options' => [
            //         "title" => 'bat',
            //     ]
            'entry_options' => array('label' => false),
            'label' => false
        ));
        $builder

            ->add('Envoyer', SubmitType::class, array(
                'attr' => array('class' => 'btn-block btn-outline-warning')
            ))
        ;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GS\FeedbackBundle\Entity\Feedback'
        ));
        $resolver->setRequired('nb_questions');
    }

    /**
     * {@inheritdoc}
     */
    // public function getBlockPrefix()
    // {
    //     return 'gs_mailerbundle_sendmail';
    // }


}
