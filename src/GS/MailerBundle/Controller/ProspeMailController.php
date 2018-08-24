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

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProspeMailController extends Controller
{
    public function writeProspeMailAction()
    {
        $repository = $this
          ->getDoctrine()
          ->getManager()
          ->getRepository('GSUserBundle:User')
        ;

        $user = $this->getUser();
        $sendAsUsers = $repository->findByPostName('Directeur Commercial');
        array_push($sendAsUsers, $user);


        $form = $this->createForm(ProspeMailType::class, new ProspeMail(), array(
            'artificial' => false,
            'sendAsUsers' => $sendAsUsers
        ));

        return $this->render('GSMailerBundle::prospeMailEdit.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function addProspeMailAction(Request $request)
    {
        $session = $request->getSession();
        $em = $this->getDoctrine()->getManager();

        $repository = $this
          ->getDoctrine()
          ->getManager()
          ->getRepository('GSUserBundle:User')
        ;
        $user = $this->getUser();
        $sendAsUsers = $repository->findByPostName('Directeur Commercial');
        array_push($sendAsUsers, $user);

        $prospeMail = new ProspeMail();
        $form = $this->createForm(ProspeMailType::class, $prospeMail, array(
            'artificial' => false,
            'sendAsUsers' => $sendAsUsers
        ));
        if($request->isMethod('POST'))
        {
            $form->handleRequest($request);
            if($form->isValid())
            {
                $prospeMailList = $session->get('prospeMailList');
                $toggleDelayedInput = $form->get('toggleDelayedInput')->getData();
                if(!$toggleDelayedInput)// Un départ différé n'est pas demandé
                    $prospeMail->getMail()->setScheduledDate(null);

                $prospeMail->getMail()->setFromEmail("pontsetudesprojets.commercial@gmail.com");
                $prospeMail->getMail()->setAttachmentName("Plaquette commerciale PEP");
                $prospeMail->getMail()->setAttachmentPath("bundles/plaquette.pdf");
                $prospeMail->getMail()->setFromAlias($prospeMail->getSendAsUser()->getFirstName()." ".$prospeMail->getSendAsUser()->getLastName());
                // $prospeMail = $em->merge($prospeMail);
                $prospeMail->getMail()->setContent($this->getHtml($prospeMail));

                $red_content = $this->presentMailContent($prospeMail);
                //verify prospe mail
                //send result of verification
                $repo = $em->getRepository('GSMailerBundle:ProspeMail');
                $duplicatedProspeMail = $repo->findByRecipientEmail($prospeMail->getMail()->getRecipientEmail());
                $duplicatedInfos = array();
                for ($i=0; $i < count($duplicatedProspeMail); $i++) {
                    array_push($duplicatedInfos, array(
                        "prospeMail" => $duplicatedProspeMail[$i],
                        "red_content" => $this->presentMailContent($duplicatedProspeMail[$i])
                    ));
                }


                $pseudo_id = 0;
                if($prospeMailList==null)
                    $prospeMailList = array(array("pseudo_id" => $pseudo_id,
                                                "mail" => $prospeMail,
                                                "red_content" => $red_content,
                                                "duplicatedInfos" => $duplicatedInfos
                                                ));
                else{
                    $pseudo_id = $prospeMailList[count($prospeMailList)-1]["pseudo_id"]+1;
                    array_push($prospeMailList, array("pseudo_id" => $pseudo_id,
                                                "mail" => $prospeMail,
                                                "red_content" => $red_content,
                                                "duplicatedInfos" => $duplicatedInfos
                                            ));
                }
                $session->set('prospeMailList', $prospeMailList);


                return new JsonResponse(array("newProspeMail" => json_encode($prospeMail),
                        "duplicatedInfos" => json_encode($duplicatedInfos),
                        "pseudo_id" => $pseudo_id,
                        "red_content" => $red_content
                ));
            }
        }

        return new JsonResponse();
    }

    public function loadProspeMailAction(Request $request)
    {
        $unitOfWork = $this
          ->getDoctrine()
          ->getManager()
          ->getUnitOfWork();
        // $isFlushedToDb = !$unitOfWork->isEntityScheduled($entity);
        $session = $request->getSession();
        $prospeMailList = $session->get('prospeMailList');
        $responseArray = array();
        for ($i=0; $i < count($prospeMailList); $i++) {
            array_push($responseArray, array("newProspeMail" => json_encode($prospeMailList[$i]['mail']),
                                            "duplicatedInfos" => json_encode($prospeMailList[$i]['duplicatedInfos']),
                                            "pseudo_id" => $prospeMailList[$i]['pseudo_id'],
                                            "red_content" => $prospeMailList[$i]['red_content'],
                                            "registered" => !$unitOfWork->isEntityScheduled($prospeMailList[$i]['mail'])
                                        ));
        }
        return new JsonResponse($responseArray);
    }

    public function removeProspeMailAction(Request $request)
    {
        $session = $request->getSession();
        $pseudo_id = $request->get('pseudo_id');
        $prospeMailList = $session->get('prospeMailList');
        $tempArray = array();
        for($i=0; $i<count($prospeMailList); $i++){
            if($prospeMailList[$i]['pseudo_id'] != $pseudo_id)
                array_push($tempArray, $prospeMailList[$i]);
        }
        $session->set('prospeMailList', $tempArray);
        return new JsonResponse();
    }

    public function sendProspeMailAction(Request $request)
    {
        $session = $request->getSession();
        $em = $this->getDoctrine()->getManager();
        $mailManager = $this->container->get('gs_mail.mail_manager');
        $pseudo_id = $request->get('pseudo_id');
        $prospeMailList = $session->get('prospeMailList');
        for($i=0; $i<count($prospeMailList); $i++){
            if($prospeMailList[$i]['pseudo_id'] == $pseudo_id){
                $prospeMail = $prospeMailList[$i]['mail'];
                $prospeMail->setUser($this->getUser());
                $prospeMail = $em->merge($prospeMail);

                // throw new NotFoundHttpException(":".json_encode($prospeMail));
                $sent = $mailManager->prepareSend($prospeMail->getMail());
                $prospeMail = $em->merge($prospeMail);
                $em->flush();
                break;
            }
        }

        return new JsonResponse(array("pseudo_id" => $pseudo_id,
                                    "registered" => true,
                                    "sent" => $prospeMail->getMail()->getSentDate() != null,
                                    'scheduled' => $prospeMail->getMail()->getScheduledDate() != null
                                ));
    }

    public function getSpecializationString($prospeMail)
    {
        $specializationArray = $prospeMail->getSpecialization();
        if($specializationArray == null)
            return "";
        if(count($specializationArray)==1)
            return $specializationArray[0]->getName();
        else {
            $string = "";
            for($i=0; $i<count($specializationArray); $i++){
                $string = $string.$specializationArray[$i]->getName();
                if($i < count($specializationArray)-2)
                    $string = $string.", en ";
                else if($i == count($specializationArray)-2)
                    $string = $string." et en ";
            }
            return $string;
        }
    }

    public function getSignature($user)
    {
        if($user == null)
            return "";
        return '<table style="width: 509px; background-color: #fdfdfd;" class="mceItemTable" cellspacing="5" cellpadding="0" border="0" align="left" height="130">'.
        '<tbody>'.
        '<tr>'.
        '<td style="text-align: center; width: 150px;">'.
        '<div style="text-align: center;"><a href="http://pep.enpc.org"><img moz-do-not-send="false" src="https://pbs.twimg.com/profile_images/580072788721008640/YT4GZ0RK.png" width="100" height="100" /></a></div>'.
        '<div style="text-align: center;"><a href="https://www.facebook.com/pontsetudespro/"><img moz-do-not-send="false" src="http://s2.googleusercontent.com/s2/favicons?domain_url=http://facebook.com" width="16" height="16" /></a>&nbsp;&nbsp;'.
            '<a href="https://twitter.com/pontsetudes"><img moz-do-not-send="false" src="http://s2.googleusercontent.com/s2/favicons?domain_url=http://twitter.com" width="16" height="16" /></a>&nbsp;&nbsp;'.
            '<a href="https://www.linkedin.com/company-beta/423587/"><img moz-do-not-send="false" src="http://s2.googleusercontent.com/s2/favicons?domain_url=www.linkedin.com" width="16" height="16" /></a></div>'.
        '</td>'.
        '<td>'.
        '<div><span style="font-size: 12pt;"><strong><strong><span style="font-family: \'trebuchet ms\', sans-serif;">'.$user->getFirstName()." ".$user->getLastName().'</span></strong></strong></span><hr /><span style="font-size: xx-small;"><strong><span style="font-family: \'trebuchet ms\', sans-serif;"></span></strong></span></div>'.
        '<div><span style="font-family: \'trebuchet ms\' , sans-serif; font-size: small; color: #404040;"><b>'.($user->getPost() == null ? "": $user->getPost()->getName()).'</b>&nbsp;chez</span><span style="color: #404040; font-family: \'trebuchet ms\', sans-serif; font-size: small;">&nbsp;Ponts Etudes Projets,</span></div>'.
        '<div><span style="font-family: \'trebuchet ms\', sans-serif; font-size: x-small; color: #404040;">la Junior-Entreprise de l\'Ecole des Ponts ParisTech</span></div>'.
        '<div><span style="font-family: \'trebuchet ms\', sans-serif; font-size: x-small; color: #404040;">&nbsp;</span></div>'.
        '<div><span style="font-family: \'trebuchet ms\', sans-serif; font-size: small; color: #336699; background-color: #ffffff;">'.
            '<span class="Object" id="OBJ_PREFIX_DWT1173_com_zimbra_phone" style="cursor: pointer;">'.
                '<span style="cursor: pointer;">'.$user->getPhone().'&nbsp;&nbsp;&ndash;&nbsp;&nbsp;</span></span></span>'.
                '<span class="Object" id="OBJ_PREFIX_DWT166_com_zimbra_url" style="color: #336699; cursor: pointer;"><a href="https://zimbra.enpc.fr/pep.enpc.org" title="Site Web" target="_blank" style="color: #336699; text-decoration: none; cursor: pointer;"><span style="color: #8e3232;"><em>pep.enpc.org</em>'.
                '</span></a></span></div>'.
        '</td>'.
        '</tr>'.
        '</tbody>'.
        '</table>'
        ;
    }

    public function getHtml($prospeMail, $preview = false)
    {
        $string = "";
        if($preview){
            $title = $prospeMail->getGender() == null ? "" : '<b style="color: red;">'.$prospeMail->getGender()->getName()."</b>";
            $name = ($prospeMail->getRecipientName() == "" || $prospeMail->getRecipientName() == null ) ? "" : '<b style="color: red;">'.$prospeMail->getRecipientName().'</b>';
            $company = '<b style="color: red;">'.$prospeMail->getCompany().'</b>';
            $specialization = '<b style="color: red;">'.$this->getSpecializationString($prospeMail).'</b>';
        }
        else {
            $title = $prospeMail->getGender() == null ? "" : $prospeMail->getGender()->getName();
            $name = ($prospeMail->getRecipientName() == "" || $prospeMail->getRecipientName() == null ) ? "" : $prospeMail->getRecipientName();
            $company = $prospeMail->getCompany();
            $specialization = $this->getSpecializationString($prospeMail);
        }

        if($title == "" && $name == "")
            $finalTitle = "";
        else if($name == "")
            $finalTitle = " ".$title;
        else if($title != "")
            $finalTitle = " ".$title." ".$name;
        else
            $finalTitle = "";

            return 'Bonjour'.$finalTitle.','.
                        '<br><br>'.
                            'Je suis Responsable Commercial de Ponts Etudes et Projets, la Junior Entreprise de l’école d’ingénieur des Ponts et Chaussées. Je me permets de vous contacter car <b>notre association s’occupe de faire réaliser des projets dispensés par des entreprises par les étudiants de notre école.</b>'.
                        '<br><br>'.
                            'Nous serions très intéressés pour travailler avec le groupe '.$company.'. En effet, de par nos spécialisations poussées en '.$specialization.', nous pensons avoir des projets à vous proposer qui pourraient vous intéresser.'.
                        '<br><br>'.
                            'Je souhaite donc savoir quand vous êtes disponible afin que je puisse succinctement vous contacter pour vous présenter plus en détail notre Junior Entreprise et les projets que nous réalisons.'.
                        '<br><br>'.
                'Dans l’attente de votre retour,'.
                '<br>Cordialement,<br><br>'.$this->getSignature($prospeMail->getSendAsUser());

    }

    public function presentMailContent($prospeMail)
    {
        if($prospeMail->getMail() == null)
            return $this->getHtml($prospeMail, true);
        $mail = $prospeMail->getMail();
        if($mail->getArtificial())
            return "Entrée ajoutée manuellement par ".$prospeMail->getUser()->getFirstName().' '.$prospeMail->getUser()->getLastName()." le ".$prospeMail->getCreationDate()->format('d M Y  à  H:i')
            .". D'après les informations renseignées, le mail a été envoyé le ".$mail->getSentDate()->format('d M Y  à  H:i')."<br>";
        return "<div class='row'><div class='col-md-12'>".
        "De : ".$mail->getFromAlias()." (".$mail->getFromEmail().")<br>".
        "À : ".$prospeMail->getRecipientName()." (".$mail->getRecipientEmail().")<br>".
        "Objet : ".
        (($mail->getSubject() == "") ? "<b style='color: red;'>Aucun objet !</b><br>" : $mail->getSubject().'<br>').
        (($mail->getScheduledDate() == null) ? "" : "<b style='color: orange'>Envoi programmé le ".$mail->getScheduledDate()->format('d M Y  à  H:i')).'</b>'.
        "<br><hr><br>".$this->getHtml($prospeMail, true)."</div></div><br><br>";
    }
}
