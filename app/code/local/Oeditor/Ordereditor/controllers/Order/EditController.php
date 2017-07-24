<?php
include_once('Mage/Adminhtml/controllers/Sales/Order/EditController.php');
class Oeditor_Ordereditor_Order_EditController extends Mage_Adminhtml_Sales_Order_EditController
{

	protected function _processActionData($action = null) {         
        $this->getRequest()->setPost('reset_shipping', 0);
        parent::_processActionData($action);
    }
	 
	 /**
     * Start edit order initialization
     */
    public function startAction()
    {
		$oId = $this->getRequest()->getParam('order_id');
		$order = Mage::getModel('sales/order')->load($oId);
		
		if($order->hasInvoices() > 0 || $order->hasShipments() >0 || $order->hasCreditmemos() > 0)
		{
			//$this->resetItemStatus($oId);
			//$this->deleteInvoiceShipCreditMemo($oId);
		}
		
        $this->_getSession()->clear();
        $orderId = $this->getRequest()->getParam('order_id');
        $order = Mage::getModel('sales/order')->load($orderId);

        try {
            if ($order->getId()) {
                $this->_getSession()->setUseOldShippingMethod(true);
                $this->_getOrderCreateModel()->initFromOrder($order);
                $this->_redirect('*/*');
            }
            else {
                $this->_redirect('*/sales_order/');
            }
        } catch (Mage_Core_Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            $this->_redirect('*/sales_order/view', array('order_id' => $orderId));
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addException($e, $e->getMessage());
            $this->_redirect('*/sales_order/view', array('order_id' => $orderId));
        }
    }
	
