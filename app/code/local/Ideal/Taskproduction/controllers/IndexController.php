<?php
class Ideal_Diamondtype_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
    	
    	/*
    	 * Load an object by id 
    	 * Request looking like:
    	 * http://site.com/diamondtype?id=15 
    	 *  or
    	 * http://site.com/diamondtype/id/15 	
    	 */
    	/* 
		$diamondtype_id = $this->getRequest()->getParam('id');

  		if($diamondtype_id != null && $diamondtype_id != '')	{
			$diamondtype = Mage::getModel('diamondtype/diamondtype')->load($diamondtype_id)->getData();
		} else {
			$diamondtype = null;
		}	
		*/
		
		 /*
    	 * If no param we load a the last created item
    	 */ 
    	/*
    	if($diamondtype == null) {
			$resource = Mage::getSingleton('core/resource');
			$read= $resource->getConnection('core_read');
			$diamondtypeTable = $resource->getTableName('diamondtype');
			
			$select = $read->select()
			   ->from($diamondtypeTable,array('diamondtype_id','title','content','status'))
			   ->where('status',1)
			   ->order('created_time DESC') ;
			   
			$diamondtype = $read->fetchRow($select);
		}
		Mage::register('diamondtype', $diamondtype);
		*/

			
		$this->loadLayout();     
		$this->renderLayout();
    }
	
	public function viewAction()
    {
    	$this->loadLayout();
    	$this->renderLayout();
    }
    
    public function saveAction()
    {

		if ($datapost = $this->getRequest()->getParams()) {
			//echo count($datapost['diamondtype-dimensions-text']); exit;
			//echo "<pre>"; print_r($this->getRequest()->getParams()); exit;
			$data['type'] = $datapost['diamondtype-type-box'];
			$data['shape'] = implode(", ",$datapost['diamondtype-shape-checkbox']);
			$data['color'] = implode(", ",$datapost['diamondtype-color-checkbox']);
			
			if(!$datapost['min-carat-range-box'])
			{
				$datapost['min-carat-range-box'] = 0;
			}
			if(!$datapost['max-carat-range-box'])
			{
				$datapost['max-carat-range-box'] = 10;
			}
			$data['carat'] = $datapost['min-carat-range-box']." - ".$datapost['max-carat-range-box'];
			
			if(count($datapost['diamondtype-dimensions-text']) > 0)
			{
				$data['dimensions'] = serialize($datapost['diamondtype-dimensions-text']);
			}
			
			if(!$datapost['min-price-range-box'])
			{
				$datapost['min-price-range-box'] = "$1000";
			}
			if(!$datapost['max-price-range-box'])
			{
				$datapost['max-price-range-box'] = "$5000000";
			}
			$data['price'] = $datapost['min-price-range-box']." - ".$datapost['max-price-range-box'];
			$data['pricetype'] = $datapost['diamondtype-price-type'];
			$data['lab'] = implode(", ",$datapost['diamondtype-lab-checkbox']);
			$data['comment'] = $datapost['diamondtype-comment-box'];
			
			$data['fname'] = $datapost['diamondtype-contact-firstname-box'];
			$data['lname'] = $datapost['diamondtype-contact-lastname-box'];
			$data['phoneno'] = $datapost['diamondtype-contact-phoneno-box'];
			$data['email'] = $datapost['diamondtype-contact-emailid-box'];

			//echo "<pre>"; print_r($data); exit;
			$model = Mage::getModel('diamondtype/diamondtype');
			$model->setData($data);
			 
				
			try {
				if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL) {
					$model->setCreatedTime(now())
					->setUpdateTime(now());
				} else {
					$model->setUpdateTime(now());
				}
				$model->save();
				Mage::getSingleton('core/session')->addSuccess(Mage::helper('diamondtype')->__('Diamondtype was successfully saved'));
				Mage::getSingleton('core/session')->setFormData(false);
				$this->_redirect('*/*/');
				return;
			} catch (Exception $e) {
				Mage::getSingleton('core/session')->addError($e->getMessage());
				Mage::getSingleton('core/session')->setFormData($data);
				return;
			}
		}
		Mage::getSingleton('core/session')->addError(Mage::helper('diamondtype')->__('Unable to find Diamondtype to save'));
		$this->_redirect('*/*/');
			//$this->getRequest()->getPost()
		exit;
    }
}