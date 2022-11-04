<?php

namespace Luxury\LuxuryTax\Model;

use AdvancedCoder\ProductTypes\Api\Data\ProductTypesInterface;
use Luxury\LuxuryTax\Api\Data\ItemInterface;
use Magento\Framework\Model\AbstractModel;
//use Magento\Tests\NamingConvention\true\string;

class Item extends AbstractModel implements ItemInterface
{
    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(ResourceModel\Item::class);
    }

    /**
     * @param int $status
     * @return mixed
     */
    public function setStatus(int $status)
    {
        $this->setData(ItemInterface::STATUS, $status);
    }

    /**
     * @return mixed|null
     */
    public function getStatus()
    {
        return $this->_getData(ItemInterface::STATUS);
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->getData(ItemInterface::NAME);
    }

    /**
     * @param int $name
     * @return mixed
     */
    public function setName(int $name)
    {
        return $this->setName(ItemInterface::NAME, $name);
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->_getData(ItemInterface::DESCRIPTION);
    }

    /**
     * @param string $description
     * @return mixed
     */
    public function setDescription(int $description)
    {
        return $this->setData(ItemInterface::DESCRIPTION, $description);
    }

    /**
     * @return mixed
     */
    public function getConditionAmount()
    {
        return $this->_getData(ItemInterface::CONDITION_AMOUNT);
    }

    /**
     * @param int $conditionamount
     * @return mixed
     */
    public function setConditionAmount(int $conditionamount)
    {
        return $this->setData(ItemInterface::CONDITION_AMOUNT, $conditionamount);
    }

    /**
     * @return mixed
     */
    public function getTaxRate()
    {
        return $this->_getData(ItemInterface::TAX_RATE);
    }

    /**
     * @param int $taxrate
     * @return mixed
     */
    public function setTaxRate(int $taxrate)
    {
        return $this->setData(ItemInterface::TAX_RATE, $taxrate);
    }

    /**
     * @return mixed
     */
    public function getCustomergroup()
    {
        return $this->_getData(ItemInterface::CUSTOMERGROUP);
    }

    /**
     * @param int $customerGroup
     * @return mixed
     */
    public function setCustomergroup(int $customerGroup)
    {
        return $this->setData(ItemInterface::CUSTOMERGROUP, $customerGroup);
    }
}
