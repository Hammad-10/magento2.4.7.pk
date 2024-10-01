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

    public function sendEmail(?string $email, ?string $subject, ?string $message)
    {
        // Ensure email, subject, and message are provided
        if (empty($email) || empty($subject) || empty($message)) {
            return __('Email, subject, and message cannot be empty.');
        }

        try {
            // Prepare headers
            $headers = "From: owner@example.com\r\n"; // Replace with your sender email
            $headers .= "Reply-To: $email\r\n"; // Set the recipient email as Reply-To
            $headers .= "Content-type: text/html; charset=UTF-8\r\n"; // For HTML emails

            // Send email using PHP's mail function
            if (mail($email, $subject, $message, $headers)) {
                return __('Email sent successfully!');
            } else {
                return __('Email sending failed.');
            }
        } catch (\Exception $e) {
            // Log the error
            $this->logger->error('Error sending email: ' . $e->getMessage());
            return __('Error in sending email: %1', $e->getMessage());
        }
    }
}
