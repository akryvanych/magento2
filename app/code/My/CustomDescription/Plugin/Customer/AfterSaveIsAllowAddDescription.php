<?php
declare(strict_types=1);

namespace My\CustomDescription\Plugin\Customer;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Api\Data\CustomerInterface;
use My\CustomDescription\Api\CustomDescriptionRepositoryInterface;
use My\CustomDescription\Api\Data\CustomDescriptionInterface;
use My\CustomDescription\Model\CustomDescriptionFactory;

/**
 * Save is allow add description in custom db.
 */
class AfterSaveIsAllowAddDescription
{

    /** @var CustomDescriptionRepositoryInterface */
    private $customDescriptionRepository;

    /**
     * @var CustomDescriptionInterface
     */
    private $customDescriptionInterface;

    /** @var CustomDescriptionFactory */
    private $customDescriptionFactory;

    /**
     * Plugin Constructor
     *
     * @param CustomDescriptionRepositoryInterface $customDescriptionRepository
     * @param CustomDescriptionInterface $customDescriptionInterface
     * @param CustomDescriptionFactory $customDescriptionFactory
     *
     */
    public function __construct(
        CustomDescriptionRepositoryInterface $customDescriptionRepository,
        CustomDescriptionInterface $customDescriptionInterface,
        CustomDescriptionFactory $customDescriptionFactory
    ) {
        $this->customDescriptionRepository = $customDescriptionRepository;
        $this->customDescriptionInterface  = $customDescriptionInterface;
        $this->customDescriptionFactory = $customDescriptionFactory;
    }

    /**
     * Saving extension value - 'is_allowed_description' to the customer.
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @param CustomerRepositoryInterface $subject
     * @param CustomerInterface           $result
     * @param CustomerInterface           $customer
     * @return CustomerInterface
     */
    public function afterSave(
        CustomerRepositoryInterface $subject,
        CustomerInterface $result,
        CustomerInterface $customer
    ): CustomerInterface {
        $customDescriptionInterface   = $this->customDescriptionFactory->create();
        $customerEmail                = $customer->getEmail();
        $customerIsAllowedDescription = $customer->getExtensionAttributes()->getIsAllowedDescription() ??
            false;
        if ($customerIsAllowedDescription === null) {
            $customerIsAllowedDescription = false;
        }
        $customDescriptionInterface->setIsAllowedDescription((bool) $customerIsAllowedDescription);
        $customDescriptionInterface->setCustomerEmail($customerEmail);
        $this->customDescriptionRepository->save($customDescriptionInterface);
        return $result;
    }
}
