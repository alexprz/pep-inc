<?php

namespace GS\SettingsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('GSSettingsBundle:Default:index.html.twig');
    }
}
