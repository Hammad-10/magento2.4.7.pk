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

        $product = $observer->getEvent()->getProduct();

        $quote = $this->cart->getQuote();


        // Loop through all items in the cart to check if the product is already present
        foreach ($quote->getAllItems() as $item) {

            // checking if the product is already in the cart
            if ($item->getProductId() == $product->getId()) {
                // If the product is already in the cart, set its quantity to 1
                $item->setQty(1);
                $item->save();
                return;
            }
        }
    }
}
