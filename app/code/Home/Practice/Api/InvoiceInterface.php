<?php
namespace Home\Practice\Api;

interface InvoiceInterface
{
    /**
     * Create an invoice for an order
     * 
     * @param int $orderId
     * @return array
     */
    public function createInvoice($orderId);
}
