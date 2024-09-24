<?php
namespace HammadIdrees\HelloWorld\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Exception\LocalizedException;

class ProductSaveObserver implements ObserverInterface
{


    /**
     * Below is the method that will fire whenever the event runs!
     *
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
//        $writer = new \Zend_Log_Writer_Stream(BP . '/var/log/customk.log');
//        $logger = new \Zend_Log();
//        $logger->addWriter($writer);
//        $logger->info('text message');

        $product = $observer->getProduct();

//        print_r($product->getQuantityAndStockStatus());
//        exit();

//        print_r($product);
//        exit();

//        getting the value of stock status
        $isInStock = $product->getQuantityAndStockStatus();


        // getting the quantity of the product from Extension Attributes
        $stockItem = $product->getExtensionAttributes()->getStockItem();
        $quantity = $stockItem->getQty();


        $isNew = $product->getNew();
        $price = $product->getPrice();

        if ($isNew) {

            $product->setPrice($price / 2);
            $product->save();
        }

        if($isInStock !== 1) {

            $product->setQuantityAndStockStatus(['qty' => $quantity, 'is_in_stock' => 1]);
            $product->save();
//            throw new LocalizedException(__('You cannot change the stock status of this product.'));

        }

    }
}
