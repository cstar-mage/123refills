<?php

class EcommerceTeam_FastImport_Adminhtml_ProductController extends Mage_Adminhtml_Controller_action{
	
	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('system/convert')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Import'), Mage::helper('adminhtml')->__('Import'));
		
		return $this;
	}
	
	public function indexAction(){
		
		$this->_initAction();
		
		$this->_addContent($this->getLayout()->createBlock('ecommerceteam_fastimport/adminhtml_product_import'))
				->_addLeft($this->getLayout()->createBlock('ecommerceteam_fastimport/adminhtml_product_import_tabs'));
		
		$this->renderLayout();
		
	}
	public function runAction(){
		try{
			
			$config = array(
				
				'create_options'	=> $this->getRequest()->getParam('create_options'),
				'create_categories' => $this->getRequest()->getParam('create_categories'),
				'absent_products'	=> $this->getRequest()->getParam('absent_products'),
				'delimeter'			=> $this->getRequest()->getParam('delimeter'),
				'enclose'			=> $this->getRequest()->getParam('enclose'),
				'update_indexes'	=> $this->getRequest()->getParam('update_indexes'),
				
			);
			
			
			$importModel = Mage::getModel('ecommerceteam_fastimport/product_import', array('config'=>$config));
			$importModel->run('data_file');
			
			$result = $importModel->getResult();
			
			if($result['created'] > 0 || $result['updated'] > 0){
			
				Mage::getSingleton('adminhtml/session')->addSuccess($this->__('Products Created: %s', $result['created']) .'<br/>' .$this->__('Products Updated: %s', $result['updated']));
			
			}
			if($result['skiped']){
			
				Mage::getSingleton('adminhtml/session')->addNotice($this->__('Items Skiped: %s', $result['skiped']));
			
			}
			if($result['errors']){
				
				foreach($result['errors'] as $msg){
				
				Mage::getSingleton('adminhtml/session')->addError($msg);
				
				}
			
			}
			
			$this->_redirect('*/*');
			
		}catch(Mage_Core_Exception $e){
			
			Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
			$this->_redirect('*/*');
			
		}catch(Exception $e){
			
			Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
			$this->_redirect('*/*');
			
		}
		
	}	
}
