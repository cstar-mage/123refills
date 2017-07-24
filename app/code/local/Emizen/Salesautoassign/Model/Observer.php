<?php
class Emizen_Salesautoassign_Model_Observer
{

	public function assigncustomer(Varien_Event_Observer $observer)
	{
			
			if(!Mage::getStoreConfig('emizen/emizen/general')) {
      			return $this;
			}
				
			//Get Info
			$order	=	$observer->getEvent()->getOrder();
			
			if(!$order->getCustomerId()){
				$email = $observer->getEvent()->getOrder()->getCustomerEmail();;
				$customer = Mage::getModel("customer/customer"); 
				$customer->setWebsiteId(Mage::app()->getWebsite()->getId()); 
				$customer->loadByEmail($email);
				
				if($customer && !$customer->getId()) {
					
					$NewCustomer = Mage::getSingleton('checkout/session')->getQuote()->getBillingAddress()->getData();
					$websiteId = Mage::app()->getWebsite()->getId();
					$store = Mage::app()->getStore();
						
					
					$customer = Mage::getModel("customer/customer");
					$customer->website_id = $websiteId;
					$customer->setStore($store);
						
					$customer->firstname = $NewCustomer['firstname'];
					$customer->lastname = $NewCustomer['lastname'];
					$customer->email = $NewCustomer['email'];
					$customer->password_hash = md5("guest123");
					$customer->save();
						
					
					$address = Mage::getModel("customer/address");
					$address->setCustomerId($customer->getId());
					$address->firstname = $customer->firstname;
					$address->lastname = $customer->lastname;
					$address->country_id = $NewCustomer['country_id'];
					$address->region_id = $NewCustomer['region_id'];
					$address->postcode = $NewCustomer['postcode'];
					$address->city = $NewCustomer['city'];
					
					
					$address->telephone = $NewCustomer['telephone'];
					$address->fax = $NewCustomer['fax'];
					$address->company = $NewCustomer['company'];
					$address->street = $NewCustomer['street'];
						
					$address->setIsDefaultBilling('1')->setIsDefaultShipping('1')->setSaveInAddressBook('1');
					
					$address->save();
					
				}
				//echo "<pre>"; print_r($customer->getData()); exit;
				#Mage::log($order->getCustomerId(), null, 'product-updates.log');
				#Mage::log($customer->getId(), null, 'product-updates.log');
				//$order->setCustomerId($customer->getId());
				$order->setCustomer($customer);
				$order->save();
        	}
        return $this;
	}
}
