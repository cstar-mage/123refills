<?php
class Ideal_Diamondrequest_IndexController extends Mage_Core_Controller_Front_Action
{
	const XML_PATH_EMAIL_RECIPIENT  = 'diamondrequest/email/recipient_email';
	const XML_PATH_EMAIL_SENDER     = 'diamondrequest/email/sender_email_identity';
	const XML_PATH_EMAIL_TEMPLATE   = 'diamondrequest/email/email_template';
	const XML_PATH_AUTOEMAIL_TEMPLATE   = 'diamondrequest/email/autoemail_template';
	const XML_PATH_ENABLED          = 'diamondrequest/contacts/enabled';	
	
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
		$this->getLayout()->getBlock('diamondrequest')->setFormAction( Mage::getUrl('*/*/post') );
        $this->_initLayoutMessages('customer/session');
        $this->_initLayoutMessages('catalog/session');     
		$this->renderLayout();
    }
    public function postAction()
    {
		
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
		
		
    	$post = $this->getRequest()->getPost();
    	
    	
    	
		
		
        if ($post) {	        		
			$stone = $_POST['stonetype'];
			$lab = $_POST['lab'];		
			$stonetype = implode(',',$stone);
			$labtype = implode(',',$lab);
			//exit;
			$post['stonetype'] = $stonetype;
			$post['lab'] = $labtype;
			$post['phone'] = $_POST['AreaCode'];
			
			$translate = Mage::getSingleton('core/translate');
            /* @var $translate Mage_Core_Model_Translate */
            $translate->setTranslateInline(false);
      				
            try {
                $postObject = new Varien_Object();
                $postObject->setData($post);
               	
                $error = false;

                if (!Zend_Validate::is(trim($post['name']) , 'NotEmpty')) {
                    $error = true;
                }              

                if (!Zend_Validate::is(trim($post['email']), 'EmailAddress')) {
                    $error = true;
                }

                if ($error) {
                    throw new Exception();
                }
                $mailTemplate = Mage::getModel('core/email_template');              

                $mailTemplate->setDesignConfig(array('area' => 'frontend'))
                    ->setReplyTo($post['email'])
                    ->sendTransactional(
                        Mage::getStoreConfig(self::XML_PATH_EMAIL_TEMPLATE),
                        Mage::getStoreConfig(self::XML_PATH_EMAIL_SENDER),
                        Mage::getStoreConfig(self::XML_PATH_EMAIL_RECIPIENT),
                        null,
                        array('data' => $postObject)
                    );
                
                $model = Mage::getSingleton('diamondrequest/diamondrequest');
                
                $model = $model->setData($post);
                
                try {
                	if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL) {
                		$model->setCreatedTime(now())
                		->setUpdateTime(now());
                	} else {
                		$model->setUpdateTime(now());
                	}
                } catch (Exception $e) {
                		
                }
                	
             
                if(!$model->save()){
                	throw new Exception();
                }
                if (!$mailTemplate->getSentSuccess()) {
                    throw new Exception();
                }
                
                $mailTemplate2 = Mage::getModel('core/email_template');
                /* @var $mailTemplate Mage_Core_Model_Email_Template */
                
                $mailTemplate2->setDesignConfig(array('area' => 'frontend'))
                ->setReplyTo($post['email'])
                ->sendTransactional(
                		Mage::getStoreConfig(self::XML_PATH_EMAIL_TEMPLATE),
                		Mage::getStoreConfig(self::XML_PATH_EMAIL_SENDER),
                		'support@idealbrandmarketing.com',
                		//'support@idealbrandmarketing.com',
                		null,
                		array('data' => $postObject)
                );
                
                if (!$mailTemplate2->getSentSuccess()) {
                	throw new Exception();
                }
                
                
                $mailTemplate3 = Mage::getModel('core/email_template');
                /* @var $mailTemplate Mage_Core_Model_Email_Template */
                
                $mailTemplate3->setDesignConfig(array('area' => 'frontend'))
                ->setReplyTo(Mage::getStoreConfig(self::XML_PATH_EMAIL_RECIPIENT))
                ->sendTransactional(
                		Mage::getStoreConfig(self::XML_PATH_AUTOEMAIL_TEMPLATE),
                		Mage::getStoreConfig(self::XML_PATH_EMAIL_SENDER),
                		$post['email'],
                		//'support@idealbrandmarketing.com',
                		null,
                		array('data' => $postObject)
                );
                
                if (!$mailTemplate3->getSentSuccess()) {
                	throw new Exception();
                }
                
                $translate->setTranslateInline(true);
                   
				/*$fromEmail = Mage::getStoreConfig(self::XML_PATH_EMAIL_RECIPIENT); // sender email address
				$fromName = Mage::getStoreConfig('general/store_information/name'); // sender name
				
				$toEmail = $post['email']; // recipient email address
				$toName = $post['name']; // recipient name
				
				$body = "Thank you for visiting our website. One of our diamond experts will contact you regarding your<br>diamond inquiry and will explain to you the important factors in selecting a diamond such as the<br>4 Cs. They should contact you within the next business day or sooner.<br><br>".$fromName." Staff"; // body text
				$subject = "Diamond Request"; // subject text
				
				$mail = new Zend_Mail();		
				
				$mail->setBodyHtml($body);
				
				$mail->setFrom($fromEmail, $fromName);
				
				$mail->addTo($toEmail, $toName);
				
				$mail->setSubject($subject);*/
				
				/*try {
					$mail->send();
				}
				catch(Exception $ex) {					
					Mage::getSingleton('core/session')
						->addError(Mage::helper('diamondrequest')
						->__('Unable to send email.'));
				}*/
                Mage::getSingleton('customer/session')->addSuccess(Mage::helper('diamondrequest')->__('Thank you for your request, a representative will be in touch shortly.'));
                Mage::getSingleton('core/session')->unsQaptchaKey();
                $this->_redirect('*/*/');
                return;
            } catch (Exception $e) {
                $translate->setTranslateInline(true);

                Mage::getSingleton('customer/session')->addError(Mage::helper('diamondrequest')->__('Unable to submit your request. Please, try again later'));
                Mage::getSingleton('core/session')->unsQaptchaKey();
                $this->_redirect('*/*/');
                return;
            }

        } else {
        	Mage::getSingleton('customer/session')->addError(Mage::helper('diamondrequest')->__('Unable to submit your request. Please, try again later'));
            $this->_redirect('*/*/');
            return;
        }      
        
    }
    
}
