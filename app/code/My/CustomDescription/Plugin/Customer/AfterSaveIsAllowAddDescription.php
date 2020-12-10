<?php
declare(strict_types=1);

namespace My\CustomDescription\Plugin\Customer;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Exception\NoSuchEntityException;
use My\CustomDescription\Api\CustomDescriptionRepositoryInterface;
use My\CustomDescription\Api\Data\CustomDescriptionInterface;

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

    /**
     * Plugin Constructor
     *
     * @param CustomDescriptionRepositoryInterface $customDescriptionRepository
     * @param CustomDescriptionInterface $customDescriptionInterface
     *
     */
    public function __construct(
        CustomDescriptionRepositoryInterface $customDescriptionRepository,
        CustomDescriptionInterface $customDescriptionInterface
    ) {
        $this->customDescriptionRepository = $customDescriptionRepository;
        $this->customDescriptionInterface  = $customDescriptionInterface;
    }

    /**
     * Saving extension value - 'is_allowed_description' to the customer.
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @param CustomerRepositoryInterface $subject
     * @param CustomerInterface           $result
     * @param CustomerInterface           $customer
     * @return CustomerInterface
     * @throws NoSuchEntityException
     * @throws AlreadyExistsException
     */
    public function afterSave(
        CustomerRepositoryInterface $subject,
        CustomerInterface $result,
        CustomerInterface $customer
    ): CustomerInterface {
        $customDescriptionInterface   = $this->customDescriptionInterface;
        $customerEmail                = $customer->getEmail();
        $customerIsAllowedDescription = $customer->getExtensionAttributes()->getIsAllowedDescription() ??
            $this->customDescriptionRepository->getByEmail($customerEmail);
        $customDescriptionInterface->setIsAllowedDescription((bool) $customerIsAllowedDescription);
        $customDescriptionInterface->setCustomerEmail($customerEmail);
        $this->customDescriptionRepository->save($customDescriptionInterface);

        return $result;
    }
}
