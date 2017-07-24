<?php
class Ideal_Diamondrequest_Block_Diamondrequest extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getCustomcontactnew()     
     { 
        if (!$this->hasData('diamondrequest')) {
            $this->setData('diamondrequest', Mage::registry('diamondrequest'));
        }
        return $this->getData('diamondrequest');
        
    }
    public function getFormActionUrl()
    {
    	$url = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB).'diamondrequest/index/post/';
    	return $url;
    
    }
}