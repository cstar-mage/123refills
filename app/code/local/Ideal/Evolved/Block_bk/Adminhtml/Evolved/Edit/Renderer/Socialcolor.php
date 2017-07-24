<?php
class Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Socialcolor extends Varien_Data_Form_Element_Text
{
    /**
     * Override field method to add js
     *
     * @param Varien_Data_Form_Element_Abstract $this
     * @return String
     */
    public function getHtml()
    {
    	$theme = Mage::helper('evolved')->getThemeConfig();
    	if($theme['social_color_deg']=="")
    	{
    		$theme['social_color_deg']=0;
    	}
    	if($theme['social_color_saturate_deg']=="")
    	{
    		$theme['social_color_saturate_deg']=1;
    	}
    	if($theme['social_color_brightness_deg']=="")
    	{
    		$theme['social_color_brightness_deg']=1;
    	}
    	$str .= '<tr class="socialcolorrow huerotateslider">';
		$str .= '<td class="label"><label for="social_color" style="margin-top: 5px; ">Hue-rotate Color:</label></td>';
		$str .= '<td class="value">';
		$str .= '<div class="color-scroll" style="float: left; margin: 5px 0 0 0; width: 230px;"><div id="slider"></div></div><input type="text" name="social_color_deg" value="'.$theme['social_color_deg'].'" id="social_color_deg" value="" style="float: left; margin-left: 10px; width: 35px;" />';
		$str .= '</td>';
		$str .= '</tr>';
		
		$str .= '<tr class="socialcolorrow saturateslider">';
		$str .= '<td class="label"><label for="social_color_saturate" style="margin-top: 5px; ">Saturate Color:</label></td>';
		$str .= '<td class="value">';
		$str .= '<div class="color-scroll" style="float: left; margin: 5px 0 0 0; width: 230px;"><div id="social_color_saturate_slider"></div></div><input type="text" name="social_color_saturate_deg" value="'.$theme['social_color_saturate_deg'].'" id="social_color_saturate_deg" value="" style="float: left; margin-left: 10px; width: 35px;" />';
		$str .= '</td>';
		$str .= '</tr>';
		
		$str .= '<tr class="socialcolorrow brightness">';
		$str .= '<td class="label"><label for="social_color_brightness" style="margin-top: 5px; ">Brightness Color:</label></td>';
		$str .= '<td class="value">';
		$str .= '<div class="color-scroll" style="float: left; margin: 5px 0 0 0; width: 230px;"><div id="social_color_brightness_slider"></div></div><input type="text" name="social_color_brightness_deg" value="'.$theme['social_color_brightness_deg'].'" id="social_color_brightness_deg" value="" style="float: left; margin-left: 10px; width: 35px;" />';
		$str .= '</td>';
		$str .= '</tr>';

        return $str;
        
    }
}