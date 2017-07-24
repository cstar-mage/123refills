<?php
class Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Elementten extends Varien_Data_Form_Element_Text
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
        //$html = parent::getHtml();
    	$model = Mage::getModel('evolved/evolved');
    	$collection = $model->getCollection();
    	foreach ($collection as $collection_arr)
    	{
//    		echo $collection_arr['field']."   value: ".$collection_arr['value']."<br />";
    		$collectiondata[$collection_arr['field']] = $collection_arr['value'];
    	}
    	/*echo "<pre>";
    	print_r($collectiondata);
    	exit;*/
    	//print_r($model->getData('homepage_element_ten_style_title_one'));
    	$homepage_element_ten_style = $collectiondata['homepage_element_ten_style'];
    	
    	$elementstyle['narrow_banner_full_width'] = 'Narrow Banner_Full-width';
    	$elementstyle['tall_banner_full_width'] = 'Tall Banner_Full-width';
    	$elementstyle['30_70_boxes_full_width'] = '30-70 Boxes_Full-width';
    	$elementstyle['70_30_boxes_full_width'] = '70-30 Boxes_Full-width';
    	
    	if($collectiondata['homepage_element_ten_style'])
    	{    	$homepage_element_ten_style = $collectiondata['homepage_element_ten_style'];	}
    	
    	$homepage_element_ten_style_sortorder = $collectiondata['homepage_element_ten_style_sortorder'];
    	
    	$homepage_element_ten_style_title_one_up = $collectiondata['homepage_element_ten_style_title_one_up'];
    	$homepage_element_ten_style_link_one_up = $collectiondata['homepage_element_ten_style_link_one_up'];
    	$homepage_element_ten_style_image_one_up = $collectiondata['homepage_element_ten_style_image_one_up'];
    	
    	$homepage_element_ten_style_title_one_down = $collectiondata['homepage_element_ten_style_title_one_down'];
    	$homepage_element_ten_style_link_one_down = $collectiondata['homepage_element_ten_style_link_one_down'];
    	$homepage_element_ten_style_image_one_down = $collectiondata['homepage_element_ten_style_image_one_down'];
    	
    	$homepage_element_ten_style_title_two = $collectiondata['homepage_element_ten_style_title_two'];
    	$homepage_element_ten_style_link_two = $collectiondata['homepage_element_ten_style_link_two'];
    	$homepage_element_ten_style_image_two = $collectiondata['homepage_element_ten_style_image_two'];
    	
    	$homepage_element_ten_style_title_three_up = $collectiondata['homepage_element_ten_style_title_three_up'];
    	$homepage_element_ten_style_link_three_up = $collectiondata['homepage_element_ten_style_link_three_up'];
    	$homepage_element_ten_style_image_three_up = $collectiondata['homepage_element_ten_style_image_three_up'];
    	 
    	$homepage_element_ten_style_title_three_down = $collectiondata['homepage_element_ten_style_title_three_down'];
    	$homepage_element_ten_style_link_three_down = $collectiondata['homepage_element_ten_style_link_three_down'];
    	$homepage_element_ten_style_image_three_down = $collectiondata['homepage_element_ten_style_image_three_down'];
    	
    	$html = '<table cellspacing="0" class="form-list">';
    	$html .= '<tbody>';
    	$html .= '<tr>';
    	$html .= '<td class="label" style="width: 130px;"><label for="homepage_element_ten_style" style="width: 115px;">Page Element Style:</label></td>';
    	$html .= '<td class="value">';
    	$html .= '<select class=" select" name="homepage_element_ten_style" id="homepage_element_ten_style">';
    	foreach($elementstyle as $elementstyle_key=>$elementstyle_value)
    	{
    		if($homepage_element_ten_style == $elementstyle_key)
    		{
    			$html .= '<option value="'.$elementstyle_key.'" selected="selected">'.$elementstyle_value.'</option>';
    		}
    		else 
    		{
    			$html .= '<option value="'.$elementstyle_key.'">'.$elementstyle_value.'</option>';
    		}
    		
    	}
    
    	$html .= '</select> ';
    	$html .= '</td>';
    	//$html .= '<td class="label" style="width: 90px;"><label for="homepage_element_ten_style_sortorder" style="width: 75px;">Sort order:</label></td>';
    	//$html .= '<td class="value">';
    	//$html .= '<input type="text" class=" input-text" style="width:50px;" value="'.$homepage_element_ten_style_sortorder.'" name="homepage_element_ten_style_sortorder" id="homepage_element_ten_style_sortorder">';
    	//$html .= '</td>';
    	$html .= '</tr>';
    	$html .= '</tbody>';
    	$html .= '</table>';
    	
    	//exit;
    	
    	$html .= '<table cellspacing="0" class="form-list" style="display: table-cell;">';
    	$html .= '<tbody>';
    	$html .= '<tr>';
    	$html .= '<td class="label"><label for="homepage_element_ten_style_title_one_up" style="width: 29px;">Title:</label></td>';
    	$html .= '<td class="value">';
    	$html .= '<input type="text" class=" input-text" value="'.$homepage_element_ten_style_title_one_up.'" name="homepage_element_ten_style_title_one_up" id="homepage_element_ten_style_title_one_up">';
    	$html .= '</td>';
    	$html .= '</tr>';
    	$html .= '<tr>';
    	$html .= '<td class="label"><label for="homepage_element_ten_style_link_one_up" style="width: 29px;">Link:</label></td>';
    	$html .= '<td class="value">';
    	$html .= '<input type="text" class=" input-text" value="'.$homepage_element_ten_style_link_one_up.'" name="homepage_element_ten_style_link_one_up" id="homepage_element_ten_style_link_one_up">';
    	$html .= '</td>';
    	$html .= '</tr>';
    	$html .= '<tr>';
    	$html .= '<td class="label"><label for="homepage_element_ten_style_image_one_up" style="width: 29px;">Image:</label></td>';
    	$html .= '<td class="value">';
    	$html .= '<div class="buttons-set" id="buttonshomepage_element_ten_style_image_one_up"><button id="togglehomepage_element_ten_style_image_one_up" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><button style="" onclick="widgetTools.openDialog("http://www.jewelrydemo.com/index.php/evolved/widget/index/widget_target_id/homepage_element_ten_style_image_one_up")" class="scalable add-widget plugin" type="button"><span><span><span>Insert Widget...</span></span></span></button><button style="" onclick="MediabrowserUtility.openDialog("http://www.jewelrydemo.com/index.php/idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_ten_style_image_one_up/")" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button><button onclick="MagentovariablePlugin.loadChooser("http://www.jewelrydemo.com/index.php/evolved/system_variable/wysiwygPlugin/", "homepage_element_ten_style_image_one_up");" class="scalable add-variable plugin" type="button"><span><span><span>Insert Variable...</span></span></span></button></div><textarea cols="15" rows="2" style="height:50px;" class="textarea " id="homepage_element_ten_style_image_one_up" title="" name="homepage_element_ten_style_image_one_up">'.$homepage_element_ten_style_image_one_up.'</textarea>';
    	$html .= '<script type="text/javascript">
    	//&lt;![CDATA[
    	openEditorPopup = function(url, name, specs, parent) {
    	if ((typeof popups == "undefined") || popups[name] == undefined || popups[name].closed) {
    	if (typeof popups == "undefined") {
    	popups = new Array();
    	}
    	var opener = (parent != undefined ? parent : window);
    	popups[name] = opener.open(url, name, specs);
    	} else {
    	popups[name].focus();
    	}
    	return popups[name];
    	}
    	
    	closeEditorPopup = function(name) {
    	if ((typeof popups != "undefined") && popups[name] != undefined && !popups[name].closed) {
    	popups[name].close();
    	}
    	}
    	//]]&gt;
    	</script>';
    	$html .= '<small>Image size must be 346*170 pixels</small>';
    	$html .= '</td>';
    	$html .= '</tr>';
    	
    	$html .= '<tr>';
    	$html .= '<td class="label"><label for="homepage_element_ten_style_title_one_down" style="width: 29px;">Title:</label></td>';
    	$html .= '<td class="value">';
    	$html .= '<input type="text" class=" input-text" value="'.$homepage_element_ten_style_title_one_down.'" name="homepage_element_ten_style_title_one_down" id="homepage_element_ten_style_title_one_down">';
    	$html .= '</td>';
    	$html .= '</tr>';
    	$html .= '<tr>';
    	$html .= '<td class="label"><label for="homepage_element_ten_style_link_one_down" style="width: 29px;">Link:</label></td>';
    	$html .= '<td class="value">';
    	$html .= '<input type="text" class=" input-text" value="'.$homepage_element_ten_style_link_one_down.'" name="homepage_element_ten_style_link_one_down" id="homepage_element_ten_style_link_one_down">';
    	$html .= '</td>';
    	$html .= '</tr>';
    	$html .= '<tr>';
    	$html .= '<td class="label"><label for="homepage_element_ten_style_image_one_down" style="width: 29px;">Image:</label></td>';
    	$html .= '<td class="value">';
    	$html .= '<div class="buttons-set" id="buttonshomepage_element_ten_style_image_one_down"><button id="togglehomepage_element_ten_style_image_one_down" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><button style="" onclick="widgetTools.openDialog("http://www.jewelrydemo.com/index.php/evolved/widget/index/widget_target_id/homepage_element_ten_style_image_one_down")" class="scalable add-widget plugin" type="button"><span><span><span>Insert Widget...</span></span></span></button><button style="" onclick="MediabrowserUtility.openDialog("http://www.jewelrydemo.com/index.php/idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_ten_style_image_one_down/")" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button><button onclick="MagentovariablePlugin.loadChooser("http://www.jewelrydemo.com/index.php/evolved/system_variable/wysiwygPlugin/", "homepage_element_ten_style_image_one_down");" class="scalable add-variable plugin" type="button"><span><span><span>Insert Variable...</span></span></span></button></div><textarea cols="15" rows="2" style="height:50px;" class="textarea " id="homepage_element_ten_style_image_one_down" title="" name="homepage_element_ten_style_image_one_down">'.$homepage_element_ten_style_image_one_down.'</textarea>';
    	$html .= '<script type="text/javascript">
    	//&lt;![CDATA[
    	openEditorPopup = function(url, name, specs, parent) {
    	if ((typeof popups == "undefined") || popups[name] == undefined || popups[name].closed) {
    	if (typeof popups == "undefined") {
    	popups = new Array();
    	}
    	var opener = (parent != undefined ? parent : window);
    	popups[name] = opener.open(url, name, specs);
    	} else {
    	popups[name].focus();
    	}
    	return popups[name];
    	}
    	 
    	closeEditorPopup = function(name) {
    	if ((typeof popups != "undefined") && popups[name] != undefined && !popups[name].closed) {
    	popups[name].close();
    	}
    	}
    	//]]&gt;
    	</script>';
    	$html .= '<small>Image size must be 346*170 pixels</small>';
    	$html .= '</td>';
    	$html .= '</tr>';
    	
    	$html .= '</tbody>';
    	$html .= '</table>';
    	
    	$html .= '<table cellspacing="0" class="form-list"  style="display: table-cell;" >';
    	$html .= '<tbody>';
    	$html .= '<tr>';
    	$html .= '<td class="label"><label for="homepage_element_ten_style_title_two" style="width: 29px;">Title:</label></td>';
    	$html .= '<td class="value">';
    	$html .= '<input type="text" class=" input-text" value="'.$homepage_element_ten_style_title_two.'" name="homepage_element_ten_style_title_two" id="homepage_element_ten_style_title_two">';
    	$html .= '</td>';
    	$html .= '</tr>';
    	$html .= '<tr>';
    	$html .= '<td class="label"><label for="homepage_element_ten_style_link_two" style="width: 29px;">Link:</label></td>';
    	$html .= '<td class="value">';
    	$html .= '<input type="text" class=" input-text" value="'.$homepage_element_ten_style_link_two.'" name="homepage_element_ten_style_link_two" id="homepage_element_ten_style_link_two">';
    	$html .= '</td>';
    	$html .= '</tr>';
    	$html .= '<tr>';
    	$html .= '<td class="label"><label for="homepage_element_ten_style_image_two" style="width: 29px;">Image:</label></td>';
    	$html .= '<td class="value">';
    	$html .= '<div class="buttons-set" id="buttonshomepage_element_ten_style_image_two"><button id="togglehomepage_element_ten_style_image_two" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><button style="" onclick="widgetTools.openDialog(http://www.jewelrydemo.com/index.php/evolved/widget/index/widget_target_id/homepage_element_ten_style_image_two)" class="scalable add-widget plugin" type="button"><span><span><span>Insert Widget...</span></span></span></button><button style="" onclick="MediabrowserUtility.openDialog(http://www.jewelrydemo.com/index.php/idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_ten_style_image_two/)" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button><button onclick="MagentovariablePlugin.loadChooser(http://www.jewelrydemo.com/index.php/evolved/system_variable/wysiwygPlugin/, "homepage_element_ten_style_image_two");" class="scalable add-variable plugin" type="button"><span><span><span>Insert Variable...</span></span></span></button></div><textarea cols="15" rows="2" style="height:50px;" class="textarea " id="homepage_element_ten_style_image_two" title="" name="homepage_element_ten_style_image_two">'.$homepage_element_ten_style_image_two.'</textarea>';
    	$html .= '<script type="text/javascript">
    	
    	openEditorPopup = function(url, name, specs, parent) {
    	if ((typeof popups == "undefined") || popups[name] == undefined || popups[name].closed) {
    	if (typeof popups == "undefined") {
    	popups = new Array();
    	}
    	var opener = (parent != undefined ? parent : window);
    	popups[name] = opener.open(url, name, specs);
    	} else {
    	popups[name].focus();
    	}
    	return popups[name];
    	}
    	
    	closeEditorPopup = function(name) {
    	if ((typeof popups != "undefined") && popups[name] != undefined && !popups[name].closed) {
    	popups[name].close();
    	}
    	}
    	
    	</script>';
    	$html .= '<small>Image size must be 346*346 pixels</small>';
    	$html .= '</td>';
    	$html .= '</tr>';
    	$html .= '</tbody>';
    	$html .= '</table>';
    	
    	
    	$html .= '<table cellspacing="0" class="form-list" style="display: table-cell;">';
    	$html .= '<tbody>';
    	$html .= '<tr>';
    	$html .= '<td class="label"><label for="homepage_element_ten_style_title_three_up" style="width: 29px;">Title:</label></td>';
    	$html .= '<td class="value">';
    	$html .= '<input type="text" class=" input-text" value="'.$homepage_element_ten_style_title_three_up.'" name="homepage_element_ten_style_title_three_up" id="homepage_element_ten_style_title_three_up">';
    	$html .= '</td>';
    	$html .= '</tr>';
    	$html .= '<tr>';
    	$html .= '<td class="label"><label for="homepage_element_ten_style_link_three_up" style="width: 29px;">Link:</label></td>';
    	$html .= '<td class="value">';
    	$html .= '<input type="text" class=" input-text" value="'.$homepage_element_ten_style_link_three_up.'" name="homepage_element_ten_style_link_three_up" id="homepage_element_ten_style_link_three_up">';
    	$html .= '</td>';
    	$html .= '</tr>';
    	$html .= '<tr>';
    	$html .= '<td class="label"><label for="homepage_element_ten_style_image_three_up" style="width: 29px;">Image:</label></td>';
    	$html .= '<td class="value">';
    	$html .= '<div class="buttons-set" id="buttonshomepage_element_ten_style_image_three_up"><button id="togglehomepage_element_ten_style_image_three_up" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><button style="" onclick="widgetTools.openDialog("http://www.jewelrydemo.com/index.php/evolved/widget/index/widget_target_id/homepage_element_ten_style_image_three_up")" class="scalable add-widget plugin" type="button"><span><span><span>Insert Widget...</span></span></span></button><button style="" onclick="MediabrowserUtility.openDialog("http://www.jewelrydemo.com/index.php/idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_ten_style_image_three_up/")" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button><button onclick="MagentovariablePlugin.loadChooser("http://www.jewelrydemo.com/index.php/evolved/system_variable/wysiwygPlugin/", "homepage_element_ten_style_image_three_up");" class="scalable add-variable plugin" type="button"><span><span><span>Insert Variable...</span></span></span></button></div><textarea cols="15" rows="2" style="height:50px;" class="textarea " id="homepage_element_ten_style_image_three_up" title="" name="homepage_element_ten_style_image_three_up">'.$homepage_element_ten_style_image_three_up.'</textarea>';
    	$html .= '<script type="text/javascript">
    	//&lt;![CDATA[
    	openEditorPopup = function(url, name, specs, parent) {
    	if ((typeof popups == "undefined") || popups[name] == undefined || popups[name].closed) {
    	if (typeof popups == "undefined") {
    	popups = new Array();
    	}
    	var opener = (parent != undefined ? parent : window);
    	popups[name] = opener.open(url, name, specs);
    	} else {
    	popups[name].focus();
    	}
    	return popups[name];
    	}
    	 
    	closeEditorPopup = function(name) {
    	if ((typeof popups != "undefined") && popups[name] != undefined && !popups[name].closed) {
    	popups[name].close();
    	}
    	}
    	//]]&gt;
    	</script>';
    	$html .= '<small>Image size must be 346*170 pixels</small>';
    	$html .= '</td>';
    	$html .= '</tr>';
    	 
    	$html .= '<tr>';
    	$html .= '<td class="label"><label for="homepage_element_ten_style_title_three_down" style="width: 29px;">Title:</label></td>';
    	$html .= '<td class="value">';
    	$html .= '<input type="text" class=" input-text" value="'.$homepage_element_ten_style_title_three_down.'" name="homepage_element_ten_style_title_three_down" id="homepage_element_ten_style_title_three_down">';
    	$html .= '</td>';
    	$html .= '</tr>';
    	$html .= '<tr>';
    	$html .= '<td class="label"><label for="homepage_element_ten_style_link_three_down" style="width: 29px;">Link:</label></td>';
    	$html .= '<td class="value">';
    	$html .= '<input type="text" class=" input-text" value="'.$homepage_element_ten_style_link_three_down.'" name="homepage_element_ten_style_link_three_down" id="homepage_element_ten_style_link_three_down">';
    	$html .= '</td>';
    	$html .= '</tr>';
    	$html .= '<tr>';
    	$html .= '<td class="label"><label for="homepage_element_ten_style_image_three_down" style="width: 29px;">Image:</label></td>';
    	$html .= '<td class="value">';
    	$html .= '<div class="buttons-set" id="buttonshomepage_element_ten_style_image_three_down"><button id="togglehomepage_element_ten_style_image_three_down" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><button style="" onclick="widgetTools.openDialog("http://www.jewelrydemo.com/index.php/evolved/widget/index/widget_target_id/homepage_element_ten_style_image_three_down")" class="scalable add-widget plugin" type="button"><span><span><span>Insert Widget...</span></span></span></button><button style="" onclick="MediabrowserUtility.openDialog("http://www.jewelrydemo.com/index.php/idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_ten_style_image_three_down/")" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button><button onclick="MagentovariablePlugin.loadChooser("http://www.jewelrydemo.com/index.php/evolved/system_variable/wysiwygPlugin/", "homepage_element_ten_style_image_three_down");" class="scalable add-variable plugin" type="button"><span><span><span>Insert Variable...</span></span></span></button></div><textarea cols="15" rows="2" style="height:50px;" class="textarea " id="homepage_element_ten_style_image_three_down" title="" name="homepage_element_ten_style_image_three_down">'.$homepage_element_ten_style_image_three_down.'</textarea>';
    	$html .= '<script type="text/javascript">
    	//&lt;![CDATA[
    	openEditorPopup = function(url, name, specs, parent) {
    	if ((typeof popups == "undefined") || popups[name] == undefined || popups[name].closed) {
    	if (typeof popups == "undefined") {
    	popups = new Array();
    	}
    	var opener = (parent != undefined ? parent : window);
    	popups[name] = opener.open(url, name, specs);
    	} else {
    	popups[name].focus();
    	}
    	return popups[name];
    	}
    	
    	closeEditorPopup = function(name) {
    	if ((typeof popups != "undefined") && popups[name] != undefined && !popups[name].closed) {
    	popups[name].close();
    	}
    	}
    	//]]&gt;
    	</script>';
    	$html .= '<small>Image size must be 346*170 pixels</small>';
    	$html .= '</td>';
    	$html .= '</tr>';
    	 
    	$html .= '</tbody>';
    	$html .= '</table>';
    	
    	return $html;
        
    }
}