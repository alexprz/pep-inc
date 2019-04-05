<?php

namespace CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('CoreBundle::index.html.twig');
    }

    public function workInProgressAction()
    {
        return $this->render('CoreBundle::workInProgress.html.twig');
    }
}
