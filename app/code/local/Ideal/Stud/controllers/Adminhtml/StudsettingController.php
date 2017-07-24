<?php
 
class Ideal_Stud_Adminhtml_StudsettingController extends Mage_Adminhtml_Controller_action
{	
	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu("stud/items")
			->_addBreadcrumb(Mage::helper("adminhtml")->__("Items Manager"), Mage::helper("adminhtml")->__("Item Manager"));
		
		return $this;
	}   
 
	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}

	public function editAction() { 
		
		$id     = $this->getRequest()->getParam("id");
		$model  = Mage::getModel("stud/clarity")->load($id);

		if ($model->getId() || $id == 0) {

			$data = Mage::getSingleton("adminhtml/session")->getFormData(true);

			if (!empty($data)) {
				$model->setData($data);
			}

			Mage::register("stud_data", $model);

			$this->loadLayout();
			$this->_setActiveMenu("stud/items");

			$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Item Manager"), Mage::helper("adminhtml")->__("Item Manager"));
			$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Item News"), Mage::helper("adminhtml")->__("Item News"));

			$this->getLayout()->getBlock("head")->setCanLoadExtJs(true);

			$this->_addContent($this->getLayout()->createBlock("stud/adminhtml_stud_stud_edit"))
				->_addLeft($this->getLayout()->createBlock("stud/adminhtml_stud_stud_edit_tabs"));

			$this->renderLayout();
		} else {
			Mage::getSingleton("adminhtml/session")->addError(Mage::helper("stud")->__("Item does not exist"));
			$this->_redirect("*/*/");
		}
	}

	public function saveAction() { 

	

    if ($data = $this->getRequest()->getPost()) {


    		$read= Mage::getSingleton('core/resource')->getConnection('core_read');
			$read->query("truncate table clarity");  
			$read->query("truncate table carat");  
  
		
			$storeId = Mage::app()->getStore()->getStoreId();

			try { 

			


				$dataValue = $data['clarity_setting']['value'];


				foreach ($dataValue as $key => $value) {

					if(($value[label] != "") && ($value[dbfield] != ""))
					{
						$data1 = array('label'=>$value['label'],'dbfield'=>$value['dbfield'],'sortorder'=>$value['sortorder']); 
				
		   	    		 $clarityModel = Mage::getModel('stud/clarity');  
				    	 $clarityModel->setData($data1)
				    	 		->save(); 

					} 
					else
					{
						continue;
					}
		
				
				}

				$dataValue1 = $data['caratweight']['value'];


				foreach ($dataValue1 as $key => $value) {

					if($value[caratweight] != "")
					{
						$data2 = array('caratweight'=>$value['caratweight']); 
				
		   	    		 $caratModel = Mage::getModel('stud/carat');  
				    	 $caratModel->setData($data2)
				    	 		->save(); 

					} 
					else
					{
						continue;
					}
		
				
				}


				

				Mage::getSingleton("adminhtml/session")->addSuccess("Information Saved.");
				$this->_redirectReferer();
				return;

			} catch (Exception $e) {
				Mage::getSingleton("adminhtml/session")->addError(Mage::helper("stud")->__("Information does not Save."));
				$this->_redirectReferer();
				return;
			}

		}	

	}
	
	public function settingAction() {
		$this->_forward("edit");
	}


	public function deleteAction() {
		if( $this->getRequest()->getParam("id") > 0 ) {
			try {
				$model = Mage::getModel("stud/clarity");
				 
				$model->setId($this->getRequest()->getParam("id"))
					->delete();
		
				Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("stud")->__("Item was successfully deleted"));
				$this->_redirectReferer();
			} catch (Exception $e) {
				Mage::getSingleton("adminhtml/session")->addError(Mage::helper("stud")->__("Item was not deleted"));
				$this->_redirect("*/*/setting", array("id" => $this->getRequest()->getParam("id")));
			}
		}
		$this->_redirectReferer();
	}






}