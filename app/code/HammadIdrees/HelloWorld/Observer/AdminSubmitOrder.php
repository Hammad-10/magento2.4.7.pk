<?php
namespace HammadIdrees\HelloWorld\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class AdminSubmitOrder implements ObserverInterface
{
    public function execute(Observer $observer)
    {
        
        // Get the order from the event
        $order = $observer->getEvent()->getOrder();

        // Initialize grand total
        $grandTotal = 0;
        $isChanged = false;

        // Loop through all order items
        foreach ($order->getAllItems() as $item) {
            $quantity = $item->getQtyOrdered();

            // Set the product quantity to 1 if greater than 1
            if ($quantity > 1) {
                // Set the quantities to 1
                $item->setQtyOrdered(1);
                $item->setQtyInvoiced(1);
                $item->setQtyShipped(1);
                $item->setQtyCanceled(0);

                // Recalculate row totals based on the new quantity
                $itemPrice = $item->getPrice();
                $item->setRowTotal($itemPrice);
                $item->setBaseRowTotal($itemPrice);

                // Adjust tax amounts if applicable
                $item->setTaxAmount($item->getTaxAmount() / $quantity);
                $item->setBaseTaxAmount($item->getBaseTaxAmount() / $quantity);

                // Mark that changes were made
                $isChanged = true;
            }

            // Add the item's row total to the grand total
            $grandTotal += $item->getRowTotal();
        }

        // If any changes were made to the order, update the grand total
        if ($isChanged) {
            $order->setTotalQtyOrdered(1); // Settting total quantity to 1
        }

        // Set the calculated grand total
        $order->setGrandTotal($grandTotal);
        $order->setBaseGrandTotal($grandTotal); // Set base grand total if needed

        // If the new grand total is greater than 200, set order status to "tocall"
        if ($grandTotal > 200) {
            $order->setStatus('tocall');
            $order->setState('processing');

            // Add a status history comment
            $comment = 'Order status set to "TOCALL" because grand total is greater than 200.';
            $order->addStatusHistoryComment($comment, 'tocall')
                ->setIsVisibleOnFront(true);
        }

        // Save the order and its items
        $order->save();
    }
}
