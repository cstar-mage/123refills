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
require_once 'Zend/Json/Decoder.php'; 
class Oeditor_Ordereditor_Adminhtml_OrdereditorController extends Mage_Adminhtml_Controller_Action
{
	private $_order;
	 
	protected function _initOrder()
    {
        $id = $this->getRequest()->getParam('order_id');
		$order = Mage::getModel('sales/order')->load($id);
	
        if (!$order->getId()) {
            $this->_getSession()->addError($this->__('This order no longer exists.'));
            $this->_redirect('*/*/');
            $this->setFlag('', self::FLAG_NO_DISPATCH, true);
            return false;
        }
        Mage::register('sales_order', $order);
        Mage::register('current_order', $order);
        return $order;
    }
    
	public function saveItemsAction()
	{
		$allowExtension = Mage::helper('ordereditor')->allowExtension();
		$allowExtension = true;
		if($allowExtension == true)
		{
			$rowTotal = 0;$rowDiscount = 0; $orderMsg = array(); $editFlag = 0; $manageInventory = 1; $productTax = 0;
			$itemCommentsHeading='';$itemComments = '';$logItemComments = array();$orderTotalComments='';$itemRemoveHeading = '';$breaker = '';
			$dataArr = $_POST;
			 //echo '<pre>';print_r($dataArr);die;

			 $orderEditReasonText = $dataArr['edit_text'];
			 $editReasonChecked = $dataArr['edit_check'];
			 $notifyCusChecked = $dataArr['notify_check'];

			$prefix = Mage::getConfig()->getTablePrefix();
			
			$itemCount = count($dataArr['item_price']);
			
			$logEnabled = Mage::getStoreConfig('editorder/orderlog/quick_edit_log'); 
			$resource = Mage::getSingleton('core/resource');
			$writeConnection = $resource->getConnection('core_write');
			
			$orderId = $dataArr['order_id'];
			$order = Mage::getModel('sales/order')->load($orderId);
		
		}
		else
		{
				Mage::getSingleton('adminhtml/session')->addError($this->__('Please purchase License for the extension.'));
				echo "Successfully updated.";
				return $this;

		}
		

$oldOrderArr= array('order_total'=>$order->getGrandTotal(), 'tax'=>$order->getTaxAmount(), 'dis'=>$order->getDiscountAmount(),'subt'=>$order->getSubtotal());

		$currencyCode = Mage::app()->getLocale()->currency($order->getOrderCurrencyCode())->getSymbol();
		$oldGrandTotal = $order->getGrandTotal();
		$orderArr = $order->getData();
		$manage_inventory = Mage::getStoreConfig('editorder/orderstockmg/manage_inventory'); 
		
		try{			
			foreach($dataArr['item_id'] as $key => $itemId) {

				$item = $order->getItemById($itemId);
				
				if(isset($dataArr['remove'][$itemId]) && $dataArr['remove'][$itemId] != "") 
				{
					//echo 'remove-'.$item->getId();echo '<br/>';
					
					$countOrderItems = count($dataArr['item_id']);
					if($countOrderItems <= 1 )
					{
							Mage::getSingleton('adminhtml/session')->addError($this->__('Order has only 1 Item and cannot be deleted.Please click on "Edit" button there you can add/edit/delete products.'));
							echo "Successfully updated.";
							return $this;
					} 
					//$order->removeItem($itemId);
					if($item->getProductType() != "simple")/* it will delete bundle,config,grouped and its child items*/
					{
						/*retrieve item's child item Id Starts*/
							$sql = "SELECT item_id FROM ".$prefix."sales_flat_order_item WHERE parent_item_id='".$itemId."' and order_id='".$orderId."' ";
							$sqlResultArr = Mage::getSingleton('core/resource')->getConnection('core_read')->fetchAll($sql);
						/*retrieve item's child item Id Ends*/
						
						$quoteItemId = $item->getQuoteItemId();	
						/*delete parent and child product will automatically delete*/
						$conQuoteItemId = "delete from ".$prefix."sales_flat_quote_item where item_id = '".$quoteItemId."'" ;
						$writeConnection->query($conQuoteItemId);
						
						/*delete child products based on parent Id*/
						$condition = "delete from ".$prefix."sales_flat_order_item where parent_item_id = '".$itemId."' and order_id='".$orderId."'";
						$writeConnection->query($condition);
						//$sqlResult = Mage::getSingleton('core/resource')->getConnection('core_read')->fetchRow($condition);
						/*delete child ends*/
						
						/*delete parent products based on Item Id*/
						$conditionParentItem = "delete from ".$prefix."sales_flat_order_item where item_id = '".$itemId."' and order_id='".$orderId."'";
						$writeConnection->query($conditionParentItem);
						//$sqlResult = Mage::getSingleton('core/resource')->getConnection('core_read')->fetchRow($conditionParentItem);
						
						/*Delete Invoice Item*/
						$conditionInv = "delete from ".$prefix."sales_flat_invoice_item where order_item_id = '".$itemId."'";
					    $writeConnection->query($conditionInv);
						if(count($sqlResultArr) > 0)
						{
							/*Delete Invoice child Item*/
							foreach($sqlResultArr as $recordItemId)
							{
								if(isset($recordItemId['item_id']) && $recordItemId['item_id'] != "")
								{
									$conditionInv = "delete from ".$prefix."sales_flat_invoice_item where order_item_id = '".$recordItemId['item_id']."'";
									$writeConnection->query($conditionInv);								
								}
							}
						}
					}
					else
					{
							/* Update Qty Stock Starts*/
							if($manage_inventory == 1)
							{
								$productId = $item->getProductId();
								$product = Mage::getModel('catalog/product')->load($productId);
								$productType = $product->getTypeId();
								$manageStock = Mage::getModel('cataloginventory/stock_item')->loadByProduct($product)->getManageStock();
								$minQtyOutOfStock = Mage::getModel('cataloginventory/stock_item')->loadByProduct($product)->getMinQty();
								if($productType == "simple" || $productType == "downloadable" && $productType == "virtual")
								{
									$stockData = $product->getStockData();
									$qtyStock = Mage::getModel('cataloginventory/stock_item')->loadByProduct($product)->getQty();
									$stockData['qty'] = $qtyStock + $item->getQtyOrdered();
									if($stockData['qty'] > $minQtyOutOfStock){$stockData['is_in_stock'] = 1;}else{$stockData['is_in_stock'] = 0;}
									if($manageStock == 1){$stockData['manage_stock'] = 1; }
									//$stockData['use_config_manage_stock'] = 0;
									$product->setStockData($stockData);
									$product->save();
								}
							}
							/* Update Qty Stock Ends*/
						
						$item->delete();
						$condition = "delete from ".$prefix."sales_flat_invoice_item where order_item_id = '".$itemId."'";
					    $writeConnection->query($condition);
					}
					
					if($logEnabled == 1)
					{	
						$productId = $item->getProductId();
						$product = Mage::getModel('catalog/product')->load($productId);
						$itemRemoveHeading .= $this->__('Item ').'<b>'.$product->getName().'</b>'.$this->__(' was removed.').'<br/>';
					}
					
				}else{

						if($item->getProductType() != "bundle") /*do not allow bundle item to enter in loop as it do not have price,qty,tax.discount etc. boxes*/
						{
							$sql = "SELECT * FROM ".$prefix."sales_flat_order_item WHERE item_id='".$itemId."'";
							$sqlResult = Mage::getSingleton('core/resource')->getConnection('core_read')->fetchRow($sql);
							$retrieveItemId = $sqlResult['item_id'];
							/* 
								bundle items has child product as simple product and when we manually delete bundle product and its child product from DB
								then its child product also enter in this loop to update data becuase ids are already available in loop.
							*/
							if(isset($retrieveItemId) && $retrieveItemId != "") 
							{
$oldArray = array('item_price'=>$item->getPrice(), 'discount'=>$item->getDiscountAmount(), 'qty'=>$item->getQtyOrdered(), 'row_total'=>$item->getRowTotal(), 'tax'=>$item->getTaxAmount());							
								$productTax = $productTax + $dataArr['tax'][$key];  // get the item tax
								//	$productTax = 0 ; 
	// here setting tax 0 everything, so if the already added item price changes to higher/lower then the tax will set to zero,admin can set item new price inclusive tax manually
								$item->setTaxAmount($dataArr['tax'][$key]);
								
								if(isset($dataArr['tax_per'][$key]))
								{$item->setTaxPercent($dataArr['tax_per'][$key]);}
					 // and also set item tax to zero so that, tax amount that is calculated(by customer-for old product while purchase), will not show in the item list
					//$item->setTaxPercent($dataArr['tax_percent'][$key]);
					 // and also set item tax percentage to zero so that, tax amount that is calculated(by customer-for old product while purchase), will not show in the item list
											
								$item->setPrice($dataArr['item_price'][$key]); 
								$item->setBasePrice($dataArr['item_price'][$key]);
								$item->setBasePriceInclTax($dataArr['item_price'][$key] + $dataArr['tax'][$key]);
								$item->setPriceInclTax($dataArr['item_price'][$key] + $dataArr['tax'][$key]);
								
								$product = $item->getProduct();
								$productPrice = $product->getPrice();
								
								$item->setBaseOriginalPrice($productPrice);
								$item->setOriginalPrice($productPrice);
								
								$item->setBaseRowTotal($dataArr['item_price'][$key] * $dataArr['qty'][$key]);
								$item->setRowTotal($dataArr['item_price'][$key] * $dataArr['qty'][$key]); //new
				
								$item->setRowTotalInclTax(($dataArr['item_price'][$key] * $dataArr['qty'][$key]) + $dataArr['tax'][$key]); //new
								$item->setBaseRowTotalInclTax(($dataArr['item_price'][$key] * $dataArr['qty'][$key]) + $dataArr['tax'][$key]); //new

								if(isset($dataArr['discount'][$key]) && $dataArr['discount'][$key] != 0) {
									$item->setDiscountAmount($dataArr['discount'][$key]);
									$item->setBaseDiscountAmount($dataArr['discount'][$key]);
									
									if(isset($dataArr['discount_per'][$key]))
									{$item->setDiscountPercent($dataArr['discount_per'][$key]);}
									
								}else{$item->setDiscountAmount(0);}
								
								if($dataArr['qty'][$key])
								{
									$item->setQtyOrdered($dataArr['qty'][$key]);
								}
								
								$item->save();
								$rowTotal =  $rowTotal + $item->getRowTotal();
								$rowDiscount = $rowDiscount +  $item->getDiscountAmount() ;
								 
$newArray = array('item_price'=>$item->getPrice(), 'discount'=>$item->getDiscountAmount(), 'qty'=>$item->getQtyOrdered(),'tax'=>$item->getTaxAmount(),'row_total'=>$item->getRowTotal());
								/* Update Qty Stock Starts*/
								if($manage_inventory == 1)
								{
								$productId = $item->getProductId();
								$product = Mage::getModel('catalog/product')->load($productId);
								$productType = $product->getTypeId();
								$manageStock = Mage::getModel('cataloginventory/stock_item')->loadByProduct($product)->getManageStock();
								$minQtyOutOfStock = Mage::getModel('cataloginventory/stock_item')->loadByProduct($product)->getMinQty();
								if($productType == "simple" || $productType == "downloadable" && $productType == "virtual")
								{
									$stockData = $product->getStockData();
									$qtyStock = Mage::getModel('cataloginventory/stock_item')->loadByProduct($product)->getQty();
									$stockData['qty'] = $qtyStock - $item->getQtyOrdered();
									if($stockData['qty'] > $minQtyOutOfStock){$stockData['is_in_stock'] = 1;}else{$stockData['is_in_stock'] = 0;}
									if($manageStock == 1){$stockData['manage_stock'] = 1; }
									//$stockData['use_config_manage_stock'] = 0;
									$product->setStockData($stockData);
									$product->save();
								}
							}
								/* Update Qty Stock Ends*/
							
								if($logEnabled == 1)
								{
									$itemComments = '';	$itemCommentsHeading = '<br/>';
								if($newArray['item_price'] != $oldArray['item_price']) 
								{$itemComments .= $this->__('&nbsp;-Price was update from ').$currencyCode.number_format($oldArray['item_price'],2) .'-To-'.$currencyCode.$newArray['item_price'].'<br/>';}
								if($newArray['discount'] != $oldArray['discount']) 
								{$itemComments .= $this->__('&nbsp;-Discount was update from ').$currencyCode.$oldArray['discount'] .'-To-'.$currencyCode.$newArray['discount'].'<br/>';}
								if($newArray['qty'] != $oldArray['qty']) 
								{$itemComments .= $this->__('&nbsp;-Qty was update from ').$oldArray['qty'] .'-To-'.$newArray['qty'].'<br/>';}
								if($newArray['tax'] != $oldArray['tax']) 
								{$itemComments .= $this->__('&nbsp;-Tax was update from ').$currencyCode.number_format($oldArray['tax'],2) .'-To-'.$currencyCode.$newArray['tax'].'<br/>';}	
								if($newArray['row_total'] != $oldArray['row_total']) 
								{$itemComments .= $this->__('&nbsp;-Row Total was update from ').$currencyCode.number_format($oldArray['row_total'],2) .'-To-'.$currencyCode.$newArray['row_total'].'<br/>';}
									if($itemComments != "")
									{
										$productId = $item->getProductId();
										$product = Mage::getModel('catalog/product')->load($productId);
										$itemCommentsHeading .= $this->__('Item ').'<b>'.$product->getName().'</b>'.$this->__(' was updated with following:').'<br/>';
										$logItemComments[] = $itemCommentsHeading.$itemComments;
										//$logItemComments .= $itemSectionComments ;
									}
								}
						  }
						}/*check product type condition close bracket*/
				}
		}
		
			
			
				$order->setIsEdit(1);
				$order->setSubtotal($rowTotal);
				$order->setBaseSubtotal($rowTotal);
				
				$order->setDiscountAmount('-'.$rowDiscount); 
				$order->setBaseDiscountAmount('-'.$rowDiscount); 


				$order->setBaseSubtotalInclTax($rowTotal+$productTax);
				$order->setSubtotalInclTax($rowTotal+$productTax);
				
//				24-7-14
				$productTax = $productTax + $order->getShippingTaxAmount() ; // if shipping has tax then it to total tax [Do not add shippign tax to subtotal as subtotal is for product]
				
				//$order->setBaseSubtotalInclTax($rowTotal);
				//$order->setSubtotalInclTax($rowTotal);
				
				$order->setBaseGrandTotal($order->getShippingAmount()+$rowTotal+$productTax-$rowDiscount);
				
				/* set directly total order tax amount,so order exclusive grand total will automatically minus this tax from order inclusive grand total it is the amount tha will show the total tax summary (+)(shipping+product tax) */ 
				$order->setTaxAmount($productTax); 
				$order->setBaseTaxAmount($productTax); 


				$resource = Mage::getSingleton('core/resource');
				$writeConnection = $resource->getConnection('core_write');
				$table = $resource->getTableName('sales/order_tax');
				$orderIdTax = $order->getId();
				$query = "UPDATE {$table} SET amount = '{$productTax}',base_amount = '{$productTax}',base_real_amount = '{$productTax}' WHERE order_id  = "
						 . (int)$orderIdTax;
				$writeConnection->query($query);
				
				$order->setGrandTotal($order->getShippingAmount()+$rowTotal+$productTax-$rowDiscount);
				$order['is_edit'] = 1;

				
				$order->save();	/*Order Save*/
				
$newOrderArr= array('order_total'=>$order->getGrandTotal(), 'tax'=>$order->getTaxAmount(), 'dis'=>$order->getDiscountAmount(),'subt'=>$order->getSubtotal());
				
				
				
					
				
					$newTotal = $order->getGrandTotal();
					if(Mage::getStoreConfig('editorder/general/reauth')) {
						if($newTotal > $oldGrandTotal) {
			
								$payment = $order->getPayment();
								$orderMethod = $payment->getMethod();
								if($orderMethod != 'free' && $orderMethod != 'checkmo' && $orderMethod != 'purchaseorder') {
									if(!$payment->authorize(1, $newTotal)) {
										echo "There was an error in re-authorizing payment.";
										return $this;
									}else{
										$additionalInformation  = $payment->getData('additional_information');
										$payment->save();
										//$order->setTotalPaid($postTotal);
										
										if( $orderMethod != "paypal_express" &&  $orderMethod != "verisign" &&  $orderMethod != "paypal_direct")
										{
										 	$order->save();
										} /* this function is used to save re-auth entries in magento DB*/
									}
								}
							}
						}
					
				if($logEnabled == 1)
					{
					if($newOrderArr['subt'] != $oldOrderArr['subt'])
					{$orderTotalComments .= $this->__('-Order Subtotal(Excl. Tax) was update from ').$currencyCode.number_format($oldOrderArr['subt'],2) .'-To-'.$currencyCode.number_format($newOrderArr['subt'],2).'<br/>';}

					if($newOrderArr['tax'] != $oldOrderArr['tax'])
					{$orderTotalComments .= $this->__('-Order Tax was update from ').$currencyCode.number_format($oldOrderArr['tax'],2) .'-To-'.$currencyCode.number_format($newOrderArr['tax'],2).'<br/>';}
					if($newOrderArr['dis'] != $oldOrderArr['dis'])
					{$orderTotalComments .= $this->__('-Order Discount was update from ').$currencyCode.number_format($oldOrderArr['dis'],2) .'-To-'.$currencyCode.number_format($newOrderArr['dis'],2).'<br/>';}
				
					if($newOrderArr['order_total'] != $oldOrderArr['order_total'])
					{$orderTotalComments .= $this->__('-Order Total(Incl. Tax) was update from ').$currencyCode.number_format($oldOrderArr['order_total'],2) .'-To-'.$currencyCode.number_format($newOrderArr['order_total'],2).'<br/>';}


					if(!empty($logItemComments)|| $itemRemoveHeading != "" && $orderTotalComments != "")
					{$breaker = '<br/>'.'--------------------------------------<i>'.$this->__(' Order Total : ').'</i>-----------------------------------------------'.'<br/>';}
					
					$userName = Mage::getSingleton('admin/session')->getUser()->getUsername();
					$firstName = Mage::getSingleton('admin/session')->getUser()->getFirstname();
					$lastName = Mage::getSingleton('admin/session')->getUser()->getLastname();
					
					$logItemComments = implode(" ",$logItemComments);
					$editComments = $logItemComments . $itemRemoveHeading . $breaker. $orderTotalComments;
					
					if($editReasonChecked == "true" && $orderEditReasonText != "")
					{
						$breaker = '<br/>'.'--------------------------------------<i>'.$this->__(' Edit Reason: ').'</i>-----------------------------------------------'.'<br/>';
						$editComments .= $breaker . $orderEditReasonText ;
					}
					//echo $notifyCusChecked;die;
					if($notifyCusChecked == "true")
					{	
						$editComments .= '<br/>';
						$editComments .= $this->__('Customer is Notified via Email');

						if($orderEditReasonText != ""){$comment = $orderEditReasonText;}
						else{ 
								$notifyMsg = $this->__('Your Order is Updated Successfully'); 
								$comment = $notifyMsg.'<br/>'.$orderEditReasonText ; 
						}
						$order->sendOrderUpdateEmail(true, $comment);

					}
					if($editComments != "")
					{
						$orderStatus = $order->getStatus();
						$orderEditedBy = '<i>'.$this->__('Order is Edited By: ').'</i>'.$firstName . ' '.$lastName .' ('.$userName .')'.' <br/>';
						$editComments = $orderEditedBy.$editComments;
						$order->addStatusHistoryComment($editComments, $orderStatus)
							->setIsVisibleOnFront(false)
							->setIsCustomerNotified(false);
						$order->save();
					}

				}
						
						
				Mage::getSingleton('adminhtml/session')->addSuccess($this->__('The order has been updated successfully.'));
				echo "Successfully updated.";
				return $this;
		}
		catch(Exception $e){
				Mage::getSingleton('adminhtml/session')->addException($e, $this->__('Order saving error: %s', $e->getMessage()));
				$path = Mage::helper('adminhtml')->getUrl("adminhtml/sales_order/view/order_id/".$orderId);
				$this->_redirectUrl($path);
			}
		
	}
	
