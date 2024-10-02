<?php
namespace Home\Practice\Model\Api;

use Psr\Log\LoggerInterface;

class Email
{
    protected $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function sendEmail($email, $subject, $message)
    {
        $to = $email;
        $subjectt = $subject;
        $txt = $message;
        $headers = "From: idreeshammad579@gmail.com" . "\r\n" .
            "CC: idreeshammad579@gmail.com";


        if (mail($to,$subjectt,$txt,$headers))
        {
            return 'Email sent';
        }
        else{
            return 'Email not sent';
        }

    }
}
