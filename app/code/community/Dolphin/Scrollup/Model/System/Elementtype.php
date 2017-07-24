<?php
class Dolphin_Scrollup_Model_System_Elementtype
{
	public function toOptionArray()
	{
		return array(
				array('value' => 'image', 'label'=>Mage::helper('dlscrollup')->__('Image')),
				array('value' => 'pill', 'label'=>Mage::helper('dlscrollup')->__('Pill')),
				array('value' => 'tab', 'label'=>Mage::helper('dlscrollup')->__('Tab')),
				array('value' => 'link', 'label'=>Mage::helper('dlscrollup')->__('Link')),
		);
	}
} 
?>