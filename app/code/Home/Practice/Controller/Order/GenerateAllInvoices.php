<?php
namespace Home\Practice\Controller\Order;

use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Home\Practice\Model\Api\AllInvoicesClass;

class GenerateAllInvoices extends \Magento\Framework\App\Action\Action
{
    protected $invoiceClass;
    protected $resultJsonFactory;

    public function __construct(
        Context $context,
        AllInvoicesClass $invoiceClass,
        JsonFactory $resultJsonFactory
    ) {
        $this->invoiceClass = $invoiceClass;
        $this->resultJsonFactory = $resultJsonFactory;
        parent::__construct($context);
    }

    public function execute()
    {

        // Call the method in AllInvoiceClass to generate the invoices
        $result = $this->invoiceClass->createAllInvoices();

        $resultJson = $this->resultJsonFactory->create();
        return $resultJson->setData(['success' => true, 'message' => $result]);
    }
}
