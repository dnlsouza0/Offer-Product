<?php

namespace Oderco\DayOffer\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

class Times implements ArrayInterface
{
    /**
     * Return array of options as value-label pairs
     *
     * @return array Format: array(array('value' => '<value>', 'label' => '<label>'), ...)
     */
    public function toOptionArray()
    {
        return [['value' => '86400', 'label' => __('24h')], ['value' => '300', 'label' => __('5m')]];
    }
}
