<?php
declare(strict_types=1);

namespace My\CustomDescription\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use My\CustomDescription\Api\Data\CustomDescriptionInterface;

/**
 * Interface CustomDescriptionRepositoryInterface
 * @package My\CustomDescription\Api
 */
interface CustomDescriptionRepositoryInterface
{
    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return CustomDescriptionInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria);
}
