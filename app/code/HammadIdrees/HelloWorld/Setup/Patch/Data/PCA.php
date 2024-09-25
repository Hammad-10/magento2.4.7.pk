<?php
namespace HammadIdrees\HelloWorld\Setup\Patch\Data;

use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class PCA implements DataPatchInterface
{
    private $moduleDataSetup;
    private $eavSetupFactory;

    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        EavSetupFactory $eavSetupFactory
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->eavSetupFactory = $eavSetupFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function apply()
    {
        /** @var EavSetup $eavSetup */
        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);

        // Adding the first custom attribute (boolean type)
        $eavSetup->addAttribute('catalog_product', 'alternate_name', [
            'type' => 'varchar',
            'backend' => '',
            'frontend' => '',
            'label' => 'Alternate Name',
            'input' => 'text',
            'class' => '',
            'source' => \Magento\Eav\Model\Entity\Attribute\Source\Boolean::class,
            'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
            'visible' => true,
            'required' => false,
            'user_defined' => false,
            'default' => '',
            'searchable' => false,
            'filterable' => false,
            'comparable' => false,
            'visible_on_front' => true,
            'used_in_product_listing' => false,
            'is_used_in_grid' => true,
            'is_visible_in_grid' => true,
            'unique' => false,
            'apply_to' => '',
        ]);

        // Adding dropdown attribute for Restricted Countries
        $eavSetup->addAttribute('catalog_product', 'restricted_countries', [
            'type' => 'varchar',
            'backend' => '',
            'frontend' => '',
            'label' => 'Restricted Countries',
            'input' => 'select',
            'class' => '',
            'source' => '',
            'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
            'visible' => true,
            'required' => false,
            'user_defined' => false,
            'default' => '',
            'searchable' => false,
            'filterable' => false,
            'comparable' => false,
            'visible_on_front' => true,
            'used_in_product_listing' => false,
            'is_used_in_grid' => true,
            'is_visible_in_grid' => true,
            'unique' => false,
            'apply_to' => '',
            'option' => [
                'value' => [
                    'USA' => ['USA'],
                    'Canada' => ['Canada'],
                    'UK' => ['UK'],
                    'Germany' => ['Germany'],
                    'France' => ['France'],
                    'Australia' => ['Australia'],
                    'India' => ['India'],
                    'Japan' => ['Japan'],
                    'Italy' => ['Italy'],
                    'Brazil' => ['Brazil'],
                ],
            ],
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getAliases()
    {
        return [];
    }
}
