<?php
/**
 * Webshopapps Shipping Module
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * Shipping MatrixRates
 *
 * @category   Webshopapps
 * @package    Webshopapps_Matrixrate
 * @copyright   Copyright (c) 2013 Zowta Ltd (http://www.WebShopApps.com)
 *              Copyright, 2013, Zowta, LLC - US license
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @author     Karen Baker <sales@webshopapps.com>
*/

class Webshopapps_Matrixrate_Model_Carrier_Matrixrate
    extends Mage_Shipping_Model_Carrier_Abstract
    implements Mage_Shipping_Model_Carrier_Interface
{

    protected $_code = 'matrixrate';
    protected $_default_condition_name = 'package_weight';

    protected $_conditionNames = array();

    public function __construct()
    {
        parent::__construct();
        foreach ($this->getCode('condition_name') as $k=>$v) {
            $this->_conditionNames[] = $k;
        }
    }
    

    /**
     * Enter description here...
     *
     * @param Mage_Shipping_Model_Rate_Request $data
     * @return Mage_Shipping_Model_Rate_Result
     */
    public function collectRates(Mage_Shipping_Model_Rate_Request $request)
    {
        if (!$this->getConfigFlag('active')) {
            return false;
        }
        
        // exclude Virtual products price from Package value if pre-configured
        if (!$this->getConfigFlag('include_virtual_price') && $request->getAllItems()) {
            foreach ($request->getAllItems() as $item) {
                if ($item->getParentItem()) {
                    continue;
                }
                if ($item->getHasChildren() && $item->isShipSeparately()) {
                    foreach ($item->getChildren() as $child) {
                        if ($child->getProduct()->isVirtual() || $item->getProductType() == 'downloadable') {
                            $request->setPackageValue($request->getPackageValue() - $child->getBaseRowTotal());
                        }
                    }
                } elseif ($item->getProduct()->isVirtual() || $item->getProductType() == 'downloadable') {
                    $request->setPackageValue($request->getPackageValue() - $item->getBaseRowTotal());
                }
            }
        }
        
  		// Free shipping by qty
        $freeQty = 0;
        if ($request->getAllItems()) {
            foreach ($request->getAllItems() as $item) {
                if ($item->getProduct()->isVirtual() || $item->getParentItem()) {
                    continue;
                }

                if ($item->getHasChildren() && $item->isShipSeparately()) {
                    foreach ($item->getChildren() as $child) {
                        if ($child->getFreeShipping() && !$child->getProduct()->isVirtual()) {
                            $freeQty += $item->getQty() * ($child->getQty() - (is_numeric($child->getFreeShipping()) ? $child->getFreeShipping() : 0));
                        }
                    }
                } elseif ($item->getFreeShipping()) {
                    $freeQty += ($item->getQty() - (is_numeric($item->getFreeShipping()) ? $item->getFreeShipping() : 0));
                }
            }
        }

        /* custom code added */
        $destCountry = $request->getDestCountryId();
        $international = false;
        if($destCountry != 'US') $international = true;
        
        $totalWeight = 0;
        $totalSellPrice = 0;
        $oemFlag = false;
        foreach ($request->getAllItems() as $item) {
        	$totalWeight = $totalWeight + ($item->getWeight()*$item->getQty());
        	$totalSellPrice = $totalSellPrice + ($item->getPrice()*$item->getQty());
        	//echo $item->getSku()."--price: ".$item->getPrice()."--weight: ".$item->getWeight()."-- qty: ".$item->getQty()."<br>";
        	
        	if( strpos(strtolower($item->getName()), 'oem') !== false ) {
        		$oemFlag = true;
        	}
        }
        //exit;
        //echo "Total weight: ". $totalWeight . " Total price: " . $totalSellPrice; //exit;
        
        $heavyItemFlag = false;
        if($international == false) {
        	//Find Heavy Item USA
        	//Heavy Item USA Formula	(sell price / weight) < 6	Charge $1 per pound
        	if(($totalSellPrice/$totalWeight) < 6) {
        		$heavyItemFlag = true;
        	}
        } else {
        	//Find Heavy Item INTERNATIONAL
        	//Heavy Item INT Formula	(sell price / weight) < 10	Charge $2 per pound
        	if(($totalSellPrice/$totalWeight) < 10) {
        		$heavyItemFlag = true;
        	}
        }
        
        //echo "heavy: " . $heavyItemFlag; exit;
        
        //$subTotal = Mage::helper('checkout/cart')->getQuote()->getSubtotal();
        $oemFee = 0;
        if($oemFlag == true && $totalSellPrice < 50) {
        	//Small OEM Order Fee	Orders with OEM items less than $50	Charge $4.95
        	$oemFee = '4.95';
        }
        //echo $oemFee; exit;
        //echo $totalSellPrice. " == " . $totalWeight . "==" . $totalSellPrice/$totalWeight . " == ".$oemFee;

        /* custom code finished */
        
        if (!$request->getMRConditionName()) {
            $request->setMRConditionName($this->getConfigData('condition_name') ? $this->getConfigData('condition_name') : $this->_default_condition_name);
        }

         // Package weight and qty free shipping
        $oldWeight = $request->getPackageWeight();
        $oldQty = $request->getPackageQty();

		if ($this->getConfigData('allow_free_shipping_promotions') && !$this->getConfigData('include_free_ship_items')) {
			$request->setPackageWeight($request->getFreeMethodWeight());
			$request->setPackageQty($oldQty - $freeQty);
		}
        
        $result = Mage::getModel('shipping/rate_result');
     	$ratearray = $this->getRate($request);
     	
     	$request->setPackageWeight($oldWeight);
        $request->setPackageQty($oldQty);

        // we are not using default free shipping option. custom code added below
     	/*$freeShipping=false;
     	 if (is_numeric($this->getConfigData('free_shipping_threshold')) && 
	        $this->getConfigData('free_shipping_threshold')>0 &&
	        $request->getPackageValue()>$this->getConfigData('free_shipping_threshold')) {
	         	$freeShipping=true;
	    }
    	if ($this->getConfigData('allow_free_shipping_promotions') &&
	        ($request->getFreeShipping() === true || 
	        $request->getPackageQty() == $this->getFreeBoxes()))
        {
         	$freeShipping=true;
        }
        
        if ($freeShipping)
        {
		  	$method = Mage::getModel('shipping/rate_result_method');
			$method->setCarrier('matrixrate');
			$method->setCarrierTitle($this->getConfigData('title'));
			$method->setMethod('matrixrate_free');
			$method->setPrice('0.00');
			$method->setMethodTitle($this->getConfigData('free_method_text'));
			$result->append($method);
			
			if ($this->getConfigData('show_only_free')) {
				return $result;
			}
		} */
     	
     	//Free Shipping is only shown twice? those are the only 2 shipping options that are based on price
     	//price only matters for the 2 lone free shipping options. //everything else is weight.
     	//Heavy formula now is only to determine free shipping or not
     	//B. IF totalSellPrice$totalWeight < 6 THEN NO FREE SHIPPING OPTION = $heavyItemFlag
     	// free shipping only over $50 and item is not heavy and not OEM
        
        $freeShipping=false; 
     	$currentMethods = array();
     	if($heavyItemFlag == false && $oemFlag == false) {
     		//package_value added for non heavy items to allow free shipping over $50 - default free shipping not used.
     		if($destCountry == 'US' && $totalSellPrice > 49) {
     			//USA Economy Ground (2-5 Days) $0 over $49.00 ship code USA
     			
     			$method = Mage::getModel('shipping/rate_result_method');
     			$method->setCarrier('matrixrate');
     			$method->setCarrierTitle($this->getConfigData('title'));
     			$method->setMethod('usa');
     			$method->setPrice('0.00');
     			$method->setMethodTitle("USA Economy Ground (2-5 Days)");
     			$result->append($method);
     			
     			$currentMethods[] = "USA Economy Ground (2-5 Days)";
     			
     			//http://production.idealbrandmarketing.com/task_detail.php?ti=14376 //if Free Shipping is an option, only show that shipping option.
     			$freeShipping=true;
     			if ($this->getConfigData('show_only_free')) {
     				return $result;
     			}
     		}
     		
     		if($destCountry == 'CA' && $totalSellPrice > 60) {
     			//Canada and Mexico (Economy, 7-14 Days) $0 over $60.00 ship code CM1
     			
     			$method = Mage::getModel('shipping/rate_result_method');
     			$method->setCarrier('matrixrate');
     			$method->setCarrierTitle($this->getConfigData('title'));
     			$method->setMethod('cm1');
     			$method->setPrice('0.00');
     			$method->setMethodTitle("Canada and Mexico (Economy, 7-14 Days)");
     			$result->append($method);
     			
     			$currentMethods[] = "Canada and Mexico (Economy, 7-14 Days)";
     			
     			//http://production.idealbrandmarketing.com/task_detail.php?ti=14376 //if Free Shipping is an option, only show that shipping option.
     			$freeShipping=true;
     			if ($this->getConfigData('show_only_free')) {
     				return $result;
     			}
     		}
     	}
     	
	   foreach ($ratearray as $rate)
		{
		   if (!empty($rate) && $rate['price'] >= 0) {
		   		
			   	if(in_array($rate['delivery_type'],$currentMethods)) {
			   		//to avoid repeat methods with same name mostly when free shipping available
			   		continue;
			   	}
		   		
			  	$method = Mage::getModel('shipping/rate_result_method');
				$method->setCarrierTitle($this->getConfigData('title'));
				//$method->setCarrier('matrixrate');
				//$method->setMethod('matrixrate_'.$rate['pk']);
				$method->setCarrier('matrixrate');
				$method->setMethod(strtolower($rate['ship_code']));

				//$method->setMethodTitle(Mage::helper('matrixrate')->__($rate['delivery_type']."==".$rate['condition_name']."==".$rate['price']."==".$rate['per_lb_cost']));
				$method->setMethodTitle(Mage::helper('matrixrate')->__($rate['delivery_type']));
				
				$method->setDeliveryType($rate['delivery_type']);
				
				/* if($rate['condition_type'] == 'per_lb' && ($totalWeight < 50 || $heavyItemFlag == false)) {
					//everything thats per_lb is the price per lb for when a product meets heavy formula.theyre not needed in the example I sent you because the product isnt "heavy"
					//so its not heavy then use fixed instead "per_lb", it needs to calculate per lb only when heavy item formulae matched.
					// ignore per_lb rows when item is not heavy
					continue;
				} */
				//client changed his mind and now heavy item is only consider to hide free shipping.
				//$$/lb only applies to weight after 50lb limit if any product in cart is >50lb
				//(not if product meets heavy formula. Heavy formula now is only to determine free shipping or not)
				//http://production.idealbrandmarketing.com/task_detail.php?ti=13506
				
				if($totalWeight > 50) { // for per_lb conditions for weight
					
					/* A. Example 1 - 61lb product  (total weight - 50) * $$per_lb
										(61 - 50) x $1 (US Postal Service) 11 x $1 = $11 for products/orders >50lb 
					US Postal Service (2-5 Days) = $34.95 + $11.00 = $45.95
					fixed + per_lb for products/orders >50lb */
					
					$perLbCost = $rate['price'] + (($totalWeight - 50) * $rate['per_lb_cost']);
					
					$shippingPrice = $this->getFinalPriceWithHandlingFee($perLbCost);
					$method->setCost($perLbCost);
					
				} else {
					$shippingPrice = $this->getFinalPriceWithHandlingFee($rate['price']);
					$method->setCost($rate['cost']);
				}
				
				//Small OEM Order Fee Orders with OEM items less than $50 Charge $4.95
				$finalPrice = $shippingPrice+$oemFee;
				$finalPrice = number_format($finalPrice, 2, '.', '');
				$method->setPrice($finalPrice);

				$result->append($method);
				
				$currentMethods[] = $rate['delivery_type'];
			}
		}

        return $result;
    }

    public function getRate(Mage_Shipping_Model_Rate_Request $request)
    {
        return Mage::getResourceModel('matrixrate_shipping/carrier_matrixrate')->getNewRate($request,$this->getConfigFlag('zip_range'));
    }
    
    /**
     * Get allowed shipping methods
     *
     * @return array
     */
    public function getAllowedMethods()
    {
        return array('matrixrate'=>$this->getConfigData('name'));
    }
    

    public function getCode($type, $code='')
    {
        $codes = array(

            'condition_name'=>array(
                'package_weight' => Mage::helper('shipping')->__('Weight vs. Destination'),
                'package_value'  => Mage::helper('shipping')->__('Price vs. Destination'),
                'package_qty'    => Mage::helper('shipping')->__('# of Items vs. Destination'),
            ),

            'condition_name_short'=>array(
                'package_weight' => Mage::helper('shipping')->__('Weight'),
                'package_value'  => Mage::helper('shipping')->__('Order Subtotal'),
                'package_qty'    => Mage::helper('shipping')->__('# of Items'),
            ),

        );

        if (!isset($codes[$type])) {
            throw Mage::exception('Mage_Shipping', Mage::helper('shipping')->__('Invalid Matrix Rate code type: %s', $type));
        }

        if (''===$code) {
            return $codes[$type];
        }

        if (!isset($codes[$type][$code])) {
            throw Mage::exception('Mage_Shipping', Mage::helper('shipping')->__('Invalid Matrix Rate code for type %s: %s', $type, $code));
        }

        return $codes[$type][$code];
    }



}