<?php
declare(strict_types=1);

namespace My\CustomDescriptionToProduct\Controller\Adminhtml\Index;

use Exception;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Request\Http as Request;
use My\CustomDescriptionToProduct\Api\CustomDescriptionToProductRepositoryInterface as CustomReviewRepository;
use My\CustomDescriptionToProduct\Model\CustomDescriptionToProductFactory;

/**
 * Customer additional comments grid approve action.
 */
class Approve extends Action implements HttpGetActionInterface
{

    /**
     * @var Request
     */
    private $request;

    /**
     * @var CustomReviewRepository
     */
    private $customReviewRepository;

    /**
     * @var CustomDescriptionToProductFactory
     */
    private $customDescriptionToProductFactory;

    /**
     * @param Context $context
     * @param Request $request
     * @param CustomReviewRepository $customReviewRepository
     * @param CustomDescriptionToProductFactory $customDescriptionToProductFactory
     */
    public function __construct(
        Context $context,
        Request $request,
        CustomReviewRepository $customReviewRepository,
        CustomDescriptionToProductFactory $customDescriptionToProductFactory
    ) {
        $this->request = $request;
        $this->customReviewRepository = $customReviewRepository;
        $this->customDescriptionToProductFactory = $customDescriptionToProductFactory;
        parent::__construct($context);
    }

    /**
     * Approve action.
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        try {
            $customDescriptionInterface = $this->customDescriptionToProductFactory->create();
            $commentId                  = $this->request->getParam('comment_id') ?? null;
            $comment                    = $this->customReviewRepository->getCommentByCommentId($commentId);
            $customDescriptionInterface->setData($comment[$commentId]->getData());
            $customDescriptionInterface->setIsApproved(true);
            $this->customReviewRepository->save($customDescriptionInterface);
            if ($commentId == null) {
                $this->messageManager->addSuccessMessage(__('Comment was approved successfully!'));
            }
        } catch (Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }

        return $resultRedirect->setUrl($this->_redirect->getRefererUrl());
    }
}
