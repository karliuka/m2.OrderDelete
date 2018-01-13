<?php
/**
 * Copyright © 2011-2018 Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * 
 * See COPYING.txt for license details.
 */
namespace Faonni\OrderDelete\Controller\Adminhtml\Order;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Magento\Sales\Model\ResourceModel\Order\CollectionFactory;
use Magento\Sales\Controller\Adminhtml\Order\AbstractMassAction;

/**
 * MassDelete action
 */
class MassDelete extends AbstractMassAction
{
    /**
     * @param Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
		Context $context, 
		Filter $filter, 
		CollectionFactory $collectionFactory
	) {
        parent::__construct($context, $filter);
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * delete selected orders
     *
     * @param AbstractCollection $collection
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    protected function massAction(AbstractCollection $collection)
    {
        $orderDeleted = 0;
        foreach ($collection->getItems() as $order) {
            $order->delete();
            $orderDeleted++;
        }
        if ($orderDeleted) {
			$this->messageManager->addSuccess(__('A total of %1 record(s) have been deleted.', $orderDeleted));
        } else {
			$this->messageManager->addError(__('You cannot delete the order(s).'));
		}
        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath($this->getComponentRefererUrl());
		
        return $resultRedirect;
    }
}