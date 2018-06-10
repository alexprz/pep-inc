<?php

namespace GS\MailBundle\Command;

// use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use GS\MailBundle\Service\MailManager;

class SendPendingMailsCommand extends Command
{
    private $mailManager;

    public function __construct(MailManager $mailManager)
    {
        $this->mailManager = $mailManager;

        parent::__construct();
    }

    protected function configure()
    {
        $this->setName("mail:send-pending")
            ->setDescription("Check scheduled date of pending mails and send them if current date is bigger")
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->mailManager->sendPendingMails();
    }
}
