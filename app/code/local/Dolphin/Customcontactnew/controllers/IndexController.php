<?php
class Dolphin_Customcontactnew_IndexController extends Mage_Core_Controller_Front_Action
{
	const XML_PATH_EMAIL_RECIPIENT  = 'customcontactnew/email/recipient_email';
	const XML_PATH_EMAIL_SENDER     = 'customcontactnew/email/sender_email_identity';
	const XML_PATH_EMAIL_TEMPLATE   = 'customcontactnew/email/email_template';
	const XML_PATH_AUTOEMAIL_TEMPLATE   = 'customcontactnew/email/autoemail_template';
	const XML_PATH_ENABLED          = 'customcontactnew/contacts/enabled';	
	
	
	
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
		//$this->getLayout()->getBlock('customcontactnew')->setFormAction( Mage::getUrl('*/*/post') );
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
			
			$interestedindata = $_POST['interestedin'];
			//echo '<pre>'; print_r($stone);
			$interestedin = implode(',',$interestedindata);
			//exit;
			$_POST['interestedin'] = $interestedin;
			
			$contactpreference1 = $_POST['contactpreference'];
			$contactpreference = implode(',',$contactpreference1);
			$_POST['contactpreference'] = $contactpreference;
			$post['contactpreference'] = $contactpreference;
			$post['interestedin'] = $interestedin;
			$date = date('Y-m-d H:i:s');
		    $post['created_time']= $date;
			//echo "<pre>";
			//print_r($post);
			//exit;
			
			$translate = Mage::getSingleton('core/translate');
            /* @var $translate Mage_Core_Model_Translate */
            $translate->setTranslateInline(false);
            
            try {
                $postObject = new Varien_Object();
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
               /*  if (!Zend_Validate::is(trim($post['appointmentdate']), 'NotEmpty')) {
                	$error = true;
                }
                if (!Zend_Validate::is(trim($post['appointmenttime']), 'NotEmpty')) {
                	$error = true;
                }
                if (!Zend_Validate::is(trim($post['contactpreference']), 'NotEmpty')) {
                	$error = true;
                } */
                

                if ($error) {
                    throw new Exception();
                }
				$mailTemplate = Mage::getModel('core/email_template');
                $mailTemplate->setDesignConfig(array('area' => 'frontend'))
                    ->setReplyTo($_POST['email'])
					->sendTransactional( 
							Mage::getStoreConfig(self::XML_PATH_EMAIL_TEMPLATE),
							Mage::getStoreConfig(self::XML_PATH_EMAIL_SENDER),
						   Mage::getStoreConfig(self::XML_PATH_EMAIL_RECIPIENT),
							null,
                        array('data' => $postObject)
                    );
					 
				$mailTemplate->setDesignConfig(array('area' => 'frontend'))
                    ->setReplyTo(Mage::getStoreConfig(self::XML_PATH_EMAIL_RECIPIENT))
                    ->sendTransactional(
                        Mage::getStoreConfig(self::XML_PATH_EMAIL_TEMPLATE),
                        Mage::getStoreConfig(self::XML_PATH_EMAIL_SENDER),
                        $_POST['email'],
                        null,
                        array('data' => $postObject)
                    );
                
				$date_arr = explode("-",$post['appointmentdate']);
				$appointmentdate = $date_arr[2]."-".$date_arr[0]."-".$date_arr[1];
				$post['appointmentdate'] = $appointmentdate; 
				

                $model = Mage::getSingleton('customcontactnew/customcontactnew')->setData($post);
                if(!$model->save()){
                	throw new Exception();
                }
                if (!$mailTemplate->getSentSuccess()) {
                    throw new Exception();
                }

                $translate->setTranslateInline(true);
               
                //Mage::getSingleton('customer/session')->addSuccess(Mage::helper('contacts')->__('Your Message was send Successfully'));
                Mage::getSingleton('core/session')->addSuccess(Mage::helper('contacts')->__('Message was successfully sent'));
				$this->_redirectUrl($post['curl']);

                return;
            } catch (Exception $e) {
                $translate->setTranslateInline(true);

                Mage::getSingleton('customer/session')->addError(Mage::helper('contacts')->__('Sorry Message could not send').$e->getMessage());
                $this->_redirectUrl($post['curl']);
                return;
            }

        } else {
            $this->_redirectUrl($post['curl']);
        }
    }
    
}
