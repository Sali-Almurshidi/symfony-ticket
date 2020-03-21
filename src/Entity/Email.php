<?php


namespace App\Entity;


use Swift_Mailer;
use Swift_SmtpTransport;

class Email
{
    private $senderEmail;
    private $receiverEmail;
    private $content;
    private $name;

    public function __construct(string $name, string $receiverEmail, string $senderEmail, string $content)
    {
        $this->senderEmail = $senderEmail;
        $this->receiverEmail = $receiverEmail;
        $this->content = $content;
        $this->name = $name;
    }

    public function sendEmail()
    {
        // Create the Transport
        $transport = new Swift_SmtpTransport('ticket.local', 3306);

        // Create the Mailer using your created Transport
        $mailer = new Swift_Mailer($transport);

        $message = (new \Swift_Message('Hello ' . $this->name))
            ->setFrom($this->senderEmail)
            ->setTo($this->receiverEmail)
            ->setBody($this->content);


        $mailer->send($message);
    }
}