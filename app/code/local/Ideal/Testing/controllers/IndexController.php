<?php
class Ideal_Testing_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
    	
    	/*
    	 * Load an object by id 
    	 * Request looking like:
    	 * http://site.com/testing?id=15 
    	 *  or
    	 * http://site.com/testing/id/15 	
    	 */
    	/* 
		$testing_id = $this->getRequest()->getParam('id');

  		if($testing_id != null && $testing_id != '')	{
			$testing = Mage::getModel('testing/testing')->load($testing_id)->getData();
		} else {
			$testing = null;
		}	
		*/
		
		 /*
    	 * If no param we load a the last created item
    	 */ 
    	/*
    	if($testing == null) {
			$resource = Mage::getSingleton('core/resource');
			$read= $resource->getConnection('core_read');
			$testingTable = $resource->getTableName('testing');
			
			$select = $read->select()
			   ->from($testingTable,array('testing_id','title','content','status'))
			   ->where('status',1)
			   ->order('created_time DESC') ;
			   
			$testing = $read->fetchRow($select);
		}
		Mage::register('testing', $testing);
		*/

			
		$this->loadLayout();     
		$this->renderLayout();
    }
}