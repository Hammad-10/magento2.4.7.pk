<?php
namespace Vendor\Banner\Model;

use Magento\Framework\Model\AbstractModel;

class Banner extends AbstractModel
{
    protected function _construct()
    {
        // Define the resource model for this entity
        $this->_init(\Vendor\Banner\Model\ResourceModel\Banner::class);
    }
}
