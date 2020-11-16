<?php


namespace My\CustomDescription\Api;


interface CustomDescriptionsProviderInterface
{
    /**
     * @param string $customerEmail
     * @return array
     */
    public function getDescriptions(string $customerEmail);
}
