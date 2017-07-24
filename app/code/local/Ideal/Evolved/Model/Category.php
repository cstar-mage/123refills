<?php 
class Ideal_Evolved_Model_Category
{
    public function toOptionArray()
    {
	    $categories = Mage::getModel('catalog/category')
                ->getCollection()
                ->addAttributeToSelect('*')
	    		->addAttributeToFilter('level',array('gt'=>1));
                //->addIsActiveFilter();
	     
                //echo count($categories); exit;

	    $all = array();
	    foreach ($categories as $c) {
	    	$all[$c->getId()] = $c->getName();
	    }
	    return $all;
    }
    
    public function toCategoryOptionArray()
    {
    	$categories = Mage::getModel('catalog/category')
    	->getCollection()
    	->addAttributeToSelect('*')
    	->addAttributeToFilter('level',array('gt'=>1));
    	//->addIsActiveFilter();
    
    	//echo count($categories); exit;
    
    	$all = array();
    	$all[] = array('value'=>'', 'label' => 'Please Select');
    	foreach ($categories as $c) {
    		//$all[][$c->getId()] = $c->getName();
    		$all[] = array('value'=>$c->getId().strtolower(str_replace(" ","-","-".$c->getName())), 'label' => $c->getName());
    	}
    	
    	return $all;
    }

}
