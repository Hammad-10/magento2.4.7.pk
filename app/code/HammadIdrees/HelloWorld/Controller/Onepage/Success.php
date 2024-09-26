<?php
namespace HammadIdrees\HelloWorld\Controller\Onepage;

class Success extends \Magento\Checkout\Controller\Onepage\Success
{
    /**
     * Execute method to override the default success page redirect
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {

        // Redirecting to sale.html
        /** @var \Magento\Framework\Controller\Result\Redirect $redirect */
        $redirect = $this->resultRedirectFactory->create();
        $redirect->setUrl('/sale.html');
        $this->messageManager->addSuccessMessage(__('Thank you for your purchase!'));
        return $redirect;
    }
}
