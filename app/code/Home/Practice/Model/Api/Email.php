<?php
namespace Home\Practice\Model\Api;

use Magento\Framework\App\Helper\Context;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Framework\Escaper;
use Magento\Framework\Mail\Template\TransportBuilder;


class Email
{
//    protected $inlineTranslation;
//    protected $escaper;
//    protected $transportBuilder;
//    protected $logger;
//
//    public function __construct(
//        Context $context,
//        StateInterface $inlineTranslation,
//        Escaper $escaper,
//        TransportBuilder $transportBuilder
//    ) {
//        parent::__construct($context);
//        $this->inlineTranslation = $inlineTranslation;
//        $this->escaper = $escaper;
//        $this->transportBuilder = $transportBuilder;
//        $this->logger = $context->getLogger();
//    }

    public function sendEmail($email, $subject, $message)
    {

        $from = 'hammad.idrees@ki5.co.uk';

        try {
            $emaill = new \Zend_Mail();
            $emaill->setSubject($subject);
            $emaill->setBodyText($message);
            $emaill->setFrom($from, 'Hammad');
            $emaill->addTo($email, 'Hammad');
            $emaill->send();
            return 'Email sent successfully';
        } catch (\Exception $e) {
            return 'Email nott sent';
            $this->logger->debug($e->getMessage());
        }
    }
}
