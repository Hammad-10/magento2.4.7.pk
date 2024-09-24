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


        $order = $observer->getEvent()->getOrder();


        $grandTotal = $order->getGrandTotal();


        if($grandTotal > 200){
            $order->setStatus('tocall');
            $order->setState('processing');
            $comment = 'Order status set to "TOCALL" because grand total is greater than 200.';
            $order->addStatusHistoryComment($comment, 'tocall')
            ->setIsVisibleOnFront(true);


            $order->save();

        }


    }

}
