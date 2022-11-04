<?php

namespace Luxury\LuxuryTax\Api;

interface ItemSearchResultInterface extends \Magento\Framework\Api\SearchResultsInterface
{
    /**
     * @return \Luxury\LuxuryTax\Api\Data\ItemInterface[]
     */
    public function getItems();

    /**
     * @param \Luxury\LuxuryTax\Api\Data\ItemInterface[]
     * @return void
     */
    public function setItems(array $items);
}
