<?php
/**
 * @copyright  Copyright (c) 2010 Amasty (http://www.amasty.com)
 */  
class Amasty_Finder_Model_Source_Type extends Varien_Object
{
	public function toOptionArray()
	{
	    $hlp = Mage::helper('amfinder');
		return array(
			array('value' => 0, 'label' => $hlp->__('All finder values are selected')),
			array('value' => 1, 'label' => $hlp->__('At least one finder value is selected')),
		);
	}
}