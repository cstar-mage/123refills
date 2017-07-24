<?php
class Ideal_Customrequest_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
    	
    	/*
    	 * Load an object by id 
    	 * Request looking like:
    	 * http://site.com/customrequest?id=15 
    	 *  or
    	 * http://site.com/customrequest/id/15 	
    	 */
    	/* 
		$customrequest_id = $this->getRequest()->getParam('id');

  		if($customrequest_id != null && $customrequest_id != '')	{
			$customrequest = Mage::getModel('customrequest/customrequest')->load($customrequest_id)->getData();
		} else {
			$customrequest = null;
		}	
		*/
		
		 /*
    	 * If no param we load a the last created item
    	 */ 
    	/*
    	if($customrequest == null) {
			$resource = Mage::getSingleton('core/resource');
			$read= $resource->getConnection('core_read');
			$customrequestTable = $resource->getTableName('customrequest');
			
			$select = $read->select()
			   ->from($customrequestTable,array('customrequest_id','title','content','status'))
			   ->where('status',1)
			   ->order('created_time DESC') ;
			   
			$customrequest = $read->fetchRow($select);
		}
		Mage::register('customrequest', $customrequest);
		*/

			
		$this->loadLayout();     
		$this->renderLayout();
    }
    public function postgoldspecialorderbuygoldAction()
    {
    	$post = $this->getRequest()->getPost();
    	 
    	//echo "<pre>";
    	//print_r($post);
    	//print_r(Mage::getModel('customcontactnew/customcontactnew')->load(1));
    	 
    	if ($post) {
    
    		$translate = Mage::getSingleton('core/translate');
    		/* @var $translate Mage_Core_Model_Translate */
    		$translate->setTranslateInline(false);
    
    		 
    		 
    		try {
    			$postObject = new Varien_Object();
    			//print_r($_POST); die();
    			$postObject->setData($_POST);
    			$error = false;
    			 
    			if (!Zend_Validate::is(trim($_POST['name']) , 'NotEmpty')) {
    				$error = true;
    			}
    			/*  if (!Zend_Validate::is(trim($post['interestedin']) , 'NotEmpty')) {
    			 $error = true;
    			} */
    			 
    			if (!Zend_Validate::is(trim($_POST['phone']) , 'NotEmpty')) {
    				$error = true;
    			}
    			 
    			if (!Zend_Validate::is(trim($_POST['email']), 'EmailAddress')) {
    				$error = true;
    			}
    			 
    			if ($error) {
    				throw new Exception();
    			}
    
    			$from_email =$_POST['email'];
    			$sendername = Mage::getStoreConfig('trans_email/ident_general/name');
    			$emailTemplate = Mage::getModel('core/email_template')->loadDefault('goldcontact');
    			$locosender =  Mage::getStoreConfig("trans_email/ident_general/email");
    			$LocoName =  Mage::getStoreConfig("trans_email/ident_general/name");
    			$customerEmail= Mage::getStoreConfig('trans_email/ident_general/email');
    			$emailTemplateVariables = array();
    			$emailTemplateVariables['name'] =$_POST['name'];
    			$emailTemplateVariables['email'] =$_POST['email'];
    			$emailTemplateVariables['phone'] =$_POST['phone'];
    			$emailTemplateVariables['producttype'] =$_POST['producttype'];
    			$emailTemplateVariables['pricerange'] =$_POST['pricerange'];
    			$processedTemplate = $emailTemplate->getProcessedTemplate($emailTemplateVariables);
    			$mail = Mage::getModel('core/email')
    			->setToName("Gold Contact")
    			->setFromName($LocoName)
    			->setToEmail($customerEmail)
    			->setBody($processedTemplate)
    			->setSubject('Gold Contacts Details')
    			->setFromEmail($locosender)
    			->setType('html');
    			$mail->send();
    				
    
    			$model = Mage::getModel('customrequest/customrequest')->setData($post);
    			if(!$model->save()){
    				throw new Exception();
    			}
    			/*	if (!$mailTemplate->getSentSuccess())
    			 {
    			throw new Exception();
    			}
    
    			$translate->setTranslateInline(true);
    			Mage::getSingleton('customer/session')->addSuccess('Your Message was send Successfully');
    			$this->_redirect('special_order');
    			 
    			return; */
    			/*
    			 $success_message = Mage::getStoreConfig('contactform/general/success_message');
    			Mage::getSingleton('customer/session')->addSuccess(Mage::helper('contacts')->__('Your Message was send successfully'));
    			$this->_redirectUrl($post['curl']);
    			return;*/
    			 
    		} catch (Exception $e) {
    			$translate->setTranslateInline(true);
    			 
    			Mage::getSingleton('customer/session')->addError(Mage::helper('contacts')->__('Sorry Message could not send').$e->getMessage());
    			$this->_redirectUrl($post['curl']);
    			return;
    		}
    		$translate->setTranslateInline(true);
    		Mage::getSingleton('customer/session')->addSuccess('Your Message was send Successfully');
    		$this->_redirectUrl($post['curl']);
    		 
    		return;
    		 
    	} else {
    		$this->_redirectUrl($post['curl']);
    	}
    }
}