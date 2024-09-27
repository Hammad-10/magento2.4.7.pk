<?php
namespace HammadIdrees\HelloWorld\Observer;
class SaveToOrder implements \Magento\Framework\Event\ObserverInterface
{
    public function execute(\Magento\Framework\Event\Observer $observer)
    {


        $event = $observer->getEvent();
        $quote = $event->getQuote();
        $order = $event->getOrder();


        if( $quote->getData('delivery_date')){

//            $writer = new \Zend_Log_Writer_Stream(BP . '/var/log/cuswwwwkrtom.log');
//            $logger = new \Zend_Log();
//            $logger->addWriter($writer);
//            $logger->info('text message');


            $order->setData('delivery_date', $quote->getData('delivery_date'));
        }

    }
}
