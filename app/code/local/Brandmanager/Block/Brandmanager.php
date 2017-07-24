<?php
class Ideal_Brandmanager_Block_Brandmanager extends Mage_Core_Block_Template
{
	private $_display = '0';
	
	public function _prepareLayout()	{
		return parent::_prepareLayout();
	}
    
	public function getBrandmanager() { 
		if (!$this->hasData('brandmanager')) {
			$this->setData('brandmanager', Mage::registry('brandmanager'));
		}
		return $this->getData('brandmanager');			
	}
	
	public function setDisplay($display){
		$this->_display = $display;
	}
	
	public function getBrandCollection() {
		$collection = Mage::getModel('brandmanager/brandmanager')->getCollection()
			->addFieldToFilter('status',1)
			->addFieldToFilter('is_home',$this->_display);
		$collection->setOrder('sortno', 'ASC')->load();
			
		if ($this->_display == Ideal_Brandmanager_Helper_Data::DISP_CATEGORY){
			$current_category = Mage::registry('current_category')->getId();
			$collection->addFieldToFilter('categories',array('finset' => $current_category));
		}
		
		$current_store = Mage::app()->getStore()->getId();
		$banners = array();
		foreach ($collection as $banner) {
			$stores = explode(',',$banner->getStores());
			if (in_array(0,$stores) || in_array($current_store,$stores))
			//if ($banner->getStatus())
				$banners[] = $banner;
		}
		return $banners;
	}
	
	public function getDelayTime() {
		$delay = (int) Mage::getStoreConfig('brandmanager/settings/time_delay');
		$delay = $delay * 1000;
		return $delay;
	}
	
	public function isShowDescription(){
		return (int)Mage::getStoreConfig('brandmanager/settings/show_description');
	}
	
	public function getListStyle(){
		return (int)Mage::getStoreConfig('brandmanager/settings/list_style');
	}
	
	public function getImageWidth() {
		return (int)Mage::getStoreConfig('brandmanager/settings/image_width');
	}
	
	public function getImageHeight() {
		return (int)Mage::getStoreConfig('brandmanager/settings/image_height');
	}
}