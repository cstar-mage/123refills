<?php
class Mage_Image2Product_Block_Adminhtml_Image2Product_Edit_Tab_Renderer_Stepfour extends Varien_Data_Form_Element_Text
{
    /**
     * Override field method to add js
     *
     * @param Varien_Data_Form_Element_Abstract $this
     * @return String
     */
    
	public function getHtml()
    {
    	$html = '<button style="margin: 15px 0;" onclick="window.open(\'/idealAdmin/Image2Product/insertinpopup/\')" class="scalable save" type="button" title="Update Products" id="id_e8668df1ee33b7ca9d5ea949feb31086"><span><span><span>Update Products</span></span></span></button>';
		return $html;       
    }
}