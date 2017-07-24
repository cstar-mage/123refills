<?php 
class Ideal_Videogallery_Adminhtml_VideogalleryController extends Mage_Adminhtml_Controller_Action
{
	/**
	 * Init here
	 */
	protected function _initAction()
	{
		$this->loadLayout();
		$this->_setActiveMenu('videogallery/videogallery');
		$this->_addBreadcrumb(Mage::helper('videogallery')->__('Videogallery'), Mage::helper('videogallery')->__('Training Video gallery'));
	}
	
	public function indexAction()
	{
		$this->loadLayout();
		$this->renderLayout();
	}
	
	public function knowledgebaseAction()
	{
		$this->loadLayout();
		$this->renderLayout();
	}
	protected function _isAllowed()
    {
    	return Mage::getSingleton('admin/session')->isAllowed('videogallery/videogallery');
    }
}
?>
