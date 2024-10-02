<?php
namespace Home\Practice\Controller\Order;

use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Home\Practice\Model\Api\ShipmentClass;

class GenerateShipment extends \Magento\Framework\App\Action\Action
{
    protected $shipmentClass;
    protected $resultJsonFactory;

    public function __construct(
        Context $context,
        ShipmentClass $shipmentClass,
        JsonFactory $resultJsonFactory
    ) {
        $this->shipmentClass = $shipmentClass;
        $this->resultJsonFactory = $resultJsonFactory;
        parent::__construct($context);
    }

    public function execute()
    {

        $orderId = $this->getRequest()->getParam('order_id');

        // Call the method in InvoiceClass to generate the invoice
        $result = $this->shipmentClass->createShipment($orderId);

        $resultJson = $this->resultJsonFactory->create();
        return $resultJson->setData(['success' => true, 'message' => $result]);
    }
}
