<?php 

require_once 'Mage/Wishlist/controllers/IndexController.php';

class Mage_Quotes_NewwishlistController extends Mage_Wishlist_IndexController
{
    public function addAction()
	{  
		$tablePrefix = (string)Mage::getConfig()->getTablePrefix();
		$write = Mage::getSingleton('core/resource')->getConnection('core_write');
		$SQL="SELECT * from `".$tablePrefix."core_config_data` WHERE path='quotes/email/recipient_email'";
		$value=$write->query($SQL);
		$row = $value->fetch();
		if(isset($row) && count($row)>0){
			$REmail = $row['value'];
		}else{
			$REmail = '';
		}
		
		 $session = Mage::getSingleton('customer/session');
		 
		 $customerData = $session->getCustomer()->getData(); 
		
		$customerAddressId = Mage::getSingleton('customer/session')->getCustomer()->getDefaultBilling();
		if ($customerAddressId){
			   $address = Mage::getModel('customer/address')->load($customerAddressId);
			   $htmlAddress = $customerData['email']."<br/>";
			   $htmlAddress .= $address->format('html');
		}else{
			  $htmlAddress = $customerData['email']."<br/>";
			  $htmlAddress .= $customerData['firstname']." ".$customerData['lastname'];
		}
		$CustomerName = $customerData['firstname']." ".$customerData['lastname'];
		$CustomerEmail = $customerData['email'];

        $wishlist = $this->_getWishlist();
        if (!$wishlist) {
            $this->_redirect('*/');
            return;
        }

        $productId = (int) $this->getRequest()->getParam('product');
        if (!$productId) {
            $this->_redirect('*/');
            return;
        }
		
        $product = Mage::getModel('catalog/product')->load($productId);
		$ProductName = $product->getName();
        if (!$product->getId() || !$product->isVisibleInCatalog()) {
            $session->addError($this->__('Cannot specify product'));
            $this->_redirect('*/');
            return;
        }

        try {
            //$wishlist->addNewItem($product->getId());
            //Mage::dispatchEvent('wishlist_add_product', array('wishlist'=>$wishlist, 'product'=>$product));

        	$requestParams = $this->getRequest()->getParams();
        	if ($session->getBeforeWishlistRequest()) {
        		$requestParams = $session->getBeforeWishlistRequest();
        		$session->unsBeforeWishlistRequest();
        	}
        	$buyRequest = new Varien_Object($requestParams);
        	
        	$result = $wishlist->addNewItem($product, $buyRequest);
        	if (is_string($result)) {
        		Mage::throwException($result);
        	}
        	$wishlist->save();
        	
        	Mage::dispatchEvent(
        			'wishlist_add_product',
        			array(
        					'wishlist' => $wishlist,
        					'product' => $product,
        					'item' => $result
        			)
        	);
        	
            if ($referer = $session->getBeforeWishlistUrl()) {
                $session->setBeforeWishlistUrl(null);
            }
            else {
                $referer = $this->_getRefererUrl();
            }
			$headers = "From:".$CustomerName."<".$CustomerEmail.">\r\n" .
				'X-Mailer: PHP/' . phpversion() . "\r\n" .
				"MIME-Version: 1.0\r\n" .
				"Content-Type: text/html; charset=utf-8\r\n" .
				"Content-Transfer-Encoding: 8bit\r\n\r\n";
				
			$subject="New Item Added to Wishlist for ".$CustomerName;
			if($product->getData('is_in_stock')==1){
				$Status='In Stock';
			}else{
				$Status='Out of Stock';
			}
			if(isset($product->_data['special_price'])){
				$SpecialPrice = Mage::helper('core')->currency($product->getData('special_price'));
			}else{
				$SpecialPrice = '---';
			}
			$baseURl=Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB);
			$HTMLNew='<div style="font:11px/1.35em Verdana, Arial, Helvetica, sans-serif;">
						  <table cellspacing="0" cellpadding="0" border="0" width="98%" style="margin-top:10px; font:11px/1.35em Verdana, Arial, Helvetica, sans-serif; margin-bottom:10px;">
							<tr>
							  <td align="center" valign="top"><table cellspacing="0" cellpadding="0" border="0" width="650">
								  <tr>
									<td valign="top"><a href="'.$baseURl.'"><img src="'.$baseURl.'skin/frontend/default/default/images/logo_email.gif" alt="'.Mage::getModel('core/website')->load(1)->getData('name').'"  style="margin-bottom:10px;" border="0"/></a></td>
								  </tr>
								</table>
								<table cellspacing="0" cellpadding="0" border="0" width="650">
								  <tr>
									<td valign="top"><p><strong style="font-size:20px;">Wishlist Notification</strong><strong>&nbsp;(Placed on '.date('F d,Y').')</strong><br/>
									  </p>
									  <table cellspacing="0" cellpadding="0" border="0" width="100%">
										<thead>
										  <tr>
											<th align="left" width="48.5%" bgcolor="#d9e5ee" style="padding:5px 9px 6px 9px; border:1px solid #bebcb7; border-bottom:none; line-height:1em;">Customer Information:</th>
											<th width="3%"></th>
											<th align="left" width="48.5%" >&nbsp;</th>
										  </tr>
										</thead>
										<tbody>
										  <tr>
											<td valign="top" style="padding:7px 9px 9px 9px; border:1px solid #bebcb7; border-top:0; background:#f8f7f5;">'.$htmlAddress.'</td>
											<td>&nbsp;</td>
											<td valign="top" >&nbsp;</td>
										  </tr>
										</tbody>
									  </table>
									  <br/>
									  <table border="0" cellspacing="0" cellpadding="0" width="100%" style="border:1px solid #bebcb7;">
										<tr bgcolor="#d9e5ee" >
										  <td width="48%" colspan="2" style="border-right:1px solid #bebcb7; border-bottom:1px solid #bebcb7; padding:5px 9px 6px 9px; line-height:1em;"><p><strong>Item</strong></p></td>
										  <td width="11%" style="border-right:1px solid #bebcb7; border-bottom:1px solid #bebcb7; padding:5px 9px 6px 9px; line-height:1em;"><p align="center"><strong>Sku</strong></p></td>
										  <td width="10%" style="border-right:1px solid #bebcb7; border-bottom:1px solid #bebcb7; padding:5px 9px 6px 9px; line-height:1em;"><p align="center"><strong>Stock</strong></p></td>
										  <td width="12%" style="border-right:1px solid #bebcb7; border-bottom:1px solid #bebcb7; padding:5px 9px 6px 9px; line-height:1em;"><p align="center"><strong>Price</strong></p></td>
										  <td width="19%" style="line-height:1em; border-bottom:1px solid #bebcb7; padding:5px 9px 6px 9px;"><p align="center"><strong>Special Price</strong></p></td>
										</tr>
										<tr>
										  <td valign="top" width="15%" style="padding:5px 9px 6px 9px;"><img src="'.$product->getImageUrl().'" style="float:left; margin-right:5px;" width="100" height="100" alt="" title="" /></td>
										  <td valign="top" width="33%" style="border-right:1px solid #bebcb7; padding:5px 9px 6px 9px;"><strong><a href="'.$baseURl.$product->getData('url_path').'">'.$ProductName.'</a></strong><br/>
										  '.$product->getData('short_description').'
										  </td>
										  <td valign="top" style="border-right:1px solid #bebcb7;"><p align="center">'.$product->getData('sku').'</p></td>
										  <td valign="top" style="border-right:1px solid #bebcb7;"><p align="center">'.$Status.'</p></td>
										  <td valign="top" style="border-right:1px solid #bebcb7;"><p align="center">'.Mage::helper('core')->currency($product->getData('price')).'</p></td>
										  <td valign="top"><p align="center">'.$SpecialPrice.'</p></td>
										</tr>
									  </table>
									  <br/>
									  <p>Thank you again,<br/>
										<strong>'.Mage::getModel('core/website')->load(1)->getData('name').'</strong></p></td>
								  </tr>
								</table></td>
							</tr>
						  </table>
						</div>';
			
			
			
			$HtmlBody='Hello Administrator<br/><br/>';
			$HtmlBody.=$CustomerName." have added ".$ProductName." to his/her wishlist.<br/><br/>";
			$HtmlBody.="Thank You\n".Mage::getModel('core/website')->load(1)->getData('name')." Team";
			
			@mail($REmail,$subject,$HTMLNew,$headers);
			
            $message = $this->__('%1$s was successfully added to your wishlist. Click <a href="%2$s">here</a> to continue shopping', $product->getName(), $referer);
			
			
            $session->addSuccess($message);
        }
        catch (Mage_Core_Exception $e) {
            $session->addError($this->__('There was an error while adding item to wishlist: %s', $e->getMessage()));
        }
        catch (Exception $e) {
            $session->addError($this->__('There was an error while adding item to wishlist.'));
        }
        $this->_redirect('*');
	}
}
