<?php
namespace Home\Practice\Plugin;

class CanShipPlugin
{

    public function afterCanShip(\Magento\Sales\Model\Order $subject, $result)
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
