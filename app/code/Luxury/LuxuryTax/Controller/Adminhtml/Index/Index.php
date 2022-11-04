<?php

namespace Luxury\LuxuryTax\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Framework\Controller\ResultFactory;

class Index extends Action
{

    const ADMIN_RESOURCE = 'Magento_Beckend::system';

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);

        $resultPage->setActiveMenu('Luxury_LuxuryTax::stores')
            ->addBreadcrumb(__('Luxury'), __('List'));
        $resultPage->getConfig()->getTitle()->prepend(__('Luxury tax'));

        return $resultPage;
    }
}
