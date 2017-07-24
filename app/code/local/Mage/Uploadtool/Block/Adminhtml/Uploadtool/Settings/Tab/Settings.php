<?php
 
class Mage_Uploadtool_Block_Adminhtml_Uploadtool_Settings_Tab_Settings extends Mage_Adminhtml_Block_Widget_Form
{
	public function _construct()
	{
		parent::_construct();
		$this->setTemplate('uploadtool/tab/settings.phtml');
	}
}