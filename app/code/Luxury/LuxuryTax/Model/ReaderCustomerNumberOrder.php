<?php
declare(strict_types=1);

namespace Luxury\LuxuryTax\Model;

use Magento\Framework\App\ResourceConnection;

class ReaderCustomerNumberOrder
{
    private ResourceConnection $resourceConnection;

    /**
     * @param ResourceConnection $resourceConnection
     */
    public function __construct(
        ResourceConnection $resourceConnection
    ) {
        $this->resourceConnection = $resourceConnection;
    }

    /**
     * @param string $customerEmail
     * @return int
     */
    public function getNumberOfOrdersForCustomer(string $customerEmail): int
    {
        $select = $this->getConnection()->select()->from(
            $this->getConnection()->getTableName('sales_order')
        )->where('customer_email=?', $customerEmail)
            ->reset(\Zend_Db_Select::COLUMNS)
            ->columns(['COUNT(*)']);

        return (int) $this->getConnection()->fetchOne($select);
    }

    /**
     * @return \Magento\Framework\DB\Adapter\AdapterInterface
     */
    public function getConnection(): \Magento\Framework\DB\Adapter\AdapterInterface
    {
        return $this->resourceConnection->getConnection();
    }
}
