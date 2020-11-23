<?php

declare(strict_types=1);

namespace My\CustomDescription\Api;

/**
 * Interface Custom descriptions provider.
 */
interface CustomDescriptionsProviderInterface
{
    /**
     * Gets is allowed descriptions.
     *
     * @param string $customerEmail
     * @return array
     */
    public function getDescriptions(string $customerEmail): array;
}