	public function saveshippingAction()
	{
	
		//	$postData = $_REQUEST;
		$postData = $_POST;
		$orderId = $postData['order_id'];
		$order = Mage::getModel('sales/order')->load($orderId);
		$oldShippingAmount = $order->getShippingAmount();
		$oldGrandTotal = $order->getGrandTotal();
		$activeShippingMethods = Mage::getSingleton('shipping/config')->getActiveCarriers();
		$preShippingDesc = $order->getShippingDescription();
		$logEnabled = Mage::getStoreConfig('editorder/orderlog/detail_edit_log');
		$currencyCode = Mage::app()->getLocale()->currency($order->getOrderCurrencyCode())->getSymbol();
		$shippingLogComments = '';
		
			try{
				if(isset($postData['ship_price']) && $postData['ship_price'] != '') 
				{
					$postData['ship_price'] = ($postData['ship_price'] < 0) ? $postData['ship_price'] * 0 : $postData['ship_price'];

					$orderPreShipingTaxAmount = $order->getShippingTaxAmount();
					$orderTaxAmount = $order->getTaxAmount(); 
					$preGrandTotal = $order->getGrandTotal() - $orderTaxAmount; //in db grand total is tax included
					$orderPreShipingAmount = $order->getShippingAmount();
					$shippingTax = $postData['ship_inc_price'] - $postData['ship_price'];
					
					$newTotalTax = $orderTaxAmount - $orderPreShipingTaxAmount + $shippingTax;
					
					$order->setBaseShippingTaxAmount($shippingTax);// shipping tax amount
					$order->setShippingTaxAmount($shippingTax);

					$order->setBaseShippingAmount($postData['ship_price']); // shipping excl amount
					$order->setShippingAmount($postData['ship_price']);

					$order->setShippingInclTax($postData['ship_inc_price']); // shipping incl amount
					$order->setBaseShippingInclTax($postData['ship_inc_price']);
				

					$order->setTaxAmount($newTotalTax); 
					$order->setBaseTaxAmount($newTotalTax); 
					
					//$order->setBaseSubtotalInclTax($rowTotal+$productTax);
					//$order->setSubtotalInclTax($rowTotal+$productTax);				
					//$order->setBaseGrandTotal($preGrandTotal + $newTotalTax);
					
			  		
					/*set custom shipping metdhod session price*/
					Mage::getSingleton('core/session')->setCustomshippriceAmount($postData['ship_price']);
					Mage::getSingleton('core/session')->setCustomshippriceBaseAmount($postData['ship_price']);
					/*set custom shipping metdhod session price*/
					
					if(isset($activeShippingMethods['customshipprice']) && is_object($activeShippingMethods['customshipprice']))
					{
						$order->setShippingMethod('customshipprice_customshipprice');
						$order->setShippingDescription($postData['custom_shipping_method']." - ".$postData['custom_name']);
						/*set custom shipping metdhod session description*/
				        Mage::getSingleton('core/session')->setCustomshippriceDescription($postData['custom_shipping_method']." - ".$postData['custom_name']);
					}
					else
					{
						if(isset($postData['custom_shipping_method']) && $postData['custom_shipping_method'] != '') 
						{
							$newMethod = strtolower($postData['custom_shipping_method']);
							if($newMethod == 'other' || $newMethod == "none"){$newMethod = 'freeshipping';}						
							$order->setShippingMethod($newMethod);
							$order->setShippingDescription($postData['custom_shipping_method']." - ".$postData['custom_name']);
						}
					}			
	
					$newShippingAmount = $order->getShippingAmount();
					$newTotal = $oldGrandTotal + $newShippingAmount - $oldShippingAmount;	
					
					$order->setBaseGrandTotal($preGrandTotal - $orderPreShipingAmount + $postData['ship_price'] + $newTotalTax );
					$order->setGrandTotal($preGrandTotal - $orderPreShipingAmount + $postData['ship_price'] + $newTotalTax );
					
				/*Save Logs to the history comments Starts*/
					if($logEnabled == 1)
					{
						$orderStatus = $order->getStatus();
						
						$userName = Mage::getSingleton('admin/session')->getUser()->getUsername();
						$firstName = Mage::getSingleton('admin/session')->getUser()->getFirstname();
						$lastName = Mage::getSingleton('admin/session')->getUser()->getLastname();
						
						$orderEditedBy = '<i>'.$this->__('Order is Edited By: ').'</i>'.$firstName . ' '.$lastName .' ('.$userName .')'.' <br/>';
						
						$logShipDesc = $postData['custom_shipping_method']." - ".$postData['custom_name'];
						if($preShippingDesc != $logShipDesc)
						{
							$shippingLogComments .= '<b>'.$this->__('Shipping method was updated from ') .'</b>'.'<br/>';
							$shippingLogComments .= '&nbsp;-'.$preShippingDesc .  $this->__(' -to- ') .$logShipDesc.'<br/>';
						}
						if($postData['ship_price'] != $orderPreShipingAmount)
						{
							$preShippingAmount = number_format($orderPreShipingAmount,2);
							$logShippingPrice = number_format($postData['ship_price'],2);
							$shippingLogComments .= '<b>'.$this->__('Shipping Price was updated from ') .'</b>';
							$shippingLogComments .= '&nbsp;-'.$currencyCode.$preShippingAmount .  $this->__(' -to- ') .$currencyCode.$logShippingPrice .'<br/>';
						}
						if($shippingTax != $orderPreShipingTaxAmount)
						{
							$shippingTax = number_format($shippingTax,2);
							$orderPreShipingTaxAmount = number_format($orderPreShipingTaxAmount,2);
							$shippingLogComments .= '<b>'.$this->__('Shipping Tax was updated ') .'</b>';
							$shippingLogComments .= '&nbsp;-'.$currencyCode . $orderPreShipingTaxAmount .  $this->__(' -to- ') .$currencyCode.$shippingTax .'<br/>';
						}
						if($shippingLogComments != "")
						{
							$editComments = $orderEditedBy . $shippingLogComments;
							$order->addStatusHistoryComment($editComments, $orderStatus)
									->setIsVisibleOnFront(false)
									->setIsCustomerNotified(false);
						}
					}			
				/*Save Logs to the history comments Ends*/

					$order->save();
					
					if(Mage::getStoreConfig('editorder/general/reauth')) {
						if($newTotal > $oldGrandTotal) {
								$payment = $order->getPayment();
								$orderMethod = $payment->getMethod();
								if($orderMethod != 'free' && $orderMethod != 'checkmo' && $orderMethod != 'purchaseorder') {
			 
									if(!$payment->authorize(1, $newTotal)) {
										echo "There was an error in re-authorizing payment.";
										return $this;
									}else{
										$additionalInformation  = $payment->getData('additional_information');
										$payment->save();
										//$order->setTotalPaid($postTotal);
										if( $orderMethod != "paypal_express" &&  $orderMethod != "verisign" &&  $orderMethod != "paypal_direct")
										{
										 	$order->save();
										} /* this function is used to save re-auth entries in magento DB*/
									}
								}
							}
						}
					
					Mage::getSingleton('adminhtml/session')->addSuccess($this->__('The shipping has been updated successfully.'));
					echo "Successfully updated.";
					return $this;
			}
			else
			{
				Mage::getSingleton('adminhtml/session')->addError($this->__('Please enter Shipping Price.'));
				$path = Mage::helper('adminhtml')->getUrl("adminhtml/sales_order/view/order_id/".$orderId);
				$this->_redirectUrl($path);
			}
			
			}catch(Exception $e){
				Mage::getSingleton('adminhtml/session')->addException($e, $this->__('Order saving error: %s', $e->getMessage()));
				$path = Mage::helper('adminhtml')->getUrl("adminhtml/sales_order/view/order_id/".$orderId);
				$this->_redirectUrl($path);
			}
	}
	
