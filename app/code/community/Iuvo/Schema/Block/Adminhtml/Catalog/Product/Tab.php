<?php
class Iuvo_Schema_Block_Adminhtml_Catalog_Product_Tab 
extends Mage_Adminhtml_Block_Template
implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
	public function __construct(){
		$this->setTemplate('iuvo/catalog/product/tab.phtml');
		parent::__construct();
	}

	public function getTabLabel(){
		return Mage::helper('core')->__('Custom Tab');
	}
	
	public function getTabTitle(){
		return Mage::helper('core')->__('Custom Tab');
	}
	
	public function canShowTab(){
		return true;
	}
	
	public function isHidden(){
		return false;
	}
}