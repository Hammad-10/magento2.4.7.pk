<?php
namespace Home\Practice\Controller\Order;

use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Home\Practice\Model\Api\AllShipmentsClass;

class GenerateAllShipments extends \Magento\Framework\App\Action\Action
{
    protected $shipmentClass;
    protected $resultJsonFactory;

    public function __construct(
        Context $context,
        AllShipmentsClass $shipmentClass,
        JsonFactory $resultJsonFactory
    ) {
        $this->shipmentClass = $shipmentClass;
        $this->resultJsonFactory = $resultJsonFactory;
        parent::__construct($context);
    }

    public function execute()
    {

        // Call the method in AllShipmentsClass to generate the shipment
        $result = $this->shipmentClass->createAllShipments();

        $resultJson = $this->resultJsonFactory->create();
        return $resultJson->setData(['success' => true, 'message' => $result]);
    }
}
