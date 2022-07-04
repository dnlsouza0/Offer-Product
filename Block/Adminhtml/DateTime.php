<?php

namespace Oderco\DayOffer\Block\Adminhtml;

use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Registry;
use Magento\Backend\Block\Template\Context;

class DateTime extends Field
{
    protected $coreRegistry;

    public function __construct(
        Context  $context,
        Registry $coreRegistry,
        array    $data = []
    )
    {
        $this->coreRegistry = $coreRegistry;
        parent::__construct($context, $data);
    }

    public function render(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        $element->setDateFormat(\Magento\Framework\Stdlib\DateTime::DATE_INTERNAL_FORMAT);
        $element->setTimeFormat("HH:mm:ss"); //set date and time as per requirment
        return parent::render($element);
    }
}
