<?php
namespace Home\Practice\Api;

interface AllInvoiceInterface
{
    /**
     * Create an invoice for an order
     *
     * @return array
     */
    public function createAllInvoices();
}
