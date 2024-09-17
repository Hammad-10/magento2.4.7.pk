<?php
namespace HammadIdrees\HelloWorld\Controller\Post;

use Magento\Framework\App\Action\Context;
use HammadIdrees\HelloWorld\Model\HelloWorldFactory;

class View extends \Magento\Framework\App\Action\Action
{
    protected $_helloworldFactory;

    public function __construct(
        Context $context,
        HelloWorldFactory $helloworldFactory
    ) {
        $this->_helloworldFactory = $helloworldFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        // Get the post ID from the URL
        $postId = $this->getRequest()->getParam('id');

        // Load the post using the model
        $post = $this->_helloworldFactory->create()->load($postId);

        if ($post->getId()) {
            // Register the post data to be available in the view
            $layout = $this->_view->loadLayout();
            $block = $layout->getLayout()->getBlock('postview');

            if ($block) {
                $block->setData('post', $post);
                $this->_view->renderLayout();
            } else {
                // Handle the case where the block is not found
                $this->messageManager->addErrorMessage(__('Block not found.'));
                return $this->_redirect('helloworld/index/index');
            }
        } else {
            // Redirect if the post is not found
            return $this->_redirect('helloworld/index/index');
        }
    }
}
