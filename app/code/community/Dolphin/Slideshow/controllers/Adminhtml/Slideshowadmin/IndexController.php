<?php

class Dolphin_Slideshow_Adminhtml_Slideshowadmin_IndexController extends Mage_Adminhtml_Controller_Action
{
	protected function _initAction()
	{
		$this->loadLayout()
			->_setActiveMenu('slideshow/manage_slideshow')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));
		return $this;
	}

	public function indexAction() {
		$this->_initAction();       
		$this->_addContent($this->getLayout()->createBlock('slideshow/adminhtml_slideshow'));
		$this->renderLayout();
	}

	public function editAction()
	{
		$slideshowId     = $this->getRequest()->getParam('id');
		$slideshowModel  = Mage::getModel('slideshow/slideshow')->load($slideshowId);
 
		if ($slideshowModel->getId() || $slideshowId == 0) {
 
			($slideshowModel['desktop_img']) ? $slideshowModel['desktop_img'] = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA)."wysiwyg/slideshow/".$slideshowModel['desktop_img'] : "";
			($slideshowModel['landscape_ipad_img']) ? $slideshowModel['landscape_ipad_img'] = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA)."wysiwyg/slideshow/".$slideshowModel['landscape_ipad_img'] : "";
			($slideshowModel['portrait_ipad_img']) ? $slideshowModel['portrait_ipad_img'] = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA)."wysiwyg/slideshow/".$slideshowModel['portrait_ipad_img'] : "";
			($slideshowModel['mobile_img']) ? $slideshowModel['mobile_img'] = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA)."wysiwyg/slideshow/".$slideshowModel['mobile_img'] : "";
			Mage::register('slideshow_data', $slideshowModel);
 
			$this->loadLayout();
			$this->_setActiveMenu('slideshow/manage_slideshow');
		   
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));
		   
			
			$this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
			
			$this->getLayout ()->getBlock ( 'head' )->addJs ( 'mage/adminhtml/variables.js' );
			$this->getLayout ()->getBlock ( 'head' )->addJs ( 'mage/adminhtml/wysiwyg/widget.js' );
			//$this->getLayout ()->getBlock ( 'head' )->addJs ( 'lib/flex.js' );
			//$this->getLayout ()->getBlock ( 'head' )->addJs ( 'lib/FABridge.js' );
			//$this->getLayout ()->getBlock ( 'head' )->addJs ( 'mage/adminhtml/flexuploader.js' );
			$this->getLayout ()->getBlock ( 'head' )->addJs ( 'lib/uploader/flow.min.js' );
			$this->getLayout ()->getBlock ( 'head' )->addJs ( 'lib/uploader/fusty-flow.js' );
			$this->getLayout ()->getBlock ( 'head' )->addJs ( 'lib/uploader/fusty-flow-factory.js' );
			$this->getLayout ()->getBlock ( 'head' )->addJs ( 'mage/adminhtml/uploader/instance.js' );
			$this->getLayout ()->getBlock ( 'head' )->addJs ( 'mage/adminhtml/browser.js' );
			$this->getLayout ()->getBlock ( 'head' )->addJs ( 'prototype/window.js' );
			$this->getLayout ()->getBlock ( 'head' )->addJs ( 'prototype/windows/themes/default.css' );
			$this->getLayout ()->getBlock ( 'head' )->addCSS ( 'lib/prototype/windows/themes/magento.css' );
		   
			$this->_addContent($this->getLayout()->createBlock('slideshow/adminhtml_slideshow_edit'))
				 ->_addLeft($this->getLayout()->createBlock('slideshow/adminhtml_slideshow_edit_tabs'));
			   
			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('slideshow')->__('Item does not exist'));
			$this->_redirect('*/*/');
		}
	}
   
	public function newAction()
	{
		$this->_forward('edit');
	}
   
	public function saveAction()
	{
		if ( $this->getRequest()->getPost() ) {
			try {
				$postData = $this->getRequest()->getPost();
				$slideshowModel = Mage::getModel('slideshow/slideshow');

			$slidesPath = Mage::helper('slideshow')->getSlidesPath();
			
			if(isset($_FILES['filename']['name']) && $_FILES['filename']['name'] != '') {
				try {	
				
					/* Starting upload */	
					$uploader = new Varien_File_Uploader('filename');
					
					// Any extention would work
	           		$uploader->setAllowedExtensions(array('jpg','jpeg','gif','png'));
					$uploader->setAllowRenameFiles(true);
					
					// Set the file upload mode 
					// false -> get the file directly in the specified folder
					// true -> get the file in the product like folders 
					//	(file.jpg will go in something like /media/f/i/file.jpg)
					$uploader->setFilesDispersion(false);
							
					// We set media as the upload dir
					$path = Mage::getBaseDir('media') . DS . $slidesPath ;
					$result = $uploader->save($path, $_FILES['filename']['name'] );
					
					//For thumb
					Mage::helper('slideshow')->resizeImg($result['file'], 100, 75);
					//For thumb ends
					
					$test = $slidesPath.$result['file'];
					
					//$postData['filename'] = $slidesPath.$result['file'];
					
					if(isset($postData['filename']['delete']) && $postData['filename']['delete'] == 1)
					{
						//Mage_Core_Model_Store::URL_TYPE_MEDIA. DS .$postData['filename']['value'];
						unlink(Mage_Core_Model_Store::URL_TYPE_MEDIA. DS .$postData['filename']['value']);
						unlink(Mage_Core_Model_Store::URL_TYPE_MEDIA. DS . Mage::helper('slideshow')->getThumbsPath($postData['filename']['value']));
					}
					$postData['filename'] = $test;

				} catch (Exception $e) {
					$postData['filename'] = $_FILES['filename']['name'];
		        }
			}
			else {       
			
				if(isset($postData['filename']['delete']) && $postData['filename']['delete'] == 1){
					unlink(Mage_Core_Model_Store::URL_TYPE_MEDIA. DS .$postData['filename']['value']);
					unlink(Mage_Core_Model_Store::URL_TYPE_MEDIA. DS .Mage::helper('slideshow')->getThumbsPath($postData['filename']['value']));
					$postData['filename'] = '';
					}
				else
					unset($postData['filename']);
			}
			
			if(isset($_FILES['desktop_img']['name']) && $_FILES['desktop_img']['name'] != '') {
				try {
			
					/* Starting upload */
					$uploader = new Varien_File_Uploader('desktop_img');
						
					// Any extention would work
					$uploader->setAllowedExtensions(array('jpg','jpeg','gif','png'));
					$uploader->setAllowRenameFiles(true);
						
					// Set the file upload mode
					// false -> get the file directly in the specified folder
					// true -> get the file in the product like folders
					//	(file.jpg will go in something like /media/f/i/file.jpg)
					$uploader->setFilesDispersion(false);
						
					// We set media as the upload dir
					$path = Mage::getBaseDir('media') . DS .'wysiwyg/slideshow/';
					$result = $uploader->save($path, $_FILES['desktop_img']['name'] );
						
					//For thumb
					Mage::helper('slideshow')->resizeImg($result['file'], 100, 75);
					//For thumb ends
						
					$test = $path.$result['file'];
						
					//$postData['desktop_img'] = $slidesPath.$result['file'];
						
					if(isset($postData['desktop_img']['delete']) && $postData['desktop_img']['delete'] == 1)
					{
						//Mage_Core_Model_Store::URL_TYPE_MEDIA. DS .$postData['desktop_img']['value'];
						unlink(Mage_Core_Model_Store::URL_TYPE_MEDIA. DS .'wysiwyg/slideshow/'. $postData['desktop_img']['value']);
						unlink(Mage_Core_Model_Store::URL_TYPE_MEDIA. DS .'wysiwyg/slideshow/'. Mage::helper('slideshow')->getThumbsPath($postData['desktop_img']['value']));
					}
					$postData['desktop_img'] = $result['file'];
			
				} catch (Exception $e) {
					$postData['desktop_img'] = $_FILES['desktop_img']['name'];
				}
			}
			else {
					
				if(isset($postData['desktop_img']['delete']) && $postData['desktop_img']['delete'] == 1){
					unlink(Mage_Core_Model_Store::URL_TYPE_MEDIA. DS .'wysiwyg/slideshow/'. $postData['desktop_img']['value']);
					unlink(Mage_Core_Model_Store::URL_TYPE_MEDIA. DS .'wysiwyg/slideshow/'. Mage::helper('slideshow')->getThumbsPath($postData['desktop_img']['value']));
					$postData['desktop_img'] = '';
				}
				else
				{
					$deskurl_explode = explode("/",$postData['desktop_img']['value']);
					$postData['desktop_img'] = $deskurl_explode[count($deskurl_explode) - 1];
					//unset($postData['desktop_img']);
				}
			}
			
			if(isset($_FILES['landscape_ipad_img']['name']) && $_FILES['landscape_ipad_img']['name'] != '') {
				try {
						
					/* Starting upload */
					$uploader = new Varien_File_Uploader('landscape_ipad_img');
			
					// Any extention would work
					$uploader->setAllowedExtensions(array('jpg','jpeg','gif','png'));
					$uploader->setAllowRenameFiles(true);
			
					// Set the file upload mode
					// false -> get the file directly in the specified folder
					// true -> get the file in the product like folders
					//	(file.jpg will go in something like /media/f/i/file.jpg)
					$uploader->setFilesDispersion(false);
			
					// We set media as the upload dir
					$path = Mage::getBaseDir('media') . DS .'wysiwyg/slideshow/';
					$result = $uploader->save($path, $_FILES['landscape_ipad_img']['name'] );
			
					//For thumb
					Mage::helper('slideshow')->resizeImg($result['file'], 100, 75);
					//For thumb ends
			
					$test = $path.$result['file'];
			
					//$postData['landscape_ipad_img'] = $slidesPath.$result['file'];
			
					if(isset($postData['landscape_ipad_img']['delete']) && $postData['landscape_ipad_img']['delete'] == 1)
					{
						//Mage_Core_Model_Store::URL_TYPE_MEDIA. DS .$postData['landscape_ipad_img']['value'];
						unlink(Mage_Core_Model_Store::URL_TYPE_MEDIA. DS .'wysiwyg/slideshow/'. $postData['landscape_ipad_img']['value']);
						unlink(Mage_Core_Model_Store::URL_TYPE_MEDIA. DS .'wysiwyg/slideshow/'. Mage::helper('slideshow')->getThumbsPath($postData['landscape_ipad_img']['value']));
					}
					$postData['landscape_ipad_img'] = $result['file'];
						
				} catch (Exception $e) {
					$postData['landscape_ipad_img'] = $_FILES['landscape_ipad_img']['name'];
				}
			}
			else {
					
				if(isset($postData['landscape_ipad_img']['delete']) && $postData['landscape_ipad_img']['delete'] == 1){
					unlink(Mage_Core_Model_Store::URL_TYPE_MEDIA. DS .'wysiwyg/slideshow/'. $postData['landscape_ipad_img']['value']);
					unlink(Mage_Core_Model_Store::URL_TYPE_MEDIA. DS .'wysiwyg/slideshow/'. Mage::helper('slideshow')->getThumbsPath($postData['landscape_ipad_img']['value']));
					$postData['landscape_ipad_img'] = '';
				}
				else
				{
					$landscapeurl_explode = explode("/",$postData['landscape_ipad_img']['value']);
					$postData['landscape_ipad_img'] = $landscapeurl_explode[count($landscapeurl_explode) - 1];
					//unset($postData['landscape_ipad_img']);
				}
			}
			
			if(isset($_FILES['portrait_ipad_img']['name']) && $_FILES['portrait_ipad_img']['name'] != '') {
				try {
						
					/* Starting upload */
					$uploader = new Varien_File_Uploader('portrait_ipad_img');
			
					// Any extention would work
					$uploader->setAllowedExtensions(array('jpg','jpeg','gif','png'));
					$uploader->setAllowRenameFiles(true);
			
					// Set the file upload mode
					// false -> get the file directly in the specified folder
					// true -> get the file in the product like folders
					//	(file.jpg will go in something like /media/f/i/file.jpg)
					$uploader->setFilesDispersion(false);
			
					// We set media as the upload dir
					$path = Mage::getBaseDir('media') . DS .'wysiwyg/slideshow/';
					$result = $uploader->save($path, $_FILES['portrait_ipad_img']['name'] );
			
					//For thumb
					Mage::helper('slideshow')->resizeImg($result['file'], 100, 75);
					//For thumb ends
			
					$test = $path.$result['file'];
			
					//$postData['portrait_ipad_img'] = $slidesPath.$result['file'];
			
					if(isset($postData['portrait_ipad_img']['delete']) && $postData['portrait_ipad_img']['delete'] == 1)
					{
						//Mage_Core_Model_Store::URL_TYPE_MEDIA. DS .$postData['portrait_ipad_img']['value'];
						unlink(Mage_Core_Model_Store::URL_TYPE_MEDIA. DS .'wysiwyg/slideshow/'. $postData['portrait_ipad_img']['value']);
						unlink(Mage_Core_Model_Store::URL_TYPE_MEDIA. DS .'wysiwyg/slideshow/'. Mage::helper('slideshow')->getThumbsPath($postData['portrait_ipad_img']['value']));
					}
					$postData['portrait_ipad_img'] = $result['file'];
						
				} catch (Exception $e) {
					$postData['portrait_ipad_img'] = $_FILES['portrait_ipad_img']['name'];
				}
			}
			else {
					
				if(isset($postData['portrait_ipad_img']['delete']) && $postData['portrait_ipad_img']['delete'] == 1){
					unlink(Mage_Core_Model_Store::URL_TYPE_MEDIA. DS .'wysiwyg/slideshow/'. $postData['portrait_ipad_img']['value']);
					unlink(Mage_Core_Model_Store::URL_TYPE_MEDIA. DS .'wysiwyg/slideshow/'. Mage::helper('slideshow')->getThumbsPath($postData['portrait_ipad_img']['value']));
					$postData['portrait_ipad_img'] = '';
				}
				else
				{
					$portraiturl_explode = explode("/",$postData['portrait_ipad_img']['value']);
					$postData['portrait_ipad_img'] = $portraiturl_explode[count($portraiturl_explode) - 1];
					//unset($postData['portrait_ipad_img']);
				}
			}
			
			if(isset($_FILES['mobile_img']['name']) && $_FILES['mobile_img']['name'] != '') {
				try {
						
					/* Starting upload */
					$uploader = new Varien_File_Uploader('mobile_img');
			
					// Any extention would work
					$uploader->setAllowedExtensions(array('jpg','jpeg','gif','png'));
					$uploader->setAllowRenameFiles(true);
			
					// Set the file upload mode
					// false -> get the file directly in the specified folder
					// true -> get the file in the product like folders
					//	(file.jpg will go in something like /media/f/i/file.jpg)
					$uploader->setFilesDispersion(false);
			
					// We set media as the upload dir
					$path = Mage::getBaseDir('media') . DS .'wysiwyg/slideshow/';
					$result = $uploader->save($path, $_FILES['mobile_img']['name'] );
			
					//For thumb
					Mage::helper('slideshow')->resizeImg($result['file'], 100, 75);
					//For thumb ends
			
					$test = $path.$result['file'];
			
					//$postData['mobile_img'] = $slidesPath.$result['file'];
			
					if(isset($postData['mobile_img']['delete']) && $postData['mobile_img']['delete'] == 1)
					{
						//Mage_Core_Model_Store::URL_TYPE_MEDIA. DS .$postData['mobile_img']['value'];
						unlink(Mage_Core_Model_Store::URL_TYPE_MEDIA. DS .'wysiwyg/slideshow/'. $postData['mobile_img']['value']);
						unlink(Mage_Core_Model_Store::URL_TYPE_MEDIA. DS .'wysiwyg/slideshow/'. Mage::helper('slideshow')->getThumbsPath($postData['mobile_img']['value']));
					}
					$postData['mobile_img'] = $result['file'];
						
				} catch (Exception $e) {
					$postData['mobile_img'] = $_FILES['mobile_img']['name'];
				}
			}
			else {
					
				if(isset($postData['mobile_img']['delete']) && $postData['mobile_img']['delete'] == 1){
					unlink(Mage_Core_Model_Store::URL_TYPE_MEDIA. DS .'wysiwyg/slideshow/'. $postData['mobile_img']['value']);
					unlink(Mage_Core_Model_Store::URL_TYPE_MEDIA. DS .'wysiwyg/slideshow/'. Mage::helper('slideshow')->getThumbsPath($postData['mobile_img']['value']));
					$postData['mobile_img'] = '';
				}
				else
				{
					$mobileurl_explode = explode("/",$postData['mobile_img']['value']);
					$postData['mobile_img'] = $mobileurl_explode[count($mobileurl_explode) - 1];
					//unset($postData['mobile_img']);
				}
			}
			
			
				if(isset($postData['stores'])) {
					if(in_array('0',$postData['stores'])){
						$postData['stores'] = '0';
					}
					else{
						$postData['stores'] = implode(",", $postData['stores']);
					}
				    //unset($postData['stores']);
				}
				
				if($postData['stores'] == "")
				{
					$postData['stores'] = '0';
				}

				$slideshowModel->setId($this->getRequest()->getParam('id'))
					->setTitle($postData['title'])
					->setSlideUrl($postData['slide_url'])
					->setSlideTarget($postData['slide_target'])
					->setContent($postData['content'])
					->setFilename($postData['filename'])
					->setImageSlide($postData['image_slide'])
					->setDesktopImg($postData['desktop_img'])
					->setLandscapeIpadImg($postData['landscape_ipad_img'])
					->setPortraitIpadImg($postData['portrait_ipad_img'])
					->setMobileImg($postData['mobile_img'])
					->setSortOrder($postData['sort_order'])
					->setStatus($postData['status'])
					->setStores($postData['stores'])
					->save();

				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Item was successfully saved'));
				Mage::getSingleton('adminhtml/session')->setSlideshowData(false);
 
				$this->_redirect('*/*/');
				return;
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				Mage::getSingleton('adminhtml/session')->setSlideshowData($this->getRequest()->getPost());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
				return;
			}
		}
		$this->_redirect('*/*/');
	}
   
	public function deleteAction()
	{
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$slideshowModel = Mage::getModel('slideshow/slideshow');
			   
				$slideshowModel->setId($this->getRequest()->getParam('id'))
					->delete();
				   
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Item was successfully deleted'));
				$this->_redirect('*/*/');
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
			}
		}
		$this->_redirect('*/*/');
	}
	/**
	 * Product grid for AJAX request.
	 * Sort and filter result for example.
	 */
	public function gridAction()
	{
		$this->loadLayout();
		$this->getResponse()->setBody(
			   $this->getLayout()->createBlock('slideshow/adminhtml_slideshow_grid')->toHtml()
		);
	}
	protected function _isAllowed()
    {
    	return Mage::getSingleton('admin/session')->isAllowed('cms/slideshow');
    }
}
?>