    /**
     * Saving quote and create order
     */
    public function saveAction()
	{
			//echo '<pre>';print_r($_POST);die;
			  if(isset($_POST['edit_order_number']) && $_POST['edit_order_number'] != "")
			 {
			 	/*Declare Log variables Starts*/
				 	$newSkuArr = array();$editComments = '';$productImgToLog='';
					$postShippingAddressArr='';$oldOrderShippingAddressArr='';
					$postShippingFormFields='';$same_as_billing = 0;
					
					$logEnabled = Mage::getStoreConfig('editorder/orderlog/detail_edit_log'); 
					$itemImgToLog = 0 ; 
				/*Declare Log variables Ends*/

			 	$prefix = Mage::getConfig()->getTablePrefix();
				$resource = Mage::getSingleton('core/resource');
				$writeConnection = $resource->getConnection('core_write');
				$connectionRead = Mage::getSingleton('core/resource')->getConnection('core_read');
				
				$postOrder = $this->getRequest()->getPost('order');

				$oldOrder = $this->_getSession()->getOrder();
 				$quote = $this->_getSession()->getQuote();
				$preTotal = $oldOrder->getGrandTotal();
				$manage_inventory = Mage::getStoreConfig('editorder/orderstockmg/manage_inventory'); 
				
				$lockField = Mage::getStoreConfig('editorder/general/lock_field'); 

 				/*PreLoad Log Data Starts*/
					$preShippingAmount = $oldOrder->getShippingAmount();
					$preShippingMethod = $oldOrder->getShippingMethod();
					$preShippingDesc = $oldOrder->getShippingDescription();
					$currencyCode = Mage::app()->getLocale()->currency($oldOrder->getOrderCurrencyCode())->getSymbol();
					$oldCustomerEmail = $oldOrder->getCustomerEmail();
					$oldCustomerGroupId = $oldOrder->getCustomerGroupId();
					
					$OldOrderBillingAddress = $oldOrder->getBillingAddress();
					$postBillingAddressArr = $postOrder['billing_address'];
					
					$oldOrderShippingAddress = $oldOrder->getShippingAddress();
					if(is_object($oldOrderShippingAddress))
					{
						$oldOrderShippingAddressArr = array_filter($oldOrderShippingAddress->getData());
					}
					if(isset($postOrder['shipping_address']) && is_array($postOrder['shipping_address']))
					{
						$postShippingFormFields = $postOrder['shipping_address'];
						$postShippingAddressArr = $postOrder['shipping_address'];
					}
					else
					{// when same as billing enabled
						$quoteShipAdd = $quote->getShippingAddress();
						if(is_object($quoteShipAdd))
						{
							$postShippingFormFields = $quoteShipAdd->getData();
							$same_as_billing = 1;
							$postShippingAddressArr = $quoteShipAdd->getData();
						}
					}
				/*PreLoad Log Data Ends*/

 				$oldOrderPayment = $oldOrder->getPayment();
				$oldOrderPaymentMethod = $oldOrderPayment->getMethod();
				
				 /*Update Payment Method STARTS*/
 				$editComments .= $this->updatePaymentMethod($_POST,$oldOrder,$oldOrderPaymentMethod,$logEnabled,$editComments);
				 /*Update Payment Method ENDS*/
 
 				$oldOrderId = $oldOrder->getId();
				$order = Mage::getModel('sales/order')->load($oldOrderId);

				/**********Remove Items Start**********/
					$removeItemsData = $this->removeItems($order,$logEnabled,$writeConnection,$connectionRead,$manage_inventory);
					$removeItemArray = $removeItemsData['remove_item_array'];
				/**********Remove Item(s) Ends**********/


				/*Re-add items those were deleted above STARTS*/
					$itemAddData = $this->addNewItems($oldOrder,$quote,$manage_inventory,$logEnabled,$itemImgToLog,$removeItemArray,$writeConnection,$connectionRead,$currencyCode);
					$newSkuArr = $itemAddData['sku_arr'];
					$editComments .= $itemAddData['edit_comments'];
				/*Re-add items those were deleted above ENDS*/
					
										
				/***************************************Log for Removed Items Starts***************************************/
					$editComments .= $this->itemRemoveLog($removeItemArray,$logEnabled,$editComments,$itemImgToLog,$newSkuArr);

				/***************************************Log for Removed Items Ends***************************************/


				/***************************************Log Billing Shipping Address Update Starts***************************************/
					if($logEnabled == 1)
					{
						$editComments .= $this->logAddress('billing',$OldOrderBillingAddress,$postBillingAddressArr,$editComments);
						$editComments .= $this->logAddress('shipping',$oldOrderShippingAddress,$postShippingAddressArr,$editComments);
					}
				/***************************************Log Shipping Shipping Address Update Ends***************************************/
				
				$address = $quote->getShippingAddress();
				$taxAmount = $address->getTaxAmount();
				$shippingPrice = ''; 
				
				/*Update custom or new shipping Method STARTS*/
					$shipMethArray = $this->updateShippingMethod($_POST,$postOrder,$address,$oldOrder,$logEnabled,$preShippingMethod,$preShippingAmount,$currencyCode,$preShippingDesc);
				   $editComments .= $shipMethArray['logComments'];
				   $shippingPrice = $shipMethArray['returnshiprice'];
				/*Update custom or new shipping Method ENDS*/
				
		
				/*Update Billing Data STARTS*/
					$quote->getPayment()->getMethod();
					$sameAsBilling = $quote->getShippingAddress()->getSameAsBilling();
					
					$postBillingAddress = $postOrder['billing_address'];
					$bb = $oldOrder->getBillingAddress();
					$bb->setData('prefix',$postBillingAddress['prefix']);$bb->setData('firstname',$postBillingAddress['firstname']);
					$bb->setData('middlename',$postBillingAddress['middlename']);$bb->setData('lastname',$postBillingAddress['lastname']);
					$bb->setData('suffix',$postBillingAddress['suffix']);$bb->setData('company',$postBillingAddress['company']);
					$bb->setData('street',implode(" ",$postBillingAddress['street']));$bb->setData('city',$postBillingAddress['city']);
					$bb->setData('country_id',$postBillingAddress['country_id']);$bb->setData('postcode',$postBillingAddress['postcode']);
					$bb->setData('telephone',$postBillingAddress['telephone']);$bb->setData('fax',$postBillingAddress['fax']);
					if(isset($postBillingAddress['vat_id']) && $postBillingAddress['vat_id'] != ""){ $bb->setData('vat_id',$postBillingAddress['vat_id']);	}
					if(isset($postBillingAddress['region']) && $postBillingAddress['region'] != ""){$bb->setData('region',$postBillingAddress['region']);}
					if(isset($postBillingAddress['region_id']) && $postBillingAddress['region_id'] != ""){ $bb->setData('region_id',$postBillingAddress['region_id']);}
	
					$oldOrder->setBillingAddress($bb);
				/*Update Billing Data ENDS*/
				
				/*Update Shipping Data -  same as billing STARTS*/
					if(isset($postShippingFormFields) && is_array($postShippingFormFields))
					{
						$shipAddArr = $oldOrder->getShippingAddress();
						$shipAddArr->setData('prefix',$postShippingFormFields['prefix']);$shipAddArr->setData('firstname',$postShippingFormFields['firstname']);
						$shipAddArr->setData('lastname',$postShippingFormFields['lastname']);$shipAddArr->setData('middlename',$postShippingFormFields['middlename']);
						$shipAddArr->setData('suffix',$postShippingFormFields['suffix']);$shipAddArr->setData('company',$postShippingFormFields['company']);
						if(is_array($postShippingFormFields['street'])){$shipAddArr->setData('street',implode(" ",$postShippingFormFields['street']));}
						else{$shipAddArr->setData('street',$postShippingFormFields['street']);}$shipAddArr->setData('country_id',$postShippingFormFields['country_id']);
						$shipAddArr->setData('postcode',$postShippingFormFields['postcode']);$shipAddArr->setData('telephone',$postShippingFormFields['telephone']);
						$shipAddArr->setData('fax',$postShippingFormFields['fax']);$shipAddArr->setData('city',$postShippingFormFields['city']);
						$shipAddArr->setData('vat_id',$postShippingFormFields['vat_id']);
						if(isset($postShippingFormFields['region']) && $postShippingFormFields['region'] != ""){$shipAddArr->setData('region',$postShippingFormFields['region']);}
						if(isset($postShippingFormFields['region_id']) && $postShippingFormFields['region_id'] != ""){ $shipAddArr->setData('region_id',$postShippingFormFields['region_id']);}
						$same_as_billing = 1;
						$oldOrder->setShippingAddress($shipAddArr);//Set Shipping Array in old order
					}
				/*Update Shipping Data -  same as billing Ends*/


				/*Update order Totals STARTS*/
				
				$oldOrder->setData('coupon_code',$quote->getData('coupon_code'));
				$oldOrder->setData('store_id',$quote->getData('store_id'));
				$oldOrder->setData('subtotal',$quote->getData('subtotal'));
				
				$subTotal = $quote->getData('subtotal');
				$baseSubTotal = $quote->getData('base_subtotal_with_discount');
				$discountAmount = $subTotal - $baseSubTotal;
				$discountAmount = '-'.$discountAmount;
				
				$oldOrder->setData('discount_amount',$discountAmount);
				$oldOrder->setData('base_discount_amount',$discountAmount);
				$oldOrder->setData('discount_description',$quote->getData('coupon_code'));

				$oldOrder->setData('base_subtotal',$quote->getData('base_subtotal'));
				
				$oldOrder->setData('base_subtotal_incl_tax',$quote->getData('base_subtotal')+$taxAmount );
				$oldOrder->setData('subtotal_incl_tax',$quote->getData('base_subtotal')+ $taxAmount);
				
				$oldOrder->setData('grand_total',$quote->getData('grand_total'));
				$oldOrder->setData('base_grand_total',$quote->getData('base_grand_total'));
				$oldOrder->setData('store_id',$quote->getData('store_id'));
				$oldOrder->setData('base_tax_amount',$taxAmount);
				$oldOrder->setData('tax_amount',$taxAmount);
				
				/*Update order Totals ENDS*/

					$accountArray = $this->logCustomerAccount($postOrder,$oldOrder,$logEnabled,$oldCustomerEmail,$oldCustomerGroupId);
					$oldOrder = $accountArray['old_order'];
					$editComments .= $accountArray['account_comment'];
				/*Update Comment,account section STARTS*/
			
				
				/*Update Comment,account section ENDS*/
		
				$newQuoteId =  $quote->getId();
				$oldOrder['quote_id'] = $newQuoteId;
				$oldOrder['is_edit'] = 1;
				
				/* If order has items those are partially or fully invoiced then we do not "delete and re-add" them so here we update the 
				   those partially invoiced or fully Invoiced items total in the order grand Grandtotal STARTS
				   -If we do not updated invoied items total in grand total then order view total will mismatch with total paid
				 */
				if ($oldOrder->hasInvoices())/*2-7-14, if order few item is already invoiced then add there total in grandtotal*/
				{
					$isInvoicesActive = $this->orderInvoices($oldOrderId);
					if($isInvoicesActive == 1)/*if invoices is cancelled then need not to re-calculate*/
					{
						$invoicedNewQuoteGrandTotal = $quote->getData('grand_total') + $oldOrder->getTotalInvoiced();
						$subTotal = $quote->getData('subtotal') + $oldOrder->getSubtotalInvoiced();
						$subTotalInclTaxPlusInvoicedTax = $quote->getData('subtotal') + $oldOrder->getSubtotalInvoiced() + $oldOrder->getTaxInvoiced() + $address->getTaxAmount();
						
						$oldOrder->setBaseSubtotal($subTotal);
						$oldOrder->setSubtotal($subTotal);
						
						$oldOrder->setBaseSubtotalInclTax($subTotalInclTaxPlusInvoicedTax);
						$oldOrder->setSubtotalInclTax($subTotalInclTaxPlusInvoicedTax);
						
						//echo $address->getTaxAmount() .'/'. $oldOrder->getTaxInvoiced();die;
						$currentPlusInvicedTax = $address->getTaxAmount() + $oldOrder->getTaxInvoiced();
						$oldOrder->setData('base_tax_amount',$currentPlusInvicedTax);
						$oldOrder->setData('tax_amount',$currentPlusInvicedTax);
						
						$shippingPlusInvoicedShip = $oldOrder->getShippingInvoiced() + $shippingPrice;
						$oldOrder->setBaseShippingAmount($shippingPlusInvoicedShip);
						$oldOrder->setShippingAmount($shippingPlusInvoicedShip);
						$oldOrder->setShippingInclTax($shippingPlusInvoicedShip);
						$oldOrder->setBaseShippingInclTax($shippingPlusInvoicedShip);	
						
						$oldOrder->setBaseGrandTotal($invoicedNewQuoteGrandTotal);
						$oldOrder->setGrandTotal($invoicedNewQuoteGrandTotal);
					}
				}
				/*Invoiced items in grandtotal ends*/
			
			
				
				$postTotal = $quote->getData('grand_total');
				if($postTotal != $preTotal) 
				{
					if($logEnabled == 1)
					{
						$preTotal = number_format($preTotal,2);
						$postTotal = number_format($postTotal,2);
						$editComments .= '<b>'.$this->__('Grand Total ').'</b>'.$this->__('was updated from ').$currencyCode. $preTotal.$this->__(' to ').$currencyCode.$postTotal ;
					}
					
				}
				
				$postTotal = $quote->getData('grand_total');
				if(Mage::getStoreConfig('editorder/general/reauth')) {
					if($postTotal > $preTotal) {
 						$payment = $oldOrder->getPayment();
						$orderMethod = $payment->getMethod();
						if($orderMethod != 'free' && $orderMethod != 'checkmo' && $orderMethod != 'purchaseorder') {
	  
							if(!$payment->authorize(1, $postTotal)) {
								echo "There was an error in re-authorizing payment.";
								return $this;
							}else{
							
								$additionalInformation  = $payment->getData('additional_information');
								$payment->save();
								//$oldOrder->setTotalPaid($postTotal);
								if( $orderMethod != "paypal_express" &&  $orderMethod != "verisign" &&  $orderMethod != "paypal_direct")
								{
									$order->save();
								} /* this function is used to save re-auth entries in magento DB*/
					}
						}
					}
				}
				
				
				/*Save Logs to the history comments Starts*/
					if($logEnabled == 1 && isset($editComments) && $editComments !="")
					{
						$orderStatus = $oldOrder->getStatus();
						
						$userName = Mage::getSingleton('admin/session')->getUser()->getUsername();
						$firstName = Mage::getSingleton('admin/session')->getUser()->getFirstname();
						$lastName = Mage::getSingleton('admin/session')->getUser()->getLastname();
						
						$editCommentsHeading = $this->__('Order is Edited with following :').' <br/><br/>';
						$orderEditedBy = '<i>'.$this->__('Order is Edited By: ').'</i>'.$firstName . ' '.$lastName .' ('.$userName .')'.' <br/>';
						
						$editComments = $editCommentsHeading .$orderEditedBy. $editComments;
						
						$oldOrder->addStatusHistoryComment($editComments, $orderStatus)
								->setIsVisibleOnFront(false)
								->setIsCustomerNotified(false);
					}			
				/*Save Logs to the history comments Ends*/
				
				
				$oldOrder->save();
		

				
				Mage::getSingleton('adminhtml/session')->addSuccess($this->__('The order has been updated successfully.'));
				$this->_redirect('*/sales_order/view', array('order_id' => $oldOrder->getId()));
		
		}else{
			try {
				$this->_processActionData('save');
				if ($paymentData = $this->getRequest()->getPost('payment')) {
					$this->_getOrderCreateModel()->setPaymentData($paymentData);
					$this->_getOrderCreateModel()->getQuote()->getPayment()->addData($paymentData);
				}
	
				$order = $this->_getOrderCreateModel()
					->setIsValidate(true)
					->importPostData($this->getRequest()->getPost('order'))
					->createOrder();
	
				$this->_getSession()->clear();
				Mage::getSingleton('adminhtml/session')->addSuccess($this->__('The order has been created.'));
				$this->_redirect('*/sales_order/view', array('order_id' => $order->getId()));
			}
			 catch (Mage_Payment_Model_Info_Exception $e) {
				$this->_getOrderCreateModel()->saveQuote();
				$message = $e->getMessage();
				if( !empty($message) ) {
					$this->_getSession()->addError($message);
				}
				$this->_redirect('*/*/');
			} catch (Mage_Core_Exception $e){
				$message = $e->getMessage();
				if( !empty($message) ) {
					$this->_getSession()->addError($message);
				}
				$this->_redirect('*/*/');
			}
			catch (Exception $e){
				$this->_getSession()->addException($e, $this->__('Order saving error: %s', $e->getMessage()));
				$this->_redirect('*/*/');
			}
		}
	  
		}
    /**
     * Prepare options array for info buy request
     *
     * @param Mage_Sales_Model_Quote_Item $item
     * @return array
     */
	public function logCustomerAccount($postOrder,$oldOrder,$logEnabled,$oldCustomerEmail,$oldCustomerGroupId)
	{
		$accountComment = '';
		$comment = $postOrder['comment'];
		if(isset($comment) && is_array($comment))
		{
			$customer_note = $comment['customer_note'];
			if(isset($customer_note) && $customer_note != "")
			{
				$oldOrder->setCustomerNote($customer_note);
				$oldOrder->addStatusToHistory($oldOrder->getStatus(),$customer_note, false);
			}
		}
		
		$account = $postOrder['account'];
		if(isset($account) && is_array($account))
		{
			$email = $account['email'];
			if(isset($email) && $email != "")
			{
				$oldOrder->setCustomerEmail($email);
				/***************************************Log Customer Accounts Starts***************************************/
					if($logEnabled == 1)
					{
						if($oldCustomerEmail != $email)
						{
							$accountComment .= '<b>'.$this->__('Customer Email ') .'</b>' ;
							$accountComment .= $this->__('was updated from ') .'<br/>'.$oldCustomerEmail .  $this->__(' -To- ') .$email.'<br/>';
						}
					}
				/***************************************Log Customer Accounts Starts***************************************/
			}
					
			if(isset($account['group_id']) && $account['group_id'] != "")
			{
				$group_id = $account['group_id'];
				$oldOrder->setCustomerGroupId($group_id);
				
				/***************************************Log Customer Accounts Starts***************************************/
					if($logEnabled == 1)
					{
						if($oldCustomerGroupId != $account['group_id'])
						{
							$newCustomerGroupArr = Mage::getModel('customer/group')->load($account['group_id']);
							$newCustomerGroup = $newCustomerGroupArr->getData('customer_group_code');
							
							$oldCustomerGroupArr = Mage::getModel('customer/group')->load($oldCustomerGroupId);
							$oldCustomerGroup = $oldCustomerGroupArr->getData('customer_group_code');
							
							$accountComment .= '<b>'.$this->__('Customer Group ') .'</b>' ;
							$accountComment .= $this->__('was updated from ') .$oldCustomerGroup .  $this->__(' -To- ') .$newCustomerGroup.'<br/>';
						}
					}
				/***************************************Log Customer Accounts Starts***************************************/
			}
		}
		
		return array('old_order'=>$oldOrder,'account_comment'=>$accountComment);
	}
	