	private function _loadOrder($orderId) {
		$this->_order = Mage::getModel('sales/order')->load($orderId);
		if(!$this->_order->getId()) return false;
		return true;
	}
	
	public function saveinvoicestatusAction() {
		$field = $this->getRequest()->getParam('field');
		$invoiceId = $this->getRequest()->getParam('invoice_id');
		$value = $this->getRequest()->getPost('value');
 
		if (!empty($field) && !empty($invoiceId)) {
			$invoice = Mage::getModel('sales/order_invoice')
                    ->load($invoiceId);
			$invoiceState = $invoice->setState($value);
			$invoice->save();

			$statuses = Mage::getModel('sales/order_invoice')->getStates();
			$invoiceState = $invoice->getState();
			if(isset($invoiceState))
			echo $invoiceStateLabel = $statuses[$invoiceState];
			else echo 'error in saving..';
		}
	}
	
	public function saveAction() {
		$field = $this->getRequest()->getParam('field');
		$type = $this->getRequest()->getParam('type');
		$orderId = $this->getRequest()->getParam('order');
		$value = $this->getRequest()->getPost('value');
		if (!empty($field) && !empty($type) && !empty($orderId)) {
			if(!empty($value)) {
				if(!$this->_loadOrder($orderId)) {
					$this->getResponse()->setBody($this->__('error: missing order number'));
				}
				$res = $this->_editAddress($type,$field,$value);
				if($res !== true) {
					$this->getResponse()->setBody($this->__('error: '.$res));
				} else {
						
						if($field == "order_status"){
							$statuses = Mage::getSingleton('sales/order_config')->getStatuses();
							foreach($statuses as $key=>$keyValue)
							{
								if($key == $value) { $this->getResponse()->setBody($keyValue);break;} 
							}
							
						}
						
						else{$this->getResponse()->setBody($value); }
				}
			} else {
				$this->getResponse()->setBody($this->__('error: value required'));
			}
		} else {
			$this->getResponse()->setBody('undefined error');
		}
	}
  

