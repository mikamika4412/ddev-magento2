<?php
declare(strict_types=1);

namespace Luxury\LuxuryTax\Block\Adminhtml\Edit\Tab;


use Magento\Customer\Controller\RegistryConstants;

class Orders extends \Magento\Customer\Block\Adminhtml\Edit\Tab\Orders
{
    private \Magento\Framework\Registry $coreRegistry;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \Magento\Framework\View\Element\UiComponent\DataProvider\CollectionFactory $collectionFactory,
        \Magento\Sales\Helper\Reorder $salesReorder,
        \Magento\Framework\Registry $coreRegistry,
        array $data = []
    ) {
        parent::__construct($context, $backendHelper, $collectionFactory, $salesReorder, $coreRegistry, $data);
        $this->collectionFactory = $collectionFactory;
        $this->coreRegistry = $coreRegistry;
    }

    public function setCollection($collection)
    {
        $collection->join(
            ['sales_order' => 'sales_order'],
            'main_table.entity_id = sales_order.entity_id',
            ['luxuryTax']
        );

        parent::setCollection($collection);
    }

    /**
     * @return Orders|\Magento\Customer\Block\Adminhtml\Edit\Tab\Orders
     */
    protected function _prepareColumns()
    {

        $this->addColumnAfter('luxuryTax', array(
            'header' => __('Luxary Tax999'),
            'index' => 'luxuryTax'
        ), 'store_id');

        return parent::_prepareColumns();
    }
}
