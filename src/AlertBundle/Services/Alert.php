<?php

namespace AlertBundle\Services;


use Doctrine\ORM\EntityManager;
use Swift_Mailer;
use Swift_Message;

class Alert
{
    const USER_EMAIL = 'alexcm.14@gmail.com';

    private $mailer;
    private $entityManager;

    public function __construct(
        Swift_Mailer $aMailer,
        EntityManager $anEntityManager
    ) {
        $this->mailer        = $aMailer;
        $this->entityManager = $anEntityManager;
    }

    public function shouldAlert($recordEvent)
    {
        $post         = $recordEvent->getPost();
        $recordsCount = $this->recordsCount($post);

        if ($recordsCount == 10 || $recordsCount == 50 || $recordsCount == 100) {
            $this->sendAlert($post, $recordsCount);
        }
    }

    private function recordsCount($post)
    {
        $records = $this->entityManager
            ->getRepository('TrackerBundle\Entity\Record')
            ->findBy(['post' => $post]);

        return count($records);
    }

    private function sendAlert($post, $recordsCount)
    {
        $message = Swift_Message::newInstance()
            ->setSubject('Congratulations')
            ->setFrom('alexcm.14@gmail.com')
            ->setTo('alexcm.14@gmail.com')
            ->setBody('Visits alert:')
            ->addPart('Your post <b>' . $post->getTitle() . '</b> has reached <b>' . $recordsCount . ' visits.</b>',
                'text/html');

        $this->mailer->send($message);
    }
}