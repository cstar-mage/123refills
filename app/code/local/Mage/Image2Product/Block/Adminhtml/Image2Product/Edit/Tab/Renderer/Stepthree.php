<?php
class Mage_Image2Product_Block_Adminhtml_Image2Product_Edit_Tab_Renderer_Stepthree extends Varien_Data_Form_Element_Text
{
    /**
     * Override field method to add js
     *
     * @param Varien_Data_Form_Element_Abstract $this
     * @return String
     */
    
	public function getHtml()
    {
    	$html = '<label for="generate_csv" style="display: block; margin-bottom: 10px;">The data will be generic but this step creates the minimum information to create products. You do not need to download csv</label>';
    	$html .= '<button style="" onclick="setLocation(\'/idealAdmin/Image2Product/generatecsv/\')" class="scalable save" type="button" title="Generate CSV" id="id_1b914854b2924f875489e730998bcd92"><span><span><span>Generate CSV</span></span></span></button>';
		return $html;       
    }
}