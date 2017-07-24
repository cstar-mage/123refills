<?php
require_once "Mage/Checkout/controllers/CartController.php";  
class CartController_AddCartController_Checkout_CartController extends Mage_Checkout_CartController{

    public function postDispatch()
    {
        parent::postDispatch();
        Mage::dispatchEvent('controller_action_postdispatch_adminhtml', array('controller_action' => $this));
    }
    
    
    
    /**
     * Add product to shopping cart action
     *
     * @return Mage_Core_Controller_Varien_Action
     * @throws Exception
     */
     
 
    
    
	
	public function addAction()
    {
        if (!$this->_validateFormKey()) {
            $this->_goBack();
            return;
        }
        $cart   = $this->_getCart();
        $params = $this->getRequest()->getParams();
		
		
		
		if($params['super_group'])
		{	
			
			foreach($params['super_group'] as $groupedId => $value )
			{
				 if($value >= 1)
				 {	
					 $Product=Mage::getModel('catalog/product')->load($groupedId);
					 $ProductName[]= $Product->getName();	 
				 }
			}
			
			$name = implode(' , ', $ProductName);
		}	
		 
		 if($params['isAjax'] == 1)
		 {
				try {
					if (isset($params['qty'])) {
						$filter = new Zend_Filter_LocalizedToNormalized(
							array('locale' => Mage::app()->getLocale()->getLocaleCode())
						);
						$params['qty'] = $filter->filter($params['qty']);
					}

					$product = $this->_initProduct();
					$related = $this->getRequest()->getParam('related_product');

					/**
					 * Check product availability
					 */
					if (!$product) {
						$this->_goBack();
						return;
					}

					$cart->addProduct($product, $params);
					if (!empty($related)) {
						$cart->addProductsByIds(explode(',', $related));
					}

					$cart->save();

					$this->_getSession()->setCartWasUpdated(true);

					/**
					 * @todo remove wishlist observer processAddToCart
					 */
					Mage::dispatchEvent('checkout_cart_add_product_complete',
						array('product' => $product, 'request' => $this->getRequest(), 'response' => $this->getResponse())
					);

				//	if (!$this->_getSession()->getNoCartRedirect(true)) {
						if (!$cart->getQuote()->getHasError()) {
							if($name!='')
							{
								$message = $this->__('%s was added to your shopping cart.', Mage::helper('core')->escapeHtml($name));								
							}	
							else
							{	
								$message = $this->__('%s was added to your shopping cart.', Mage::helper('core')->escapeHtml($product->getName()));
							}	
							//$this->_getSession()->addSuccess($message);
                         	 $response['status'] = 'SUCCESS';
                       		 $response['message'] = $message;
//New Code Here
							//$this->loadLayout();
							//$toplink = $this->getLayout()->getBlock('top.links')->toHtml();
							//$sidebar = $this->getLayout()->getBlock('minicart_head')->toHtml();
							//$response['toplink'] = $toplink;
							//$response['sidebar'] = $sidebar;
							//$response['countqty'] = Mage::helper('checkout/cart')->getSummaryCount();
							//$checkout=$this->getUrl('firecheckout');
							//$this->getResponse()->setRedirect($checkout);
							//$this->getResponse()->setBody(Mage::helper('core')->jsonEncode($response));
           					//echo "<pre>"; print_r($response); exit;
							Mage::getSingleton('core/session')->addSuccess($message);
							echo Mage::helper('core')->jsonEncode($response);
							return; 
						}  
						//$this->_goBack();
						
				//	} 
				} catch (Mage_Core_Exception $e) {
                $msg = "";
                if ($this->_getSession()->getUseNotice(true)) {
                    $msg = $e->getMessage();
                } else {
                    $messages = array_unique(explode("\n", $e->getMessage()));
                    foreach ($messages as $message) {
                        $msg .= $message.'<br/>';
                    }
                }
 
                $response['status'] = 'ERROR';
                $response['message'] = $msg;
            } catch (Exception $e) 
			{
                $response['status'] = 'ERROR';
                $response['message'] = $this->__('Cannot add the item to shopping cart.');
                Mage::logException($e);
            }
            
			//$this->getResponse()->setBody(Mage::helper('core')->jsonEncode($response));
			return Mage::helper('core')->jsonEncode($response); 
            return;
		 }
   


	 else{
			
			 try {
            if (isset($params['qty'])) {
                $filter = new Zend_Filter_LocalizedToNormalized(
                    array('locale' => Mage::app()->getLocale()->getLocaleCode())
                );
                $params['qty'] = $filter->filter($params['qty']);
            }

            $product = $this->_initProduct();
            $related = $this->getRequest()->getParam('related_product');

            /**
             * Check product availability
             */
            if (!$product) {
                $this->_goBack();
                return;
            }

            $cart->addProduct($product, $params);
            if (!empty($related)) {
                $cart->addProductsByIds(explode(',', $related));
            }

            $cart->save();

            $this->_getSession()->setCartWasUpdated(true);

            /**
             * @todo remove wishlist observer processAddToCart
             */
            Mage::dispatchEvent('checkout_cart_add_product_complete',
                array('product' => $product, 'request' => $this->getRequest(), 'response' => $this->getResponse())
            );

            if (!$this->_getSession()->getNoCartRedirect(true)) {
                if (!$cart->getQuote()->getHasError()) {
				    if($name != '')
					{
						$message = $this->__('%s was added to your shopping cart.', Mage::helper('core')->escapeHtml($name));
					}
					else
					{	
                    	$message = $this->__('%s was added to your shopping cart.', Mage::helper('core')->escapeHtml($product->getName()));
					}	
                    $this->_getSession()->addSuccess($message);
                }
                $this->_goBack();
            }
        } catch (Mage_Core_Exception $e) {
            if ($this->_getSession()->getUseNotice(true)) {
                $this->_getSession()->addNotice(Mage::helper('core')->escapeHtml($e->getMessage()));
            } else {
                $messages = array_unique(explode("\n", $e->getMessage()));
                foreach ($messages as $message) {
                    $this->_getSession()->addError(Mage::helper('core')->escapeHtml($message));
                }
            }

            $url = $this->_getSession()->getRedirectUrl(true);
            if ($url) {
                $this->getResponse()->setRedirect($url);
            } else {
                $this->_redirectReferer(Mage::helper('checkout/cart')->getCartUrl());
            }
        } catch (Exception $e) {
            $this->_getSession()->addException($e, $this->__('Cannot add the item to shopping cart.'));
            Mage::logException($e);
            $this->_goBack();
        }
        
        
			
		}
        
	 }


}
				
