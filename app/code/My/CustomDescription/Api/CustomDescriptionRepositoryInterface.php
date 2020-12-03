<?php
declare(strict_types=1);

namespace My\CustomDescription\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use My\CustomDescription\Api\Data\CustomDescriptionInterface;

/**
 * Custom Description Repository Interface
 * @api
 */
interface CustomDescriptionRepositoryInterface
{
    /**
     * Get list of is_allowed_descriptions in CustomDescriptionInterface
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return CustomDescriptionInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * Get is_allowed_description by email
     *
     * @param string $customerEmail
     * @return CustomDescriptionInterface
     * @throws NoSuchEntityException
     */
    public function getIsAllowedByEmail(string $customerEmail);

    /**
     * Save Custom Description in "allow_add_description" table
     *
     * @param string $customerEmail
     * @param bool $currentIsAllowedDescription
     */
    public function save(string $customerEmail, bool $currentIsAllowedDescription);
}
