<?php
class Ideal_Diamondsearch_Block_Adminhtml_Diamondsearch_Edit_Renderer_Color extends Varien_Data_Form_Element_Text
{
    /**
     * Override field method to add js
     *
     * @param Varien_Data_Form_Element_Abstract $this
     * @return String
     */
		
    public function getHtml()
    {
        // Get the default HTML for this option
        $html = parent::getHtml();
		
        if ( !Mage::registry('mColorPicker') ) {
        	$html .= '
        	<script type="text/javascript">
        	jQuery.fn.mColorPicker.init.replace = false;
        	jQuery.fn.mColorPicker.init.enhancedSwatches = false;
        	jQuery.fn.mColorPicker.init.allowTransparency = true;
        	jQuery.fn.mColorPicker.init.showLogo = false;
        	jQuery.fn.mColorPicker.defaults.imageFolder = "'.Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_JS).'evolved/mColorPicker/";
        	</script>
        	';
        	Mage::register('mColorPicker', 1);
        }
        $html .= '
        <script type="text/javascript">
        jQuery(function($){
        $("#'.$this->getHtmlId().'").attr("data-hex", true).mColorPicker();
        });
        </script>
        ';
        return $html;
        
    }
}