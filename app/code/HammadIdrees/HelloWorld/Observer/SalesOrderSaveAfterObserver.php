<?php
namespace HammadIdrees\HelloWorld\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class SalesOrderSaveAfterObserver implements ObserverInterface
{
    /**
     * Below is the method that will fire whenever the event runs!
     *
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        $writer = new \Zend_Log_Writer_Stream(BP . '/var/log/customB.log');
        $logger = new \Zend_Log();
        $logger->addWriter($writer);
        $logger->info('text message');

        $order = $observer->getEvent()->getOrder();

    }
}
