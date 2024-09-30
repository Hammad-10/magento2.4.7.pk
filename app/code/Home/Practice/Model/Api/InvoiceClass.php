<?php
namespace Home\Practice\Model\Api;

use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Sales\Model\Service\InvoiceService;
use Magento\Framework\DB\Transaction;
use Magento\Sales\Model\Order\Email\Sender\InvoiceSender;
use Psr\Log\LoggerInterface; 

class InvoiceClass
{
    protected $orderRepository;
    protected $invoiceService;
    protected $transaction;
    protected $invoiceSender;
    protected $logger;

    public function __construct(
        OrderRepositoryInterface $orderRepository,
        InvoiceService $invoiceService,
        InvoiceSender $invoiceSender,
        Transaction $transaction,
        LoggerInterface $logger 
    ) {
        $this->orderRepository = $orderRepository;
        $this->invoiceService = $invoiceService;
        $this->transaction = $transaction;
        $this->invoiceSender = $invoiceSender;
        $this->logger = $logger; 
    }
    
    public function createInvoice($orderId)
{
    try {
        $order = $this->orderRepository->get($orderId);

        if (!$order instanceof \Magento\Sales\Model\Order) {
            throw new \Exception('Invalid order instance.');
        }

        if (!$order->canInvoice()) {
            throw new \Magento\Framework\Exception\LocalizedException(__('The order does not allow invoicing.'));
        }

        // method to prepare the invoice
        $invoice = $this->invoiceService->prepareInvoice($order);
        if (!$invoice) {
            throw new \Magento\Framework\Exception\LocalizedException(__('Failed to prepare invoice.'));
        }

        $invoice->register(); // Registering the invoice
        $invoice->save();     // Save the invoice to the db


        return $this->formatInvoiceResponse($invoice);

    } catch (\Exception $e) {
        $this->logger->error($e->getMessage());
        throw new \Magento\Framework\Exception\LocalizedException(__($e->getMessage()));
    }
}

protected function formatInvoiceResponse(\Magento\Sales\Model\Order\Invoice $invoice)
{
    return [
        'invoice_id' => $invoice->getId(),
        'order_id' => $invoice->getOrder()->getId(),
        'invoice_status' => $invoice->getState(), // Get invoice status
        'total' => $invoice->getGrandTotal(),     // Invoice grand total
        'items' => array_map(function($item) {
            return [
                'item_id' => $item->getId(),
                'name' => $item->getName(),
                'quantity' => $item->getQty(),
                'price' => $item->getPrice(),
            ];
        }, $invoice->getAllItems()) // Format all items in the invoice
    ];
}


    
}
