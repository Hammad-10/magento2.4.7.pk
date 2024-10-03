<?php
namespace Home\Practice\Model\Api;

use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Sales\Model\Service\InvoiceService;
use Magento\Framework\DB\Transaction;
use Magento\Sales\Model\Order\Email\Sender\InvoiceSender;
use Psr\Log\LoggerInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;

class AllInvoicesClass
{
    protected $orderRepository;
    protected $invoiceService;
    protected $transaction;
    protected $invoiceSender;
    protected $logger;
    protected $searchCriteriaBuilder;

    public function __construct(
        OrderRepositoryInterface $orderRepository,
        InvoiceService $invoiceService,
        InvoiceSender $invoiceSender,
        Transaction $transaction,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        LoggerInterface $logger
    ) {
        $this->orderRepository = $orderRepository;
        $this->invoiceService = $invoiceService;
        $this->transaction = $transaction;
        $this->invoiceSender = $invoiceSender;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->logger = $logger;
    }

    public function createAllInvoices()
    {

        try {
            // Retrieve all orders from the order repository
            $searchCriteria = $this->searchCriteriaBuilder->create();  // No filters, retrieve all orders
            $ordersList = $this->orderRepository->getList($searchCriteria);
            $response = '';

            // Iterate through all orders
            foreach ($ordersList->getItems() as $order) {
                // Check if an invoice already exists for the order
                $invoices = $order->getInvoiceCollection();

                if ($invoices->getSize() > 0) {
                    // If the invoice already exists, skip this order
                    $response = 'Invoice already exists for this order';
                    continue;  // Skip to the next order
                }

                // Check if the order allows invoicing
                if (!$order->canInvoice()) {
                    $response = 'Order does not allow invoicing';
                    continue;  // Skip to the next order
                }

                // Prepare the invoice
                $invoice = $this->invoiceService->prepareInvoice($order);
                if (!$invoice) {
                    $response = 'Failed to prepare Invoice';
                    continue;  // Skip to the next order
                }

                // Register and save the invoice
                $invoice->register();
                $invoice->save();

            }

            $response = 'All Invoices Generated Successfully';

            // Return the confirmation
            return $response;

        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
            throw new \Magento\Framework\Exception\LocalizedException(__($e->getMessage()));
        }
    }


}
