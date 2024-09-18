<?php
namespace Vendor\Banner\Controller\Adminhtml\Banner\Upload;

/**
 * Interceptor class for @see \Vendor\Banner\Controller\Adminhtml\Banner\Upload
 */
class Interceptor extends \Vendor\Banner\Controller\Adminhtml\Banner\Upload implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Framework\File\UploaderFactory $uploaderFactory, \Magento\Framework\Filesystem\Driver\File $fileDriver)
    {
        $this->___init();
        parent::__construct($context, $uploaderFactory, $fileDriver);
    }

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'execute');
        return $pluginInfo ? $this->___callPlugins('execute', func_get_args(), $pluginInfo) : parent::execute();
    }

    /**
     * {@inheritdoc}
     */
    public function dispatch(\Magento\Framework\App\RequestInterface $request)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'dispatch');
        return $pluginInfo ? $this->___callPlugins('dispatch', func_get_args(), $pluginInfo) : parent::dispatch($request);
    }
}
