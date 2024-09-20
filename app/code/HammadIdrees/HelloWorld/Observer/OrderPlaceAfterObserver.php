<?php
namespace HammadIdrees\HelloWorld\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
//use Psr\Log\LoggerInterface;

class OrderPlaceAfterObserver implements ObserverInterface
{
    /**
     * Below is the method that will fire whenever the event runs!
     *
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
//        $writer = new \Zend_Log_Writer_Stream(BP . '/var/log/custom.log');
//        $logger = new \Zend_Log();
//        $logger->addWriter($writer);
//        $logger->info('text message');

//        die('asdasasasa');


        $order = $observer->getEvent()->getOrder();

//        print_r($order);
//        exit();

        $grandTotal = $order->getGrandTotal();
        $status = $order->getStatus();
        $state = $order->getState();


        if($grandTotal > 200){
            $order->setStatus('tocall');
            $order->setState('processing');
            $comment = 'Order status set to "TOCALL" because grand total is greater than 200.';
            $order->addStatusHistoryComment($comment, 'tocall')
            ->setIsVisibleOnFront(true);
//            ->setIsCustomerNotified(true);

//            $order->setState('tocall');


            $order->save();

//            die($order->getStatus());

        }






    }

}
