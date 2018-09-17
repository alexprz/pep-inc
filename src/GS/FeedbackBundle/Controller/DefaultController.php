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

class DefaultController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $repoFbSet = $em->getRepository('GSFeedbackBundle:FeedbackSet');
        $result = $repoFbSet->getSubmittedStats();
        // throw new NotFoundHttpException(json_encode($result));
        return $this->render('GSFeedbackBundle::index.html.twig', array(
            'fbSetList' => $repoFbSet->findAll(),
            'countSubmittedFeedbacks' => $result[0],
            'countAllFeedbacks' => $result[1]
        ));
    }
    public function addSetAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $feedbackSet = new FeedbackSet();

        $form = $this->createForm(FbSetType::class, $feedbackSet);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $feedbackSet->setUser($this->getUser());
            $em->persist($feedbackSet);
            $em->flush();

            return $this->redirectToRoute('gs_feedback_fbSet_view', array(
                'id' => $feedbackSet->getId()
            ));
        }

        return $this->render('GSFeedbackBundle::fbSet_add.html.twig', array(
            'form' => $form->createView(),
            'title' => "Ajouter une étude aux feedbacks"
        ));

    }

    public function editSetAction(Request $request, $setId)
    {
        $em = $this->getDoctrine()->getManager();
        $repoFbSet = $em->getRepository('GSFeedbackBundle:FeedbackSet');
        $fbSet = $repoFbSet->find($setId);

        $form = $this->createForm(FbSetType::class, $fbSet);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em->persist($fbSet);
            $em->flush();

            return $this->redirectToRoute('gs_feedback_fbSet_view', array(
                'id' => $fbSet->getId()
            ));
        }

        return $this->render('GSFeedbackBundle::fbSet_add.html.twig', array(
            'form' => $form->createView(),
            'title' => "Modifier l'étude « ".$fbSet->getTitle()." »"
        ));
    }

    public function confirmDeleteSetAction(Request $request, $setId)
    {
        return $this->render('GSFeedbackBundle::fbSet_delete.html.twig', array(
            'setId' => $setId
        ));
    }

    public function deleteSetAction(Request $request, $setId)
    {
        $em = $this->getDoctrine()->getManager();
        $repoFbSet = $em->getRepository('GSFeedbackBundle:FeedbackSet');

        $feedbackSet = $repoFbSet->find($setId);

        $em->remove($feedbackSet);
        $em->flush();

        return $this->redirectToRoute('gs_feedback_homepage', array('id' => $setId));
    }

    public function viewSetAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $repoFbSet = $em->getRepository('GSFeedbackBundle:FeedbackSet');
        $repoFb = $em->getRepository('GSFeedbackBundle:Feedback');
        $feedbackSet = $repoFbSet->find($id);
        $fbArray = $repoFb->findByFeedbackSet($feedbackSet);
        return $this->render('GSFeedbackBundle::fbSet_view.html.twig', array(
            'feedbackSet' => $feedbackSet,
            'fbList' => $fbArray
        ));
    }

    public function createFbForm($feedback)
    {
        $type = $feedback->getType();
        if($type == 1)
            return $this->createForm(FbStudentType::class, $feedback);
        else if($type == 2)
            return $this->createForm(FbClientType::class, $feedback);
        else if($type == 3)
            return $this->createForm(FbClient_DenialType::class, $feedback);
    }

    public function addFbAction(Request $request, $setId, $type)
    {
        if($type == 1){
            $fb = new FbStudent();
            $form = $this->createForm(FbStudentType::class, $fb);
        }
        else if($type == 2){
            $fb = new FbClient();
            $form = $this->createForm(FbClientType::class, $fb);
        }
        else if($type == 3){
            $fb = new FbClient_Denial();
            $form = $this->createForm(FbClient_DenialType::class, $fb);
        }
        else
            throw new NotFoundHttpException();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();

            $repo = $em->getRepository('GSFeedbackBundle:FeedbackSet');
            $feedbackSet = $repo->find($setId);

            $fb->setToken($this->generateToken($em));
            $fb->setUser($this->getUser());
            $feedbackSet->addFeedback($fb);
            $em->persist($feedbackSet);
            $em->flush();

            $repoQModel = $em->getRepository('GSFeedbackBundle:QuestionModel');
            $qModelList = $repoQModel->findAll();
            foreach ($qModelList as $questionModel){
                if(in_array($fb->getType(), $questionModel->getFbType())){
                    // throw new NotFoundHttpException(in_array($fb->getType(), $questionModel->getFbType()));
                    $question = new Question();
                    $question->setQuestionModel($questionModel);
                    $fb->addQuestion($question);
                }
            }
            $em->flush();


            return $this->redirectToRoute('gs_feedback_fb_view', array('setId' => $setId, 'fbId' => $fb->getId()));

        }

        return $this->render('GSFeedbackBundle::fb_add.html.twig', array(
            'feedback' => $fb,
            'form' => $form->createView(),
            'title' => "Ajouter un ".$fb->stringTitle()
        ));
    }

    public function editFbAction(Request $request, $setId, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $repoFeedback = $em->getRepository('GSFeedbackBundle:Feedback');

        $fb = $repoFeedback->findFeedback($id);
        $form = $this->createFbForm($fb);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em->persist($fb);
            $em->flush();

            return $this->redirectToRoute('gs_feedback_fb_view', array('setId' => $setId, 'fbId' => $fb->getId()));

        }

        return $this->render('GSFeedbackBundle::fb_add.html.twig', array(
            'feedback' => $fb,
            'form' => $form->createView(),
            'title' => "Modifier le ".$fb->stringTitle()." de ".$fb->stringName()
        ));

    }

    public function confirmDeleteFbAction(Request $request, $setId, $id)
    {
        return $this->render('GSFeedbackBundle::fb_delete.html.twig', array(
            'setId' => $setId,
            'id' => $id
        ));
    }

    public function deleteFbAction(Request $request, $setId, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $repoFeedback = $em->getRepository('GSFeedbackBundle:Feedback');
        $repoFbSet = $em->getRepository('GSFeedbackBundle:FeedbackSet');

        $fb = $repoFeedback->findFeedback($id);
        $feedbackSet = $repoFbSet->find($setId);

        $feedbackSet->removeFeedback($fb);
        $em->persist($feedbackSet);
        $em->remove($fb);
        $em->flush();

        return $this->redirectToRoute('gs_feedback_fbSet_view', array('id' => $setId));
    }

    public function viewFbAction(Request $request, $setId, $fbId)
    {
        $repoFeedback = $this->getDoctrine()
                        ->getManager()
                        ->getRepository('GSFeedbackBundle:Feedback')
        ;

        return $this->render('GSFeedbackBundle::fb_view.html.twig', array(
            'feedback' => $repoFeedback->findFeedback($fbId),
            'setId' => $setId
        ));
    }


    public function generateToken($em, $expirationDate = null)
    {
        $token = new Token();
        $token->setExpirationDate($expirationDate);
        $continue = true;
        while($continue){
            $token->setString(sha1(random_bytes(20)));
            $em->persist($token);
            try {
                $em->flush();
                $continue = false;
            } catch (\Exception $e) {
                $continue = false;
            }
        }

        return $token;
    }

    public function dumpAllAction()
    {

    }

}
