<?php
declare(strict_types=1);

namespace My\CustomDescriptionToProduct\Block;

use Exception;
use Magento\Authorization\Model\UserContextInterface;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use My\CustomDescription\Model\CustomDescriptionRepository;

/**
 * Product additional comment form block.
 */
class Form extends Template
{
    /**
     * @var CustomDescriptionRepository
     */
    private $customDescriptionRepository;

    /**
     * @var UserContextInterface
     */
    private $userContextInterface;

    /**
     * @var CustomerRepositoryInterface
     */
    private $customerRepository;

    /**
     * @var Registry
     */
    private $coreRegistry;

    /**
     * Form Constructor
     *
     * @param Context                     $context
     * @param CustomDescriptionRepository $customDescriptionRepository
     * @param UserContextInterface        $userContextInterface
     * @param CustomerRepositoryInterface $customerRepository
     * @param Registry                    $coreRegistry
     * @param array                       $data
     */
    public function __construct(
        Context $context,
        CustomDescriptionRepository $customDescriptionRepository,
        UserContextInterface $userContextInterface,
        CustomerRepositoryInterface $customerRepository,
        Registry $coreRegistry,
        array $data = []
    ) {
        $this->userContextInterface        = $userContextInterface;
        $this->customDescriptionRepository = $customDescriptionRepository;
        $this->customerRepository          = $customerRepository;
        $this->coreRegistry                = $coreRegistry;
        parent::__construct($context, $data);
    }

    /**
     * Check for permission to add extra comment.
     *
     * @return bool
     * @throws Exception
     */
    public function checkIsAllow(): bool
    {
        $customerEmail = $this->getCustomerEmail();
        if ($customerEmail != false) {
            $isAllowedAdditionalComment = $this->customDescriptionRepository->getByEmail($customerEmail);
            return $isAllowedAdditionalComment;
        }

        return false;
    }

    /**
     * Put hidden inputs with custom comment params.
     *
     * @return string
     */
    public function getAdditionalInfo(): string
    {
        $currentProduct = $this->coreRegistry->registry('current_product');
        $customerEmail  = $this->getCustomerEmail();
        $productId      = $currentProduct->getId();
        $basePath       = $this->getUrl();
        $productUrl     = $currentProduct->getUrlKey();
        $productInfo    = '<input name="productUrl" type="hidden" value="' . $basePath . $productUrl . '.html' . '">' .
            '<input name="productId" type="hidden" value="' . $productId . '">' .
            '<input name="customerEmail" type="hidden" value="' . $customerEmail . '">';

        return $productInfo;
    }

    /**
     * Get Customer email.
     *
     * @return string|bool
     */
    public function getCustomerEmail()
    {
        $customerId = $this->userContextInterface->getUserId();
        try {
            $customer = $this->customerRepository->getById($customerId);
        } catch (NoSuchEntityException | LocalizedException $e) {
            return false;
        }

        return $customer->getEmail();
    }
}
