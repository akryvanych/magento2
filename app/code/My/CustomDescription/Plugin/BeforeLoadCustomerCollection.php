<?php
declare(strict_types=1);

namespace My\CustomDescription\Plugin;

use Magento\Customer\Model\ResourceModel\Grid\Collection;

/**
 * Add allow_add_description to customer admin grid
 */
class BeforeLoadCustomerCollection
{
    /**
     * Add custom row to the customer grid
     *
     * @param Collection $collection
     */
    public function beforeLoad(Collection $collection)
    {
        $collection->join('allow_add_description', 'email = customer_email', 'is_allowed_description');
    }
}
