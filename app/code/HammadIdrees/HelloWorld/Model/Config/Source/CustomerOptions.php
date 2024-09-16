<?php
namespace HammadIdrees\HelloWorld\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;
use Magento\Framework\App\ResourceConnection;

class CustomerOptions implements ArrayInterface
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

        // Define the customer_entity table
        $customerEntityTable = $connection->getTableName('customer_entity');

        // Fetch customer IDs and emails from the customer_entity table
        $select = $connection->select()
            ->from(['c' => $customerEntityTable], ['entity_id', 'email']) // You can also fetch 'firstname' and 'lastname' if needed
            ->order('email ASC'); // Sort by email or any other column you prefer

        $customers = $connection->fetchAll($select);

        // Prepare the options array
        $options = [];
        foreach ($customers as $customer) {
            $options[] = ['value' => $customer['entity_id'], 'label' => $customer['email']]; // Display email as the label
        }

        return $options;
    }
}
