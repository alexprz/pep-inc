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
use GS\FeedbackBundle\Form\QuestionModelType;
use GS\MailBundle\Entity\Mail;
use GS\FeedbackBundle\Entity\QuestionModel;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class QuestionController extends Controller
{
    public function questionManagerAction()
    {
        $questionList = $this->getDoctrine()
                            ->getManager()
                            ->getRepository('GSFeedbackBundle:QuestionModel')
                            ->findAll()
        ;

        return $this->render('GSFeedbackBundle:question:questionManager.html.twig', array(
            'questionList' => $questionList
        ));
    }

    public function questionShowAction(Request $request, $id)
    {
        $question = $this->getDoctrine()
                            ->getManager()
                            ->getRepository('GSFeedbackBundle:QuestionModel')
                            ->find($id)
        ;

        return $this->render('GSFeedbackBundle:question:question_show.html.twig', array(
            'question' => $question
        ));
    }

    public function questionEditAction(Request $request, $id = null)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $repo = $em->getRepository('GSFeedbackBundle:QuestionModel');

        $questionModel = new QuestionModel();
        if($id != null)
            $questionModel = $repo->find($id);

        $form = $this->createForm(QuestionModelType::class, $questionModel);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em->persist($questionModel);
            $em->flush();
            if($id == null)
                return $this->redirectToRoute('gs_feedback_question_manager');
            return $this->redirectToRoute('gs_feedback_question_show', array('id' => $questionModel->getId()));
        }

        return $this->render('GSFeedbackBundle:question:question_add.html.twig', array(
            'form' => $form->createView(),
            'title' => $id == null ? "Ajouter une question" : "Modifier une question"
        ));
    }

    public function confirmDeleteAction(Request $request,$id)
    {
        return $this->render('GSFeedbackBundle:question:question_delete.html.twig', array(
            'id' => $id
        ));
    }

    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('GSFeedbackBundle:QuestionModel');
        $repoQuestion = $em->getRepository('GSFeedbackBundle:Question');

        $questionModel = $repo->find($id);
        $questionList = $repoQuestion->findByQuestionModel($questionModel);
        foreach ($questionList as $question) {
            $em->remove($question);
        }
        $em->remove($questionModel);
        $em->flush();

        return $this->redirectToRoute('gs_feedback_question_manager');
    }
}
