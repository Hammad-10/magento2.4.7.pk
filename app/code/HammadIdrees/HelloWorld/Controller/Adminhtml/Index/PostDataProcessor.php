<?php

namespace HammadIdrees\HelloWorld\Controller\Adminhtml\Index;

use Magento\Framework\Stdlib\DateTime\Filter\Date;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\View\Model\Layout\Update\ValidatorFactory;
use Magento\Framework\Filter\FilterManager;

class PostDataProcessor
{
    /**
     * @var Date
     */
    protected $dateFilter;

    /**
     * @var ValidatorFactory
     */
    protected $validatorFactory;

    /**
     * @var ManagerInterface
     */
    protected $messageManager;

    /**
     * @var FilterManager
     */
    protected $filterManager;

    /**
     * @param Date $dateFilter
     * @param ManagerInterface $messageManager
     * @param ValidatorFactory $validatorFactory
     * @param FilterManager $filterManager
     */
    public function __construct(
        Date $dateFilter,
        ManagerInterface $messageManager,
        ValidatorFactory $validatorFactory,
        FilterManager $filterManager
    ) {
        $this->dateFilter = $dateFilter;
        $this->messageManager = $messageManager;
        $this->validatorFactory = $validatorFactory;
        $this->filterManager = $filterManager;
    }

    /**
     * Filtering posted data. Converting localized data if needed
     *
     * @param array $data
     * @return array
     */
    public function filter($data)
    {
        foreach (['custom_theme_from', 'custom_theme_to'] as $dateField) {
            if (!empty($data[$dateField])) {
                // Apply date filter
                $data[$dateField] = $this->dateFilter->filter($data[$dateField]);
            }
        }

        // Apply other necessary filters (stripTags and PHP's native trim)
        foreach (['title', 'description'] as $field) {
            if (isset($data[$field])) {
                $data[$field] = $this->filterManager->stripTags($data[$field]); // Strip HTML tags
                $data[$field] = trim($data[$field]); // Trim whitespace using native PHP function
            }
        }

        return $data;
    }

    /**
     * Validate post data
     *
     * @param array $data
     * @return bool     Return FALSE if some item is invalid
     */
    public function validate($data)
    {
        $errorNo = true;
        if (!empty($data['layout_update_xml']) || !empty($data['custom_layout_update_xml'])) {
            /** @var $validatorCustomLayout \Magento\Framework\View\Model\Layout\Update\Validator */
            $validatorCustomLayout = $this->validatorFactory->create();
            if (!empty($data['layout_update_xml']) && !$validatorCustomLayout->isValid($data['layout_update_xml'])) {
                $errorNo = false;
            }
            if (!empty($data['custom_layout_update_xml']) && !$validatorCustomLayout->isValid($data['custom_layout_update_xml'])) {
                $errorNo = false;
            }
            foreach ($validatorCustomLayout->getMessages() as $message) {
                $this->messageManager->addError($message);
            }
        }
        return $errorNo;
    }

    /**
     * Check if required fields are not empty
     *
     * @param array $data
     * @return bool
     */
    public function validateRequireEntry(array $data)
    {
        $requiredFields = [
            'title' => __('Title')
        ];
        $errorNo = true;
        foreach ($data as $field => $value) {
            if (in_array($field, array_keys($requiredFields)) && $value == '') {
                $errorNo = false;
                $this->messageManager->addError(
                    __('To apply changes, you should fill in the required "%1" field', $requiredFields[$field])
                );
            }
        }
        return $errorNo;
    }
}
