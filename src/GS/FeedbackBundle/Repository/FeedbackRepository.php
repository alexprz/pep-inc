<?php

namespace GS\FeedbackBundle\Repository;

/**
 * FeedbackRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class FeedbackRepository extends \Doctrine\ORM\EntityRepository
{
    public function findFeedback($id)
    {
        $em = $this->getEntityManager();

        $repoStudent = $em->getRepository('GSFeedbackBundle:FbStudent');
        $repoClient = $em->getRepository('GSFeedbackBundle:FbClient');
        $repoClient_Denial = $em->getRepository('GSFeedbackBundle:FbClient_Denial');

        $fb = $repoStudent->find($id);
        if($fb == null)
            $fb = $repoClient->find($id);
        if($fb == null)
            $fb = $repoClient_Denial->find($id);

        return $fb;
    }

    public function findBySlug($slug)
    {
        $em = $this->getEntityManager();

        $repo = $em->getRepository('GSFeedbackBundle:Token');
        $token = $repo->findByString($slug);
        if($token == null)
            return new NotFoundHttpException();

        return $token[0]->getFeedback();
    }

    public function findByFeedbackSet($fbSet)
    {
        $em = $this->getEntityManager();

        $repoStudent = $em->getRepository('GSFeedbackBundle:FbStudent');
        $repoClient = $em->getRepository('GSFeedbackBundle:FbClient');
        $repoClient_Denial = $em->getRepository('GSFeedbackBundle:FbClient_Denial');

        $fbList1 = $repoStudent->findByFeedbackSet($fbSet);
        $fbList2 = $repoClient->findByFeedbackSet($fbSet);
        $fbList3 = $repoClient_Denial->findByFeedbackSet($fbSet);

        return array_merge($fbList1, $fbList2, $fbList3);
    }
}
