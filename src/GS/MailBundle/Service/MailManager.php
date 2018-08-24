<?php
namespace GS\MailBundle\Service;

use Doctrine\ORM\EntityManager;
use GS\MailBundle\Entity\Mail;

class MailManager
{
    private $mailer;
    private $entityManager;


    public function __construct(\Swift_Mailer $mailer, EntityManager $entityManager)
    {
        $this->mailer = $mailer;
        $this->entityManager = $entityManager;
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

}
