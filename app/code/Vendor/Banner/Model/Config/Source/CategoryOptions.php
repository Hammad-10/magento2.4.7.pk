<?php
namespace Vendor\Banner\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;
use Magento\Framework\App\ResourceConnection;

class CategoryOptions implements ArrayInterface
{
protected $resource;

public function __construct(ResourceConnection $resource)
{
$this->resource = $resource;
}

public function toOptionArray()
{
// Get the database connection
$connection = $this->resource->getConnection();

// Define the tables and necessary columns
$categoryEntityTable = $connection->getTableName('catalog_category_entity'); // this table store the id of the category
$categoryVarcharTable = $connection->getTableName('catalog_category_entity_varchar'); // this table store the name of the category
$eavAttributeTable = $connection->getTableName('eav_attribute');

// Get the attribute ID for the category name
$attributeId = $connection->fetchOne(
"SELECT attribute_id FROM {$eavAttributeTable} WHERE attribute_code = 'name' AND entity_type_id = 3"
);

// Fetch categories with their names
$select = $connection->select()
->from(['c' => $categoryEntityTable], ['entity_id'])
->joinLeft(
['v' => $categoryVarcharTable],
"c.entity_id = v.entity_id AND v.attribute_id = $attributeId",
['value AS name']
)
->where('v.value IS NOT NULL')
->order('name ASC');

$categories = $connection->fetchAll($select);

// Prepare the options array
$options = [];
foreach ($categories as $category) {
$options[] = ['value' => $category['entity_id'], 'label' => $category['name']];
}

return $options;
}
}
