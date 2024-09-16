<?php
namespace Vendor\Banner\Model\ResourceModel\Banner;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Vendor\Banner\Model\Banner;

class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'id';

    /**
     * Dependency Initilization
     *
     * @return void
     */
    public function _construct()
    {
        $this->_init(
            Banner::class,
            \Vendor\Banner\Model\ResourceModel\Banner::class
        );
    }
}
