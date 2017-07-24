<?php 
class Mage_Imaclean_Model_Observer {
	
	const XML_PATH_IMACLEAN_ENABLED = 'cronjobs/imaclean/enabled';
	
	public function imageCleanUp() {
		
		if (!Mage::getStoreConfigFlag(self::XML_PATH_IMACLEAN_ENABLED)) {
			return;
		}
		
		Mage::helper('imaclean')->compareList(); // collect imgaes
		
		$collection = Mage::getModel('imaclean/imaclean')->getCollection();
		
		$model = Mage::getModel('imaclean/imaclean');
		foreach ($collection as $imaclean) {
			
			$imacleanId = $imaclean->getId();
			$model->load($imacleanId);
			unlink('media/catalog/product'. $model->getFilename());
			$model->setId($imacleanId)->delete();
		}
		
		return $this;
	}
}
?>