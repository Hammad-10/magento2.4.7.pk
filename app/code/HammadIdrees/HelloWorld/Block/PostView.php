<?php
namespace HammadIdrees\HelloWorld\Block;

class PostView extends \Magento\Framework\View\Element\Template
{
    protected $_helloworldFactory;
    protected $_customerSession;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \HammadIdrees\HelloWorld\Model\HelloWorldFactory $helloworldFactory,
        \Magento\Customer\Model\SessionFactory $customerSessionFactory,
        array $data = []
    ) {
        $this->_helloworldFactory = $helloworldFactory;
        $this->customerSessionFactory = $customerSessionFactory;
        parent::__construct($context, $data);
    }

    public function getPostData()
    {
        return $this->getData('post');
    }

    public function getCustomerSession()
    {
        return $this->customerSessionFactory->create();
    }
}
