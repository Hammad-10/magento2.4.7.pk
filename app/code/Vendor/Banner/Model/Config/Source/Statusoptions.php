<?php

namespace Vendor\Banner\Model\Config\Source;


use Magento\Framework\Data\OptionSourceInterface;


class Statusoptions implements OptionSourceInterface
{

public function toOptionArray(){

return [

['label' => __('Active'), 'value' => '1'],
['label' => __('Not Active'), 'value' => '2'],

];
}
}