	public function removeItems($order,$logEnabled,$writeConnection,$connectionRead,$manage_inventory)
	{
		$removeItemArray = array(); $prefix = Mage::getConfig()->getTablePrefix();
		$oldOrderQuoteId = $order['quote_id'];				
		$orderAllItems = $order->getAllItems();
		
		
		/*delete quote and new quote will be inserted*/
			$condition = "delete from ".$prefix."sales_flat_quote where entity_id = '".$oldOrderQuoteId."'";
			$writeConnection->query($condition);
		/*delete quote and new quote will be inserted*/
		
		/*Delete items with its item quote starts*/
		foreach($orderAllItems as $delteItem)
		{
			/***************************************Pre fill Array to Log the edited data Starts***************************************/
				if($logEnabled == 1)
				{
					$delSku = $delteItem->getSku();
					$removeItemArray[$delSku]['sku'] = $delteItem->getSku();
					$removeItemArray[$delSku]['price'] = $delteItem->getPrice();
					$removeItemArray[$delSku]['qty_orderdered'] = $delteItem->getQtyOrdered();
					$removeItemArray[$delSku]['discount'] = $delteItem->getDiscount();
				}
			/***************************************Pre fill Array to Log the edited data Ends***************************************/

			if(isset($manage_inventory) && $manage_inventory == 1 )
			{
				//$product = $delteItem->getProduct();
				$productId = $delteItem->getProductId();
				$product = Mage::getModel('catalog/product')->load($productId);
				$productType = $product->getTypeId();
				$manageStock = Mage::getModel('cataloginventory/stock_item')->loadByProduct($product)->getManageStock();
				$minQtyOutOfStock = Mage::getModel('cataloginventory/stock_item')->loadByProduct($product)->getMinQty();

				if($productType == "simple" || $productType == "downloadable" && $productType == "virtual")
				{
					$stockData = $product->getStockData();
					$qtyStock = Mage::getModel('cataloginventory/stock_item')->loadByProduct($product)->getQty();
					$stockData['qty'] = $qtyStock + $delteItem->getQtyOrdered();
					if($stockData['qty'] > $minQtyOutOfStock){$stockData['is_in_stock'] = 1;}else{$stockData['is_in_stock'] = 0;}
					if($manageStock == 1){$stockData['manage_stock'] = 1; }
					//$stockData['use_config_manage_stock'] = 0;
					$product->setStockData($stockData);
					$product->save();
					
					/*
						-lock field until it update is not completed so that filed will not update if customer purchasing products start
						- comment out above $product->save();, as below we are saving product direct via query 
					*/

					if($lockField == 1)
					{
							$writeConnection->beginTransaction();
					try {
							 $product = Mage::getModel('catalog/product')->load($delteItem->getProductId());
							 $productId = $product->getId();
							$select = $connectionRead->select()->forUpdate()
															->from('cataloginventory_stock_item', array( 'qty'))
											->where('product_id = ?', $productId);
			 
							$result = $connectionRead->fetchRow($select); 
							$updateFields = array();
							
							//$updateFields['qty'] = $stockData['qty']; 
							$updateFields['qty'] = $result['qty'] + $delteItem->getQtyOrdered(); 
											 
							$where = $writeConnection->quoteInto('product_id =? ', $productId);
							$writeConnection->update('cataloginventory_stock_item', $updateFields, $where);
							$writeConnection->commit();
						} 
							catch (Exception $e) { $writeConnection->rollBack(); }
					}
						
				   /*lock field until it update is not completed ends*/
				}
			}
			/*
				-Fully invoiced items will not be visible here
				-If item is partially invoiced then donot delete those items and add those invoiced items total with the grand total.
				- if items status "Ordered"(NOT INVOICED) then delete them as they will re-added and manage grand(totals) automatically via quote add items loop"
			*/
			
			$itemStatusId = $delteItem->getStatusId();
			$itemStatus = $delteItem->getStatus();
			$isOrderHasInvoices = $order->hasInvoices();
			if ($itemStatusId == 1) { /* skip the item from being delete those are alredy invoiced*/
			
				/*delete items from quote*/
				$quoteItemId = $delteItem->getQuoteItemId();/*delete parent(if item is congfig,grouped,bundle) child will automatically delete(if any)*/
				$condition = "delete from ".$prefix."sales_flat_quote_item where item_id = '".$quoteItemId."'";
				$writeConnection->query($condition);
				/*delete items from quote*/
				
				$condition = "delete from ".$prefix."sales_flat_quote_item_option where item_id = '".$quoteItemId."'";
				$writeConnection->query($condition);
		
				$delteItem->delete(); /* it will delete item child(if there is any)*/
			}
			else
			{
				if ($itemStatusId == 6) { /* if item is partially invoiced then remove remaining qty as they will be adding as new item */
					$qtyToOrder = $delteItem ['qty_ordered'] - $delteItem['qty_invoiced'];

					$delteItem['qty_ordered'] = $delteItem['qty_invoiced'];
					$delteItem['row_total'] = $delteItem['base_row_invoiced'];
					$delteItem['base_row_total'] = $delteItem['base_row_invoiced'];
					
					$delteItem['tax_amount'] = $delteItem['tax_invoiced'];
					$delteItem['base_tax_amount'] = $delteItem['base_tax_invoiced'];
					
					$delteItem['discount_amount'] = $delteItem['discount_invoiced'];
					$delteItem['base_discount_amount'] = $delteItem['base_discount_invoiced'];
					
					$delteItem['row_total_incl_tax'] = $delteItem['base_row_invoiced'];
					$delteItem['base_row_total_incl_tax'] = $delteItem['base_row_invoiced'];
					
					$delteItem->save();
				}
			}
		}
		return array('remove_item_array'=>$removeItemArray);
		/*Delete items with its item quote ends*/
	}
	
