<?php
declare(strict_types = 1);

namespace My\CustomDescription\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\NoSuchEntityException;
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
     * @return CustomDescriptionInterface
     * @throws NoSuchEntityException
     */
    public function getByEmail(string $customerEmail): CustomDescriptionInterface;

    /**
     * Get list of items in CustomDescriptionInterface
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return CustomDescriptionSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): CustomDescriptionSearchResultInterface;
}
