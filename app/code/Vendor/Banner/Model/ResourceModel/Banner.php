<?php
namespace Vendor\Banner\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Banner extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('banner_table', 'id'); // 'banner_table' is your database table, 'id' is the primary key

    }
}
