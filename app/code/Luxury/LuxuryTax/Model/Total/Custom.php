<?php

namespace Luxury\LuxuryTax\Model\Total;

use Magento\Quote\Model\Quote\Address\Total\AbstractTotal;
use Magento\Quote\Model\Quote;
use Magento\Quote\Api\Data\ShippingAssignmentInterface;
use Magento\Quote\Model\Quote\Address\Total;
use Luxury\LuxuryTax\Model\ItemRepository;
use Luxury\LuxuryTax\Helper\Data;
use Magento\Framework\Api\SearchCriteriaBuilder;


class Custom extends AbstractTotal
{
    /**
     * @var ItemRepository
     */
    protected $itemRepository;

    /**
     * @var Data
     */
    protected $helper;

    /**
     * @var int
     */
    private static $ConditionAmount;

    /**
     * @var
     */
    protected $attributeCollection;

    /**
     * @var SearchCriteriaBuilder
     */
    protected $searchCriteriaBuilder;

    /**
     * Custom constructor.
     */
    public function __construct(
        ItemRepository $itemRepository,
        Data $helper,
        SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
        $this->setCode('custom_amount');
        $this->itemRepository = $itemRepository;
        $this->helper = $helper;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    /**
     * @param Quote $quote
     * @param ShippingAssignmentInterface $shippingAssignment
     * @param Total $total
     * @return $this
     */
    public function collect(
        Quote $quote,
        ShippingAssignmentInterface $shippingAssignment,
        Total $total
    ) {
        parent::collect($quote, $shippingAssignment, $total);

        $items = $shippingAssignment->getItems();
        if (!count($items)) {
            return $this;
        }

        $customerId = $this->helper->getCustomerId();
        $luxuryAttribute = $this->getAttributeLuxuryTax($customerId);
        if ($luxuryAttribute) {
            self::$ConditionAmount = $this->getLuxuryTaxAmount($customerId, $total);
//            $taxRate = $luxuryAttribute->getTaxRate();
            $taxRate = $luxuryAttribute->getConditionAmount();
            if ($total->getData('subtotal') >= $taxRate) {
                $total->setCustomAmount(self::$ConditionAmount);
                $total->setBaseCustomAmount(self::$ConditionAmount);
                $total->setGrandTotal($total->getGrandTotal() + self::$ConditionAmount);
                $total->setBaseGrandTotal($total->getBaseGrandTotal() + self::$ConditionAmount);
            }
        }
        return $this;
    }

    /**
     * @param Total $total
     */
    protected function clearValues(Total $total)
    {
        $total->setTotalAmount('subtotal', 0);
        $total->setBaseTotalAmount('subtotal', 0);
        $total->setTotalAmount('tax', 0);
        $total->setBaseTotalAmount('tax', 0);
        $total->setTotalAmount('discount_tax_compensation', 0);
        $total->setBaseTotalAmount('discount_tax_compensation', 0);
        $total->setTotalAmount('shipping_discount_tax_compensation', 0);
        $total->setBaseTotalAmount('shipping_discount_tax_compensation', 0);
        $total->setSubtotalInclTax(0);
        $total->setBaseSubtotalInclTax(0);
    }

    /**
     * @param Quote $quote
     * @param Total $total
     * @return array
     */
    public function fetch(Quote $quote, Total $total)
    {
        self::$ConditionAmount = $this->getLuxuryTaxAmount($this->helper->getCustomerId(), $total);
        return [
            'code' => $this->getCode(),
            'title' => 'Luxury Tax Amount',
            'value' => self::$ConditionAmount
        ];
    }

    /**
     * @return \Magento\Framework\Phrase
     */
    public function getLabel()
    {
        return __('Luxury Tax Amount');
    }

    /**
     * @param $customerId
     * @return mixed|null
     */
    protected function getAttributeLuxuryTax($customerId)
    {
        $luxuryTaxAttribute = $this->helper->getAttributeLuxuryTax($customerId);
        $this->searchCriteriaBuilder->addFilter('customer_group', $luxuryTaxAttribute->getValue());
        $searchCriteria = $this->searchCriteriaBuilder->create();
        $luxuryTaxAttributes = $this->itemRepository->getList($searchCriteria)->getItems();
        return array_shift($luxuryTaxAttributes);
    }

    /**
     * @param $customerId
     * @param Total $total
     * @return int
     */
    protected function getLuxuryTaxAmount($customerId, Total $total)
    {
        $attribute = $this->getAttributeLuxuryTax($customerId);
        if ($attribute) {
            $taxRate = $attribute->getTaxRate();
            if ($total->getData('subtotal') >= $taxRate) {
                return $attribute->getConditionAmount();
            } else {
                return 0;
            }
        } else {
            return 0;
        }
    }
}
