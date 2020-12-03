<?php
declare(strict_types=1);

namespace My\CustomDescription\Plugin;

use Magento\Customer\Model\Customer\DataProviderWithDefaultAddresses;
use My\CustomDescription\Model\CustomDescriptionRepository;

/**
 * Get is allow add description plugin class.
 */
class GetIsAllowAddDescription
{

    /** @var CustomDescriptionRepository */
    private $customDescriptionRepository;

    /**
     * Plugin constructor.
     *
     * @param CustomDescriptionRepository   $customDescriptionRepository
     */
    public function __construct(
        CustomDescriptionRepository $customDescriptionRepository
    ) {
        $this->customDescriptionRepository = $customDescriptionRepository;
    }

    /**
     * Add custom data to customer data.
     *
     * @param DataProviderWithDefaultAddresses $subject
     * @param array                            $data
     * @return array
     */
    public function afterGetData(DataProviderWithDefaultAddresses $subject, array $data)
    {
        $customerEmail = current($data)['customer']['email'];
        $isAllowed = $this->customDescriptionRepository->getIsAllowedByEmail($customerEmail);
        foreach ($data as &$customerData) {
            $email = $customerData['customer']['email'] ?? '';
            if ($email && isset($isAllowed)) {
                $customerData['customer']['extension_attributes']['is_allowed_description'] = (string)(int)$isAllowed;
            }
        }

        return $data;
    }
}
