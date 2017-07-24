<?php 
class Dolphin_Customeroverride_Model_Observer
{
	
     public function customerLogin($observer) 
     {

 		    $productid = Mage::getSingleton('core/session')->getEntityid();
 		   
 		   
		 
		    $Brandid = Mage::getSingleton('core/session')->getBrandid();
			$Seriesid = Mage::getSingleton('core/session')->getSeriesid();
			$Modelid = Mage::getSingleton('core/session')->getModelid(); 
								
			
			$customer = $observer->getCustomer();
		
			$customerid = $customer->getId();
			
		/*	$customer->getResource()->saveAttribute($Brandid,'brandid');
			$customer->getResource()->saveAttribute($Seriesid,'seriesid');
			$customer->getResource()->saveAttribute($Modelid,'modelid'); */
	
			try {
				
				if($Brandid != "" && $Seriesid != "" && $Modelid != ""){
					
					$customer->setBrandid($Brandid);
					$customer->setSeriesid($Seriesid);
					$customer->setModelid($Modelid);
					$customer->save();
			
					$wishlist = Mage::getModel('wishlist/wishlist')->loadByCustomer($customerid, true);
					
					
					$product123 = Mage::getModel('catalog/product')->load($productid);
					
					
					$associatedProducts = $product123->getTypeInstance(true)->getAssociatedProducts($product123);
					$hasAssociatedProducts = count($associatedProducts) > 0;
		 
					if ($hasAssociatedProducts) {
						 
					 foreach ($associatedProducts as $_item) {
								
								$itemModel = Mage::getModel('catalog/product')->load($_item->getId());
								
								$result = $wishlist->addNewItem($itemModel);
								$wishlist->save();    
								
							}
					 }
		 
		 				
				    
					 
 
				}
				
				 
			} catch (Mage_Core_Exception $e) {
				
				echo $e->getMessage();
				exit;
				
			}

		/*	$customerData = Mage::getModel('customer/customer')->load($customer->getId())->getData();
		
			
			echo "<pre>";	
			print_r($customerData);
			exit;
			
			*/
		
		 
			 
     }
     public function customerCreate($observer) 
     {  
		  $productid = Mage::getSingleton('core/session')->getEntityid();
 		   
		 
		    $Brandid = Mage::getSingleton('core/session')->getBrandid();
			$Seriesid = Mage::getSingleton('core/session')->getSeriesid();
			$Modelid = Mage::getSingleton('core/session')->getModelid(); 
			
			$customer = $observer->getCustomer();
		
			$customerid = $customer->getId();
			
		/*	$customer->getResource()->saveAttribute($Brandid,'brandid');
			$customer->getResource()->saveAttribute($Seriesid,'seriesid');
			$customer->getResource()->saveAttribute($Modelid,'modelid'); */
	
			try {
				
				if($Brandid != "" && $Seriesid != "" && $Modelid != ""){
					
			
				$wishlist = Mage::getModel('wishlist/wishlist')->loadByCustomer($customerid, true);
					
					$product123 = Mage::getModel('catalog/product')->load($productid);
					
					$associatedProducts = $product123->getTypeInstance(true)->getAssociatedProducts($product123);
					$hasAssociatedProducts = count($associatedProducts) > 0;
		 
					if ($hasAssociatedProducts) {
						 
					 foreach ($associatedProducts as $_item) {
								
								$itemModel = Mage::getModel('catalog/product')->load($_item->getId());
								
								$result = $wishlist->addNewItem($itemModel);
								$wishlist->save();    
								
							}
					 }
		 
 
				} 
				
				 
			} catch (Mage_Core_Exception $e) {
				
				echo $e->getMessage();
				exit;
				
			}


		 
	 }

}


?>
