<?php

namespace HammadIdrees\HelloWorld\Controller\Adminhtml\Index;

class Index extends \Magento\Backend\App\Action
{

    protected $resultPageFactory;


    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context, $coreRegistry);
    }


    public function execute()
    {

        $resultPage = $this->resultPageFactory->create();
        $this->initPage($resultPage)->getConfig()->getTitle()->prepend(__('Manage Post'));
        return $resultPage;
    }
    protected function initPage($resultPage)
    {
        $resultPage->setActiveMenu('HammadIdrees_HelloWorld::helloworld1')
            ->addBreadcrumb(__('Hammad Idrees'), __('Hammad Idrees'))
            ->addBreadcrumb(__('Manage Post'), __('Manage Post'));

        return $resultPage;
    }


    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('HammadIdrees_HelloWorld::helloworld1');
    }
}