	public function itemRemoveLog($removeItemArray,$logEnabled,$editComments,$itemImgToLog,$newSkuArr)
	{
		$removeItemComments = '';
		if($logEnabled == 1)
		{
			$removeItemProductImage = '';
			if(is_array($removeItemArray))
			{
				$removeItemKeys = array_keys($removeItemArray);
				if(array_diff($removeItemKeys,$newSkuArr))
				{
					$delProducts = array_diff($removeItemKeys,$newSkuArr);
					foreach($delProducts as $delItms)
					{
						$_productForLog = Mage::getModel('catalog/product')->loadByAttribute('sku',$delItms);
						if($itemImgToLog == 1)
						{
							$removeItemProductImage = Mage::helper('catalog/image')->init($_productForLog, 'image')->resize(30);
						}
						
						$removeItemComments .= $this->__('Item ') .$removeItemProductImage . '<b>'.$_productForLog->getName() .'</b>'.  $this->__(' was removed') .'<br/>';
					}
				}
			}
		}
		return $removeItemComments;
	}
	
	public function addNewItems($oldOrder,$quote,$manage_inventory,$logEnabled,$itemImgToLog,$removeItemArray,$writeConnection,$connectionRead,$currencyCode)
	{
		$options = '';$addNewItemArr = '';$isItemEdited = 0; $productImgToLog = ''; $itemLogContent = '';$itemLogHeading = '';$returnItemComments = '';
		$price = 0 ;$itemQty = "";$newAddedQty = "" ; $newSkuArr = '';
		
		$convertor = Mage::getModel('sales/convert_quote');
		foreach ($quote->getAllItems() as $item)
		{
				//foreach ($quote->getAllVisibleItems() as $item)
			 if(isset($manage_inventory) && $manage_inventory == 1 )
			 {
	
				$quoteItem = $item;
				//$product = $item->getProduct();
				$productId = $item->getProductId();
				$product = Mage::getModel('catalog/product')->load($productId);
					
				$productType = $product->getTypeId();
				$stockData = $product->getStockData();
				$quoteItemParentId = $quoteItem->getParentItemId();
									
					if($productType == "simple" || $productType == "downloadable" && $productType == "virtual")
					{
						$manageStock = Mage::getModel('cataloginventory/stock_item')->loadByProduct($product)->getManageStock();
						$minQtyOutOfStock = Mage::getModel('cataloginventory/stock_item')->loadByProduct($product)->getMinQty();
	
						$qtyStock = Mage::getModel('cataloginventory/stock_item')->loadByProduct($product)->getQty();
						if($quoteItemParentId != "" || $quoteItemParentId != NULL)/*it is a SIMPLE product whose parent is configurable product*/
						{
							$sql = "SELECT qty FROM ".$prefix."sales_flat_quote_item WHERE item_id='".$quoteItemParentId."'";
							$sqlResult = Mage::getSingleton('core/resource')->getConnection('core_read')->fetchRow($sql);
							$newAddedQty = $sqlResult['qty'];
						}
						else
						{$newAddedQty = $item->getQty();}
						
						$stockData['qty'] = $qtyStock - $newAddedQty;
						if($stockData['qty'] <= $minQtyOutOfStock){$stockData['is_in_stock'] = 0;}else{$stockData['is_in_stock'] = 1;}
						if($manageStock == 1){$stockData['manage_stock'] = 1; }
						//$stockData['use_config_manage_stock'] = 0;
						$product->setStockData($stockData);
						$product->save();
						
						if($lockField == 1)
						{
						/*lock field until it update is not completed start*/
							$writeConnection->beginTransaction();
								try {
									 $product = Mage::getModel('catalog/product')->load($item->getProductId());
									 $productId = $product->getId();
									 $select = $connectionRead->select()
											->forUpdate() 
											->from('cataloginventory_stock_item', array( 'qty'))
										->where('product_id = ?', $productId);
								 
									$result = $connectionRead->fetchRow($select); 
								 
									$updateFields = array();
									//$updateFields['qty'] = $stockData['qty']; 
									$updateFields['qty'] = $result['qty'] - $newAddedQty; 
									
									$where = $writeConnection->quoteInto('product_id =? ', $productId);
									$writeConnection->update('cataloginventory_stock_item', $updateFields, $where);
									$writeConnection->commit();
								} catch (Exception $e) {
									$writeConnection->rollBack();
								}
						}
						/*lock field until it update is not completed ends*/				
					}
				}
				
				$options = array();
				$productOptions = $item->getProduct()->getTypeInstance(true)->getOrderOptions($item->getProduct());
	
				if ($productOptions) {
					$productOptions['info_buyRequest']['options'] = $this->prepareEditedOptionsForRequest($item);
					$options = $productOptions;						
				}
				$addOptions = $item->getOptionByCode('additional_options');
				if ($addOptions) {
					$options['additional_options'] = unserialize($addOptions->getValue());
				}
				$item->setProductOrderOptions($options);
	//			echo $item->getItemCustomPrice().$item->getCustomPrice();die;
				$orderItem = $convertor->itemToOrderItem($item);
	
				if ($item->getParentItem()) {
					$orderItem->setParentItem($oldOrder->getItemByQuoteItemId($item->getParentItem()->getId()));
				}
				$orderItem->setBaseOriginalPrice($item->getProduct()->getPrice());
				$orderItem->setOriginalPrice($item->getProduct()->getPrice());
				$oldOrder->addItem($orderItem);
				$orderItem->save();
			
			/***************************************Log updated Item Starts***************************************/
				
							/**********Get Item Image for Log Starts****************/
					if($logEnabled == 1 && $itemImgToLog == 1)
					{
						$_productIdForLog = $item->getProductId();
						if(isset($_productIdForLog) && $_productIdForLog != "")
						{
							$_productForLog = Mage::getModel('catalog/product')->load($_productIdForLog);
							$productImage = Mage::helper('catalog/image')->init($_productForLog, 'image')->resize(30);
						}
						$productImgToLog = '<img src="'.$productImage.'" /> ';
					}
	
						/**********Get Item Image for Log Ends****************/ 
					if($logEnabled == 1)
					{
						$newSkuArr[] = $orderItem->getSku();
						$newSku = $orderItem->getSku();
						
						if(is_array($removeItemArray))
						{
							$removeItemKeys = array_keys($removeItemArray);
							if(in_array($newSku,$removeItemKeys))//edited
							{
								if($removeItemArray[$newSku]['qty_orderdered'] != $orderItem->getQtyOrdered())
								{
									$isItemEdited = 1;
									$logUpdatedQty = number_format($removeItemArray[$newSku]['qty_orderdered'],0);
									$itemLogContent .= $this->__('&nbsp;-Quantity was updated from : ') . $logUpdatedQty. $this->__(' to ') . $orderItem->getQtyOrdered().'<br/>';	
								}
								if($removeItemArray[$newSku]['price'] != $orderItem->getPrice())
								{
									$isItemEdited = 1;
									$logOldPrice = number_format($removeItemArray[$newSku]['price'],2);
									$logUpdatedPrice = number_format($orderItem->getPrice(),2);
									
									$itemLogContent .= $this->__('&nbsp;-Price was updated from : ') .$currencyCode.$logOldPrice . $this->__(' to ') . $currencyCode.$logUpdatedPrice.'<br/>';							
								}
								if($removeItemArray[$newSku]['discount'] != $orderItem->getDiscount())
								{
									$isItemEdited = 1;
									$logUpdatedDiscount = number_format($removeItemArray[$newSku]['discount'],2);
									$itemLogContent .= $this->__('&nbsp;-Discount was updated from : ') .$currencyCode.$logUpdatedDiscount . $this->__(' to ') . $currencyCode.$orderItem->getDiscount().'<br/>';							
								}
								if($isItemEdited == 1)
								{
									$itemLogHeading = $productImgToLog .'<b>'.$orderItem->getName().'</b>'.$this->__(' was updated: ').'<br/>';	
									$returnItemComments .= $itemLogHeading.$itemLogContent;
								}
								
							}else
							{
								$returnItemComments .= $this->__('New Item, ') .'<b>'.$productImgToLog.$orderItem->getName().'</b>' .  $this->__(' was Added') .'<br/>';
							}
					}
				
				} 
				
			/***************************************Log updated Item Ends*************************************************/
		}
			return $addNewItemArr = array('edit_comments'=>$returnItemComments,'sku_arr'=>$newSkuArr);
	}
	
