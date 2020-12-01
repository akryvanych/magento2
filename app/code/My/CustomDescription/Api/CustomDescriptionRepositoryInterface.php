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
     * Get list of items in CustomDescriptionInterface
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return CustomDescriptionInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * Get allow add description by email
     *
     * @param string $customerEmail
     * @return CustomDescriptionInterface
     * @throws NoSuchEntityException
     */
    public function getIsAllowedByEmail(string $customerEmail);

    /**
     * Save Custom Description item
     *
     * @param string $customerEmail
     * @param bool $currentIsAllowedDescription
     */
    public function save(string $customerEmail, bool $currentIsAllowedDescription);
}
