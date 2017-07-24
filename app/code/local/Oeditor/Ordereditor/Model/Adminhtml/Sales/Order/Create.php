<?php
class Oeditor_Ordereditor_Model_Adminhtml_Sales_Order_Create extends Mage_Adminhtml_Model_Sales_Order_Create
{
    /**
     * Parse data retrieved from request
     *
     * @param   array $data
     * @return  Mage_Adminhtml_Model_Sales_Order_Create
     */
    public function importPostData($data)
    {
        if (is_array($data)) {
            $this->addData($data);
        } else {
            return $this;
        }

        if (isset($data['account'])) {
            $this->setAccountData($data['account']);
        }

        if (isset($data['comment'])) {
            $this->getQuote()->addData($data['comment']);
            if (empty($data['comment']['customer_note_notify'])) {
                $this->getQuote()->setCustomerNoteNotify(false);
            } else {
                $this->getQuote()->setCustomerNoteNotify(true);
            }
        }

        if (isset($data['billing_address'])) {
            $this->setBillingAddress($data['billing_address']);
        }

        if (isset($data['shipping_address'])) {
            $this->setShippingAddress($data['shipping_address']);
        }

        if (isset($data['shipping_method'])) {
            $this->setShippingMethod($data['shipping_method']);
        }

        if (isset($data['payment_method'])) {
            $this->setPaymentMethod($data['payment_method']);
        }
        
        $reinit_rates = false;
        
        if (isset($data['shipping_amount'])) {            	
            $shippingPrice = $this->_parseShippingPrice($data['shipping_amount']);
            //$this->getQuote()->getShippingAddress()->setShippingAmount($shippingPrice);
        	Mage::getSingleton('core/session')->setCustomshippriceAmount($shippingPrice);
        	$reinit_rates = true;
        }

        if (isset($data['base_shipping_amount'])) {
            $baseShippingPrice = $this->_parseShippingPrice($data['base_shipping_amount']);
            //$this->getQuote()->getShippingAddress()->setBaseShippingAmount($baseShippingPrice, true);
        	Mage::getSingleton('core/session')->setCustomshippriceBaseAmount($baseShippingPrice);
        	$reinit_rates = true;
        }

        if (isset($data['shipping_description'])) {
            //$this->getQuote()->getShippingAddress()->setShippingDescription($data['shipping_description']);
        	Mage::getSingleton('core/session')->setCustomshippriceDescription($data['shipping_description']);
        	$reinit_rates = true;
        }

        if (isset($data['coupon']['code'])) {
            $this->applyCoupon($data['coupon']['code']);
            $reinit_rates = true;
        }
        
        if($reinit_rates)
        {
        	//$this->collectShippingRates();
        	//$this->getQuote()->getShippingAddress()->setCollectShippingRates(true);
        	//$this->collectRates();
        	//$this->getQuote()->collectTotals();
        }
        
        return $this;
    }

    protected function _parseShippingPrice($price)
    {
        $price = Mage::app()->getLocale()->getNumber($price);
        $price = $price>0 ? $price : 0;
        return $price;
    }
	
	    /**
     * Initialize creation data from existing order Item
     *
     * @param Mage_Sales_Model_Order_Item $orderItem
     * @param int $qty
     * @return Mage_Sales_Model_Quote_Item | string
     */
    public function initFromOrderItem(Mage_Sales_Model_Order_Item $orderItem, $qty = null)
    {
        if (!$orderItem->getId()) {
            return $this;
        }

        $product = Mage::getModel('catalog/product')
            ->setStoreId($this->getSession()->getStoreId())
            ->load($orderItem->getProductId());

        if ($product->getId()) {
            $product->setSkipCheckRequiredOption(true);
            $buyRequest = $orderItem->getBuyRequest();
            if (is_numeric($qty)) {
                $buyRequest->setQty($qty);
            }
            $item = $this->getQuote()->addProduct($product, $buyRequest);
            if (is_string($item)) {
                return $item;
            }
/*********************************************Set custom price selected starts************************************************************/
if ( !$this->getSession()->getReordered()  && $orderItem->getOriginalPrice() != $orderItem->getPrice() ) 
{
    if ($orderItem->getProductType()=='configurable'  || $orderItem->getProductType()=='bundle') {
            $productId = $orderItem->getProductId();   
			
				 $quoteItemId = $orderItem->getQuoteItemId();
				 $items = $this->getQuote()->getItemsCollection();
 				  foreach($items as $item) {
 					if ($item->getProduct()->getId()==$productId && !$item->getApplyPriceFlag()) {
					
						if ($orderItem->getOriginalPrice() != $orderItem->getPrice()) {
							$item->setCustomPrice($orderItem->getPrice())->setOriginalCustomPrice($orderItem->getPrice());
						}                    
							//$item->setApplyPriceFlag(true);
					}
				}
         }
	else
	{
 	  	$item->setCustomPrice($orderItem->getPrice())->setOriginalCustomPrice($orderItem->getPrice());
	}
}
/*********************************************Set custom price selected ends************************************************************/

            if ($additionalOptions = $orderItem->getProductOptionByCode('additional_options')) {
                $item->addOption(new Varien_Object(
                    array(
                        'product' => $item->getProduct(),
                        'code' => 'additional_options',
                        'value' => serialize($additionalOptions)
                    )
                ));
            }
            Mage::dispatchEvent('sales_convert_order_item_to_quote_item', array(
                'order_item' => $orderItem,
                'quote_item' => $item
            ));
            return $item;
        }
        return $this;
    }

}
