<?php
namespace HammadIdrees\HelloWorld\Block\Product\View;

use Magento\Framework\View\Element\Template;
use Magento\Catalog\Model\ProductFactory;

class Attribute extends Template
{
    protected $_product;

    public function __construct(
        Template\Context $context,
        ProductFactory $productFactory,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->_productFactory = $productFactory;
    }

    public function getRestrictedCountries()
    {
        $product = $this->getProduct();
        if ($product && $product->getData('restricted_countries')) {
            return $product->getData('restricted_countries');
        }
        return '';
    }

    public function getProduct()
    {
        if (!$this->_product) {
            $this->_product = $this->getData('product') ?: $this->registry->registry('current_product');
        }
        return $this->_product;
    }
}
