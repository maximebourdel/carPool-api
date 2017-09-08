<?php

namespace MainBundle\Service\Mailer;
 
use SymfonyBundleFrameworkBundleCommandContainerAwareCommand;
use SymfonyComponentConsoleInputInputInterface;
use SymfonyComponentConsoleOutputOutputInterface;
 
class CronCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
                ->setname('uranie:cron')
                ->setDescription('Exécute les crons');
    }
 
    public function execute(InputInterface $input, OutputInterface $output)
    {
 
     // Du fait qu'il y est un spool de mail en mémoire définit dans le fichier de config et que ce spool est uber pratique dans le cadre des controller
        // On force l'envoie des mails du spool avec le code-ci dessous
        /* @var $mailer Swift_Mailer */
        $mailer = $this->getContainer()->get('mailer');
 
        $transport = $mailer->getTransport();
        if ($transport instanceof Swift_Transport_SpoolTransport) {
            $spool = $transport->getSpool();
            $sent = $spool->flushQueue($this->getContainer()->get('swiftmailer.transport.real'));
        }
    }
}