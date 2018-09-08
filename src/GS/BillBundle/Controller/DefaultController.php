<?php

namespace GS\BillBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('GSBillBundle:Default:index.html.twig');
    }

    public function addAction()
    {
        $em = $this->getDoctrine()->getManager();
        $bill = new Bill();

        $form = $this->createForm(BillType::class, $bill);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $bill->setUser($this->getUser());
            $em->persist($feedbackSet);
            $em->flush();

            // return $this->redirectToRoute('gs_feedback_fbSet_view', array(
            //     'id' => $feedbackSet->getId()
            // ));
        }

        return $this->render('GSFeedbackBundle:Bill:add.html.twig', array(
            'form' => $form->createView(),
            'title' => "Ajouter une étude aux feedbacks"
        ));
    }
}
