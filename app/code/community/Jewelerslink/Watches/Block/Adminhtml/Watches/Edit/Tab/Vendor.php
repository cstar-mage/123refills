<?php
 
class Jewelerslink_Watches_Block_Adminhtml_Watches_Edit_Tab_Vendor extends Mage_Adminhtml_Block_Widget_Form
{
	public function _construct()
	{
		parent::_construct();
		$this->setTemplate('watches/tab/vendor.phtml');
	}
}