<?php
namespace Home\Practice\Api;

interface EmailInterface
{
    /**
     * @param string $email
     * @param string $subject
     * @param string $name
     * @param int $phone
     * @param string $message
     * @return string
     */
    public function sendEmail($email, $subject, $name, $phone, $message);
}
?>
