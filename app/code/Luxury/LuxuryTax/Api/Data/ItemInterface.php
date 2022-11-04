<?php

namespace Luxury\LuxuryTax\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

//interface ItemInterface extends ExtensibleDataInterface
interface ItemInterface
{
    const ENTITY_ID = 'id';
//    const ID = 'id';
    const NAME = 'name';
    const DESCRIPTION = 'description';
    const CUSTOMERGROUP = 'customer_group';
    const STATUS = 'status';
    const CONDITION_AMOUNT = 'condition_amount';
    const TAX_RATE = 'tax_rate';
    const ID = 'id';

    /**
     * @return int
     */
    public function getId();

    /**
     * @param int $id
     * @return $this
     */
    public function setId(int $id);

    /**
     * @param int $status
     * @return $this
     */
    public function setStatus(int $status);

    /**
     * @return mixed
     */
    public function getStatus();

    /**
     * @return mixed
     */
    public function getName();

    /**
     * @param int $name
     * @return $this
     */
    public function setName(int $name);

    /**
     * @return mixed
     */
    public function getDescription();

    /**
     * @param int $description
     * @return $this
     */
    public function setDescription(int $description);

    /**
     * @return mixed
     */
    public function getCustomergroup();

    /**
     * @param int $customerGroup
     * @return $this
     */
    public function setCustomergroup(int $customerGroup);

    /**
     * @return mixed
     */
    public function getConditionAmount();

    /**
     * @param int $conditionamount
     * @return $this
     */
    public function setConditionAmount(int $conditionamount);

    /**
     * @return mixed
     */
    public function getTaxRate();

    /**
     * @param int $taxrate
     * @return $this
     */
    public function setTaxRate(int $taxrate);
}
