<?php

namespace Luxury\LuxuryTax\Model\ResourceModel\Item;

use Luxury\LuxuryTax\Api\Data\ItemInterface;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Luxury\LuxuryTax\Model\Item;
use Luxury\LuxuryTax\Model\ResourceModel\Item as ItemResource;

class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'id';

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(Item::class, ItemResource::class);
    }

    public function toOptionArray()
    {
        return $this->_toOptionArray(ItemInterface::ID, ItemInterface::NAME, ItemInterface::DESCRIPTION);
    }
}
