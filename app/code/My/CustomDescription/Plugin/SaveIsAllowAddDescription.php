<?php
declare(strict_types=1);

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
    public function __construct(
        CustomDescriptionRepository $customDescriptionRepository
    ) {
        $this->customDescriptionRepository = $customDescriptionRepository;
    }

    /**
     * Saving extension value - 'is_allowed_description'
     *
     * @param CustomerRepository $subject
     * @param object $data
     * @return mixed
     */
    public function afterSave(CustomerRepository $subject, $data)
    {
        $customerIsAllowedDescription =
            $data->getExtensionAttributes()->getAllowAddDescription() ?? $data->setExtensionAttributes();
        if (is_bool($customerIsAllowedDescription)) {
            $customerEmail = $data->getEmail();
            $currentIsAllowedDescription = (bool)(int)$_POST['customer']['is_allowed_description'] ??
                $customerIsAllowedDescription;
            $this->customDescriptionRepository->save($customerEmail, $currentIsAllowedDescription);
        }
        return $data;
    }
}
