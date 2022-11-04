<?php

namespace Luxury\LuxuryTax\Block\Adminhtml\Button;

class Reset extends \Magento\Catalog\Block\Adminhtml\Product\Edit\Button\Generic
{
    /**
     * @return array
     */
    public function getButtonData()
    {
        return [
            'label' => __('Reset'),
            'class' => 'reset',
            'on_click' => 'location.reload();',
            'sort_order' => 30,
        ];
    }
}
