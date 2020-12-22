<?php
declare(strict_types=1);

namespace My\CustomDescriptionToProduct\Block\Adminhtml\Grid;

use Exception;
use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Widget\Grid\Extended;
use Magento\Backend\Helper\Data;
use Magento\Catalog\Model\Product;
use Magento\Framework\App\Request\Http as Request;
use My\CustomDescriptionToProduct\Model\ResourceModel\CustomDescriptionsToProduct\Grid\GridCollectionFactory as
    CustomCommentCollectionFactory;

/**
 * Product edit form custom comments grid block.
 */
class CustomCommentGrid extends Extended
{
    /**
     * @var Request
     */
    private $request;

    /**
     * @var CustomCommentCollectionFactory
     */
    private $additionalCommentCollectionFactory;

    /**
     * @var Product
     */
    private $product;

    /**
     * Custom Comment Grid constructor
     *
     * @param Context                        $context
     * @param Data                           $backendHelper
     * @param CustomCommentCollectionFactory $additionalCommentCollectionFactory
     * @param Request                        $request
     * @param Product                        $product
     * @param array                          $data
     */
    public function __construct(
        Context $context,
        Data $backendHelper,
        CustomCommentCollectionFactory $additionalCommentCollectionFactory,
        Request $request,
        Product $product,
        array $data = []
    ) {
        $this->additionalCommentCollectionFactory = $additionalCommentCollectionFactory;
        $this->request                            = $request;
        $this->product                            = $product;
        parent::__construct($context, $backendHelper, $data);
    }

    /**
     * Grid constructor.
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setDefaultSort('comment_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
    }

    /**
     * Prepare collection function.
     *
     * @return Extended
     */
    protected function _prepareCollection(): Extended
    {
        $productObj             = $this->product->load($this->request->getParam('id'));
        $productId              = $productObj->getId();
        $extraCommentCollection = $this->additionalCommentCollectionFactory->create()->addFieldToSelect('*');
        $extraCommentCollection->addFieldToFilter('product_id', $productId);
        $this->setCollection($extraCommentCollection);
        return parent::_prepareCollection();
    }

    /**
     * Prepare columns function.
     *
     * @return Extended
     * @throws Exception
     */
    protected function _prepareColumns(): Extended
    {
        $this->addColumn(
            'comment_id',
            [
                'header'           => __('Comment Id'),
                'type'             => 'number',
                'filter_index'     => 'comment_id',
                'index'            => 'comment_id',
                'header_css_class' => 'col-id',
                'column_css_class' => 'col-id',
            ]
        );
        $this->addColumn(
            'customer_email',
            [
                'header'           => __('Customer Email'),
                'type'             => 'text',
                'filter_index'     => 'customer_email',
                'index'            => 'customer_email',
                'header_css_class' => 'col-id',
                'column_css_class' => 'col-id',
            ]
        );
        $this->addColumn(
            'custom_customer_description_to_product',
            [

                'header'           => __('Comment'),
                'type'             => 'text',
                'filter_index'     => 'custom_customer_description_to_product',
                'index'            => 'custom_customer_description_to_product',
                'header_css_class' => 'col-id',
                'column_css_class' => 'col-id',
            ]
        );
        $this->addColumn(
            'is_approved',
            [
                'header'           => __('Approved'),
                'type' => 'options',
                'options' => [
                    1 => __('Approved'),
                    0 => __('Pending'),
                ],
                'filter_index'     => 'is_approved',
                'index'            => 'is_approved',
                'header_css_class' => 'col-id',
                'column_css_class' => 'col-id',
            ]
        );
        $this->addColumn(
            'action',
            [
                'header' => __('Actions'),
                'width' => '100px',
                'type' => 'action',
                'getter' => 'getCommentId',
                'actions' => [
                    [
                        'caption' => __('Delete'),
                        'url' => ['base' => 'customgrid/index/delete'],
                        'field' => 'comment_id'
                    ],
                    [
                        'caption' => __('Approve'),
                        'url' => ['base' => 'customgrid/index/approve'],
                        'field' => 'comment_id'
                    ],
                    [
                        'caption' => __('Disapprove'),
                        'url' => ['base' => 'customgrid/index/disapprove'],
                        'field' => 'comment_id'
                    ],
                ],
                'filter' => false,
                'sortable' => false,
                'index' => 'comment_id',
                'is_system' => true,
            ]
        );
        return parent::_prepareColumns();
    }
}
