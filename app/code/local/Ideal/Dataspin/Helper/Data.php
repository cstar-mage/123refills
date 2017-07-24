<?php

class Ideal_Dataspin_Helper_Data extends Mage_Core_Helper_Abstract
{

	public function getDataSpinValues($field) {
		
		$collection = Mage::getModel('dataspin/dataspin')->getCollection();
		if(isset($field) && $field != "") {
			$collection->addFieldToFilter('field',$field)->getFirstItem();
			//echo "<pre>"; print_r($collection->getData()); exit;
			$item = $collection->getData();
			return $item[0]['value'];
		}
		
		$items = array();
		foreach ($collection as $row) {
			$items[$row['field']] = $row['value'];
		}
		
		return $items;
	}
	
	public function getInbetweenStrings($start, $end, $str){
		$matches = array();
		$regex = "/$start([a-zA-Z0-9_]*)$end/";
		preg_match_all($regex, $str, $matches);
		return $matches[1];
	}
}