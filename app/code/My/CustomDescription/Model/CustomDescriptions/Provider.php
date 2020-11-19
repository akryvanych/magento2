<?php

namespace My\CustomDescription\Model\CustomDescriptions;

use Magento\Framework\EntityManager\EntityManager;
use My\CustomDescription\Api\CustomDescriptionsProviderInterface;
use My\CustomDescription\Model\CustomDescriptionFactory;
use My\CustomDescription\Model\ResourceModel\CustomDescriptions\Loader;

/**
 * Class Provider
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
    public function getDescriptions(string $customerEmail): array
    {
        $customDescriptions = [];
        $ids = $this->loader->getCustomersByCustomerEmails($customerEmail);

        foreach ($ids as $id) {
            $customDescription = $this->customDescriptionFactory->create();
            $customDescriptions[] = $this->entityManager->load($customDescription, $id);
        }
        return $customDescriptions;
    }
}
