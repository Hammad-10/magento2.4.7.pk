<?php
namespace HammadIdrees\HelloWorld\Block;

class HelloWorld extends \Magento\Framework\View\Element\Template
{
    protected $_coreRegistry = null;
    protected $_helloworldFactory;
    protected $customerSessionFactory;
    protected $logger;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Customer\Model\SessionFactory $customerSessionFactory,
        \Psr\Log\LoggerInterface $logger,
        \HammadIdrees\HelloWorld\Model\ResourceModel\HelloWorld\CollectionFactory $helloworldFactory,
        array $data = []
    ) {
        $this->_coreRegistry = $registry;
        $this->_helloworldFactory = $helloworldFactory;
        $this->customerSessionFactory = $customerSessionFactory;
        $this->logger = $logger;
        parent::__construct($context, $data);
    }

    public function getCustomerSession()
    {
        return $this->customerSessionFactory->create();
    }
    public function getHelloCollection()
    {
        // Create session instance using the factory
//        $customerSession = $this->customerSessionFactory->create();

        $customerSession = $this->getCustomerSession();

        // Check if customer is logged in
        if ($customerSession->isLoggedIn()) {
            $customerId = $customerSession->getCustomerId();
            // Log customer ID for debugging
//            die('Logged in customer ID is: ' . $customerId);
        } else {
            // Log if customer is not logged in
//            die('Customer is not logged in');
        }
        $customerId = $customerSession->getCustomerId();
        // Continue with post filtering once the customer ID is confirmed
        $page = ($this->getRequest()->getParam('p')) ? $this->getRequest()->getParam('p') : 1;
        $pageSize = ($this->getRequest()->getParam('limit')) ? $this->getRequest()->getParam('limit') : 5;

        $helloCollection = $this->_helloworldFactory->create();
        $helloCollection->setPageSize($pageSize);
        $helloCollection->setCurPage($page);

        if (isset($customerId)) {
            $helloCollection->addFieldToFilter('customer_id', $customerId);
        }


        return $helloCollection;
    }

    public function _prepareLayout()
    {
        parent::_prepareLayout();
        $this->pageConfig->getTitle()->set(__('Sample Post'));

        if ($this->getHelloCollection()) {
            $pager = $this->getLayout()->createBlock('Magento\Theme\Block\Html\Pager', 'hammadidrees.blog.pager')
                ->setAvailableLimit([5 => 5, 10 => 10, 15 => 15, 20 => 20]);
            $pager->setShowPerPage(true);
            $pager->setCollection($this->getHelloCollection());
            $this->setChild('pager', $pager);
            $this->getHelloCollection()->load();
        }
        return $this;
    }

    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }
}
