<?php
declare(strict_types=1);

namespace My\CustomDescription\Api;

use Magento\Framework\Exception\NoSuchEntityException;
use My\CustomDescription\Api\Data\CustomDescriptionInterface;

/**
 * Custom Description Methods Repository Interface
 * @api
 */
interface CustomDescriptionRepositoryInterface
{

    /**
     * Get CustomDescriptionInterface by email
     *
     * @param string $customerEmail
     * @return CustomDescriptionInterface
     * @throws NoSuchEntityException
     */
    public function getByEmail(string $customerEmail): CustomDescriptionInterface;

    /**
     * Save CustomDescriptionInterface in "allow_add_description" table
     *
     * @param CustomDescriptionInterface $customDescription
     */
    public function save(CustomDescriptionInterface $customDescription);
}
