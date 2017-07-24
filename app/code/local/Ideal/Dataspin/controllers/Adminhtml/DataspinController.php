<?php 
require_once(MAGENTO_ROOT."/magmi/inc/magmi_defs.php");
require_once(MAGENTO_ROOT."/magmi/integration/inc/magmi_datapump.php");

class Ideal_Dataspin_Adminhtml_DataspinController extends Mage_Adminhtml_Controller_Action
{

	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('catalog/dataspin')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Data Spin'), Mage::helper('adminhtml')->__('Data Spin'));
		
		return $this;
	}   
 
	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}
	
	public function productgridAction() {
        $this->_initAction();
        $this->getResponse()->setBody(
                $this->getLayout()->createBlock('dataspin/adminhtml_dataspin_edit_tab_products')->toHtml()
        );
    }

	public function editAction() {

		$collection = Mage::getModel('dataspin/dataspin')->getCollection();
		$data = array();	
		foreach ($collection as $row) {
			$data[$row['field']] = $row['value'];
		}
		
		//echo "<pre>"; print_r($data);echo "</pre>";
		$model  = Mage::getModel('dataspin/dataspin');
		if (!empty($data)) {
			$model->setData($data);
		}
		
		Mage::register('dataspin_data', $model);
		
		$this->loadLayout();
		$this->_setActiveMenu('catalog/dataspin');

		$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Data Spin'), Mage::helper('adminhtml')->__('Data Spin'));

		$this->getLayout ()->getBlock ( 'head' )->setCanLoadTinyMce ( true );
		$this->getLayout ()->getBlock ( 'head' )->setCanLoadExtJs ( true );
			
		$this->getLayout ()->getBlock ( 'head' )->addJs ( 'mage/adminhtml/variables.js' );
		$this->getLayout ()->getBlock ( 'head' )->addJs ( 'mage/adminhtml/wysiwyg/widget.js' );
		$this->getLayout ()->getBlock ( 'head' )->addJs ( 'lib/flex.js' );
		$this->getLayout ()->getBlock ( 'head' )->addJs ( 'lib/FABridge.js' );
		$this->getLayout ()->getBlock ( 'head' )->addJs ( 'mage/adminhtml/flexuploader.js' );
		$this->getLayout ()->getBlock ( 'head' )->addJs ( 'mage/adminhtml/browser.js' );
		$this->getLayout ()->getBlock ( 'head' )->addJs ( 'prototype/windows/themes/default.css' );
		$this->getLayout ()->getBlock ( 'head' )->addCSS ( 'lib/prototype/windows/themes/magento.css' );

		$this->_addContent($this->getLayout()->createBlock('dataspin/adminhtml_dataspin_edit'))
			->_addLeft($this->getLayout()->createBlock('dataspin/adminhtml_dataspin_edit_tabs'));

		$this->renderLayout();
	}
 
	public function newAction() {
		$this->_forward('edit');
	}
	
	public function importAction() {
		$this->_forward('edit');
	}
 
	public function saveAction() {
		if ($data = $this->getRequest()->getPost()) {
			//$product = $this->getRequest()->getPost('in_products');	
			//echo "<pre>"; print_r($data); exit;
		
			try {
				foreach ( $data as $field => $value ) {
					
					$ignorePosts = array('form_key','dataspin_products','export','internal_dataspin_products','config','page','limit','massaction','entity_id','sku','price','type','set_name','status','visibility','dataspin_applied');
					if (in_array($field, $ignorePosts)) continue;
					
					$model = Mage::getModel('dataspin/dataspin');
					$collection = $model->getCollection ()->addFieldToFilter ( 'field', $field );
					
					if($collection->count() > 0) {
						
						$settings = array (
								'dataspin_id' => $collection->getFirstItem()->getId(),
								'field' => $field,
								'value' => $value,
								'update_time' => now()
						);
						
					} else {
						
						$settings = array (
								'field' => $field,
								'value' => $value,
								'update_time' => now()
						);
						
					}
						
					$model->setData ($settings);
					$model->save ();

				}

				if(isset($data['dataspin_products']) && is_array($data['dataspin_products']) && (count($data['dataspin_products']) > 0)) {
					$applyToproducts = $data['dataspin_products'];
					$this->applyToProductsAction($applyToproducts);
				}
				
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('dataspin')->__('Settings was successfully saved'));
				Mage::getSingleton('adminhtml/session')->setFormData(false);

				$this->_redirect('*/*/import');
				return;
            } catch (Exception $e) {
                
            	Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                
                $this->_redirect('*/*/import');
                
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('dataspin')->__('Unable to find item to save'));
        $this->_redirect('*/*/import');
	}
 
	public function applyToProductsAction($applyToproducts) {

		try {
			$dp = Magmi_DataPumpFactory::getDataPumpInstance("productimport");
			$dp->beginImportSession("123_import_products", "update");
			
			$spinValues = Mage::helper('dataspin')->getDataSpinValues();
			
			$spinFields = array('name','short_description','description','meta_title','meta_description');
			
			$attributes = array();
			foreach ($spinFields as $spinField) {
				$codes = Mage::helper('dataspin')->getInbetweenStrings("{{", "}}", $spinValues[$spinField]);
				$attributes = array_merge($attributes, $codes);
			}
			//echo "<pre>"; print_r($attributes); exit;
			
			/* $_productCollection = Mage::getModel('catalog/product')->getCollection()
								->addAttributeToSelect('*')
								//->addAttributeToFilter('dataspin_applied','0')
								->addAttributeToFilter('sku','test-data-spin');//test */
			
			//echo count($_productCollection); exit;
			
			foreach ($applyToproducts as $productId) {
				
				$_product = Mage::getModel('catalog/product')->load($productId);
				if($_product->getDataspinApplied() == 1) {
				    Mage::getSingleton('adminhtml/session')->addError(Mage::helper('dataspin')->__('%s was already applied data spin',$_product->getSku()));
					continue; //products should flag so the data doesnt change
				}
				$replaceArray = array();
				foreach ($attributes as $attribute_code) {
					if (strpos($attribute_code, 'spin') !== false) {
						
						$spinRandom = explode(",",$spinValues[$attribute_code]);
						$rand_key = array_rand($spinRandom, 1);
						
						$attributeValue = trim($spinRandom[$rand_key]); //get the random from comma separated spin values
					} else {
						$attributeId = Mage::getResourceModel('eav/entity_attribute')->getIdByCode('catalog_product', $attribute_code);
						$attribute = Mage::getModel('catalog/resource_eav_attribute')->load($attributeId);
						$attributeValue = $attribute->getFrontend()->getValue($_product);
					}
	
					//echo $attribute_code . "==" . $attributeValue."<br>";
					$formattedKey = "{{".$attribute_code."}}";
					$replaceArray[$formattedKey] = $attributeValue;
				}
				//echo "<pre>"; print_r($replaceArray); exit;
				
				$searchWith  = array_keys($replaceArray);
				$replaceWith = array_values($replaceArray);
				
				$item = array();
				$item['sku'] = $_product->getSku();
				$item['websites'] = 'base';
				$item['store_id'] = '0';
				$item['store'] = 'admin';
				$item['dataspin_applied'] = '1';
				
				foreach ($spinFields as $spinField) {
					//echo $spinField . ": " . str_replace($searchWith, $replaceWith, $spinValues[$spinField]) . "<br>";
					$item[$spinField] = str_replace($searchWith, $replaceWith, $spinValues[$spinField]);
				}
				
				//echo "<pre>"; print_r($item); exit;
				$dp->ingest($item);
				
				//echo $item['sku']." Updated";
				unset($item);
				//exit;
			}
	
			// End import Session
			$dp->endImportSession();
			
			Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('dataspin')->__('Data Spin was applied successfully.'));
			$this->_redirect('*/*/import');
			return;
		
		} catch (Exception $e) {
		
			Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
			$this->_redirect('*/*/import');
		
			return;
		}
	}
}