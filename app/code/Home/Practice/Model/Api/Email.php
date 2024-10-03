<?php
namespace Home\Practice\Model\Api;

use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\App\Area;
use Magento\Framework\Exception\MailException;

class Email
{
    protected $transportBuilder;
    protected $inlineTranslation;
    protected $storeManager;

    public function __construct(
        TransportBuilder $transportBuilder,
        StateInterface $inlineTranslation,
        StoreManagerInterface $storeManager
    ) {
        $this->transportBuilder = $transportBuilder;
        $this->inlineTranslation = $inlineTranslation;
        $this->storeManager = $storeManager;
    }

    /**
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function sendEmail($email, $subject, $name, $phone, $message)
    {
        try {
// Disable inline translation while sending the email
            $this->inlineTranslation->suspend();

// Prepare email template variables
            $transport = $this->transportBuilder
                ->setTemplateIdentifier('3') // Use a blank template or existing one
                ->setTemplateOptions([
                    'area' => Area::AREA_FRONTEND,
                    'store' => $this->storeManager->getStore()->getId(),
                ])
                ->setTemplateVars([
                    'subject' => $subject, // Pass subject as a variable
                    'name' => $name ,// Pass body content as a variable
                    'email' => $email, // Pass body content as a variable
                    'phone' => $phone, // Pass body content as a variable
                    'message' => $message // Pass body content as a variable
                ])
                ->setFrom('general') // Sender details
                ->addTo($email) // Recipient email
                ->getTransport();

// Send the email
            $transport->sendMessage();

// Re-enable inline translation after sending
            $this->inlineTranslation->resume();

            return 'Email sent successfully';
        } catch (MailException $e) {
            throw new \Magento\Framework\Exception\LocalizedException(
                __('Unable to send email: %1', $e->getMessage())
            );
        }
    }
}
