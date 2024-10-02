<?php
namespace Home\Practice\Plugin;

class CanInvoicePlugin
{

    public function afterCanInvoice(\Magento\Sales\Model\Order $subject, $result)
    {
        //if the result is false make it true and return
        if(!$result) {
            return !$result;
        }
        //if the result is already true then return it as it is
        else{
            return $result;
        }

    }

}
