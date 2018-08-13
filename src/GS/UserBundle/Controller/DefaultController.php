<?php

namespace GS\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use GS\UserBundle\Form\UserType;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('GSUserBundle:Default:index.html.twig');
    }

    public function showProfileAction(Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $user = $this->getUser();

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em->persist($user);
            $em->flush();
        }

        return $this->render('GSUserBundle:Profile:show.html.twig', array(
            'form' => $form->createView(),
            'user' => $user
        ));

    }
}
