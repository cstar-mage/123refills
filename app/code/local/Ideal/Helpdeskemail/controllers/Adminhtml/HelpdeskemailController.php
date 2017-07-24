<?php
 
class Ideal_Helpdeskemail_Adminhtml_HelpdeskemailController extends Mage_Adminhtml_Controller_Action
{
	const XML_PATH_EMAIL_SENDER     = 'contacts/email/sender_email_identity';

	public function indexAction()
	{
		if($data = $this->getRequest()->getPost())
		{
	
			$imageUrl = NULL;
			if (isset($_FILES['filename']['name']) && $_FILES['filename']['name'] != '') {
				try {
					$uploader = new Varien_File_Uploader('filename');
					$uploader->setAllowedExtensions(array('jpg','jpeg','gif','png','pdf','xls','csv','doc'));
					$uploader->setAllowRenameFiles(false);
					$uploader->setFilesDispersion(false);
					$path = Mage::getBaseDir('media') . DS . 'helpdeskemail' . DS ;
					// $path = Mage::getBaseDir('media') . DS . 'logo' . DS;
					$logoName = $_FILES['filename']['name'];
					$uploader->save($path, $logoName);
			
					$filename1 = "media/helpdeskemail/".$_FILES['filename']['name'];
					 $NewimageName = str_replace(' ', '_', $_FILES['filename']['name']);
					$imageUrl = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA)."helpdeskemail/".$NewimageName;
					
				} catch (Exception $e) {
			
				}
			}
			
			if($imageUrl) {
				$_POST['content'] = $_POST['content'] . "\n" . $imageUrl;
			}

			$ch = curl_init();
			
			$postvars = '';
			foreach($_POST as $key=>$value) {
				$postvars .= $key . "=" . $value . "&";
			}
			
			$email = Mage::getStoreConfig('trans_email/ident_general/email');
			$storeName = Mage::getStoreConfig('general/store_information/name');
			
			$project = str_replace("www.","",$_SERVER['SERVER_NAME']); 
			
			$postvars .= 'email' . "=" . $email . "&";
			$postvars .= 'company' . "=" . $storeName . "&";
			$postvars .= 'client_project' . "=" . $project . "&";
			
			
			$url = "http://production.idealbrandmarketing.com/include/insertTicketTask.php";
			curl_setopt($ch,CURLOPT_URL,$url);
			curl_setopt($ch,CURLOPT_POST, 1);                //0 for a get request
			curl_setopt($ch,CURLOPT_POSTFIELDS,$postvars);
			curl_setopt($ch,CURLOPT_RETURNTRANSFER, true); 
			curl_setopt($ch,CURLOPT_CONNECTTIMEOUT ,3);
			curl_setopt($ch,CURLOPT_TIMEOUT, 20);
			$response = curl_exec($ch);
			
			//print "curl response is:" . $response;
			 //exit;
			curl_close ($ch);
			
			if($response == 'success') {
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('helpdeskemail')->__('Ticket created Successfully.'));
			} else {
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('helpdeskemail')->__('There is something wrong while creating ticket.'));
			}
			
			Mage::app()->getResponse()->setRedirect($_SERVER['HTTP_REFERER'])->sendResponse();
			
		}
	}
	
	public function indexOldAction()
    {
    	if($data = $this->getRequest()->getPost())
    	{
    		if (isset($_FILES['filename']['name']) && $_FILES['filename']['name'] != '') {
    			try {
    				$uploader = new Varien_File_Uploader('filename');
    				$uploader->setAllowedExtensions(array('jpg','jpeg','gif','png','pdf','xls','csv','doc'));
    				$uploader->setAllowRenameFiles(false);
    				$uploader->setFilesDispersion(false);
    				$path = Mage::getBaseDir('media') . DS . 'helpdeskemail' . DS ;
    				// $path = Mage::getBaseDir('media') . DS . 'logo' . DS;
    				$logoName = $_FILES['filename']['name'];
    				$uploader->save($path, $logoName);
    		
    			} catch (Exception $e) {
    		
    			}
    		}

    		$filename1 = "media/helpdeskemail/".$_FILES['filename']['name'];

    		$postObject = new Varien_Object();
    		$postObject->setData($_POST);

    		$mailTemplate = Mage::getModel('core/email_template');
    		
			$fileContents = file_get_contents(Mage::getBaseDir().'/'.$filename1);
			$attachment = $mailTemplate->getMail()->createAttachment($fileContents);
			$attachment->filename = $filename1;    			
    			
			$helpdeskconfig = new Mage_Core_Model_Config();
			$helpdeskconfig ->saveConfig('helpdeskemail/general/email_template', 'helpdeskemail_general_email_template', 'default', 0);
			
    		$mailTemplate->setDesignConfig(array('area' => 'frontend'));
    		$mailTemplate->setReplyTo(Mage::getStoreConfig('trans_email/ident_general/email'));
    		
    		
    		try
    		{
    			$mailTemplate->sendTransactional(
    				'helpdeskemail_general_email_template',
    				Mage::getStoreConfig(self::XML_PATH_EMAIL_SENDER),
    				'help@idealbrandmarketing.com',
    				null,
    				array(
    						'data' => $postObject,
    				)
    		);
    			//$mail->send();
    			Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('helpdeskemail')->__('Successfully to send helpdeskticket email'));
    		}
    		catch(Exception $e)
    		{
    			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('helpdeskemail')->__('Unable to send helpdeskticket email'));
    		}
    		Mage::app()->getResponse()->setRedirect($_SERVER['HTTP_REFERER'])->sendResponse();
    	}
    	else 
    	{
    		Mage::getSingleton('adminhtml/session')->addError(Mage::helper('helpdeskemail')->__('Unable to send helpdeskticket email'));
    		Mage::app()->getResponse()->setRedirect($_SERVER['HTTP_REFERER'])->sendResponse();
    	}
    	//echo "hi"; exit;
    }

    protected function _isAllowed()
    {
    	return true;
    }
    
}