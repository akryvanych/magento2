<?php

declare(strict_types=1);

namespace My\CustomDescription\Model\CustomDescriptions;

use Magento\Framework\EntityManager\EntityManager;
use My\CustomDescription\Api\CustomDescriptionsProviderInterface;
use My\CustomDescription\Model\CustomDescriptionFactory;
use My\CustomDescription\Model\ResourceModel\CustomDescriptions\Loader;

/**
 * Custom Description Provider
 * @package My\CustomDescription\Model\CustomDescriptions
 */
class Provider implements CustomDescriptionsProviderInterface
{
    /** @var  EntityManager */
    private $entityManager;

    /** @var  Loader */
    private $loader;

    /**
     * @var CustomDescriptionFactory
     */
    private $customDescriptionFactory;

    /**
     * Provider constructor.
     * @param EntityManager $entityManager
     * @param Loader $loader
     * @param CustomDescriptionFactory $customDescriptionFactory
     */
    public function __construct(
        EntityManager $entityManager,
        Loader $loader,
        CustomDescriptionFactory $customDescriptionFactory
    ) {
        $this->entityManager = $entityManager;
        $this->loader = $loader;
        $this->customDescriptionFactory = $customDescriptionFactory;
    }

    /**
     * @inheritdoc
     * @throws \Exception
     */
    public function getIsAllowed(string $customerEmail): array
    {
        $customDescriptions = [];
        $email = $this->loader->getCustomersByCustomerEmails($customerEmail);
        $customDescription = $this->customDescriptionFactory->create();
        if ($email !== 'new_user') {
            $customDescriptions[] = $this->entityManager->load($customDescription, $email);
        } else {
            $customDescriptions[] = $this->entityManager->load($customDescription, $customerEmail);
            $customDescriptions[0]->setCustomerEmail($customerEmail);
        }
        return $customDescriptions;
    }
}
