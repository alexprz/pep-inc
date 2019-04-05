<?php

namespace GS\FeedbackBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use GS\FeedbackBundle\Entity\FeedbackSet;
use GS\FeedbackBundle\Entity\FbStudent;
use GS\FeedbackBundle\Entity\FbClient;
use GS\FeedbackBundle\Entity\Feedback;
use GS\FeedbackBundle\Entity\FbClient_Denial;
use GS\FeedbackBundle\Entity\Token;
use GS\FeedbackBundle\Form\FbSetType;
use GS\FeedbackBundle\Form\FbStudentType;
use GS\FeedbackBundle\Form\FbClientType;
use GS\FeedbackBundle\Form\FbClient_DenialType;
use GS\FeedbackBundle\Form\FbStudentAnswerType;
use GS\FeedbackBundle\Form\FbClientAnswerType;
use GS\FeedbackBundle\Form\FbClient_DenialAnswerType;
use GS\FeedbackBundle\Form\FbAnswerType;
use GS\FeedbackBundle\Form\QuestionModelType;
use GS\MailBundle\Entity\Mail;
use GS\FeedbackBundle\Entity\QuestionModel;
use GS\FeedbackBundle\Entity\Question;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AnswerController extends Controller
{
    public function answerAction(Request $request, $slug)
    {
        $em = $this->getDoctrine()->getManager();
        $repoFeedback = $em->getRepository('GSFeedbackBundle:Feedback');
        $repoQuestion = $em->getRepository('GSFeedbackBundle:Question');

        $fb = $repoFeedback->findBySlug($slug);

        if($fb == null)
            throw new NotFoundHttpException();

        if($fb->isSubmitted())
            return $this->render('GSFeedbackBundle:answer:fb_already_submitted.html.twig', array('fb' => $fb));

        // $type = $fb->getType();
        // if($type == 1)
        //     $form = $this->createForm(FbStudentAnswerType::class, $fb);
        // else if($type == 2)
        //     $form = $this->createForm(FbClientAnswerType::class, $fb);
        // else if($type == 3)
        //     $form = $this->createForm(FbClient_DenialAnswerType::class, $fb);
        // $formList = array();
        $questionList = $repoQuestion->findByFeedback($fb);
        // foreach ($questionList as $question) {
        //     array_push($this->createForm(QuestionType::class, $question, array()), $formList);
        // }
        $form = $this->createForm(FbAnswerType::class, $fb, array(
            'nb_questions' => count($questionList)
            // 'questionList' => $repoQuestion->findByFeedback($fb)
        ));
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $fb->setResponseDate(new \DateTime("now", new \DateTimeZone("EUROPE/Paris")));
            $em->persist($fb);
            $em->flush();

            $user = $fb->getUser();
            $mail = new Mail();
            $mail->setRecipientEmail($user->getEmail());

            $twig = $this->get('twig');
            $template = $twig->loadTemplate('@GSMailBundle/Resources/views/mail_templates/feedback-submitted.twig');
            $parameters  = array('fb' => $fb);
            $subject  = $template->renderBlock('subject',   $parameters);
            $body = $template->renderBlock('body', $parameters);

            $mail->setSubject($subject);
            $mail->setContent($body);

            $mailManager = $this->container->get('gs_mail.mail_manager');
            $mailManager->send($mail);

            return $this->render('GSFeedbackBundle:answer:fb_submitted.html.twig', array(
                'fb' => $fb
            ));

        }

        return $this->render('GSFeedbackBundle:answer:fb_answer.html.twig', array(
            'form' => $form->createView(),
            'feedback' => $fb
        ));
    }

    public function missSubmitAction(Request $request, $slug)
    {
        return $this->render('GSFeedbackBundle:answer:fb_miss_submit.html.twig', array(
            'slug' => $slug
        ));
    }

    public function askUnsubmitAction(Request $request, $slug)
    {
        $em = $this->getDoctrine()->getManager();
        $repoFb = $em->getRepository('GSFeedbackBundle:Feedback');

        $fb = $repoFb->findBySlug($slug);

        $mail = new Mail();
        $mail->setRecipientEmail($fb->getUser()->getEmail());

        $twig = $this->get('twig');
        $template = $twig->loadTemplate('@GSMailBundle/Resources/views/mail_templates/unsubmit_demand.twig');
        $parameters  = array('fb' => $fb);
        $subject  = $template->renderBlock('subject',   $parameters);
        $body = $template->renderBlock('body', $parameters);

        $mail->setSubject($subject);
        $mail->setContent($body);

        $mailManager = $this->container->get('gs_mail.mail_manager');
        $mailManager->send($mail);


        return $this->render('GSFeedbackBundle:answer:fb_unsubmit_asked.html.twig', array(
            'fb' => $fb
        ));
    }

    public function openAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $fb = $em->getRepository('GSFeedbackBundle:Feedback')
                    ->findFeedback($id)
        ;

        $fb->setResponseDate(null);
        $em->persist($fb);
        $em->flush();

        return $this->render('GSFeedbackBundle:answer:fb_opened.html.twig', array(
            'fb' => $fb
        ));
    }
}