	private function _editAddress($type,$field,$value) {
  //echo $type.'='.$field.'='.$value;die;
  		$logEnabled = Mage::getStoreConfig('editorder/addlog/enabled');
		
		if($type == "bill") {
			  $address = $this->_order->getBillingAddress();
			 
			$addressSet = 'setBillingAddress';
		} elseif($type == "ship") {
			$address = $this->_order->getShippingAddress();
			$addressSet = 'setShippingAddress';
		} elseif($type == "cemail") {
				$this->_order->setCustomerEmail($value)->save();
				return true;
		} elseif($type == "cust_name") {

				$explodeName = explode(" ",$value);
				if(isset($explodeName[0]) && $explodeName[0] != ""){ $firstName = $explodeName[0]; $this->_order->setCustomerFirstname($firstName)->save();}
				if(isset($explodeName[1]) && $explodeName[1] != ""){ $lastName = $explodeName[1]; $this->_order->setCustomerLastname($lastName)->save();}
			
				
				return true;
		} elseif($type == "edit_ord") {
				$orderObj = $this->_order;
				if($logEnabled == 1)
				{										
					$userName = Mage::getSingleton('admin/session')->getUser()->getUsername();
					$firstName = Mage::getSingleton('admin/session')->getUser()->getFirstname();
					$lastName = Mage::getSingleton('admin/session')->getUser()->getLastname();
					$preOrderStatus = ucfirst($orderObj->getStatus());

					if($preOrderStatus != $value)
					{
						$orderStatus = $orderObj->getStatus();
						$orderEditedBy = '<i>'.$this->__('Order is Edited By: ').'</i>'.$firstName . ' '.$lastName .' ('.$userName .')'.' <br/>';
						$editComments = $this->__('Order Status was updated from ').$preOrderStatus. $this->__('-To- ').ucfirst($value);
						$editComments = $orderEditedBy. $editComments;				
						$orderObj->addStatusHistoryComment($editComments, $orderStatus)
									->setIsVisibleOnFront(false)
									->setIsCustomerNotified(false);
					}
				}
				$orderObj->setStatus($value)->save();
				//$this->_order->setStatus($value)->save();
				return true;
		}
		
		elseif($type == "edit_customer_group") {

			$this->_order->setCustomerGroupId($value)->save();
			
			$group = Mage::getModel('customer/group')->load($value);
      		echo $value = $group->getCode();die;
			return true;
			
		}
		
		else {
			return 'type not defined';
		}

		$updated = false;
    	$fieldGet = 'get'.ucwords($field);
    	$fieldSet = 'set'.ucwords($field);


    	if($address->$fieldGet() != $value) {
 
    		if($field == 'country') {
    			$fieldSet = 'setCountryId';
    			$countries = array_flip(Mage::app()->getLocale()->getCountryTranslationList());
    			if(isset($countries[$value])) {
    				$value = $countries[$value];
    			} else {
    				return 'country not found';
    			}
    		}
    		if(substr($field,0,6) == 'street') {
    			$i = substr($field,6,1);
    			if(!is_numeric($i))
    				$i = 1;
    			$valueOrg = $value;
    			$value = array();
    			for($n=1;$n<=4;$n++) {
    				if($n != $i) {
	    				$value[] = $address->getStreet($n);
    				} else {
    					$value[] = $valueOrg;
    				}
    			}
    			$fieldSet = 'setStreet';
    		}
    		//update field and set as updated
    		$address->$fieldSet($value);
    		$updated = true;
    	}

		if($updated) {
//			$this->_order->setStatus($value)->save();
				 if($field == "firstname") {
					$this->_order->setFirstName($value)->save();
					return true;
				}
				 if($field == "lastname") {
					$this->_order->setLastName($value)->save();
					return true;
				}
				
				 if($field == "street1") {
					$this->_order->setStreet1($value)->save();
					return true;
				}
				
				 if($field == "street2") {
					$this->_order->setStreet2($value)->save();
					return true;
				}
				
				 if($field == "street3") {
					$this->_order->setStreet3($value)->save();
					return true;
				}
				 if($field == "street4") {
					$this->_order->setStreet4($value)->save();
					return true;
				}
				
				 if($field == "city") {
					$this->_order->setCity($value)->save();
					return true;
				}
				 if($field == "region") {
					$this->_order->setRegion($value)->save();
					return true;
				}
				 if($field == "postcode") {
					$this->_order->setPostcode($value)->save();
					return true;
				}
				 if($field == "country") {
					$this->_order->setCountry($value)->save();
					return true;
				}
				 if($field == "telephone") {
					$this->_order->setTelephone($value)->save();
					return true;
				}
				 if($field == "fax") {
					$this->_order->setFax($value)->save();
					return true;
				}

			$this->_order->$addressSet($address);
        	$this->_order->save();
		}
		return true;
	}
	
