<?php
class MageWorx_Adminhtml_Block_Customoptions_Options_Edit_Tab_Renderer_Thumbnail extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract {
	
	public function render(Varien_Object $row) {
		$_product = Mage::getModel('catalog/product')->load($row->getId());	
		if($_product->getImage() == ""){
			return '';
		}else{
			$val = str_replace("no_selection", "", $_product->getImage());
			if($val == ''){
				$img_txt = '';
			}else{
				$img_txt = "<img src='".Mage::helper('catalog/image')->init($_product, 'small_image')->resize(100,100)."'/>";
				//$img_txt = 'else else';
			}
			return $img_txt;
		}		
		
	}
}
?>