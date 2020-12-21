<?php
declare(strict_types=1);

namespace My\CustomDescriptionToProduct\Block;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use My\CustomDescriptionToProduct\Api\CustomDescriptionToProductRepositoryInterface as CustomCommentRepository;

/**
 * Custom comments list block for product.
 */
class CommentsList extends Template
{
    /**
     * @var Registry
     */
    private $coreRegistry;

    /**
     * @var CustomerRepositoryInterface
     */
    private $customerRepository;

    /**
     * @var CustomCommentRepository
     */
    private $customCommentRepository;

    /**
     * Comments List Constructor
     *
     * @param Context $context
     * @param Registry $registry
     * @param CustomerRepositoryInterface $customerRepository
     * @param CustomCommentRepository $customCommentRepository
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        CustomerRepositoryInterface $customerRepository,
        CustomCommentRepository $customCommentRepository,
        array $data = []
    ) {
        $this->coreRegistry = $registry;
        $this->customerRepository = $customerRepository;
        $this->customCommentRepository = $customCommentRepository;
        parent::__construct($context, $data);
    }

    /**
     * Get Product Id.
     *
     * @return string
     */
    public function getProductId(): string
    {
        $productObject = $this->coreRegistry->registry('current_product');

        return $productObject->getId();
    }

    /**
     * Get customer name.
     *
     * @param string $email
     * @return string
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function getCustomerName(string $email): string
    {
        $customer = $this->customerRepository->get($email);

        return $customer->getFirstname();
    }

    /**
     * Gets approved comment list array by custom repository.
     *
     * @return array
     */
    public function getCommentList(): array
    {
        return $this->customCommentRepository->getById((int)$this->getProductId());
    }

    /**
     * Check comment list on existing for current product.
     *
     * @return string
     */
    public function checkIsEmpty(): string
    {
        $commentList = $this->customCommentRepository->getById((int)$this->getProductId());
        if (count($commentList) == 0) {
            return 'empty';
        }
        return '';
    }
}