	public function deleteOrderAction()
	{
	   $prefix = Mage::getConfig()->getTablePrefix();
 	   $orderId = $_REQUEST['order_id'];
 	   $resource = Mage::getSingleton('core/resource');
	   $writeConnection = $resource->getConnection('core_write');
	   $connectionRead = Mage::getSingleton('core/resource')->getConnection('core_read');
	   
	   $order = Mage::getModel('sales/order')->load($orderId);
	   $incrementId = $order['increment_id'];
	   $quoteId = $order['quote_id'];

/*Reset foreign checks to 1 Starts*/
		$writeConnection->query("SET FOREIGN_KEY_CHECKS=0");
/*Reset foreign checks to 1 Ends*/

/*Delete Order Credit Memo related entries*/
	  if ($order->hasCreditmemos())
	  {
		$creditmemos = Mage::getResourceModel('sales/order_creditmemo_collection')->setOrderFilter($orderId)->load();
		foreach($creditmemos as $creditmemo){
			$creditmemo = Mage::getModel('sales/order_creditmemo')->load($creditmemo->getId());
			$creditmemo->delete();
 		}
	 }
/*Delete Order Credit Memo related entries Ends*/

/*Delete Order Invoice related entries*/
		if ($order->hasInvoices())
		{
			$invoices = Mage::getResourceModel('sales/order_invoice_collection')->setOrderFilter($orderId)->load();
			foreach($invoices as $invoice){
				$invoice = Mage::getModel('sales/order_invoice')->load($invoice->getId());
				$invoice->delete();
			}
		}
/*Delete Order Invoice related entries Ends*/

/*Delete Order Quote related entries*/
 	   
	   if ($order->hasShipments())
	   {
			$shipments = Mage::getResourceModel('sales/order_shipment_collection')->setOrderFilter($orderId)->load();
			foreach($shipments as $shipment){
				$shipment = Mage::getModel('sales/order_shipment')->load($shipment->getId());
				$shipment->delete();
			}
		}
		
		
/*Delete sales flat order related entries Starts*/

		$condition = "delete from ".$prefix."sales_flat_quote where entity_id = '".$quoteId."'";
		$writeConnection->query($condition);
		   
		$orderAllItems = $order->getAllItems();
		foreach($orderAllItems as $item)
		{
			$quoteItemId = $item->getQuoteItemId();
			
			$condition = "delete from ".$prefix."sales_flat_quote_item where item_id = '".$quoteItemId."'";
		    $writeConnection->query($condition);
			
			$condition = "delete from ".$prefix."sales_flat_quote_item_option where item_id = '".$quoteItemId."'";
		    $writeConnection->query($condition);
			
			$item->delete();
 		}

		$addressIdReadQry = "select address_id from ".$prefix."sales_flat_quote_address where quote_id='".$quoteId."' and address_type = 'billing' ";
		$addressIdArr = $connectionRead->fetchRow($addressIdReadQry);
		
		$addressIdReadshipQry = "select address_id from ".$prefix."sales_flat_quote_address where quote_id='".$quoteId."' and address_type = 'shipping' ";
		$addressIdShippingArr = $connectionRead->fetchRow($addressIdReadshipQry);
		
		$addressIdReadQry1 = "select address_id from ".$prefix."sales_flat_quote_address where quote_id='".$quoteId."'";
		$quoteParentIdArr = $connectionRead->fetchRow($addressIdReadQry1);
		
		$condition = "delete from ".$prefix."sales_flat_quote_address where quote_id = '".$quoteId."'";
		$writeConnection->query($condition);
		
		$condition = "delete from ".$prefix."sales_flat_quote_payment where quote_id = '".$quoteId."'";
		$writeConnection->query( $condition);

		$condition = "delete from ".$prefix."sales_flat_order_status_history where parent_id = '".$orderId."'";
		$writeConnection->query( $condition);
		
		/*delete billing type*/
		$condition = "delete from ".$prefix."sales_flat_quote_shipping_rate where address_id = '".$addressIdArr['address_id']."'";
		$writeConnection->query($condition);
		
		/*delete shipping type*/
		$condition = "delete from ".$prefix."sales_flat_quote_shipping_rate where address_id = '".$addressIdShippingArr['address_id']."'";
		$writeConnection->query($condition);
		
		$condition = "delete from ".$prefix."sales_flat_quote_address_item where parent_item_id = '".$quoteParentIdArr['address_id']."'";
		$writeConnection->query($condition);
		
		$condition = "delete from ".$prefix."sales_flat_order_grid where entity_id = '".$orderId."'";
		$writeConnection->query( $condition);
 
/*Delete Order Quote related entries Ends*/
		
		$condition = "delete from ".$prefix."sales_flat_order_address where parent_id = '".$orderId."'";
		$writeConnection->query( $condition);
		
		$condition = "delete from ".$prefix."sales_flat_order_payment where parent_id = '".$orderId."'";
		$writeConnection->query( $condition);
		
		$order->delete();
		
		/*Delete sales payment transactions entries Starts*/
		//	   $condition = "delete from sales_payment_transaction where order_id = '".$orderId."'";
		//	   $writeConnection->query('sales_payment_transaction', $condition);
		/*Delete sales payment transactions related entries Edns*/
		
		/*Delete log related entries Starts*/
		//	   $condition = "delete from log_quote where quote_id = '".$quoteId."'";
			//   $writeConnection->query('log_quote', $condition);
		/*Delete log related entries Edns*/
  
/*Reset foreign checks to 1 Starts*/
		$writeConnection->query("SET FOREIGN_KEY_CHECKS=1");
/*Reset foreign checks to 1 Ends*/
		$this->_getSession()->addSuccess($this->__('Order is successfully deleted.'));
 		$path = Mage::helper('adminhtml')->getUrl("adminhtml/sales_order/");
		$this->_redirectUrl($path);
	
	}
	
 
	public function deleteInvoiceShipCreditMemoAction()
	{
			$orderId = $_REQUEST['order_id'];
			
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
			
			if ($order->hasShipments()) {
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
					$write->query("DELETE FROM `".$coreResource->getTableName('sales_flat_creditmemo')."` WHERE `order_id`=".$orderId);
					$write->query("DELETE FROM `".$coreResource->getTableName('sales_flat_creditmemo_grid')."` WHERE `order_id`=".$orderId);
					$countDeleteCreditmemo++;
				}
			}
			
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
		
