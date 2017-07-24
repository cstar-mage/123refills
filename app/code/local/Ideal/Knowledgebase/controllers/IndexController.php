<?php
class Ideal_Knowledgebase_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
    	
    	/*
    	 * Load an object by id 
    	 * Request looking like:
    	 * http://site.com/knowledgebase?id=15 
    	 *  or
    	 * http://site.com/knowledgebase/id/15 	
    	 */
    	/* 
		$knowledgebase_id = $this->getRequest()->getParam('id');

  		if($knowledgebase_id != null && $knowledgebase_id != '')	{
			$knowledgebase = Mage::getModel('knowledgebase/knowledgebase')->load($knowledgebase_id)->getData();
		} else {
			$knowledgebase = null;
		}	
		*/
		
		 /*
    	 * If no param we load a the last created item
    	 */ 
    	/*
    	if($knowledgebase == null) {
			$resource = Mage::getSingleton('core/resource');
			$read= $resource->getConnection('core_read');
			$knowledgebaseTable = $resource->getTableName('knowledgebase');
			
			$select = $read->select()
			   ->from($knowledgebaseTable,array('knowledgebase_id','title','content','status'))
			   ->where('status',1)
			   ->order('created_time DESC') ;
			   
			$knowledgebase = $read->fetchRow($select);
		}
		Mage::register('knowledgebase', $knowledgebase);
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