<?php
namespace Home\Practice\Model\Api;

use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Sales\Model\Service\ShipmentService;
use Magento\Sales\Model\Convert\Order as ConvertOrder; // Add this line
use Magento\Framework\Exception\LocalizedException;

class ShipmentClass
{
    protected $orderRepository;  
    protected $convertOrder;     
    protected $shipmentNotifier;  
    protected $shipmentService;   

    public function __construct(
        OrderRepositoryInterface $orderRepository,
        ShipmentService $shipmentService,
        ConvertOrder $convertOrder // Include ConvertOrder in the constructor
    ) {
        $this->orderRepository = $orderRepository;
        $this->shipmentService = $shipmentService;  
        $this->convertOrder = $convertOrder; // Assign the convertOrder service
    }

    public function createShipment($orderId)
    {
        $order = $this->orderRepository->get($orderId);
    
        if (!$order instanceof \Magento\Sales\Model\Order) {
            throw new \Exception('Invalid order instance.');
        }
    
        if (!$order->canShip()) {
            throw new LocalizedException(
                __("You can't create the Shipment of this order.")
            );
        }
    
        $orderShipment = $this->convertOrder->toShipment($order);
    
        foreach ($order->getAllItems() as $orderItem) {
            if (!$orderItem->getQtyToShip() || $orderItem->getIsVirtual()) {
                continue;
            }
    
            $qty = $orderItem->getQtyToShip();
            $shipmentItem = $this->convertOrder->itemToShipmentItem($orderItem)->setQty($qty);
            $orderShipment->addItem($shipmentItem);
        }
    
        $orderShipment->register();
        $orderShipment->getOrder()->setIsInProcess(true);
    
        $orderShipment->save();
        $orderShipment->getOrder()->save();
    
        // Properly encode the response as JSON
        $response = [
            'Shipment ID' => $orderShipment->getId(),
            'Order ID' => $orderShipment->getOrder()->getId(),
            'Shipment Status' => $orderShipment->getShipmentStatus(),
            'Shipped Items' => $this->formatShipmentResponse($orderShipment)
        ];
    
        // Ensure the response is JSON encoded
        return json_encode($response, JSON_PRETTY_PRINT);
    }
    
    protected function formatShipmentResponse($orderShipment)
    {
        return array_map(function($item) {
            return [
                'Item ID' => $item->getId(),
                'Product Name' => $item->getName(),
                'Shipped Quantity' => $item->getQty(),
            ];
        }, $orderShipment->getAllItems());
    }
    
    
    
}
