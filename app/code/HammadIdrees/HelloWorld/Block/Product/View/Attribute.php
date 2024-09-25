<?php
namespace HammadIdrees\HelloWorld\Block\Product\View;

use Magento\Framework\View\Element\Template;
use Magento\Catalog\Model\ProductFactory;
use Magento\Framework\Registry;
use Magento\Eav\Model\Config as EavConfig;

class Attribute extends Template
{
    protected $_product;
    protected $_registry;
    protected $_eavConfig;

    public function __construct(
        Template\Context $context,
        ProductFactory $productFactory,
        Registry $registry, // Inject Registry class
        EavConfig $eavConfig, // Inject EAV config for attribute label
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->_productFactory = $productFactory;
        $this->_registry = $registry; // Assign Registry instance
        $this->_eavConfig = $eavConfig; // Assign EAV Config instance
    }

    public function getRestrictedCountries()
    {
        $product = $this->getProduct(); // Get the product

        if ($product && $product->getData('restricted_countries')) {
            // Get the select attribute option ID
            $optionId = $product->getData('restricted_countries');

            // Load attribute information for restricted_countries
            $attribute = $this->_eavConfig->getAttribute('catalog_product', 'restricted_countries');
            
            if ($attribute && $attribute->usesSource()) {
                // Retrieve the option label using the source model
                $optionLabel = $attribute->getSource()->getOptionText($optionId);
                return $optionLabel;
            }
        }
        return '';
    }

    public function getProduct()
    {
        if (!$this->_product) {
            // Fetch current product from the registry
            $this->_product = $this->_registry->registry('current_product');
            
        }
        return $this->_product;
    }
}
