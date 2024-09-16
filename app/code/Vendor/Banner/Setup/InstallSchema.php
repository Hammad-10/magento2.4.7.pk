<?php
namespace Vendor\Banner\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        // Create banner_table
        $table = $setup->getConnection()->newTable($setup->getTable('banner_table'))
            ->addColumn(
                'id',
                Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'nullable' => false, 'primary' => true],
                'Banner ID'
            )
            ->addColumn(
                'name',
                Table::TYPE_TEXT,
                255,
                ['nullable' => false],
                'Name'
            )
            ->addColumn(
                'status',
                Table::TYPE_SMALLINT,
                null,
                ['nullable' => false, 'default' => '1'],
                'Status'
            )
            ->addColumn(
                'from_date',
                Table::TYPE_DATE,
                null,
                ['nullable' => true],
                'From Date'
            )
            ->addColumn(
                'to_date',
                Table::TYPE_DATE,
                null,
                ['nullable' => true],
                'To Date'
            )
            ->addColumn(
                'image',
                Table::TYPE_TEXT,
                255,
                ['nullable' => true],
                'Image'
            )
            ->setComment('Banner Table');

        $setup->getConnection()->createTable($table);

        $setup->endSetup();
    }
}
