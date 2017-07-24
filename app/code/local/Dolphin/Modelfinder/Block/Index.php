<?php   
class Dolphin_Modelfinder_Block_Index extends Mage_Core_Block_Template
{   

	public function getcategorylist()
	{
		$categories = Mage::getModel('catalog/category')->getCollection()
		->addAttributeToSelect('*')//or you can just add some attributes
		->addAttributeToFilter('level', 2)//2 is actually the first level
		->addAttributeToFilter('is_active', 1);

		$catelist=array();
		foreach($categories as $category)
		{
			if($category->getId()==15 or $category->getId()==16 ){ continue; }
			//echo "   <br> " . $category->getId().'---'.$category->getName();	
			$catelist[$category->getId()]=$category->getName();
		}


		$cat = Mage::getModel('catalog/category')->load(15);
		$subcats = $cat->getChildren();

		foreach(explode(',',$subcats) as $subCatid)
		{
			$_category = Mage::getModel('catalog/category')->load($subCatid);
			if($_category->getIsActive()) 
			{
				//echo "   <br>bb " . $_category->getId().'---'.$_category->getName();	
				if($_category->getName())
				{	
					$catelist[$_category->getId()]=$_category->getName();
				}	
			}
		}
		asort($catelist);
		return($catelist);
	}



}
