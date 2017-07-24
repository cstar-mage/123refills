<?php
class Ideal_Dcevent_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
    	
    	/*
    	 * Load an object by id 
    	 * Request looking like:
    	 * http://site.com/dcevent?id=15 
    	 *  or
    	 * http://site.com/dcevent/id/15 	
    	 */
    	/* 
		$dcevent_id = $this->getRequest()->getParam('id');

  		if($dcevent_id != null && $dcevent_id != '')	{
			$dcevent = Mage::getModel('dcevent/dcevent')->load($dcevent_id)->getData();
		} else {
			$dcevent = null;
		}	
		*/
		
		 /*
    	 * If no param we load a the last created item
    	 */ 
    	/*
    	if($dcevent == null) {
			$resource = Mage::getSingleton('core/resource');
			$read= $resource->getConnection('core_read');
			$dceventTable = $resource->getTableName('dcevent');
			
			$select = $read->select()
			   ->from($dceventTable,array('dcevent_id','title','content','status'))
			   ->where('status',1)
			   ->order('created_time DESC') ;
			   
			$dcevent = $read->fetchRow($select);
		}
		Mage::register('dcevent', $dcevent);
		*/

			
		$this->loadLayout();     
		$this->renderLayout();
    }
	
	public function viewAction()
    {
    	$this->loadLayout();
    	$this->renderLayout();
    }
}