	public function updateShippingMethod($post,$postOrder,$address,$oldOrder,$logEnabled,$preShippingMethod,$preShippingAmount,$currencyCode,$preShippingDesc)
	{
		$logShipMethod = '';$logShipDesc = ''; $logShippingPrice=0;$shippingLogComments = '';

		$customShippingMetdhod = $address->getShippingMethod();		
		if($customShippingMetdhod == 'customshipprice_customshipprice')
		{
			$oldOrder->setShippingMethod($customShippingMetdhod);
			$oldOrder->setShippingDescription($address->getShippingDescription());
			$oldOrder->setBaseShippingAmount($address->getShippingAmount());
			$oldOrder->setShippingAmount($address->getShippingAmount());
			$oldOrder->setShippingInclTax($address->getShippingInclTax());
			$oldOrder->setBaseShippingInclTax($address->getShippingInclTax());	
										
			/*Preload Log Data*/
				$logShipMethod = 'customshipprice_customshipprice';
				$logShipDesc = $address->getShippingDescription();
				$logShippingPrice = $address->getShippingAmount();
			/*Preload Log Data*/

			$shippingPrice = $address->getShippingAmount();
		}
		else{
			if(isset($postOrder['shipping_method']) && $postOrder['shipping_method'] != "") 
			{
				// check if shipping method available(usually shipping method does not available for virtual products)
					$rates = $address->getShippingRatesCollection();
					$taxAmount = $address->getTaxAmount();
				// $_rates = $quote->getShippingAddress()->getShippingRatesCollection();
				$shippingRates = array();
				$shippingPrice = 0 ;
				foreach ($rates as $_rate)
				{
					//$orderData = $this->getRequest()->getPost('order');
					$orderData = $postOrder ;
					if($orderData['shipping_method'] == $_rate->getCode())
					{
						$oldOrder->setShippingMethod($orderData['shipping_method']);
						$shippingDescription = $_rate->getCarrierTitle().' - ' . $_rate->getMethodTitle();
						$oldOrder->setShippingDescription($shippingDescription);
						
						$oldOrder->setBaseShippingAmount($_rate->getPrice());
						$oldOrder->setShippingAmount($_rate->getPrice());
						$oldOrder->setShippingInclTax($_rate->getPrice());
						$oldOrder->setBaseShippingInclTax($_rate->getPrice());	
						$shippingPrice = $_rate->getPrice();
						
						/*Preload Log Data*/
							$logShipMethod = $orderData['shipping_method'];
							$logShipDesc = $shippingDescription;
							$logShippingPrice = $address->getShippingAmount();
						/*Preload Log Data*/
	
					}
				}
			}
		}
					
		/***************************************Log Shiping Method,Price Starts***************************************/
			if($logEnabled == 1)
			{
				//echo $logShipMethod .'/'. $preShippingMethod;die;
				if($logShipMethod != $preShippingMethod)
				{
					$shippingLogComments .= '<b>'.$this->__('Shipping method was updated ') .'</b>'.'<br/>';
					$shippingLogComments .= '&nbsp;-'.$preShippingDesc .  $this->__(' -to- ') .$logShipDesc.'<br/>';
				}
				if($logShippingPrice != $preShippingAmount)
				{
					$preShippingAmount = number_format($preShippingAmount,2);
					$logShippingPrice = number_format($logShippingPrice,2);
					$shippingLogComments .= '<b>'.$this->__('Shipping Price was updated ') .'</b>';
					$shippingLogComments .= '&nbsp;-'.$currencyCode.$preShippingAmount .  $this->__(' -to- ') .$currencyCode.$logShippingPrice .'<br/>';
				}
			}
		/***************************************Log Shiping Method,Price Ends***************************************/
		return array('logComments' => $shippingLogComments,'returnshiprice' => $shippingPrice);
	}
	
