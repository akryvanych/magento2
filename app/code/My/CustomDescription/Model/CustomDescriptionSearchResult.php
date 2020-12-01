<?php
declare(strict_types=1);

namespace My\CustomDescription\Model;

use Magento\Framework\Api\SearchResults;
use My\CustomDescription\Api\Data\CustomDescriptionSearchResultInterface;

/**
 *  Custom Description search result
 */
class CustomDescriptionSearchResult extends SearchResults implements CustomDescriptionSearchResultInterface
{
}
