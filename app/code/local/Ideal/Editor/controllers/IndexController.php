<?php
class Ideal_Editor_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
    	
    	/*
    	 * Load an object by id 
    	 * Request looking like:
    	 * http://site.com/editor?id=15 
    	 *  or
    	 * http://site.com/editor/id/15 	
    	 */
    	/* 
		$editor_id = $this->getRequest()->getParam('id');

  		if($editor_id != null && $editor_id != '')	{
			$editor = Mage::getModel('editor/editor')->load($editor_id)->getData();
		} else {
			$editor = null;
		}	
		*/
		
		 /*
    	 * If no param we load a the last created item
    	 */ 
    	/*
    	if($editor == null) {
			$resource = Mage::getSingleton('core/resource');
			$read= $resource->getConnection('core_read');
			$editorTable = $resource->getTableName('editor');
			
			$select = $read->select()
			   ->from($editorTable,array('editor_id','title','content','status'))
			   ->where('status',1)
			   ->order('created_time DESC') ;
			   
			$editor = $read->fetchRow($select);
		}
		Mage::register('editor', $editor);
		*/

			
		$this->loadLayout();     
		$this->renderLayout();
    }
}