    protected function prepareEditedOptionsForRequest($item)
    {
        $newInfoOptions = array();
        if ($optionIds = $item->getOptionByCode('option_ids')) {
            foreach (explode(',', $optionIds->getValue()) as $optionId) {
                $option = $item->getProduct()->getOptionById($optionId);
                $optionValue = $item->getOptionByCode('option_'.$optionId)->getValue();

                $group = Mage::getSingleton('catalog/product_option')->groupFactory($option->getType())
                    ->setOption($option)
                    ->setQuoteItem($item);

                $newInfoOptions[$optionId] = $group->prepareOptionValueForRequest($optionValue);
            }
        }
        return $newInfoOptions;
    }
	
	public function logAddress($type,$orderAddress,$postAddressArr,$editComments)
	{
		$isAddressEdited = 0;$heading = '';$comments = '';$commentsText='';$billComments='';$shipComments='';
		
		if(is_array($postAddressArr) && $type == "billing")
		{
			foreach($postAddressArr as $key => $value)
			{
				if($key != "customer_address_id")
				{
					if($key == 'street' && is_array($value))
					$value = implode(" ",$value);
					
					$orderField = $orderAddress->getData($key);
					if(trim($orderField) != trim($value))
					{
						if($key == 'region' && isset($postAddressArr['region_id']) && $postAddressArr['region_id'] != ""){}
						else
						{
							$isAddressEdited = 1;
							$commentsText = '&nbsp;-'.ucfirst($key).$this->__(' was updated from ') ;
							$comments .= $commentsText . "'".$orderField."'".  $this->__(' -To- ') ."'".$value."'".'<br/>';
						}
					}
				}
			}
			if($isAddressEdited == 1)
			{
				$heading = '<b>'.$this->__('Billing address was updated:').'</b>'.'<br/>';
				return $billComments = $heading . $comments ;
			}	

		}
		if(is_array($postAddressArr) && $type == "shipping")
		{
			$selectFieldsArray = array("prefix","firstname","middlename","lastname","suffix","company","street","city","country_id","region_id","region","postcode","telephone","fax","vat_id");
			foreach($postAddressArr as $key => $value)
			{
				if(in_array($key,$selectFieldsArray))
				{
					if($key == 'street' && is_array($value))
					$value = implode(" ",$value);
					
					$orderField = $orderAddress->getData($key);
					if(trim($orderField) != trim($value))
					{
						if($key == 'region' && isset($postAddressArr['region_id']) && $postAddressArr['region_id'] != ""){}
						else
						{
							$isAddressEdited = 1;
							$commentsText = '&nbsp;-'.ucfirst($key).$this->__(' was updated from ') ;
							$comments .= $commentsText . "'".$orderField."'".  $this->__(' -To- ') ."'".$value."'".'<br/>';
						}
					}
				}
			}
			if($isAddressEdited == 1)
			{
				$heading .= '<b>'.$this->__('Shipping address was updated').'</b>'.'<br/>';
				return $shipComments = $heading . $comments ;
			}
	
			
		}
		return '';
	}
	
