<?php

namespace HammadIdrees\HelloWorld\Model;



class HelloWorld extends \Magento\Framework\Model\AbstractModel
{
    protected function _construct()
    {
        $this->_init('HammadIdrees\HelloWorld\Model\ResourceModel\HelloWorld');
    }
}
