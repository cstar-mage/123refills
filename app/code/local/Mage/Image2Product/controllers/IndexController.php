<?php
class Mage_Image2Product_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
    	
    	/*
    	 * Load an object by id 
    	 * Request looking like: 
    	 * http://site.com/Image2Product?id=15 
    	 *  or
    	 * http://site.com/Image2Product/id/15 	
    	 */
    	/*  
		$Image2Product_id = $this->getRequest()->getParam('id'); 

  		if($Image2Product_id != null && $Image2Product_id != '')	{
			$Image2Product = Mage::getModel('Image2Product/Image2Product')->load($Image2Product_id)->getData();
		} else {
			$Image2Product = null;
		}	
		*/
		
		 /*
    	 * If no param we load a the last created item
    	 */ 
    	/*
    	if($Image2Product == null) {
			$resource = Mage::getSingleton('core/resource');
			$read= $resource->getConnection('core_read');
			$Image2ProductTable = $resource->getTableName('Image2Product');
			
			$select = $read->select()
			   ->from($Image2ProductTable,array('Image2Product_id','title','content','status'))
			   ->where('status',1)
			   ->order('created_time DESC') ;
			   
			$Image2Product = $read->fetchRow($select);
		}
		Mage::register('Image2Product', $Image2Product);
		*/

			
		$this->loadLayout();     
		$this->renderLayout();
    }	
}
?>