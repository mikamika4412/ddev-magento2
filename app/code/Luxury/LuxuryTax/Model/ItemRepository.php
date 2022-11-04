<?php

namespace Luxury\LuxuryTax\Model;

use Luxury\LuxuryTax\Api\Data\ItemInterface;
use Luxury\LuxuryTax\Api\ItemRepositoryInterface;
use Luxury\LuxuryTax\Model\ResourceModel\Item\CollectionFactory;
use Luxury\LuxuryTax\Model\ResourceModel\Item as ItemResource;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Luxury\LuxuryTax\Api\Data\ItemSearchResultInterface;
use Luxury\LuxuryTax\Api\Data\ItemSearchResultInterfaceFactory;
use Luxury\LuxuryTax\Model\ItemFactory;

class ItemRepository implements ItemRepositoryInterface
{

    /**
     * @var \Luxury\LuxuryTax\Model\ItemFactory
     */
    private $itemFactory;
    /**
     * @var Item|ItemResource
     */
    private $itemResource;
    /**
     * @var CollectionFactory
     */
    private $collectionFactory;
    /**
     * @var ItemSearchResultInterfaceFactory
     */
    private $searchResultFactory;
    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;


    /**
     * @param ItemFactory $itemFactory
     * @param Item $itemResource
     * @param CollectionFactory $collectionFactory
     * @param ItemSearchResultInterfaceFactory $itemSearchResultInterfaceFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        ItemFactory $itemFactory,
        ItemResource $itemResource,
        CollectionFactory $collectionFactory,
        ItemSearchResultInterfaceFactory $itemSearchResultInterfaceFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->itemFactory = $itemFactory;
        $this->itemResource = $itemResource;
         $this->collectionFactory = $collectionFactory;
        $this->searchResultFactory = $itemSearchResultInterfaceFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * @param int $id
     * @return \Luxury\LuxuryTax\Api\Data\ItemInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($id)
    {
        $item = $this->itemFactory->create();
        $this->itemResource->load($item, $id);
        if (!$item->getId()) {
            throw new NoSuchEntityException(__('Unable to find News with ID "%1"', $id));
        }
        return $item;
    }

    /**
     * @param $id
     * @return bool
     * @throws NoSuchEntityException
     */
    public function deleteById($id)
    {
        $item = $this->getById($id);
        try {
            $this->itemResource->delete($item);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(
                __('Could not delete the entry: %1', $exception->getMessage())
            );
        }
        return true;
    }

    /**
     * @return ItemInterface[]|\Magento\Framework\DataObject[]
     */
    public function getAllItems()
    {
        return $this->collectionFactory->create()->getItems();
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return \Luxury\LuxuryTax\Api\Data\ItemSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->collectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);
        $searchResults = $this->searchResultFactory->create();

        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());

        return $searchResults;
    }

    /**
     * @param ItemInterface $productTypes
     * @return ItemInterface
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     */
    public function save(ItemInterface $productTypes): ItemInterface
    {
        $this->itemResource->save($productTypes);
        return $productTypes;
    }

    /**
     * @param ItemInterface $workingHours
     * @return bool
     */
    public function delete(ItemInterface $workingHours): bool
    {
        try {
            $this->itemResource->delete($workingHours);
        } catch (\Exception $e) {
            throw new StateException(__('Unable to remove entity #%1', $workingHours->getId()));
        }
        return true;
    }


    /**
     * @param int $id
     * @return mixed
     * @throws NoSuchEntityException
     */
    public function get(int $id):ItemInterface
    {
        $object = $this->itemFactory->create();

        $this->itemResource->load($object, $id);

        if (!$object->getId()) {
            throw new NoSuchEntityException(__('Unable to find entity with ID "%1"', $id));
        }
        return $object;
    }
}
