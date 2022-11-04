<?php

namespace Luxury\LuxuryTax\Model\Attribute\Source;

//use AdvancedCoder\Brend\Api\Data\BrendInterface;
use Luxury\LuxuryTax\Model\ItemRepository;
use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;

class Vendors extends AbstractSource
{
    /**
     * @var ItemRepository
     */
    private $itemRepository;

    /**
     * @var array
     */
    protected $_options = [];

    /**
     * @param ItemRepository $itemRepository
     */
    public function __construct(ItemRepository $itemRepository)
    {
        $this->itemRepository = $itemRepository;
    }

    /**
     * Get all options
     * @return array
     */
    public function getAllOptions()
    {
        $this->_options = [];
        foreach ($this->itemRepository->getAllItems() as $item) {
            $this->_options[] =

                [
                    'label' => __($item->getName()),
                    'value' => __($item->getCustomerGroup())
                ];
        }
        return $this->_options;
    }

}
