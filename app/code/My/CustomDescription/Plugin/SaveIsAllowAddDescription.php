<?php
declare(strict_types = 1);

namespace My\CustomDescription\Plugin;

use Magento\Customer\Model\ResourceModel\CustomerRepository;
use My\CustomDescription\Model\CustomDescriptionRepository;

/**
 * Set is allow add description plugin class.
 */
class SaveIsAllowAddDescription
{
    /** @var string */
    public const DESCRIPTION_TABLE = 'allow_add_description';

    /** @var CustomDescriptionRepository */
    private $customDescriptionRepository;

    /**
     * Plugin constructor.
     *
     * @param CustomDescriptionRepository $customDescriptionRepository
     */
    public function __construct(CustomDescriptionRepository $customDescriptionRepository)
    {
        $this->customDescriptionRepository = $customDescriptionRepository;
    }

    /**
     * Saving extension value - 'is_allowed_description'
     *
     * @param CustomerRepository $subject
     * @param object             $data
     * @return object
     */
    public function afterSave(CustomerRepository $subject, $data)
    {
        $customerIsAllowedDescription =
            $data->getExtensionAttributes()->getIsAllowedDescription() ?? '';
        if (is_bool($customerIsAllowedDescription)) {
            $customerEmail = $data->getEmail();
            $this->customDescriptionRepository->save($customerEmail, $customerIsAllowedDescription);
        }

        return $data;
    }
}
