<?php
declare(strict_types=1);

namespace My\CustomDescriptionToProduct\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Webapi\Rest\Request;
use My\CustomDescriptionToProduct\Api\CustomDescriptionToProductRepositoryInterface as CustomCommentRepository;

use My\CustomDescriptionToProduct\Model\CustomDescriptionToProductFactory;

/**
 * Sets extra comment to db and save.
 *
 * @SuppressWarnings(PHPMD)
 */
class Index extends Action
{
    /**
     * @var Request
     */
    private $request;

    /**
     * @var ResultFactory
     */
    protected $resultFactory;

    /**
     * @var CustomCommentRepository
     */
    private $commentRepository;

    /**
     * @var CustomDescriptionToProductFactory
     */
    private $customDescriptionToProductFactory;

    /**
     * Controller constructor.
     *
     * @param Context $context
     * @param ResultFactory $resultFactory
     * @param Request $request
     * @param CustomCommentRepository $commentRepository
     * @param CustomDescriptionToProductFactory $customDescriptionToProductFactory
     */
    public function __construct(
        Context $context,
        ResultFactory $resultFactory,
        Request $request,
        CustomCommentRepository $commentRepository,
        CustomDescriptionToProductFactory $customDescriptionToProductFactory
    ) {
        parent::__construct($context);
        $this->resultFactory = $resultFactory;
        $this->request = $request;
        $this->commentRepository = $commentRepository;
        $this->customDescriptionToProductFactory = $customDescriptionToProductFactory;
    }

    /**
     * Sets extra comments to db and save.
     */
    public function execute()
    {
        $comment = $this->request->getParam('additionalComment');
        $productUrl = $this->request->getParam('productUrl');
        if (!empty($comment)) {
            $productId = $this->request->getParam('productId');
            $customerEmail = $this->request->getParam('customerEmail');
            $productUrl = $this->request->getParam('productUrl');
            $customDescriptionInterface = $this->customDescriptionToProductFactory->create();
            $customDescriptionInterface->setProductId((int)$productId)
                ->setCustomerEmail($customerEmail)
                ->setCustomCustomerDescriptionToProduct($comment)
                ->setIsApproved(false);
            $this->commentRepository->save($customDescriptionInterface);
        }
        $redirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $redirect->setUrl($productUrl);

        return $redirect;
    }
}
