<?php

namespace Luxury\LuxuryTax\Api;

use AdvancedCoder\ProductTypes\Api\Data\ProductTypesInterface;
use Luxury\LuxuryTax\Api\Data\ItemInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

interface ItemRepositoryInterface
{

    /**
     * @param $id
     * @return mixed
     */
    public function getById($id);

    /**
     * @param $id
     * @return mixed
     */
    public function deleteById($id);

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return \Luxury\LuxuryTax\Api\Data\ItemSearchResultInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * @return ItemInterface[]
     */
    public function getAllItems();

    //_________________________________________________________________________________
    /**
     * @param ItemInterface $productTypes
     * @return ItemInterface
     */
    public function save(ItemInterface $productTypes): ItemInterface;

    /**
     * @param ItemInterface $workingHours
     * @return bool
     */
    public function delete(ItemInterface $workingHours): bool;

    /**
     * @param int $id
     * @return ItemInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function get(int $id): ItemInterface;
}
