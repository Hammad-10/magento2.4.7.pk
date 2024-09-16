<?php

namespace Vendor\Banner\Controller\Adminhtml\Banner;

use Magento\Backend\App\Action;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action
{
    protected $resultPageFactory;

    public function __construct(
        Action\Context $context,
        PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    public function execute()
    {

        // Creating the result page and set title for the grid
        $resultPage = $this->resultPageFactory->create();
//        $resultPage->setActiveMenu('Vendor_Banner::banner_grid');
        $resultPage->getConfig()->getTitle()->prepend(__('Banner Grid'));

        return $resultPage;
    }
}
