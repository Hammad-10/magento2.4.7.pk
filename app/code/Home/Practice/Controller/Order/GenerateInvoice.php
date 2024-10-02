<?php
namespace Home\Practice\Controller\Order;

use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Home\Practice\Model\Api\InvoiceClass;

class GenerateInvoice extends \Magento\Framework\App\Action\Action
{
    protected $invoiceClass;
    protected $resultJsonFactory;

    public function __construct(
        Context $context,
        InvoiceClass $invoiceClass,
        JsonFactory $resultJsonFactory
    ) {
        $this->invoiceClass = $invoiceClass;
        $this->resultJsonFactory = $resultJsonFactory;
        parent::__construct($context);
    }

    public function execute()
    {

        $orderId = $this->getRequest()->getParam('order_id');

        // Call the method in InvoiceClass to generate the invoice
        $result = $this->invoiceClass->createInvoice($orderId);

        $resultJson = $this->resultJsonFactory->create();
        return $resultJson->setData(['success' => true, 'message' => $result]);
    }
}
