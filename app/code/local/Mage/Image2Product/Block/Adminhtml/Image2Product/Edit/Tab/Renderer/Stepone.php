<?php
class Mage_Image2Product_Block_Adminhtml_Image2Product_Edit_Tab_Renderer_Stepone extends Varien_Data_Form_Element_Text
{
    /**
     * Override field method to add js
     *
     * @param Varien_Data_Form_Element_Abstract $this
     * @return String
     */
    
	public function getHtml()
    {
    	$html = '<label for="remove_images" style="display: block; margin-bottom: 10px;">Remove previous image 2 product images only. this will not affect any existing products</label>';
    	$html .= '<button style="" onclick="confirmSetLocation(\'Are you sure?\',\'/idealAdmin/Image2Product/remove/\')" class="scalable delete" type="button" title="Remove Images" id="id_f93657411b772d988f7517f61c01183d"><span><span><span>Remove Images</span></span></span></button>';
		return $html;       
    }
}