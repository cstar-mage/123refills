<?php
/**
 * Magento Order Editor Module
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the License Version.
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 *
 * @category   Order Editor
 * @package    Oeditor_Ordereditor
 * @copyright  Copyright (c) 2010 
 * @version    0.4.1
*/


class Oeditor_Ordereditor_Block_Adminhtml_Sales_Order_View extends Mage_Adminhtml_Block_Sales_Order_View 
{
	
	public function  __construct() {

        parent::__construct();

		$order = $this->getOrder();
		$orderId = $order->getId();
		
		$allowedInvoice = $this->_isAllowedAction('invoice');
		$canInvoice = $order->canInvoice();

		 if ($order->hasInvoices() || $order->hasShipments() || $order->getState() == 'closed' ) 
		 {
			$deleteInvoiceShipMemoPath = $this->getUrl('ordereditor/adminhtml_ordereditor/deleteInvoiceShipCreditMemo').'?order_id='.$orderId;
		 	$onclickInvoiceJs = 'deleteConfirm(\''
			. Mage::helper('sales')->__('Are you sure? It will delete the created Invoice(s) and then you can create new updated invoice.')
			. '\', \'' . $deleteInvoiceShipMemoPath . '\');';	
		 }else
		 {
		 	$onclickInvoiceJs = 'alert(\''
			. Mage::helper('sales')->__('Sorry, no invoice is created,please create new Invoice')
			. '\');';	
		 }
		 
       	 $_label = Mage::helper('sales')->__('Delete Invoice');
            $this->_addButton('delete_invoice', array(
                'label'     => $_label,
                'onclick'   => $onclickInvoiceJs,
                'class'     => ''
         ),0,15);

	
	/*	if ($order->hasInvoices() || $order->hasShipments() || $order->getState() == 'closed' ) 
		{
			$resetItemStatusPath = $this->getUrl('ordereditor/adminhtml_ordereditor/resetItemStatus').'?order_id='.$orderId;
			$resetItemStatus = 'deleteConfirm(\''
			. Mage::helper('sales')->__('Are you sure?')
			. '\', \'' . $resetItemStatusPath . '\');';	
		}
		else
		 {
		 	$resetItemStatus = 'alert(\''
			. Mage::helper('sales')->__('Sorry, no invoice is created,please create new Invoice')
			. '\');';	
		 }
		
		  $_label = Mage::helper('sales')->__('Reset Item Status');
            $this->_addButton('reset_item', array(
                'label'     => $_label,
                'onclick'   => $resetItemStatus,
                'class'     => ''
         ),0,26);
		*/
		 
		 	$deleteOrderAction = $this->getUrl('ordereditor/adminhtml_ordereditor/deleteOrder').'?order_id='.$orderId;
		
		 	$deleteAlert = 'deleteConfirm(\''
			. Mage::helper('sales')->__('Are you sure you want to delete the order.')
			. '\', \'' . $deleteOrderAction . '\');';	
			 
			 $_label = Mage::helper('sales')->__('Delete');
				$this->_addButton('delete_order', array(
					'label'     => $_label,
					'onclick'   => $deleteAlert,
					'class'     => 'delete'
			 ),0,25);		 
    }
	
	public function getHeaderText() {
        $parentMessage = parent::getHeaderText();
		
		$isArchieved = ''; $editMsg = ''; $typeMsg = '';
		$type = $this->getOrder()->getIsArchieved();
		$isEdited = $this->getOrder()->getIsEdit();
		
		if (isset($type) && $type == 1)
		{
			 $typeText = Mage::helper('sales')->__('Group - Archieve');   
			 $typeMsg =  ' ( ' . $typeText .' ) ' ;
		}else{
			$typeText = Mage::helper('sales')->__('Group - Active');
			 $typeMsg =  ' ( ' . $typeText .' ) ' ;
		}
		
        if (isset($isEdited) && $isEdited == 1)
		{
			 $editText = Mage::helper('sales')->__('Edited');    
			 $editMsg =  ' ( ' . $editText .' ) ' ;    
		}

		$parentMessage = $parentMessage . $editMsg . $typeMsg ;

        return $parentMessage;
    } 
}