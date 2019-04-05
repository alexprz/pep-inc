<?php

namespace GS\MailBundle\Command;

// use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\ORM\EntityManagerInterface;

use GS\MailerBundle\Entity\ProspeMail;
use GS\MailBundle\Entity\Mail;


class UpdateProspeMailCommand extends Command
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName("mail:update-prospe-mail")
            ->setDescription("Update fields based on content")
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("Start");

        $em = $this->em;
        $repoProspeMail = $em->getRepository('GSMailerBundle:ProspeMail');
        $repoGender = $em->getRepository('GSMailerBundle:Gender');
        $monsieur = $repoGender->findByName('Monsieur')[0];
        $madame = $repoGender->findByName('Madame')[0];
        $repoSpecialization = $em->getRepository('GSMailerBundle:Specialization');
        $GMM = $repoSpecialization->findByName('Génie Mécanique')[0];
        $GCC = $repoSpecialization->findByName('Génie Civil')[0];
        $VET = $repoSpecialization->findByName('Énergie, Transports et Urbanisme')[0];
        $SEGF = $repoSpecialization->findByName('Stratégie, Finance et Économie')[0];
        $GI = $repoSpecialization->findByName('Génie Industriel et Marketing')[0];
        $IMI = $repoSpecialization->findByName('Informatique')[0];
        $TRA = $repoSpecialization->findByName('Traduction technique')[0];

        $prospeMailList = $repoProspeMail->findAll();

        $output->writeln("Start foreach");

        foreach ($prospeMailList as $prospeMail) {
            $output->writeln("-------------------START ".$prospeMail->getId().'---------------');


            if($prospeMail->getMail() ==  null)
                continue;

            if(count($prospeMail->getSpecialization())>0){
                $output->writeln("////////////////AVOIDED ".$prospeMail->getId().'////////////////////');
                continue;
            }

            $content = $prospeMail->getMail()->getContent();

            if(strpos($content, 'Monsieur') !== false){
                $prospeMail->setGender($monsieur);
                $output->writeln("Set monsieur");
            }
            else if(strpos($content, 'Madame') !== false){
                $prospeMail->setGender($madame);
                $output->writeln("Set madame");
            }

            if(strpos($content, 'Génie Mécanique') !== false){
                $prospeMail->addSpecialization($GMM);
                $output->writeln("Set GMM");
            }
            if(strpos($content, 'Génie Civil') !== false){
                $prospeMail->addSpecialization($GCC);
                $output->writeln("Set GCC");
            }
            if(strpos($content, 'Énergie, Transports et Urbanisme') !== false){
                $prospeMail->addSpecialization($VET);
                $output->writeln("Set VET");
            }
            if(strpos($content, 'Stratégie, Finance et Économie') !== false){
                $prospeMail->addSpecialization($SEGF);
                $output->writeln("Set SEGF");
            }
            if(strpos($content, 'Génie Industriel et Marketing') !== false){
                $prospeMail->addSpecialization($GI);
                $output->writeln("Set GI");
            }
            if(strpos($content, 'Informatique') !== false){
                $prospeMail->addSpecialization($IMI);
                $output->writeln("Set IMI");
            }
            if(strpos($content, 'Traduction technique') !== false){
                $prospeMail->addSpecialization($TRA);
                $output->writeln("Set TRA");
            }


            $em->persist($prospeMail);
        }
        $output->writeln("End foreach");
        $em->flush();
        $output->writeln("End");

    }
}
