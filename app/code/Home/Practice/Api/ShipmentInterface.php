<?php
namespace Home\Practice\Api;

interface ShipmentInterface
{
    /**
     * Create an invoice for an order
     * 
     * @param int $orderId
     * @return array
     */
    public function createShipment($orderId);
}
