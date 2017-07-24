<?php
class Dolphin_Customcontactnew_Block_Customcontactnew extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getCustomcontactnew()     
     { 
        if (!$this->hasData('customcontactnew')) {
            $this->setData('customcontactnew', Mage::registry('customcontactnew'));
        }
        return $this->getData('customcontactnew');
        
    }
    public function getFormActionUrl()
    {
    	$url = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB).'customcontactnew/index/post/';
    	return $url;
    
    }
}