	public function updatePaymentMethod($post,$oldOrder,$oldOrderPaymentMethod,$logEnabled,$editComments)
	{
		if($_POST['payment']['method'] && $_POST['payment']['method'] != "" && $oldOrderPaymentMethod != "paypal_express"){
			$payOldMethod = $oldOrder->getPayment()->getMethodInstance()->getCode(); 
			 
			if($_POST['payment']['method'] != $payOldMethod)
			{
				$payment = $oldOrder->getPayment();
				$payment->setMethod($_POST['payment']['method']);
				
				/***************************************Log Payment Method***************************************/
						if($logEnabled == 1)
						{
							if($payOldMethod != $_POST['payment']['method'])
							{
								$orderPaymentTitle = $oldOrder->getPayment()->getMethodInstance()->getTitle(); 
								$updatedPaymentTitle = Mage::getStoreConfig('payment/'. $_POST['payment']['method'].'/title');
								$editComments .= '<b>'.$this->__('Payment Method').'</b>'. $this->__(' is updated from ') .$orderPaymentTitle .  $this->__(' -To- ') .$updatedPaymentTitle.'<br/>';
							}
						}
				/***************************************Log Payment Method***************************************/	

				if(isset($_POST['payment']['cc_exp_month']) && $_POST['payment']['cc_exp_month'] !="")
				{
					$payment['cc_exp_month'] = $_POST['payment']['cc_exp_month'];
				}
				if(isset($_POST['payment']['cc_exp_year']) && $_POST['payment']['cc_exp_year'] !="")
				{
					$payment['cc_exp_year'] = $_POST['payment']['cc_exp_year'];
				}
				if(isset($_POST['payment']['cc_type']) && $_POST['payment']['cc_type'] !="")
				{
					$payment['cc_type'] = $_POST['payment']['cc_type'];
				}
				
				if(isset($_POST['payment']['cc_owner']) && $_POST['payment']['cc_owner'] !="")
				{
					$payment['cc_owner'] = $_POST['payment']['cc_owner'];
				}
				
				if($_POST['payment']['method'] == 'ccsave')
				{
					if(isset($_POST['payment']['cc_number']) && $_POST['payment']['cc_number'] != "")
					{
						$payment['cc_number_enc'] = Mage::helper('core')->encrypt($_POST['payment']['cc_number']);
					}
				}
				
				if(isset($_POST['payment']['cc_last4']) && $_POST['payment']['cc_last4'] !="")
				{
					$payment['cc_last4'] = substr($_POST['payment']['cc_number'],-4);
				}
				$payment->save();
			}
		}
			return $editComments;
	}
		
	public function getImageUrl($image)
    {
        $productImageUrl = false;
        $productImageUrl = Mage::getBaseUrl('media').'catalog/product'. $image;
        return $productImageUrl;
    }
	public function orderInvoices($orderId)
	{
		$ordersInvoiceCollection = Mage::getModel("sales/order_invoice")->getCollection()->addFieldToFilter('order_id',$orderId)
							->addFieldToFilter('state',array('neq'=>'3'));
		$collectionSize = $ordersInvoiceCollection->getSize();
		if($collectionSize > 0){return true;}else{return false;}
	}
	
