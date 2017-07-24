<?php
 
class Mage_Uploadtool_Block_Adminhtml_Uploadtool_Edit_Tab_Google extends Mage_Adminhtml_Block_Widget_Form
{
	public function _construct()
	{
		parent::_construct();
		$this->setTemplate('uploadtool/tab/google.phtml');
	}
}
