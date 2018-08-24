<?php

namespace GS\MailerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use GS\MailerBundle\Form\MailType;
use GS\MailerBundle\Form\DatabaseType;
use GS\MailerBundle\Form\ProspeMailType;
// use GS\MailerBundle\Entity\Mail;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use GS\MailBundle\Entity\Mail;
use GS\MailerBundle\Entity\ProspeMail;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('GSMailerBundle::index.html.twig');
    }

    // public function writeProspeMailAction()
    // {
    //     $repository = $this
    //       ->getDoctrine()
    //       ->getManager()
    //       ->getRepository('GSUserBundle:User')
    //     ;
    //
    //     $user = $this->getUser();
    //     $sendAsUsers = $repository->findByPostName('Directeur Commercial');
    //     array_push($sendAsUsers, $user);
    //
    //
    //     $form = $this->createForm(ProspeMailType::class, new ProspeMail(), array(
    //         'artificial' => false,
    //         'sendAsUsers' => $sendAsUsers
    //     ));
    //
    //     return $this->render('GSMailerBundle::prospeMailEdit.html.twig', array(
    //         'form' => $form->createView()
    //     ));
    // }
    //
    // public function addProspeMailAction(Request $request)
    // {
    //     $session = $request->getSession();
    //     $prospeMail = new ProspeMail();
    //     $form = $this->createForm(ProspeMailType::class, $prospeMail, array(
    //         'artificial' => false,
    //         'sendAsUsers' => null
    //     ));
    //     if($request->isMethod('POST'))
    //     {
    //         $form->handleRequest($request);
    //         if($form->isValid())
    //         {
    //             $prospeMailList = $session->get('prospeMailList');
    //             $pseudo_id = 0;
    //             if($prospeMailList==null)
    //                 $prospeMailList = array(array("pseudo_id" => $pseudo_id, "mail" => $prospeMail));
    //             else{
    //                 $pseudo_id = $prospeMailList[count($prospeMailList)-1]["pseudo_id"]+1;
    //                 array_push($prospeMailList, array("pseudo_id" => $pseudo_id, "mail" => $prospeMail));
    //             }
    //             $session->set('prospeMailList', $prospeMailList);
    //             //verify prospe mail
    //             //send result of verification
    //             return new JsonResponse(array("newProspeMail" => json_encode($prospeMail),
    //                     "isDuplication" => false,
    //                     "pseudo_id" => $pseudo_id
    //             ));
    //         }
    //     }
    //
    //     return new JsonResponse();
    // }
    //
    // public function loadProspeMailAction(Request $request)
    // {
    //     $session = $request->getSession();
    //     $prospeMailList = $session->get('prospeMailList');
    //     $responseArray = array();
    //     for ($i=0; $i < count($prospeMailList); $i++) {
    //         array_push($responseArray, array("newProspeMail" => json_encode($prospeMailList[$i]['mail']),
    //                                         "isDuplication" => false,
    //                                         "pseudo_id" => $prospeMailList[$i]['pseudo_id']
    //                                     ));
    //     }
    //     return new JsonResponse($responseArray);
    // }
    //
    // public function removeProspeMailAction(Request $request)
    // {
    //     $session = $request->getSession();
    //     $pseudo_id = $request->get('pseudo_id');
    //     $prospeMailList = $session->get('prospeMailList');
    //     $tempArray = array();
    //     for($i=0; $i<count($prospeMailList); $i++){
    //         if($prospeMailList[$i]['pseudo_id'] != $pseudo_id)
    //             array_push($tempArray, $prospeMailList[$i]);
    //     }
    //     $session->set('prospeMailList', $tempArray);
    //     return new JsonResponse();
    // }
    //
    // public function sendProspeMailAction(Request $request)
    // {
    //     $session = $request->getSession();
    //     $em = $this->getDoctrine()->getManager();
    //     $mailManager = $this->container->get('gs_mail.mail_manager');
    //     $pseudo_id = $request->get('pseudo_id');
    //     $prospeMailList = $session->get('prospeMailList');
    //     for($i=0; $i<count($prospeMailList); $i++){
    //         if($prospeMailList[$i]['pseudo_id'] == $pseudo_id){
    //             $prospeMail = $prospeMailList[$i]['mail'];
    //             $prospeMail->setUser($this->getUser());
    //             $prospeMail->getMail()->setFromEmail("pontsetudesprojets.commercial@gmail.com");
    //             $prospeMail->getMail()->setFromAlias($prospeMail->getMail()->getSendAsUser()->getFirstName()." ".$prospeMail->getMail()->getSendAsUser()->getLastName());
    //             $prospeMail->getMail()->setAttachmentName("Plaquette commerciale PEP");
    //             $prospeMail->getMail()->setAttachmentPath("bundles/plaquette.pdf");
    //             $mailManager->prepareSend($prospeMail->getMail());
    //             $em->merge($prospeMail);
    //             $em->flush();
    //             break;
    //         }
    //     }
    //
    //     return new JsonResponse();
    // }

    // public function sendProspeMailAction(Request $request)
    // {
    //     $em = $this->getDoctrine()->getManager();
    //
    //     $userId = $request->get("userId");
    //     $sendAsUserId = $request->get("sendAsUserId");
    //     $user = null;
    //     $sendAsUser = null;
    //
    //     if($userId != null)
    //         $user = $em->getRepository('GSUserBundle:User')->find($userId);
    //
    //     if($sendAsUserId != null)
    //         $sendAsUser = $em->getRepository('GSUserBundle:User')->find($sendAsUserId);
    //
    //     $response = new Response();
    //     $response->setStatusCode(200);
    //
    //     $mail = new Mail();
    //
    //     $mail->setRecipientEmail($request->get("recipientEmail"))
    //         ->setFromEmail($request->get("fromEmail"))
    //         ->setFromAlias($request->get("fromAlias"))
    //         ->setReplyToEmail($request->get("replyToEmail"))
    //         ->setSubject($request->get("subject"))
    //         ->setContent($request->get("content"))
    //         ->setScheduledDate(new \DateTime($request->get("scheduledDate")))
    //         ->setPlainText($request->get("plainText"))
    //         ->setAttachmentPath($request->get("attachmentPath"))
    //         ->setAttachmentName($request->get("attachmentName"))
    //     ;
    //     if ($request->get("scheduledDate") == null)
    //         $mail->setScheduledDate(null);
    //
    //     $mailManager = $this->container->get('gs_mail.mail_manager');
    //
    //     if(!$mailManager->prepareSend($mail))
    //         $response->setStatusCode(450);
    //
    //     $prospeMail = new ProspeMail();
    //
    //     $prospeMail->setUser($user)
    //         ->setSendAsUser($sendAsUser)
    //         ->setMail($mail)
    //         ->setRecipientName($request->get("recipientName"))
    //         ->setCompany($request->get("company"))
    //         ->setSpecializationIdArray($request->get("specializationIdArray"))
    //         ->setTitleId($request->get("titleId"))
    //     ;
    //
    //     $em->persist($prospeMail);
    //     $em->flush();
    //
    //     return $response;
    // }

    public function sendMailAction(Request $request)
    {
        // // Récupère les paramètres de la requette
        // $text = $request->get("text");
        // $from = $request->get("from");
        // $fromAlias = $request->get("fromAlias");
        // $to = $request->get("to");
        // $object = $request->get("object");
        // $scheduledDate = $request->get("scheduledDate");
        //
        // //Récupère l'utilisateur
        // $em = $this->getDoctrine()->getManager();
        // $user = $em->getRepository('GSUserBundle:User')->find($request->get("userid"));
        //
        // // Crée une nouvelle instance de Mail
        // $repoMail = $em->getRepository('GSMailerBundle:Mail');
        // $mail = new Mail();
        //
        // //Enregistre les paramètres
        // $mail->setFromAlias($fromAlias);
        // $mail->setFromEmail($from);
        // $mail->setRecipientEmail($to);
        // $mail->setObject($object);
        // $mail->setContent($text);
        // $mail->setUser($user);
        // $mail->setScheduledDate(new \DateTime($scheduledDate));
        // if ($scheduledDate == null) {
        //     $mail->setScheduledDate(null);
        // }

        // Crée une réponse
        $response = new Response();

        // Si aucun destinataires : erreur
        // if($to == null){
        //     $response->setStatusCode(450);
        //     return $response;
        // }

        // Prépare le message
        // $message = (new \Swift_Message($object))
        //     ->setFrom([$from => $fromAlias])
        //     ->setTo($to)
        //     // ->setReplyTo($from)
        //     ->setBody(
        //         $text,
        //         'text/html'
        //     )
        //     ->attach(\Swift_Attachment::fromPath('bundles/plaquette.pdf')->setFilename('Plaquette commerciale PEP.pdf'))
        // ;
        //
        // $mailer = $this->get('mailer');
        //
        //
        // $mail->setSent(false);
        // $sent = false;
        //
        // // Envoie le message ou non
        // if($scheduledDate == null){
        //     //Pas d'envoie différé
        //     $sent = $mailer->send($message);
        //     if($sent){
        //         $mail->setSent(true);
        //         $mail->setSentAt(new \DateTime("now", new \DateTimeZone("EUROPE/Paris")));
        //     }
        // }
        //
        // if($sent || $scheduledDate != null){
        //     // Envoie réussi : stocke le nouveau mail dans la BDD et renvoie code 200
        //     $response->setStatusCode(200);
        //     $em->persist($mail);
        //     $em->flush();
        // }
        // else {
        //     // Erreur : renvoie directement un code d'erreur
        //     $response->setStatusCode(451);
        // }

        return $response;
    }

    public function sendAction(Request $request)
    {
        // Récupère les paramètres de la requette
        // $text = $request->get("text");
        // $from = $request->get("from");
        // $fromAlias = $request->get("fromAlias");
        // $to = $request->get("to");
        // $object = $request->get("object");
        //
        // // Crée une réponse
        $response = new Response();
        //
        // // Si aucun destinataires : erreur
        // if($to == null){
        //     $response->setStatusCode(450);
        //     return $response;
        // }
        //
        // // Prépare le message
        // $message = (new \Swift_Message($object))
        //     ->setFrom([$from => $fromAlias])
        //     ->setTo($to)
        //     // ->setReplyTo($from)
        //     ->setBody(
        //         $text,
        //         'text/html'
        //     )
        // ;
        //
        // $mailer = $this->get('mailer');
        //
        // $sent = $mailer->send($message);
        // if(!$sent){
        //     // Erreur : renvoie directement un code d'erreur
        //     $response->setStatusCode(451);
        // }
        // else {
        //     $response->setStatusCode(200);
        // }

        return $response;
    }

    public function verifyMailAction(Request $request)
    {
        $id = $request->get("id");
        $recipient = $request->get("recipient");

        $em = $this->getDoctrine()->getManager();
        $results = $em->getRepository('GSMailerBundle:Mail')->findByRecipientEmail($recipient);

        $multipleMailsList = array();

        foreach ($results as $result) {

            $mailAttributes = array(
                "from" => $result->getFromEmail(),
                "fromAlias" => $result->getFromAlias(),
                "recipient" => $result->getRecipientEmail(),
                "object" => $result->getObject(),
                "content" => $result->getContent()
            );

            array_push($multipleMailsList, $mailAttributes);
        }

        return new JsonResponse(array("isMultiple" => $results != null, "multipleMails" => json_encode($multipleMailsList), "id" => $id));
    }

    public function writePepRecruteAction()
    {
        return $this->render('GSMailerBundle::pepRecruteEdit.html.twig');
    }

    public function showStatsAction()
    {
        return $this->render('GSMailerBundle::statistics.html.twig');
    }

    public function dumpStatsAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('GSMailerBundle:ProspeMail');

        $numberOfMails = $repo->countAll();
        // $numberOfMailsByDay = $repo->countDaily();
        $numberOfMailsByUser = $repo->countByUser();


        return new JsonResponse(array(
            'numberOfMails' => $numberOfMails,
            // 'numberOfMailsByDay' => json_encode($numberOfMailsByDay)
            'numberOfMailsByUser' => json_encode($numberOfMailsByUser),
        ));
    }

    public function settingsAction()
    {

        $form = $this->createForm(MailType::class);

        return $this->render('GSMailerBundle::settings.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function showMailDatabaseAction(Request $request)
    {
        $form = $this->createForm(DatabaseType::class);

        $repoState = $this
          ->getDoctrine()
          ->getManager()
          ->getRepository('GSMailerBundle:State')
        ;

        $stateIndex = $repoState->getStateIndex();

        return $this->render('GSMailerBundle::prospeMailDatabase.html.twig', array(
            'form' => $form->createView(),
            'stateIndex' => $stateIndex
        ));
    }

    public function searchIntoDatabaseAction(Request $request)
    {
        $searchParameters = json_decode($request->get('searchParameters'));
        $sortCode = json_decode($request->get('sortCode'));

        $repository = $this
          ->getDoctrine()
          ->getManager()
          ->getRepository('GSMailerBundle:ProspeMail')
        ;

        $search = $searchParameters->search;
        $advancedSearch = $searchParameters->advancedSearch;
        $recipientEmailPattern = $searchParameters->recipientEmail;
        $fromPattern = $searchParameters->from;
        $datePattern = $searchParameters->date;
        $sortByState = $searchParameters->sortByState;
        $idState = $searchParameters->stateId;

        if($advancedSearch){
            $listMails = $repository->findByLikeAdvanced($recipientEmailPattern, $fromPattern, $datePattern, $sortByState, $idState, $sortCode);
        }
        else {
            $listMails = $repository->findByLike($search, $sortCode);//findBy(array(), array('name' => 'ASC'));
        }

        $resultList = [];

        foreach ($listMails as $mail) {
            //Récupération des paramètres non nulls
            // $state = null;
            // if($mail->getState() != null){
            //     $state = $mail->getState()->getName();
            // }

             array_push($resultList, array(
                 "id" => $mail->getId(),
                "recipientEmail" => $mail->getMail() == null ? "Aucun destinataire" : $mail->getMail()->getRecipientEmail(),
                "userFirstName" => $mail->getUser() == null ? null : $mail->getUser()->getFirstName(),
                "userLastName" => $mail->getUser() == null ? null : $mail->getUser()->getLastName(),
                "sentAt" => $mail->getMail() == null ? null : ($mail->getMail()->getSentDate() == null ? null : $mail->getMail()->getSentDate()->format('d M Y  à  H:i')),
                "scheduledDate" => $mail->getMail() == null ? null : ($mail->getMail()->getScheduledDate() == null ? null : $mail->getMail()->getScheduledDate()->format('d M Y  à  H:i')),
                "state" =>  $mail->getState() == null ? null : $mail->getState()->getName()
            ));
        }

        return new JsonResponse(array('mailList' => json_encode($resultList)));
    }

    public function showMailDetailsAction($id)
    {
        $repository = $this
          ->getDoctrine()
          ->getManager()
          ->getRepository('GSMailerBundle:Mail')
        ;

        $mail = $repository->find($id);

        if (null === $mail) {
          throw new NotFoundHttpException("Le mail d'id ".$id." n'existe pas.");
        }

        return $this->render('GSMailerBundle::prospeMailDetails.html.twig', array(
            'mail' => $mail,
        ));
    }

    public function loadMailSessionAction(Request $request, SessionInterface $session)
    {
        $id = $session->getId();

        $mailList = $session->get($id.'mailSaving_mailList');
        $object = $session->get($id.'mailSaving_object');
        $company = $session->get($id.'mailSaving_company');
        $sendAsId = $session->get($id.'mailSaving_sendAsId');

        if($mailList == null){
            $mailList = [];
        }

        return new JsonResponse(array(
            "mailList" => json_encode($mailList),
            "object" => $object,
            "company" => $company,
            "sendAsId" => $sendAsId
        ));

    }

    public function loadUserAction($id)
    {
        $repository = $this
          ->getDoctrine()
          ->getManager()
          ->getRepository('GSUserBundle:User')
        ;

        $user = $repository->find($id);

        $postName = 'Directeur Commercial';
        $firstName = '';
        $lastName = '';
        $phone = '';
        if ($user->getPost() != null) {
            $postName = $user->getPost()->getName();
        }
        if ($user->getFirstName() != null) {
            $firstName = $user->getFirstName();
        }
        if ($user->getLastName() != null) {
            $lastName = $user->getLastName();
        }
        if ($user->getPhone() != null) {
            $phone = $user->getPhone();
        }


        // return new JsonResponse(json_encode(get_object_vars($user)));
        return new JsonResponse(json_encode(array(
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'firstName' => $firstName,
            'lastName' =>$lastName,
            'phone' => $phone,
            'postName' => $postName,
        )));

    }

    public function saveMailSessionAction(Request $request, SessionInterface $session)
    {
        $mailList = $request->get('mailList');
        $object = $request->get('object');
        $company = $request->get('company');
        $sendAsId = $request->get('sendAsId');

        $id = $session->getId();

        $session->set($id.'mailSaving_mailList', json_decode($mailList));
        $session->set($id.'mailSaving_object', $object);
        $session->set($id.'mailSaving_company', $company);
        $session->set($id.'mailSaving_sendAsId', $sendAsId);

        $response = new Response();
        $response->setStatusCode(200);

        return $response;
    }

    public function updateStateMailAction(Request $request)
    {
        $id = $request->get('id');
        $id_state = $request->get('id_state');

        $em = $this
          ->getDoctrine()
          ->getManager();

        $repoMail = $em->getRepository('GSMailerBundle:ProspeMail');
        $repoState = $em->getRepository('GSMailerBundle:State');

        $mail = $repoMail->find($id);
        $state = $repoState->find($id_state);

        $em->persist($mail);
        $mail->setState($state);
        $em->flush();

        return new JsonResponse();
    }

    public function addProspeMailManuallyAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $session = $request->getSession();

        $prospeMail = new ProspeMail();

        $form   = $this->createForm(ProspeMailType::class, $prospeMail, array(
            "artificial" => true,
            "sendAsUsers" => null
        ));//, array('user' => $this->getUser()));

        if ($request->isMethod('POST')){
            $form->handleRequest($request);
            if($form->get('Ajouter')->isClicked() && $form->isValid()){
                $prospeMail->getMail()->setArtificial(true);
                $prospeMail->setUser($this->getUser());
                $em->persist($prospeMail);
                $em->flush();

                $session->getFlashBag()->add('success',  $prospeMail->getMail()->getRecipientEmail()." ajouté.");
            }
        }
        return $this->render("GSMailerBundle::prospeMailAdd.html.twig", array(
            "form" => $form->createView()
        ));
    }
}
