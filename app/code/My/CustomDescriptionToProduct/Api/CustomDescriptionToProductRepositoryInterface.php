<?php
declare(strict_types=1);

namespace My\CustomDescriptionToProduct\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use My\CustomDescriptionToProduct\Api\Data\CustomDescriptionToProductInterface;
use My\CustomDescriptionToProduct\Api\Data\CustomDescriptionToProductSearchResultInterface;

/**
 * Custom Description To Product Methods Repository Interface
 * @api
 */
interface CustomDescriptionToProductRepositoryInterface
{
    /**
     * Get CustomDescriptionToProductInterface by product id
     *
     * @param int $productId
     * @return array
     */
    public function getById(int $productId): array;

    /**
     * Get CustomDescriptionToProductInterface by comment id.
     *
     * @param string $commentId
     * @return array
     */
    public function getCommentByCommentId(string $commentId): array;

    /**
     * Get list of items in CustomDescriptionToProduct
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return CustomDescriptionToProductSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): CustomDescriptionToProductSearchResultInterface;

    /**
     * Save custom comment
     *
     * @param CustomDescriptionToProductInterface $customDescriptionToProduct
     * @return void
     */
    public function save(CustomDescriptionToProductInterface $customDescriptionToProduct): void;

    /**
     * Delete custom comment
     *
     * @param CustomDescriptionToProductInterface $customDescriptionToProduct
     * @return void
     */
    public function delete(CustomDescriptionToProductInterface $customDescriptionToProduct): void;
}