		   if ($countDeleteInvoice > 0) {
				$this->_getSession()->addSuccess($this->__('%s invoice is successfully deleted.', $countDeleteInvoice));
			} 
			
			$path = Mage::helper('adminhtml')->getUrl("adminhtml/sales_order/view/order_id/".$orderId);
			$this->_redirectUrl($path);
	}
	
	public function resetItemStatusAction()
	{
		
			$orderId = $_REQUEST['order_id'];
	        $countResetInvoice = 0;
			$orderEditedBy = '';$itemStatusLogComments = '';$itemStatusLogComments = '';
			
			$logEnabled = Mage::getStoreConfig('editorder/orderlog/detail_edit_log'); 
			//$order = Mage::getModel('ordereditor/order')->load($id);
			$order = Mage::getModel('sales/order')->load($orderId);
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
				
				if($logEnabled == 1)
				{
					$itemName = $item->getName();
					
					$userName = Mage::getSingleton('admin/session')->getUser()->getUsername();
					$firstName = Mage::getSingleton('admin/session')->getUser()->getFirstname();
					$lastName = Mage::getSingleton('admin/session')->getUser()->getLastname();
					
					$orderEditedBy = '<i>'.$this->__('Order is Edited By: ').'</i>'.$firstName . ' '.$lastName .' ('.$userName .')'.' <br/>';
					$itemStatusLogComments .= '-&nbsp;'.'<b>'.$itemName.'</b>'.$this->__(' item status was reset to ') .'Ordered'.'<br/>';
				}
			}
			
			if(isset($itemStatusLogComments) && $itemStatusLogComments != "")
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

			$this->_getSession()->addSuccess($this->__('Item(s) status was successfully reset.'));
			
		}else{
		
			$this->_getSession()->addSuccess($this->__('Item(s) status is already Ordered, no need to Reset.'));		
		
		}
			$path = Mage::helper('adminhtml')->getUrl("adminhtml/sales_order/view/order_id/".$orderId);
			$this->_redirectUrl($path);
	
	}
	

	
	public function customInvoiceAction()
	{
		$field = $this->getRequest()->getParam('field');
		$invoiceId = $this->getRequest()->getParam('invoice_id');
		$value = $this->getRequest()->getPost('value');
 
		if (!empty($field) && !empty($invoiceId)) {
			$invoice = Mage::getModel('sales/order_invoice')
                    ->load($invoiceId);
			$invoiceState = $invoice->setIncrementId($value);
			$invoice->save();
			echo $value;die;
		}
	}
	
	public function saveDateAction() {

		$dateStr = $_POST['selected_date'];
		$dateArr = explode("-",$dateStr);
		$dateTimeArr = explode(" ",$dateArr[2]);
		$logEnabled = Mage::getStoreConfig('editorder/orderlog/detail_edit_log'); 
		$write = Mage::getSingleton('core/resource')->getConnection('core_write');

		//		year				month			day				time
		$dateTime = $dateTimeArr[0].'-'.$dateArr[0].'-'.$dateArr[1].' '.$dateTimeArr[1];
		//$date = $dateArr[2].'-'.$dateArr[0].'-'.$dateArr[1];
		
		//$dob = sprintf("%02d-%02d-%04d", $dateArr[1], $dateArr[0], $dateTimeArr[0]);
		//$date = Mage::app()->getLocale()->date($dob, null, null, true)->toString('yyyy-MM-dd');
		//$date = date('Y-m-d', strtotime($date . ' + 1 days'));
		//$nDate = Mage::helper('core')->formatDate($dateStr, 'short', true);
		//$nDate = Mage::getModel('core/date')->timestamp(strtotime($dateStr));
		//$nDate = date('m/d/y h:i:s', $nDate);
		//$cDate = Mage::getModel('core/date')->timestamp(strtotime($date.' +2 day'));
		
		//$cDate = Mage::getModel('core/date')->timestamp(strtotime($dateTime));
		//$fDate = date('Y-m-d h:i:s', $cDate);
		
		$orderId = $_POST['order_id'];
		if ( $orderId != "") {

			$order = Mage::getModel('sales/order')->load($orderId);
			$preCreatedDate = $order->getCreatedAt();
			$order->setCreatedAt($dateTime);

			$prefix = Mage::getConfig()->getTablePrefix();
			$gridTable = $prefix.'sales_flat_order_grid';
			$condition = "update ".$gridTable." SET `created_at` = '".$dateTime."' where entity_id = '".$orderId."'";
			$write->query($condition);
			if($logEnabled == 1)
			{										
				$userName = Mage::getSingleton('admin/session')->getUser()->getUsername();
				$firstName = Mage::getSingleton('admin/session')->getUser()->getFirstname();
				$lastName = Mage::getSingleton('admin/session')->getUser()->getLastname();

				$orderStatus = $order->getStatus();
				$orderEditedBy = '<i>'.$this->__('Order is Edited By: ').'</i>'.$firstName . ' '.$lastName .' ('.$userName .')'.' <br/>';
				$editComments = $this->__('Order Date was update from ').$preCreatedDate . $this->__('-To-').$dateTime;
				$editComments = $orderEditedBy. $editComments;				
				$order->addStatusHistoryComment($editComments, $orderStatus)
							->setIsVisibleOnFront(false)
							->setIsCustomerNotified(false);
				
			}
			
			$order->save();
 			echo 'Successfully updated.';die;
		} 
	}
	
	public function saveDeliveryDateAction() {
		$dateStr = $_POST['selected_dev_date'];
		$dateStrArr = explode("-",$dateStr);

		$dateStr = $dateStrArr[2].'-'.$dateStrArr[0].'-'.$dateStrArr[1];
		$orderId = $_POST['order_id'];
		$write = Mage::getSingleton('core/resource')->getConnection('core_write');
		$logEnabled = Mage::getStoreConfig('editorder/orderlog/detail_edit_log'); 
		
		if ( $orderId != "") {
			$order = Mage::getModel('sales/order')->load($orderId);
			$preDeliveryDate = $order->getDeliveryAt();
			$order->setDeliveryAt($dateStr);

			$prefix = Mage::getConfig()->getTablePrefix();
			$gridTable = $prefix.'sales_flat_order_grid';
			$condition = "update ".$gridTable." SET `delivery_at` = '".$dateStr."' where entity_id = '".$orderId."'";
			$write->query($condition);
			if($logEnabled == 1)
			{										
				$userName = Mage::getSingleton('admin/session')->getUser()->getUsername();
				$firstName = Mage::getSingleton('admin/session')->getUser()->getFirstname();
				$lastName = Mage::getSingleton('admin/session')->getUser()->getLastname();

				$orderStatus = $order->getStatus();
				$orderEditedBy = '<i>'.$this->__('Order is Edited By: ').'</i>'.$firstName . ' '.$lastName .' ('.$userName .')'.' <br/>';
				$editComments = $this->__('Delivery Date is update from ').$preDeliveryDate . $this->__('-To-').$dateStr;
				$editComments = $orderEditedBy. $editComments;				
				$order->addStatusHistoryComment($editComments, $orderStatus)
							->setIsVisibleOnFront(false)
							->setIsCustomerNotified(false);
				
			}
			$order->save();
 			echo 'Successfully updated.';die;
		} 
	}
	public function saveadmincommentAction()
	{
		$field = $this->getRequest()->getParam('field');
		$orderId = $this->getRequest()->getParam('order_id');
		$order = Mage::getModel('sales/order')->load($orderId);		
		$logEnabled = Mage::getStoreConfig('editorder/addlog/enabled');

		$value = $this->getRequest()->getParam('value');
		$order->setEditComments($value);
		
		$write = Mage::getSingleton('core/resource')->getConnection('core_write');
		$where = $write->quoteInto('entity_id =?', $orderId);
		$vals = array();
		$vals['is_edit'] = 1;
		$vals['edit_comments'] = 1;
		//$write->update("sales_flat_order_grid", $vals ,$where);
		
		$prefix = Mage::getConfig()->getTablePrefix();
		$gridTable = $prefix.'sales_flat_order_grid';
		$condition = "update ".$gridTable." SET `edit_comments` = '".$value."' where entity_id = '".$orderId."'";
		$write->query($condition);
		
		if($logEnabled == 1)
		{										
			$userName = Mage::getSingleton('admin/session')->getUser()->getUsername();
			$firstName = Mage::getSingleton('admin/session')->getUser()->getFirstname();
			$lastName = Mage::getSingleton('admin/session')->getUser()->getLastname();

			$orderStatus = $order->getStatus();
			$orderEditedBy = '<i>'.$this->__('Order is Edited By: ').'</i>'.$firstName . ' '.$lastName .' ('.$userName .')'.' <br/>';
			$editComments = $this->__('Special Not was updated to:- ').$value;
			$editComments = $orderEditedBy. $editComments;				
			$order->addStatusHistoryComment($editComments, $orderStatus)
						->setIsVisibleOnFront(false)
						->setIsCustomerNotified(false);
			
		}
		
		$order->save();
		echo $value;die;
	}
}