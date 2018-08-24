<?php

namespace GS\MailBundle\Command;

// use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\ORM\EntityManagerInterface;

use GS\MailerBundle\Entity\ProspeMail;
use GS\MailBundle\Entity\Mail;


class UpdateOldMailsCommand extends Command
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName("mail:update-old-mails")
            ->setDescription("Convert old mail structure to a new one")
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("Start");

        $em = $this->em;
        $oldRepo = $em->getRepository('GSMailerBundle:Mail');
        $repoProspeMail = $em->getRepository('GSMailerBundle:ProspeMail');
        $repoMail = $em->getRepository('GSMailBundle:Mail');

        $oldMails = $oldRepo->findAll();

        $output->writeln("Start foreach");

        foreach ($oldMails as $oldMail) {
            $prospeMail = new ProspeMail();
            $mail = new Mail();

            $mail->setRecipientEmail($oldMail->getRecipientEmail());
            $mail->setFromEmail($oldMail->getFromEmail());
            $mail->setFromAlias($oldMail->getFromAlias());
            $mail->setReplyToEmail();
            $mail->setSubject($oldMail->getObject());
            $mail->setContent($oldMail->getContent());
            $mail->setCreationDate($oldMail->getCreationDate());
            $mail->setSentDate($oldMail->getSentAt());
            $mail->setAttachmentPath('bundles/plaquette.pdf');
            $mail->setAttachmentName('Plaquette commerciale PEP');
            $mail->setArtificial();

            $prospeMail->setCreationDate($oldMail->getCreationDate());
            $prospeMail->setUser($oldMail->getUser());
            $prospeMail->setSendAsUser($oldMail->getUser());
            $prospeMail->setState($oldMail->getState());
            $prospeMail->setRecipientName();
            $prospeMail->setGender();
            $prospeMail->setCompany();
            $prospeMail->setMail($mail);

            $em->persist($prospeMail);
            $output->writeln($mail->getRecipientEmail());
        }
        $output->writeln("End foreach");
        $em->flush();
        $output->writeln("End");

    }
}
