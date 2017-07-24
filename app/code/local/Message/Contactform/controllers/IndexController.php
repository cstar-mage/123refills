<?php
/**
 * Custom
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * @category   Custom
 * @package    Message_Contactform
 * @author     Custom Development Team
 * @copyright  Copyright (c) 2013 Custom. (http://www.magerevol.com)
 * @license    http://opensource.org/licenses/osl-3.0.php
 */

require_once 'Mage/Contacts/controllers/IndexController.php';
class Message_Contactform_IndexController extends Mage_Contacts_IndexController
{
 
	const XML_PATH_EMAIL_RECIPIENT  = 'contacts/email/recipient_email';
	const XML_PATH_EMAIL_SENDER     = 'contacts/email/sender_email_identity';
	const XML_PATH_EMAIL_TEMPLATE_ADMIN   = 'contacts/contactform/email_template_admin';
	const XML_PATH_EMAIL_TEMPLATE_USER   = 'contacts/contactform/email_template_user';
	
	private function rpHash($value) {
		$hash = 5381;
		$value = strtoupper($value);
		for($i = 0; $i < strlen($value); $i++) {
			$hash = ($this->leftShift32($hash, 5) + $hash) + ord(substr($value, $i));
		}
		return $hash;
	}
	// Perform a 32bit left shift
	private function leftShift32($number, $steps) {
		// convert to binary (string)
		$binary = decbin($number);
		// left-pad with 0's if necessary
		$binary = str_pad($binary, 32, "0", STR_PAD_LEFT);
		// left shift manually
		$binary = $binary.str_repeat("0", $steps);
		// get the last 32 bits
		$binary = substr($binary, strlen($binary) - 32);
		// if it's a positive number return it
		// otherwise return the 2's complement
		return ($binary{0} == "0" ? bindec($binary) :
		-(pow(2, 31) - bindec(substr($binary, 1))));
	}
		
 	public function postAction()
    {
    	if(!Mage::getStoreConfig('contacts/contactform/enable_contactform')) {
    		return parent::postAction();
    	}
    	
		if(Mage::getStoreConfig('evolved/contacts_custom_captcha/enable')==1)
		{
			if($captch=$_POST['defaultReal']){
				if ($this->rpHash($_POST['defaultReal']) != $_POST['defaultRealHash']) {
					Mage::getSingleton('core/session')->addError(Mage::helper('contactform')->__('The security code entered was incorrect. Please try again!'));
					//$this->_redirect('*/');
					$this->_redirectReferer();
					return;
				}
			}	
		}
    	
        if ($post = $this->getRequest()->getPost()) {
			
		
		
		
        	
	        	$translate = Mage::getSingleton('core/translate');
	        	/* @var $translate Mage_Core_Model_Translate */
	        	$translate->setTranslateInline(false);
        	
	        	try {
	        		
	        		if($post['name'] == '' && $post['cname'] != "") {
	        			$post['name'] = $post['cname'];
	        		}
	        		
	        		if($post['cname'] == '' && $post['name'] != "") {
	        			$post['cname'] = $post['name'];
	        		}
	        		
	        		$postObject = new Varien_Object();
	        		$postObject->setData($post);
	        		
	        		$error = false;	
	        		
	        		if (!Zend_Validate::is(trim($post['name']) , 'NotEmpty')) {
	        			$error = true;
	        		}
	        		
	        		if (!Zend_Validate::is(trim($post['message']) , 'NotEmpty')) {
	        			$error = true;
	        		}
	        		
	        		if (!Zend_Validate::is(trim($post['email']), 'EmailAddress')) {
	        			$error = true;
	        		}
	        		
	        		
	        		/* if ($error) { 
	        			throw new Exception();
	        		} */
	        		
	               	$model = Mage::getModel('contactform/contactform');		
				    $model->setData($post);
					
					//echo "<pre>"; print_r($post); exit;
            	
                    $model->setCreatedTime(now());
					$model->setTelephone("".$post['telephone']."");
					$model->save();
					
					
					
					$mailTemplate = Mage::getModel('core/email_template');
					
					//admin email
					/* @var $mailTemplate Mage_Core_Model_Email_Template */
					$mailTemplate->setDesignConfig(array('area' => 'frontend'))
								->setReplyTo($post['email'])
								->sendTransactional(
										Mage::getStoreConfig(self::XML_PATH_EMAIL_TEMPLATE_ADMIN),
										Mage::getStoreConfig(self::XML_PATH_EMAIL_SENDER),
										Mage::getStoreConfig(self::XML_PATH_EMAIL_RECIPIENT),
										null,
										array('data' => $postObject)
								);
					
					if (!$mailTemplate->getSentSuccess()) {
						throw new Exception();
					}
					
					// user email
					$mailTemplate2 = Mage::getModel('core/email_template');
					$mailTemplate2->setDesignConfig(array('area' => 'frontend'))
								->setReplyTo(Mage::getStoreConfig(self::XML_PATH_EMAIL_RECIPIENT))
								->sendTransactional(
										Mage::getStoreConfig(self::XML_PATH_EMAIL_TEMPLATE_USER),
										Mage::getStoreConfig(self::XML_PATH_EMAIL_SENDER),
										$post['email'],
										null,
										array('data' => $postObject)
								);
					
					
					if (!$mailTemplate2->getSentSuccess()) {
						throw new Exception();
					}
					
					
					
					
			
					
					
					
					
				
					$translate->setTranslateInline(true);
			
					//echo "success"; exit;
					
					$success_message = Mage::getStoreConfig('contacts/contactform/success_message');
					Mage::getSingleton('customer/session')->addSuccess(Mage::helper('contactform')->__($success_message));
					$this->_redirectReferer();
					return;
					
                } catch (Exception $e) {
                	
                	//echo "Error: ".$e->getMessage(); exit;
                	
                	$translate->setTranslateInline(true);
                	
                	$failure_message = Mage::getStoreConfig('contacts/contactform/error_message');
                   	Mage::getSingleton('customer/session')->addError(Mage::helper('contactform')->__($failure_message));
       				 $this->_redirectReferer();
       				 return;
                } 
 
        }

	    Mage::getSingleton('customer/session')->addError(Mage::helper('contactform')->__('Unable to find data.'));
	    $this->_redirectReferer();
    }    
}
