<?php
class Ideal_Evolved_Helper_Data extends Mage_Core_Helper_Abstract
{
	public function getThemeConfig()
	{
		//$model = Mage::getModel('evolved/evolved');
		//$collection = $model->getCollection()->addFieldToFilter('value',array('neq' => null));
		// echo "<pre>"; echo "count => ".count($collection->getData())."<br />"; print_r($collection->getData()); exit;
		/** @var Varien_Cache_Core $cache */
	        $SQL="SELECT * FROM `evolved` WHERE `value` IS NOT NULL";
		$write = Mage::getSingleton('core/resource')->getConnection('core_write');
		$results = $write->fetchAll($SQL);

		$evolvedThemeSettings = array();
		foreach($results as $row){
			$evolvedThemeSettings[$row['field']] = $row['value'];
		}

		return $evolvedThemeSettings;
	}

	public function getThemeBlockConfig($type)
	{
		$model = Mage::getModel('evolved/evolved');
		$collection = $model->getCollection()
			->addFieldToFilter('type',array('like' => $type))
			->addFieldToFilter('value',array('neq' => null));
		$theme = array();
		foreach($collection as $row)
		{
			$theme[$row->getData('field')] = $row->getData('value');
		}
//		$SQL="SELECT * FROM `evolved` WHERE `value` IS NOT NULL AND `type` IN ('".$type."')";
//		$write = Mage::getSingleton('core/resource')->getConnection('core_write');
//		$results = $write->fetchAll($SQL);
//
//		$theme = array();
//		foreach($results as $row){
//			$theme[$row['field']] = $row['value'];
//		}
		return $theme;
	}
	public function getContactsTopLinks()
	{
		return $this->_getUrl('contacts/');
	}
	public function getContactsMetaKeywords()
	{
		return Mage::getStoreConfig('evolved/contacts/metakeywords');
	}
	public function getContactsMetaDescription()
	{
		return Mage::getStoreConfig('evolved/contacts/metadescription');
	}
}