<?php
class Ideal_Selldiamond_IndexController extends Mage_Core_Controller_Front_Action
{
		const XML_PATH_EMAIL_RECIPIENT  = 'contacts/email/recipient_email';
    public function indexAction()
    {
    	
    	/*
    	 * Load an object by id 
    	 * Request looking like:
    	 * http://site.com/selldiamond?id=15 
    	 *  or
    	 * http://site.com/selldiamond/id/15 	
    	 */
    	/* 
		$selldiamond_id = $this->getRequest()->getParam('id');

  		if($selldiamond_id != null && $selldiamond_id != '')	{
			$selldiamond = Mage::getModel('selldiamond/selldiamond')->load($selldiamond_id)->getData();
		} else {
			$selldiamond = null;
		}	
		*/
		
		 /*
    	 * If no param we load a the last created item
    	 */ 
    	/*
    	if($selldiamond == null) {
			$resource = Mage::getSingleton('core/resource');
			$read= $resource->getConnection('core_read');
			$selldiamondTable = $resource->getTableName('selldiamond');
			
			$select = $read->select()
			   ->from($selldiamondTable,array('selldiamond_id','title','content','status'))
			   ->where('status',1)
			   ->order('created_time DESC') ;
			   
			$selldiamond = $read->fetchRow($select);
		}
		Mage::register('selldiamond', $selldiamond);
		*/

			
		$this->loadLayout();     
		$this->renderLayout();
    }
    
    
    public function sendemailAction()
    {
    	if ($data = $this->getRequest()->getPost()) {
    		$post = $this->getRequest()->getPost();
    		 
    		if($post['certification']=="Yes")
    		{
    			$post['certificationtype']=$post['certificationtype'];
    		}
    		else
    		{
    			$post['certificationtype']=$post['certificationtype1'];
    		}
    		
    		$model = Mage::getModel('selldiamond/selldiamond');
    		$model->setData($data)
    		->setId($this->getRequest()->getParam('id'));
    		
    		
    
    		try {
    			if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL) {
    				$model->setCreatedTime(now())
    				->setUpdateTime(now());
    			} else {
    				$model->setUpdateTime(now());
    			}
    		} catch (Exception $e) {
    
    		}
    		 
    		$model->save();
    
    		//Fetch submited params
    		$params = $this->getRequest()->getParams();
    		if($params['certification']=="Yes")
    		{
    			$type=$params['certificationtype'];
    		}
    		else
    		{
    			$type=$params['certificationtype1'];
    		}
    		$mail = new Zend_Mail();
    		$mail->setBodyText('Name: '.$params['name']."\r\nPrimary Phone Number: ".$params['phone1']."\r\nSecondary Phone Number: ".$params['phone2']."\r\nEmail: ".$params['email']."\r\nBest Time of Day to Contact You: ".$params['contact_time']."\r\nShape: ".$params['shape']."\r\nWeight:".$params['weight']."\r\nAsking Price: ".$params['price']."\r\nCertification: ".$params['certification']."\r\nType: ".$type."\r\nComment: ".$params['content']);
    		$mail->setFrom($params['email'], Mage::getStoreConfig('trans_email/ident_general/name')." - ".$params['name']);
    		$mail->addTo(Mage::getStoreConfig(self::XML_PATH_EMAIL_RECIPIENT), Mage::getStoreConfig('trans_email/ident_general/name').' Diamondseller');
			$mail->addBcc($params['email']);
    		//$mail->addTo('info@losangelesdiamondseller.com', 'Some Recipient');	  
    		$mail->setSubject('Sell your diamonds');
    		try {
    			$mail->send();
    			Mage::getSingleton('core/session')->addSuccess('<p>Thank you, we\'ve received your request. Our expert jeweler will contact you within 24 hours.</p>');
    		}
    		catch(Exception $ex) {
    			Mage::getSingleton('core/session')->addError('Unable to send email');
    		}
    		//Redirect back to index action of (this) inchoo-simplecontact controller
    		$this->_redirect('sell-your-diamonds');
    	}
    }
}
