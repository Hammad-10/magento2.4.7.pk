<?php
namespace HammadIdrees\HelloWorld\Model\HelloWorld;

use HammadIdrees\HelloWorld\Model\ResourceModel\HelloWorld\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;

/**
 * Class DataProvider
 */
class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @var \Magento\Cms\Model\ResourceModel\Block\Collection
     */
    protected $collection;

    public    $_storeManager;

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var array
     */
    protected $loadedData;

    /**
     * Constructor
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $blockCollectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $helloworldCollectionFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $helloworldCollectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        $this->_storeManager=$storeManager;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        // Get the base URL for media files
        $baseurl = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);

        // Check if loadedData is already set, return it if true
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        // Get the items from the collection
        $items = $this->collection->getItems();

        /** @var \Magento\Cms\Model\Block $helloworld */
        foreach ($items as $helloworld) {
            // Get data for each item
            $temp = $helloworld->getData();

            // Check if the image exists and set the URL for it
            if (!empty($temp['image'])) {
                $img = [];
                $img[0]['image'] = $temp['image'];
                $img[0]['url'] = $baseurl . 'test/' . $temp['image'];
                $temp['logo'] = $img; // Add image data to the 'logo' field
            }

            // Add the processed data to the loadedData array
            $this->loadedData[$helloworld->getId()] = $temp;
        }

        // Check if there is any persisted data
        $data = $this->dataPersistor->get('helloworld');
        if (!empty($data)) {
            $helloworld = $this->collection->getNewEmptyItem();
            $helloworld->setData($data);

            // Handle persisted data and add it to loadedData
            $this->loadedData[$helloworld->getId()] = $helloworld->getData();

            // Clear the persisted data
            $this->dataPersistor->clear('helloworld');
        }

        // Return the loaded data
        return $this->loadedData;
    }

}
