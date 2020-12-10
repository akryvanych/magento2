<?php
declare(strict_types=1);

namespace My\CustomDescription\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use My\CustomDescription\Api\Data\CustomDescriptionInterface;
use My\CustomDescription\Api\Data\CustomDescriptionSearchResultInterface;

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
     * @return bool
     */
    public function getByEmail(string $customerEmail): bool;

    /**
     * Get list of items in CustomDescriptionInterface
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return CustomDescriptionSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): CustomDescriptionSearchResultInterface;

    /**
     * Save extension_attribute in db
     *
     * @param CustomDescriptionInterface $customDescription
     * @return void
     */
    public function save(CustomDescriptionInterface $customDescription): void;
}
