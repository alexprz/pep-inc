<?php

namespace GS\BillBundle\Command;

// use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use GS\MailBundle\Service\MailManager;

class CheckTreasuryCommand extends Command
{
    private $mailManager;

    public function __construct(MailManager $mailManager)
    {
        $this->mailManager = $mailManager;

        parent::__construct();
    }

    protected function configure()
    {
        $this->setName("mail:check-treasury")
            ->setDescription("Send reminders mails to treasury for late bill")
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->mailManager->checkTreasury();
    }
}
