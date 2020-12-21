<?php
declare(strict_types=1);

namespace My\CustomDescriptionToProduct\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

/**
 * Product additional comment tab.
 *
 * @api
 */
class ExtraReview extends Template
{

    /**
     * Extra Review Constructor
     *
     * @param Context $context
     * @param array $data
     */
    public function __construct(
        Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);

        $this->setTabTitle();
    }

    /**
     * Set tab title
     *
     * @return void
     */
    public function setTabTitle()
    {
        $title = 'Custom comments';
        $this->setTitle($title);
    }
}
