<?php

namespace Luxury\LuxuryTax\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface ItemSearchResultInterface extends SearchResultsInterface
{
    /**
     * @return \Luxury\LuxuryTax\Api\Data\ItemInterface[]
     */
    public function getItems();

    /**
     * @param \Luxury\LuxuryTax\Api\Data\ItemInterface[] $items
     * @return ItemSearchResultInterface
     */
    public function setItems(array $items);
}
