<?php
declare(strict_types=1);

namespace Luxury\LuxuryTax\Plugin;

use Luxury\LuxuryTax\Model\AdditionalCustomerInfoHandler;

class AssignAdditionalData
{
    private \Luxury\LuxuryTax\Model\AdditionalCustomerInfoHandler $additionalCustomerInfoHandler;

    /**
     * @param AdditionalCustomerInfoHandler $additionalCustomerInfoHandler
     */
    public function __construct(
        \Luxury\LuxuryTax\Model\AdditionalCustomerInfoHandler $additionalCustomerInfoHandler
    ) {
        $this->additionalCustomerInfoHandler = $additionalCustomerInfoHandler;
    }

    public function afterGet(
        \Magento\Customer\Api\CustomerRepositoryInterface $subject,
        \Magento\Customer\Api\Data\CustomerInterface $customer
    ) {
        $this->addAdditionalInfoExtensionAttribute($customer);
        return $customer;
    }

    public function afterGetList(
        \Magento\Customer\Api\CustomerRepositoryInterface $subject,
        \Magento\Customer\Api\Data\CustomerSearchResultsInterface $results
    ) {
        array_map([$this, 'addAdditionalInfoExtensionAttribute'], $results->getItems());
        return $results;
    }

    private function addAdditionalInfoExtensionAttribute(\Magento\Customer\Api\Data\CustomerInterface $customer)
    {
        $this->additionalCustomerInfoHandler->addAdditionalInfoExtensionAttribute($customer);
    }
}
