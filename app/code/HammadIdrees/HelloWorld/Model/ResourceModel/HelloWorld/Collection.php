<?php

namespace HammadIdrees\HelloWorld\Model\ResourceModel\HelloWorld;

use HammadIdrees\HelloWorld\Model\ResourceModel\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'post_id';

    /**
     * Load data for preview flag
     *
     * @var bool
     */
    protected $_previewFlag;

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('HammadIdrees\HelloWorld\Model\HelloWorld', 'HammadIdrees\HelloWorld\Model\ResourceModel\HelloWorld');


        // Debugging
        $logger = \Magento\Framework\App\ObjectManager::getInstance()->get(\Psr\Log\LoggerInterface::class);
        $logger->info('HelloWorld Collection _construct method called');
    }

//    public function _initSelect()
//    {
//        parent::_initSelect();
//        $this->addFieldToSelect('title');
//        $this->addFieldToSelect('content');
//        $this->addFieldToSelect('customer_id'); // Add your new column here
//
//        return $this;
//    }

    public function setFirstStoreFlag($flag = false)
    {
        $this->_previewFlag = $flag;
        return $this;
    }

    /**
     * Add filter by store
     *
     * @param int|array|\Magento\Store\Model\Store $store
     * @param bool $withAdmin
     * @return $this
     */
    public function addStoreFilter($store, $withAdmin = true)
    {
        return $this;
    }

    /**
     * Perform operations after collection load
     *
     * @return $this
     */
    protected function _afterLoad()
    {
        // Debugging
        $logger = \Magento\Framework\App\ObjectManager::getInstance()->get(\Psr\Log\LoggerInterface::class);
        $logger->info('Data after load in HelloWorld Collection: ' . print_r($this->getItems(), true));

        return parent::_afterLoad();
    }

    /**
     * Perform operations before rendering filters
     *
     * @return void
     */
    protected function _renderFiltersBefore()
    {
        // Debugging
        $logger = \Magento\Framework\App\ObjectManager::getInstance()->get(\Psr\Log\LoggerInterface::class);
        $logger->info('Filters before rendering in HelloWorld Collection: ' . print_r($this->getSelect()->__toString(), true));

        return parent::_renderFiltersBefore();
    }
}
