<?php
declare(strict_types=1);

namespace My\CustomDescription\Plugin\Customer;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Exception\NoSuchEntityException;
use My\CustomDescription\Api\CustomDescriptionRepositoryInterface;

/**
 * Save is allow add description in custom db.
 */
class AfterSaveIsAllowAddDescription
{

    /** @var CustomDescriptionRepositoryInterface */
    private $customDescriptionRepository;

    /**
     * CustomDescriptionRepository
     *
     * @param CustomDescriptionRepositoryInterface $customDescriptionRepository
     */
    public function __construct(CustomDescriptionRepositoryInterface $customDescriptionRepository)
    {
        $this->customDescriptionRepository = $customDescriptionRepository;
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
     */
    public function afterSave(
        CustomerRepositoryInterface $subject,
        CustomerInterface $result,
        CustomerInterface $customer
    ): CustomerInterface {
        $customerEmail = $result->getEmail();
        $customDescriptionInterface = $this->customDescriptionRepository->getByEmail($customerEmail);
        $customerIsAllowedDescription =
            $customer->getExtensionAttributes()->getIsAllowedDescription() ?? $customer->getExtensionAttributes()
                ->setIsAllowedDescription(false)->getIsAllowedDescription();
        $customDescriptionInterface->setIsAllowedDescription((bool)$customerIsAllowedDescription);
        $this->customDescriptionRepository->save($customDescriptionInterface);

        return $result;
    }
}
