<?php

namespace GS\StatsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class InterfaceController extends Controller
{
    public function mainAction()
    {
        $repo = $this->get('gs_stats.repository');
        $todayDate = new \DateTime("now", new \DateTimeZone("EUROPE/Paris"));
        // $repo->setEndDate($todayDate->modify('-50 day'));
        // $repo->setStartDate($todayDate->modify('-100 day'));

        return $this->render('GSStatsBundle:Interface:main.html.twig', array(
            'repo' => $repo
        ));
    }

    public function analysisAction()
    {
        $repo = $this->get('gs_stats.repository');
        $todayDate = new \DateTime("now", new \DateTimeZone("EUROPE/Paris"));
        // $repo->setEndDate($todayDate->modify('-50 day'));
        // $repo->setStartDate($todayDate->modify('-100 day'));

        return $this->render('GSStatsBundle:Interface:analysis.html.twig', array(
            'repo' => $repo
        ));
    }
}
