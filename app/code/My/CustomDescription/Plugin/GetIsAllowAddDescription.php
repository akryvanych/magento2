<?php
declare(strict_types = 1);

namespace My\CustomDescription\Plugin;

use Magento\Customer\Model\Customer\DataProviderWithDefaultAddresses;
use My\CustomDescription\Model\CustomDescriptionRepository;

/**
 * Get is allow add description for customer form.
 */
class GetIsAllowAddDescription
{

    /** @var CustomDescriptionRepository */
    private $customDescriptionRepository;

    /**
     * Plugin constructor.
     *
     * @param CustomDescriptionRepository $customDescriptionRepository
     */
    public function __construct(
        CustomDescriptionRepository $customDescriptionRepository
    ) {
        $this->customDescriptionRepository = $customDescriptionRepository;
    }

    /**
     * Add custom data to customer data.
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @param DataProviderWithDefaultAddresses $subject
     * @param array                            $data
     * @return array
     */
    public function afterGetData(DataProviderWithDefaultAddresses $subject, array $data): array
    {
        foreach ($data as &$customerData) {
            $customerEmail = $customerData['customer']['email'];
            $isAllowed     = $this->customDescriptionRepository->getByEmail($customerEmail);
            $email         = $customerEmail ?? null;
            if ($email && isset($isAllowed)) {
                $customerData['customer']['extension_attributes']['is_allowed_description'] =
                    $isAllowed->getIsAllowedDescription();
            }
        }

        return $data;
    }
}
