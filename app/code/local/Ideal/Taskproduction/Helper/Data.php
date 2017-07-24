<?php

class Ideal_Taskproduction_Helper_Data extends Mage_Core_Helper_Abstract
{
	public function getPageLimit()
	{
		if(strpos(Mage::getUrl('*/*/grid', array('_current'=>true)), '/limit/') !== false)
		{
			$urlexploderow = explode('/limit/',Mage::getUrl('*/*/grid', array('_current'=>true)));
			$urlexplodelimitrow = explode('/',$urlexploderow[1]);
			$limit = $urlexplodelimitrow[0];
		}
		else
		{
			$limit = 20;
		}
		return $limit;
	}
	
	public function getCurrentPage()
	{
		if (strpos ( Mage::getUrl ( '*/*/grid', array ('_current' => true ) ), '/page/' ) !== false) {
			$urlexploderowpage = explode ( '/page/', Mage::getUrl ( '*/*/grid', array ('_current' => true ) ) );
			$urlexplodelimitrowpage = explode ( '/', $urlexploderowpage [1] );
			$currentpage = $urlexplodelimitrowpage [0];
		} else {
			$currentpage = 1;
		}
		return $currentpage;
	}
	
	public function getRequestParamsPage()
	{
		if(strpos(Mage::getUrl('*/*/grid', array('_current'=>true)), '/sort/') !== false)
		{ 
			$urlexplode = explode('/sort/',Mage::getUrl('*/*/grid', array('_current'=>true)));
			$urlexplodesort = explode('/',$urlexplode[1]);
			$paramsfield['siteurl'] = str_replace("www.","",$_SERVER['HTTP_HOST']);
			$paramsfield['column'] = $urlexplodesort[0];
			$paramsfield['dir'] = $urlexplodesort[2]; 
		}
		else {
			$paramsfield['siteurl'] = str_replace("www.","",$_SERVER['HTTP_HOST']);
			$paramsfield['column'] = 'task_id';
			$paramsfield['dir'] = 'asc'; 
		}
		return $paramsfield;
	}
	
}