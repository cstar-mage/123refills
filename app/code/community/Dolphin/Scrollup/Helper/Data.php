<?php
class Dolphin_Scrollup_Helper_Data extends Mage_Core_Helper_Abstract
{
	public function getConfig($path = "design/scrollup")
	{
		$store = Mage::app()->getStore()->getId();
		return Mage::getStoreConfig($path,$store);
	}
	public function isEnabled()
	{
		return $this->getConfig('design/scrollup/enabled');
	}
} 
?>