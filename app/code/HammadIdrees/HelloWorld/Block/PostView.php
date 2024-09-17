<?php
namespace HammadIdrees\HelloWorld\Block;

class PostView extends \Magento\Framework\View\Element\Template
{
    protected $_helloworldFactory;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \HammadIdrees\HelloWorld\Model\HelloWorldFactory $helloworldFactory,
        array $data = []
    ) {
        $this->_helloworldFactory = $helloworldFactory;
        parent::__construct($context, $data);
    }

    public function getPostData()
    {
        // Retrieve the post data that was registered in the controller
        return $this->getData('post');
    }
}
