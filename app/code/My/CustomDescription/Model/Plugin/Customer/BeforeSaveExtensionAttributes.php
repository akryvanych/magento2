<?php
declare(strict_types = 1);

namespace My\CustomDescription\Model\Plugin\Customer;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Api\Data\CustomerInterface;
use My\CustomDescription\Model\CustomDescriptionRepository;

/**
 * Before save extension attributes plugin
 */
class BeforeSaveExtensionAttributes
{
    private $customDescriptionRepository;

    /**
     * Before save
     *
     * @param CustomerRepositoryInterface $subject
     * @param CustomerInterface           $customer
     *
     * @return $customer
     */

    /**
     * BeforeSave Constructor.
     *
     * @param CustomDescriptionRepository $customDescriptionRepository
     */
    public function __construct(CustomDescriptionRepository $customDescriptionRepository)
    {
        $this->customDescriptionRepository = $customDescriptionRepository;
    }

    /**
     * Update already exist customer
     *
     * @param CustomerRepositoryInterface $subject
     * @param CustomerInterface           $customer
     */
    public function beforeSave(
        CustomerRepositoryInterface $subject,
        CustomerInterface $customer
    ) {
        $customerIsAllowedDescription =
            $customer->getExtensionAttributes()->getIsAllowedDescription() ?? 'newCustomer';
        if ($customerIsAllowedDescription != 'newCustomer') {
            $customerEmail = $customer->getEmail();
            $this->customDescriptionRepository->save($customerEmail, (bool) $customerIsAllowedDescription);
        }
    }
}
