<?php
namespace Vendor\Banner\Controller\Adminhtml\Save\Save;

/**
 * Interceptor class for @see \Vendor\Banner\Controller\Adminhtml\Save\Save
 */
class Interceptor extends \Vendor\Banner\Controller\Adminhtml\Save\Save implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Vendor\Banner\Model\BannerFactory $bannerFactory, \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor, \Magento\Framework\Filesystem $filesystem, \Magento\MediaStorage\Model\File\UploaderFactory $uploaderFactory, \Magento\Framework\Image\AdapterFactory $adapterFactory, \Psr\Log\LoggerInterface $logger)
    {
        $this->___init();
        parent::__construct($context, $bannerFactory, $dataPersistor, $filesystem, $uploaderFactory, $adapterFactory, $logger);
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
