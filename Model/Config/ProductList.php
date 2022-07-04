<?php

namespace Oderco\DayOffer\Model\Config;

use Magento\Framework\Option\ArrayInterface;

class ProductList implements ArrayInterface
{

    protected $collectionFactory;

    public function __construct(\Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $collectionFactory )
    {
        $this->collectionFactory = $collectionFactory;
    }

    public function toOptionArray()
    {
        $collection = $this->collectionFactory->create();
        $collection
            ->addAttributeToSelect('id')
            ->addAttributeToSelect('name');

        $ret    	= [];
        foreach ($collection as $product) {
            $ret[] = [
                'value' => $product->getId(),
                'label' => $product->getName(),
            ];
        }
        return $ret;
    }
}
