<?php
class Emizen_Salesautoassign_Model_Observer
{

			public function assigncustomer(Varien_Event_Observer $observer)
			{
			
			if(!Mage::getStoreConfig('emizen/emizen/general')) // if not enable extension return false
      				 return;
				//Get Info
				$order	=	$observer->getEvent()->getOrder();
				if(!$order->getCustomerId()){
					$email = $observer->getEvent()->getOrder()->getCustomerEmail();;
					$customer = Mage::getModel("customer/customer"); 
					$customer->setWebsiteId(Mage::app()->getWebsite()->getId()); 
					$customer->loadByEmail($email);
					#Mage::log($order->getCustomerId(), null, 'product-updates.log');
					#Mage::log($customer->getId(), null, 'product-updates.log');
					//$order->setCustomerId($customer->getId());
					$order->setCustomer($customer);
					$order->save();
        		}
			}
		
}
