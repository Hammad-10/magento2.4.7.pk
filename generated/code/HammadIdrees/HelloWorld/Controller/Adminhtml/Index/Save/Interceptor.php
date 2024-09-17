<?php
namespace HammadIdrees\HelloWorld\Controller\Adminhtml\Index\Save;

/**
 * Interceptor class for @see \HammadIdrees\HelloWorld\Controller\Adminhtml\Index\Save
 */
class Interceptor extends \HammadIdrees\HelloWorld\Controller\Adminhtml\Index\Save implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \HammadIdrees\HelloWorld\Controller\Adminhtml\Index\PostDataProcessor $dataProcessor, \HammadIdrees\HelloWorld\Model\HelloWorld $model, \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor)
    {
        $this->___init();
        parent::__construct($context, $dataProcessor, $model, $dataPersistor);
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
