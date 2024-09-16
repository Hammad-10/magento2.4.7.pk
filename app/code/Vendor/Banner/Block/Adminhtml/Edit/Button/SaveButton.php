<?php

namespace Vendor\Banner\Block\Adminhtml\Edit\Button;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use Magento\Framework\View\Layout\Generic;

class SaveButton extends Generic implements ButtonProviderInterface
{
    public function getButtonData()
    {
        return [
            'label' => __('Save'),
            'class' => 'save primary',
            'on_click' => '',
            'sort_order' => 50,
            'data_attribute' => [
                'mage-init' => [
                    'Magento_Ui/js/form/button-adapter' => [
                        'actions' => [
                            [
                                'targetName' => 'banner_form.employee_form_data_source',
                                'actionName' => 'save',
                            ],
                        ],
                    ],
                ],

            ],
        ];
    }
}
