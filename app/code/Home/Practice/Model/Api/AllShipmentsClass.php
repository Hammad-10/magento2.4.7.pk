<?php
namespace Home\Practice\Model\Api;

use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Sales\Model\Order\ShipmentFactory;
use Magento\Sales\Model\Order\Shipment\TrackFactory;
use Magento\Sales\Model\Service\ShipmentService;
use Magento\Framework\DB\Transaction;
use Psr\Log\LoggerInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;

class AllShipmentsClass
{
    protected $orderRepository;
    protected $shipmentFactory;
    protected $shipmentService;
    protected $trackFactory;
    protected $transaction;
    protected $logger;
    protected $searchCriteriaBuilder;

    public function __construct(
        OrderRepositoryInterface $orderRepository,
        ShipmentFactory $shipmentFactory,
        ShipmentService $shipmentService,
        TrackFactory $trackFactory,
        Transaction $transaction,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        LoggerInterface $logger
    ) {
        $this->orderRepository = $orderRepository;
        $this->shipmentFactory = $shipmentFactory;
        $this->shipmentService = $shipmentService;
        $this->trackFactory = $trackFactory;
        $this->transaction = $transaction;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->logger = $logger;
    }

    public function createAllShipments()
    {
        try {
            // Retrieve all orders from the order repository
            $searchCriteria = $this->searchCriteriaBuilder->create();  // No filters, retrieve all orders
            $ordersList = $this->orderRepository->getList($searchCriteria);
            $response = [];

            // Iterate through all orders
            foreach ($ordersList->getItems() as $order) {
                // Check if a shipment already exists for the order
                $shipments = $order->getShipmentsCollection();
                if ($shipments->getSize() > 0) {
                    // If the shipment already exists, skip this order
                    $response[] = [
                        'Order ID' => $order->getId(),
                        'Message' => 'Shipment already exists for this order.'
                    ];
                    continue;  // Skip to the next order
                }

                // Check if the order allows shipping
                if (!$order->canShip()) {
                    $response[] = [
                        'Order ID' => $order->getId(),
                        'Message' => 'The order does not allow shipping.'
                    ];
                    continue;  // Skip to the next order
                }

                // Create the shipment
                $shipment = $this->shipmentFactory->create($order, $order->getAllItems());

                if (!$shipment) {
                    $response[] = [
                        'Order ID' => $order->getId(),
                        'Message' => 'Failed to prepare shipment.'
                    ];
                    continue;  // Skip to the next order
                }

                // Register and save the shipment
                $shipment->register();
                $shipment->save();


                $this->transaction->addObject($shipment)->save();
            }

            // Return the JSON encoded response for all orders
            return 'All shipments have been created.';

        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
            throw new \Magento\Framework\Exception\LocalizedException(__($e->getMessage()));
        }
    }


}
