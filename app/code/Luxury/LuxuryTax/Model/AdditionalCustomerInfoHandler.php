<?php
declare(strict_types=1);

namespace Luxury\LuxuryTax\Model;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Api\Data\CustomerExtensionInterfaceFactory;
use Magento\Customer\Api\Data\CustomerInterface;

class AdditionalCustomerInfoHandler
{
    private CustomerRepositoryInterface $customerRepository;
    private \Magento\Customer\Api\Data\CustomerExtensionInterfaceFactory $customerExtensionInterfaceFactory;
    private ReaderCustomerNumberOrder $readerCustomerNumberOrder;

    /**
     * @param CustomerRepositoryInterface $customerRepository
     * @param CustomerExtensionInterfaceFactory $customerExtensionInterfaceFactory
     * @param ReaderCustomerNumberOrder $readerCustomerNumberOrder
     */
    public function __construct(
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository,
        \Magento\Customer\Api\Data\CustomerExtensionInterfaceFactory $customerExtensionInterfaceFactory,
        \Luxury\LuxuryTax\Model\ReaderCustomerNumberOrder $readerCustomerNumberOrder
    ) {
        $this->customerRepository = $customerRepository;
        $this->customerExtensionInterfaceFactory = $customerExtensionInterfaceFactory;
        $this->readerCustomerNumberOrder = $readerCustomerNumberOrder;
    }

    /**
     * @param CustomerInterface $customer
     * @return void
     */
    public function addAdditionalInfoExtensionAttribute(\Magento\Customer\Api\Data\CustomerInterface $customer)
    {
        $extensionAttributes = $this->getExtensionAttributes($customer);

        $extensionAttributes->setNumberOfOrders($this->readerCustomerNumberOrder->getNumberOfOrdersForCustomer($customer->getEmail()));
        $extensionAttributes->setPreferredColour($customer->getCustomAttribute(Constant::LUXURYTAX)->getValue());
        $customer->setExtensionAttributes($extensionAttributes);
    }

//    /**
//     * @param CustomerInterface $customer
//     * @return \Magento\Customer\Api\Data\CustomerExtensionInterface|null
//     */
//    public function getExtensionAttributes(CustomerInterface $customer): ?\Magento\Customer\Api\Data\CustomerExtensionInterface
//    {
//        $extensionAttributes = $customer->getExtensionAttributes();
//        if ($extensionAttributes === null) {
//            $extensionAttributes = $this->customerExtensionInterfaceFactory->create();
//        }
//        return $extensionAttributes;
//    }
}
