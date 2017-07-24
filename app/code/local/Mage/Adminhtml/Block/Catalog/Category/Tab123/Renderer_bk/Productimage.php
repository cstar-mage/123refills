<?php
class Mage_Adminhtml_Block_Catalog_Category_Tab_Renderer_Productimage extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract {
	
	public function render(Varien_Object $row) {
		$_product = Mage::getModel('catalog/product')->load($row->getId());	
		if($_product->getImage() != 'no_selection'){
			$img_txt = "<img src='".Mage::helper('catalog/image')->init($_product, 'small_image')->resize(150,150)."'/>";
		}else{
			$img_txt = '';
		}
		return $img_txt;
	}
}
?>