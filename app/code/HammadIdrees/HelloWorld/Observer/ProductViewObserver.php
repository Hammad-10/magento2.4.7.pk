<?php
namespace HammadIdrees\HelloWorld\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class ProductViewObserver implements ObserverInterface
{
    /**
     * Below is the method that will fire whenever the event runs!
     *
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {


        $product = $observer->getProduct();
        $originalName = $product->getName();
        $modifiedName = $originalName . ' - Modified by Events and Observers';
        $product->setName($modifiedName);

    }
}
