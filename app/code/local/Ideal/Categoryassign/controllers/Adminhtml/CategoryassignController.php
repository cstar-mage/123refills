<?php
class Ideal_Categoryassign_Adminhtml_CategoryassignController extends Mage_Adminhtml_Controller_action
{	
	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu("sales/categoryassign")
			->_addBreadcrumb(Mage::helper("adminhtml")->__("Category Assignment"), Mage::helper("adminhtml")->__("Category Assignment"));
		
		return $this;
	}   
 
	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}

	public function exportCSVAction()
	{
		//$collection->addAttributeToFilter(array('eaov.value','14k%'));
		/* echo count($collection);
		print_r($collection->getData()); */
		
		//echo "<pre>"; print_r($collection->getData());exit;
		
		if($data = $this->getRequest()->getPost())
		{
			/********************** Start Text fields *****************************/
			$collection = Mage::getModel('catalog/product')->getCollection();
			$dataattrname = explode(";",$data['catassign_attrname']);
			foreach($dataattrname as $dataattrname_key=>$dataattrname_value)
			{
				$attributeInfo = Mage::getResourceModel('eav/entity_attribute_collection')->setCodeFilter($dataattrname_value)->getFirstItem();
				//echo "<pre>"; print_r($attributeInfo->getData());
				
				if(($attributeInfo->getData('frontend_input') == "multiselect") || ($attributeInfo->getData('frontend_input') == "select"))
				{
					$attrids[] = $attributeInfo->getData('attribute_id');
					continue;
				}
				else {
					if($data['catassign_rules'] == 'is_equal')
					{
						$arr[] = array('attribute'=> $dataattrname_value,'like' => $data['catassign_searchword']);
					}
					else{
						$arr[] = array('attribute'=> $dataattrname_value,'like' => '%'.$data['catassign_searchword'].'%');
					}
				}
			}
			//echo "<br />".$implodeattrids;
			$collection = Mage::getModel('catalog/product')->getCollection();
			$collection->addAttributeToFilter($arr);
			foreach($collection as $collection1)
			{
				$csvdata[] = $collection1->getSku();
			}
			//echo "<pre>"; print_r($csvdata);
			/********************** End Text fields *****************************/
			
			/********************** Start Select,Multiselect fields *****************************/

			//echo "<pre> hi "; print_r($optiondata); echo $implodeoptiondata;
			/*$collectiondrop = Mage::getModel('catalog/product')->getCollection()->getSelect();
			$collectiondrop->join( array('cpev'=>'catalog_product_entity_varchar'), 'e.entity_id = cpev.entity_id', array('cpev.*'));
			$collectiondrop->join( array('ea'=>'eav_attribute'), 'cpev.attribute_id = ea.attribute_id', array('ea.*'));
			$collectiondrop->join( array('eao'=>'eav_attribute_option'), 'ea.attribute_id = eao.attribute_id', array('eao.*'));
			$collectiondrop->join( array('eaov'=>'eav_attribute_option_value'), 'eao.option_id = eaov.option_id', array('eaov.*'));
			if($data['catassign_rules'] == 'is_equal')
			{
				$collectiondrop->where("eaov.value like '".$data['catassign_searchword']."' and ea.attribute_id in (74,174)");
			}
			else{
				$collectiondrop->where("eaov.value like '%".$data['catassign_searchword']."%' and ea.attribute_id in (74,174)");
			}*/
			$implodeattrids = implode(",",$attrids);
			if(count($attrids) != 0)
			{
				if($data['catassign_rules'] == 'is_equal')
				{
					$attrvalue_query = "select * from ".Mage::getSingleton('core/resource')->getTableName('eav_attribute_option_value')." where value like '".$data['catassign_searchword']."'";
				}
				else
				{
					$attrvalue_query = "select * from ".Mage::getSingleton('core/resource')->getTableName('eav_attribute_option_value')." where value like '%".$data['catassign_searchword']."%'";
				}
				$attrvalueresults = Mage::getSingleton('core/resource')->getConnection('core_read')->fetchAll($attrvalue_query);
				foreach($attrvalueresults as $attrvalueresultsdata)
				{
					$optiondata[] = $attrvalueresultsdata['option_id'];
				}
				$implodeoptiondata = implode(",",$optiondata);
				if(trim($implodeoptiondata))
				{
					$collectiondrop = Mage::getModel('catalog/product')->getCollection()->getSelect();
					$collectiondrop->join( array('cpev'=>Mage::getSingleton('core/resource')->getTableName('catalog_product_entity_varchar')), 'e.entity_id = cpev.entity_id', array('cpev.*'));
					$collectiondrop->where("(cpev.value in (".$implodeoptiondata.")) and cpev.attribute_id in (".$implodeattrids.")");
					//echo $collectiondrop; exit;
					$results = Mage::getSingleton('core/resource')->getConnection('core_read')->fetchAll($collectiondrop);
					foreach($results as $resultsdata)
					{
						$csvdata[] = $resultsdata['sku'];
					}	
				}
			}
			/********************** End Select,Multiselect fields *****************************/
		}
		
		//echo "<pre>"; print_r($csvdata); exit;
		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename=categoryassignment.csv');
		$catcsvdata[] = 'Categoty Ids,Sku';
		foreach($csvdata as $csvdata1)
		{
			$catcsvdata[] = $data['catassign_categoryid'].",".$csvdata1;
		}
		$resultcatcsvdata = array_unique($catcsvdata);
		//echo "<pre>"; print_r($catcsvdata); print_r($data); exit;
		/*$fp = fopen('php://output', 'w');
		foreach ( $resultcatcsvdata as $line ) {
		    $val = explode(",", $line);
		    fputcsv($fp, $val);
		}
		fclose($fp);
		*/
		$file = fopen("php://output","w");		
		foreach ($resultcatcsvdata as $line)
		{
			fputcsv($file,explode(',',$line));
		}
		fclose($file);
		exit;
	}
	
	public function editAction() {
		$id     = $this->getRequest()->getParam("id");
		$model  = Mage::getModel("categoryassign/categoryassign")->load($id);

		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton("adminhtml/session")->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}

			Mage::register("categoryassign_data", $model);

			$this->loadLayout();
			$this->_setActiveMenu("sales/categoryassign");

			$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Category Assignment"), Mage::helper("adminhtml")->__("Category Assignment"));
			$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Category Assignment"), Mage::helper("adminhtml")->__("Category Assignment"));

			$this->getLayout()->getBlock("head")->setCanLoadExtJs(true);

			$this->_addContent($this->getLayout()->createBlock("categoryassign/adminhtml_categoryassign_edit"))
				->_addLeft($this->getLayout()->createBlock("categoryassign/adminhtml_categoryassign_edit_tabs"));

			$this->renderLayout();
		} else {
			Mage::getSingleton("adminhtml/session")->addError(Mage::helper("categoryassign")->__("Item does not exist"));
			$this->_redirect("*/*/");
		}
	}
 
	public function newAction() {
		$this->_forward("edit");
	}
	
	public function exportAction() {
	    
	    $this->loadLayout();
	    $this->_setActiveMenu("sales/categoryassign");
	    
	    $this->_addBreadcrumb(Mage::helper("adminhtml")->__("Category Assignment"), Mage::helper("adminhtml")->__("Category Assignment"));
	    $this->_addBreadcrumb(Mage::helper("adminhtml")->__("Category Assignment"), Mage::helper("adminhtml")->__("Category Assignment"));
	    
	    $this->getLayout()->getBlock("head")->setCanLoadExtJs(true);
	    
	    $this->_addContent($this->getLayout()->createBlock("categoryassign/adminhtml_categoryassign_edit"))
	    ->_addLeft($this->getLayout()->createBlock("categoryassign/adminhtml_categoryassign_edit_tabs"));
	    
	    $this->getLayout()->getBlock('head')->setTitle(Mage::helper("categoryassign")->__("Category Assignment"));
	    
	    $this->renderLayout();
	    
	}
	
	public function saveAction() {
	    if ($data = $this->getRequest()->getPost()) {
	       
	        $type = $this->getRequest()->getParam('type');
	        if(!$type) {
	            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('categoryassign')->__('Format Not Found'));
	            $this->_redirect('*/export');
	            return;
	        } 
	       
	       if($type == "CLI") {
	           $this->exportFormatCLI();
	       }
	       
	       if($type == "FAC") {
	           $this->exportFormatFAC();
	       }
	       
	       if($type == "LFA") {
	           $this->exportFormatLFA();
	       }
	       
	       if($type == "MAE") {
	           $this->exportFormatMAE();
	       }
	       
	    }
	    
	    /* Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('categoryassign')->__('Item was successfully saved'));
	    Mage::getSingleton('adminhtml/session')->addError(Mage::helper('categoryassign')->__('Unable to find item to save'));
	    $this->_redirect('categoryassign/adminhtml_categoryassign/export'); */
	}
	
	public function exportFormatCLI() {
	    Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('categoryassign')->__('CLI Processed'));
	    $this->_redirect('categoryassign/adminhtml_categoryassign/export');
	    return;
	}
	
	public function exportFormatFAC() {
	    Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('categoryassign')->__('FAC Processed'));
	    $this->_redirect('categoryassign/adminhtml_categoryassign/export');
	    return;
	}
	
	public function exportFormatLFA() {
	    Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('categoryassign')->__('LFA Processed'));
	    $this->_redirect('categoryassign/adminhtml_categoryassign/export');
	    return;
	}
	
	public function exportFormatMAE() {
	    Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('categoryassign')->__('MAE Processed'));
	    $this->_redirect('categoryassign/adminhtml_categoryassign/export');
	    return;
	}
	
}
?>