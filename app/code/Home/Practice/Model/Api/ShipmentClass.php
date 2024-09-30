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
    
        // Use convertOrder to create a shipment from the order
        $orderShipment = $this->convertOrder->toShipment($order); 
    
        foreach ($order->getAllItems() as $orderItem) {
            // Check virtual item and item Quantity
            if (!$orderItem->getQtyToShip() || $orderItem->getIsVirtual()) {
                continue;
            }
    
            $qty = $orderItem->getQtyToShip();
            $shipmentItem = $this->convertOrder->itemToShipmentItem($orderItem)->setQty($qty);
            $orderShipment->addItem($shipmentItem);
        }
    
        $orderShipment->register();
        $orderShipment->getOrder()->setIsInProcess(true);
    
        // Save created Order Shipment
        $orderShipment->save();
        $orderShipment->getOrder()->save();
    
        // Return shipment details as an array or JSON
        return $this->formatShipmentResponse($orderShipment);
    }
    
    protected function formatShipmentResponse($orderShipment)
    {
        // Format shipment data into an array for response
        return [
            'shipment_id' => $orderShipment->getId(),
            'order_id' => $orderShipment->getOrder()->getId(),
            'shipment_status' => $orderShipment->getShipmentStatus(),
            'items' => array_map(function($item) {
                return [
                    'item_id' => $item->getId(),
                    'name' => $item->getName(),
                    'quantity' => $item->getQty(),
                ];
            }, $orderShipment->getAllItems())
        ];
    }
    
}
