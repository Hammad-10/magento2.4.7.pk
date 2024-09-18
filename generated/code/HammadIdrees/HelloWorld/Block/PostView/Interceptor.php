<?php
namespace HammadIdrees\HelloWorld\Block\PostView;

/**
 * Interceptor class for @see \HammadIdrees\HelloWorld\Block\PostView
 */
class Interceptor extends \HammadIdrees\HelloWorld\Block\PostView implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\View\Element\Template\Context $context, \HammadIdrees\HelloWorld\Model\HelloWorldFactory $helloworldFactory, \Magento\Customer\Model\SessionFactory $customerSessionFactory, array $data = [])
    {
        $this->___init();
        parent::__construct($context, $helloworldFactory, $customerSessionFactory, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function getPostData()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getPostData');
        return $pluginInfo ? $this->___callPlugins('getPostData', func_get_args(), $pluginInfo) : parent::getPostData();
    }
}
