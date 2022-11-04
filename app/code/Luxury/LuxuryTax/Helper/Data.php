<?php

namespace Luxury\LuxuryTax\Helper;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Helper\Context;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Model\Session;
use Magento\Framework\App\Helper\AbstractHelper;
use Luxury\LuxuryTax\Model\ItemRepository;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Setup\Exception;

/**
 * Products helper
 */
class Data extends AbstractHelper
{

    /**
     * @var Session
     */
    protected $_customerSession;

    /**
     * @var CustomerRepositoryInterface
     */
    protected $customerRepository;

    /**
     * @var ItemRepository
     */
    protected $itemRepository;

    /**
     * @var SearchCriteriaBuilder
     */
    protected $searchCriteriaBuilder;


    /**
     * @param Context $context
     * @param CustomerRepositoryInterface $customerRepository
     * @param Session $customerSession
     * @param ItemRepository $itemRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     */
    public function __construct(
        Context $context,
        CustomerRepositoryInterface $customerRepository,
        Session $customerSession,
        ItemRepository $itemRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
        parent::__construct($context);
        $this->_customerSession = $customerSession;
        $this->customerRepository = $customerRepository;
        $this->itemRepository = $itemRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }


    /**
     * @return int|null
     */
    public function getCustomerId()
    {

        $t = $this->_customerSession->getCustomerId();
        if ($t == null) {
            $t = "1";
        }
        return $t;
    }


    /**
     * @param $customerId
     * @return \Magento\Framework\Api\AttributeInterface|null
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getAttributeLuxuryTax($customerId)
    {
        $customer = $this->customerRepository->getById($customerId);
        return $customer->getCustomAttribute('luxuryTax');
    }

    /**
     * @param $customerId
     * @return mixed|null
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getLuxuryAttribute($customerId)
    {
        $luxuryTaxAttribute = $this->getAttributeLuxuryTax($customerId);
        $this->searchCriteriaBuilder->addFilter('customer_group', $luxuryTaxAttribute->getValue());
        $searchCriteria = $this->searchCriteriaBuilder->create();
        $luxuryTaxAttributes = $this->itemRepository->getList($searchCriteria)->getItems();
        return array_shift($luxuryTaxAttributes);
    }

    /**
     * @param $customerId
     * @param $subtotal
     * @return int
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getLuxuryTaxAmount($customerId, $subtotal)
    {
        $attribute = $this->getLuxuryAttribute($customerId);
        if ($attribute) {
            $taxRate = $attribute->getTaxRate();
            if ($subtotal >= $taxRate) {
                return $attribute->getConditionAmount();
            } else {
                return 0;
            }
        } else {
            return 0;
        }
    }

}
