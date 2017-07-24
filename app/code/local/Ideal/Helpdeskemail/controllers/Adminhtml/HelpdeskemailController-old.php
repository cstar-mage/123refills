<?php
 
class Ideal_Helpdeskemail_Adminhtml_HelpdeskemailController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
    	$mail = new Zend_Mail();
    	$mail->setBodyText('This is the text of the mail.');
    	$mail->setFrom('support@idealbrandmarketing.com', 'Some Sender');
    	$mail->addTo('support@idealbrandmarketing.com', 'Some Recipient');
    	$mail->setSubject('TestSubject');
    	$mail->send();
    	exit;
    	if($data = $this->getRequest()->getPost())
    	{

			$content = file_get_contents(Mage::getBaseDir()."media/helpdeskemail/imgo.jpg");
			$attachment = new Zend_Mime_Part($content);
			$attachment->type        = 'image/jpg';
			$attachment->disposition = Zend_Mime::DISPOSITION_INLINE;
			$attachment->encoding    = Zend_Mime::ENCODING_BASE64;
			$attachment->filename    = 'imgo.jpg';

    		$mail = new Zend_Mail();
			$mail->addAttachment($attachment);
			
			$mail->setBodyText($data['content']);
			$mail->setFrom(Mage::getStoreConfig('trans_email/ident_general/email'), Mage::getStoreConfig('general/store_information/name'));
			$mail->addTo('support@idealbrandmarketing.com', 'JewelryDemo');
			$mail->setSubject('TestSubject');
			
    		/*$mail->setToName('JewelryDemo');
    		$mail->setToEmail('support@idealbrandmarketing.com');
    		$mail->setBody($data['content']);
    		$mail->setSubject($data['subject']);
    		$mail->setFromEmail(Mage::getStoreConfig('trans_email/ident_general/email'));
    		$mail->setFromName(Mage::getStoreConfig('general/store_information/name'));
    		$mail->setType('html');// YOu can use Html or text as Mail format
    		*/
    		try
    		{
    			$mail->send();
    			Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('evolved')->__('Successfully to send helpdeskticket email'));
    		}
    		catch(Exception $e)
    		{
    			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('evolved')->__('Unable to send helpdeskticket email'));
    		}
    		Mage::app()->getResponse()->setRedirect($_SERVER['HTTP_REFERER'])->sendResponse();
    	}
    	else 
    	{
    		Mage::getSingleton('adminhtml/session')->addError(Mage::helper('evolved')->__('Unable to send helpdeskticket email'));
    	}
    	//echo "hi"; exit;
    }
}