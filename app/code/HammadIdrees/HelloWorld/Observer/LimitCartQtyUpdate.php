<?php
namespace HammadIdrees\HelloWorld\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Message\ManagerInterface;

class LimitCartQtyUpdate implements ObserverInterface
{
    /**
     * @var ManagerInterface
     */
    protected $messageManager;

    /**
     * Constructor
     *
     * @param ManagerInterface $messageManager
     */
    public function __construct(ManagerInterface $messageManager)
    {
        $this->messageManager = $messageManager;
    }

    /**
     * Prevent the customer from updating product quantity
     *
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {

        //error message for the customer
        $this->messageManager->addErrorMessage(__('You cannot update the quantity of this product.'));

        // Get the quote item from the observer
        $quoteItem = $observer->getEvent()->getQuoteItem();

        // Set the quantity back to 1
        $quoteItem->setQty(1);


        return;
    }
}
