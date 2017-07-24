<?php
class Dolphin_ProductQA_IndexController extends Mage_Core_Controller_Front_Action
{
	const XML_PATH_EMAIL_RECIPIENT  = 'catalog/email/recipient_email';
	const XML_PATH_EMAIL_SENDER     = 'catalog/email/sender_email_identity';
	const XML_PATH_EMAIL_TEMPLATE   = 'catalog/email/email_template';
	const XML_PATH_ENABLED          = 'catalog/productqa/enabled';
	
	public function preDispatch()
	{
		parent::preDispatch();
	
		if( !Mage::getStoreConfigFlag(self::XML_PATH_ENABLED) ) {
			$this->norouteAction();
		}
	}
	
    public function indexAction()
    {
    	$this->loadLayout();     
		$this->renderLayout();
    }
	public function postAction()
    {
    	
        $post = $this->getRequest()->getPost();
        //print_r($post);
        if ( $post ) {
        	$model = Mage::getSingleton('productqa/productqa')->setData($post);
        }
	  try {
	        	$postObject = new Varien_Object();
	        	$postObject->setData($post);
	        
	        	$error = false;
	        
	        	if (!Zend_Validate::is(trim($post['name']) , 'NotEmpty')) {
	        		$error = true;
	        	}
	        
	        	//if (!Zend_Validate::is(trim($post['phone']) , 'NotEmpty')) {
	        	// $error = true;
	        	//}
	        
	        	if (!Zend_Validate::is(trim($post['email']), 'EmailAddress')) {
	        		$error = true;
	        	}
	        
	        	if ($error) {
	        		throw new Exception();
	        	}        
		        try {
		        	if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL) {
		        		$model->setCreatedTime(now())
		        		->setUpdateTime(now());
		        	} else {
		        		$model->setUpdateTime(now());
		        	}
					$model->save();	
					
					$mailTemplate = Mage::getModel('core/email_template');
					/* @var $mailTemplate Mage_Core_Model_Email_Template */
					$mailTemplate->setDesignConfig(array('area' => 'frontend'))
					->setReplyTo($post['email'])
					->sendTransactional(
							Mage::getStoreConfig(self::XML_PATH_EMAIL_TEMPLATE),
							Mage::getStoreConfig(self::XML_PATH_EMAIL_SENDER),
							Mage::getStoreConfig(self::XML_PATH_EMAIL_RECIPIENT),
							null,
							array('data' => $postObject)
					);
					
					if (!$mailTemplate->getSentSuccess()) {
						throw new Exception();
					}
					
					$translate->setTranslateInline(true);
					
					Mage::getSingleton('customer/session')->addSuccess(Mage::helper('productqa')->__('Your question submited Successfully'));
					$this->_redirectUrl($post['product_url']);
					return;
		        }catch (Exception $e) {
						Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
						Mage::getSingleton('adminhtml/session')->setFormData($data);
						$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
						return;
				}
		} catch (Exception $e) {
			$translate->setTranslateInline(true);
		
			Mage::getSingleton('customer/session')->addError(Mage::helper('productqa')->__('Unable to submit your request. Please, try again later').$e->getMessage());
			$this->_redirectUrl($post['product_url']);
			return;
		}
	}	
	public function viewAction()
	{
		$this->loadLayout();
		$this->renderLayout();	
	}
}