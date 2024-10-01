<?php
namespace Home\Practice\Api;

interface EmailInterface
{
    /**
     * @param string $email
     * @param string $subject
     * @param string $message
     * @return string
     */
    public function sendEmail($email, $subject, $message);
}
?>