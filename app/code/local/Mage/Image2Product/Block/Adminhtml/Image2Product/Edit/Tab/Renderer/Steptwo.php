<?php
class Mage_Image2Product_Block_Adminhtml_Image2Product_Edit_Tab_Renderer_Steptwo extends Varien_Data_Form_Element_Text
{
    /**
     * Override field method to add js
     *
     * @param Varien_Data_Form_Element_Abstract $this
     * @return String
     */
    
	public function getHtml()
    {
    	$html = '<label for="upload_zip" style="display: block; margin: 5px 0;">Images should be saved for web approx 650px * 650px</label>';
    	$html .= '<input type="file" value="" name="zipfile" id="zipfile" style=" width: 205px; margin-left: -1px; ">(.zip Format Only)';
    	$html .= '<button style="display: block; margin-top: 5px;" onclick="editForm.submit();" class="scalable save" type="button" title="Save"><span><span><span>Save</span></span></span></button>';
		return $html;       
    }
}