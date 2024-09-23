<?php
namespace HammadIdrees\HelloWorld\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Magento\Checkout\Model\Cart;

class ProdAddToCartAfter implements ObserverInterface
{
    protected $cart;

    public function __construct(Cart $cart)
    {
        $this->cart = $cart;
    }

    public function execute(Observer $observer)
    {
        // Get the product and request information from the event
        $product = $observer->getProduct();
        $quote = $this->cart->getQuote();

        // Loop through all items in the cart to check if the product is already present
        foreach ($quote->getAllItems() as $item) {
            // Checking if the product is already in the cart
            if ($item->getProductId() == $product->getId()) {
                // Setting the quantity to 1 to ensure it doesn't increase
                $item->setQty(1);
                $item->save();

                // Adjusting the cart totals to remove any excess amount from previous additions
                $quote->setTotalsCollectedFlag(false);
                $quote->collectTotals();
                $this->cart->save();

                return;
            }
        }
    }



}
