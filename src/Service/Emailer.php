<?php

namespace App\Service;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class Emailer
{
    private $entityManager;
    private $mailer;

    public function __construct(EntityManagerInterface $entityManager, MailerInterface $mailer) {
        $this->entityManager = $entityManager;
        $this->mailer = $mailer;
    }

    public function sendEmail(string $application, User $user, string $toAddress)
    {
        $card = $this->entityManager->getRepository('App:Card')->findOneBy(['application'=>$application]);
        $email = (new TemplatedEmail())
            ->from('scdirector@uga.edu')
            ->to($toAddress)
            ->bcc('scdirector@uga.edu')
            ->subject($card->getTitle())
            ->htmlTemplate("email/content.html.twig")
            ->context([
                'user' => $user,
                'card' => $card,

            ]);
        $this->mailer->send($email);
    }


}