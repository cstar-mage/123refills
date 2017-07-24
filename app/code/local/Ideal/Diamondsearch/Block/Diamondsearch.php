<?php
class Ideal_Diamondsearch_Block_Diamondsearch extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getDiamondsearch()     
     { 
        if (!$this->hasData('diamondsearch')) {
            $this->setData('diamondsearch', Mage::registry('diamondsearch'));
        }
        return $this->getData('diamondsearch');
        
    }
    
    public function getImage($productimage)
    {
		$url=Mage::getBaseDir('media');
		if (!file_exists($url.'/dsearch/shape')) 	{    mkdir($url.'dsearch/shape', 0777, true);}
		$url=$url.'/dsearch/shape/'.basename($productimage);
		file_put_contents($url, file_get_contents($productimage));
		$resizeImage=Mage::helper('diamondsearch')->resizeImage(basename($productimage),270,270, 'dsearch/shape');	
		return $resizeImage;
	}
}