	public function resetItemStatus($orderId)
	{
		$order = Mage::getModel('sales/order')->load($orderId);
			
		$ordersInvoiceCollection = Mage::getModel("sales/order_invoice")->getCollection()->addFieldToFilter('order_id',$orderId)
							->addFieldToFilter('state',array('neq'=>'3'));
		$collectionSize = $ordersInvoiceCollection->getSize();
		 if($collectionSize > 0 && $order->hasShipments() >0 || $order->hasCreditmemos() > 0) // if there is paid invoices OR has shppment OR has credit memo
		 {
		 	
		 }else{ return true; }
		 
		 
	        $countResetInvoice = 0;
			$orderEditedBy = '';$itemStatusLogComments = '';$itemStatusLogComments = '';
			
			$logEnabled = Mage::getStoreConfig('editorder/orderlog/detail_edit_log'); 
			//$order = Mage::getModel('ordereditor/order')->load($id);
			
			$coreResource = Mage::getSingleton('core/resource');
        	$write = $coreResource->getConnection('core_write');
		
			if ($order->hasInvoices())
			{
			
			if ($order->hasInvoices()) {
				$invoices = Mage::getResourceModel('sales/order_invoice_collection')->setOrderFilter($orderId)->load();
				foreach($invoices as $invoice){
					$invoice = Mage::getModel('sales/order_invoice')->load($invoice->getId());
					$invoice->setState('3');
					$invoice->save();
					//$write->query("DELETE FROM `".$coreResource->getTableName('sales_flat_invoice')."` WHERE `order_id`=".$orderId);
					//$write->query("DELETE FROM `".$coreResource->getTableName('sales_flat_invoice_grid')."` WHERE `order_id`=".$orderId);
					//$countResetInvoice++;
				}
			}
			
			$allowLog = 1;
			foreach ($order->getAllItems() as $item) 
			{
				$itemStatusId = $item->getStatusId();
				if($itemStatusId != 1) //status Ordered
				{
					$allowLog = 2;
				}
				
				$item['qty_canceled'] = 0;
				$item['qty_invoiced'] = 0;
				$item['qty_refunded'] = 0;
				$item['qty_shipped'] = 0;
				
				$item['row_invoiced'] = 0;
				$item['base_row_invoiced'] = 0;
				$item['tax_invoiced'] = 0;
				$item['base_tax_invoiced'] = 0;
				$item['discount_invoiced'] = 0;
				$item['base_discount_invoiced'] = 0;
				
				$item['amount_refunded'] = 0;
				$item['base_amount_refunded'] = 0;
				$item['tax_refunded'] = 0;
				$item['base_tax_refunded'] = 0;
				$item['discount_refunded'] = 0;
				$item['base_discount_refunded'] = 0;
				$item->save();
				
				if($logEnabled == 1)
				{
					$itemName = $item->getName();
					
					$userName = Mage::getSingleton('admin/session')->getUser()->getUsername();
					$firstName = Mage::getSingleton('admin/session')->getUser()->getFirstname();
					$lastName = Mage::getSingleton('admin/session')->getUser()->getLastname();
					
					$orderEditedBy = '<i>'.$this->__('Order is Edited By: ').'</i>'.$firstName . ' '.$lastName .' ('.$userName .')'.' <br/><br/>';
					$itemStatusLogComments .= '-&nbsp;'.'<b>'.$itemName.'</b>'.$this->__(' item status was reset to ') .'Ordered'.'<br/>';
				}
			}
			
			if(isset($itemStatusLogComments) && $itemStatusLogComments != "" && $allowLog ==2)
			{
				$orderStatus = $order->getStatus();
				$editCommentsHeading = $this->__('Item status was reset for the below Items:').' <br/>';
				$editComments = $orderEditedBy . $editCommentsHeading . $itemStatusLogComments;
				$order->addStatusHistoryComment($editComments, $orderStatus)
						->setIsVisibleOnFront(false)
						->setIsCustomerNotified(false);
			}

			$order->setStatus('pending');
			$order->setState('new');
			
			$order->setBaseShippingInvoiced(0);
			$order->setBaseSubtotalInvoiced(0);
			$order->setBaseTaxInvoiced(0);
			$order->setBaseTotalInvoiced(0);
			$order->setBaseTotalInvoicedCost(0);
			$order->setDiscountInvoiced(0);
			$order->setShippingInvoiced(0);
			$order->setSubtotalInvoiced(0);
			$order->setTaxInvoiced(0);
			$order->setTotalInvoiced(0);
			
			$order->setBaseTaxRefunded(0);
			$order->setBaseTaxCanceled(0);
			$order->setBaseTotalCanceled(0);
			$order->setBaseTotalRefunded(0);
			$order->setDiscountRefunded(0);
			$order->setBaseDiscountInvoiced(0);
			$order->setTaxRefunded(0);
			$order->setTotalRefunded(0);
			
			$order->setBaseTotalPaid(0);
			$order->setTotalPaid(0);
			$order->save();

			//$this->_getSession()->addSuccess($this->__('Item(s) status was successfully reset.'));
			
		}else{
		
			$this->_getSession()->addSuccess($this->__('Item(s) status is already Ordered, no need to Reset.'));		
			$path = Mage::helper('adminhtml')->getUrl("adminhtml/sales_order/view/order_id/".$orderId);
			$this->_redirectUrl($path);
		}
		return true;
	
	}
	
	
	public function deleteInvoiceShipCreditMemo($orderId)
	{ 
			//$orderId = $_REQUEST['order_id'];
			
			$countDeleteOrder = 0;
	        $countDeleteInvoice = 0;
	        $countDeleteShipment = 0;
	        $countDeleteCreditmemo = 0;

			//$order = Mage::getModel('ordereditor/order')->load($id);
			$order = Mage::getModel('sales/order')->load($orderId);
			$coreResource = Mage::getSingleton('core/resource');
        	$write = $coreResource->getConnection('core_write');
		
			if ($order->hasInvoices()) {
				$invoices = Mage::getResourceModel('sales/order_invoice_collection')->setOrderFilter($orderId)->load();
				foreach($invoices as $invoice){
					$invoice = Mage::getModel('sales/order_invoice')->load($invoice->getId());
					$invoice->delete();
					$write->query("DELETE FROM `".$coreResource->getTableName('sales_flat_invoice')."` WHERE `order_id`=".$orderId);
					$write->query("DELETE FROM `".$coreResource->getTableName('sales_flat_invoice_grid')."` WHERE `order_id`=".$orderId);
					$countDeleteInvoice++;
				}
			}
			
			/*if ($order->hasShipments()) {
				$shipments = Mage::getResourceModel('sales/order_shipment_collection')->setOrderFilter($orderId)->load();
				foreach($shipments as $shipment){
					$shipment = Mage::getModel('sales/order_shipment')->load($shipment->getId());
					$shipment->delete();
					$write->query("DELETE FROM `".$coreResource->getTableName('sales_flat_shipment')."` WHERE `order_id`=".$orderId);            
					$write->query("DELETE FROM `".$coreResource->getTableName('sales_flat_shipment_grid')."` WHERE `order_id`=".$orderId);            
					$countDeleteShipment++;
				}
			}
			
			if ($order->hasCreditmemos()) {
				$creditmemos = Mage::getResourceModel('sales/order_creditmemo_collection')->setOrderFilter($orderId)->load();
				foreach($creditmemos as $creditmemo){
					$creditmemo = Mage::getModel('sales/order_creditmemo')->load($creditmemo->getId());
					$creditmemo->delete();
					$countDeleteCreditmemo++;
				}
			}*/
			
			foreach ($order->getAllItems() as $item) 
			{
				$item['qty_canceled'] = 0;
				$item['qty_invoiced'] = 0;
				$item['qty_refunded'] = 0;
				$item['qty_shipped'] = 0;
				
				$item['row_invoiced'] = 0;
				$item['base_row_invoiced'] = 0;
				$item['tax_invoiced'] = 0;
				$item['base_tax_invoiced'] = 0;
				$item['discount_invoiced'] = 0;
				$item['base_discount_invoiced'] = 0;
				
				$item['amount_refunded'] = 0;
				$item['base_amount_refunded'] = 0;
				$item['tax_refunded'] = 0;
				$item['base_tax_refunded'] = 0;
				$item['discount_refunded'] = 0;
				$item['base_discount_refunded'] = 0;
				
				
				$item->save();
			}
			$order->setStatus('pending');
			$order->setState('new');
			
			$order->setBaseShippingInvoiced(0);
			$order->setBaseSubtotalInvoiced(0);
			$order->setBaseTaxInvoiced(0);
			$order->setBaseTotalInvoiced(0);
			$order->setBaseTotalInvoicedCost(0);
			$order->setDiscountInvoiced(0);
			$order->setShippingInvoiced(0);
			$order->setSubtotalInvoiced(0);
			$order->setTaxInvoiced(0);
			$order->setTotalInvoiced(0);
			
			$order->setBaseTaxRefunded(0);
			$order->setBaseTaxCanceled(0);
			$order->setBaseTotalCanceled(0);
			$order->setBaseTotalRefunded(0);
			$order->setDiscountRefunded(0);
			$order->setTaxRefunded(0);
			$order->setTotalRefunded(0);
			
			$order->setBaseTotalPaid(0);
			$order->setTotalPaid(0);
			$order->save();

			return true;
	}
	
}
