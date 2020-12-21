<?php
declare(strict_types=1);

namespace My\CustomDescriptionToProduct\Model\Data;

use Magento\Framework\Api\SearchResults;
use My\CustomDescriptionToProduct\Api\Data\CustomDescriptionToProductSearchResultInterface;

/**
 *  Custom Description search result
 */
class CustomDescriptionToProductSearchResult extends SearchResults
    implements CustomDescriptionToProductSearchResultInterface
{
}
