<?php
namespace HammadIdrees\HelloWorld\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;

class SaveCustomNote implements ObserverInterface
{
    public function execute(Observer $observer)
    {
        $quote = $observer->getQuote();
        $order = $observer->getOrder();
        $customNote = $quote->getCustomNote();
        $order->setCustomNote($customNote);
    }
}

