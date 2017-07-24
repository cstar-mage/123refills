<?php
class Mage_Uploadproduct_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
    	
    	/*
    	 * Load an object by id 
    	 * Request looking like:
    	 * http://site.com/uploadproduct?id=15 
    	 *  or
    	 * http://site.com/uploadproduct/id/15 	
    	 */
    	/* 
		$uploadproduct_id = $this->getRequest()->getParam('id');

  		if($uploadproduct_id != null && $uploadproduct_id != '')	{
			$uploadproduct = Mage::getModel('uploadproduct/uploadproduct')->load($uploadproduct_id)->getData();
		} else {
			$uploadproduct = null;
		}	
		*/
		
		 /*
    	 * If no param we load a the last created item
    	 */ 
    	/*
    	if($uploadproduct == null) {
			$resource = Mage::getSingleton('core/resource');
			$read= $resource->getConnection('core_read');
			$uploadproductTable = $resource->getTableName('uploadproduct');
			
			$select = $read->select()
			   ->from($uploadproductTable,array('uploadproduct_id','title','content','status'))
			   ->where('status',1)
			   ->order('created_time DESC') ;
			   
			$uploadproduct = $read->fetchRow($select);
		}
		Mage::register('uploadproduct', $uploadproduct);
		*/

			
		$this->loadLayout();     
		$this->renderLayout();
    }
}