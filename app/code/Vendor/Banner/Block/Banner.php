<?php

namespace Vendor\Banner\Block;

use Magento\Framework\View\Element\Template;
use Vendor\Banner\Model\ResourceModel\Banner\CollectionFactory;

class Banner extends Template
{
    protected $bannerCollectionFactory;

    public function __construct(
        Template\Context $context,
        CollectionFactory $bannerCollectionFactory,
        array $data = []
    ) {
        $this->bannerCollectionFactory = $bannerCollectionFactory;
        parent::__construct($context, $data);
    }

    public function getBannerData()
    {
        // Get the collection of banners from the database
        $collection = $this->bannerCollectionFactory->create();
        return $collection->getItems(); // Returns all banner data
    }
}
