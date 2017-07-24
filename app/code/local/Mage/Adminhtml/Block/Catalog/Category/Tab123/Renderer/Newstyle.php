<?php
class Mage_Adminhtml_Block_Catalog_Category_Tab_Renderer_Newstyle extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract {
	
	public function render(Varien_Object $row)
	{
		$newstyle = explode(',',$row->getNewstyle());
		$html = "";
		if(count($newstyle)>0)
		{
			$html ="<ul>";
			foreach($newstyle as $value)
			{
				$_productModel = Mage::getModel('catalog/product');
				$attribute = $_productModel->getResource()->getAttribute("newstyle");
				if ($attribute ->usesSource()) {
					$html .= "<li>".$attribute ->getSource()->getOptionText("$value")."</li>";
				}
			}
			$html .= "</ul>";
		}
		return $html ;
	}
}
?>