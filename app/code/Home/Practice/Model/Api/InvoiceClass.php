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
    
            // Prepare the invoice
            $invoice = $this->invoiceService->prepareInvoice($order);
            if (!$invoice) {
                throw new \Magento\Framework\Exception\LocalizedException(__('Failed to prepare invoice.'));
            }
    
            $invoice->register(); // Registering the invoice
            $invoice->save();     // Save the invoice to the db
    
            // Properly encode the response as JSON
            $response = [
                'Invoice ID' => $invoice->getId(),
                'Order ID' => $invoice->getOrder()->getId(),
                'Invoice Status' => $invoice->getState(),
                'Total' => $invoice->getGrandTotal(),
                'Items' => $this->formatInvoiceResponse($invoice)
            ];
    
            // Return the JSON encoded response
            return json_encode($response, JSON_PRETTY_PRINT);
    
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
            throw new \Magento\Framework\Exception\LocalizedException(__($e->getMessage()));
        }
    }
    

    protected function formatInvoiceResponse(\Magento\Sales\Model\Order\Invoice $invoice)
    {
        return array_map(function($item) {
            return [
                'Item ID' => $item->getId(),
                'Name' => $item->getName(),
                'Quantity' => $item->getQty(),
                'Price' => $item->getPrice(),
            ];
        }, $invoice->getAllItems());
    }
    
    

    
}
