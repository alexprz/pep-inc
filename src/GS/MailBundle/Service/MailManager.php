<?php
namespace GS\MailBundle\Service;

use Doctrine\ORM\EntityManager;
use GS\MailBundle\Entity\Mail;
use Twig_Environment as Environment;

use GS\BillBundle\Entity\Bill;
use GS\BillBundle\Entity\BillMail;

class MailManager
{
    private $mailer;
    private $entityManager;
    private $twig;


    public function __construct(\Swift_Mailer $mailer, EntityManager $entityManager, Environment $twig)
    {
        $this->mailer = $mailer;
        $this->entityManager = $entityManager;
        $this->twig = $twig;
    }

    public function prepareSend($mail)
    {
        $em = $this->entityManager;

        // Si aucun destinataires : erreur
        if($mail->getRecipientEmail() == null)
            return false;

        if($mail->getScheduledDate() == null) // Envoi immédiat
        {
            $sent = $this->send($mail);
            // if($sent)
            //     $mail->setSentDate(new \DateTime("now", new \DateTimeZone("EUROPE/Paris")));
        }

        $em->persist($mail);
        $em->flush();

        return true;
    }

    public function send($mail)
    {
        $recipientEmail = $mail->getRecipientEmail();
        $fromEmail = $mail->getFromEmail();
        $fromAlias = $mail->getFromAlias();
        $replyToEmail = $mail->getReplyToEmail();
        $subject = $mail->getSubject();
        $content = $mail->getContent();
        $plainText = $mail->getPlainText();
        $attachmentPath = $mail->getAttachmentPath();
        $attachmentName = $mail->getAttachmentName();

        if($fromEmail == null)
            $fromEmail = "noreply@pep.com";
        if($fromAlias == null)
            $fromAlias = "PEP";

        // Si aucun destinataires : erreur
        if($recipientEmail == null)
            return false;

        // Prépare le message
        $message = (new \Swift_Message($subject))
            ->setFrom([$fromEmail => $fromAlias])
            ->setTo($recipientEmail)
            ->setBody($content)
        ;

        if($replyToEmail != null)
            $message->setReplyTo($replyToEmail);

        if($plainText != null && $plainText)
            $message->setContentType('text/plain');
        else
            $message->setContentType('text/html');

        if($attachmentPath != null)
            $message->attach(\Swift_Attachment::fromPath($attachmentPath)->setFilename($attachmentName));

        $mailer = $this->mailer;

        $sent = $mailer->send($message);

        if($sent)
            $mail->setSentDate(new \DateTime("now", new \DateTimeZone("EUROPE/Paris")));
        else
            $mail->setError(true);

        return $sent;
    }

    public function sendPendingMails()
    {
        $em = $this->entityManager;

        $mailList = $em->getRepository("GSMailBundle:Mail")->getMailsToSend();

        foreach ($mailList as $mail) {
            $em->persist($mail);
            $this->send($mail);
        }
        $em->flush();
    }

    public function checkTreasury()
    {
        $em = $this->entityManager;

        $billList = $em->getRepository("GSBillBundle:Bill")->findUnpaid();
        $todayDate = new \DateTime("now", new \DateTimeZone("EUROPE/Paris"));
        $treasurer = $em->getRepository('GSUserBundle:User')->findCurrentTreasurer();

        foreach ($billList as $bill) {
            $dueDate = $bill->getDueDate();
            $interval = $dueDate->diff($todayDate);

            $mailPerso = new Mail();
            $mailTrez = new Mail();

            $billMailPerso = new BillMail();
            $billMailTrez = new BillMail();

            $billMailPerso->setMail($mailPerso);
            $billMailTrez->setMail($mailTrez);

            $twig = $this->twig;

            $mailPerso->setRecipientEmail($bill->getMail());
            if($treasurer != null)
                $mailTrez->setRecipientEmail($treasurer->getEmail());

            $parameters  = array('bill' => $bill,
                'mailPerso' => $mailPerso->getRecipientEmail(),
                'mailTrez' => $mailTrez->getRecipientEmail()
            );

            // Arrivé à la date d'échéance
            if($dueDate->format('Y-m-d') == $todayDate->format('Y-m-d'))
            {
                if($bill->isMemberBill()){
                    $template = $twig->loadTemplate('@GSMailBundle/Resources/views/mail_templates/late-treasury-member-1.twig');
                    // $mailPerso->setAttachmentPath('bundles/rib.pdf');
                }
                else
                    $template = $twig->loadTemplate('@GSMailBundle/Resources/views/mail_templates/late-treasury-1.twig');
                $subject  = $template->renderBlock('subject',   $parameters);
                $body = $template->renderBlock('body', $parameters);

                $mailPerso->setSubject($subject);
                $mailPerso->setContent($body);
                $mailTrez->setSubject($subject);
                $mailTrez->setContent($body);

                $this->send($mailPerso);
                $this->send($mailTrez);

                $em->persist($billMailPerso);
                $em->persist($billMailTrez);
                $em->flush();
            }
            // Arrivée à la date d'échéance + 15j
            else if($dueDate->modify('+15 days')->format('Y-m-d') == $todayDate->format('Y-m-d'))
            {
                if($bill->isMemberBill()){
                    $template = $twig->loadTemplate('@GSMailBundle/Resources/views/mail_templates/late-treasury-member-2.twig');
                    // $mailPerso->setAttachmentPath('bundles/rib.pdf');
                }
                else
                    $template = $twig->loadTemplate('@GSMailBundle/Resources/views/mail_templates/late-treasury-2.twig');
                $subject  = $template->renderBlock('subject',   $parameters);
                $body = $template->renderBlock('body', $parameters);

                $mailPerso->setSubject($subject);
                $mailPerso->setContent($body);
                $mailTrez->setSubject($subject);
                $mailTrez->setContent($body);

                $this->send($mailPerso);
                $this->send($mailTrez);

                $em->persist($billMailPerso);
                $em->persist($billMailTrez);
                $em->flush();
            }
            // Arrivée à la date d'échéance + 30j
            else if($dueDate->modify('+15 days')->format('Y-m-d') == $todayDate->format('Y-m-d'))
            {
                if($bill->isMemberBill()){
                    $template = $twig->loadTemplate('@GSMailBundle/Resources/views/mail_templates/late-treasury-member-3.twig');
                    // $mailPerso->setAttachmentPath('bundles/rib.pdf');
                }
                else
                    $template = $twig->loadTemplate('@GSMailBundle/Resources/views/mail_templates/late-treasury-3.twig');
                $subject  = $template->renderBlock('subject',   $parameters);
                $body = $template->renderBlock('body', $parameters);

                $mailTrez->setSubject($subject);
                $mailTrez->setContent($body);

                if($bill->isMemberBill()){
                    $this->send($mailPerso);
                    $em->persist($billMailPerso);
                }

                $this->send($mailTrez);
                $em->persist($billMailTrez);
                $em->flush();
            }



        }



    }

}
