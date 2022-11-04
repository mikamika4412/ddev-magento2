<?php

namespace Luxury\LuxuryTax\Model\Resolver;

use Luxury\LuxuryTax\Api\ItemRepositoryInterface;
use Luxury\LuxuryTax\Model\ItemRepository;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\CustomerGroup\Api\CustomerGroupRepositoryInterface;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Query\Resolver\ContextInterface;
use Magento\Framework\GraphQl\Query\Resolver\Value;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Luxury\LuxuryTax\Model\ResourceModel\Item\CollectionFactory;
use \Luxury\LuxuryTax\Observer\CustomerSaveAfter;
class ProductTypesToProduct implements ResolverInterface
{
    private CustomerRepositoryInterface $productRepository;
    private ItemRepositoryInterface $productTypesRepository;
    private CollectionFactory $collectionFactory;


    /**
     * @param CustomerRepositoryInterface $productRepository
     * @param ItemRepositoryInterface $productTypesRepository
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        CustomerRepositoryInterface $productRepository,
        ItemRepositoryInterface $productTypesRepository,
        CollectionFactory $collectionFactory
    ) {
        $this->productRepository = $productRepository;
        $this->productTypesRepository = $productTypesRepository;
        $this->collectionFactory = $collectionFactory;

    }

    /**
     * @param Field $field
     * @param ContextInterface $context
     * @param ResolveInfo $info
     * @param array|null $value
     * @param array|null $args
     * @return array
     * @throws GraphQlInputException
     */
    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        $productId = trim($args['productId']);
        $typeId = trim($args['typeId']);


        if (empty($productId) || empty($typeId)) {
            throw new GraphQlInputException(
                __('You must specify an productId and typeId.')
            );
        }

        try {
            $this->productTypesRepository->get($typeId);
            $group_id = $this->collectionFactory->create()->getItemById($typeId)->getData('customer_group');
            $product = $this->productRepository->getById($productId);
//            $product->setCustomAttribute('luxuryTax',$typeId);
            $product->setCustomAttribute('luxuryTax',$group_id);
            $product->setGroupId($group_id);
            $this->productRepository->save($product);


            return [
                'success' => true,
                'error' => '',
            ];
        } catch (\Exception $exception) {
            return [
                'success' => false,
                'error' => $exception->getMessage(),
            ];
        }
    }
}
