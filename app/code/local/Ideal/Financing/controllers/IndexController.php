<?php
class Ideal_Financing_IndexController extends Mage_Core_Controller_Front_Action
{
	const XML_PATH_EMAIL_RECIPIENT  = 'financing/email/recipient_email';
	const XML_PATH_EMAIL_SENDER     = 'financing/email/sender_email_identity';
	const XML_PATH_EMAIL_TEMPLATE   = 'financing/email/email_template';
	const XML_PATH_AUTOEMAIL_TEMPLATE   = 'financing/email/autoemail_template';
	
    public function indexAction()
    {
			
		$this->loadLayout();     
		$this->renderLayout();
    }
    
	public function saveAction() {
		if ($data = $this->getRequest()->getPost()) {	  	
					
			$model = Mage::getModel('financing/financing');		
			
			$translate = Mage::getSingleton('core/translate');
			/* @var $translate Mage_Core_Model_Translate */
			$translate->setTranslateInline(false);
			
			$postObject = new Varien_Object();
			$postObject->setData($data);
			
			$model->setData($data)
				->setId($this->getRequest()->getParam('id'));			
			try {
				if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL) {
					$model->setCreatedTime(now())
						->setUpdateTime(now());
				} else {
					$model->setUpdateTime(now());
				}		

				$mailTemplate = Mage::getModel('core/email_template');
				
				$mailTemplate->setDesignConfig(array('area' => 'frontend'))
				->setReplyTo($data['email'])
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
				
				$mailTemplate2 = Mage::getModel('core/email_template');
				/* @var $mailTemplate Mage_Core_Model_Email_Template */
				
				$mailTemplate2->setDesignConfig(array('area' => 'frontend'))
				->setReplyTo(Mage::getStoreConfig(self::XML_PATH_EMAIL_RECIPIENT))
				->sendTransactional(
						Mage::getStoreConfig(self::XML_PATH_AUTOEMAIL_TEMPLATE),
						Mage::getStoreConfig(self::XML_PATH_EMAIL_SENDER),
						$data['email'],
						//'support@idealbrandmarketing.com',
						null,
						array('data' => $postObject)
				);
				
				if (!$mailTemplate2->getSentSuccess()) {
					throw new Exception();
				}
				
				
				$translate->setTranslateInline(true);	
				
				$model->save();
				Mage::getSingleton('core/session')->addSuccess(Mage::helper('financing')->__('Item was successfully saved'));
				Mage::getSingleton('core/session')->setFormData(false);
								
				$this->_redirect('*/*/');
				return;
            } catch (Exception $e) {
                Mage::getSingleton('core/session')->addError($e->getMessage());
                Mage::getSingleton('core/session')->setFormData($data);
                $this->_redirect('*/*/');
				return;
            }
        }
        Mage::getSingleton('core/session')->addError(Mage::helper('financing')->__('Unable to find item to save'));
        $this->_redirect('*/*/');
	}
}