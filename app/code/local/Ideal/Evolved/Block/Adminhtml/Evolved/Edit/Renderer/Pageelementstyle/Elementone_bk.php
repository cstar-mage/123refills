<?php
class Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Pageelementstyle_Elementone extends Varien_Data_Form_Element_Text
{
    /**
     * Override field method to add js
     *
     * @param Varien_Data_Form_Element_Ab$stract $this
     * @return String
     */
    
	public function getHtml()
    {
    	$baseurl = Mage::getBaseUrl();
		$siteurl = str_replace("/index.php/","/",$baseurl);
		$elementonemodel = Mage::getModel('evolved/evolved');
		$elementonecollection = $elementonemodel->getCollection();
		$elementonecollection->addFieldToFilter('field', array('like' => 'homepage_element_one_style'));
		foreach($elementonecollection as $elementonecollection1)
		{
			$selectElement = $elementonecollection1['value'];
			//$selectElement = $elementonecollection1['field'];
		}
		$elementonemodeldata = Mage::getModel('evolved/evolved');
		$elementonecollectiondata = $elementonemodeldata->getCollection();
		$elementonecollectiondata->addFieldToFilter('field', array('like' => 'homepage_element_1_%'));
		//echo "<pre>"; print_r($elementonecollectiondata->getData()); exit;
		foreach ($elementonecollectiondata as $elementonecollectiondata1)
		{
			//    		echo $collection_arr['field']."   value: ".$collection_arr['value']."<br />";
			$collectiondata[$elementonecollectiondata1['field']] = $elementonecollectiondata1['value'];
		}
		//echo "<pre>"; print_r($collectiondata); exit;
        // Get the default HTML for this option
        //$html = parent::getHtml();
    	//$selectElement = '30_70_boxes_full_width';
    			//if($selectElement == '1920_by_480_banner')
	      				{
	      					if($selectElement == 'homepage_element_1_1920_by_480_banner')
	      					{
	      						$str = '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="homepage_element_1_1920_by_480_banner" style="display: block">';
	      					}
	      					else 
	      					{
	      						$str = '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="homepage_element_1_1920_by_480_banner"  style="display: none">';
	      					}
	      					$str = $str . '<tbody>';
	      					$str = $str . '<tr>';
	      					$str = $str . '<td>';
      						$str = $str . '<table cellspacing="0" class="form-list allpageelement">';
							$str = $str . '<tbody>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_one_style_title">Title:</label></td>';  
      						$str = $str . '<td class="value"><input id="homepage_element_1_one_style_title"  value="'.$collectiondata['homepage_element_1_one_style_title'].'"  name="homepage_element_1_one_style_title"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str .	'<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_one_style_link">Link:</label></td>';
      						$str = $str . '<td class="value"><input id="homepage_element_1_one_style_link" value="'.$collectiondata['homepage_element_1_one_style_link'].'" name="homepage_element_1_one_style_link"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_one_style_image">Image:</label></td>';
      						//$str = $str . '<td class="value"><div id="buttonshomepage_element_1_one_style_image" class="buttons-set"><button type="button" class="scalable show-hide" style="" id="togglehomepage_element_1_one_style_image"><span><span><span>Show / Hide Editor</span></span></span></button><button type="button" class="scalable add-widget plugin" onclick="widgetTools.openDialog('.$baseurl.'evolved/widget/index/widget_target_id/homepage_element_1_one_style_image)" style=""><span><span><span>Insert Widget...</span></span></span></button><button type="button" class="scalable add-image plugin" onclick="MediabrowserUtility.openDialog('.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_1_one_style_image/)" style=""><span><span><span>Insert Image...</span></span></span></button><button type="button" class="scalable add-variable plugin" onclick="MagentovariablePlugin.loadChooser('.$baseurl.'evolved/system_variable/wysiwygPlugin/, homepage_element_1_one_style_image);"><span><span><span>Insert Variable...</span></span></span></button></div><textarea name="homepage_element_1_one_style_image" title="" id="homepage_element_1_one_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_1_one_style_image'].'</textarea><small>Image size must be 1920*480 pixels</small></td>';
      						$str = $str . '<td class="value"><button id="togglehomepage_element_1_one_style_image" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><div id="buttonshomepage_element_1_one_style_image" class="buttons-set"><button style="" onclick="MediabrowserUtility.openDialog(\''.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_1_one_style_image/\')" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button></div><textarea name="homepage_element_1_one_style_image" title="" id="homepage_element_1_one_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_1_one_style_image'].'</textarea><small>Image size must be 1920*480 pixels</small></td>';
      						$str = $str . '<script type="text/javascript">';
      						$str = $str . ' openEditorPopup = function(url, name, specs, parent) {';
      						$str = $str . ' if ((typeof popups == "undefined") || popups[name] == undefined || popups[name].closed) {';
      						$str = $str . ' if (typeof popups == "undefined") {';
      						$str = $str . ' popups = new Array();';
      						$str = $str . ' }';
      						$str = $str . ' var opener = (parent != undefined ? parent : window);';
      						$str = $str . 'popups[name] = opener.open(url, name, specs);';
      						$str = $str . ' } else {';
      						$str = $str . ' popups[name].focus();';
      						$str = $str . ' }';
      						$str = $str . 'return popups[name];';
      						$str = $str . '}';
      						$str = $str . 'closeEditorPopup = function(name) {';
      						$str = $str . 'if ((typeof popups != "undefined") &amp;&amp; popups[name] != undefined &amp;&amp; !popups[name].closed) {';
      						$str = $str . 'popups[name].close();';
      						$str = $str . '}';
      						$str = $str . '}';
      						$str = $str . ' </script>';
      						$str = $str . '<script type="text/javascript">';
      						$str = $str . 'if ("undefined" != typeof(Translator)) {';
      						$str = $str . 'Translator.add({"Insert Image...":"Insert Image...","Insert Media...":"Insert Media...","Insert File...":"Insert File..."});';
      						$str = $str . '}wysiwyghomepage_element_1_one_style_image = new tinyMceWysiwygSetup("homepage_element_1_one_style_image", {"enabled":true,"hidden":true,"use_container":false,"add_variables":true,"add_widgets":true,"add_images":true,"no_display":false,"translator":{},"encode_directives":true,"directives_url":"'.$baseurl.'evolved/cms_wysiwyg/directive/","popup_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/dialog.css","content_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/content.css","width":"100%","plugins":[{"name":"magentovariable","src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentovariable/editor_plugin.js","options":{"title":"Insert Variable...","url":"'.$baseurl.'evolved/system_variable/wysiwygPlugin/","onclick":{"search":["html_id"],"subject":"MagentovariablePlugin.loadChooser(\''.$baseurl.'evolved/system_variable/wysiwygPlugin/\', \'{{html_id}}\');"},"class":"add-variable plugin"}}],"directives_url_quoted":"'.$baseurl.'evolved/cms_wysiwyg/directive/","files_browser_window_url":"'.$baseurl.'idealAdmin/cms_wysiwyg_images/index/","files_browser_window_width":1000,"files_browser_window_height":600,"widget_plugin_src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentowidget/editor_plugin.js","widget_images_url":"'.$siteurl.'skin/adminhtml/default/default/images/widget/","widget_placeholders":["Thumbs.db","catalog__category_widget_link.gif","catalog__product_widget_link.gif","catalog__product_widget_new.gif","cms__widget_block.gif","cms__widget_page_link.gif","default.gif","reports__product_widget_compared.gif","reports__product_widget_viewed.gif"],"widget_window_url":"'.$baseurl.'evolved/widget/index/","firebug_warning_title":"Warning","firebug_warning_text":"Firebug is known to make the WYSIWYG editor slow unless it is turned off or configured properly.","firebug_warning_anchor":"Hide"});';
      						$str = $str . 'editorFormValidationHandler = wysiwyghomepage_element_1_one_style_image.onFormValidation.bind(wysiwyghomepage_element_1_one_style_image);';
      						$str = $str . 'Event.observe("togglehomepage_element_1_one_style_image", "click", wysiwyghomepage_element_1_one_style_image.toggle.bind(wysiwyghomepage_element_1_one_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("formSubmit", editorFormValidationHandler);';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceBeforeSetContent", wysiwyghomepage_element_1_one_style_image.beforeSetContent.bind(wysiwyghomepage_element_1_one_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceSaveContent", wysiwyghomepage_element_1_one_style_image.saveContent.bind(wysiwyghomepage_element_1_one_style_image));';
      						$str = $str . 'varienGlobalEvents.clearEventHandlers("open_browser_callback");';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("open_browser_callback", wysiwyghomepage_element_1_one_style_image.openFileBrowser.bind(wysiwyghomepage_element_1_one_style_image));';
      						$str = $str . '</script>';
      						$str = $str . '</tr>';
      						$str = $str . '</tbody>';
      						$str = $str . '</table>';	
      						$str = $str . '</td>';
      						$str = $str . '</tr>';
      						$str = $str . '</tbody>';
      						$str = $str . '</table>';
						}
      					//else if($selectElement == '1920_by_800_banner')
	      				{
      						//alert('hi');
	      					if($selectElement == 'homepage_element_1_1920_by_800_banner')
	      					{
	      						$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="homepage_element_1_1920_by_800_banner" style="display: block">';
	      					}
	      					else
	      					{
	      						$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="homepage_element_1_1920_by_800_banner"  style="display: none">';
	      					}
	      					//$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="1920_by_800_banner">';
	      					$str = $str . '<tbody>';
	      					$str = $str . '<tr>';
	      					$str = $str . '<td>';
      						$str = $str . '<table cellspacing="0" class="form-list allpageelement">';
							$str = $str . '<tbody>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_two_style_title">Title:</label></td>';  
      						$str = $str . '<td class="value"><input id="homepage_element_1_two_style_title" value="'.$collectiondata['homepage_element_1_two_style_title'].'"  name="homepage_element_1_two_style_title"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str .	'<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_two_style_link">Link:</label></td>';
      						$str = $str . '<td class="value"><input id="homepage_element_1_two_style_link" value="'.$collectiondata['homepage_element_1_two_style_link'].'" name="homepage_element_1_two_style_link"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_two_style_image">Image:</label></td>';
      						//$str = $str . '<td class="value"><div id="buttonshomepage_element_1_two_style_image" class="buttons-set"><button type="button" class="scalable show-hide" style="" id="togglehomepage_element_1_two_style_image"><span><span><span>Show / Hide Editor</span></span></span></button><button type="button" class="scalable add-widget plugin" onclick="widgetTools.openDialog('.$baseurl.'evolved/widget/index/widget_target_id/homepage_element_1_two_style_image)" style=""><span><span><span>Insert Widget...</span></span></span></button><button type="button" class="scalable add-image plugin" onclick="MediabrowserUtility.openDialog('.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_1_two_style_image/)" style=""><span><span><span>Insert Image...</span></span></span></button><button type="button" class="scalable add-variable plugin" onclick="MagentovariablePlugin.loadChooser('.$baseurl.'evolved/system_variable/wysiwygPlugin/, homepage_element_1_two_style_image);"><span><span><span>Insert Variable...</span></span></span></button></div><textarea name="homepage_element_1_two_style_image" title="" id="homepage_element_1_two_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_1_two_style_image'].'</textarea><small>Image size must be 1920*480 pixels</small></td>';
      						$str = $str . '<td class="value"><button id="togglehomepage_element_1_two_style_image" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><div id="buttonshomepage_element_1_two_style_image" class="buttons-set"><button style="" onclick="MediabrowserUtility.openDialog(\''.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_1_two_style_image/\')" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button></div><textarea name="homepage_element_1_two_style_image" title="" id="homepage_element_1_two_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_1_two_style_image'].'</textarea><small>Image size must be 1920*800 pixels</small></td>';
      						$str = $str . '<script type="text/javascript">';
      						$str = $str . ' openEditorPopup = function(url, name, specs, parent) {';
      						$str = $str . ' if ((typeof popups == "undefined") || popups[name] == undefined || popups[name].closed) {';
      						$str = $str . ' if (typeof popups == "undefined") {';
      						$str = $str . ' popups = new Array();';
      						$str = $str . ' }';
      						$str = $str . ' var opener = (parent != undefined ? parent : window);';
      						$str = $str . 'popups[name] = opener.open(url, name, specs);';
      						$str = $str . ' } else {';
      						$str = $str . ' popups[name].focus();';
      						$str = $str . ' }';
      						$str = $str . 'return popups[name];';
      						$str = $str . '}';
      						$str = $str . 'closeEditorPopup = function(name) {';
      						$str = $str . 'if ((typeof popups != "undefined") &amp;&amp; popups[name] != undefined &amp;&amp; !popups[name].closed) {';
      						$str = $str . 'popups[name].close();';
      						$str = $str . '}';
      						$str = $str . '}';
      						$str = $str . ' </script>';
      						$str = $str . '<script type="text/javascript">';
      						$str = $str . 'if ("undefined" != typeof(Translator)) {';
      						$str = $str . 'Translator.add({"Insert Image...":"Insert Image...","Insert Media...":"Insert Media...","Insert File...":"Insert File..."});';
      						$str = $str . '}wysiwyghomepage_element_1_two_style_image = new tinyMceWysiwygSetup("homepage_element_1_two_style_image", {"enabled":true,"hidden":true,"use_container":false,"add_variables":true,"add_widgets":true,"add_images":true,"no_display":false,"translator":{},"encode_directives":true,"directives_url":"'.$baseurl.'evolved/cms_wysiwyg/directive/","popup_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/dialog.css","content_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/content.css","width":"100%","plugins":[{"name":"magentovariable","src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentovariable/editor_plugin.js","options":{"title":"Insert Variable...","url":"'.$baseurl.'evolved/system_variable/wysiwygPlugin/","onclick":{"search":["html_id"],"subject":"MagentovariablePlugin.loadChooser(\''.$baseurl.'evolved/system_variable/wysiwygPlugin/\', \'{{html_id}}\');"},"class":"add-variable plugin"}}],"directives_url_quoted":"'.$baseurl.'evolved/cms_wysiwyg/directive/","files_browser_window_url":"'.$baseurl.'idealAdmin/cms_wysiwyg_images/index/","files_browser_window_width":1000,"files_browser_window_height":600,"widget_plugin_src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentowidget/editor_plugin.js","widget_images_url":"'.$siteurl.'skin/adminhtml/default/default/images/widget/","widget_placeholders":["Thumbs.db","catalog__category_widget_link.gif","catalog__product_widget_link.gif","catalog__product_widget_new.gif","cms__widget_block.gif","cms__widget_page_link.gif","default.gif","reports__product_widget_compared.gif","reports__product_widget_viewed.gif"],"widget_window_url":"'.$baseurl.'evolved/widget/index/","firebug_warning_title":"Warning","firebug_warning_text":"Firebug is known to make the WYSIWYG editor slow unless it is turned off or configured properly.","firebug_warning_anchor":"Hide"});';
      						$str = $str . 'editorFormValidationHandler = wysiwyghomepage_element_1_two_style_image.onFormValidation.bind(wysiwyghomepage_element_1_two_style_image);';
      						$str = $str . 'Event.observe("togglehomepage_element_1_two_style_image", "click", wysiwyghomepage_element_1_two_style_image.toggle.bind(wysiwyghomepage_element_1_two_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("formSubmit", editorFormValidationHandler);';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceBeforeSetContent", wysiwyghomepage_element_1_two_style_image.beforeSetContent.bind(wysiwyghomepage_element_1_two_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceSaveContent", wysiwyghomepage_element_1_two_style_image.saveContent.bind(wysiwyghomepage_element_1_two_style_image));';
      						$str = $str . 'varienGlobalEvents.clearEventHandlers("open_browser_callback");';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("open_browser_callback", wysiwyghomepage_element_1_two_style_image.openFileBrowser.bind(wysiwyghomepage_element_1_two_style_image));';
      						$str = $str . '</script>';
      						$str = $str . '</tr>';
      						$str = $str . '</tbody>';
      						$str = $str . '</table>';
      						$str = $str . '</td>';
      						$str = $str . '</tr>';
      						$str = $str . '</tbody>';
      						$str = $str . '</table>';
						}
      					//else if($selectElement == '30_70_boxes_full_width')
	      				{
      						//alert('hi');
	      					if($selectElement == 'homepage_element_1_30_70_boxes_full_width')
	      					{
	      						$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="homepage_element_1_30_70_boxes_full_width" style="display: block">';
	      					}
	      					else
	      					{
	      						$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="homepage_element_1_30_70_boxes_full_width"  style="display: none">';
	      					}
	      					//$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="30_70_boxes_full_width">';
	      					$str = $str . '<tbody>';
	      					$str = $str . '<tr>';
	      					$str = $str . '<td>';
      						$str = $str . '<table cellspacing="0" class="form-list allpageelement" style="display: table-cell;">';
							$str = $str . '<tbody>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_three_one_style_title">Title:</label></td>';  
      						$str = $str . '<td class="value"><input id="homepage_element_1_three_one_style_title" value="'.$collectiondata['homepage_element_1_three_one_style_title'].'" name="homepage_element_1_three_one_style_title"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str .	'<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_three_one_style_link">Link:</label></td>';
      						$str = $str . '<td class="value"><input id="homepage_element_1_three_one_style_link"  value="'.$collectiondata['homepage_element_1_three_one_style_link'].'" name="homepage_element_1_three_one_style_link"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_three_one_style_image">Image:</label></td>';
      						//$str = $str . '<td class="value"><div id="buttonshomepage_element_1_three_one_style_image" class="buttons-set"><button type="button" class="scalable show-hide" style="" id="togglehomepage_element_1_three_one_style_image"><span><span><span>Show / Hide Editor</span></span></span></button><button type="button" class="scalable add-widget plugin" onclick="widgetTools.openDialog('.$baseurl.'evolved/widget/index/widget_target_id/homepage_element_1_three_one_style_image)" style=""><span><span><span>Insert Widget...</span></span></span></button><button type="button" class="scalable add-image plugin" onclick="MediabrowserUtility.openDialog('.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_1_three_one_style_image/)" style=""><span><span><span>Insert Image...</span></span></span></button><button type="button" class="scalable add-variable plugin" onclick="MagentovariablePlugin.loadChooser('.$baseurl.'evolved/system_variable/wysiwygPlugin/, homepage_element_1_three_one_style_image);"><span><span><span>Insert Variable...</span></span></span></button></div><textarea name="homepage_element_1_three_one_style_image" title="" id="homepage_element_1_three_one_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_1_three_one_style_image'].'</textarea><small>Image size must be 1920*480 pixels</small></td>';
      						$str = $str . '<td class="value"><button id="togglehomepage_element_1_three_one_style_image" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><div id="buttonshomepage_element_1_three_one_style_image" class="buttons-set"><button style="" onclick="MediabrowserUtility.openDialog(\''.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_1_three_one_style_image/\')" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button></div><textarea name="homepage_element_1_three_one_style_image" title="" id="homepage_element_1_three_one_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_1_three_one_style_image'].'</textarea><small>Image size must be 640*400 pixels</small></td>';
      						$str = $str . '<script type="text/javascript">';
      						$str = $str . ' openEditorPopup = function(url, name, specs, parent) {';
      						$str = $str . ' if ((typeof popups == "undefined") || popups[name] == undefined || popups[name].closed) {';
      						$str = $str . ' if (typeof popups == "undefined") {';
      						$str = $str . ' popups = new Array();';
      						$str = $str . ' }';
      						$str = $str . ' var opener = (parent != undefined ? parent : window);';
      						$str = $str . 'popups[name] = opener.open(url, name, specs);';
      						$str = $str . ' } else {';
      						$str = $str . ' popups[name].focus();';
      						$str = $str . ' }';
      						$str = $str . 'return popups[name];';
      						$str = $str . '}';
      						$str = $str . 'closeEditorPopup = function(name) {';
      						$str = $str . 'if ((typeof popups != "undefined") &amp;&amp; popups[name] != undefined &amp;&amp; !popups[name].closed) {';
      						$str = $str . 'popups[name].close();';
      						$str = $str . '}';
      						$str = $str . '}';
      						$str = $str . ' </script>';
      						$str = $str . '<script type="text/javascript">';
      						$str = $str . 'if ("undefined" != typeof(Translator)) {';
      						$str = $str . 'Translator.add({"Insert Image...":"Insert Image...","Insert Media...":"Insert Media...","Insert File...":"Insert File..."});';
      						$str = $str . '}wysiwyghomepage_element_1_three_one_style_image = new tinyMceWysiwygSetup("homepage_element_1_three_one_style_image", {"enabled":true,"hidden":true,"use_container":false,"add_variables":true,"add_widgets":true,"add_images":true,"no_display":false,"translator":{},"encode_directives":true,"directives_url":"'.$baseurl.'evolved/cms_wysiwyg/directive/","popup_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/dialog.css","content_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/content.css","width":"100%","plugins":[{"name":"magentovariable","src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentovariable/editor_plugin.js","options":{"title":"Insert Variable...","url":"'.$baseurl.'evolved/system_variable/wysiwygPlugin/","onclick":{"search":["html_id"],"subject":"MagentovariablePlugin.loadChooser(\''.$baseurl.'evolved/system_variable/wysiwygPlugin/\', \'{{html_id}}\');"},"class":"add-variable plugin"}}],"directives_url_quoted":"'.$baseurl.'evolved/cms_wysiwyg/directive/","files_browser_window_url":"'.$baseurl.'idealAdmin/cms_wysiwyg_images/index/","files_browser_window_width":1000,"files_browser_window_height":600,"widget_plugin_src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentowidget/editor_plugin.js","widget_images_url":"'.$siteurl.'skin/adminhtml/default/default/images/widget/","widget_placeholders":["Thumbs.db","catalog__category_widget_link.gif","catalog__product_widget_link.gif","catalog__product_widget_new.gif","cms__widget_block.gif","cms__widget_page_link.gif","default.gif","reports__product_widget_compared.gif","reports__product_widget_viewed.gif"],"widget_window_url":"'.$baseurl.'evolved/widget/index/","firebug_warning_title":"Warning","firebug_warning_text":"Firebug is known to make the WYSIWYG editor slow unless it is turned off or configured properly.","firebug_warning_anchor":"Hide"});';
      						$str = $str . 'editorFormValidationHandler = wysiwyghomepage_element_1_three_one_style_image.onFormValidation.bind(wysiwyghomepage_element_1_three_one_style_image);';
      						$str = $str . 'Event.observe("togglehomepage_element_1_three_one_style_image", "click", wysiwyghomepage_element_1_three_one_style_image.toggle.bind(wysiwyghomepage_element_1_three_one_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("formSubmit", editorFormValidationHandler);';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceBeforeSetContent", wysiwyghomepage_element_1_three_one_style_image.beforeSetContent.bind(wysiwyghomepage_element_1_three_one_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceSaveContent", wysiwyghomepage_element_1_three_one_style_image.saveContent.bind(wysiwyghomepage_element_1_three_one_style_image));';
      						$str = $str . 'varienGlobalEvents.clearEventHandlers("open_browser_callback");';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("open_browser_callback", wysiwyghomepage_element_1_three_one_style_image.openFileBrowser.bind(wysiwyghomepage_element_1_three_one_style_image));';
      						$str = $str . '</script>';
      						$str = $str . '</tr>';
      						$str = $str . '</tbody>';
      						$str = $str . '</table>';
      						$str = $str . '<table cellspacing="0" class="form-list allpageelement" style="display: table-cell;">';
							$str = $str . '<tbody>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_three_two_style_title">Title:</label></td>';  
      						$str = $str . '<td class="value"><input id="homepage_element_1_three_two_style_title" value="'.$collectiondata['homepage_element_1_three_two_style_title'].'" name="homepage_element_1_three_two_style_title"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str .	'<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_three_two_style_link">Link:</label></td>';
      						$str = $str . '<td class="value"><input id="homepage_element_1_three_two_style_link"  value="'.$collectiondata['homepage_element_1_three_two_style_link'].'" name="homepage_element_1_three_two_style_link"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_three_two_style_image">Image:</label></td>';
      						//$str = $str . '<td class="value"><div id="buttonshomepage_element_1_three_two_style_image" class="buttons-set"><button type="button" class="scalable show-hide" style="" id="togglehomepage_element_1_three_two_style_image"><span><span><span>Show / Hide Editor</span></span></span></button><button type="button" class="scalable add-widget plugin" onclick="widgetTools.openDialog('.$baseurl.'evolved/widget/index/widget_target_id/homepage_element_1_three_two_style_image)" style=""><span><span><span>Insert Widget...</span></span></span></button><button type="button" class="scalable add-image plugin" onclick="MediabrowserUtility.openDialog('.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_1_three_two_style_image/)" style=""><span><span><span>Insert Image...</span></span></span></button><button type="button" class="scalable add-variable plugin" onclick="MagentovariablePlugin.loadChooser('.$baseurl.'evolved/system_variable/wysiwygPlugin/, homepage_element_1_three_two_style_image);"><span><span><span>Insert Variable...</span></span></span></button></div><textarea name="homepage_element_1_three_two_style_image" title="" id="homepage_element_1_three_two_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_1_three_two_style_image'].'</textarea><small>Image size must be 1920*480 pixels</small></td>';
      						$str = $str . '<td class="value"><button id="togglehomepage_element_1_three_two_style_image" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><div id="buttonshomepage_element_1_three_two_style_image" class="buttons-set"><button style="" onclick="MediabrowserUtility.openDialog(\''.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_1_three_two_style_image/\')" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button></div><textarea name="homepage_element_1_three_two_style_image" title="" id="homepage_element_1_three_two_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_1_three_two_style_image'].'</textarea><small>Image size must be 640*400 pixels</small></td>';
      						$str = $str . '<script type="text/javascript">';
      						$str = $str . ' openEditorPopup = function(url, name, specs, parent) {';
      						$str = $str . ' if ((typeof popups == "undefined") || popups[name] == undefined || popups[name].closed) {';
      						$str = $str . ' if (typeof popups == "undefined") {';
      						$str = $str . ' popups = new Array();';
      						$str = $str . ' }';
      						$str = $str . ' var opener = (parent != undefined ? parent : window);';
      						$str = $str . 'popups[name] = opener.open(url, name, specs);';
      						$str = $str . ' } else {';
      						$str = $str . ' popups[name].focus();';
      						$str = $str . ' }';
      						$str = $str . 'return popups[name];';
      						$str = $str . '}';
      						$str = $str . 'closeEditorPopup = function(name) {';
      						$str = $str . 'if ((typeof popups != "undefined") &amp;&amp; popups[name] != undefined &amp;&amp; !popups[name].closed) {';
      						$str = $str . 'popups[name].close();';
      						$str = $str . '}';
      						$str = $str . '}';
      						$str = $str . ' </script>';
      						$str = $str . '<script type="text/javascript">';
      						$str = $str . 'if ("undefined" != typeof(Translator)) {';
      						$str = $str . 'Translator.add({"Insert Image...":"Insert Image...","Insert Media...":"Insert Media...","Insert File...":"Insert File..."});';
      						$str = $str . '}wysiwyghomepage_element_1_three_two_style_image = new tinyMceWysiwygSetup("homepage_element_1_three_two_style_image", {"enabled":true,"hidden":true,"use_container":false,"add_variables":true,"add_widgets":true,"add_images":true,"no_display":false,"translator":{},"encode_directives":true,"directives_url":"'.$baseurl.'evolved/cms_wysiwyg/directive/","popup_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/dialog.css","content_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/content.css","width":"100%","plugins":[{"name":"magentovariable","src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentovariable/editor_plugin.js","options":{"title":"Insert Variable...","url":"'.$baseurl.'evolved/system_variable/wysiwygPlugin/","onclick":{"search":["html_id"],"subject":"MagentovariablePlugin.loadChooser(\''.$baseurl.'evolved/system_variable/wysiwygPlugin/\', \'{{html_id}}\');"},"class":"add-variable plugin"}}],"directives_url_quoted":"'.$baseurl.'evolved/cms_wysiwyg/directive/","files_browser_window_url":"'.$baseurl.'idealAdmin/cms_wysiwyg_images/index/","files_browser_window_width":1000,"files_browser_window_height":600,"widget_plugin_src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentowidget/editor_plugin.js","widget_images_url":"'.$siteurl.'skin/adminhtml/default/default/images/widget/","widget_placeholders":["Thumbs.db","catalog__category_widget_link.gif","catalog__product_widget_link.gif","catalog__product_widget_new.gif","cms__widget_block.gif","cms__widget_page_link.gif","default.gif","reports__product_widget_compared.gif","reports__product_widget_viewed.gif"],"widget_window_url":"'.$baseurl.'evolved/widget/index/","firebug_warning_title":"Warning","firebug_warning_text":"Firebug is known to make the WYSIWYG editor slow unless it is turned off or configured properly.","firebug_warning_anchor":"Hide"});';
      						$str = $str . 'editorFormValidationHandler = wysiwyghomepage_element_1_three_two_style_image.onFormValidation.bind(wysiwyghomepage_element_1_three_two_style_image);';
      						$str = $str . 'Event.observe("togglehomepage_element_1_three_two_style_image", "click", wysiwyghomepage_element_1_three_two_style_image.toggle.bind(wysiwyghomepage_element_1_three_two_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("formSubmit", editorFormValidationHandler);';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceBeforeSetContent", wysiwyghomepage_element_1_three_two_style_image.beforeSetContent.bind(wysiwyghomepage_element_1_three_two_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceSaveContent", wysiwyghomepage_element_1_three_two_style_image.saveContent.bind(wysiwyghomepage_element_1_three_two_style_image));';
      						$str = $str . 'varienGlobalEvents.clearEventHandlers("open_browser_callback");';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("open_browser_callback", wysiwyghomepage_element_1_three_two_style_image.openFileBrowser.bind(wysiwyghomepage_element_1_three_two_style_image));';
      						$str = $str . '</script>';
      						$str = $str . '</tr>';
      						$str = $str . '</tbody>';
      						$str = $str . '</table>';
      						$str = $str . '<table cellspacing="0" class="form-list allpageelement" style="display: table-cell;">';
							$str = $str . '<tbody>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_three_three_style_title">Title:</label></td>';  
      						$str = $str . '<td class="value"><input id="homepage_element_1_three_three_style_title"  value="'.$collectiondata['homepage_element_1_three_three_style_title'].'" name="homepage_element_1_three_three_style_title"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str .	'<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_three_three_style_link">Link:</label></td>';
      						$str = $str . '<td class="value"><input id="homepage_element_1_three_three_style_link" value="'.$collectiondata['homepage_element_1_three_three_style_link'].'" name="homepage_element_1_three_three_style_link"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_three_three_style_image">Image:</label></td>';
      						//$str = $str . '<td class="value"><div id="buttonshomepage_element_1_three_three_style_image" class="buttons-set"><button type="button" class="scalable show-hide" style="" id="togglehomepage_element_1_three_three_style_image"><span><span><span>Show / Hide Editor</span></span></span></button><button type="button" class="scalable add-widget plugin" onclick="widgetTools.openDialog('.$baseurl.'evolved/widget/index/widget_target_id/homepage_element_1_three_three_style_image)" style=""><span><span><span>Insert Widget...</span></span></span></button><button type="button" class="scalable add-image plugin" onclick="MediabrowserUtility.openDialog('.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_1_three_three_style_image/)" style=""><span><span><span>Insert Image...</span></span></span></button><button type="button" class="scalable add-variable plugin" onclick="MagentovariablePlugin.loadChooser('.$baseurl.'evolved/system_variable/wysiwygPlugin/, homepage_element_1_three_three_style_image);"><span><span><span>Insert Variable...</span></span></span></button></div><textarea name="homepage_element_1_three_three_style_image" title="" id="homepage_element_1_three_three_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_1_three_three_style_image'].'</textarea><small>Image size must be 1920*480 pixels</small></td>';
      						$str = $str . '<td class="value"><button id="togglehomepage_element_1_three_three_style_image" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><div id="buttonshomepage_element_1_three_three_style_image" class="buttons-set"><button style="" onclick="MediabrowserUtility.openDialog(\''.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_1_three_three_style_image/\')" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button></div><textarea name="homepage_element_1_three_three_style_image" title="" id="homepage_element_1_three_three_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_1_three_three_style_image'].'</textarea><small>Image size must be 1280*800 pixels</small></td>';
      						$str = $str . '<script type="text/javascript">';
      						$str = $str . ' openEditorPopup = function(url, name, specs, parent) {';
      						$str = $str . ' if ((typeof popups == "undefined") || popups[name] == undefined || popups[name].closed) {';
      						$str = $str . ' if (typeof popups == "undefined") {';
      						$str = $str . ' popups = new Array();';
      						$str = $str . ' }';
      						$str = $str . ' var opener = (parent != undefined ? parent : window);';
      						$str = $str . 'popups[name] = opener.open(url, name, specs);';
      						$str = $str . ' } else {';
      						$str = $str . ' popups[name].focus();';
      						$str = $str . ' }';
      						$str = $str . 'return popups[name];';
      						$str = $str . '}';
      						$str = $str . 'closeEditorPopup = function(name) {';
      						$str = $str . 'if ((typeof popups != "undefined") &amp;&amp; popups[name] != undefined &amp;&amp; !popups[name].closed) {';
      						$str = $str . 'popups[name].close();';
      						$str = $str . '}';
      						$str = $str . '}';
      						$str = $str . ' </script>';
      						$str = $str . '<script type="text/javascript">';
      						$str = $str . 'if ("undefined" != typeof(Translator)) {';
      						$str = $str . 'Translator.add({"Insert Image...":"Insert Image...","Insert Media...":"Insert Media...","Insert File...":"Insert File..."});';
      						$str = $str . '}wysiwyghomepage_element_1_three_three_style_image = new tinyMceWysiwygSetup("homepage_element_1_three_three_style_image", {"enabled":true,"hidden":true,"use_container":false,"add_variables":true,"add_widgets":true,"add_images":true,"no_display":false,"translator":{},"encode_directives":true,"directives_url":"'.$baseurl.'evolved/cms_wysiwyg/directive/","popup_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/dialog.css","content_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/content.css","width":"100%","plugins":[{"name":"magentovariable","src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentovariable/editor_plugin.js","options":{"title":"Insert Variable...","url":"'.$baseurl.'evolved/system_variable/wysiwygPlugin/","onclick":{"search":["html_id"],"subject":"MagentovariablePlugin.loadChooser(\''.$baseurl.'evolved/system_variable/wysiwygPlugin/\', \'{{html_id}}\');"},"class":"add-variable plugin"}}],"directives_url_quoted":"'.$baseurl.'evolved/cms_wysiwyg/directive/","files_browser_window_url":"'.$baseurl.'idealAdmin/cms_wysiwyg_images/index/","files_browser_window_width":1000,"files_browser_window_height":600,"widget_plugin_src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentowidget/editor_plugin.js","widget_images_url":"'.$siteurl.'skin/adminhtml/default/default/images/widget/","widget_placeholders":["Thumbs.db","catalog__category_widget_link.gif","catalog__product_widget_link.gif","catalog__product_widget_new.gif","cms__widget_block.gif","cms__widget_page_link.gif","default.gif","reports__product_widget_compared.gif","reports__product_widget_viewed.gif"],"widget_window_url":"'.$baseurl.'evolved/widget/index/","firebug_warning_title":"Warning","firebug_warning_text":"Firebug is known to make the WYSIWYG editor slow unless it is turned off or configured properly.","firebug_warning_anchor":"Hide"});';
      						$str = $str . 'editorFormValidationHandler = wysiwyghomepage_element_1_three_three_style_image.onFormValidation.bind(wysiwyghomepage_element_1_three_three_style_image);';
      						$str = $str . 'Event.observe("togglehomepage_element_1_three_three_style_image", "click", wysiwyghomepage_element_1_three_three_style_image.toggle.bind(wysiwyghomepage_element_1_three_three_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("formSubmit", editorFormValidationHandler);';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceBeforeSetContent", wysiwyghomepage_element_1_three_three_style_image.beforeSetContent.bind(wysiwyghomepage_element_1_three_three_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceSaveContent", wysiwyghomepage_element_1_three_three_style_image.saveContent.bind(wysiwyghomepage_element_1_three_three_style_image));';
      						$str = $str . 'varienGlobalEvents.clearEventHandlers("open_browser_callback");';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("open_browser_callback", wysiwyghomepage_element_1_three_three_style_image.openFileBrowser.bind(wysiwyghomepage_element_1_three_three_style_image));';
      						$str = $str . '</script>';
      						$str = $str . '</tr>';
      						$str = $str . '</tbody>';
      						$str = $str . '</table>';
      						$str = $str . '</td>';
      						$str = $str . '</tr>';
      						$str = $str . '</tbody>';
      						$str = $str . '</table>';
						}
      					//if($selectElement == '70_30_boxes_full_width')
	      				{
      						//alert('hi');
	      					if($selectElement == 'homepage_element_1_70_30_boxes_full_width')
	      					{
	      						$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="homepage_element_1_70_30_boxes_full_width" style="display: block">';
	      					}
	      					else
	      					{
	      						$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="homepage_element_1_70_30_boxes_full_width"  style="display: none">';
	      					}
	      					//$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="70_30_boxes_full_width">';
	      					$str = $str . '<tbody>';
	      					$str = $str . '<tr>';
	      					$str = $str . '<td>';
      						$str = $str . '<table cellspacing="0" class="form-list allpageelement" style="display: table-cell;">';
							$str = $str . '<tbody>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_four_one_style_title">Title:</label></td>';  
      						$str = $str . '<td class="value"><input id="homepage_element_1_four_one_style_title"  value="'.$collectiondata['homepage_element_1_four_one_style_title'].'" name="homepage_element_1_four_one_style_title"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_four_one_style_link">Link:</label></td>';
      						$str = $str . '<td class="value"><input id="homepage_element_1_four_one_style_link" value="'.$collectiondata['homepage_element_1_four_one_style_link'].'" name="homepage_element_1_four_one_style_link"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_four_one_style_image">Image:</label></td>';
      						//$str = $str . '<td class="value"><div id="buttonshomepage_element_1_four_one_style_image" class="buttons-set"><button type="button" class="scalable show-hide" style="" id="togglehomepage_element_1_four_one_style_image"><span><span><span>Show / Hide Editor</span></span></span></button><button type="button" class="scalable add-widget plugin" onclick="widgetTools.openDialog('.$baseurl.'evolved/widget/index/widget_target_id/homepage_element_1_four_one_style_image)" style=""><span><span><span>Insert Widget...</span></span></span></button><button type="button" class="scalable add-image plugin" onclick="MediabrowserUtility.openDialog('.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_1_four_one_style_image/)" style=""><span><span><span>Insert Image...</span></span></span></button><button type="button" class="scalable add-variable plugin" onclick="MagentovariablePlugin.loadChooser('.$baseurl.'evolved/system_variable/wysiwygPlugin/, homepage_element_1_four_one_style_image);"><span><span><span>Insert Variable...</span></span></span></button></div><textarea name="homepage_element_1_four_one_style_image" title="" id="homepage_element_1_four_one_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_1_four_one_style_image'].'</textarea><small>Image size must be 1920*480 pixels</small></td>';
      						$str = $str . '<td class="value"><button id="togglehomepage_element_1_four_one_style_image" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><div id="buttonshomepage_element_1_four_one_style_image" class="buttons-set"><button style="" onclick="MediabrowserUtility.openDialog(\''.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_1_four_one_style_image/\')" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button></div><textarea name="homepage_element_1_four_one_style_image" title="" id="homepage_element_1_four_one_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_1_four_one_style_image'].'</textarea><small>Image size must be 1280*800 pixels</small></td>';
      						$str = $str . '<script type="text/javascript">';
      						$str = $str . ' openEditorPopup = function(url, name, specs, parent) {';
      						$str = $str . ' if ((typeof popups == "undefined") || popups[name] == undefined || popups[name].closed) {';
      						$str = $str . ' if (typeof popups == "undefined") {';
      						$str = $str . ' popups = new Array();';
      						$str = $str . ' }';
      						$str = $str . ' var opener = (parent != undefined ? parent : window);';
      						$str = $str . 'popups[name] = opener.open(url, name, specs);';
      						$str = $str . ' } else {';
      						$str = $str . ' popups[name].focus();';
      						$str = $str . ' }';
      						$str = $str . 'return popups[name];';
      						$str = $str . '}';
      						$str = $str . 'closeEditorPopup = function(name) {';
      						$str = $str . 'if ((typeof popups != "undefined") &amp;&amp; popups[name] != undefined &amp;&amp; !popups[name].closed) {';
      						$str = $str . 'popups[name].close();';
      						$str = $str . '}';
      						$str = $str . '}';
      						$str = $str . ' </script>';
      						$str = $str . '<script type="text/javascript">';
      						$str = $str . 'if ("undefined" != typeof(Translator)) {';
      						$str = $str . 'Translator.add({"Insert Image...":"Insert Image...","Insert Media...":"Insert Media...","Insert File...":"Insert File..."});';
      						$str = $str . '}wysiwyghomepage_element_1_four_one_style_image = new tinyMceWysiwygSetup("homepage_element_1_four_one_style_image", {"enabled":true,"hidden":true,"use_container":false,"add_variables":true,"add_widgets":true,"add_images":true,"no_display":false,"translator":{},"encode_directives":true,"directives_url":"'.$baseurl.'evolved/cms_wysiwyg/directive/","popup_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/dialog.css","content_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/content.css","width":"100%","plugins":[{"name":"magentovariable","src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentovariable/editor_plugin.js","options":{"title":"Insert Variable...","url":"'.$baseurl.'evolved/system_variable/wysiwygPlugin/","onclick":{"search":["html_id"],"subject":"MagentovariablePlugin.loadChooser(\''.$baseurl.'evolved/system_variable/wysiwygPlugin/\', \'{{html_id}}\');"},"class":"add-variable plugin"}}],"directives_url_quoted":"'.$baseurl.'evolved/cms_wysiwyg/directive/","files_browser_window_url":"'.$baseurl.'idealAdmin/cms_wysiwyg_images/index/","files_browser_window_width":1000,"files_browser_window_height":600,"widget_plugin_src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentowidget/editor_plugin.js","widget_images_url":"'.$siteurl.'skin/adminhtml/default/default/images/widget/","widget_placeholders":["Thumbs.db","catalog__category_widget_link.gif","catalog__product_widget_link.gif","catalog__product_widget_new.gif","cms__widget_block.gif","cms__widget_page_link.gif","default.gif","reports__product_widget_compared.gif","reports__product_widget_viewed.gif"],"widget_window_url":"'.$baseurl.'evolved/widget/index/","firebug_warning_title":"Warning","firebug_warning_text":"Firebug is known to make the WYSIWYG editor slow unless it is turned off or configured properly.","firebug_warning_anchor":"Hide"});';
      						$str = $str . 'editorFormValidationHandler = wysiwyghomepage_element_1_four_one_style_image.onFormValidation.bind(wysiwyghomepage_element_1_four_one_style_image);';
      						$str = $str . 'Event.observe("togglehomepage_element_1_four_one_style_image", "click", wysiwyghomepage_element_1_four_one_style_image.toggle.bind(wysiwyghomepage_element_1_four_one_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("formSubmit", editorFormValidationHandler);';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceBeforeSetContent", wysiwyghomepage_element_1_four_one_style_image.beforeSetContent.bind(wysiwyghomepage_element_1_four_one_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceSaveContent", wysiwyghomepage_element_1_four_one_style_image.saveContent.bind(wysiwyghomepage_element_1_four_one_style_image));';
      						$str = $str . 'varienGlobalEvents.clearEventHandlers("open_browser_callback");';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("open_browser_callback", wysiwyghomepage_element_1_four_one_style_image.openFileBrowser.bind(wysiwyghomepage_element_1_four_one_style_image));';
      						$str = $str . '</script>';
      						$str = $str . '</tr>';
      						$str = $str . '</tbody>';
      						$str = $str . '</table>'; 
      						$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelement" style="display: table-cell;">';
							$str = $str . '<tbody>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_four_two_style_title">Title:</label></td>';  
      						$str = $str . '<td class="value"><input id="homepage_element_1_four_two_style_title" value="'.$collectiondata['homepage_element_1_four_two_style_title'].'" name="homepage_element_1_four_two_style_title"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str .	'<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_four_two_style_link">Link:</label></td>';
      						$str = $str . '<td class="value"><input id="homepage_element_1_four_two_style_link" value="'.$collectiondata['homepage_element_1_four_two_style_link'].'" name="homepage_element_1_four_two_style_link"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_four_two_style_image">Image:</label></td>';
      						//$str = $str . '<td class="value"><div id="buttonshomepage_element_1_four_two_style_image" class="buttons-set"><button type="button" class="scalable show-hide" style="" id="togglehomepage_element_1_four_two_style_image"><span><span><span>Show / Hide Editor</span></span></span></button><button type="button" class="scalable add-widget plugin" onclick="widgetTools.openDialog('.$baseurl.'evolved/widget/index/widget_target_id/homepage_element_1_four_two_style_image)" style=""><span><span><span>Insert Widget...</span></span></span></button><button type="button" class="scalable add-image plugin" onclick="MediabrowserUtility.openDialog('.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_1_four_two_style_image/)" style=""><span><span><span>Insert Image...</span></span></span></button><button type="button" class="scalable add-variable plugin" onclick="MagentovariablePlugin.loadChooser('.$baseurl.'evolved/system_variable/wysiwygPlugin/, homepage_element_1_four_two_style_image);"><span><span><span>Insert Variable...</span></span></span></button></div><textarea name="homepage_element_1_four_two_style_image" title="" id="homepage_element_1_four_two_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_1_four_two_style_image'].'</textarea><small>Image size must be 1920*480 pixels</small></td>';
      						$str = $str . '<td class="value"><button id="togglehomepage_element_1_four_two_style_image" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><div id="buttonshomepage_element_1_four_two_style_image" class="buttons-set"><button style="" onclick="MediabrowserUtility.openDialog(\''.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_1_four_two_style_image/\')" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button></div><textarea name="homepage_element_1_four_two_style_image" title="" id="homepage_element_1_four_two_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_1_four_two_style_image'].'</textarea><small>Image size must be 640*400 pixels</small></td>';
      						$str = $str . '<script type="text/javascript">';
      						$str = $str . ' openEditorPopup = function(url, name, specs, parent) {';
      						$str = $str . ' if ((typeof popups == "undefined") || popups[name] == undefined || popups[name].closed) {';
      						$str = $str . ' if (typeof popups == "undefined") {';
      						$str = $str . ' popups = new Array();';
      						$str = $str . ' }';
      						$str = $str . ' var opener = (parent != undefined ? parent : window);';
      						$str = $str . 'popups[name] = opener.open(url, name, specs);';
      						$str = $str . ' } else {';
      						$str = $str . ' popups[name].focus();';
      						$str = $str . ' }';
      						$str = $str . 'return popups[name];';
      						$str = $str . '}';
      						$str = $str . 'closeEditorPopup = function(name) {';
      						$str = $str . 'if ((typeof popups != "undefined") &amp;&amp; popups[name] != undefined &amp;&amp; !popups[name].closed) {';
      						$str = $str . 'popups[name].close();';
      						$str = $str . '}';
      						$str = $str . '}';
      						$str = $str . ' </script>';
      						$str = $str . '<script type="text/javascript">';
      						$str = $str . 'if ("undefined" != typeof(Translator)) {';
      						$str = $str . 'Translator.add({"Insert Image...":"Insert Image...","Insert Media...":"Insert Media...","Insert File...":"Insert File..."});';
      						$str = $str . '}wysiwyghomepage_element_1_four_two_style_image = new tinyMceWysiwygSetup("homepage_element_1_four_two_style_image", {"enabled":true,"hidden":true,"use_container":false,"add_variables":true,"add_widgets":true,"add_images":true,"no_display":false,"translator":{},"encode_directives":true,"directives_url":"'.$baseurl.'evolved/cms_wysiwyg/directive/","popup_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/dialog.css","content_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/content.css","width":"100%","plugins":[{"name":"magentovariable","src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentovariable/editor_plugin.js","options":{"title":"Insert Variable...","url":"'.$baseurl.'evolved/system_variable/wysiwygPlugin/","onclick":{"search":["html_id"],"subject":"MagentovariablePlugin.loadChooser(\''.$baseurl.'evolved/system_variable/wysiwygPlugin/\', \'{{html_id}}\');"},"class":"add-variable plugin"}}],"directives_url_quoted":"'.$baseurl.'evolved/cms_wysiwyg/directive/","files_browser_window_url":"'.$baseurl.'idealAdmin/cms_wysiwyg_images/index/","files_browser_window_width":1000,"files_browser_window_height":600,"widget_plugin_src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentowidget/editor_plugin.js","widget_images_url":"'.$siteurl.'skin/adminhtml/default/default/images/widget/","widget_placeholders":["Thumbs.db","catalog__category_widget_link.gif","catalog__product_widget_link.gif","catalog__product_widget_new.gif","cms__widget_block.gif","cms__widget_page_link.gif","default.gif","reports__product_widget_compared.gif","reports__product_widget_viewed.gif"],"widget_window_url":"'.$baseurl.'evolved/widget/index/","firebug_warning_title":"Warning","firebug_warning_text":"Firebug is known to make the WYSIWYG editor slow unless it is turned off or configured properly.","firebug_warning_anchor":"Hide"});';
      						$str = $str . 'editorFormValidationHandler = wysiwyghomepage_element_1_four_two_style_image.onFormValidation.bind(wysiwyghomepage_element_1_four_two_style_image);';
      						$str = $str . 'Event.observe("togglehomepage_element_1_four_two_style_image", "click", wysiwyghomepage_element_1_four_two_style_image.toggle.bind(wysiwyghomepage_element_1_four_two_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("formSubmit", editorFormValidationHandler);';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceBeforeSetContent", wysiwyghomepage_element_1_four_two_style_image.beforeSetContent.bind(wysiwyghomepage_element_1_four_two_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceSaveContent", wysiwyghomepage_element_1_four_two_style_image.saveContent.bind(wysiwyghomepage_element_1_four_two_style_image));';
      						$str = $str . 'varienGlobalEvents.clearEventHandlers("open_browser_callback");';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("open_browser_callback", wysiwyghomepage_element_1_four_two_style_image.openFileBrowser.bind(wysiwyghomepage_element_1_four_two_style_image));';
      						$str = $str . '</script>';
      						$str = $str . '</tr>';
      						$str = $str . '</tbody>';
      						$str = $str . '</table>';
      						$str = $str . '<table cellspacing="0" class="form-list allpageelement" style="display: table-cell;">';
							$str = $str . '<tbody>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_four_three_style_title">Title:</label></td>';  
      						$str = $str . '<td class="value"><input id="homepage_element_1_four_three_style_title" value="'.$collectiondata['homepage_element_1_four_three_style_title'].'" name="homepage_element_1_four_three_style_title"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_four_three_style_link">Link:</label></td>';
      						$str = $str . '<td class="value"><input id="homepage_element_1_four_three_style_link" value="'.$collectiondata['homepage_element_1_four_three_style_link'].'" name="homepage_element_1_four_three_style_link"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_four_three_style_image">Image:</label></td>';
      						//$str = $str . '<td class="value"><div id="buttonshomepage_element_1_four_three_style_image" class="buttons-set"><button type="button" class="scalable show-hide" style="" id="togglehomepage_element_1_four_three_style_image"><span><span><span>Show / Hide Editor</span></span></span></button><button type="button" class="scalable add-widget plugin" onclick="widgetTools.openDialog('.$baseurl.'evolved/widget/index/widget_target_id/homepage_element_1_four_three_style_image)" style=""><span><span><span>Insert Widget...</span></span></span></button><button type="button" class="scalable add-image plugin" onclick="MediabrowserUtility.openDialog('.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_1_four_three_style_image/)" style=""><span><span><span>Insert Image...</span></span></span></button><button type="button" class="scalable add-variable plugin" onclick="MagentovariablePlugin.loadChooser('.$baseurl.'evolved/system_variable/wysiwygPlugin/, homepage_element_1_four_three_style_image);"><span><span><span>Insert Variable...</span></span></span></button></div><textarea name="homepage_element_1_four_three_style_image" title="" id="homepage_element_1_four_three_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_1_four_three_style_image'].'</textarea><small>Image size must be 1920*480 pixels</small></td>';
      						$str = $str . '<td class="value"><button id="togglehomepage_element_1_four_three_style_image" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><div id="buttonshomepage_element_1_four_three_style_image" class="buttons-set"><button style="" onclick="MediabrowserUtility.openDialog(\''.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_1_four_three_style_image/\')" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button></div><textarea name="homepage_element_1_four_three_style_image" title="" id="homepage_element_1_four_three_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_1_four_three_style_image'].'</textarea><small>Image size must be 640*400 pixels</small></td>';
      						$str = $str . '<script type="text/javascript">';
      						$str = $str . ' openEditorPopup = function(url, name, specs, parent) {';
      						$str = $str . ' if ((typeof popups == "undefined") || popups[name] == undefined || popups[name].closed) {';
      						$str = $str . ' if (typeof popups == "undefined") {';
      						$str = $str . ' popups = new Array();';
      						$str = $str . ' }';
      						$str = $str . ' var opener = (parent != undefined ? parent : window);';
      						$str = $str . 'popups[name] = opener.open(url, name, specs);';
      						$str = $str . ' } else {';
      						$str = $str . ' popups[name].focus();';
      						$str = $str . ' }';
      						$str = $str . 'return popups[name];';
      						$str = $str . '}';
      						$str = $str . 'closeEditorPopup = function(name) {';
      						$str = $str . 'if ((typeof popups != "undefined") &amp;&amp; popups[name] != undefined &amp;&amp; !popups[name].closed) {';
      						$str = $str . 'popups[name].close();';
      						$str = $str . '}';
      						$str = $str . '}';
      						$str = $str . ' </script>';
      						$str = $str . '<script type="text/javascript">';
      						$str = $str . 'if ("undefined" != typeof(Translator)) {';
      						$str = $str . 'Translator.add({"Insert Image...":"Insert Image...","Insert Media...":"Insert Media...","Insert File...":"Insert File..."});';
      						$str = $str . '}wysiwyghomepage_element_1_four_three_style_image = new tinyMceWysiwygSetup("homepage_element_1_four_three_style_image", {"enabled":true,"hidden":true,"use_container":false,"add_variables":true,"add_widgets":true,"add_images":true,"no_display":false,"translator":{},"encode_directives":true,"directives_url":"'.$baseurl.'evolved/cms_wysiwyg/directive/","popup_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/dialog.css","content_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/content.css","width":"100%","plugins":[{"name":"magentovariable","src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentovariable/editor_plugin.js","options":{"title":"Insert Variable...","url":"'.$baseurl.'evolved/system_variable/wysiwygPlugin/","onclick":{"search":["html_id"],"subject":"MagentovariablePlugin.loadChooser(\''.$baseurl.'evolved/system_variable/wysiwygPlugin/\', \'{{html_id}}\');"},"class":"add-variable plugin"}}],"directives_url_quoted":"'.$baseurl.'evolved/cms_wysiwyg/directive/","files_browser_window_url":"'.$baseurl.'idealAdmin/cms_wysiwyg_images/index/","files_browser_window_width":1000,"files_browser_window_height":600,"widget_plugin_src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentowidget/editor_plugin.js","widget_images_url":"'.$siteurl.'skin/adminhtml/default/default/images/widget/","widget_placeholders":["Thumbs.db","catalog__category_widget_link.gif","catalog__product_widget_link.gif","catalog__product_widget_new.gif","cms__widget_block.gif","cms__widget_page_link.gif","default.gif","reports__product_widget_compared.gif","reports__product_widget_viewed.gif"],"widget_window_url":"'.$baseurl.'evolved/widget/index/","firebug_warning_title":"Warning","firebug_warning_text":"Firebug is known to make the WYSIWYG editor slow unless it is turned off or configured properly.","firebug_warning_anchor":"Hide"});';
      						$str = $str . 'editorFormValidationHandler = wysiwyghomepage_element_1_four_three_style_image.onFormValidation.bind(wysiwyghomepage_element_1_four_three_style_image);';
      						$str = $str . 'Event.observe("togglehomepage_element_1_four_three_style_image", "click", wysiwyghomepage_element_1_four_three_style_image.toggle.bind(wysiwyghomepage_element_1_four_three_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("formSubmit", editorFormValidationHandler);';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceBeforeSetContent", wysiwyghomepage_element_1_four_three_style_image.beforeSetContent.bind(wysiwyghomepage_element_1_four_three_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceSaveContent", wysiwyghomepage_element_1_four_three_style_image.saveContent.bind(wysiwyghomepage_element_1_four_three_style_image));';
      						$str = $str . 'varienGlobalEvents.clearEventHandlers("open_browser_callback");';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("open_browser_callback", wysiwyghomepage_element_1_four_three_style_image.openFileBrowser.bind(wysiwyghomepage_element_1_four_three_style_image));';
      						$str = $str . '</script>';
      						$str = $str . '</tr>';
      						$str = $str . '</tbody>';
      						$str = $str . '</table>';
      						$str = $str . '</td>';
      						$str = $str . '</tr>';
      						$str = $str . '</tbody>';
      						$str = $str . '</table>';
						}
      					//if($selectElement == '33_%_640_by_400_three_boxes_full_width')
      					{
      						//alert('hi');
      						if($selectElement == 'homepage_element_1_33_percentage_640_by_400_three_boxes_full_width')
      						{
      							$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="homepage_element_1_33_percentage_640_by_400_three_boxes_full_width" style="display: block">';
      						}
      						else
      						{
      							$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="homepage_element_1_33_percentage_640_by_400_three_boxes_full_width"  style="display: none">';
      						}
      						//$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="33_percentage_640_by_400_three_boxes_full_width">';
      						$str = $str . '<tbody>';
      						$str = $str . '<tr>';
      						$str = $str . '<td>';
      						$str = $str . '<table cellspacing="0" class="form-list allpageelement" style="display: table-cell;">';
							$str = $str . '<tbody>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_five_one_style_title">Title:</label></td>';  
      						$str = $str . '<td class="value"><input id="homepage_element_1_five_one_style_title" value="'.$collectiondata['homepage_element_1_five_one_style_title'].'" name="homepage_element_1_five_one_style_title"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_five_one_style_link">Link:</label></td>';
      						$str = $str . '<td class="value"><input id="homepage_element_1_five_one_style_link" value="'.$collectiondata['homepage_element_1_five_one_style_link'].'" name="homepage_element_1_five_one_style_link"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_five_one_style_image">Image:</label></td>';
      						//$str = $str . '<td class="value"><div id="buttonshomepage_element_1_five_one_style_image" class="buttons-set"><button type="button" class="scalable show-hide" style="" id="togglehomepage_element_1_five_one_style_image"><span><span><span>Show / Hide Editor</span></span></span></button><button type="button" class="scalable add-widget plugin" onclick="widgetTools.openDialog('.$baseurl.'evolved/widget/index/widget_target_id/homepage_element_1_five_one_style_image)" style=""><span><span><span>Insert Widget...</span></span></span></button><button type="button" class="scalable add-image plugin" onclick="MediabrowserUtility.openDialog('.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_1_five_one_style_image/)" style=""><span><span><span>Insert Image...</span></span></span></button><button type="button" class="scalable add-variable plugin" onclick="MagentovariablePlugin.loadChooser('.$baseurl.'evolved/system_variable/wysiwygPlugin/, homepage_element_1_five_one_style_image);"><span><span><span>Insert Variable...</span></span></span></button></div><textarea name="homepage_element_1_five_one_style_image" title="" id="homepage_element_1_five_one_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_1_five_one_style_image'].'</textarea><small>Image size must be 1920*480 pixels</small></td>';
      						$str = $str . '<td class="value"><button id="togglehomepage_element_1_five_one_style_image" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><div id="buttonshomepage_element_1_five_one_style_image" class="buttons-set"><button style="" onclick="MediabrowserUtility.openDialog(\''.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_1_five_one_style_image/\')" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button></div><textarea name="homepage_element_1_five_one_style_image" title="" id="homepage_element_1_five_one_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_1_five_one_style_image'].'</textarea><small>Image size must be 640*400 pixels</small></td>';
      						$str = $str . '<script type="text/javascript">';
      						$str = $str . ' openEditorPopup = function(url, name, specs, parent) {';
      						$str = $str . ' if ((typeof popups == "undefined") || popups[name] == undefined || popups[name].closed) {';
      						$str = $str . ' if (typeof popups == "undefined") {';
      						$str = $str . ' popups = new Array();';
      						$str = $str . ' }';
      						$str = $str . ' var opener = (parent != undefined ? parent : window);';
      						$str = $str . 'popups[name] = opener.open(url, name, specs);';
      						$str = $str . ' } else {';
      						$str = $str . ' popups[name].focus();';
      						$str = $str . ' }';
      						$str = $str . 'return popups[name];';
      						$str = $str . '}';
      						$str = $str . 'closeEditorPopup = function(name) {';
      						$str = $str . 'if ((typeof popups != "undefined") &amp;&amp; popups[name] != undefined &amp;&amp; !popups[name].closed) {';
      						$str = $str . 'popups[name].close();';
      						$str = $str . '}';
      						$str = $str . '}';
      						$str = $str . ' </script>';
      						$str = $str . '<script type="text/javascript">';
      						$str = $str . 'if ("undefined" != typeof(Translator)) {';
      						$str = $str . 'Translator.add({"Insert Image...":"Insert Image...","Insert Media...":"Insert Media...","Insert File...":"Insert File..."});';
      						$str = $str . '}wysiwyghomepage_element_1_five_one_style_image = new tinyMceWysiwygSetup("homepage_element_1_five_one_style_image", {"enabled":true,"hidden":true,"use_container":false,"add_variables":true,"add_widgets":true,"add_images":true,"no_display":false,"translator":{},"encode_directives":true,"directives_url":"'.$baseurl.'evolved/cms_wysiwyg/directive/","popup_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/dialog.css","content_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/content.css","width":"100%","plugins":[{"name":"magentovariable","src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentovariable/editor_plugin.js","options":{"title":"Insert Variable...","url":"'.$baseurl.'evolved/system_variable/wysiwygPlugin/","onclick":{"search":["html_id"],"subject":"MagentovariablePlugin.loadChooser(\''.$baseurl.'evolved/system_variable/wysiwygPlugin/\', \'{{html_id}}\');"},"class":"add-variable plugin"}}],"directives_url_quoted":"'.$baseurl.'evolved/cms_wysiwyg/directive/","files_browser_window_url":"'.$baseurl.'idealAdmin/cms_wysiwyg_images/index/","files_browser_window_width":1000,"files_browser_window_height":600,"widget_plugin_src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentowidget/editor_plugin.js","widget_images_url":"'.$siteurl.'skin/adminhtml/default/default/images/widget/","widget_placeholders":["Thumbs.db","catalog__category_widget_link.gif","catalog__product_widget_link.gif","catalog__product_widget_new.gif","cms__widget_block.gif","cms__widget_page_link.gif","default.gif","reports__product_widget_compared.gif","reports__product_widget_viewed.gif"],"widget_window_url":"'.$baseurl.'evolved/widget/index/","firebug_warning_title":"Warning","firebug_warning_text":"Firebug is known to make the WYSIWYG editor slow unless it is turned off or configured properly.","firebug_warning_anchor":"Hide"});';
      						$str = $str . 'editorFormValidationHandler = wysiwyghomepage_element_1_five_one_style_image.onFormValidation.bind(wysiwyghomepage_element_1_five_one_style_image);';
      						$str = $str . 'Event.observe("togglehomepage_element_1_five_one_style_image", "click", wysiwyghomepage_element_1_five_one_style_image.toggle.bind(wysiwyghomepage_element_1_five_one_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("formSubmit", editorFormValidationHandler);';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceBeforeSetContent", wysiwyghomepage_element_1_five_one_style_image.beforeSetContent.bind(wysiwyghomepage_element_1_five_one_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceSaveContent", wysiwyghomepage_element_1_five_one_style_image.saveContent.bind(wysiwyghomepage_element_1_five_one_style_image));';
      						$str = $str . 'varienGlobalEvents.clearEventHandlers("open_browser_callback");';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("open_browser_callback", wysiwyghomepage_element_1_five_one_style_image.openFileBrowser.bind(wysiwyghomepage_element_1_five_one_style_image));';
      						$str = $str . '</script>';
      						$str = $str . '</tr>';
      						$str = $str . '</tbody>';
      						$str = $str . '</table>'; 
      						$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelement" style="display: table-cell;">';
							$str = $str . '<tbody>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_five_two_style_title">Title:</label></td>';  
      						$str = $str . '<td class="value"><input id="homepage_element_1_five_two_style_title"  value="'.$collectiondata['homepage_element_1_five_two_style_title'].'" name="homepage_element_1_five_two_style_title"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_five_two_style_link">Link:</label></td>';
      						$str = $str . '<td class="value"><input id="homepage_element_1_five_two_style_link" value="'.$collectiondata['homepage_element_1_five_two_style_link'].'" name="homepage_element_1_five_two_style_link"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_five_two_style_image">Image:</label></td>';
      						//$str = $str . '<td class="value"><div id="buttonshomepage_element_1_five_two_style_image" class="buttons-set"><button type="button" class="scalable show-hide" style="" id="togglehomepage_element_1_five_two_style_image"><span><span><span>Show / Hide Editor</span></span></span></button><button type="button" class="scalable add-widget plugin" onclick="widgetTools.openDialog('.$baseurl.'evolved/widget/index/widget_target_id/homepage_element_1_five_two_style_image)" style=""><span><span><span>Insert Widget...</span></span></span></button><button type="button" class="scalable add-image plugin" onclick="MediabrowserUtility.openDialog('.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_1_five_two_style_image/)" style=""><span><span><span>Insert Image...</span></span></span></button><button type="button" class="scalable add-variable plugin" onclick="MagentovariablePlugin.loadChooser('.$baseurl.'evolved/system_variable/wysiwygPlugin/, homepage_element_1_five_two_style_image);"><span><span><span>Insert Variable...</span></span></span></button></div><textarea name="homepage_element_1_five_two_style_image" title="" id="homepage_element_1_five_two_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_1_five_two_style_image'].'</textarea><small>Image size must be 1920*480 pixels</small></td>';
      						$str = $str . '<td class="value"><button id="togglehomepage_element_1_five_two_style_image" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><div id="buttonshomepage_element_1_five_two_style_image" class="buttons-set"><button style="" onclick="MediabrowserUtility.openDialog(\''.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_1_five_two_style_image/\')" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button></div><textarea name="homepage_element_1_five_two_style_image" title="" id="homepage_element_1_five_two_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_1_five_two_style_image'].'</textarea><small>Image size must be 640*400 pixels</small></td>';
      						$str = $str . '<script type="text/javascript">';
      						$str = $str . ' openEditorPopup = function(url, name, specs, parent) {';
      						$str = $str . ' if ((typeof popups == "undefined") || popups[name] == undefined || popups[name].closed) {';
      						$str = $str . ' if (typeof popups == "undefined") {';
      						$str = $str . ' popups = new Array();';
      						$str = $str . ' }';
      						$str = $str . ' var opener = (parent != undefined ? parent : window);';
      						$str = $str . 'popups[name] = opener.open(url, name, specs);';
      						$str = $str . ' } else {';
      						$str = $str . ' popups[name].focus();';
      						$str = $str . ' }';
      						$str = $str . 'return popups[name];';
      						$str = $str . '}';
      						$str = $str . 'closeEditorPopup = function(name) {';
      						$str = $str . 'if ((typeof popups != "undefined") &amp;&amp; popups[name] != undefined &amp;&amp; !popups[name].closed) {';
      						$str = $str . 'popups[name].close();';
      						$str = $str . '}';
      						$str = $str . '}';
      						$str = $str . ' </script>';
      						$str = $str . '<script type="text/javascript">';
      						$str = $str . 'if ("undefined" != typeof(Translator)) {';
      						$str = $str . 'Translator.add({"Insert Image...":"Insert Image...","Insert Media...":"Insert Media...","Insert File...":"Insert File..."});';
      						$str = $str . '}wysiwyghomepage_element_1_five_two_style_image = new tinyMceWysiwygSetup("homepage_element_1_five_two_style_image", {"enabled":true,"hidden":true,"use_container":false,"add_variables":true,"add_widgets":true,"add_images":true,"no_display":false,"translator":{},"encode_directives":true,"directives_url":"'.$baseurl.'evolved/cms_wysiwyg/directive/","popup_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/dialog.css","content_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/content.css","width":"100%","plugins":[{"name":"magentovariable","src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentovariable/editor_plugin.js","options":{"title":"Insert Variable...","url":"'.$baseurl.'evolved/system_variable/wysiwygPlugin/","onclick":{"search":["html_id"],"subject":"MagentovariablePlugin.loadChooser(\''.$baseurl.'evolved/system_variable/wysiwygPlugin/\', \'{{html_id}}\');"},"class":"add-variable plugin"}}],"directives_url_quoted":"'.$baseurl.'evolved/cms_wysiwyg/directive/","files_browser_window_url":"'.$baseurl.'idealAdmin/cms_wysiwyg_images/index/","files_browser_window_width":1000,"files_browser_window_height":600,"widget_plugin_src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentowidget/editor_plugin.js","widget_images_url":"'.$siteurl.'skin/adminhtml/default/default/images/widget/","widget_placeholders":["Thumbs.db","catalog__category_widget_link.gif","catalog__product_widget_link.gif","catalog__product_widget_new.gif","cms__widget_block.gif","cms__widget_page_link.gif","default.gif","reports__product_widget_compared.gif","reports__product_widget_viewed.gif"],"widget_window_url":"'.$baseurl.'evolved/widget/index/","firebug_warning_title":"Warning","firebug_warning_text":"Firebug is known to make the WYSIWYG editor slow unless it is turned off or configured properly.","firebug_warning_anchor":"Hide"});';
      						$str = $str . 'editorFormValidationHandler = wysiwyghomepage_element_1_five_two_style_image.onFormValidation.bind(wysiwyghomepage_element_1_five_two_style_image);';
      						$str = $str . 'Event.observe("togglehomepage_element_1_five_two_style_image", "click", wysiwyghomepage_element_1_five_two_style_image.toggle.bind(wysiwyghomepage_element_1_five_two_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("formSubmit", editorFormValidationHandler);';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceBeforeSetContent", wysiwyghomepage_element_1_five_two_style_image.beforeSetContent.bind(wysiwyghomepage_element_1_five_two_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceSaveContent", wysiwyghomepage_element_1_five_two_style_image.saveContent.bind(wysiwyghomepage_element_1_five_two_style_image));';
      						$str = $str . 'varienGlobalEvents.clearEventHandlers("open_browser_callback");';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("open_browser_callback", wysiwyghomepage_element_1_five_two_style_image.openFileBrowser.bind(wysiwyghomepage_element_1_five_two_style_image));';
      						$str = $str . '</script>';
      						$str = $str . '</tr>';
      						$str = $str . '</tbody>';
      						$str = $str . '</table>';
      						$str = $str . '<table cellspacing="0" class="form-list allpageelement" style="display: table-cell;">';
							$str = $str . '<tbody>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_five_three_style_title">Title:</label></td>';  
      						$str = $str . '<td class="value"><input id="homepage_element_1_five_three_style_title"  value="'.$collectiondata['homepage_element_1_five_three_style_title'].'" name="homepage_element_1_five_three_style_title"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_five_three_style_link">Link:</label></td>';
      						$str = $str . '<td class="value"><input id="homepage_element_1_five_three_style_link" value="'.$collectiondata['homepage_element_1_five_three_style_link'].'" name="homepage_element_1_five_three_style_link"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_five_three_style_image">Image:</label></td>';
      						//$str = $str . '<td class="value"><div id="buttonshomepage_element_1_five_three_style_image" class="buttons-set"><button type="button" class="scalable show-hide" style="" id="togglehomepage_element_1_five_three_style_image"><span><span><span>Show / Hide Editor</span></span></span></button><button type="button" class="scalable add-widget plugin" onclick="widgetTools.openDialog('.$baseurl.'evolved/widget/index/widget_target_id/homepage_element_1_five_three_style_image)" style=""><span><span><span>Insert Widget...</span></span></span></button><button type="button" class="scalable add-image plugin" onclick="MediabrowserUtility.openDialog('.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_1_five_three_style_image/)" style=""><span><span><span>Insert Image...</span></span></span></button><button type="button" class="scalable add-variable plugin" onclick="MagentovariablePlugin.loadChooser('.$baseurl.'evolved/system_variable/wysiwygPlugin/, homepage_element_1_five_three_style_image);"><span><span><span>Insert Variable...</span></span></span></button></div><textarea name="homepage_element_1_five_three_style_image" title="" id="homepage_element_1_five_three_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_1_five_three_style_image'].'</textarea><small>Image size must be 1920*480 pixels</small></td>';
      						$str = $str . '<td class="value"><button id="togglehomepage_element_1_five_three_style_image" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><div id="buttonshomepage_element_1_five_three_style_image" class="buttons-set"><button style="" onclick="MediabrowserUtility.openDialog(\''.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_1_five_three_style_image/\')" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button></div><textarea name="homepage_element_1_five_three_style_image" title="" id="homepage_element_1_five_three_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_1_five_three_style_image'].'</textarea><small>Image size must be 640*400 pixels</small></td>';
      						$str = $str . '<script type="text/javascript">';
      						$str = $str . ' openEditorPopup = function(url, name, specs, parent) {';
      						$str = $str . ' if ((typeof popups == "undefined") || popups[name] == undefined || popups[name].closed) {';
      						$str = $str . ' if (typeof popups == "undefined") {';
      						$str = $str . ' popups = new Array();';
      						$str = $str . ' }';
      						$str = $str . ' var opener = (parent != undefined ? parent : window);';
      						$str = $str . 'popups[name] = opener.open(url, name, specs);';
      						$str = $str . ' } else {';
      						$str = $str . ' popups[name].focus();';
      						$str = $str . ' }';
      						$str = $str . 'return popups[name];';
      						$str = $str . '}';
      						$str = $str . 'closeEditorPopup = function(name) {';
      						$str = $str . 'if ((typeof popups != "undefined") &amp;&amp; popups[name] != undefined &amp;&amp; !popups[name].closed) {';
      						$str = $str . 'popups[name].close();';
      						$str = $str . '}';
      						$str = $str . '}';
      						$str = $str . ' </script>';
      						$str = $str . '<script type="text/javascript">';
      						$str = $str . 'if ("undefined" != typeof(Translator)) {';
      						$str = $str . 'Translator.add({"Insert Image...":"Insert Image...","Insert Media...":"Insert Media...","Insert File...":"Insert File..."});';
      						$str = $str . '}wysiwyghomepage_element_1_five_three_style_image = new tinyMceWysiwygSetup("homepage_element_1_five_three_style_image", {"enabled":true,"hidden":true,"use_container":false,"add_variables":true,"add_widgets":true,"add_images":true,"no_display":false,"translator":{},"encode_directives":true,"directives_url":"'.$baseurl.'evolved/cms_wysiwyg/directive/","popup_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/dialog.css","content_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/content.css","width":"100%","plugins":[{"name":"magentovariable","src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentovariable/editor_plugin.js","options":{"title":"Insert Variable...","url":"'.$baseurl.'evolved/system_variable/wysiwygPlugin/","onclick":{"search":["html_id"],"subject":"MagentovariablePlugin.loadChooser(\''.$baseurl.'evolved/system_variable/wysiwygPlugin/\', \'{{html_id}}\');"},"class":"add-variable plugin"}}],"directives_url_quoted":"'.$baseurl.'evolved/cms_wysiwyg/directive/","files_browser_window_url":"'.$baseurl.'idealAdmin/cms_wysiwyg_images/index/","files_browser_window_width":1000,"files_browser_window_height":600,"widget_plugin_src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentowidget/editor_plugin.js","widget_images_url":"'.$siteurl.'skin/adminhtml/default/default/images/widget/","widget_placeholders":["Thumbs.db","catalog__category_widget_link.gif","catalog__product_widget_link.gif","catalog__product_widget_new.gif","cms__widget_block.gif","cms__widget_page_link.gif","default.gif","reports__product_widget_compared.gif","reports__product_widget_viewed.gif"],"widget_window_url":"'.$baseurl.'evolved/widget/index/","firebug_warning_title":"Warning","firebug_warning_text":"Firebug is known to make the WYSIWYG editor slow unless it is turned off or configured properly.","firebug_warning_anchor":"Hide"});';
      						$str = $str . 'editorFormValidationHandler = wysiwyghomepage_element_1_five_three_style_image.onFormValidation.bind(wysiwyghomepage_element_1_five_three_style_image);';
      						$str = $str . 'Event.observe("togglehomepage_element_1_five_three_style_image", "click", wysiwyghomepage_element_1_five_three_style_image.toggle.bind(wysiwyghomepage_element_1_five_three_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("formSubmit", editorFormValidationHandler);';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceBeforeSetContent", wysiwyghomepage_element_1_five_three_style_image.beforeSetContent.bind(wysiwyghomepage_element_1_five_three_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceSaveContent", wysiwyghomepage_element_1_five_three_style_image.saveContent.bind(wysiwyghomepage_element_1_five_three_style_image));';
      						$str = $str . 'varienGlobalEvents.clearEventHandlers("open_browser_callback");';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("open_browser_callback", wysiwyghomepage_element_1_five_three_style_image.openFileBrowser.bind(wysiwyghomepage_element_1_five_three_style_image));';
      						$str = $str . '</script>';
      						$str = $str . '</tr>';
      						$str = $str . '</tbody>';
      						$str = $str . '</table>';			
      						$str = $str . '</td>';
      						$str = $str . '</tr>';
      						$str = $str . '</tbody>';
      						$str = $str . '</table>';
      					}
						//if($selectElement == '25_%_480_by_400_four_boxes_full_width')
      					{
      		      			      						//alert('hi');
      						if($selectElement == 'homepage_element_1_25_percentage_480_by_400_four_boxes_full_width')
      						{
      							$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="homepage_element_1_25_percentage_480_by_400_four_boxes_full_width" style="display: block">';
      						}
      						else
      						{
      							$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="homepage_element_1_25_percentage_480_by_400_four_boxes_full_width"  style="display: none">';
      						}
      						//$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="25_percentage_480_by_400_four_boxes_full_width">';
      						$str = $str . '<tbody>';
      						$str = $str . '<tr>';
      						$str = $str . '<td>';
      						$str = $str . '<table cellspacing="0" class="form-list allpageelement" style="display: table-cell;">';
							$str = $str . '<tbody>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_six_one_style_title">Title:</label></td>';  
      						$str = $str . '<td class="value"><input id="homepage_element_1_six_one_style_title" value="'.$collectiondata['homepage_element_1_six_one_style_title'].'" name="homepage_element_1_six_one_style_title"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_six_one_style_link">Link:</label></td>';
      						$str = $str . '<td class="value"><input id="homepage_element_1_six_one_style_link" value="'.$collectiondata['homepage_element_1_six_one_style_link'].'" name="homepage_element_1_six_one_style_link"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_six_one_style_image">Image:</label></td>';
      						//$str = $str . '<td class="value"><div id="buttonshomepage_element_1_six_one_style_image" class="buttons-set"><button type="button" class="scalable show-hide" style="" id="togglehomepage_element_1_six_one_style_image"><span><span><span>Show / Hide Editor</span></span></span></button><button type="button" class="scalable add-widget plugin" onclick="widgetTools.openDialog('.$baseurl.'evolved/widget/index/widget_target_id/homepage_element_1_six_one_style_image)" style=""><span><span><span>Insert Widget...</span></span></span></button><button type="button" class="scalable add-image plugin" onclick="MediabrowserUtility.openDialog('.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_1_six_one_style_image/)" style=""><span><span><span>Insert Image...</span></span></span></button><button type="button" class="scalable add-variable plugin" onclick="MagentovariablePlugin.loadChooser('.$baseurl.'evolved/system_variable/wysiwygPlugin/, homepage_element_1_six_one_style_image);"><span><span><span>Insert Variable...</span></span></span></button></div><textarea name="homepage_element_1_six_one_style_image" title="" id="homepage_element_1_six_one_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_1_six_one_style_image'].'</textarea><small>Image size must be 1920*480 pixels</small></td>';
      						$str = $str . '<td class="value"><button id="togglehomepage_element_1_six_one_style_image" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><div id="buttonshomepage_element_1_six_one_style_image" class="buttons-set"><button style="" onclick="MediabrowserUtility.openDialog(\''.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_1_six_one_style_image/\')" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button></div><textarea name="homepage_element_1_six_one_style_image" title="" id="homepage_element_1_six_one_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_1_six_one_style_image'].'</textarea><small>Image size must be 480*400 pixels</small></td>';
      						$str = $str . '<script type="text/javascript">';
      						$str = $str . ' openEditorPopup = function(url, name, specs, parent) {';
      						$str = $str . ' if ((typeof popups == "undefined") || popups[name] == undefined || popups[name].closed) {';
      						$str = $str . ' if (typeof popups == "undefined") {';
      						$str = $str . ' popups = new Array();';
      						$str = $str . ' }';
      						$str = $str . ' var opener = (parent != undefined ? parent : window);';
      						$str = $str . 'popups[name] = opener.open(url, name, specs);';
      						$str = $str . ' } else {';
      						$str = $str . ' popups[name].focus();';
      						$str = $str . ' }';
      						$str = $str . 'return popups[name];';
      						$str = $str . '}';
      						$str = $str . 'closeEditorPopup = function(name) {';
      						$str = $str . 'if ((typeof popups != "undefined") &amp;&amp; popups[name] != undefined &amp;&amp; !popups[name].closed) {';
      						$str = $str . 'popups[name].close();';
      						$str = $str . '}';
      						$str = $str . '}';
      						$str = $str . ' </script>';
      						$str = $str . '<script type="text/javascript">';
      						$str = $str . 'if ("undefined" != typeof(Translator)) {';
      						$str = $str . 'Translator.add({"Insert Image...":"Insert Image...","Insert Media...":"Insert Media...","Insert File...":"Insert File..."});';
      						$str = $str . '}wysiwyghomepage_element_1_six_one_style_image = new tinyMceWysiwygSetup("homepage_element_1_six_one_style_image", {"enabled":true,"hidden":true,"use_container":false,"add_variables":true,"add_widgets":true,"add_images":true,"no_display":false,"translator":{},"encode_directives":true,"directives_url":"'.$baseurl.'evolved/cms_wysiwyg/directive/","popup_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/dialog.css","content_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/content.css","width":"100%","plugins":[{"name":"magentovariable","src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentovariable/editor_plugin.js","options":{"title":"Insert Variable...","url":"'.$baseurl.'evolved/system_variable/wysiwygPlugin/","onclick":{"search":["html_id"],"subject":"MagentovariablePlugin.loadChooser(\''.$baseurl.'evolved/system_variable/wysiwygPlugin/\', \'{{html_id}}\');"},"class":"add-variable plugin"}}],"directives_url_quoted":"'.$baseurl.'evolved/cms_wysiwyg/directive/","files_browser_window_url":"'.$baseurl.'idealAdmin/cms_wysiwyg_images/index/","files_browser_window_width":1000,"files_browser_window_height":600,"widget_plugin_src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentowidget/editor_plugin.js","widget_images_url":"'.$siteurl.'skin/adminhtml/default/default/images/widget/","widget_placeholders":["Thumbs.db","catalog__category_widget_link.gif","catalog__product_widget_link.gif","catalog__product_widget_new.gif","cms__widget_block.gif","cms__widget_page_link.gif","default.gif","reports__product_widget_compared.gif","reports__product_widget_viewed.gif"],"widget_window_url":"'.$baseurl.'evolved/widget/index/","firebug_warning_title":"Warning","firebug_warning_text":"Firebug is known to make the WYSIWYG editor slow unless it is turned off or configured properly.","firebug_warning_anchor":"Hide"});';
      						$str = $str . 'editorFormValidationHandler = wysiwyghomepage_element_1_six_one_style_image.onFormValidation.bind(wysiwyghomepage_element_1_six_one_style_image);';
      						$str = $str . 'Event.observe("togglehomepage_element_1_six_one_style_image", "click", wysiwyghomepage_element_1_six_one_style_image.toggle.bind(wysiwyghomepage_element_1_six_one_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("formSubmit", editorFormValidationHandler);';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceBeforeSetContent", wysiwyghomepage_element_1_six_one_style_image.beforeSetContent.bind(wysiwyghomepage_element_1_six_one_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceSaveContent", wysiwyghomepage_element_1_six_one_style_image.saveContent.bind(wysiwyghomepage_element_1_six_one_style_image));';
      						$str = $str . 'varienGlobalEvents.clearEventHandlers("open_browser_callback");';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("open_browser_callback", wysiwyghomepage_element_1_six_one_style_image.openFileBrowser.bind(wysiwyghomepage_element_1_six_one_style_image));';
      						$str = $str . '</script>';
      						$str = $str . '</tr>';
      						$str = $str . '</tbody>';
      						$str = $str . '</table>'; 
      						$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelement" style="display: table-cell;">';
							$str = $str . '<tbody>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_six_two_style_title">Title:</label></td>';  
      						$str = $str . '<td class="value"><input id="homepage_element_1_six_two_style_title" value="'.$collectiondata['homepage_element_1_six_two_style_title'].'" name="homepage_element_1_six_two_style_title"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_six_two_style_link">Link:</label></td>';
      						$str = $str . '<td class="value"><input id="homepage_element_1_six_two_style_link" value="'.$collectiondata['homepage_element_1_six_two_style_link'].'" name="homepage_element_1_six_two_style_link"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_six_two_style_image">Image:</label></td>';
      						//$str = $str . '<td class="value"><div id="buttonshomepage_element_1_six_two_style_image" class="buttons-set"><button type="button" class="scalable show-hide" style="" id="togglehomepage_element_1_six_two_style_image"><span><span><span>Show / Hide Editor</span></span></span></button><button type="button" class="scalable add-widget plugin" onclick="widgetTools.openDialog('.$baseurl.'evolved/widget/index/widget_target_id/homepage_element_1_six_two_style_image)" style=""><span><span><span>Insert Widget...</span></span></span></button><button type="button" class="scalable add-image plugin" onclick="MediabrowserUtility.openDialog('.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_1_six_two_style_image/)" style=""><span><span><span>Insert Image...</span></span></span></button><button type="button" class="scalable add-variable plugin" onclick="MagentovariablePlugin.loadChooser('.$baseurl.'evolved/system_variable/wysiwygPlugin/, homepage_element_1_six_two_style_image);"><span><span><span>Insert Variable...</span></span></span></button></div><textarea name="homepage_element_1_six_two_style_image" title="" id="homepage_element_1_six_two_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_1_six_two_style_image'].'</textarea><small>Image size must be 1920*480 pixels</small></td>';
      						$str = $str . '<td class="value"><button id="togglehomepage_element_1_six_two_style_image" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><div id="buttonshomepage_element_1_six_two_style_image" class="buttons-set"><button style="" onclick="MediabrowserUtility.openDialog(\''.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_1_six_two_style_image/\')" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button></div><textarea name="homepage_element_1_six_two_style_image" title="" id="homepage_element_1_six_two_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_1_six_two_style_image'].'</textarea><small>Image size must be 480*400 pixels</small></td>';
      						$str = $str . '<script type="text/javascript">';
      						$str = $str . ' openEditorPopup = function(url, name, specs, parent) {';
      						$str = $str . ' if ((typeof popups == "undefined") || popups[name] == undefined || popups[name].closed) {';
      						$str = $str . ' if (typeof popups == "undefined") {';
      						$str = $str . ' popups = new Array();';
      						$str = $str . ' }';
      						$str = $str . ' var opener = (parent != undefined ? parent : window);';
      						$str = $str . 'popups[name] = opener.open(url, name, specs);';
      						$str = $str . ' } else {';
      						$str = $str . ' popups[name].focus();';
      						$str = $str . ' }';
      						$str = $str . 'return popups[name];';
      						$str = $str . '}';
      						$str = $str . 'closeEditorPopup = function(name) {';
      						$str = $str . 'if ((typeof popups != "undefined") &amp;&amp; popups[name] != undefined &amp;&amp; !popups[name].closed) {';
      						$str = $str . 'popups[name].close();';
      						$str = $str . '}';
      						$str = $str . '}';
      						$str = $str . ' </script>';
      						$str = $str . '<script type="text/javascript">';
      						$str = $str . 'if ("undefined" != typeof(Translator)) {';
      						$str = $str . 'Translator.add({"Insert Image...":"Insert Image...","Insert Media...":"Insert Media...","Insert File...":"Insert File..."});';
      						$str = $str . '}wysiwyghomepage_element_1_six_two_style_image = new tinyMceWysiwygSetup("homepage_element_1_six_two_style_image", {"enabled":true,"hidden":true,"use_container":false,"add_variables":true,"add_widgets":true,"add_images":true,"no_display":false,"translator":{},"encode_directives":true,"directives_url":"'.$baseurl.'evolved/cms_wysiwyg/directive/","popup_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/dialog.css","content_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/content.css","width":"100%","plugins":[{"name":"magentovariable","src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentovariable/editor_plugin.js","options":{"title":"Insert Variable...","url":"'.$baseurl.'evolved/system_variable/wysiwygPlugin/","onclick":{"search":["html_id"],"subject":"MagentovariablePlugin.loadChooser(\''.$baseurl.'evolved/system_variable/wysiwygPlugin/\', \'{{html_id}}\');"},"class":"add-variable plugin"}}],"directives_url_quoted":"'.$baseurl.'evolved/cms_wysiwyg/directive/","files_browser_window_url":"'.$baseurl.'idealAdmin/cms_wysiwyg_images/index/","files_browser_window_width":1000,"files_browser_window_height":600,"widget_plugin_src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentowidget/editor_plugin.js","widget_images_url":"'.$siteurl.'skin/adminhtml/default/default/images/widget/","widget_placeholders":["Thumbs.db","catalog__category_widget_link.gif","catalog__product_widget_link.gif","catalog__product_widget_new.gif","cms__widget_block.gif","cms__widget_page_link.gif","default.gif","reports__product_widget_compared.gif","reports__product_widget_viewed.gif"],"widget_window_url":"'.$baseurl.'evolved/widget/index/","firebug_warning_title":"Warning","firebug_warning_text":"Firebug is known to make the WYSIWYG editor slow unless it is turned off or configured properly.","firebug_warning_anchor":"Hide"});';
      						$str = $str . 'editorFormValidationHandler = wysiwyghomepage_element_1_six_two_style_image.onFormValidation.bind(wysiwyghomepage_element_1_six_two_style_image);';
      						$str = $str . 'Event.observe("togglehomepage_element_1_six_two_style_image", "click", wysiwyghomepage_element_1_six_two_style_image.toggle.bind(wysiwyghomepage_element_1_six_two_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("formSubmit", editorFormValidationHandler);';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceBeforeSetContent", wysiwyghomepage_element_1_six_two_style_image.beforeSetContent.bind(wysiwyghomepage_element_1_six_two_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceSaveContent", wysiwyghomepage_element_1_six_two_style_image.saveContent.bind(wysiwyghomepage_element_1_six_two_style_image));';
      						$str = $str . 'varienGlobalEvents.clearEventHandlers("open_browser_callback");';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("open_browser_callback", wysiwyghomepage_element_1_six_two_style_image.openFileBrowser.bind(wysiwyghomepage_element_1_six_two_style_image));';
      						$str = $str . '</script>';
      						$str = $str . '</tr>';
      						$str = $str . '</tbody>';
      						$str = $str . '</table>';
      						$str = $str . '<table cellspacing="0" class="form-list allpageelement" style="display: table-cell;">';
							$str = $str . '<tbody>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_six_three_style_title">Title:</label></td>';  
      						$str = $str . '<td class="value"><input id="homepage_element_1_six_three_style_title" value="'.$collectiondata['homepage_element_1_six_three_style_title'].'" name="homepage_element_1_six_three_style_title"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_six_three_style_link">Link:</label></td>';
      						$str = $str . '<td class="value"><input id="homepage_element_1_six_three_style_link" value="'.$collectiondata['homepage_element_1_six_three_style_link'].'" name="homepage_element_1_six_three_style_link"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_six_three_style_image">Image:</label></td>';
      						//$str = $str . '<td class="value"><div id="buttonshomepage_element_1_six_three_style_image" class="buttons-set"><button type="button" class="scalable show-hide" style="" id="togglehomepage_element_1_six_three_style_image"><span><span><span>Show / Hide Editor</span></span></span></button><button type="button" class="scalable add-widget plugin" onclick="widgetTools.openDialog('.$baseurl.'evolved/widget/index/widget_target_id/homepage_element_1_six_three_style_image)" style=""><span><span><span>Insert Widget...</span></span></span></button><button type="button" class="scalable add-image plugin" onclick="MediabrowserUtility.openDialog('.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_1_six_three_style_image/)" style=""><span><span><span>Insert Image...</span></span></span></button><button type="button" class="scalable add-variable plugin" onclick="MagentovariablePlugin.loadChooser('.$baseurl.'evolved/system_variable/wysiwygPlugin/, homepage_element_1_six_three_style_image);"><span><span><span>Insert Variable...</span></span></span></button></div><textarea name="homepage_element_1_six_three_style_image" title="" id="homepage_element_1_six_three_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_1_six_three_style_image'].'</textarea><small>Image size must be 1920*480 pixels</small></td>';
      						$str = $str . '<td class="value"><button id="togglehomepage_element_1_six_three_style_image" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><div id="buttonshomepage_element_1_six_three_style_image" class="buttons-set"><button style="" onclick="MediabrowserUtility.openDialog(\''.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_1_six_three_style_image/\')" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button></div><textarea name="homepage_element_1_six_three_style_image" title="" id="homepage_element_1_six_three_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_1_six_three_style_image'].'</textarea><small>Image size must be 480*400 pixels</small></td>';
      						$str = $str . '<script type="text/javascript">';
      						$str = $str . ' openEditorPopup = function(url, name, specs, parent) {';
      						$str = $str . ' if ((typeof popups == "undefined") || popups[name] == undefined || popups[name].closed) {';
      						$str = $str . ' if (typeof popups == "undefined") {';
      						$str = $str . ' popups = new Array();';
      						$str = $str . ' }';
      						$str = $str . ' var opener = (parent != undefined ? parent : window);';
      						$str = $str . 'popups[name] = opener.open(url, name, specs);';
      						$str = $str . ' } else {';
      						$str = $str . ' popups[name].focus();';
      						$str = $str . ' }';
      						$str = $str . 'return popups[name];';
      						$str = $str . '}';
      						$str = $str . 'closeEditorPopup = function(name) {';
      						$str = $str . 'if ((typeof popups != "undefined") &amp;&amp; popups[name] != undefined &amp;&amp; !popups[name].closed) {';
      						$str = $str . 'popups[name].close();';
      						$str = $str . '}';
      						$str = $str . '}';
      						$str = $str . ' </script>';
      						$str = $str . '<script type="text/javascript">';
      						$str = $str . 'if ("undefined" != typeof(Translator)) {';
      						$str = $str . 'Translator.add({"Insert Image...":"Insert Image...","Insert Media...":"Insert Media...","Insert File...":"Insert File..."});';
      						$str = $str . '}wysiwyghomepage_element_1_six_three_style_image = new tinyMceWysiwygSetup("homepage_element_1_six_three_style_image", {"enabled":true,"hidden":true,"use_container":false,"add_variables":true,"add_widgets":true,"add_images":true,"no_display":false,"translator":{},"encode_directives":true,"directives_url":"'.$baseurl.'evolved/cms_wysiwyg/directive/","popup_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/dialog.css","content_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/content.css","width":"100%","plugins":[{"name":"magentovariable","src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentovariable/editor_plugin.js","options":{"title":"Insert Variable...","url":"'.$baseurl.'evolved/system_variable/wysiwygPlugin/","onclick":{"search":["html_id"],"subject":"MagentovariablePlugin.loadChooser(\''.$baseurl.'evolved/system_variable/wysiwygPlugin/\', \'{{html_id}}\');"},"class":"add-variable plugin"}}],"directives_url_quoted":"'.$baseurl.'evolved/cms_wysiwyg/directive/","files_browser_window_url":"'.$baseurl.'idealAdmin/cms_wysiwyg_images/index/","files_browser_window_width":1000,"files_browser_window_height":600,"widget_plugin_src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentowidget/editor_plugin.js","widget_images_url":"'.$siteurl.'skin/adminhtml/default/default/images/widget/","widget_placeholders":["Thumbs.db","catalog__category_widget_link.gif","catalog__product_widget_link.gif","catalog__product_widget_new.gif","cms__widget_block.gif","cms__widget_page_link.gif","default.gif","reports__product_widget_compared.gif","reports__product_widget_viewed.gif"],"widget_window_url":"'.$baseurl.'evolved/widget/index/","firebug_warning_title":"Warning","firebug_warning_text":"Firebug is known to make the WYSIWYG editor slow unless it is turned off or configured properly.","firebug_warning_anchor":"Hide"});';
      						$str = $str . 'editorFormValidationHandler = wysiwyghomepage_element_1_six_three_style_image.onFormValidation.bind(wysiwyghomepage_element_1_six_three_style_image);';
      						$str = $str . 'Event.observe("togglehomepage_element_1_six_three_style_image", "click", wysiwyghomepage_element_1_six_three_style_image.toggle.bind(wysiwyghomepage_element_1_six_three_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("formSubmit", editorFormValidationHandler);';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceBeforeSetContent", wysiwyghomepage_element_1_six_three_style_image.beforeSetContent.bind(wysiwyghomepage_element_1_six_three_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceSaveContent", wysiwyghomepage_element_1_six_three_style_image.saveContent.bind(wysiwyghomepage_element_1_six_three_style_image));';
      						$str = $str . 'varienGlobalEvents.clearEventHandlers("open_browser_callback");';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("open_browser_callback", wysiwyghomepage_element_1_six_three_style_image.openFileBrowser.bind(wysiwyghomepage_element_1_six_three_style_image));';
      						$str = $str . '</script>';
      						$str = $str . '</tr>';
      						$str = $str . '</tbody>';
      						$str = $str . '</table>';
      						$str = $str . '<table cellspacing="0" class="form-list allpageelement" style="display: table-cell;">';
							$str = $str . '<tbody>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_six_four_style_title">Title:</label></td>';  
      						$str = $str . '<td class="value"><input id="homepage_element_1_six_four_style_title" value="'.$collectiondata['homepage_element_1_six_four_style_title'].'" name="homepage_element_1_six_four_style_title"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_six_four_style_link">Link:</label></td>';
      						$str = $str . '<td class="value"><input id="homepage_element_1_six_four_style_link" value="'.$collectiondata['homepage_element_1_six_four_style_link'].'" name="homepage_element_1_six_four_style_link"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_six_four_style_image">Image:</label></td>';
      						//$str = $str . '<td class="value"><div id="buttonshomepage_element_1_six_four_style_image" class="buttons-set"><button type="button" class="scalable show-hide" style="" id="togglehomepage_element_1_six_four_style_image"><span><span><span>Show / Hide Editor</span></span></span></button><button type="button" class="scalable add-widget plugin" onclick="widgetTools.openDialog('.$baseurl.'evolved/widget/index/widget_target_id/homepage_element_1_six_four_style_image)" style=""><span><span><span>Insert Widget...</span></span></span></button><button type="button" class="scalable add-image plugin" onclick="MediabrowserUtility.openDialog('.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_1_six_four_style_image/)" style=""><span><span><span>Insert Image...</span></span></span></button><button type="button" class="scalable add-variable plugin" onclick="MagentovariablePlugin.loadChooser('.$baseurl.'evolved/system_variable/wysiwygPlugin/, homepage_element_1_six_four_style_image);"><span><span><span>Insert Variable...</span></span></span></button></div><textarea name="homepage_element_1_six_four_style_image" title="" id="homepage_element_1_six_four_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_1_six_four_style_image'].'</textarea><small>Image size must be 1920*480 pixels</small></td>';
      						$str = $str . '<td class="value"><button id="togglehomepage_element_1_six_four_style_image" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><div id="buttonshomepage_element_1_six_four_style_image" class="buttons-set"><button style="" onclick="MediabrowserUtility.openDialog(\''.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_1_six_four_style_image/\')" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button></div><textarea name="homepage_element_1_six_four_style_image" title="" id="homepage_element_1_six_four_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_1_six_four_style_image'].'</textarea><small>Image size must be 480*400 pixels</small></td>';
      						$str = $str . '<script type="text/javascript">';
      						$str = $str . ' openEditorPopup = function(url, name, specs, parent) {';
      						$str = $str . ' if ((typeof popups == "undefined") || popups[name] == undefined || popups[name].closed) {';
      						$str = $str . ' if (typeof popups == "undefined") {';
      						$str = $str . ' popups = new Array();';
      						$str = $str . ' }';
      						$str = $str . ' var opener = (parent != undefined ? parent : window);';
      						$str = $str . 'popups[name] = opener.open(url, name, specs);';
      						$str = $str . ' } else {';
      						$str = $str . ' popups[name].focus();';
      						$str = $str . ' }';
      						$str = $str . 'return popups[name];';
      						$str = $str . '}';
      						$str = $str . 'closeEditorPopup = function(name) {';
      						$str = $str . 'if ((typeof popups != "undefined") &amp;&amp; popups[name] != undefined &amp;&amp; !popups[name].closed) {';
      						$str = $str . 'popups[name].close();';
      						$str = $str . '}';
      						$str = $str . '}';
      						$str = $str . ' </script>';
      						$str = $str . '<script type="text/javascript">';
      						$str = $str . 'if ("undefined" != typeof(Translator)) {';
      						$str = $str . 'Translator.add({"Insert Image...":"Insert Image...","Insert Media...":"Insert Media...","Insert File...":"Insert File..."});';
      						$str = $str . '}wysiwyghomepage_element_1_six_four_style_image = new tinyMceWysiwygSetup("homepage_element_1_six_four_style_image", {"enabled":true,"hidden":true,"use_container":false,"add_variables":true,"add_widgets":true,"add_images":true,"no_display":false,"translator":{},"encode_directives":true,"directives_url":"'.$baseurl.'evolved/cms_wysiwyg/directive/","popup_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/dialog.css","content_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/content.css","width":"100%","plugins":[{"name":"magentovariable","src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentovariable/editor_plugin.js","options":{"title":"Insert Variable...","url":"'.$baseurl.'evolved/system_variable/wysiwygPlugin/","onclick":{"search":["html_id"],"subject":"MagentovariablePlugin.loadChooser(\''.$baseurl.'evolved/system_variable/wysiwygPlugin/\', \'{{html_id}}\');"},"class":"add-variable plugin"}}],"directives_url_quoted":"'.$baseurl.'evolved/cms_wysiwyg/directive/","files_browser_window_url":"'.$baseurl.'idealAdmin/cms_wysiwyg_images/index/","files_browser_window_width":1000,"files_browser_window_height":600,"widget_plugin_src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentowidget/editor_plugin.js","widget_images_url":"'.$siteurl.'skin/adminhtml/default/default/images/widget/","widget_placeholders":["Thumbs.db","catalog__category_widget_link.gif","catalog__product_widget_link.gif","catalog__product_widget_new.gif","cms__widget_block.gif","cms__widget_page_link.gif","default.gif","reports__product_widget_compared.gif","reports__product_widget_viewed.gif"],"widget_window_url":"'.$baseurl.'evolved/widget/index/","firebug_warning_title":"Warning","firebug_warning_text":"Firebug is known to make the WYSIWYG editor slow unless it is turned off or configured properly.","firebug_warning_anchor":"Hide"});';
      						$str = $str . 'editorFormValidationHandler = wysiwyghomepage_element_1_six_four_style_image.onFormValidation.bind(wysiwyghomepage_element_1_six_four_style_image);';
      						$str = $str . 'Event.observe("togglehomepage_element_1_six_four_style_image", "click", wysiwyghomepage_element_1_six_four_style_image.toggle.bind(wysiwyghomepage_element_1_six_four_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("formSubmit", editorFormValidationHandler);';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceBeforeSetContent", wysiwyghomepage_element_1_six_four_style_image.beforeSetContent.bind(wysiwyghomepage_element_1_six_four_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceSaveContent", wysiwyghomepage_element_1_six_four_style_image.saveContent.bind(wysiwyghomepage_element_1_six_four_style_image));';
      						$str = $str . 'varienGlobalEvents.clearEventHandlers("open_browser_callback");';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("open_browser_callback", wysiwyghomepage_element_1_six_four_style_image.openFileBrowser.bind(wysiwyghomepage_element_1_six_four_style_image));';
      						$str = $str . '</script>';
      						$str = $str . '</tr>';
      						$str = $str . '</tbody>';
      						$str = $str . '</table>';
      						$str = $str . '</td>';
      						$str = $str . '</tr>';
      						$str = $str . '</tbody>';
      						$str = $str . '</table>';
      					}
      					//if($selectElement == '33_%_346_by_170_three_boxes_width')
      					{
      						if($selectElement == 'homepage_element_1_33_percentage_346_by_170_three_boxes_width')
      						{
      							$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="homepage_element_1_33_percentage_346_by_170_three_boxes_width" style="display: block">';
      						}
      						else
      						{
      							$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="homepage_element_1_33_percentage_346_by_170_three_boxes_width"  style="display: none">';
      						}
      						//$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="33_percentage_346_by_170_three_boxes_width">';
      						$str = $str . '<tbody>';
      						$str = $str . '<tr>';
      						$str = $str . '<td>';
      						$str = $str . '<table cellspacing="0" class="form-list allpageelement" style="display: table-cell;">';
							$str = $str . '<tbody>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_seven_one_style_title">Title:</label></td>';  
      						$str = $str . '<td class="value"><input id="homepage_element_1_seven_one_style_title" value="'.$collectiondata['homepage_element_1_seven_one_style_title'].'" name="homepage_element_1_seven_one_style_title"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_seven_one_style_link">Link:</label></td>';
      						$str = $str . '<td class="value"><input id="homepage_element_1_seven_one_style_link" value="'.$collectiondata['homepage_element_1_seven_one_style_link'].'" name="homepage_element_1_seven_one_style_link"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_seven_one_style_image">Image:</label></td>';
      						//$str = $str . '<td class="value"><div id="buttonshomepage_element_1_seven_one_style_image" class="buttons-set"><button type="button" class="scalable show-hide" style="" id="togglehomepage_element_1_seven_one_style_image"><span><span><span>Show / Hide Editor</span></span></span></button><button type="button" class="scalable add-widget plugin" onclick="widgetTools.openDialog('.$baseurl.'evolved/widget/index/widget_target_id/homepage_element_1_seven_one_style_image)" style=""><span><span><span>Insert Widget...</span></span></span></button><button type="button" class="scalable add-image plugin" onclick="MediabrowserUtility.openDialog('.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_1_seven_one_style_image/)" style=""><span><span><span>Insert Image...</span></span></span></button><button type="button" class="scalable add-variable plugin" onclick="MagentovariablePlugin.loadChooser('.$baseurl.'evolved/system_variable/wysiwygPlugin/, homepage_element_1_seven_one_style_image);"><span><span><span>Insert Variable...</span></span></span></button></div><textarea name="homepage_element_1_seven_one_style_image" title="" id="homepage_element_1_seven_one_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_1_seven_one_style_image'].'</textarea><small>Image size must be 1920*480 pixels</small></td>';
      						$str = $str . '<td class="value"><button id="togglehomepage_element_1_seven_one_style_image" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><div id="buttonshomepage_element_1_seven_one_style_image" class="buttons-set"><button style="" onclick="MediabrowserUtility.openDialog(\''.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_1_seven_one_style_image/\')" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button></div><textarea name="homepage_element_1_seven_one_style_image" title="" id="homepage_element_1_seven_one_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_1_seven_one_style_image'].'</textarea><small>Image size must be 346*170 pixels</small></td>';
      						$str = $str . '<script type="text/javascript">';
      						$str = $str . ' openEditorPopup = function(url, name, specs, parent) {';
      						$str = $str . ' if ((typeof popups == "undefined") || popups[name] == undefined || popups[name].closed) {';
      						$str = $str . ' if (typeof popups == "undefined") {';
      						$str = $str . ' popups = new Array();';
      						$str = $str . ' }';
      						$str = $str . ' var opener = (parent != undefined ? parent : window);';
      						$str = $str . 'popups[name] = opener.open(url, name, specs);';
      						$str = $str . ' } else {';
      						$str = $str . ' popups[name].focus();';
      						$str = $str . ' }';
      						$str = $str . 'return popups[name];';
      						$str = $str . '}';
      						$str = $str . 'closeEditorPopup = function(name) {';
      						$str = $str . 'if ((typeof popups != "undefined") &amp;&amp; popups[name] != undefined &amp;&amp; !popups[name].closed) {';
      						$str = $str . 'popups[name].close();';
      						$str = $str . '}';
      						$str = $str . '}';
      						$str = $str . ' </script>';
      						$str = $str . '<script type="text/javascript">';
      						$str = $str . 'if ("undefined" != typeof(Translator)) {';
      						$str = $str . 'Translator.add({"Insert Image...":"Insert Image...","Insert Media...":"Insert Media...","Insert File...":"Insert File..."});';
      						$str = $str . '}wysiwyghomepage_element_1_seven_one_style_image = new tinyMceWysiwygSetup("homepage_element_1_seven_one_style_image", {"enabled":true,"hidden":true,"use_container":false,"add_variables":true,"add_widgets":true,"add_images":true,"no_display":false,"translator":{},"encode_directives":true,"directives_url":"'.$baseurl.'evolved/cms_wysiwyg/directive/","popup_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/dialog.css","content_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/content.css","width":"100%","plugins":[{"name":"magentovariable","src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentovariable/editor_plugin.js","options":{"title":"Insert Variable...","url":"'.$baseurl.'evolved/system_variable/wysiwygPlugin/","onclick":{"search":["html_id"],"subject":"MagentovariablePlugin.loadChooser(\''.$baseurl.'evolved/system_variable/wysiwygPlugin/\', \'{{html_id}}\');"},"class":"add-variable plugin"}}],"directives_url_quoted":"'.$baseurl.'evolved/cms_wysiwyg/directive/","files_browser_window_url":"'.$baseurl.'idealAdmin/cms_wysiwyg_images/index/","files_browser_window_width":1000,"files_browser_window_height":600,"widget_plugin_src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentowidget/editor_plugin.js","widget_images_url":"'.$siteurl.'skin/adminhtml/default/default/images/widget/","widget_placeholders":["Thumbs.db","catalog__category_widget_link.gif","catalog__product_widget_link.gif","catalog__product_widget_new.gif","cms__widget_block.gif","cms__widget_page_link.gif","default.gif","reports__product_widget_compared.gif","reports__product_widget_viewed.gif"],"widget_window_url":"'.$baseurl.'evolved/widget/index/","firebug_warning_title":"Warning","firebug_warning_text":"Firebug is known to make the WYSIWYG editor slow unless it is turned off or configured properly.","firebug_warning_anchor":"Hide"});';
      						$str = $str . 'editorFormValidationHandler = wysiwyghomepage_element_1_seven_one_style_image.onFormValidation.bind(wysiwyghomepage_element_1_seven_one_style_image);';
      						$str = $str . 'Event.observe("togglehomepage_element_1_seven_one_style_image", "click", wysiwyghomepage_element_1_seven_one_style_image.toggle.bind(wysiwyghomepage_element_1_seven_one_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("formSubmit", editorFormValidationHandler);';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceBeforeSetContent", wysiwyghomepage_element_1_seven_one_style_image.beforeSetContent.bind(wysiwyghomepage_element_1_seven_one_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceSaveContent", wysiwyghomepage_element_1_seven_one_style_image.saveContent.bind(wysiwyghomepage_element_1_seven_one_style_image));';
      						$str = $str . 'varienGlobalEvents.clearEventHandlers("open_browser_callback");';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("open_browser_callback", wysiwyghomepage_element_1_seven_one_style_image.openFileBrowser.bind(wysiwyghomepage_element_1_seven_one_style_image));';
      						$str = $str . '</script>';
      						$str = $str . '</tr>';
      						$str = $str . '</tbody>';
      						$str = $str . '</table>'; 
      						$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelement" style="display: table-cell;">';
							$str = $str . '<tbody>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_seven_two_style_title">Title:</label></td>';  
      						$str = $str . '<td class="value"><input id="homepage_element_1_seven_two_style_title" value="'.$collectiondata['homepage_element_1_seven_two_style_title'].'" name="homepage_element_1_seven_two_style_title"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_seven_two_style_link">Link:</label></td>';
      						$str = $str . '<td class="value"><input id="homepage_element_1_seven_two_style_link" value="'.$collectiondata['homepage_element_1_seven_two_style_link'].'" name="homepage_element_1_seven_two_style_link"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_seven_two_style_image">Image:</label></td>';
      						//$str = $str . '<td class="value"><div id="buttonshomepage_element_1_seven_two_style_image" class="buttons-set"><button type="button" class="scalable show-hide" style="" id="togglehomepage_element_1_seven_two_style_image"><span><span><span>Show / Hide Editor</span></span></span></button><button type="button" class="scalable add-widget plugin" onclick="widgetTools.openDialog('.$baseurl.'evolved/widget/index/widget_target_id/homepage_element_1_seven_two_style_image)" style=""><span><span><span>Insert Widget...</span></span></span></button><button type="button" class="scalable add-image plugin" onclick="MediabrowserUtility.openDialog('.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_1_seven_two_style_image/)" style=""><span><span><span>Insert Image...</span></span></span></button><button type="button" class="scalable add-variable plugin" onclick="MagentovariablePlugin.loadChooser('.$baseurl.'evolved/system_variable/wysiwygPlugin/, homepage_element_1_seven_two_style_image);"><span><span><span>Insert Variable...</span></span></span></button></div><textarea name="homepage_element_1_seven_two_style_image" title="" id="homepage_element_1_seven_two_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_1_seven_two_style_image'].'</textarea><small>Image size must be 1920*480 pixels</small></td>';
      						$str = $str . '<td class="value"><button id="togglehomepage_element_1_seven_two_style_image" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><div id="buttonshomepage_element_1_seven_two_style_image" class="buttons-set"><button style="" onclick="MediabrowserUtility.openDialog(\''.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_1_seven_two_style_image/\')" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button></div><textarea name="homepage_element_1_seven_two_style_image" title="" id="homepage_element_1_seven_two_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_1_seven_two_style_image'].'</textarea><small>Image size must be 346*170 pixels</small></td>';
      						$str = $str . '<script type="text/javascript">';
      						$str = $str . ' openEditorPopup = function(url, name, specs, parent) {';
      						$str = $str . ' if ((typeof popups == "undefined") || popups[name] == undefined || popups[name].closed) {';
      						$str = $str . ' if (typeof popups == "undefined") {';
      						$str = $str . ' popups = new Array();';
      						$str = $str . ' }';
      						$str = $str . ' var opener = (parent != undefined ? parent : window);';
      						$str = $str . 'popups[name] = opener.open(url, name, specs);';
      						$str = $str . ' } else {';
      						$str = $str . ' popups[name].focus();';
      						$str = $str . ' }';
      						$str = $str . 'return popups[name];';
      						$str = $str . '}';
      						$str = $str . 'closeEditorPopup = function(name) {';
      						$str = $str . 'if ((typeof popups != "undefined") &amp;&amp; popups[name] != undefined &amp;&amp; !popups[name].closed) {';
      						$str = $str . 'popups[name].close();';
      						$str = $str . '}';
      						$str = $str . '}';
      						$str = $str . ' </script>';
      						$str = $str . '<script type="text/javascript">';
      						$str = $str . 'if ("undefined" != typeof(Translator)) {';
      						$str = $str . 'Translator.add({"Insert Image...":"Insert Image...","Insert Media...":"Insert Media...","Insert File...":"Insert File..."});';
      						$str = $str . '}wysiwyghomepage_element_1_seven_two_style_image = new tinyMceWysiwygSetup("homepage_element_1_seven_two_style_image", {"enabled":true,"hidden":true,"use_container":false,"add_variables":true,"add_widgets":true,"add_images":true,"no_display":false,"translator":{},"encode_directives":true,"directives_url":"'.$baseurl.'evolved/cms_wysiwyg/directive/","popup_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/dialog.css","content_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/content.css","width":"100%","plugins":[{"name":"magentovariable","src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentovariable/editor_plugin.js","options":{"title":"Insert Variable...","url":"'.$baseurl.'evolved/system_variable/wysiwygPlugin/","onclick":{"search":["html_id"],"subject":"MagentovariablePlugin.loadChooser(\''.$baseurl.'evolved/system_variable/wysiwygPlugin/\', \'{{html_id}}\');"},"class":"add-variable plugin"}}],"directives_url_quoted":"'.$baseurl.'evolved/cms_wysiwyg/directive/","files_browser_window_url":"'.$baseurl.'idealAdmin/cms_wysiwyg_images/index/","files_browser_window_width":1000,"files_browser_window_height":600,"widget_plugin_src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentowidget/editor_plugin.js","widget_images_url":"'.$siteurl.'skin/adminhtml/default/default/images/widget/","widget_placeholders":["Thumbs.db","catalog__category_widget_link.gif","catalog__product_widget_link.gif","catalog__product_widget_new.gif","cms__widget_block.gif","cms__widget_page_link.gif","default.gif","reports__product_widget_compared.gif","reports__product_widget_viewed.gif"],"widget_window_url":"'.$baseurl.'evolved/widget/index/","firebug_warning_title":"Warning","firebug_warning_text":"Firebug is known to make the WYSIWYG editor slow unless it is turned off or configured properly.","firebug_warning_anchor":"Hide"});';
      						$str = $str . 'editorFormValidationHandler = wysiwyghomepage_element_1_seven_two_style_image.onFormValidation.bind(wysiwyghomepage_element_1_seven_two_style_image);';
      						$str = $str . 'Event.observe("togglehomepage_element_1_seven_two_style_image", "click", wysiwyghomepage_element_1_seven_two_style_image.toggle.bind(wysiwyghomepage_element_1_seven_two_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("formSubmit", editorFormValidationHandler);';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceBeforeSetContent", wysiwyghomepage_element_1_seven_two_style_image.beforeSetContent.bind(wysiwyghomepage_element_1_seven_two_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceSaveContent", wysiwyghomepage_element_1_seven_two_style_image.saveContent.bind(wysiwyghomepage_element_1_seven_two_style_image));';
      						$str = $str . 'varienGlobalEvents.clearEventHandlers("open_browser_callback");';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("open_browser_callback", wysiwyghomepage_element_1_seven_two_style_image.openFileBrowser.bind(wysiwyghomepage_element_1_seven_two_style_image));';
      						$str = $str . '</script>';
      						$str = $str . '</tr>';
      						$str = $str . '</tbody>';
      						$str = $str . '</table>';
      						$str = $str . '<table cellspacing="0" class="form-list allpageelement" style="display: table-cell;">';
							$str = $str . '<tbody>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_seven_three_style_title">Title:</label></td>';  
      						$str = $str . '<td class="value"><input id="homepage_element_1_seven_three_style_title" value="'.$collectiondata['homepage_element_1_seven_three_style_title'].'" name="homepage_element_1_seven_three_style_title"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_seven_three_style_link">Link:</label></td>';
      						$str = $str . '<td class="value"><input id="homepage_element_1_seven_three_style_link" value="'.$collectiondata['homepage_element_1_seven_three_style_link'].'" name="homepage_element_1_seven_three_style_link"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_seven_three_style_image">Image:</label></td>';
      						//$str = $str . '<td class="value"><div id="buttonshomepage_element_1_seven_three_style_image" class="buttons-set"><button type="button" class="scalable show-hide" style="" id="togglehomepage_element_1_seven_three_style_image"><span><span><span>Show / Hide Editor</span></span></span></button><button type="button" class="scalable add-widget plugin" onclick="widgetTools.openDialog('.$baseurl.'evolved/widget/index/widget_target_id/homepage_element_1_seven_three_style_image)" style=""><span><span><span>Insert Widget...</span></span></span></button><button type="button" class="scalable add-image plugin" onclick="MediabrowserUtility.openDialog('.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_1_seven_three_style_image/)" style=""><span><span><span>Insert Image...</span></span></span></button><button type="button" class="scalable add-variable plugin" onclick="MagentovariablePlugin.loadChooser('.$baseurl.'evolved/system_variable/wysiwygPlugin/, homepage_element_1_seven_three_style_image);"><span><span><span>Insert Variable...</span></span></span></button></div><textarea name="homepage_element_1_seven_three_style_image" title="" id="homepage_element_1_seven_three_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_1_seven_three_style_image'].'</textarea><small>Image size must be 1920*480 pixels</small></td>';
      						$str = $str . '<td class="value"><button id="togglehomepage_element_1_seven_three_style_image" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><div id="buttonshomepage_element_1_seven_three_style_image" class="buttons-set"><button style="" onclick="MediabrowserUtility.openDialog(\''.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_1_seven_three_style_image/\')" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button></div><textarea name="homepage_element_1_seven_three_style_image" title="" id="homepage_element_1_seven_three_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_1_seven_three_style_image'].'</textarea><small>Image size must be 346*170 pixels</small></td>';
      						$str = $str . '<script type="text/javascript">';
      						$str = $str . ' openEditorPopup = function(url, name, specs, parent) {';
      						$str = $str . ' if ((typeof popups == "undefined") || popups[name] == undefined || popups[name].closed) {';
      						$str = $str . ' if (typeof popups == "undefined") {';
      						$str = $str . ' popups = new Array();';
      						$str = $str . ' }';
      						$str = $str . ' var opener = (parent != undefined ? parent : window);';
      						$str = $str . 'popups[name] = opener.open(url, name, specs);';
      						$str = $str . ' } else {';
      						$str = $str . ' popups[name].focus();';
      						$str = $str . ' }';
      						$str = $str . 'return popups[name];';
      						$str = $str . '}';
      						$str = $str . 'closeEditorPopup = function(name) {';
      						$str = $str . 'if ((typeof popups != "undefined") &amp;&amp; popups[name] != undefined &amp;&amp; !popups[name].closed) {';
      						$str = $str . 'popups[name].close();';
      						$str = $str . '}';
      						$str = $str . '}';
      						$str = $str . ' </script>';
      						$str = $str . '<script type="text/javascript">';
      						$str = $str . 'if ("undefined" != typeof(Translator)) {';
      						$str = $str . 'Translator.add({"Insert Image...":"Insert Image...","Insert Media...":"Insert Media...","Insert File...":"Insert File..."});';
      						$str = $str . '}wysiwyghomepage_element_1_seven_three_style_image = new tinyMceWysiwygSetup("homepage_element_1_seven_three_style_image", {"enabled":true,"hidden":true,"use_container":false,"add_variables":true,"add_widgets":true,"add_images":true,"no_display":false,"translator":{},"encode_directives":true,"directives_url":"'.$baseurl.'evolved/cms_wysiwyg/directive/","popup_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/dialog.css","content_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/content.css","width":"100%","plugins":[{"name":"magentovariable","src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentovariable/editor_plugin.js","options":{"title":"Insert Variable...","url":"'.$baseurl.'evolved/system_variable/wysiwygPlugin/","onclick":{"search":["html_id"],"subject":"MagentovariablePlugin.loadChooser(\''.$baseurl.'evolved/system_variable/wysiwygPlugin/\', \'{{html_id}}\');"},"class":"add-variable plugin"}}],"directives_url_quoted":"'.$baseurl.'evolved/cms_wysiwyg/directive/","files_browser_window_url":"'.$baseurl.'idealAdmin/cms_wysiwyg_images/index/","files_browser_window_width":1000,"files_browser_window_height":600,"widget_plugin_src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentowidget/editor_plugin.js","widget_images_url":"'.$siteurl.'skin/adminhtml/default/default/images/widget/","widget_placeholders":["Thumbs.db","catalog__category_widget_link.gif","catalog__product_widget_link.gif","catalog__product_widget_new.gif","cms__widget_block.gif","cms__widget_page_link.gif","default.gif","reports__product_widget_compared.gif","reports__product_widget_viewed.gif"],"widget_window_url":"'.$baseurl.'evolved/widget/index/","firebug_warning_title":"Warning","firebug_warning_text":"Firebug is known to make the WYSIWYG editor slow unless it is turned off or configured properly.","firebug_warning_anchor":"Hide"});';
      						$str = $str . 'editorFormValidationHandler = wysiwyghomepage_element_1_seven_three_style_image.onFormValidation.bind(wysiwyghomepage_element_1_seven_three_style_image);';
      						$str = $str . 'Event.observe("togglehomepage_element_1_seven_three_style_image", "click", wysiwyghomepage_element_1_seven_three_style_image.toggle.bind(wysiwyghomepage_element_1_seven_three_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("formSubmit", editorFormValidationHandler);';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceBeforeSetContent", wysiwyghomepage_element_1_seven_three_style_image.beforeSetContent.bind(wysiwyghomepage_element_1_seven_three_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceSaveContent", wysiwyghomepage_element_1_seven_three_style_image.saveContent.bind(wysiwyghomepage_element_1_seven_three_style_image));';
      						$str = $str . 'varienGlobalEvents.clearEventHandlers("open_browser_callback");';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("open_browser_callback", wysiwyghomepage_element_1_seven_three_style_image.openFileBrowser.bind(wysiwyghomepage_element_1_seven_three_style_image));';
      						$str = $str . '</script>';
      						$str = $str . '</tr>';
      						$str = $str . '</tbody>';
      						$str = $str . '</table>';
      						$str = $str . '</td>';
      						$str = $str . '</tr>';
      						$str = $str . '</tbody>';
      						$str = $str . '</table>';
      					}
      					//else if($selectElement == '33_%_346_by_346_three_boxes_width')
      					{
      						if($selectElement == 'homepage_element_1_33_percentage_346_by_346_three_boxes_width')
      						{
      							$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="homepage_element_1_33_percentage_346_by_346_three_boxes_width" style="display: block">';
      						}
      						else
      						{
      							$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="homepage_element_1_33_percentage_346_by_346_three_boxes_width"  style="display: none">';
      						}
      						//$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="33_percentage_346_by_346_three_boxes_width">';
      						$str = $str . '<tbody>';
      						$str = $str . '<tr>';
      						$str = $str . '<td>';
      						$str = $str . '<table cellspacing="0" class="form-list allpageelement" style="display: table-cell;">';
							$str = $str . '<tbody>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_eight_one_style_title">Title:</label></td>';  
      						$str = $str . '<td class="value"><input id="homepage_element_1_eight_one_style_title" value="'.$collectiondata['homepage_element_1_eight_one_style_title'].'" name="homepage_element_1_eight_one_style_title"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str .	'<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_eight_one_style_link">Link:</label></td>';
      						$str = $str . '<td class="value"><input id="homepage_element_1_eight_one_style_link" value="'.$collectiondata['homepage_element_1_eight_one_style_link'].'" name="homepage_element_1_eight_one_style_link"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_eight_one_style_image">Image:</label></td>';
      						//$str = $str . '<td class="value"><div id="buttonshomepage_element_1_eight_one_style_image" class="buttons-set"><button type="button" class="scalable show-hide" style="" id="togglehomepage_element_1_eight_one_style_image"><span><span><span>Show / Hide Editor</span></span></span></button><button type="button" class="scalable add-widget plugin" onclick="widgetTools.openDialog('.$baseurl.'evolved/widget/index/widget_target_id/homepage_element_1_eight_one_style_image)" style=""><span><span><span>Insert Widget...</span></span></span></button><button type="button" class="scalable add-image plugin" onclick="MediabrowserUtility.openDialog('.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_1_eight_one_style_image/)" style=""><span><span><span>Insert Image...</span></span></span></button><button type="button" class="scalable add-variable plugin" onclick="MagentovariablePlugin.loadChooser('.$baseurl.'evolved/system_variable/wysiwygPlugin/, homepage_element_1_eight_one_style_image);"><span><span><span>Insert Variable...</span></span></span></button></div><textarea name="homepage_element_1_eight_one_style_image" title="" id="homepage_element_1_eight_one_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_1_eight_one_style_image'].'</textarea><small>Image size must be 1920*480 pixels</small></td>';
      						$str = $str . '<td class="value"><button id="togglehomepage_element_1_eight_one_style_image" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><div id="buttonshomepage_element_1_eight_one_style_image" class="buttons-set"><button style="" onclick="MediabrowserUtility.openDialog(\''.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_1_eight_one_style_image/\')" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button></div><textarea name="homepage_element_1_eight_one_style_image" title="" id="homepage_element_1_eight_one_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_1_eight_one_style_image'].'</textarea><small>Image size must be 346*346 pixels</small></td>';
      						$str = $str . '<script type="text/javascript">';
      						$str = $str . ' openEditorPopup = function(url, name, specs, parent) {';
      						$str = $str . ' if ((typeof popups == "undefined") || popups[name] == undefined || popups[name].closed) {';
      						$str = $str . ' if (typeof popups == "undefined") {';
      						$str = $str . ' popups = new Array();';
      						$str = $str . ' }';
      						$str = $str . ' var opener = (parent != undefined ? parent : window);';
      						$str = $str . 'popups[name] = opener.open(url, name, specs);';
      						$str = $str . ' } else {';
      						$str = $str . ' popups[name].focus();';
      						$str = $str . ' }';
      						$str = $str . 'return popups[name];';
      						$str = $str . '}';
      						$str = $str . 'closeEditorPopup = function(name) {';
      						$str = $str . 'if ((typeof popups != "undefined") &amp;&amp; popups[name] != undefined &amp;&amp; !popups[name].closed) {';
      						$str = $str . 'popups[name].close();';
      						$str = $str . '}';
      						$str = $str . '}';
      						$str = $str . ' </script>';
      						$str = $str . '<script type="text/javascript">';
      						$str = $str . 'if ("undefined" != typeof(Translator)) {';
      						$str = $str . 'Translator.add({"Insert Image...":"Insert Image...","Insert Media...":"Insert Media...","Insert File...":"Insert File..."});';
      						$str = $str . '}wysiwyghomepage_element_1_eight_one_style_image = new tinyMceWysiwygSetup("homepage_element_1_eight_one_style_image", {"enabled":true,"hidden":true,"use_container":false,"add_variables":true,"add_widgets":true,"add_images":true,"no_display":false,"translator":{},"encode_directives":true,"directives_url":"'.$baseurl.'evolved/cms_wysiwyg/directive/","popup_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/dialog.css","content_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/content.css","width":"100%","plugins":[{"name":"magentovariable","src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentovariable/editor_plugin.js","options":{"title":"Insert Variable...","url":"'.$baseurl.'evolved/system_variable/wysiwygPlugin/","onclick":{"search":["html_id"],"subject":"MagentovariablePlugin.loadChooser(\''.$baseurl.'evolved/system_variable/wysiwygPlugin/\', \'{{html_id}}\');"},"class":"add-variable plugin"}}],"directives_url_quoted":"'.$baseurl.'evolved/cms_wysiwyg/directive/","files_browser_window_url":"'.$baseurl.'idealAdmin/cms_wysiwyg_images/index/","files_browser_window_width":1000,"files_browser_window_height":600,"widget_plugin_src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentowidget/editor_plugin.js","widget_images_url":"'.$siteurl.'skin/adminhtml/default/default/images/widget/","widget_placeholders":["Thumbs.db","catalog__category_widget_link.gif","catalog__product_widget_link.gif","catalog__product_widget_new.gif","cms__widget_block.gif","cms__widget_page_link.gif","default.gif","reports__product_widget_compared.gif","reports__product_widget_viewed.gif"],"widget_window_url":"'.$baseurl.'evolved/widget/index/","firebug_warning_title":"Warning","firebug_warning_text":"Firebug is known to make the WYSIWYG editor slow unless it is turned off or configured properly.","firebug_warning_anchor":"Hide"});';
      						$str = $str . 'editorFormValidationHandler = wysiwyghomepage_element_1_eight_one_style_image.onFormValidation.bind(wysiwyghomepage_element_1_eight_one_style_image);';
      						$str = $str . 'Event.observe("togglehomepage_element_1_eight_one_style_image", "click", wysiwyghomepage_element_1_eight_one_style_image.toggle.bind(wysiwyghomepage_element_1_eight_one_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("formSubmit", editorFormValidationHandler);';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceBeforeSetContent", wysiwyghomepage_element_1_eight_one_style_image.beforeSetContent.bind(wysiwyghomepage_element_1_eight_one_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceSaveContent", wysiwyghomepage_element_1_eight_one_style_image.saveContent.bind(wysiwyghomepage_element_1_eight_one_style_image));';
      						$str = $str . 'varienGlobalEvents.clearEventHandlers("open_browser_callback");';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("open_browser_callback", wysiwyghomepage_element_1_eight_one_style_image.openFileBrowser.bind(wysiwyghomepage_element_1_eight_one_style_image));';
      						$str = $str . '</script>';
      						$str = $str . '</tr>';
      						$str = $str . '</tbody>';
      						$str = $str . '</table>'; 
      						$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelement" style="display: table-cell;">';
							$str = $str . '<tbody>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_eight_two_style_title">Title:</label></td>';  
      						$str = $str . '<td class="value"><input id="homepage_element_1_eight_two_style_title"  value="'.$collectiondata['homepage_element_1_eight_two_style_title'].'" name="homepage_element_1_eight_two_style_title"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str .	'<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_eight_two_style_link">Link:</label></td>';
      						$str = $str . '<td class="value"><input id="homepage_element_1_eight_two_style_link" value="'.$collectiondata['homepage_element_1_eight_two_style_link'].'" name="homepage_element_1_eight_two_style_link"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_eight_two_style_image">Image:</label></td>';
      						//$str = $str . '<td class="value"><div id="buttonshomepage_element_1_eight_two_style_image" class="buttons-set"><button type="button" class="scalable show-hide" style="" id="togglehomepage_element_1_eight_two_style_image"><span><span><span>Show / Hide Editor</span></span></span></button><button type="button" class="scalable add-widget plugin" onclick="widgetTools.openDialog('.$baseurl.'evolved/widget/index/widget_target_id/homepage_element_1_eight_two_style_image)" style=""><span><span><span>Insert Widget...</span></span></span></button><button type="button" class="scalable add-image plugin" onclick="MediabrowserUtility.openDialog('.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_1_eight_two_style_image/)" style=""><span><span><span>Insert Image...</span></span></span></button><button type="button" class="scalable add-variable plugin" onclick="MagentovariablePlugin.loadChooser('.$baseurl.'evolved/system_variable/wysiwygPlugin/, homepage_element_1_eight_two_style_image);"><span><span><span>Insert Variable...</span></span></span></button></div><textarea name="homepage_element_1_eight_two_style_image" title="" id="homepage_element_1_eight_two_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_1_eight_two_style_image'].'</textarea><small>Image size must be 1920*480 pixels</small></td>';
      						$str = $str . '<td class="value"><button id="togglehomepage_element_1_eight_two_style_image" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><div id="buttonshomepage_element_1_eight_two_style_image" class="buttons-set"><button style="" onclick="MediabrowserUtility.openDialog(\''.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_1_eight_two_style_image/\')" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button></div><textarea name="homepage_element_1_eight_two_style_image" title="" id="homepage_element_1_eight_two_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_1_eight_two_style_image'].'</textarea><small>Image size must be 346*346 pixels</small></td>';
      						$str = $str . '<script type="text/javascript">';
      						$str = $str . ' openEditorPopup = function(url, name, specs, parent) {';
      						$str = $str . ' if ((typeof popups == "undefined") || popups[name] == undefined || popups[name].closed) {';
      						$str = $str . ' if (typeof popups == "undefined") {';
      						$str = $str . ' popups = new Array();';
      						$str = $str . ' }';
      						$str = $str . ' var opener = (parent != undefined ? parent : window);';
      						$str = $str . 'popups[name] = opener.open(url, name, specs);';
      						$str = $str . ' } else {';
      						$str = $str . ' popups[name].focus();';
      						$str = $str . ' }';
      						$str = $str . 'return popups[name];';
      						$str = $str . '}';
      						$str = $str . 'closeEditorPopup = function(name) {';
      						$str = $str . 'if ((typeof popups != "undefined") &amp;&amp; popups[name] != undefined &amp;&amp; !popups[name].closed) {';
      						$str = $str . 'popups[name].close();';
      						$str = $str . '}';
      						$str = $str . '}';
      						$str = $str . ' </script>';
      						$str = $str . '<script type="text/javascript">';
      						$str = $str . 'if ("undefined" != typeof(Translator)) {';
      						$str = $str . 'Translator.add({"Insert Image...":"Insert Image...","Insert Media...":"Insert Media...","Insert File...":"Insert File..."});';
      						$str = $str . '}wysiwyghomepage_element_1_eight_two_style_image = new tinyMceWysiwygSetup("homepage_element_1_eight_two_style_image", {"enabled":true,"hidden":true,"use_container":false,"add_variables":true,"add_widgets":true,"add_images":true,"no_display":false,"translator":{},"encode_directives":true,"directives_url":"'.$baseurl.'evolved/cms_wysiwyg/directive/","popup_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/dialog.css","content_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/content.css","width":"100%","plugins":[{"name":"magentovariable","src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentovariable/editor_plugin.js","options":{"title":"Insert Variable...","url":"'.$baseurl.'evolved/system_variable/wysiwygPlugin/","onclick":{"search":["html_id"],"subject":"MagentovariablePlugin.loadChooser(\''.$baseurl.'evolved/system_variable/wysiwygPlugin/\', \'{{html_id}}\');"},"class":"add-variable plugin"}}],"directives_url_quoted":"'.$baseurl.'evolved/cms_wysiwyg/directive/","files_browser_window_url":"'.$baseurl.'idealAdmin/cms_wysiwyg_images/index/","files_browser_window_width":1000,"files_browser_window_height":600,"widget_plugin_src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentowidget/editor_plugin.js","widget_images_url":"'.$siteurl.'skin/adminhtml/default/default/images/widget/","widget_placeholders":["Thumbs.db","catalog__category_widget_link.gif","catalog__product_widget_link.gif","catalog__product_widget_new.gif","cms__widget_block.gif","cms__widget_page_link.gif","default.gif","reports__product_widget_compared.gif","reports__product_widget_viewed.gif"],"widget_window_url":"'.$baseurl.'evolved/widget/index/","firebug_warning_title":"Warning","firebug_warning_text":"Firebug is known to make the WYSIWYG editor slow unless it is turned off or configured properly.","firebug_warning_anchor":"Hide"});';
      						$str = $str . 'editorFormValidationHandler = wysiwyghomepage_element_1_eight_two_style_image.onFormValidation.bind(wysiwyghomepage_element_1_eight_two_style_image);';
      						$str = $str . 'Event.observe("togglehomepage_element_1_eight_two_style_image", "click", wysiwyghomepage_element_1_eight_two_style_image.toggle.bind(wysiwyghomepage_element_1_eight_two_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("formSubmit", editorFormValidationHandler);';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceBeforeSetContent", wysiwyghomepage_element_1_eight_two_style_image.beforeSetContent.bind(wysiwyghomepage_element_1_eight_two_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceSaveContent", wysiwyghomepage_element_1_eight_two_style_image.saveContent.bind(wysiwyghomepage_element_1_eight_two_style_image));';
      						$str = $str . 'varienGlobalEvents.clearEventHandlers("open_browser_callback");';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("open_browser_callback", wysiwyghomepage_element_1_eight_two_style_image.openFileBrowser.bind(wysiwyghomepage_element_1_eight_two_style_image));';
      						$str = $str . '</script>';
      						$str = $str . '</tr>';
      						$str = $str . '</tbody>';
      						$str = $str . '</table>';
      						$str = $str . '<table cellspacing="0" class="form-list allpageelement" style="display: table-cell;">';
							$str = $str . '<tbody>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_eight_three_style_title">Title:</label></td>';  
      						$str = $str . '<td class="value"><input id="homepage_element_1_eight_three_style_title" value="'.$collectiondata['homepage_element_1_eight_three_style_title'].'" name="homepage_element_1_eight_three_style_title"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str .	'<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_eight_three_style_link">Link:</label></td>';
      						$str = $str . '<td class="value"><input id="homepage_element_1_eight_three_style_link" value="'.$collectiondata['homepage_element_1_eight_three_style_link'].'" name="homepage_element_1_eight_three_style_link"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_eight_three_style_image">Image:</label></td>';
      						//$str = $str . '<td class="value"><div id="buttonshomepage_element_1_eight_three_style_image" class="buttons-set"><button type="button" class="scalable show-hide" style="" id="togglehomepage_element_1_eight_three_style_image"><span><span><span>Show / Hide Editor</span></span></span></button><button type="button" class="scalable add-widget plugin" onclick="widgetTools.openDialog('.$baseurl.'evolved/widget/index/widget_target_id/homepage_element_1_eight_three_style_image)" style=""><span><span><span>Insert Widget...</span></span></span></button><button type="button" class="scalable add-image plugin" onclick="MediabrowserUtility.openDialog('.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_1_eight_three_style_image/)" style=""><span><span><span>Insert Image...</span></span></span></button><button type="button" class="scalable add-variable plugin" onclick="MagentovariablePlugin.loadChooser('.$baseurl.'evolved/system_variable/wysiwygPlugin/, homepage_element_1_eight_three_style_image);"><span><span><span>Insert Variable...</span></span></span></button></div><textarea name="homepage_element_1_eight_three_style_image" title="" id="homepage_element_1_eight_three_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_1_eight_three_style_image'].'</textarea><small>Image size must be 1920*480 pixels</small></td>';
      						$str = $str . '<td class="value"><button id="togglehomepage_element_1_eight_three_style_image" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><div id="buttonshomepage_element_1_eight_three_style_image" class="buttons-set"><button style="" onclick="MediabrowserUtility.openDialog(\''.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_1_eight_three_style_image/\')" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button></div><textarea name="homepage_element_1_eight_three_style_image" title="" id="homepage_element_1_eight_three_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_1_eight_three_style_image'].'</textarea><small>Image size must be 346*346 pixels</small></td>';
      						$str = $str . '<script type="text/javascript">';
      						$str = $str . ' openEditorPopup = function(url, name, specs, parent) {';
      						$str = $str . ' if ((typeof popups == "undefined") || popups[name] == undefined || popups[name].closed) {';
      						$str = $str . ' if (typeof popups == "undefined") {';
      						$str = $str . ' popups = new Array();';
      						$str = $str . ' }';
      						$str = $str . ' var opener = (parent != undefined ? parent : window);';
      						$str = $str . 'popups[name] = opener.open(url, name, specs);';
      						$str = $str . ' } else {';
      						$str = $str . ' popups[name].focus();';
      						$str = $str . ' }';
      						$str = $str . 'return popups[name];';
      						$str = $str . '}';
      						$str = $str . 'closeEditorPopup = function(name) {';
      						$str = $str . 'if ((typeof popups != "undefined") &amp;&amp; popups[name] != undefined &amp;&amp; !popups[name].closed) {';
      						$str = $str . 'popups[name].close();';
      						$str = $str . '}';
      						$str = $str . '}';
      						$str = $str . ' </script>';
      						$str = $str . '<script type="text/javascript">';
      						$str = $str . 'if ("undefined" != typeof(Translator)) {';
      						$str = $str . 'Translator.add({"Insert Image...":"Insert Image...","Insert Media...":"Insert Media...","Insert File...":"Insert File..."});';
      						$str = $str . '}wysiwyghomepage_element_1_eight_three_style_image = new tinyMceWysiwygSetup("homepage_element_1_eight_three_style_image", {"enabled":true,"hidden":true,"use_container":false,"add_variables":true,"add_widgets":true,"add_images":true,"no_display":false,"translator":{},"encode_directives":true,"directives_url":"'.$baseurl.'evolved/cms_wysiwyg/directive/","popup_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/dialog.css","content_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/content.css","width":"100%","plugins":[{"name":"magentovariable","src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentovariable/editor_plugin.js","options":{"title":"Insert Variable...","url":"'.$baseurl.'evolved/system_variable/wysiwygPlugin/","onclick":{"search":["html_id"],"subject":"MagentovariablePlugin.loadChooser(\''.$baseurl.'evolved/system_variable/wysiwygPlugin/\', \'{{html_id}}\');"},"class":"add-variable plugin"}}],"directives_url_quoted":"'.$baseurl.'evolved/cms_wysiwyg/directive/","files_browser_window_url":"'.$baseurl.'idealAdmin/cms_wysiwyg_images/index/","files_browser_window_width":1000,"files_browser_window_height":600,"widget_plugin_src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentowidget/editor_plugin.js","widget_images_url":"'.$siteurl.'skin/adminhtml/default/default/images/widget/","widget_placeholders":["Thumbs.db","catalog__category_widget_link.gif","catalog__product_widget_link.gif","catalog__product_widget_new.gif","cms__widget_block.gif","cms__widget_page_link.gif","default.gif","reports__product_widget_compared.gif","reports__product_widget_viewed.gif"],"widget_window_url":"'.$baseurl.'evolved/widget/index/","firebug_warning_title":"Warning","firebug_warning_text":"Firebug is known to make the WYSIWYG editor slow unless it is turned off or configured properly.","firebug_warning_anchor":"Hide"});';
      						$str = $str . 'editorFormValidationHandler = wysiwyghomepage_element_1_eight_three_style_image.onFormValidation.bind(wysiwyghomepage_element_1_eight_three_style_image);';
      						$str = $str . 'Event.observe("togglehomepage_element_1_eight_three_style_image", "click", wysiwyghomepage_element_1_eight_three_style_image.toggle.bind(wysiwyghomepage_element_1_eight_three_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("formSubmit", editorFormValidationHandler);';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceBeforeSetContent", wysiwyghomepage_element_1_eight_three_style_image.beforeSetContent.bind(wysiwyghomepage_element_1_eight_three_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceSaveContent", wysiwyghomepage_element_1_eight_three_style_image.saveContent.bind(wysiwyghomepage_element_1_eight_three_style_image));';
      						$str = $str . 'varienGlobalEvents.clearEventHandlers("open_browser_callback");';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("open_browser_callback", wysiwyghomepage_element_1_eight_three_style_image.openFileBrowser.bind(wysiwyghomepage_element_1_eight_three_style_image));';
      						$str = $str . '</script>';
      						$str = $str . '</tr>';
      						$str = $str . '</tbody>';
      						$str = $str . '</table>';
      						$str = $str . '</td>';
      						$str = $str . '</tr>';
      						$str = $str . '</tbody>';
      						$str = $str . '</table>';
      					}
      					//else if($selectElement == '33_%_346_by_346_three_boxes_middle_updown_width')
      					{
      						if($selectElement == 'homepage_element_1_33_percentage_346_by_346_three_boxes_middle_updown_width')
      						{
      							$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="homepage_element_1_33_percentage_346_by_346_three_boxes_middle_updown_width" style="display: block">';
      						}
      						else
      						{
      							$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="homepage_element_1_33_percentage_346_by_346_three_boxes_middle_updown_width"  style="display: none">';
      						}
      						//$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="33_percentage_346_by_346_three_boxes_middle_updown_width">';
      						$str = $str . '<tbody>';
      						$str = $str . '<tr>';
      						$str = $str . '<td>';
      						$str = $str . '<table cellspacing="0" class="form-list allpageelement" style="display: table-cell;">';
							$str = $str . '<tbody>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_nine_one_style_title">Title:</label></td>';  
      						$str = $str . '<td class="value"><input id="homepage_element_1_nine_one_style_title" value="'.$collectiondata['homepage_element_1_nine_one_style_title'].'" name="homepage_element_1_nine_one_style_title"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str .	'<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_nine_one_style_link">Link:</label></td>';
      						$str = $str . '<td class="value"><input id="homepage_element_1_nine_one_style_link" value="'.$collectiondata['homepage_element_1_nine_one_style_link'].'" name="homepage_element_1_nine_one_style_link"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_nine_one_style_image">Image:</label></td>';
      						//$str = $str . '<td class="value"><div id="buttonshomepage_element_1_nine_one_style_image" class="buttons-set"><button type="button" class="scalable show-hide" style="" id="togglehomepage_element_1_nine_one_style_image"><span><span><span>Show / Hide Editor</span></span></span></button><button type="button" class="scalable add-widget plugin" onclick="widgetTools.openDialog('.$baseurl.'evolved/widget/index/widget_target_id/homepage_element_1_nine_one_style_image)" style=""><span><span><span>Insert Widget...</span></span></span></button><button type="button" class="scalable add-image plugin" onclick="MediabrowserUtility.openDialog('.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_1_nine_one_style_image/)" style=""><span><span><span>Insert Image...</span></span></span></button><button type="button" class="scalable add-variable plugin" onclick="MagentovariablePlugin.loadChooser('.$baseurl.'evolved/system_variable/wysiwygPlugin/, homepage_element_1_nine_one_style_image);"><span><span><span>Insert Variable...</span></span></span></button></div><textarea name="homepage_element_1_nine_one_style_image" title="" id="homepage_element_1_nine_one_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_1_nine_one_style_image'].'</textarea><small>Image size must be 1920*480 pixels</small></td>';
      						$str = $str . '<td class="value"><button id="togglehomepage_element_1_nine_one_style_image" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><div id="buttonshomepage_element_1_nine_one_style_image" class="buttons-set"><button style="" onclick="MediabrowserUtility.openDialog(\''.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_1_nine_one_style_image/\')" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button></div><textarea name="homepage_element_1_nine_one_style_image" title="" id="homepage_element_1_nine_one_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_1_nine_one_style_image'].'</textarea><small>Image size must be 346*346 pixels</small></td>';
      						$str = $str . '<script type="text/javascript">';
      						$str = $str . ' openEditorPopup = function(url, name, specs, parent) {';
      						$str = $str . ' if ((typeof popups == "undefined") || popups[name] == undefined || popups[name].closed) {';
      						$str = $str . ' if (typeof popups == "undefined") {';
      						$str = $str . ' popups = new Array();';
      						$str = $str . ' }';
      						$str = $str . ' var opener = (parent != undefined ? parent : window);';
      						$str = $str . 'popups[name] = opener.open(url, name, specs);';
      						$str = $str . ' } else {';
      						$str = $str . ' popups[name].focus();';
      						$str = $str . ' }';
      						$str = $str . 'return popups[name];';
      						$str = $str . '}';
      						$str = $str . 'closeEditorPopup = function(name) {';
      						$str = $str . 'if ((typeof popups != "undefined") &amp;&amp; popups[name] != undefined &amp;&amp; !popups[name].closed) {';
      						$str = $str . 'popups[name].close();';
      						$str = $str . '}';
      						$str = $str . '}';
      						$str = $str . ' </script>';
      						$str = $str . '<script type="text/javascript">';
      						$str = $str . 'if ("undefined" != typeof(Translator)) {';
      						$str = $str . 'Translator.add({"Insert Image...":"Insert Image...","Insert Media...":"Insert Media...","Insert File...":"Insert File..."});';
      						$str = $str . '}wysiwyghomepage_element_1_nine_one_style_image = new tinyMceWysiwygSetup("homepage_element_1_nine_one_style_image", {"enabled":true,"hidden":true,"use_container":false,"add_variables":true,"add_widgets":true,"add_images":true,"no_display":false,"translator":{},"encode_directives":true,"directives_url":"'.$baseurl.'evolved/cms_wysiwyg/directive/","popup_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/dialog.css","content_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/content.css","width":"100%","plugins":[{"name":"magentovariable","src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentovariable/editor_plugin.js","options":{"title":"Insert Variable...","url":"'.$baseurl.'evolved/system_variable/wysiwygPlugin/","onclick":{"search":["html_id"],"subject":"MagentovariablePlugin.loadChooser(\''.$baseurl.'evolved/system_variable/wysiwygPlugin/\', \'{{html_id}}\');"},"class":"add-variable plugin"}}],"directives_url_quoted":"'.$baseurl.'evolved/cms_wysiwyg/directive/","files_browser_window_url":"'.$baseurl.'idealAdmin/cms_wysiwyg_images/index/","files_browser_window_width":1000,"files_browser_window_height":600,"widget_plugin_src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentowidget/editor_plugin.js","widget_images_url":"'.$siteurl.'skin/adminhtml/default/default/images/widget/","widget_placeholders":["Thumbs.db","catalog__category_widget_link.gif","catalog__product_widget_link.gif","catalog__product_widget_new.gif","cms__widget_block.gif","cms__widget_page_link.gif","default.gif","reports__product_widget_compared.gif","reports__product_widget_viewed.gif"],"widget_window_url":"'.$baseurl.'evolved/widget/index/","firebug_warning_title":"Warning","firebug_warning_text":"Firebug is known to make the WYSIWYG editor slow unless it is turned off or configured properly.","firebug_warning_anchor":"Hide"});';
      						$str = $str . 'editorFormValidationHandler = wysiwyghomepage_element_1_nine_one_style_image.onFormValidation.bind(wysiwyghomepage_element_1_nine_one_style_image);';
      						$str = $str . 'Event.observe("togglehomepage_element_1_nine_one_style_image", "click", wysiwyghomepage_element_1_nine_one_style_image.toggle.bind(wysiwyghomepage_element_1_nine_one_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("formSubmit", editorFormValidationHandler);';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceBeforeSetContent", wysiwyghomepage_element_1_nine_one_style_image.beforeSetContent.bind(wysiwyghomepage_element_1_nine_one_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceSaveContent", wysiwyghomepage_element_1_nine_one_style_image.saveContent.bind(wysiwyghomepage_element_1_nine_one_style_image));';
      						$str = $str . 'varienGlobalEvents.clearEventHandlers("open_browser_callback");';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("open_browser_callback", wysiwyghomepage_element_1_nine_one_style_image.openFileBrowser.bind(wysiwyghomepage_element_1_nine_one_style_image));';
      						$str = $str . '</script>';
      						$str = $str . '</tr>';
      						$str = $str . '</tbody>';
      						$str = $str . '</table>'; 
      						$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelement" style="display: table-cell;">';
							$str = $str . '<tbody>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_nine_two_up_style_title">Title:</label></td>';  
      						$str = $str . '<td class="value"><input id="homepage_element_1_nine_two_up_style_title" value="'.$collectiondata['homepage_element_1_nine_two_up_style_title'].'" name="homepage_element_1_nine_two_up_style_title"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str .	'<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_nine_two_up_style_link">Link:</label></td>';
      						$str = $str . '<td class="value"><input id="homepage_element_1_nine_two_up_style_link" value="'.$collectiondata['homepage_element_1_nine_two_up_style_link'].'" name="homepage_element_1_nine_two_up_style_link"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_nine_two_up_style_image">Image:</label></td>';
      						//$str = $str . '<td class="value"><div id="buttonshomepage_element_1_nine_two_up_style_image" class="buttons-set"><button type="button" class="scalable show-hide" style="" id="togglehomepage_element_1_nine_two_up_style_image"><span><span><span>Show / Hide Editor</span></span></span></button><button type="button" class="scalable add-widget plugin" onclick="widgetTools.openDialog('.$baseurl.'evolved/widget/index/widget_target_id/homepage_element_1_nine_two_up_style_image)" style=""><span><span><span>Insert Widget...</span></span></span></button><button type="button" class="scalable add-image plugin" onclick="MediabrowserUtility.openDialog('.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_1_nine_two_up_style_image/)" style=""><span><span><span>Insert Image...</span></span></span></button><button type="button" class="scalable add-variable plugin" onclick="MagentovariablePlugin.loadChooser('.$baseurl.'evolved/system_variable/wysiwygPlugin/, homepage_element_1_nine_two_up_style_image);"><span><span><span>Insert Variable...</span></span></span></button></div><textarea name="homepage_element_1_nine_two_up_style_image" title="" id="homepage_element_1_nine_two_up_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_1_nine_two_up_style_image'].'</textarea><small>Image size must be 1920*480 pixels</small></td>';
      						$str = $str . '<td class="value"><button id="togglehomepage_element_1_nine_two_up_style_image" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><div id="buttonshomepage_element_1_nine_two_up_style_image" class="buttons-set"><button style="" onclick="MediabrowserUtility.openDialog(\''.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_1_nine_two_up_style_image/\')" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button></div><textarea name="homepage_element_1_nine_two_up_style_image" title="" id="homepage_element_1_nine_two_up_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_1_nine_two_up_style_image'].'</textarea><small>Image size must be 346*170 pixels</small></td>';
      						$str = $str . '<script type="text/javascript">';
      						$str = $str . ' openEditorPopup = function(url, name, specs, parent) {';
      						$str = $str . ' if ((typeof popups == "undefined") || popups[name] == undefined || popups[name].closed) {';
      						$str = $str . ' if (typeof popups == "undefined") {';
      						$str = $str . ' popups = new Array();';
      						$str = $str . ' }';
      						$str = $str . ' var opener = (parent != undefined ? parent : window);';
      						$str = $str . 'popups[name] = opener.open(url, name, specs);';
      						$str = $str . ' } else {';
      						$str = $str . ' popups[name].focus();';
      						$str = $str . ' }';
      						$str = $str . 'return popups[name];';
      						$str = $str . '}';
      						$str = $str . 'closeEditorPopup = function(name) {';
      						$str = $str . 'if ((typeof popups != "undefined") &amp;&amp; popups[name] != undefined &amp;&amp; !popups[name].closed) {';
      						$str = $str . 'popups[name].close();';
      						$str = $str . '}';
      						$str = $str . '}';
      						$str = $str . ' </script>';
      						$str = $str . '<script type="text/javascript">';
      						$str = $str . 'if ("undefined" != typeof(Translator)) {';
      						$str = $str . 'Translator.add({"Insert Image...":"Insert Image...","Insert Media...":"Insert Media...","Insert File...":"Insert File..."});';
      						$str = $str . '}wysiwyghomepage_element_1_nine_two_up_style_image = new tinyMceWysiwygSetup("homepage_element_1_nine_two_up_style_image", {"enabled":true,"hidden":true,"use_container":false,"add_variables":true,"add_widgets":true,"add_images":true,"no_display":false,"translator":{},"encode_directives":true,"directives_url":"'.$baseurl.'evolved/cms_wysiwyg/directive/","popup_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/dialog.css","content_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/content.css","width":"100%","plugins":[{"name":"magentovariable","src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentovariable/editor_plugin.js","options":{"title":"Insert Variable...","url":"'.$baseurl.'evolved/system_variable/wysiwygPlugin/","onclick":{"search":["html_id"],"subject":"MagentovariablePlugin.loadChooser(\''.$baseurl.'evolved/system_variable/wysiwygPlugin/\', \'{{html_id}}\');"},"class":"add-variable plugin"}}],"directives_url_quoted":"'.$baseurl.'evolved/cms_wysiwyg/directive/","files_browser_window_url":"'.$baseurl.'idealAdmin/cms_wysiwyg_images/index/","files_browser_window_width":1000,"files_browser_window_height":600,"widget_plugin_src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentowidget/editor_plugin.js","widget_images_url":"'.$siteurl.'skin/adminhtml/default/default/images/widget/","widget_placeholders":["Thumbs.db","catalog__category_widget_link.gif","catalog__product_widget_link.gif","catalog__product_widget_new.gif","cms__widget_block.gif","cms__widget_page_link.gif","default.gif","reports__product_widget_compared.gif","reports__product_widget_viewed.gif"],"widget_window_url":"'.$baseurl.'evolved/widget/index/","firebug_warning_title":"Warning","firebug_warning_text":"Firebug is known to make the WYSIWYG editor slow unless it is turned off or configured properly.","firebug_warning_anchor":"Hide"});';
      						$str = $str . 'editorFormValidationHandler = wysiwyghomepage_element_1_nine_two_up_style_image.onFormValidation.bind(wysiwyghomepage_element_1_nine_two_up_style_image);';
      						$str = $str . 'Event.observe("togglehomepage_element_1_nine_two_up_style_image", "click", wysiwyghomepage_element_1_nine_two_up_style_image.toggle.bind(wysiwyghomepage_element_1_nine_two_up_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("formSubmit", editorFormValidationHandler);';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceBeforeSetContent", wysiwyghomepage_element_1_nine_two_up_style_image.beforeSetContent.bind(wysiwyghomepage_element_1_nine_two_up_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceSaveContent", wysiwyghomepage_element_1_nine_two_up_style_image.saveContent.bind(wysiwyghomepage_element_1_nine_two_up_style_image));';
      						$str = $str . 'varienGlobalEvents.clearEventHandlers("open_browser_callback");';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("open_browser_callback", wysiwyghomepage_element_1_nine_two_up_style_image.openFileBrowser.bind(wysiwyghomepage_element_1_nine_two_up_style_image));';
      						$str = $str . '</script>';
      						$str = $str . '</tr>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_nine_two_down_style_title">Title:</label></td>';  
      						$str = $str . '<td class="value"><input id="homepage_element_1_nine_two_down_style_title" value="'.$collectiondata['homepage_element_1_nine_two_down_style_title'].'" name="homepage_element_1_nine_two_down_style_title"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str .	'<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_nine_two_down_style_link">Link:</label></td>';
      						$str = $str . '<td class="value"><input id="homepage_element_1_nine_two_down_style_link" value="'.$collectiondata['homepage_element_1_nine_two_down_style_link'].'" name="homepage_element_1_nine_two_down_style_link"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_nine_two_down_style_image">Image:</label></td>';
      						//$str = $str . '<td class="value"><div id="buttonshomepage_element_1_nine_two_down_style_image" class="buttons-set"><button type="button" class="scalable show-hide" style="" id="togglehomepage_element_1_nine_two_down_style_image"><span><span><span>Show / Hide Editor</span></span></span></button><button type="button" class="scalable add-widget plugin" onclick="widgetTools.openDialog('.$baseurl.'evolved/widget/index/widget_target_id/homepage_element_1_nine_two_down_style_image)" style=""><span><span><span>Insert Widget...</span></span></span></button><button type="button" class="scalable add-image plugin" onclick="MediabrowserUtility.openDialog('.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_1_nine_two_down_style_image/)" style=""><span><span><span>Insert Image...</span></span></span></button><button type="button" class="scalable add-variable plugin" onclick="MagentovariablePlugin.loadChooser('.$baseurl.'evolved/system_variable/wysiwygPlugin/, homepage_element_1_nine_two_down_style_image);"><span><span><span>Insert Variable...</span></span></span></button></div><textarea name="homepage_element_1_nine_two_down_style_image" title="" id="homepage_element_1_nine_two_down_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_1_nine_two_down_style_image'].'</textarea><small>Image size must be 1920*480 pixels</small></td>';
      						$str = $str . '<td class="value"><button id="togglehomepage_element_1_nine_two_down_style_image" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><div id="buttonshomepage_element_1_nine_two_down_style_image" class="buttons-set"><button style="" onclick="MediabrowserUtility.openDialog(\''.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_1_nine_two_down_style_image/\')" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button></div><textarea name="homepage_element_1_nine_two_down_style_image" title="" id="homepage_element_1_nine_two_down_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_1_nine_two_down_style_image'].'</textarea><small>Image size must be 346*170 pixels</small></td>';
      						$str = $str . '<script type="text/javascript">';
      						$str = $str . ' openEditorPopup = function(url, name, specs, parent) {';
      						$str = $str . ' if ((typeof popups == "undefined") || popups[name] == undefined || popups[name].closed) {';
      						$str = $str . ' if (typeof popups == "undefined") {';
      						$str = $str . ' popups = new Array();';
      						$str = $str . ' }';
      						$str = $str . ' var opener = (parent != undefined ? parent : window);';
      						$str = $str . 'popups[name] = opener.open(url, name, specs);';
      						$str = $str . ' } else {';
      						$str = $str . ' popups[name].focus();';
      						$str = $str . ' }';
      						$str = $str . 'return popups[name];';
      						$str = $str . '}';
      						$str = $str . 'closeEditorPopup = function(name) {';
      						$str = $str . 'if ((typeof popups != "undefined") &amp;&amp; popups[name] != undefined &amp;&amp; !popups[name].closed) {';
      						$str = $str . 'popups[name].close();';
      						$str = $str . '}';
      						$str = $str . '}';
      						$str = $str . ' </script>';
      						$str = $str . '<script type="text/javascript">';
      						$str = $str . 'if ("undefined" != typeof(Translator)) {';
      						$str = $str . 'Translator.add({"Insert Image...":"Insert Image...","Insert Media...":"Insert Media...","Insert File...":"Insert File..."});';
      						$str = $str . '}wysiwyghomepage_element_1_nine_two_down_style_image = new tinyMceWysiwygSetup("homepage_element_1_nine_two_down_style_image", {"enabled":true,"hidden":true,"use_container":false,"add_variables":true,"add_widgets":true,"add_images":true,"no_display":false,"translator":{},"encode_directives":true,"directives_url":"'.$baseurl.'evolved/cms_wysiwyg/directive/","popup_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/dialog.css","content_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/content.css","width":"100%","plugins":[{"name":"magentovariable","src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentovariable/editor_plugin.js","options":{"title":"Insert Variable...","url":"'.$baseurl.'evolved/system_variable/wysiwygPlugin/","onclick":{"search":["html_id"],"subject":"MagentovariablePlugin.loadChooser(\''.$baseurl.'evolved/system_variable/wysiwygPlugin/\', \'{{html_id}}\');"},"class":"add-variable plugin"}}],"directives_url_quoted":"'.$baseurl.'evolved/cms_wysiwyg/directive/","files_browser_window_url":"'.$baseurl.'idealAdmin/cms_wysiwyg_images/index/","files_browser_window_width":1000,"files_browser_window_height":600,"widget_plugin_src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentowidget/editor_plugin.js","widget_images_url":"'.$siteurl.'skin/adminhtml/default/default/images/widget/","widget_placeholders":["Thumbs.db","catalog__category_widget_link.gif","catalog__product_widget_link.gif","catalog__product_widget_new.gif","cms__widget_block.gif","cms__widget_page_link.gif","default.gif","reports__product_widget_compared.gif","reports__product_widget_viewed.gif"],"widget_window_url":"'.$baseurl.'evolved/widget/index/","firebug_warning_title":"Warning","firebug_warning_text":"Firebug is known to make the WYSIWYG editor slow unless it is turned off or configured properly.","firebug_warning_anchor":"Hide"});';
      						$str = $str . 'editorFormValidationHandler = wysiwyghomepage_element_1_nine_two_down_style_image.onFormValidation.bind(wysiwyghomepage_element_1_nine_two_down_style_image);';
      						$str = $str . 'Event.observe("togglehomepage_element_1_nine_two_down_style_image", "click", wysiwyghomepage_element_1_nine_two_down_style_image.toggle.bind(wysiwyghomepage_element_1_nine_two_down_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("formSubmit", editorFormValidationHandler);';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceBeforeSetContent", wysiwyghomepage_element_1_nine_two_down_style_image.beforeSetContent.bind(wysiwyghomepage_element_1_nine_two_down_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceSaveContent", wysiwyghomepage_element_1_nine_two_down_style_image.saveContent.bind(wysiwyghomepage_element_1_nine_two_down_style_image));';
      						$str = $str . 'varienGlobalEvents.clearEventHandlers("open_browser_callback");';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("open_browser_callback", wysiwyghomepage_element_1_nine_two_down_style_image.openFileBrowser.bind(wysiwyghomepage_element_1_nine_two_down_style_image));';
      						$str = $str . '</script>';
      						$str = $str . '</tr>';
      						$str = $str . '</tbody>';
      						$str = $str . '</table>';
      						$str = $str . '<table cellspacing="0" class="form-list allpageelement" style="display: table-cell;">';
							$str = $str . '<tbody>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_nine_three_style_title">Title:</label></td>';  
      						$str = $str . '<td class="value"><input id="homepage_element_1_nine_three_style_title" value="'.$collectiondata['homepage_element_1_nine_three_style_title'].'" name="homepage_element_1_nine_three_style_title"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str .	'<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_nine_three_style_link">Link:</label></td>';
      						$str = $str . '<td class="value"><input id="homepage_element_1_nine_three_style_link" value="'.$collectiondata['homepage_element_1_nine_three_style_link'].'" name="homepage_element_1_nine_three_style_link"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_nine_three_style_image">Image:</label></td>';
      						//$str = $str . '<td class="value"><div id="buttonshomepage_element_1_nine_three_style_image" class="buttons-set"><button type="button" class="scalable show-hide" style="" id="togglehomepage_element_1_nine_three_style_image"><span><span><span>Show / Hide Editor</span></span></span></button><button type="button" class="scalable add-widget plugin" onclick="widgetTools.openDialog('.$baseurl.'evolved/widget/index/widget_target_id/homepage_element_1_nine_three_style_image)" style=""><span><span><span>Insert Widget...</span></span></span></button><button type="button" class="scalable add-image plugin" onclick="MediabrowserUtility.openDialog('.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_1_nine_three_style_image/)" style=""><span><span><span>Insert Image...</span></span></span></button><button type="button" class="scalable add-variable plugin" onclick="MagentovariablePlugin.loadChooser('.$baseurl.'evolved/system_variable/wysiwygPlugin/, homepage_element_1_nine_three_style_image);"><span><span><span>Insert Variable...</span></span></span></button></div><textarea name="homepage_element_1_nine_three_style_image" title="" id="homepage_element_1_nine_three_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_1_nine_three_style_image'].'</textarea><small>Image size must be 1920*480 pixels</small></td>';
      						$str = $str . '<td class="value"><button id="togglehomepage_element_1_nine_three_style_image" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><div id="buttonshomepage_element_1_nine_three_style_image" class="buttons-set"><button style="" onclick="MediabrowserUtility.openDialog(\''.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_1_nine_three_style_image/\')" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button></div><textarea name="homepage_element_1_nine_three_style_image" title="" id="homepage_element_1_nine_three_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_1_nine_three_style_image'].'</textarea><small>Image size must be 346*346 pixels</small></td>';
      						$str = $str . '<script type="text/javascript">';
      						$str = $str . ' openEditorPopup = function(url, name, specs, parent) {';
      						$str = $str . ' if ((typeof popups == "undefined") || popups[name] == undefined || popups[name].closed) {';
      						$str = $str . ' if (typeof popups == "undefined") {';
      						$str = $str . ' popups = new Array();';
      						$str = $str . ' }';
      						$str = $str . ' var opener = (parent != undefined ? parent : window);';
      						$str = $str . 'popups[name] = opener.open(url, name, specs);';
      						$str = $str . ' } else {';
      						$str = $str . ' popups[name].focus();';
      						$str = $str . ' }';
      						$str = $str . 'return popups[name];';
      						$str = $str . '}';
      						$str = $str . 'closeEditorPopup = function(name) {';
      						$str = $str . 'if ((typeof popups != "undefined") &amp;&amp; popups[name] != undefined &amp;&amp; !popups[name].closed) {';
      						$str = $str . 'popups[name].close();';
      						$str = $str . '}';
      						$str = $str . '}';
      						$str = $str . ' </script>';
      						$str = $str . '<script type="text/javascript">';
      						$str = $str . 'if ("undefined" != typeof(Translator)) {';
      						$str = $str . 'Translator.add({"Insert Image...":"Insert Image...","Insert Media...":"Insert Media...","Insert File...":"Insert File..."});';
      						$str = $str . '}wysiwyghomepage_element_1_nine_three_style_image = new tinyMceWysiwygSetup("homepage_element_1_nine_three_style_image", {"enabled":true,"hidden":true,"use_container":false,"add_variables":true,"add_widgets":true,"add_images":true,"no_display":false,"translator":{},"encode_directives":true,"directives_url":"'.$baseurl.'evolved/cms_wysiwyg/directive/","popup_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/dialog.css","content_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/content.css","width":"100%","plugins":[{"name":"magentovariable","src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentovariable/editor_plugin.js","options":{"title":"Insert Variable...","url":"'.$baseurl.'evolved/system_variable/wysiwygPlugin/","onclick":{"search":["html_id"],"subject":"MagentovariablePlugin.loadChooser(\''.$baseurl.'evolved/system_variable/wysiwygPlugin/\', \'{{html_id}}\');"},"class":"add-variable plugin"}}],"directives_url_quoted":"'.$baseurl.'evolved/cms_wysiwyg/directive/","files_browser_window_url":"'.$baseurl.'idealAdmin/cms_wysiwyg_images/index/","files_browser_window_width":1000,"files_browser_window_height":600,"widget_plugin_src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentowidget/editor_plugin.js","widget_images_url":"'.$siteurl.'skin/adminhtml/default/default/images/widget/","widget_placeholders":["Thumbs.db","catalog__category_widget_link.gif","catalog__product_widget_link.gif","catalog__product_widget_new.gif","cms__widget_block.gif","cms__widget_page_link.gif","default.gif","reports__product_widget_compared.gif","reports__product_widget_viewed.gif"],"widget_window_url":"'.$baseurl.'evolved/widget/index/","firebug_warning_title":"Warning","firebug_warning_text":"Firebug is known to make the WYSIWYG editor slow unless it is turned off or configured properly.","firebug_warning_anchor":"Hide"});';
      						$str = $str . 'editorFormValidationHandler = wysiwyghomepage_element_1_nine_three_style_image.onFormValidation.bind(wysiwyghomepage_element_1_nine_three_style_image);';
      						$str = $str . 'Event.observe("togglehomepage_element_1_nine_three_style_image", "click", wysiwyghomepage_element_1_nine_three_style_image.toggle.bind(wysiwyghomepage_element_1_nine_three_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("formSubmit", editorFormValidationHandler);';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceBeforeSetContent", wysiwyghomepage_element_1_nine_three_style_image.beforeSetContent.bind(wysiwyghomepage_element_1_nine_three_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceSaveContent", wysiwyghomepage_element_1_nine_three_style_image.saveContent.bind(wysiwyghomepage_element_1_nine_three_style_image));';
      						$str = $str . 'varienGlobalEvents.clearEventHandlers("open_browser_callback");';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("open_browser_callback", wysiwyghomepage_element_1_nine_three_style_image.openFileBrowser.bind(wysiwyghomepage_element_1_nine_three_style_image));';
      						$str = $str . '</script>';
      						$str = $str . '</tr>';
      						$str = $str . '</tbody>';
      						$str = $str . '</table>';
      						$str = $str . '</td>';
      						$str = $str . '</tr>';
      						$str = $str . '</tbody>';
      						$str = $str . '</table>';
      					}
      					//else if($selectElement == '33_%_346_by_346_three_boxes_leftright_updown_width')
      					{
      						if($selectElement == 'homepage_element_1_33_percentage_346_by_346_three_boxes_leftright_updown_width')
      						{
      							$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="homepage_element_1_33_percentage_346_by_346_three_boxes_leftright_updown_width" style="display: block">';
      						}
      						else
      						{
      							$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="homepage_element_1_33_percentage_346_by_346_three_boxes_leftright_updown_width"  style="display: none">';
      						}
      						//$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="33_percentage_346_by_346_three_boxes_leftright_updown_width">';
      						$str = $str . '<tbody>';
      						$str = $str . '<tr>';
      						$str = $str . '<td>';
      						$str = $str . '<table cellspacing="0" class="form-list allpageelement" style="display: table-cell;">';
							$str = $str . '<tbody>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_ten_one_up_style_title">Title:</label></td>';  
      						$str = $str . '<td class="value"><input id="homepage_element_1_ten_one_up_style_title" value="'.$collectiondata['homepage_element_1_ten_one_up_style_title'].'" name="homepage_element_1_ten_one_up_style_title"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str .	'<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_ten_one_up_style_link">Link:</label></td>';
      						$str = $str . '<td class="value"><input id="homepage_element_1_ten_one_up_style_link" value="'.$collectiondata['homepage_element_1_ten_one_up_style_link'].'" name="homepage_element_1_ten_one_up_style_link"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_ten_one_up_style_image">Image:</label></td>';
      						//$str = $str . '<td class="value"><div id="buttonshomepage_element_1_ten_one_up_style_image" class="buttons-set"><button type="button" class="scalable show-hide" style="" id="togglehomepage_element_1_ten_one_up_style_image"><span><span><span>Show / Hide Editor</span></span></span></button><button type="button" class="scalable add-widget plugin" onclick="widgetTools.openDialog('.$baseurl.'evolved/widget/index/widget_target_id/homepage_element_1_ten_one_up_style_image)" style=""><span><span><span>Insert Widget...</span></span></span></button><button type="button" class="scalable add-image plugin" onclick="MediabrowserUtility.openDialog('.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_1_ten_one_up_style_image/)" style=""><span><span><span>Insert Image...</span></span></span></button><button type="button" class="scalable add-variable plugin" onclick="MagentovariablePlugin.loadChooser('.$baseurl.'evolved/system_variable/wysiwygPlugin/, homepage_element_1_ten_one_up_style_image);"><span><span><span>Insert Variable...</span></span></span></button></div><textarea name="homepage_element_1_ten_one_up_style_image" title="" id="homepage_element_1_ten_one_up_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_1_ten_one_up_style_image'].'</textarea><small>Image size must be 1920*480 pixels</small></td>';
      						$str = $str . '<td class="value"><button id="togglehomepage_element_1_ten_one_up_style_image" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><div id="buttonshomepage_element_1_ten_one_up_style_image" class="buttons-set"><button style="" onclick="MediabrowserUtility.openDialog(\''.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_1_ten_one_up_style_image/\')" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button></div><textarea name="homepage_element_1_ten_one_up_style_image" title="" id="homepage_element_1_ten_one_up_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_1_ten_one_up_style_image'].'</textarea><small>Image size must be 346*170 pixels</small></td>';
      						$str = $str . '<script type="text/javascript">';
      						$str = $str . ' openEditorPopup = function(url, name, specs, parent) {';
      						$str = $str . ' if ((typeof popups == "undefined") || popups[name] == undefined || popups[name].closed) {';
      						$str = $str . ' if (typeof popups == "undefined") {';
      						$str = $str . ' popups = new Array();';
      						$str = $str . ' }';
      						$str = $str . ' var opener = (parent != undefined ? parent : window);';
      						$str = $str . 'popups[name] = opener.open(url, name, specs);';
      						$str = $str . ' } else {';
      						$str = $str . ' popups[name].focus();';
      						$str = $str . ' }';
      						$str = $str . 'return popups[name];';
      						$str = $str . '}';
      						$str = $str . 'closeEditorPopup = function(name) {';
      						$str = $str . 'if ((typeof popups != "undefined") &amp;&amp; popups[name] != undefined &amp;&amp; !popups[name].closed) {';
      						$str = $str . 'popups[name].close();';
      						$str = $str . '}';
      						$str = $str . '}';
      						$str = $str . ' </script>';
      						$str = $str . '<script type="text/javascript">';
      						$str = $str . 'if ("undefined" != typeof(Translator)) {';
      						$str = $str . 'Translator.add({"Insert Image...":"Insert Image...","Insert Media...":"Insert Media...","Insert File...":"Insert File..."});';
      						$str = $str . '}wysiwyghomepage_element_1_ten_one_up_style_image = new tinyMceWysiwygSetup("homepage_element_1_ten_one_up_style_image", {"enabled":true,"hidden":true,"use_container":false,"add_variables":true,"add_widgets":true,"add_images":true,"no_display":false,"translator":{},"encode_directives":true,"directives_url":"'.$baseurl.'evolved/cms_wysiwyg/directive/","popup_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/dialog.css","content_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/content.css","width":"100%","plugins":[{"name":"magentovariable","src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentovariable/editor_plugin.js","options":{"title":"Insert Variable...","url":"'.$baseurl.'evolved/system_variable/wysiwygPlugin/","onclick":{"search":["html_id"],"subject":"MagentovariablePlugin.loadChooser(\''.$baseurl.'evolved/system_variable/wysiwygPlugin/\', \'{{html_id}}\');"},"class":"add-variable plugin"}}],"directives_url_quoted":"'.$baseurl.'evolved/cms_wysiwyg/directive/","files_browser_window_url":"'.$baseurl.'idealAdmin/cms_wysiwyg_images/index/","files_browser_window_width":1000,"files_browser_window_height":600,"widget_plugin_src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentowidget/editor_plugin.js","widget_images_url":"'.$siteurl.'skin/adminhtml/default/default/images/widget/","widget_placeholders":["Thumbs.db","catalog__category_widget_link.gif","catalog__product_widget_link.gif","catalog__product_widget_new.gif","cms__widget_block.gif","cms__widget_page_link.gif","default.gif","reports__product_widget_compared.gif","reports__product_widget_viewed.gif"],"widget_window_url":"'.$baseurl.'evolved/widget/index/","firebug_warning_title":"Warning","firebug_warning_text":"Firebug is known to make the WYSIWYG editor slow unless it is turned off or configured properly.","firebug_warning_anchor":"Hide"});';
      						$str = $str . 'editorFormValidationHandler = wysiwyghomepage_element_1_ten_one_up_style_image.onFormValidation.bind(wysiwyghomepage_element_1_ten_one_up_style_image);';
      						$str = $str . 'Event.observe("togglehomepage_element_1_ten_one_up_style_image", "click", wysiwyghomepage_element_1_ten_one_up_style_image.toggle.bind(wysiwyghomepage_element_1_ten_one_up_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("formSubmit", editorFormValidationHandler);';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceBeforeSetContent", wysiwyghomepage_element_1_ten_one_up_style_image.beforeSetContent.bind(wysiwyghomepage_element_1_ten_one_up_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceSaveContent", wysiwyghomepage_element_1_ten_one_up_style_image.saveContent.bind(wysiwyghomepage_element_1_ten_one_up_style_image));';
      						$str = $str . 'varienGlobalEvents.clearEventHandlers("open_browser_callback");';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("open_browser_callback", wysiwyghomepage_element_1_ten_one_up_style_image.openFileBrowser.bind(wysiwyghomepage_element_1_ten_one_up_style_image));';
      						$str = $str . '</script>';
      						$str = $str . '</tr>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_ten_one_down_style_title">Title:</label></td>';  
      						$str = $str . '<td class="value"><input id="homepage_element_1_ten_one_down_style_title" value="'.$collectiondata['homepage_element_1_ten_one_down_style_title'].'" name="homepage_element_1_ten_one_down_style_title"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str .	'<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_ten_one_down_style_link">Link:</label></td>';
      						$str = $str . '<td class="value"><input id="homepage_element_1_ten_one_down_style_link" value="'.$collectiondata['homepage_element_1_ten_one_down_style_link'].'" name="homepage_element_1_ten_one_down_style_link"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_ten_one_down_style_image">Image:</label></td>';
      						//$str = $str . '<td class="value"><div id="buttonshomepage_element_1_ten_one_down_style_image" class="buttons-set"><button type="button" class="scalable show-hide" style="" id="togglehomepage_element_1_ten_one_down_style_image"><span><span><span>Show / Hide Editor</span></span></span></button><button type="button" class="scalable add-widget plugin" onclick="widgetTools.openDialog('.$baseurl.'evolved/widget/index/widget_target_id/homepage_element_1_ten_one_down_style_image)" style=""><span><span><span>Insert Widget...</span></span></span></button><button type="button" class="scalable add-image plugin" onclick="MediabrowserUtility.openDialog('.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_1_ten_one_down_style_image/)" style=""><span><span><span>Insert Image...</span></span></span></button><button type="button" class="scalable add-variable plugin" onclick="MagentovariablePlugin.loadChooser('.$baseurl.'evolved/system_variable/wysiwygPlugin/, homepage_element_1_ten_one_down_style_image);"><span><span><span>Insert Variable...</span></span></span></button></div><textarea name="homepage_element_1_ten_one_down_style_image" title="" id="homepage_element_1_ten_one_down_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_1_ten_one_down_style_image'].'</textarea><small>Image size must be 1920*480 pixels</small></td>';
      						$str = $str . '<td class="value"><button id="togglehomepage_element_1_ten_one_down_style_image" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><div id="buttonshomepage_element_1_ten_one_down_style_image" class="buttons-set"><button style="" onclick="MediabrowserUtility.openDialog(\''.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_1_ten_one_down_style_image/\')" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button></div><textarea name="homepage_element_1_ten_one_down_style_image" title="" id="homepage_element_1_ten_one_down_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_1_ten_one_down_style_image'].'</textarea><small>Image size must be 346*170 pixels</small></td>';
      						$str = $str . '<script type="text/javascript">';
      						$str = $str . ' openEditorPopup = function(url, name, specs, parent) {';
      						$str = $str . ' if ((typeof popups == "undefined") || popups[name] == undefined || popups[name].closed) {';
      						$str = $str . ' if (typeof popups == "undefined") {';
      						$str = $str . ' popups = new Array();';
      						$str = $str . ' }';
      						$str = $str . ' var opener = (parent != undefined ? parent : window);';
      						$str = $str . 'popups[name] = opener.open(url, name, specs);';
      						$str = $str . ' } else {';
      						$str = $str . ' popups[name].focus();';
      						$str = $str . ' }';
      						$str = $str . 'return popups[name];';
      						$str = $str . '}';
      						$str = $str . 'closeEditorPopup = function(name) {';
      						$str = $str . 'if ((typeof popups != "undefined") &amp;&amp; popups[name] != undefined &amp;&amp; !popups[name].closed) {';
      						$str = $str . 'popups[name].close();';
      						$str = $str . '}';
      						$str = $str . '}';
      						$str = $str . ' </script>';
      						$str = $str . '<script type="text/javascript">';
      						$str = $str . 'if ("undefined" != typeof(Translator)) {';
      						$str = $str . 'Translator.add({"Insert Image...":"Insert Image...","Insert Media...":"Insert Media...","Insert File...":"Insert File..."});';
      						$str = $str . '}wysiwyghomepage_element_1_ten_one_down_style_image = new tinyMceWysiwygSetup("homepage_element_1_ten_one_down_style_image", {"enabled":true,"hidden":true,"use_container":false,"add_variables":true,"add_widgets":true,"add_images":true,"no_display":false,"translator":{},"encode_directives":true,"directives_url":"'.$baseurl.'evolved/cms_wysiwyg/directive/","popup_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/dialog.css","content_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/content.css","width":"100%","plugins":[{"name":"magentovariable","src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentovariable/editor_plugin.js","options":{"title":"Insert Variable...","url":"'.$baseurl.'evolved/system_variable/wysiwygPlugin/","onclick":{"search":["html_id"],"subject":"MagentovariablePlugin.loadChooser(\''.$baseurl.'evolved/system_variable/wysiwygPlugin/\', \'{{html_id}}\');"},"class":"add-variable plugin"}}],"directives_url_quoted":"'.$baseurl.'evolved/cms_wysiwyg/directive/","files_browser_window_url":"'.$baseurl.'idealAdmin/cms_wysiwyg_images/index/","files_browser_window_width":1000,"files_browser_window_height":600,"widget_plugin_src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentowidget/editor_plugin.js","widget_images_url":"'.$siteurl.'skin/adminhtml/default/default/images/widget/","widget_placeholders":["Thumbs.db","catalog__category_widget_link.gif","catalog__product_widget_link.gif","catalog__product_widget_new.gif","cms__widget_block.gif","cms__widget_page_link.gif","default.gif","reports__product_widget_compared.gif","reports__product_widget_viewed.gif"],"widget_window_url":"'.$baseurl.'evolved/widget/index/","firebug_warning_title":"Warning","firebug_warning_text":"Firebug is known to make the WYSIWYG editor slow unless it is turned off or configured properly.","firebug_warning_anchor":"Hide"});';
      						$str = $str . 'editorFormValidationHandler = wysiwyghomepage_element_1_ten_one_down_style_image.onFormValidation.bind(wysiwyghomepage_element_1_ten_one_down_style_image);';
      						$str = $str . 'Event.observe("togglehomepage_element_1_ten_one_down_style_image", "click", wysiwyghomepage_element_1_ten_one_down_style_image.toggle.bind(wysiwyghomepage_element_1_ten_one_down_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("formSubmit", editorFormValidationHandler);';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceBeforeSetContent", wysiwyghomepage_element_1_ten_one_down_style_image.beforeSetContent.bind(wysiwyghomepage_element_1_ten_one_down_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceSaveContent", wysiwyghomepage_element_1_ten_one_down_style_image.saveContent.bind(wysiwyghomepage_element_1_ten_one_down_style_image));';
      						$str = $str . 'varienGlobalEvents.clearEventHandlers("open_browser_callback");';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("open_browser_callback", wysiwyghomepage_element_1_ten_one_down_style_image.openFileBrowser.bind(wysiwyghomepage_element_1_ten_one_down_style_image));';
      						$str = $str . '</script>';
      						$str = $str . '</tr>';
      						$str = $str . '</tbody>';
      						$str = $str . '</table>'; 
      						$str = $str . '<table cellspacing="0" class="form-list allpageelement" style="display: table-cell;">';
							$str = $str . '<tbody>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_ten_two_style_title">Title:</label></td>';  
      						$str = $str . '<td class="value"><input id="homepage_element_1_ten_two_style_title" value="'.$collectiondata['homepage_element_1_ten_two_style_title'].'" name="homepage_element_1_ten_two_style_title"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str .	'<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_ten_two_style_link">Link:</label></td>';
      						$str = $str . '<td class="value"><input id="homepage_element_1_ten_two_style_link" value="'.$collectiondata['homepage_element_1_ten_two_style_link'].'" name="homepage_element_1_ten_two_style_link"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_ten_two_style_image">Image:</label></td>';
      						//$str = $str . '<td class="value"><div id="buttonshomepage_element_1_ten_two_style_image" class="buttons-set"><button type="button" class="scalable show-hide" style="" id="togglehomepage_element_1_ten_two_style_image"><span><span><span>Show / Hide Editor</span></span></span></button><button type="button" class="scalable add-widget plugin" onclick="widgetTools.openDialog('.$baseurl.'evolved/widget/index/widget_target_id/homepage_element_1_ten_two_style_image)" style=""><span><span><span>Insert Widget...</span></span></span></button><button type="button" class="scalable add-image plugin" onclick="MediabrowserUtility.openDialog('.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_1_ten_two_style_image/)" style=""><span><span><span>Insert Image...</span></span></span></button><button type="button" class="scalable add-variable plugin" onclick="MagentovariablePlugin.loadChooser('.$baseurl.'evolved/system_variable/wysiwygPlugin/, homepage_element_1_ten_two_style_image);"><span><span><span>Insert Variable...</span></span></span></button></div><textarea name="homepage_element_1_ten_two_style_image" title="" id="homepage_element_1_ten_two_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_1_ten_two_style_image'].'</textarea><small>Image size must be 1920*480 pixels</small></td>';
      						$str = $str . '<td class="value"><button id="togglehomepage_element_1_ten_two_style_image" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><div id="buttonshomepage_element_1_ten_two_style_image" class="buttons-set"><button style="" onclick="MediabrowserUtility.openDialog(\''.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_1_ten_two_style_image/\')" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button></div><textarea name="homepage_element_1_ten_two_style_image" title="" id="homepage_element_1_ten_two_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_1_ten_two_style_image'].'</textarea><small>Image size must be 346*346 pixels</small></td>';
      						$str = $str . '<script type="text/javascript">';
      						$str = $str . ' openEditorPopup = function(url, name, specs, parent) {';
      						$str = $str . ' if ((typeof popups == "undefined") || popups[name] == undefined || popups[name].closed) {';
      						$str = $str . ' if (typeof popups == "undefined") {';
      						$str = $str . ' popups = new Array();';
      						$str = $str . ' }';
      						$str = $str . ' var opener = (parent != undefined ? parent : window);';
      						$str = $str . 'popups[name] = opener.open(url, name, specs);';
      						$str = $str . ' } else {';
      						$str = $str . ' popups[name].focus();';
      						$str = $str . ' }';
      						$str = $str . 'return popups[name];';
      						$str = $str . '}';
      						$str = $str . 'closeEditorPopup = function(name) {';
      						$str = $str . 'if ((typeof popups != "undefined") &amp;&amp; popups[name] != undefined &amp;&amp; !popups[name].closed) {';
      						$str = $str . 'popups[name].close();';
      						$str = $str . '}';
      						$str = $str . '}';
      						$str = $str . ' </script>';
      						$str = $str . '<script type="text/javascript">';
      						$str = $str . 'if ("undefined" != typeof(Translator)) {';
      						$str = $str . 'Translator.add({"Insert Image...":"Insert Image...","Insert Media...":"Insert Media...","Insert File...":"Insert File..."});';
      						$str = $str . '}wysiwyghomepage_element_1_ten_two_style_image = new tinyMceWysiwygSetup("homepage_element_1_ten_two_style_image", {"enabled":true,"hidden":true,"use_container":false,"add_variables":true,"add_widgets":true,"add_images":true,"no_display":false,"translator":{},"encode_directives":true,"directives_url":"'.$baseurl.'evolved/cms_wysiwyg/directive/","popup_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/dialog.css","content_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/content.css","width":"100%","plugins":[{"name":"magentovariable","src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentovariable/editor_plugin.js","options":{"title":"Insert Variable...","url":"'.$baseurl.'evolved/system_variable/wysiwygPlugin/","onclick":{"search":["html_id"],"subject":"MagentovariablePlugin.loadChooser(\''.$baseurl.'evolved/system_variable/wysiwygPlugin/\', \'{{html_id}}\');"},"class":"add-variable plugin"}}],"directives_url_quoted":"'.$baseurl.'evolved/cms_wysiwyg/directive/","files_browser_window_url":"'.$baseurl.'idealAdmin/cms_wysiwyg_images/index/","files_browser_window_width":1000,"files_browser_window_height":600,"widget_plugin_src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentowidget/editor_plugin.js","widget_images_url":"'.$siteurl.'skin/adminhtml/default/default/images/widget/","widget_placeholders":["Thumbs.db","catalog__category_widget_link.gif","catalog__product_widget_link.gif","catalog__product_widget_new.gif","cms__widget_block.gif","cms__widget_page_link.gif","default.gif","reports__product_widget_compared.gif","reports__product_widget_viewed.gif"],"widget_window_url":"'.$baseurl.'evolved/widget/index/","firebug_warning_title":"Warning","firebug_warning_text":"Firebug is known to make the WYSIWYG editor slow unless it is turned off or configured properly.","firebug_warning_anchor":"Hide"});';
      						$str = $str . 'editorFormValidationHandler = wysiwyghomepage_element_1_ten_two_style_image.onFormValidation.bind(wysiwyghomepage_element_1_ten_two_style_image);';
      						$str = $str . 'Event.observe("togglehomepage_element_1_ten_two_style_image", "click", wysiwyghomepage_element_1_ten_two_style_image.toggle.bind(wysiwyghomepage_element_1_ten_two_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("formSubmit", editorFormValidationHandler);';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceBeforeSetContent", wysiwyghomepage_element_1_ten_two_style_image.beforeSetContent.bind(wysiwyghomepage_element_1_ten_two_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceSaveContent", wysiwyghomepage_element_1_ten_two_style_image.saveContent.bind(wysiwyghomepage_element_1_ten_two_style_image));';
      						$str = $str . 'varienGlobalEvents.clearEventHandlers("open_browser_callback");';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("open_browser_callback", wysiwyghomepage_element_1_ten_two_style_image.openFileBrowser.bind(wysiwyghomepage_element_1_ten_two_style_image));';
      						$str = $str . '</script>';
      						$str = $str . '</tr>';
      						$str = $str . '</tbody>';
      						$str = $str . '</table>';
      						$str = $str . '<table cellspacing="0" class="form-list allpageelement" style="display: table-cell;">';
							$str = $str . '<tbody>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_ten_three_up_style_title">Title:</label></td>';  
      						$str = $str . '<td class="value"><input id="homepage_element_1_ten_three_up_style_title" value="'.$collectiondata['homepage_element_1_ten_three_up_style_title'].'" name="homepage_element_1_ten_three_up_style_title"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str .	'<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_ten_three_up_style_link">Link:</label></td>';
      						$str = $str . '<td class="value"><input id="homepage_element_1_ten_three_up_style_link" value="'.$collectiondata['homepage_element_1_ten_three_up_style_link'].'" name="homepage_element_1_ten_three_up_style_link"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_ten_three_up_style_image">Image:</label></td>';
      						//$str = $str . '<td class="value"><div id="buttonshomepage_element_1_ten_three_up_style_image" class="buttons-set"><button type="button" class="scalable show-hide" style="" id="togglehomepage_element_1_ten_three_up_style_image"><span><span><span>Show / Hide Editor</span></span></span></button><button type="button" class="scalable add-widget plugin" onclick="widgetTools.openDialog('.$baseurl.'evolved/widget/index/widget_target_id/homepage_element_1_ten_three_up_style_image)" style=""><span><span><span>Insert Widget...</span></span></span></button><button type="button" class="scalable add-image plugin" onclick="MediabrowserUtility.openDialog('.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_1_ten_three_up_style_image/)" style=""><span><span><span>Insert Image...</span></span></span></button><button type="button" class="scalable add-variable plugin" onclick="MagentovariablePlugin.loadChooser('.$baseurl.'evolved/system_variable/wysiwygPlugin/, homepage_element_1_ten_three_up_style_image);"><span><span><span>Insert Variable...</span></span></span></button></div><textarea name="homepage_element_1_ten_three_up_style_image" title="" id="homepage_element_1_ten_three_up_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_1_ten_three_up_style_image'].'</textarea><small>Image size must be 1920*480 pixels</small></td>';
      						$str = $str . '<td class="value"><button id="togglehomepage_element_1_ten_three_up_style_image" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><div id="buttonshomepage_element_1_ten_three_up_style_image" class="buttons-set"><button style="" onclick="MediabrowserUtility.openDialog(\''.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_1_ten_three_up_style_image/\')" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button></div><textarea name="homepage_element_1_ten_three_up_style_image" title="" id="homepage_element_1_ten_three_up_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_1_ten_three_up_style_image'].'</textarea><small>Image size must be 346*170 pixels</small></td>';
      						$str = $str . '<script type="text/javascript">';
      						$str = $str . ' openEditorPopup = function(url, name, specs, parent) {';
      						$str = $str . ' if ((typeof popups == "undefined") || popups[name] == undefined || popups[name].closed) {';
      						$str = $str . ' if (typeof popups == "undefined") {';
      						$str = $str . ' popups = new Array();';
      						$str = $str . ' }';
      						$str = $str . ' var opener = (parent != undefined ? parent : window);';
      						$str = $str . 'popups[name] = opener.open(url, name, specs);';
      						$str = $str . ' } else {';
      						$str = $str . ' popups[name].focus();';
      						$str = $str . ' }';
      						$str = $str . 'return popups[name];';
      						$str = $str . '}';
      						$str = $str . 'closeEditorPopup = function(name) {';
      						$str = $str . 'if ((typeof popups != "undefined") &amp;&amp; popups[name] != undefined &amp;&amp; !popups[name].closed) {';
      						$str = $str . 'popups[name].close();';
      						$str = $str . '}';
      						$str = $str . '}';
      						$str = $str . ' </script>';
      						$str = $str . '<script type="text/javascript">';
      						$str = $str . 'if ("undefined" != typeof(Translator)) {';
      						$str = $str . 'Translator.add({"Insert Image...":"Insert Image...","Insert Media...":"Insert Media...","Insert File...":"Insert File..."});';
      						$str = $str . '}wysiwyghomepage_element_1_ten_three_up_style_image = new tinyMceWysiwygSetup("homepage_element_1_ten_three_up_style_image", {"enabled":true,"hidden":true,"use_container":false,"add_variables":true,"add_widgets":true,"add_images":true,"no_display":false,"translator":{},"encode_directives":true,"directives_url":"'.$baseurl.'evolved/cms_wysiwyg/directive/","popup_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/dialog.css","content_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/content.css","width":"100%","plugins":[{"name":"magentovariable","src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentovariable/editor_plugin.js","options":{"title":"Insert Variable...","url":"'.$baseurl.'evolved/system_variable/wysiwygPlugin/","onclick":{"search":["html_id"],"subject":"MagentovariablePlugin.loadChooser(\''.$baseurl.'evolved/system_variable/wysiwygPlugin/\', \'{{html_id}}\');"},"class":"add-variable plugin"}}],"directives_url_quoted":"'.$baseurl.'evolved/cms_wysiwyg/directive/","files_browser_window_url":"'.$baseurl.'idealAdmin/cms_wysiwyg_images/index/","files_browser_window_width":1000,"files_browser_window_height":600,"widget_plugin_src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentowidget/editor_plugin.js","widget_images_url":"'.$siteurl.'skin/adminhtml/default/default/images/widget/","widget_placeholders":["Thumbs.db","catalog__category_widget_link.gif","catalog__product_widget_link.gif","catalog__product_widget_new.gif","cms__widget_block.gif","cms__widget_page_link.gif","default.gif","reports__product_widget_compared.gif","reports__product_widget_viewed.gif"],"widget_window_url":"'.$baseurl.'evolved/widget/index/","firebug_warning_title":"Warning","firebug_warning_text":"Firebug is known to make the WYSIWYG editor slow unless it is turned off or configured properly.","firebug_warning_anchor":"Hide"});';
      						$str = $str . 'editorFormValidationHandler = wysiwyghomepage_element_1_ten_three_up_style_image.onFormValidation.bind(wysiwyghomepage_element_1_ten_three_up_style_image);';
      						$str = $str . 'Event.observe("togglehomepage_element_1_ten_three_up_style_image", "click", wysiwyghomepage_element_1_ten_three_up_style_image.toggle.bind(wysiwyghomepage_element_1_ten_three_up_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("formSubmit", editorFormValidationHandler);';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceBeforeSetContent", wysiwyghomepage_element_1_ten_three_up_style_image.beforeSetContent.bind(wysiwyghomepage_element_1_ten_three_up_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceSaveContent", wysiwyghomepage_element_1_ten_three_up_style_image.saveContent.bind(wysiwyghomepage_element_1_ten_three_up_style_image));';
      						$str = $str . 'varienGlobalEvents.clearEventHandlers("open_browser_callback");';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("open_browser_callback", wysiwyghomepage_element_1_ten_three_up_style_image.openFileBrowser.bind(wysiwyghomepage_element_1_ten_three_up_style_image));';
      						$str = $str . '</script>';
      						$str = $str . '</tr>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_ten_three_down_style_title">Title:</label></td>';  
      						$str = $str . '<td class="value"><input id="homepage_element_1_ten_three_down_style_title" value="'.$collectiondata['homepage_element_1_ten_three_down_style_title'].'" name="homepage_element_1_ten_three_down_style_title"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str .	'<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_ten_three_down_style_link">Link:</label></td>';
      						$str = $str . '<td class="value"><input id="homepage_element_1_ten_three_down_style_link" value="'.$collectiondata['homepage_element_1_ten_three_down_style_link'].'" name="homepage_element_1_ten_three_down_style_link"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_ten_three_down_style_image">Image:</label></td>';
      						//$str = $str . '<td class="value"><div id="buttonshomepage_element_1_ten_three_down_style_image" class="buttons-set"><button type="button" class="scalable show-hide" style="" id="togglehomepage_element_1_ten_three_down_style_image"><span><span><span>Show / Hide Editor</span></span></span></button><button type="button" class="scalable add-widget plugin" onclick="widgetTools.openDialog('.$baseurl.'evolved/widget/index/widget_target_id/homepage_element_1_ten_three_down_style_image)" style=""><span><span><span>Insert Widget...</span></span></span></button><button type="button" class="scalable add-image plugin" onclick="MediabrowserUtility.openDialog('.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_1_ten_three_down_style_image/)" style=""><span><span><span>Insert Image...</span></span></span></button><button type="button" class="scalable add-variable plugin" onclick="MagentovariablePlugin.loadChooser('.$baseurl.'evolved/system_variable/wysiwygPlugin/, homepage_element_1_ten_three_down_style_image);"><span><span><span>Insert Variable...</span></span></span></button></div><textarea name="homepage_element_1_ten_three_down_style_image" title="" id="homepage_element_1_ten_three_down_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_1_ten_three_down_style_image'].'</textarea><small>Image size must be 1920*480 pixels</small></td>';
      						$str = $str . '<td class="value"><button id="togglehomepage_element_1_ten_three_down_style_image" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><div id="buttonshomepage_element_1_ten_three_down_style_image" class="buttons-set"><button style="" onclick="MediabrowserUtility.openDialog(\''.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_1_ten_three_down_style_image/\')" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button></div><textarea name="homepage_element_1_ten_three_down_style_image" title="" id="homepage_element_1_ten_three_down_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_1_ten_three_down_style_image'].'</textarea><small>Image size must be 346*170 pixels</small></td>';
      						$str = $str . '<script type="text/javascript">';
      						$str = $str . ' openEditorPopup = function(url, name, specs, parent) {';
      						$str = $str . ' if ((typeof popups == "undefined") || popups[name] == undefined || popups[name].closed) {';
      						$str = $str . ' if (typeof popups == "undefined") {';
      						$str = $str . ' popups = new Array();';
      						$str = $str . ' }';
      						$str = $str . ' var opener = (parent != undefined ? parent : window);';
      						$str = $str . 'popups[name] = opener.open(url, name, specs);';
      						$str = $str . ' } else {';
      						$str = $str . ' popups[name].focus();';
      						$str = $str . ' }';
      						$str = $str . 'return popups[name];';
      						$str = $str . '}';
      						$str = $str . 'closeEditorPopup = function(name) {';
      						$str = $str . 'if ((typeof popups != "undefined") &amp;&amp; popups[name] != undefined &amp;&amp; !popups[name].closed) {';
      						$str = $str . 'popups[name].close();';
      						$str = $str . '}';
      						$str = $str . '}';
      						$str = $str . ' </script>';
      						$str = $str . '<script type="text/javascript">';
      						$str = $str . 'if ("undefined" != typeof(Translator)) {';
      						$str = $str . 'Translator.add({"Insert Image...":"Insert Image...","Insert Media...":"Insert Media...","Insert File...":"Insert File..."});';
      						$str = $str . '}wysiwyghomepage_element_1_ten_three_down_style_image = new tinyMceWysiwygSetup("homepage_element_1_ten_three_down_style_image", {"enabled":true,"hidden":true,"use_container":false,"add_variables":true,"add_widgets":true,"add_images":true,"no_display":false,"translator":{},"encode_directives":true,"directives_url":"'.$baseurl.'evolved/cms_wysiwyg/directive/","popup_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/dialog.css","content_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/content.css","width":"100%","plugins":[{"name":"magentovariable","src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentovariable/editor_plugin.js","options":{"title":"Insert Variable...","url":"'.$baseurl.'evolved/system_variable/wysiwygPlugin/","onclick":{"search":["html_id"],"subject":"MagentovariablePlugin.loadChooser(\''.$baseurl.'evolved/system_variable/wysiwygPlugin/\', \'{{html_id}}\');"},"class":"add-variable plugin"}}],"directives_url_quoted":"'.$baseurl.'evolved/cms_wysiwyg/directive/","files_browser_window_url":"'.$baseurl.'idealAdmin/cms_wysiwyg_images/index/","files_browser_window_width":1000,"files_browser_window_height":600,"widget_plugin_src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentowidget/editor_plugin.js","widget_images_url":"'.$siteurl.'skin/adminhtml/default/default/images/widget/","widget_placeholders":["Thumbs.db","catalog__category_widget_link.gif","catalog__product_widget_link.gif","catalog__product_widget_new.gif","cms__widget_block.gif","cms__widget_page_link.gif","default.gif","reports__product_widget_compared.gif","reports__product_widget_viewed.gif"],"widget_window_url":"'.$baseurl.'evolved/widget/index/","firebug_warning_title":"Warning","firebug_warning_text":"Firebug is known to make the WYSIWYG editor slow unless it is turned off or configured properly.","firebug_warning_anchor":"Hide"});';
      						$str = $str . 'editorFormValidationHandler = wysiwyghomepage_element_1_ten_three_down_style_image.onFormValidation.bind(wysiwyghomepage_element_1_ten_three_down_style_image);';
      						$str = $str . 'Event.observe("togglehomepage_element_1_ten_three_down_style_image", "click", wysiwyghomepage_element_1_ten_three_down_style_image.toggle.bind(wysiwyghomepage_element_1_ten_three_down_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("formSubmit", editorFormValidationHandler);';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceBeforeSetContent", wysiwyghomepage_element_1_ten_three_down_style_image.beforeSetContent.bind(wysiwyghomepage_element_1_ten_three_down_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceSaveContent", wysiwyghomepage_element_1_ten_three_down_style_image.saveContent.bind(wysiwyghomepage_element_1_ten_three_down_style_image));';
      						$str = $str . 'varienGlobalEvents.clearEventHandlers("open_browser_callback");';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("open_browser_callback", wysiwyghomepage_element_1_ten_three_down_style_image.openFileBrowser.bind(wysiwyghomepage_element_1_ten_three_down_style_image));';
      						$str = $str . '</script>';
      						$str = $str . '</tr>';
      						$str = $str . '</tbody>';
      						$str = $str . '</table>';
      						$str = $str . '</td>';
      						$str = $str . '</tr>';
      						$str = $str . '</tbody>';
      						$str = $str . '</table>';
      					}
			      		//else if($selectElement == '50_%_522_by_170_two_boxes_width')
      					{
      						if($selectElement == 'homepage_element_1_50_percentage_522_by_170_two_boxes_width')
      						{
      							$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="homepage_element_1_50_percentage_522_by_170_two_boxes_width" style="display: block">';
      						}
      						else
      						{
      							$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="homepage_element_1_50_percentage_522_by_170_two_boxes_width"  style="display: none">';
      						}
      						//$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="50_percentage_522_by_170_two_boxes_width">';
      						$str = $str . '<tbody>';
      						$str = $str . '<tr>';
      						$str = $str . '<td>';
      						$str = $str . '<table cellspacing="0" class="form-list allpageelement" style="display: table-cell;">';
							$str = $str . '<tbody>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_eleven_one_style_title">Title:</label></td>';  
      						$str = $str . '<td class="value"><input id="homepage_element_1_eleven_one_style_title" value="'.$collectiondata['homepage_element_1_eleven_one_style_title'].'" name="homepage_element_1_eleven_one_style_title"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str .	'<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_eleven_one_style_link">Link:</label></td>';
      						$str = $str . '<td class="value"><input id="homepage_element_1_eleven_one_style_link" value="'.$collectiondata['homepage_element_1_eleven_one_style_link'].'" name="homepage_element_1_eleven_one_style_link"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_eleven_one_style_image">Image:</label></td>';
      						//$str = $str . '<td class="value"><div id="buttonshomepage_element_1_eleven_one_style_image" class="buttons-set"><button type="button" class="scalable show-hide" style="" id="togglehomepage_element_1_eleven_one_style_image"><span><span><span>Show / Hide Editor</span></span></span></button><button type="button" class="scalable add-widget plugin" onclick="widgetTools.openDialog('.$baseurl.'evolved/widget/index/widget_target_id/homepage_element_1_eleven_one_style_image)" style=""><span><span><span>Insert Widget...</span></span></span></button><button type="button" class="scalable add-image plugin" onclick="MediabrowserUtility.openDialog('.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_1_eleven_one_style_image/)" style=""><span><span><span>Insert Image...</span></span></span></button><button type="button" class="scalable add-variable plugin" onclick="MagentovariablePlugin.loadChooser('.$baseurl.'evolved/system_variable/wysiwygPlugin/, homepage_element_1_eleven_one_style_image);"><span><span><span>Insert Variable...</span></span></span></button></div><textarea name="homepage_element_1_eleven_one_style_image" title="" id="homepage_element_1_eleven_one_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_1_eleven_one_style_image'].'</textarea><small>Image size must be 1920*480 pixels</small></td>';
      						$str = $str . '<td class="value"><button id="togglehomepage_element_1_eleven_one_style_image" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><div id="buttonshomepage_element_1_eleven_one_style_image" class="buttons-set"><button style="" onclick="MediabrowserUtility.openDialog(\''.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_1_eleven_one_style_image/\')" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button></div><textarea name="homepage_element_1_eleven_one_style_image" title="" id="homepage_element_1_eleven_one_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_1_eleven_one_style_image'].'</textarea><small>Image size must be 522*170 pixels</small></td>';
      						$str = $str . '<script type="text/javascript">';
      						$str = $str . ' openEditorPopup = function(url, name, specs, parent) {';
      						$str = $str . ' if ((typeof popups == "undefined") || popups[name] == undefined || popups[name].closed) {';
      						$str = $str . ' if (typeof popups == "undefined") {';
      						$str = $str . ' popups = new Array();';
      						$str = $str . ' }';
      						$str = $str . ' var opener = (parent != undefined ? parent : window);';
      						$str = $str . 'popups[name] = opener.open(url, name, specs);';
      						$str = $str . ' } else {';
      						$str = $str . ' popups[name].focus();';
      						$str = $str . ' }';
      						$str = $str . 'return popups[name];';
      						$str = $str . '}';
      						$str = $str . 'closeEditorPopup = function(name) {';
      						$str = $str . 'if ((typeof popups != "undefined") &amp;&amp; popups[name] != undefined &amp;&amp; !popups[name].closed) {';
      						$str = $str . 'popups[name].close();';
      						$str = $str . '}';
      						$str = $str . '}';
      						$str = $str . ' </script>';
      						$str = $str . '<script type="text/javascript">';
      						$str = $str . 'if ("undefined" != typeof(Translator)) {';
      						$str = $str . 'Translator.add({"Insert Image...":"Insert Image...","Insert Media...":"Insert Media...","Insert File...":"Insert File..."});';
      						$str = $str . '}wysiwyghomepage_element_1_eleven_one_style_image = new tinyMceWysiwygSetup("homepage_element_1_eleven_one_style_image", {"enabled":true,"hidden":true,"use_container":false,"add_variables":true,"add_widgets":true,"add_images":true,"no_display":false,"translator":{},"encode_directives":true,"directives_url":"'.$baseurl.'evolved/cms_wysiwyg/directive/","popup_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/dialog.css","content_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/content.css","width":"100%","plugins":[{"name":"magentovariable","src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentovariable/editor_plugin.js","options":{"title":"Insert Variable...","url":"'.$baseurl.'evolved/system_variable/wysiwygPlugin/","onclick":{"search":["html_id"],"subject":"MagentovariablePlugin.loadChooser(\''.$baseurl.'evolved/system_variable/wysiwygPlugin/\', \'{{html_id}}\');"},"class":"add-variable plugin"}}],"directives_url_quoted":"'.$baseurl.'evolved/cms_wysiwyg/directive/","files_browser_window_url":"'.$baseurl.'idealAdmin/cms_wysiwyg_images/index/","files_browser_window_width":1000,"files_browser_window_height":600,"widget_plugin_src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentowidget/editor_plugin.js","widget_images_url":"'.$siteurl.'skin/adminhtml/default/default/images/widget/","widget_placeholders":["Thumbs.db","catalog__category_widget_link.gif","catalog__product_widget_link.gif","catalog__product_widget_new.gif","cms__widget_block.gif","cms__widget_page_link.gif","default.gif","reports__product_widget_compared.gif","reports__product_widget_viewed.gif"],"widget_window_url":"'.$baseurl.'evolved/widget/index/","firebug_warning_title":"Warning","firebug_warning_text":"Firebug is known to make the WYSIWYG editor slow unless it is turned off or configured properly.","firebug_warning_anchor":"Hide"});';
      						$str = $str . 'editorFormValidationHandler = wysiwyghomepage_element_1_eleven_one_style_image.onFormValidation.bind(wysiwyghomepage_element_1_eleven_one_style_image);';
      						$str = $str . 'Event.observe("togglehomepage_element_1_eleven_one_style_image", "click", wysiwyghomepage_element_1_eleven_one_style_image.toggle.bind(wysiwyghomepage_element_1_eleven_one_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("formSubmit", editorFormValidationHandler);';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceBeforeSetContent", wysiwyghomepage_element_1_eleven_one_style_image.beforeSetContent.bind(wysiwyghomepage_element_1_eleven_one_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceSaveContent", wysiwyghomepage_element_1_eleven_one_style_image.saveContent.bind(wysiwyghomepage_element_1_eleven_one_style_image));';
      						$str = $str . 'varienGlobalEvents.clearEventHandlers("open_browser_callback");';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("open_browser_callback", wysiwyghomepage_element_1_eleven_one_style_image.openFileBrowser.bind(wysiwyghomepage_element_1_eleven_one_style_image));';
      						$str = $str . '</script>';
      						$str = $str . '</tr>';
      						$str = $str . '</tbody>';
      						$str = $str . '</table>'; 
      						$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelement" style="display: table-cell;">';
							$str = $str . '<tbody>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_eleven_two_style_title">Title:</label></td>';  
      						$str = $str . '<td class="value"><input id="homepage_element_1_eleven_two_style_title" value="'.$collectiondata['homepage_element_1_eleven_two_style_title'].'" name="homepage_element_1_eleven_two_style_title"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str .	'<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_eleven_two_style_link">Link:</label></td>';
      						$str = $str . '<td class="value"><input id="homepage_element_1_eleven_two_style_link" value="'.$collectiondata['homepage_element_1_eleven_two_style_link'].'" name="homepage_element_1_eleven_two_style_link"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_eleven_two_style_image">Image:</label></td>';
      						//$str = $str . '<td class="value"><div id="buttonshomepage_element_1_eleven_two_style_image" class="buttons-set"><button type="button" class="scalable show-hide" style="" id="togglehomepage_element_1_eleven_two_style_image"><span><span><span>Show / Hide Editor</span></span></span></button><button type="button" class="scalable add-widget plugin" onclick="widgetTools.openDialog('.$baseurl.'evolved/widget/index/widget_target_id/homepage_element_1_eleven_two_style_image)" style=""><span><span><span>Insert Widget...</span></span></span></button><button type="button" class="scalable add-image plugin" onclick="MediabrowserUtility.openDialog('.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_1_eleven_two_style_image/)" style=""><span><span><span>Insert Image...</span></span></span></button><button type="button" class="scalable add-variable plugin" onclick="MagentovariablePlugin.loadChooser('.$baseurl.'evolved/system_variable/wysiwygPlugin/, homepage_element_1_eleven_two_style_image);"><span><span><span>Insert Variable...</span></span></span></button></div><textarea name="homepage_element_1_eleven_two_style_image" title="" id="homepage_element_1_eleven_two_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_1_eleven_two_style_image'].'</textarea><small>Image size must be 1920*480 pixels</small></td>';
      						$str = $str . '<td class="value"><button id="togglehomepage_element_1_eleven_two_style_image" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><div id="buttonshomepage_element_1_eleven_two_style_image" class="buttons-set"><button style="" onclick="MediabrowserUtility.openDialog(\''.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_1_eleven_two_style_image/\')" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button></div><textarea name="homepage_element_1_eleven_two_style_image" title="" id="homepage_element_1_eleven_two_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_1_eleven_two_style_image'].'</textarea><small>Image size must be 522*170 pixels</small></td>';
      						$str = $str . '<script type="text/javascript">';
      						$str = $str . ' openEditorPopup = function(url, name, specs, parent) {';
      						$str = $str . ' if ((typeof popups == "undefined") || popups[name] == undefined || popups[name].closed) {';
      						$str = $str . ' if (typeof popups == "undefined") {';
      						$str = $str . ' popups = new Array();';
      						$str = $str . ' }';
      						$str = $str . ' var opener = (parent != undefined ? parent : window);';
      						$str = $str . 'popups[name] = opener.open(url, name, specs);';
      						$str = $str . ' } else {';
      						$str = $str . ' popups[name].focus();';
      						$str = $str . ' }';
      						$str = $str . 'return popups[name];';
      						$str = $str . '}';
      						$str = $str . 'closeEditorPopup = function(name) {';
      						$str = $str . 'if ((typeof popups != "undefined") &amp;&amp; popups[name] != undefined &amp;&amp; !popups[name].closed) {';
      						$str = $str . 'popups[name].close();';
      						$str = $str . '}';
      						$str = $str . '}';
      						$str = $str . ' </script>';
      						$str = $str . '<script type="text/javascript">';
      						$str = $str . 'if ("undefined" != typeof(Translator)) {';
      						$str = $str . 'Translator.add({"Insert Image...":"Insert Image...","Insert Media...":"Insert Media...","Insert File...":"Insert File..."});';
      						$str = $str . '}wysiwyghomepage_element_1_eleven_two_style_image = new tinyMceWysiwygSetup("homepage_element_1_eleven_two_style_image", {"enabled":true,"hidden":true,"use_container":false,"add_variables":true,"add_widgets":true,"add_images":true,"no_display":false,"translator":{},"encode_directives":true,"directives_url":"'.$baseurl.'evolved/cms_wysiwyg/directive/","popup_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/dialog.css","content_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/content.css","width":"100%","plugins":[{"name":"magentovariable","src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentovariable/editor_plugin.js","options":{"title":"Insert Variable...","url":"'.$baseurl.'evolved/system_variable/wysiwygPlugin/","onclick":{"search":["html_id"],"subject":"MagentovariablePlugin.loadChooser(\''.$baseurl.'evolved/system_variable/wysiwygPlugin/\', \'{{html_id}}\');"},"class":"add-variable plugin"}}],"directives_url_quoted":"'.$baseurl.'evolved/cms_wysiwyg/directive/","files_browser_window_url":"'.$baseurl.'idealAdmin/cms_wysiwyg_images/index/","files_browser_window_width":1000,"files_browser_window_height":600,"widget_plugin_src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentowidget/editor_plugin.js","widget_images_url":"'.$siteurl.'skin/adminhtml/default/default/images/widget/","widget_placeholders":["Thumbs.db","catalog__category_widget_link.gif","catalog__product_widget_link.gif","catalog__product_widget_new.gif","cms__widget_block.gif","cms__widget_page_link.gif","default.gif","reports__product_widget_compared.gif","reports__product_widget_viewed.gif"],"widget_window_url":"'.$baseurl.'evolved/widget/index/","firebug_warning_title":"Warning","firebug_warning_text":"Firebug is known to make the WYSIWYG editor slow unless it is turned off or configured properly.","firebug_warning_anchor":"Hide"});';
      						$str = $str . 'editorFormValidationHandler = wysiwyghomepage_element_1_eleven_two_style_image.onFormValidation.bind(wysiwyghomepage_element_1_eleven_two_style_image);';
      						$str = $str . 'Event.observe("togglehomepage_element_1_eleven_two_style_image", "click", wysiwyghomepage_element_1_eleven_two_style_image.toggle.bind(wysiwyghomepage_element_1_eleven_two_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("formSubmit", editorFormValidationHandler);';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceBeforeSetContent", wysiwyghomepage_element_1_eleven_two_style_image.beforeSetContent.bind(wysiwyghomepage_element_1_eleven_two_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceSaveContent", wysiwyghomepage_element_1_eleven_two_style_image.saveContent.bind(wysiwyghomepage_element_1_eleven_two_style_image));';
      						$str = $str . 'varienGlobalEvents.clearEventHandlers("open_browser_callback");';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("open_browser_callback", wysiwyghomepage_element_1_eleven_two_style_image.openFileBrowser.bind(wysiwyghomepage_element_1_eleven_two_style_image));';
      						$str = $str . '</script>';
      						$str = $str . '</tr>';
      						$str = $str . '</tbody>';
      						$str = $str . '</table>';
      						$str = $str . '</td>';
      						$str = $str . '</tr>';
      						$str = $str . '</tbody>';
      						$str = $str . '</table>';
      					}
      					//else if($selectElement == '50_%_522_by_346_two_boxes_width')
      					{
      						if($selectElement == 'homepage_element_1_50_percentage_522_by_346_two_boxes_width')
      						{
      							$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="homepage_element_1_50_percentage_522_by_346_two_boxes_width" style="display: block">';
      						}
      						else
      						{
      							$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="homepage_element_1_50_percentage_522_by_346_two_boxes_width"  style="display: none">';
      						}
      						//$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="50_percentage_522_by_346_two_boxes_width">';
      						$str = $str . '<tbody>';
      						$str = $str . '<tr>';
      						$str = $str . '<td>';
      						$str = $str . '<table cellspacing="0" class="form-list allpageelement" style="display: table-cell;">';
							$str = $str . '<tbody>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_twelve_one_style_title">Title:</label></td>';  
      						$str = $str . '<td class="value"><input id="homepage_element_1_twelve_one_style_title" value="'.$collectiondata['homepage_element_1_twelve_one_style_title'].'" name="homepage_element_1_twelve_one_style_title"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str .	'<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_twelve_one_style_link">Link:</label></td>';
      						$str = $str . '<td class="value"><input id="homepage_element_1_twelve_one_style_link" value="'.$collectiondata['homepage_element_1_twelve_one_style_link'].'" name="homepage_element_1_twelve_one_style_link"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_twelve_one_style_image">Image:</label></td>';
      						//$str = $str . '<td class="value"><div id="buttonshomepage_element_1_twelve_one_style_image" class="buttons-set"><button type="button" class="scalable show-hide" style="" id="togglehomepage_element_1_twelve_one_style_image"><span><span><span>Show / Hide Editor</span></span></span></button><button type="button" class="scalable add-widget plugin" onclick="widgetTools.openDialog('.$baseurl.'evolved/widget/index/widget_target_id/homepage_element_1_twelve_one_style_image)" style=""><span><span><span>Insert Widget...</span></span></span></button><button type="button" class="scalable add-image plugin" onclick="MediabrowserUtility.openDialog('.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_1_twelve_one_style_image/)" style=""><span><span><span>Insert Image...</span></span></span></button><button type="button" class="scalable add-variable plugin" onclick="MagentovariablePlugin.loadChooser('.$baseurl.'evolved/system_variable/wysiwygPlugin/, homepage_element_1_twelve_one_style_image);"><span><span><span>Insert Variable...</span></span></span></button></div><textarea name="homepage_element_1_twelve_one_style_image" title="" id="homepage_element_1_twelve_one_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_1_twelve_one_style_image'].'</textarea><small>Image size must be 1920*480 pixels</small></td>';
      						$str = $str . '<td class="value"><button id="togglehomepage_element_1_twelve_one_style_image" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><div id="buttonshomepage_element_1_twelve_one_style_image" class="buttons-set"><button style="" onclick="MediabrowserUtility.openDialog(\''.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_1_twelve_one_style_image/\')" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button></div><textarea name="homepage_element_1_twelve_one_style_image" title="" id="homepage_element_1_twelve_one_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_1_twelve_one_style_image'].'</textarea><small>Image size must be 522*346 pixels</small></td>';
      						$str = $str . '<script type="text/javascript">';
      						$str = $str . ' openEditorPopup = function(url, name, specs, parent) {';
      						$str = $str . ' if ((typeof popups == "undefined") || popups[name] == undefined || popups[name].closed) {';
      						$str = $str . ' if (typeof popups == "undefined") {';
      						$str = $str . ' popups = new Array();';
      						$str = $str . ' }';
      						$str = $str . ' var opener = (parent != undefined ? parent : window);';
      						$str = $str . 'popups[name] = opener.open(url, name, specs);';
      						$str = $str . ' } else {';
      						$str = $str . ' popups[name].focus();';
      						$str = $str . ' }';
      						$str = $str . 'return popups[name];';
      						$str = $str . '}';
      						$str = $str . 'closeEditorPopup = function(name) {';
      						$str = $str . 'if ((typeof popups != "undefined") &amp;&amp; popups[name] != undefined &amp;&amp; !popups[name].closed) {';
      						$str = $str . 'popups[name].close();';
      						$str = $str . '}';
      						$str = $str . '}';
      						$str = $str . ' </script>';
      						$str = $str . '<script type="text/javascript">';
      						$str = $str . 'if ("undefined" != typeof(Translator)) {';
      						$str = $str . 'Translator.add({"Insert Image...":"Insert Image...","Insert Media...":"Insert Media...","Insert File...":"Insert File..."});';
      						$str = $str . '}wysiwyghomepage_element_1_twelve_one_style_image = new tinyMceWysiwygSetup("homepage_element_1_twelve_one_style_image", {"enabled":true,"hidden":true,"use_container":false,"add_variables":true,"add_widgets":true,"add_images":true,"no_display":false,"translator":{},"encode_directives":true,"directives_url":"'.$baseurl.'evolved/cms_wysiwyg/directive/","popup_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/dialog.css","content_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/content.css","width":"100%","plugins":[{"name":"magentovariable","src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentovariable/editor_plugin.js","options":{"title":"Insert Variable...","url":"'.$baseurl.'evolved/system_variable/wysiwygPlugin/","onclick":{"search":["html_id"],"subject":"MagentovariablePlugin.loadChooser(\''.$baseurl.'evolved/system_variable/wysiwygPlugin/\', \'{{html_id}}\');"},"class":"add-variable plugin"}}],"directives_url_quoted":"'.$baseurl.'evolved/cms_wysiwyg/directive/","files_browser_window_url":"'.$baseurl.'idealAdmin/cms_wysiwyg_images/index/","files_browser_window_width":1000,"files_browser_window_height":600,"widget_plugin_src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentowidget/editor_plugin.js","widget_images_url":"'.$siteurl.'skin/adminhtml/default/default/images/widget/","widget_placeholders":["Thumbs.db","catalog__category_widget_link.gif","catalog__product_widget_link.gif","catalog__product_widget_new.gif","cms__widget_block.gif","cms__widget_page_link.gif","default.gif","reports__product_widget_compared.gif","reports__product_widget_viewed.gif"],"widget_window_url":"'.$baseurl.'evolved/widget/index/","firebug_warning_title":"Warning","firebug_warning_text":"Firebug is known to make the WYSIWYG editor slow unless it is turned off or configured properly.","firebug_warning_anchor":"Hide"});';
      						$str = $str . 'editorFormValidationHandler = wysiwyghomepage_element_1_twelve_one_style_image.onFormValidation.bind(wysiwyghomepage_element_1_twelve_one_style_image);';
      						$str = $str . 'Event.observe("togglehomepage_element_1_twelve_one_style_image", "click", wysiwyghomepage_element_1_twelve_one_style_image.toggle.bind(wysiwyghomepage_element_1_twelve_one_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("formSubmit", editorFormValidationHandler);';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceBeforeSetContent", wysiwyghomepage_element_1_twelve_one_style_image.beforeSetContent.bind(wysiwyghomepage_element_1_twelve_one_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceSaveContent", wysiwyghomepage_element_1_twelve_one_style_image.saveContent.bind(wysiwyghomepage_element_1_twelve_one_style_image));';
      						$str = $str . 'varienGlobalEvents.clearEventHandlers("open_browser_callback");';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("open_browser_callback", wysiwyghomepage_element_1_twelve_one_style_image.openFileBrowser.bind(wysiwyghomepage_element_1_twelve_one_style_image));';
      						$str = $str . '</script>';
      						$str = $str . '</tr>';
      						$str = $str . '</tbody>';
      						$str = $str . '</table>'; 
      						$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelement" style="display: table-cell;">';
							$str = $str . '<tbody>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_twelve_two_style_title">Title:</label></td>';  
      						$str = $str . '<td class="value"><input id="homepage_element_1_twelve_two_style_title" value="'.$collectiondata['homepage_element_1_twelve_two_style_title'].'" name="homepage_element_1_twelve_two_style_title"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str .	'<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_twelve_two_style_link">Link:</label></td>';
      						$str = $str . '<td class="value"><input id="homepage_element_1_twelve_two_style_link" value="'.$collectiondata['homepage_element_1_twelve_two_style_link'].'" name="homepage_element_1_twelve_two_style_link"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_twelve_two_style_image">Image:</label></td>';
      						//$str = $str . '<td class="value"><div id="buttonshomepage_element_1_twelve_two_style_image" class="buttons-set"><button type="button" class="scalable show-hide" style="" id="togglehomepage_element_1_twelve_two_style_image"><span><span><span>Show / Hide Editor</span></span></span></button><button type="button" class="scalable add-widget plugin" onclick="widgetTools.openDialog('.$baseurl.'evolved/widget/index/widget_target_id/homepage_element_1_twelve_two_style_image)" style=""><span><span><span>Insert Widget...</span></span></span></button><button type="button" class="scalable add-image plugin" onclick="MediabrowserUtility.openDialog('.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_1_twelve_two_style_image/)" style=""><span><span><span>Insert Image...</span></span></span></button><button type="button" class="scalable add-variable plugin" onclick="MagentovariablePlugin.loadChooser('.$baseurl.'evolved/system_variable/wysiwygPlugin/, homepage_element_1_twelve_two_style_image);"><span><span><span>Insert Variable...</span></span></span></button></div><textarea name="homepage_element_1_twelve_two_style_image" title="" id="homepage_element_1_twelve_two_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_1_twelve_two_style_image'].'</textarea><small>Image size must be 1920*480 pixels</small></td>';
      						$str = $str . '<td class="value"><button id="togglehomepage_element_1_twelve_two_style_image" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><div id="buttonshomepage_element_1_twelve_two_style_image" class="buttons-set"><button style="" onclick="MediabrowserUtility.openDialog(\''.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_1_twelve_two_style_image/\')" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button></div><textarea name="homepage_element_1_twelve_two_style_image" title="" id="homepage_element_1_twelve_two_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_1_twelve_two_style_image'].'</textarea><small>Image size must be 522*346 pixels</small></td>';
      						$str = $str . '<script type="text/javascript">';
      						$str = $str . ' openEditorPopup = function(url, name, specs, parent) {';
      						$str = $str . ' if ((typeof popups == "undefined") || popups[name] == undefined || popups[name].closed) {';
      						$str = $str . ' if (typeof popups == "undefined") {';
      						$str = $str . ' popups = new Array();';
      						$str = $str . ' }';
      						$str = $str . ' var opener = (parent != undefined ? parent : window);';
      						$str = $str . 'popups[name] = opener.open(url, name, specs);';
      						$str = $str . ' } else {';
      						$str = $str . ' popups[name].focus();';
      						$str = $str . ' }';
      						$str = $str . 'return popups[name];';
      						$str = $str . '}';
      						$str = $str . 'closeEditorPopup = function(name) {';
      						$str = $str . 'if ((typeof popups != "undefined") &amp;&amp; popups[name] != undefined &amp;&amp; !popups[name].closed) {';
      						$str = $str . 'popups[name].close();';
      						$str = $str . '}';
      						$str = $str . '}';
      						$str = $str . ' </script>';
      						$str = $str . '<script type="text/javascript">';
      						$str = $str . 'if ("undefined" != typeof(Translator)) {';
      						$str = $str . 'Translator.add({"Insert Image...":"Insert Image...","Insert Media...":"Insert Media...","Insert File...":"Insert File..."});';
      						$str = $str . '}wysiwyghomepage_element_1_twelve_two_style_image = new tinyMceWysiwygSetup("homepage_element_1_twelve_two_style_image", {"enabled":true,"hidden":true,"use_container":false,"add_variables":true,"add_widgets":true,"add_images":true,"no_display":false,"translator":{},"encode_directives":true,"directives_url":"'.$baseurl.'evolved/cms_wysiwyg/directive/","popup_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/dialog.css","content_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/content.css","width":"100%","plugins":[{"name":"magentovariable","src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentovariable/editor_plugin.js","options":{"title":"Insert Variable...","url":"'.$baseurl.'evolved/system_variable/wysiwygPlugin/","onclick":{"search":["html_id"],"subject":"MagentovariablePlugin.loadChooser(\''.$baseurl.'evolved/system_variable/wysiwygPlugin/\', \'{{html_id}}\');"},"class":"add-variable plugin"}}],"directives_url_quoted":"'.$baseurl.'evolved/cms_wysiwyg/directive/","files_browser_window_url":"'.$baseurl.'idealAdmin/cms_wysiwyg_images/index/","files_browser_window_width":1000,"files_browser_window_height":600,"widget_plugin_src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentowidget/editor_plugin.js","widget_images_url":"'.$siteurl.'skin/adminhtml/default/default/images/widget/","widget_placeholders":["Thumbs.db","catalog__category_widget_link.gif","catalog__product_widget_link.gif","catalog__product_widget_new.gif","cms__widget_block.gif","cms__widget_page_link.gif","default.gif","reports__product_widget_compared.gif","reports__product_widget_viewed.gif"],"widget_window_url":"'.$baseurl.'evolved/widget/index/","firebug_warning_title":"Warning","firebug_warning_text":"Firebug is known to make the WYSIWYG editor slow unless it is turned off or configured properly.","firebug_warning_anchor":"Hide"});';
      						$str = $str . 'editorFormValidationHandler = wysiwyghomepage_element_1_twelve_two_style_image.onFormValidation.bind(wysiwyghomepage_element_1_twelve_two_style_image);';
      						$str = $str . 'Event.observe("togglehomepage_element_1_twelve_two_style_image", "click", wysiwyghomepage_element_1_twelve_two_style_image.toggle.bind(wysiwyghomepage_element_1_twelve_two_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("formSubmit", editorFormValidationHandler);';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceBeforeSetContent", wysiwyghomepage_element_1_twelve_two_style_image.beforeSetContent.bind(wysiwyghomepage_element_1_twelve_two_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceSaveContent", wysiwyghomepage_element_1_twelve_two_style_image.saveContent.bind(wysiwyghomepage_element_1_twelve_two_style_image));';
      						$str = $str . 'varienGlobalEvents.clearEventHandlers("open_browser_callback");';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("open_browser_callback", wysiwyghomepage_element_1_twelve_two_style_image.openFileBrowser.bind(wysiwyghomepage_element_1_twelve_two_style_image));';
      						$str = $str . '</script>';
      						$str = $str . '</tr>';
      						$str = $str . '</tbody>';
      						$str = $str . '</table>';
      						$str = $str . '</td>';
      						$str = $str . '</tr>';
      						$str = $str . '</tbody>';
      						$str = $str . '</table>';
      					}
	   					//else if($selectElement == '1050_by_170_banner')
      					{
      						if($selectElement == 'homepage_element_1_1050_by_170_banner')
      						{
      							$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="homepage_element_1_1050_by_170_banner" style="display: block">';
      						}
      						else
      						{
      							$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="homepage_element_1_1050_by_170_banner"  style="display: none">';
      						}
      						//$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="1050_by_170_banner">';
      						$str = $str . '<tbody>';
      						$str = $str . '<tr>';
      						$str = $str . '<td>';
      						$str = $str . '<table cellspacing="0" class="form-list allpageelement" style="display: table-cell;">';
							$str = $str . '<tbody>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_thirteen_one_style_title">Title:</label></td>';  
      						$str = $str . '<td class="value"><input id="homepage_element_1_thirteen_one_style_title" value="'.$collectiondata['homepage_element_1_thirteen_one_style_title'].'" name="homepage_element_1_thirteen_one_style_title"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str .	'<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_thirteen_one_style_link">Link:</label></td>';
      						$str = $str . '<td class="value"><input id="homepage_element_1_thirteen_one_style_link" value="'.$collectiondata['homepage_element_1_thirteen_one_style_link'].'" name="homepage_element_1_thirteen_one_style_link"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_thirteen_one_style_image">Image:</label></td>';
      						//$str = $str . '<td class="value"><div id="buttonshomepage_element_1_thirteen_one_style_image" class="buttons-set"><button type="button" class="scalable show-hide" style="" id="togglehomepage_element_1_thirteen_one_style_image"><span><span><span>Show / Hide Editor</span></span></span></button><button type="button" class="scalable add-widget plugin" onclick="widgetTools.openDialog('.$baseurl.'evolved/widget/index/widget_target_id/homepage_element_1_thirteen_one_style_image)" style=""><span><span><span>Insert Widget...</span></span></span></button><button type="button" class="scalable add-image plugin" onclick="MediabrowserUtility.openDialog('.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_1_thirteen_one_style_image/)" style=""><span><span><span>Insert Image...</span></span></span></button><button type="button" class="scalable add-variable plugin" onclick="MagentovariablePlugin.loadChooser('.$baseurl.'evolved/system_variable/wysiwygPlugin/, homepage_element_1_thirteen_one_style_image);"><span><span><span>Insert Variable...</span></span></span></button></div><textarea name="homepage_element_1_thirteen_one_style_image" title="" id="homepage_element_1_thirteen_one_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_1_thirteen_one_style_image'].'</textarea><small>Image size must be 1920*480 pixels</small></td>';
      						$str = $str . '<td class="value"><button id="togglehomepage_element_1_thirteen_one_style_image" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><div id="buttonshomepage_element_1_thirteen_one_style_image" class="buttons-set"><button style="" onclick="MediabrowserUtility.openDialog(\''.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_1_thirteen_one_style_image/\')" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button></div><textarea name="homepage_element_1_thirteen_one_style_image" title="" id="homepage_element_1_thirteen_one_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_1_thirteen_one_style_image'].'</textarea><small>Image size must be 1050*170 pixels</small></td>';
      						$str = $str . '<script type="text/javascript">';
      						$str = $str . ' openEditorPopup = function(url, name, specs, parent) {';
      						$str = $str . ' if ((typeof popups == "undefined") || popups[name] == undefined || popups[name].closed) {';
      						$str = $str . ' if (typeof popups == "undefined") {';
      						$str = $str . ' popups = new Array();';
      						$str = $str . ' }';
      						$str = $str . ' var opener = (parent != undefined ? parent : window);';
      						$str = $str . 'popups[name] = opener.open(url, name, specs);';
      						$str = $str . ' } else {';
      						$str = $str . ' popups[name].focus();';
      						$str = $str . ' }';
      						$str = $str . 'return popups[name];';
      						$str = $str . '}';
      						$str = $str . 'closeEditorPopup = function(name) {';
      						$str = $str . 'if ((typeof popups != "undefined") &amp;&amp; popups[name] != undefined &amp;&amp; !popups[name].closed) {';
      						$str = $str . 'popups[name].close();';
      						$str = $str . '}';
      						$str = $str . '}';
      						$str = $str . ' </script>';
      						$str = $str . '<script type="text/javascript">';
      						$str = $str . 'if ("undefined" != typeof(Translator)) {';
      						$str = $str . 'Translator.add({"Insert Image...":"Insert Image...","Insert Media...":"Insert Media...","Insert File...":"Insert File..."});';
      						$str = $str . '}wysiwyghomepage_element_1_thirteen_one_style_image = new tinyMceWysiwygSetup("homepage_element_1_thirteen_one_style_image", {"enabled":true,"hidden":true,"use_container":false,"add_variables":true,"add_widgets":true,"add_images":true,"no_display":false,"translator":{},"encode_directives":true,"directives_url":"'.$baseurl.'evolved/cms_wysiwyg/directive/","popup_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/dialog.css","content_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/content.css","width":"100%","plugins":[{"name":"magentovariable","src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentovariable/editor_plugin.js","options":{"title":"Insert Variable...","url":"'.$baseurl.'evolved/system_variable/wysiwygPlugin/","onclick":{"search":["html_id"],"subject":"MagentovariablePlugin.loadChooser(\''.$baseurl.'evolved/system_variable/wysiwygPlugin/\', \'{{html_id}}\');"},"class":"add-variable plugin"}}],"directives_url_quoted":"'.$baseurl.'evolved/cms_wysiwyg/directive/","files_browser_window_url":"'.$baseurl.'idealAdmin/cms_wysiwyg_images/index/","files_browser_window_width":1000,"files_browser_window_height":600,"widget_plugin_src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentowidget/editor_plugin.js","widget_images_url":"'.$siteurl.'skin/adminhtml/default/default/images/widget/","widget_placeholders":["Thumbs.db","catalog__category_widget_link.gif","catalog__product_widget_link.gif","catalog__product_widget_new.gif","cms__widget_block.gif","cms__widget_page_link.gif","default.gif","reports__product_widget_compared.gif","reports__product_widget_viewed.gif"],"widget_window_url":"'.$baseurl.'evolved/widget/index/","firebug_warning_title":"Warning","firebug_warning_text":"Firebug is known to make the WYSIWYG editor slow unless it is turned off or configured properly.","firebug_warning_anchor":"Hide"});';
      						$str = $str . 'editorFormValidationHandler = wysiwyghomepage_element_1_thirteen_one_style_image.onFormValidation.bind(wysiwyghomepage_element_1_thirteen_one_style_image);';
      						$str = $str . 'Event.observe("togglehomepage_element_1_thirteen_one_style_image", "click", wysiwyghomepage_element_1_thirteen_one_style_image.toggle.bind(wysiwyghomepage_element_1_thirteen_one_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("formSubmit", editorFormValidationHandler);';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceBeforeSetContent", wysiwyghomepage_element_1_thirteen_one_style_image.beforeSetContent.bind(wysiwyghomepage_element_1_thirteen_one_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceSaveContent", wysiwyghomepage_element_1_thirteen_one_style_image.saveContent.bind(wysiwyghomepage_element_1_thirteen_one_style_image));';
      						$str = $str . 'varienGlobalEvents.clearEventHandlers("open_browser_callback");';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("open_browser_callback", wysiwyghomepage_element_1_thirteen_one_style_image.openFileBrowser.bind(wysiwyghomepage_element_1_thirteen_one_style_image));';
      						$str = $str . '</script>';
      						$str = $str . '</tr>';
      						$str = $str . '</tbody>';
      						$str = $str . '</table>'; 					
      						$str = $str . '</td>';
      						$str = $str . '</tr>';
      						$str = $str . '</tbody>';
      						$str = $str . '</table>';
      					}
      			   	//	else if($selectElement == '1050_by_346_banner')
      					{
      						if($selectElement == 'homepage_element_1_1050_by_346_banner')
      						{
      							$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="homepage_element_1_1050_by_346_banner" style="display: block">';
      						}
      						else
      						{
      							$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="homepage_element_1_1050_by_346_banner"  style="display: none">';
      						}
      						//$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="1050_by_346_banner">';
      						$str = $str . '<tbody>';
      						$str = $str . '<tr>';
      						$str = $str . '<td>';
      						$str = $str . '<table cellspacing="0" class="form-list allpageelement" style="display: table-cell;">';
							$str = $str . '<tbody>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_fourteen_one_style_title">Title:</label></td>';  
      						$str = $str . '<td class="value"><input id="homepage_element_1_fourteen_one_style_title" value="'.$collectiondata['homepage_element_1_fourteen_one_style_title'].'" name="homepage_element_1_fourteen_one_style_title"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str .	'<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_fourteen_one_style_link">Link:</label></td>';
      						$str = $str . '<td class="value"><input id="homepage_element_1_fourteen_one_style_link" value="'.$collectiondata['homepage_element_1_fourteen_one_style_link'].'" name="homepage_element_1_fourteen_one_style_link"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_fourteen_one_style_image">Image:</label></td>';
      						//$str = $str . '<td class="value"><div id="buttonshomepage_element_1_fourteen_one_style_image" class="buttons-set"><button type="button" class="scalable show-hide" style="" id="togglehomepage_element_1_fourteen_one_style_image"><span><span><span>Show / Hide Editor</span></span></span></button><button type="button" class="scalable add-widget plugin" onclick="widgetTools.openDialog('.$baseurl.'evolved/widget/index/widget_target_id/homepage_element_1_fourteen_one_style_image)" style=""><span><span><span>Insert Widget...</span></span></span></button><button type="button" class="scalable add-image plugin" onclick="MediabrowserUtility.openDialog('.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_1_fourteen_one_style_image/)" style=""><span><span><span>Insert Image...</span></span></span></button><button type="button" class="scalable add-variable plugin" onclick="MagentovariablePlugin.loadChooser('.$baseurl.'evolved/system_variable/wysiwygPlugin/, homepage_element_1_fourteen_one_style_image);"><span><span><span>Insert Variable...</span></span></span></button></div><textarea name="homepage_element_1_fourteen_one_style_image" title="" id="homepage_element_1_fourteen_one_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_1_fourteen_one_style_image'].'</textarea><small>Image size must be 1920*480 pixels</small></td>';
      						$str = $str . '<td class="value"><button id="togglehomepage_element_1_fourteen_one_style_image" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><div id="buttonshomepage_element_1_fourteen_one_style_image" class="buttons-set"><button style="" onclick="MediabrowserUtility.openDialog(\''.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_1_fourteen_one_style_image/\')" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button></div><textarea name="homepage_element_1_fourteen_one_style_image" title="" id="homepage_element_1_fourteen_one_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_1_fourteen_one_style_image'].'</textarea><small>Image size must be 1050*346 pixels</small></td>';
      						$str = $str . '<script type="text/javascript">';
      						$str = $str . ' openEditorPopup = function(url, name, specs, parent) {';
      						$str = $str . ' if ((typeof popups == "undefined") || popups[name] == undefined || popups[name].closed) {';
      						$str = $str . ' if (typeof popups == "undefined") {';
      						$str = $str . ' popups = new Array();';
      						$str = $str . ' }';
      						$str = $str . ' var opener = (parent != undefined ? parent : window);';
      						$str = $str . 'popups[name] = opener.open(url, name, specs);';
      						$str = $str . ' } else {';
      						$str = $str . ' popups[name].focus();';
      						$str = $str . ' }';
      						$str = $str . 'return popups[name];';
      						$str = $str . '}';
      						$str = $str . 'closeEditorPopup = function(name) {';
      						$str = $str . 'if ((typeof popups != "undefined") &amp;&amp; popups[name] != undefined &amp;&amp; !popups[name].closed) {';
      						$str = $str . 'popups[name].close();';
      						$str = $str . '}';
      						$str = $str . '}';
      						$str = $str . ' </script>';
      						$str = $str . '<script type="text/javascript">';
      						$str = $str . 'if ("undefined" != typeof(Translator)) {';
      						$str = $str . 'Translator.add({"Insert Image...":"Insert Image...","Insert Media...":"Insert Media...","Insert File...":"Insert File..."});';
      						$str = $str . '}wysiwyghomepage_element_1_fourteen_one_style_image = new tinyMceWysiwygSetup("homepage_element_1_fourteen_one_style_image", {"enabled":true,"hidden":true,"use_container":false,"add_variables":true,"add_widgets":true,"add_images":true,"no_display":false,"translator":{},"encode_directives":true,"directives_url":"'.$baseurl.'evolved/cms_wysiwyg/directive/","popup_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/dialog.css","content_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/content.css","width":"100%","plugins":[{"name":"magentovariable","src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentovariable/editor_plugin.js","options":{"title":"Insert Variable...","url":"'.$baseurl.'evolved/system_variable/wysiwygPlugin/","onclick":{"search":["html_id"],"subject":"MagentovariablePlugin.loadChooser(\''.$baseurl.'evolved/system_variable/wysiwygPlugin/\', \'{{html_id}}\');"},"class":"add-variable plugin"}}],"directives_url_quoted":"'.$baseurl.'evolved/cms_wysiwyg/directive/","files_browser_window_url":"'.$baseurl.'idealAdmin/cms_wysiwyg_images/index/","files_browser_window_width":1000,"files_browser_window_height":600,"widget_plugin_src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentowidget/editor_plugin.js","widget_images_url":"'.$siteurl.'skin/adminhtml/default/default/images/widget/","widget_placeholders":["Thumbs.db","catalog__category_widget_link.gif","catalog__product_widget_link.gif","catalog__product_widget_new.gif","cms__widget_block.gif","cms__widget_page_link.gif","default.gif","reports__product_widget_compared.gif","reports__product_widget_viewed.gif"],"widget_window_url":"'.$baseurl.'evolved/widget/index/","firebug_warning_title":"Warning","firebug_warning_text":"Firebug is known to make the WYSIWYG editor slow unless it is turned off or configured properly.","firebug_warning_anchor":"Hide"});';
      						$str = $str . 'editorFormValidationHandler = wysiwyghomepage_element_1_fourteen_one_style_image.onFormValidation.bind(wysiwyghomepage_element_1_fourteen_one_style_image);';
      						$str = $str . 'Event.observe("togglehomepage_element_1_fourteen_one_style_image", "click", wysiwyghomepage_element_1_fourteen_one_style_image.toggle.bind(wysiwyghomepage_element_1_fourteen_one_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("formSubmit", editorFormValidationHandler);';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceBeforeSetContent", wysiwyghomepage_element_1_fourteen_one_style_image.beforeSetContent.bind(wysiwyghomepage_element_1_fourteen_one_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceSaveContent", wysiwyghomepage_element_1_fourteen_one_style_image.saveContent.bind(wysiwyghomepage_element_1_fourteen_one_style_image));';
      						$str = $str . 'varienGlobalEvents.clearEventHandlers("open_browser_callback");';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("open_browser_callback", wysiwyghomepage_element_1_fourteen_one_style_image.openFileBrowser.bind(wysiwyghomepage_element_1_fourteen_one_style_image));';
      						$str = $str . '</script>';
      						$str = $str . '</tr>';
      						$str = $str . '</tbody>';
      						$str = $str . '</table>'; 
      						$str = $str . '</td>';
      						$str = $str . '</tr>';
      						$str = $str . '</tbody>';
      						$str = $str . '</table>';
      					}
			      		//else if($selectElement == '33_%_left_50_%_right_boxes_right_updown_width')
      					{
      						if($selectElement == 'homepage_element_1_33_percentage_left_50_percentage_right_boxes_right_updown_width')
      						{
      							$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="homepage_element_1_33_percentage_left_50_percentage_right_boxes_right_updown_width" style="display: block">';
      						}
      						else
      						{
      							$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="homepage_element_1_33_percentage_left_50_percentage_right_boxes_right_updown_width"  style="display: none">';
      						}
      						//$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="33_percentage_left_50_percentage_right_boxes_right_updown_width">';
      						$str = $str . '<tbody>';
      						$str = $str . '<tr>';
      						$str = $str . '<td>';
      						$str = $str . '<table cellspacing="0" class="form-list allpageelement" style="display: table-cell;">';
							$str = $str . '<tbody>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_fifthteen_one_style_title">Title:</label></td>';  
      						$str = $str . '<td class="value"><input id="homepage_element_1_fifthteen_one_style_title" value="'.$collectiondata['homepage_element_1_fifthteen_one_style_title'].'" name="homepage_element_1_fifthteen_one_style_title"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str .	'<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_fifthteen_one_style_link">Link:</label></td>';
      						$str = $str . '<td class="value"><input id="homepage_element_1_fifthteen_one_style_link" value="'.$collectiondata['homepage_element_1_fifthteen_one_style_link'].'" name="homepage_element_1_fifthteen_one_style_link"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_fifthteen_one_style_image">Image:</label></td>';
      						//$str = $str . '<td class="value"><div id="buttonshomepage_element_1_fifthteen_one_style_image" class="buttons-set"><button type="button" class="scalable show-hide" style="" id="togglehomepage_element_1_fifthteen_one_style_image"><span><span><span>Show / Hide Editor</span></span></span></button><button type="button" class="scalable add-widget plugin" onclick="widgetTools.openDialog('.$baseurl.'evolved/widget/index/widget_target_id/homepage_element_1_fifthteen_one_style_image)" style=""><span><span><span>Insert Widget...</span></span></span></button><button type="button" class="scalable add-image plugin" onclick="MediabrowserUtility.openDialog('.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_1_fifthteen_one_style_image/)" style=""><span><span><span>Insert Image...</span></span></span></button><button type="button" class="scalable add-variable plugin" onclick="MagentovariablePlugin.loadChooser('.$baseurl.'evolved/system_variable/wysiwygPlugin/, homepage_element_1_fifthteen_one_style_image);"><span><span><span>Insert Variable...</span></span></span></button></div><textarea name="homepage_element_1_fifthteen_one_style_image" title="" id="homepage_element_1_fifthteen_one_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_1_fifthteen_one_style_image'].'</textarea><small>Image size must be 1920*480 pixels</small></td>';
      						$str = $str . '<td class="value"><button id="togglehomepage_element_1_fifthteen_one_style_image" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><div id="buttonshomepage_element_1_fifthteen_one_style_image" class="buttons-set"><button style="" onclick="MediabrowserUtility.openDialog(\''.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_1_fifthteen_one_style_image/\')" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button></div><textarea name="homepage_element_1_fifthteen_one_style_image" title="" id="homepage_element_1_fifthteen_one_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_1_fifthteen_one_style_image'].'</textarea><small>Image size must be 522*346 pixels</small></td>';
      						$str = $str . '<script type="text/javascript">';
      						$str = $str . ' openEditorPopup = function(url, name, specs, parent) {';
      						$str = $str . ' if ((typeof popups == "undefined") || popups[name] == undefined || popups[name].closed) {';
      						$str = $str . ' if (typeof popups == "undefined") {';
      						$str = $str . ' popups = new Array();';
      						$str = $str . ' }';
      						$str = $str . ' var opener = (parent != undefined ? parent : window);';
      						$str = $str . 'popups[name] = opener.open(url, name, specs);';
      						$str = $str . ' } else {';
      						$str = $str . ' popups[name].focus();';
      						$str = $str . ' }';
      						$str = $str . 'return popups[name];';
      						$str = $str . '}';
      						$str = $str . 'closeEditorPopup = function(name) {';
      						$str = $str . 'if ((typeof popups != "undefined") &amp;&amp; popups[name] != undefined &amp;&amp; !popups[name].closed) {';
      						$str = $str . 'popups[name].close();';
      						$str = $str . '}';
      						$str = $str . '}';
      						$str = $str . ' </script>';
      						$str = $str . '<script type="text/javascript">';
      						$str = $str . 'if ("undefined" != typeof(Translator)) {';
      						$str = $str . 'Translator.add({"Insert Image...":"Insert Image...","Insert Media...":"Insert Media...","Insert File...":"Insert File..."});';
      						$str = $str . '}wysiwyghomepage_element_1_fifthteen_one_style_image = new tinyMceWysiwygSetup("homepage_element_1_fifthteen_one_style_image", {"enabled":true,"hidden":true,"use_container":false,"add_variables":true,"add_widgets":true,"add_images":true,"no_display":false,"translator":{},"encode_directives":true,"directives_url":"'.$baseurl.'evolved/cms_wysiwyg/directive/","popup_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/dialog.css","content_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/content.css","width":"100%","plugins":[{"name":"magentovariable","src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentovariable/editor_plugin.js","options":{"title":"Insert Variable...","url":"'.$baseurl.'evolved/system_variable/wysiwygPlugin/","onclick":{"search":["html_id"],"subject":"MagentovariablePlugin.loadChooser(\''.$baseurl.'evolved/system_variable/wysiwygPlugin/\', \'{{html_id}}\');"},"class":"add-variable plugin"}}],"directives_url_quoted":"'.$baseurl.'evolved/cms_wysiwyg/directive/","files_browser_window_url":"'.$baseurl.'idealAdmin/cms_wysiwyg_images/index/","files_browser_window_width":1000,"files_browser_window_height":600,"widget_plugin_src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentowidget/editor_plugin.js","widget_images_url":"'.$siteurl.'skin/adminhtml/default/default/images/widget/","widget_placeholders":["Thumbs.db","catalog__category_widget_link.gif","catalog__product_widget_link.gif","catalog__product_widget_new.gif","cms__widget_block.gif","cms__widget_page_link.gif","default.gif","reports__product_widget_compared.gif","reports__product_widget_viewed.gif"],"widget_window_url":"'.$baseurl.'evolved/widget/index/","firebug_warning_title":"Warning","firebug_warning_text":"Firebug is known to make the WYSIWYG editor slow unless it is turned off or configured properly.","firebug_warning_anchor":"Hide"});';
      						$str = $str . 'editorFormValidationHandler = wysiwyghomepage_element_1_fifthteen_one_style_image.onFormValidation.bind(wysiwyghomepage_element_1_fifthteen_one_style_image);';
      						$str = $str . 'Event.observe("togglehomepage_element_1_fifthteen_one_style_image", "click", wysiwyghomepage_element_1_fifthteen_one_style_image.toggle.bind(wysiwyghomepage_element_1_fifthteen_one_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("formSubmit", editorFormValidationHandler);';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceBeforeSetContent", wysiwyghomepage_element_1_fifthteen_one_style_image.beforeSetContent.bind(wysiwyghomepage_element_1_fifthteen_one_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceSaveContent", wysiwyghomepage_element_1_fifthteen_one_style_image.saveContent.bind(wysiwyghomepage_element_1_fifthteen_one_style_image));';
      						$str = $str . 'varienGlobalEvents.clearEventHandlers("open_browser_callback");';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("open_browser_callback", wysiwyghomepage_element_1_fifthteen_one_style_image.openFileBrowser.bind(wysiwyghomepage_element_1_fifthteen_one_style_image));';
      						$str = $str . '</script>';
      						$str = $str . '</tr>';
      						$str = $str . '</tbody>';
      						$str = $str . '</table>'; 
      						$str = $str . '<table cellspacing="0" class="form-list allpageelement" style="display: table-cell;">';
							$str = $str . '<tbody>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_fifthteen_two_up_style_title">Title:</label></td>';  
      						$str = $str . '<td class="value"><input id="homepage_element_1_fifthteen_two_up_style_title" value="'.$collectiondata['homepage_element_1_fifthteen_two_up_style_title'].'" name="homepage_element_1_fifthteen_two_up_style_title"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str .	'<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_fifthteen_two_up_style_link">Link:</label></td>';
      						$str = $str . '<td class="value"><input id="homepage_element_1_fifthteen_two_up_style_link" value="'.$collectiondata['homepage_element_1_fifthteen_two_up_style_link'].'" name="homepage_element_1_fifthteen_two_up_style_link"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_fifthteen_two_up_style_image">Image:</label></td>';
      						//$str = $str . '<td class="value"><div id="buttonshomepage_element_1_fifthteen_two_up_style_image" class="buttons-set"><button type="button" class="scalable show-hide" style="" id="togglehomepage_element_1_fifthteen_two_up_style_image"><span><span><span>Show / Hide Editor</span></span></span></button><button type="button" class="scalable add-widget plugin" onclick="widgetTools.openDialog('.$baseurl.'evolved/widget/index/widget_target_id/homepage_element_1_fifthteen_two_up_style_image)" style=""><span><span><span>Insert Widget...</span></span></span></button><button type="button" class="scalable add-image plugin" onclick="MediabrowserUtility.openDialog('.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_1_fifthteen_two_up_style_image/)" style=""><span><span><span>Insert Image...</span></span></span></button><button type="button" class="scalable add-variable plugin" onclick="MagentovariablePlugin.loadChooser('.$baseurl.'evolved/system_variable/wysiwygPlugin/, homepage_element_1_fifthteen_two_up_style_image);"><span><span><span>Insert Variable...</span></span></span></button></div><textarea name="homepage_element_1_fifthteen_two_up_style_image" title="" id="homepage_element_1_fifthteen_two_up_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_1_fifthteen_two_up_style_image'].'</textarea><small>Image size must be 1920*480 pixels</small></td>';
      						$str = $str . '<td class="value"><button id="togglehomepage_element_1_fifthteen_two_up_style_image" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><div id="buttonshomepage_element_1_fifthteen_two_up_style_image" class="buttons-set"><button style="" onclick="MediabrowserUtility.openDialog(\''.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_1_fifthteen_two_up_style_image/\')" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button></div><textarea name="homepage_element_1_fifthteen_two_up_style_image" title="" id="homepage_element_1_fifthteen_two_up_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_1_fifthteen_two_up_style_image'].'</textarea><small>Image size must be 522*170 pixels</small></td>';
      						$str = $str . '<script type="text/javascript">';
      						$str = $str . ' openEditorPopup = function(url, name, specs, parent) {';
      						$str = $str . ' if ((typeof popups == "undefined") || popups[name] == undefined || popups[name].closed) {';
      						$str = $str . ' if (typeof popups == "undefined") {';
      						$str = $str . ' popups = new Array();';
      						$str = $str . ' }';
      						$str = $str . ' var opener = (parent != undefined ? parent : window);';
      						$str = $str . 'popups[name] = opener.open(url, name, specs);';
      						$str = $str . ' } else {';
      						$str = $str . ' popups[name].focus();';
      						$str = $str . ' }';
      						$str = $str . 'return popups[name];';
      						$str = $str . '}';
      						$str = $str . 'closeEditorPopup = function(name) {';
      						$str = $str . 'if ((typeof popups != "undefined") &amp;&amp; popups[name] != undefined &amp;&amp; !popups[name].closed) {';
      						$str = $str . 'popups[name].close();';
      						$str = $str . '}';
      						$str = $str . '}';
      						$str = $str . ' </script>';
      						$str = $str . '<script type="text/javascript">';
      						$str = $str . 'if ("undefined" != typeof(Translator)) {';
      						$str = $str . 'Translator.add({"Insert Image...":"Insert Image...","Insert Media...":"Insert Media...","Insert File...":"Insert File..."});';
      						$str = $str . '}wysiwyghomepage_element_1_fifthteen_two_up_style_image = new tinyMceWysiwygSetup("homepage_element_1_fifthteen_two_up_style_image", {"enabled":true,"hidden":true,"use_container":false,"add_variables":true,"add_widgets":true,"add_images":true,"no_display":false,"translator":{},"encode_directives":true,"directives_url":"'.$baseurl.'evolved/cms_wysiwyg/directive/","popup_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/dialog.css","content_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/content.css","width":"100%","plugins":[{"name":"magentovariable","src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentovariable/editor_plugin.js","options":{"title":"Insert Variable...","url":"'.$baseurl.'evolved/system_variable/wysiwygPlugin/","onclick":{"search":["html_id"],"subject":"MagentovariablePlugin.loadChooser(\''.$baseurl.'evolved/system_variable/wysiwygPlugin/\', \'{{html_id}}\');"},"class":"add-variable plugin"}}],"directives_url_quoted":"'.$baseurl.'evolved/cms_wysiwyg/directive/","files_browser_window_url":"'.$baseurl.'idealAdmin/cms_wysiwyg_images/index/","files_browser_window_width":1000,"files_browser_window_height":600,"widget_plugin_src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentowidget/editor_plugin.js","widget_images_url":"'.$siteurl.'skin/adminhtml/default/default/images/widget/","widget_placeholders":["Thumbs.db","catalog__category_widget_link.gif","catalog__product_widget_link.gif","catalog__product_widget_new.gif","cms__widget_block.gif","cms__widget_page_link.gif","default.gif","reports__product_widget_compared.gif","reports__product_widget_viewed.gif"],"widget_window_url":"'.$baseurl.'evolved/widget/index/","firebug_warning_title":"Warning","firebug_warning_text":"Firebug is known to make the WYSIWYG editor slow unless it is turned off or configured properly.","firebug_warning_anchor":"Hide"});';
      						$str = $str . 'editorFormValidationHandler = wysiwyghomepage_element_1_fifthteen_two_up_style_image.onFormValidation.bind(wysiwyghomepage_element_1_fifthteen_two_up_style_image);';
      						$str = $str . 'Event.observe("togglehomepage_element_1_fifthteen_two_up_style_image", "click", wysiwyghomepage_element_1_fifthteen_two_up_style_image.toggle.bind(wysiwyghomepage_element_1_fifthteen_two_up_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("formSubmit", editorFormValidationHandler);';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceBeforeSetContent", wysiwyghomepage_element_1_fifthteen_two_up_style_image.beforeSetContent.bind(wysiwyghomepage_element_1_fifthteen_two_up_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceSaveContent", wysiwyghomepage_element_1_fifthteen_two_up_style_image.saveContent.bind(wysiwyghomepage_element_1_fifthteen_two_up_style_image));';
      						$str = $str . 'varienGlobalEvents.clearEventHandlers("open_browser_callback");';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("open_browser_callback", wysiwyghomepage_element_1_fifthteen_two_up_style_image.openFileBrowser.bind(wysiwyghomepage_element_1_fifthteen_two_up_style_image));';
      						$str = $str . '</script>';
      						$str = $str . '</tr>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_fifthteen_two_down_style_title">Title:</label></td>';  
      						$str = $str . '<td class="value"><input id="homepage_element_1_fifthteen_two_down_style_title" value="'.$collectiondata['homepage_element_1_fifthteen_two_down_style_title'].'" name="homepage_element_1_fifthteen_two_down_style_title"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str .	'<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_fifthteen_two_down_style_link">Link:</label></td>';
      						$str = $str . '<td class="value"><input id="homepage_element_1_fifthteen_two_down_style_link" value="'.$collectiondata['homepage_element_1_fifthteen_two_down_style_link'].'" name="homepage_element_1_fifthteen_two_down_style_link"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_fifthteen_two_down_style_image">Image:</label></td>';
      						//$str = $str . '<td class="value"><div id="buttonshomepage_element_1_fifthteen_two_down_style_image" class="buttons-set"><button type="button" class="scalable show-hide" style="" id="togglehomepage_element_1_fifthteen_two_down_style_image"><span><span><span>Show / Hide Editor</span></span></span></button><button type="button" class="scalable add-widget plugin" onclick="widgetTools.openDialog('.$baseurl.'evolved/widget/index/widget_target_id/homepage_element_1_fifthteen_two_down_style_image)" style=""><span><span><span>Insert Widget...</span></span></span></button><button type="button" class="scalable add-image plugin" onclick="MediabrowserUtility.openDialog('.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_1_fifthteen_two_down_style_image/)" style=""><span><span><span>Insert Image...</span></span></span></button><button type="button" class="scalable add-variable plugin" onclick="MagentovariablePlugin.loadChooser('.$baseurl.'evolved/system_variable/wysiwygPlugin/, homepage_element_1_fifthteen_two_down_style_image);"><span><span><span>Insert Variable...</span></span></span></button></div><textarea name="homepage_element_1_fifthteen_two_down_style_image" title="" id="homepage_element_1_fifthteen_two_down_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_1_fifthteen_two_down_style_image'].'</textarea><small>Image size must be 1920*480 pixels</small></td>';
      						$str = $str . '<td class="value"><button id="togglehomepage_element_1_fifthteen_two_down_style_image" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><div id="buttonshomepage_element_1_fifthteen_two_down_style_image" class="buttons-set"><button style="" onclick="MediabrowserUtility.openDialog(\''.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_1_fifthteen_two_down_style_image/\')" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button></div><textarea name="homepage_element_1_fifthteen_two_down_style_image" title="" id="homepage_element_1_fifthteen_two_down_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_1_fifthteen_two_down_style_image'].'</textarea><small>Image size must be 522*170 pixels</small></td>';
      						$str = $str . '<script type="text/javascript">';
      						$str = $str . ' openEditorPopup = function(url, name, specs, parent) {';
      						$str = $str . ' if ((typeof popups == "undefined") || popups[name] == undefined || popups[name].closed) {';
      						$str = $str . ' if (typeof popups == "undefined") {';
      						$str = $str . ' popups = new Array();';
      						$str = $str . ' }';
      						$str = $str . ' var opener = (parent != undefined ? parent : window);';
      						$str = $str . 'popups[name] = opener.open(url, name, specs);';
      						$str = $str . ' } else {';
      						$str = $str . ' popups[name].focus();';
      						$str = $str . ' }';
      						$str = $str . 'return popups[name];';
      						$str = $str . '}';
      						$str = $str . 'closeEditorPopup = function(name) {';
      						$str = $str . 'if ((typeof popups != "undefined") &amp;&amp; popups[name] != undefined &amp;&amp; !popups[name].closed) {';
      						$str = $str . 'popups[name].close();';
      						$str = $str . '}';
      						$str = $str . '}';
      						$str = $str . ' </script>';
      						$str = $str . '<script type="text/javascript">';
      						$str = $str . 'if ("undefined" != typeof(Translator)) {';
      						$str = $str . 'Translator.add({"Insert Image...":"Insert Image...","Insert Media...":"Insert Media...","Insert File...":"Insert File..."});';
      						$str = $str . '}wysiwyghomepage_element_1_fifthteen_two_down_style_image = new tinyMceWysiwygSetup("homepage_element_1_fifthteen_two_down_style_image", {"enabled":true,"hidden":true,"use_container":false,"add_variables":true,"add_widgets":true,"add_images":true,"no_display":false,"translator":{},"encode_directives":true,"directives_url":"'.$baseurl.'evolved/cms_wysiwyg/directive/","popup_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/dialog.css","content_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/content.css","width":"100%","plugins":[{"name":"magentovariable","src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentovariable/editor_plugin.js","options":{"title":"Insert Variable...","url":"'.$baseurl.'evolved/system_variable/wysiwygPlugin/","onclick":{"search":["html_id"],"subject":"MagentovariablePlugin.loadChooser(\''.$baseurl.'evolved/system_variable/wysiwygPlugin/\', \'{{html_id}}\');"},"class":"add-variable plugin"}}],"directives_url_quoted":"'.$baseurl.'evolved/cms_wysiwyg/directive/","files_browser_window_url":"'.$baseurl.'idealAdmin/cms_wysiwyg_images/index/","files_browser_window_width":1000,"files_browser_window_height":600,"widget_plugin_src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentowidget/editor_plugin.js","widget_images_url":"'.$siteurl.'skin/adminhtml/default/default/images/widget/","widget_placeholders":["Thumbs.db","catalog__category_widget_link.gif","catalog__product_widget_link.gif","catalog__product_widget_new.gif","cms__widget_block.gif","cms__widget_page_link.gif","default.gif","reports__product_widget_compared.gif","reports__product_widget_viewed.gif"],"widget_window_url":"'.$baseurl.'evolved/widget/index/","firebug_warning_title":"Warning","firebug_warning_text":"Firebug is known to make the WYSIWYG editor slow unless it is turned off or configured properly.","firebug_warning_anchor":"Hide"});';
      						$str = $str . 'editorFormValidationHandler = wysiwyghomepage_element_1_fifthteen_two_down_style_image.onFormValidation.bind(wysiwyghomepage_element_1_fifthteen_two_down_style_image);';
      						$str = $str . 'Event.observe("togglehomepage_element_1_fifthteen_two_down_style_image", "click", wysiwyghomepage_element_1_fifthteen_two_down_style_image.toggle.bind(wysiwyghomepage_element_1_fifthteen_two_down_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("formSubmit", editorFormValidationHandler);';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceBeforeSetContent", wysiwyghomepage_element_1_fifthteen_two_down_style_image.beforeSetContent.bind(wysiwyghomepage_element_1_fifthteen_two_down_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceSaveContent", wysiwyghomepage_element_1_fifthteen_two_down_style_image.saveContent.bind(wysiwyghomepage_element_1_fifthteen_two_down_style_image));';
      						$str = $str . 'varienGlobalEvents.clearEventHandlers("open_browser_callback");';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("open_browser_callback", wysiwyghomepage_element_1_fifthteen_two_down_style_image.openFileBrowser.bind(wysiwyghomepage_element_1_fifthteen_two_down_style_image));';
      						$str = $str . '</script>';
      						$str = $str . '</tr>';
      						$str = $str . '</tbody>';
      						$str = $str . '</table>'; 
      						$str = $str . '</td>';
      						$str = $str . '</tr>';
      						$str = $str . '</tbody>';
      						$str = $str . '</table>';
      					}
						 //else if($selectElement == '33_%_left_50_%_right_boxes_right_updown_width')
						{
							if($selectElement == 'homepage_element_1_25_percentage_258_by_170_four_boxes_width')
      						{
      							$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="homepage_element_1_25_percentage_258_by_170_four_boxes_width" style="display: block">';
      						}
      						else
      						{
      							$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="homepage_element_1_25_percentage_258_by_170_four_boxes_width"  style="display: none">';
      						}
      						//$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="25_percentage_480_by_400_four_boxes_full_width">';
      						$str = $str . '<tbody>';
      						$str = $str . '<tr>';
      						$str = $str . '<td>';
      						$str = $str . '<table cellspacing="0" class="form-list allpageelement" style="display: table-cell;">';
							$str = $str . '<tbody>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_sixteen_one_style_title">Title:</label></td>';  
      						$str = $str . '<td class="value"><input id="homepage_element_1_sixteen_one_style_title" value="'.$collectiondata['homepage_element_1_sixteen_one_style_title'].'" name="homepage_element_1_sixteen_one_style_title"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_sixteen_one_style_link">Link:</label></td>';
      						$str = $str . '<td class="value"><input id="homepage_element_1_sixteen_one_style_link" value="'.$collectiondata['homepage_element_1_sixteen_one_style_link'].'" name="homepage_element_1_sixteen_one_style_link"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_sixteen_one_style_image">Image:</label></td>';
      						//$str = $str . '<td class="value"><div id="buttonshomepage_element_1_sixteen_one_style_image" class="buttons-set"><button type="button" class="scalable show-hide" style="" id="togglehomepage_element_1_sixteen_one_style_image"><span><span><span>Show / Hide Editor</span></span></span></button><button type="button" class="scalable add-widget plugin" onclick="widgetTools.openDialog('.$baseurl.'evolved/widget/index/widget_target_id/homepage_element_1_sixteen_one_style_image)" style=""><span><span><span>Insert Widget...</span></span></span></button><button type="button" class="scalable add-image plugin" onclick="MediabrowserUtility.openDialog('.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_1_sixteen_one_style_image/)" style=""><span><span><span>Insert Image...</span></span></span></button><button type="button" class="scalable add-variable plugin" onclick="MagentovariablePlugin.loadChooser('.$baseurl.'evolved/system_variable/wysiwygPlugin/, homepage_element_1_sixteen_one_style_image);"><span><span><span>Insert Variable...</span></span></span></button></div><textarea name="homepage_element_1_sixteen_one_style_image" title="" id="homepage_element_1_sixteen_one_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_1_sixteen_one_style_image'].'</textarea><small>Image size must be 1920*480 pixels</small></td>';
      						$str = $str . '<td class="value"><button id="togglehomepage_element_1_sixteen_one_style_image" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><div id="buttonshomepage_element_1_sixteen_one_style_image" class="buttons-set"><button style="" onclick="MediabrowserUtility.openDialog(\''.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_1_sixteen_one_style_image/\')" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button></div><textarea name="homepage_element_1_sixteen_one_style_image" title="" id="homepage_element_1_sixteen_one_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_1_sixteen_one_style_image'].'</textarea><small>Image size must be 258*170 pixels</small></td>';
      						$str = $str . '<script type="text/javascript">';
      						$str = $str . ' openEditorPopup = function(url, name, specs, parent) {';
      						$str = $str . ' if ((typeof popups == "undefined") || popups[name] == undefined || popups[name].closed) {';
      						$str = $str . ' if (typeof popups == "undefined") {';
      						$str = $str . ' popups = new Array();';
      						$str = $str . ' }';
      						$str = $str . ' var opener = (parent != undefined ? parent : window);';
      						$str = $str . 'popups[name] = opener.open(url, name, specs);';
      						$str = $str . ' } else {';
      						$str = $str . ' popups[name].focus();';
      						$str = $str . ' }';
      						$str = $str . 'return popups[name];';
      						$str = $str . '}';
      						$str = $str . 'closeEditorPopup = function(name) {';
      						$str = $str . 'if ((typeof popups != "undefined") &amp;&amp; popups[name] != undefined &amp;&amp; !popups[name].closed) {';
      						$str = $str . 'popups[name].close();';
      						$str = $str . '}';
      						$str = $str . '}';
      						$str = $str . ' </script>';
      						$str = $str . '<script type="text/javascript">';
      						$str = $str . 'if ("undefined" != typeof(Translator)) {';
      						$str = $str . 'Translator.add({"Insert Image...":"Insert Image...","Insert Media...":"Insert Media...","Insert File...":"Insert File..."});';
      						$str = $str . '}wysiwyghomepage_element_1_sixteen_one_style_image = new tinyMceWysiwygSetup("homepage_element_1_sixteen_one_style_image", {"enabled":true,"hidden":true,"use_container":false,"add_variables":true,"add_widgets":true,"add_images":true,"no_display":false,"translator":{},"encode_directives":true,"directives_url":"'.$baseurl.'evolved/cms_wysiwyg/directive/","popup_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/dialog.css","content_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/content.css","width":"100%","plugins":[{"name":"magentovariable","src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentovariable/editor_plugin.js","options":{"title":"Insert Variable...","url":"'.$baseurl.'evolved/system_variable/wysiwygPlugin/","onclick":{"search":["html_id"],"subject":"MagentovariablePlugin.loadChooser(\''.$baseurl.'evolved/system_variable/wysiwygPlugin/\', \'{{html_id}}\');"},"class":"add-variable plugin"}}],"directives_url_quoted":"'.$baseurl.'evolved/cms_wysiwyg/directive/","files_browser_window_url":"'.$baseurl.'idealAdmin/cms_wysiwyg_images/index/","files_browser_window_width":1000,"files_browser_window_height":600,"widget_plugin_src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentowidget/editor_plugin.js","widget_images_url":"'.$siteurl.'skin/adminhtml/default/default/images/widget/","widget_placeholders":["Thumbs.db","catalog__category_widget_link.gif","catalog__product_widget_link.gif","catalog__product_widget_new.gif","cms__widget_block.gif","cms__widget_page_link.gif","default.gif","reports__product_widget_compared.gif","reports__product_widget_viewed.gif"],"widget_window_url":"'.$baseurl.'evolved/widget/index/","firebug_warning_title":"Warning","firebug_warning_text":"Firebug is known to make the WYSIWYG editor slow unless it is turned off or configured properly.","firebug_warning_anchor":"Hide"});';
      						$str = $str . 'editorFormValidationHandler = wysiwyghomepage_element_1_sixteen_one_style_image.onFormValidation.bind(wysiwyghomepage_element_1_sixteen_one_style_image);';
      						$str = $str . 'Event.observe("togglehomepage_element_1_sixteen_one_style_image", "click", wysiwyghomepage_element_1_sixteen_one_style_image.toggle.bind(wysiwyghomepage_element_1_sixteen_one_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("formSubmit", editorFormValidationHandler);';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceBeforeSetContent", wysiwyghomepage_element_1_sixteen_one_style_image.beforeSetContent.bind(wysiwyghomepage_element_1_sixteen_one_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceSaveContent", wysiwyghomepage_element_1_sixteen_one_style_image.saveContent.bind(wysiwyghomepage_element_1_sixteen_one_style_image));';
      						$str = $str . 'varienGlobalEvents.clearEventHandlers("open_browser_callback");';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("open_browser_callback", wysiwyghomepage_element_1_sixteen_one_style_image.openFileBrowser.bind(wysiwyghomepage_element_1_sixteen_one_style_image));';
      						$str = $str . '</script>';
      						$str = $str . '</tr>';
      						$str = $str . '</tbody>';
      						$str = $str . '</table>'; 
      						$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelement" style="display: table-cell;">';
							$str = $str . '<tbody>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_sixteen_two_style_title">Title:</label></td>';  
      						$str = $str . '<td class="value"><input id="homepage_element_1_sixteen_two_style_title" value="'.$collectiondata['homepage_element_1_sixteen_two_style_title'].'" name="homepage_element_1_sixteen_two_style_title"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_sixteen_two_style_link">Link:</label></td>';
      						$str = $str . '<td class="value"><input id="homepage_element_1_sixteen_two_style_link" value="'.$collectiondata['homepage_element_1_sixteen_two_style_link'].'" name="homepage_element_1_sixteen_two_style_link"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_sixteen_two_style_image">Image:</label></td>';
      						//$str = $str . '<td class="value"><div id="buttonshomepage_element_1_sixteen_two_style_image" class="buttons-set"><button type="button" class="scalable show-hide" style="" id="togglehomepage_element_1_sixteen_two_style_image"><span><span><span>Show / Hide Editor</span></span></span></button><button type="button" class="scalable add-widget plugin" onclick="widgetTools.openDialog('.$baseurl.'evolved/widget/index/widget_target_id/homepage_element_1_sixteen_two_style_image)" style=""><span><span><span>Insert Widget...</span></span></span></button><button type="button" class="scalable add-image plugin" onclick="MediabrowserUtility.openDialog('.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_1_sixteen_two_style_image/)" style=""><span><span><span>Insert Image...</span></span></span></button><button type="button" class="scalable add-variable plugin" onclick="MagentovariablePlugin.loadChooser('.$baseurl.'evolved/system_variable/wysiwygPlugin/, homepage_element_1_sixteen_two_style_image);"><span><span><span>Insert Variable...</span></span></span></button></div><textarea name="homepage_element_1_sixteen_two_style_image" title="" id="homepage_element_1_sixteen_two_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_1_sixteen_two_style_image'].'</textarea><small>Image size must be 1920*480 pixels</small></td>';
      						$str = $str . '<td class="value"><button id="togglehomepage_element_1_sixteen_two_style_image" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><div id="buttonshomepage_element_1_sixteen_two_style_image" class="buttons-set"><button style="" onclick="MediabrowserUtility.openDialog(\''.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_1_sixteen_two_style_image/\')" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button></div><textarea name="homepage_element_1_sixteen_two_style_image" title="" id="homepage_element_1_sixteen_two_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_1_sixteen_two_style_image'].'</textarea><small>Image size must be 258*170 pixels</small></td>';
      						$str = $str . '<script type="text/javascript">';
      						$str = $str . ' openEditorPopup = function(url, name, specs, parent) {';
      						$str = $str . ' if ((typeof popups == "undefined") || popups[name] == undefined || popups[name].closed) {';
      						$str = $str . ' if (typeof popups == "undefined") {';
      						$str = $str . ' popups = new Array();';
      						$str = $str . ' }';
      						$str = $str . ' var opener = (parent != undefined ? parent : window);';
      						$str = $str . 'popups[name] = opener.open(url, name, specs);';
      						$str = $str . ' } else {';
      						$str = $str . ' popups[name].focus();';
      						$str = $str . ' }';
      						$str = $str . 'return popups[name];';
      						$str = $str . '}';
      						$str = $str . 'closeEditorPopup = function(name) {';
      						$str = $str . 'if ((typeof popups != "undefined") &amp;&amp; popups[name] != undefined &amp;&amp; !popups[name].closed) {';
      						$str = $str . 'popups[name].close();';
      						$str = $str . '}';
      						$str = $str . '}';
      						$str = $str . ' </script>';
      						$str = $str . '<script type="text/javascript">';
      						$str = $str . 'if ("undefined" != typeof(Translator)) {';
      						$str = $str . 'Translator.add({"Insert Image...":"Insert Image...","Insert Media...":"Insert Media...","Insert File...":"Insert File..."});';
      						$str = $str . '}wysiwyghomepage_element_1_sixteen_two_style_image = new tinyMceWysiwygSetup("homepage_element_1_sixteen_two_style_image", {"enabled":true,"hidden":true,"use_container":false,"add_variables":true,"add_widgets":true,"add_images":true,"no_display":false,"translator":{},"encode_directives":true,"directives_url":"'.$baseurl.'evolved/cms_wysiwyg/directive/","popup_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/dialog.css","content_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/content.css","width":"100%","plugins":[{"name":"magentovariable","src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentovariable/editor_plugin.js","options":{"title":"Insert Variable...","url":"'.$baseurl.'evolved/system_variable/wysiwygPlugin/","onclick":{"search":["html_id"],"subject":"MagentovariablePlugin.loadChooser(\''.$baseurl.'evolved/system_variable/wysiwygPlugin/\', \'{{html_id}}\');"},"class":"add-variable plugin"}}],"directives_url_quoted":"'.$baseurl.'evolved/cms_wysiwyg/directive/","files_browser_window_url":"'.$baseurl.'idealAdmin/cms_wysiwyg_images/index/","files_browser_window_width":1000,"files_browser_window_height":600,"widget_plugin_src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentowidget/editor_plugin.js","widget_images_url":"'.$siteurl.'skin/adminhtml/default/default/images/widget/","widget_placeholders":["Thumbs.db","catalog__category_widget_link.gif","catalog__product_widget_link.gif","catalog__product_widget_new.gif","cms__widget_block.gif","cms__widget_page_link.gif","default.gif","reports__product_widget_compared.gif","reports__product_widget_viewed.gif"],"widget_window_url":"'.$baseurl.'evolved/widget/index/","firebug_warning_title":"Warning","firebug_warning_text":"Firebug is known to make the WYSIWYG editor slow unless it is turned off or configured properly.","firebug_warning_anchor":"Hide"});';
      						$str = $str . 'editorFormValidationHandler = wysiwyghomepage_element_1_sixteen_two_style_image.onFormValidation.bind(wysiwyghomepage_element_1_sixteen_two_style_image);';
      						$str = $str . 'Event.observe("togglehomepage_element_1_sixteen_two_style_image", "click", wysiwyghomepage_element_1_sixteen_two_style_image.toggle.bind(wysiwyghomepage_element_1_sixteen_two_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("formSubmit", editorFormValidationHandler);';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceBeforeSetContent", wysiwyghomepage_element_1_sixteen_two_style_image.beforeSetContent.bind(wysiwyghomepage_element_1_sixteen_two_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceSaveContent", wysiwyghomepage_element_1_sixteen_two_style_image.saveContent.bind(wysiwyghomepage_element_1_sixteen_two_style_image));';
      						$str = $str . 'varienGlobalEvents.clearEventHandlers("open_browser_callback");';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("open_browser_callback", wysiwyghomepage_element_1_sixteen_two_style_image.openFileBrowser.bind(wysiwyghomepage_element_1_sixteen_two_style_image));';
      						$str = $str . '</script>';
      						$str = $str . '</tr>';
      						$str = $str . '</tbody>';
      						$str = $str . '</table>';
      						$str = $str . '<table cellspacing="0" class="form-list allpageelement" style="display: table-cell;">';
							$str = $str . '<tbody>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_sixteen_three_style_title">Title:</label></td>';  
      						$str = $str . '<td class="value"><input id="homepage_element_1_sixteen_three_style_title" value="'.$collectiondata['homepage_element_1_sixteen_three_style_title'].'" name="homepage_element_1_sixteen_three_style_title"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_sixteen_three_style_link">Link:</label></td>';
      						$str = $str . '<td class="value"><input id="homepage_element_1_sixteen_three_style_link" value="'.$collectiondata['homepage_element_1_sixteen_three_style_link'].'" name="homepage_element_1_sixteen_three_style_link"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_sixteen_three_style_image">Image:</label></td>';
      						//$str = $str . '<td class="value"><div id="buttonshomepage_element_1_sixteen_three_style_image" class="buttons-set"><button type="button" class="scalable show-hide" style="" id="togglehomepage_element_1_sixteen_three_style_image"><span><span><span>Show / Hide Editor</span></span></span></button><button type="button" class="scalable add-widget plugin" onclick="widgetTools.openDialog('.$baseurl.'evolved/widget/index/widget_target_id/homepage_element_1_sixteen_three_style_image)" style=""><span><span><span>Insert Widget...</span></span></span></button><button type="button" class="scalable add-image plugin" onclick="MediabrowserUtility.openDialog('.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_1_sixteen_three_style_image/)" style=""><span><span><span>Insert Image...</span></span></span></button><button type="button" class="scalable add-variable plugin" onclick="MagentovariablePlugin.loadChooser('.$baseurl.'evolved/system_variable/wysiwygPlugin/, homepage_element_1_sixteen_three_style_image);"><span><span><span>Insert Variable...</span></span></span></button></div><textarea name="homepage_element_1_sixteen_three_style_image" title="" id="homepage_element_1_sixteen_three_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_1_sixteen_three_style_image'].'</textarea><small>Image size must be 1920*480 pixels</small></td>';
      						$str = $str . '<td class="value"><button id="togglehomepage_element_1_sixteen_three_style_image" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><div id="buttonshomepage_element_1_sixteen_three_style_image" class="buttons-set"><button style="" onclick="MediabrowserUtility.openDialog(\''.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_1_sixteen_three_style_image/\')" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button></div><textarea name="homepage_element_1_sixteen_three_style_image" title="" id="homepage_element_1_sixteen_three_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_1_sixteen_three_style_image'].'</textarea><small>Image size must be 258*170 pixels</small></td>';
      						$str = $str . '<script type="text/javascript">';
      						$str = $str . ' openEditorPopup = function(url, name, specs, parent) {';
      						$str = $str . ' if ((typeof popups == "undefined") || popups[name] == undefined || popups[name].closed) {';
      						$str = $str . ' if (typeof popups == "undefined") {';
      						$str = $str . ' popups = new Array();';
      						$str = $str . ' }';
      						$str = $str . ' var opener = (parent != undefined ? parent : window);';
      						$str = $str . 'popups[name] = opener.open(url, name, specs);';
      						$str = $str . ' } else {';
      						$str = $str . ' popups[name].focus();';
      						$str = $str . ' }';
      						$str = $str . 'return popups[name];';
      						$str = $str . '}';
      						$str = $str . 'closeEditorPopup = function(name) {';
      						$str = $str . 'if ((typeof popups != "undefined") &amp;&amp; popups[name] != undefined &amp;&amp; !popups[name].closed) {';
      						$str = $str . 'popups[name].close();';
      						$str = $str . '}';
      						$str = $str . '}';
      						$str = $str . ' </script>';
      						$str = $str . '<script type="text/javascript">';
      						$str = $str . 'if ("undefined" != typeof(Translator)) {';
      						$str = $str . 'Translator.add({"Insert Image...":"Insert Image...","Insert Media...":"Insert Media...","Insert File...":"Insert File..."});';
      						$str = $str . '}wysiwyghomepage_element_1_sixteen_three_style_image = new tinyMceWysiwygSetup("homepage_element_1_sixteen_three_style_image", {"enabled":true,"hidden":true,"use_container":false,"add_variables":true,"add_widgets":true,"add_images":true,"no_display":false,"translator":{},"encode_directives":true,"directives_url":"'.$baseurl.'evolved/cms_wysiwyg/directive/","popup_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/dialog.css","content_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/content.css","width":"100%","plugins":[{"name":"magentovariable","src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentovariable/editor_plugin.js","options":{"title":"Insert Variable...","url":"'.$baseurl.'evolved/system_variable/wysiwygPlugin/","onclick":{"search":["html_id"],"subject":"MagentovariablePlugin.loadChooser(\''.$baseurl.'evolved/system_variable/wysiwygPlugin/\', \'{{html_id}}\');"},"class":"add-variable plugin"}}],"directives_url_quoted":"'.$baseurl.'evolved/cms_wysiwyg/directive/","files_browser_window_url":"'.$baseurl.'idealAdmin/cms_wysiwyg_images/index/","files_browser_window_width":1000,"files_browser_window_height":600,"widget_plugin_src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentowidget/editor_plugin.js","widget_images_url":"'.$siteurl.'skin/adminhtml/default/default/images/widget/","widget_placeholders":["Thumbs.db","catalog__category_widget_link.gif","catalog__product_widget_link.gif","catalog__product_widget_new.gif","cms__widget_block.gif","cms__widget_page_link.gif","default.gif","reports__product_widget_compared.gif","reports__product_widget_viewed.gif"],"widget_window_url":"'.$baseurl.'evolved/widget/index/","firebug_warning_title":"Warning","firebug_warning_text":"Firebug is known to make the WYSIWYG editor slow unless it is turned off or configured properly.","firebug_warning_anchor":"Hide"});';
      						$str = $str . 'editorFormValidationHandler = wysiwyghomepage_element_1_sixteen_three_style_image.onFormValidation.bind(wysiwyghomepage_element_1_sixteen_three_style_image);';
      						$str = $str . 'Event.observe("togglehomepage_element_1_sixteen_three_style_image", "click", wysiwyghomepage_element_1_sixteen_three_style_image.toggle.bind(wysiwyghomepage_element_1_sixteen_three_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("formSubmit", editorFormValidationHandler);';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceBeforeSetContent", wysiwyghomepage_element_1_sixteen_three_style_image.beforeSetContent.bind(wysiwyghomepage_element_1_sixteen_three_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceSaveContent", wysiwyghomepage_element_1_sixteen_three_style_image.saveContent.bind(wysiwyghomepage_element_1_sixteen_three_style_image));';
      						$str = $str . 'varienGlobalEvents.clearEventHandlers("open_browser_callback");';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("open_browser_callback", wysiwyghomepage_element_1_sixteen_three_style_image.openFileBrowser.bind(wysiwyghomepage_element_1_sixteen_three_style_image));';
      						$str = $str . '</script>';
      						$str = $str . '</tr>';
      						$str = $str . '</tbody>';
      						$str = $str . '</table>';
      						$str = $str . '<table cellspacing="0" class="form-list allpageelement" style="display: table-cell;">';
							$str = $str . '<tbody>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_sixteen_four_style_title">Title:</label></td>';  
      						$str = $str . '<td class="value"><input id="homepage_element_1_sixteen_four_style_title" value="'.$collectiondata['homepage_element_1_sixteen_four_style_title'].'" name="homepage_element_1_sixteen_four_style_title"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_sixteen_four_style_link">Link:</label></td>';
      						$str = $str . '<td class="value"><input id="homepage_element_1_sixteen_four_style_link" value="'.$collectiondata['homepage_element_1_sixteen_four_style_link'].'" name="homepage_element_1_sixteen_four_style_link"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_sixteen_four_style_image">Image:</label></td>';
      						//$str = $str . '<td class="value"><div id="buttonshomepage_element_1_sixteen_four_style_image" class="buttons-set"><button type="button" class="scalable show-hide" style="" id="togglehomepage_element_1_sixteen_four_style_image"><span><span><span>Show / Hide Editor</span></span></span></button><button type="button" class="scalable add-widget plugin" onclick="widgetTools.openDialog('.$baseurl.'evolved/widget/index/widget_target_id/homepage_element_1_sixteen_four_style_image)" style=""><span><span><span>Insert Widget...</span></span></span></button><button type="button" class="scalable add-image plugin" onclick="MediabrowserUtility.openDialog('.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_1_sixteen_four_style_image/)" style=""><span><span><span>Insert Image...</span></span></span></button><button type="button" class="scalable add-variable plugin" onclick="MagentovariablePlugin.loadChooser('.$baseurl.'evolved/system_variable/wysiwygPlugin/, homepage_element_1_sixteen_four_style_image);"><span><span><span>Insert Variable...</span></span></span></button></div><textarea name="homepage_element_1_sixteen_four_style_image" title="" id="homepage_element_1_sixteen_four_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_1_sixteen_four_style_image'].'</textarea><small>Image size must be 1920*480 pixels</small></td>';
      						$str = $str . '<td class="value"><button id="togglehomepage_element_1_sixteen_four_style_image" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><div id="buttonshomepage_element_1_sixteen_four_style_image" class="buttons-set"><button style="" onclick="MediabrowserUtility.openDialog(\''.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_1_sixteen_four_style_image/\')" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button></div><textarea name="homepage_element_1_sixteen_four_style_image" title="" id="homepage_element_1_sixteen_four_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_1_sixteen_four_style_image'].'</textarea><small>Image size must be 258*170 pixels</small></td>';
      						$str = $str . '<script type="text/javascript">';
      						$str = $str . ' openEditorPopup = function(url, name, specs, parent) {';
      						$str = $str . ' if ((typeof popups == "undefined") || popups[name] == undefined || popups[name].closed) {';
      						$str = $str . ' if (typeof popups == "undefined") {';
      						$str = $str . ' popups = new Array();';
      						$str = $str . ' }';
      						$str = $str . ' var opener = (parent != undefined ? parent : window);';
      						$str = $str . 'popups[name] = opener.open(url, name, specs);';
      						$str = $str . ' } else {';
      						$str = $str . ' popups[name].focus();';
      						$str = $str . ' }';
      						$str = $str . 'return popups[name];';
      						$str = $str . '}';
      						$str = $str . 'closeEditorPopup = function(name) {';
      						$str = $str . 'if ((typeof popups != "undefined") &amp;&amp; popups[name] != undefined &amp;&amp; !popups[name].closed) {';
      						$str = $str . 'popups[name].close();';
      						$str = $str . '}';
      						$str = $str . '}';
      						$str = $str . ' </script>';
      						$str = $str . '<script type="text/javascript">';
      						$str = $str . 'if ("undefined" != typeof(Translator)) {';
      						$str = $str . 'Translator.add({"Insert Image...":"Insert Image...","Insert Media...":"Insert Media...","Insert File...":"Insert File..."});';
      						$str = $str . '}wysiwyghomepage_element_1_sixteen_four_style_image = new tinyMceWysiwygSetup("homepage_element_1_sixteen_four_style_image", {"enabled":true,"hidden":true,"use_container":false,"add_variables":true,"add_widgets":true,"add_images":true,"no_display":false,"translator":{},"encode_directives":true,"directives_url":"'.$baseurl.'evolved/cms_wysiwyg/directive/","popup_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/dialog.css","content_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/content.css","width":"100%","plugins":[{"name":"magentovariable","src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentovariable/editor_plugin.js","options":{"title":"Insert Variable...","url":"'.$baseurl.'evolved/system_variable/wysiwygPlugin/","onclick":{"search":["html_id"],"subject":"MagentovariablePlugin.loadChooser(\''.$baseurl.'evolved/system_variable/wysiwygPlugin/\', \'{{html_id}}\');"},"class":"add-variable plugin"}}],"directives_url_quoted":"'.$baseurl.'evolved/cms_wysiwyg/directive/","files_browser_window_url":"'.$baseurl.'idealAdmin/cms_wysiwyg_images/index/","files_browser_window_width":1000,"files_browser_window_height":600,"widget_plugin_src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentowidget/editor_plugin.js","widget_images_url":"'.$siteurl.'skin/adminhtml/default/default/images/widget/","widget_placeholders":["Thumbs.db","catalog__category_widget_link.gif","catalog__product_widget_link.gif","catalog__product_widget_new.gif","cms__widget_block.gif","cms__widget_page_link.gif","default.gif","reports__product_widget_compared.gif","reports__product_widget_viewed.gif"],"widget_window_url":"'.$baseurl.'evolved/widget/index/","firebug_warning_title":"Warning","firebug_warning_text":"Firebug is known to make the WYSIWYG editor slow unless it is turned off or configured properly.","firebug_warning_anchor":"Hide"});';
      						$str = $str . 'editorFormValidationHandler = wysiwyghomepage_element_1_sixteen_four_style_image.onFormValidation.bind(wysiwyghomepage_element_1_sixteen_four_style_image);';
      						$str = $str . 'Event.observe("togglehomepage_element_1_sixteen_four_style_image", "click", wysiwyghomepage_element_1_sixteen_four_style_image.toggle.bind(wysiwyghomepage_element_1_sixteen_four_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("formSubmit", editorFormValidationHandler);';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceBeforeSetContent", wysiwyghomepage_element_1_sixteen_four_style_image.beforeSetContent.bind(wysiwyghomepage_element_1_sixteen_four_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceSaveContent", wysiwyghomepage_element_1_sixteen_four_style_image.saveContent.bind(wysiwyghomepage_element_1_sixteen_four_style_image));';
      						$str = $str . 'varienGlobalEvents.clearEventHandlers("open_browser_callback");';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("open_browser_callback", wysiwyghomepage_element_1_sixteen_four_style_image.openFileBrowser.bind(wysiwyghomepage_element_1_sixteen_four_style_image));';
      						$str = $str . '</script>';
      						$str = $str . '</tr>';
      						$str = $str . '</tbody>';
      						$str = $str . '</table>';
      						$str = $str . '</td>';
      						$str = $str . '</tr>';
      						$str = $str . '</tbody>';
      						$str = $str . '</table>';
      					}
      					//else if($selectElement == '33_%_left_50_%_right_boxes_right_updown_width')
      					{
      						if($selectElement == 'homepage_element_1_show_newarrival_product')
      						{
      							$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="homepage_element_1_show_newarrival_product" style="display: block">';
      						}
      						else
      						{
      							$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="homepage_element_1_show_newarrival_product"  style="display: none">';
      						}
      						$newarrival = array(0=>'No', 1=>'Yes');
      						//$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="33_percentage_left_50_percentage_right_boxes_right_updown_width">';
      						$str = $str . '<tbody>';
      						$str = $str . '<tr>';
      						$str = $str . '<td>';
      						$str = $str . '<table cellspacing="0" class="form-list allpageelement" style="display: table-cell;">';
      						$str = $str . '<tbody>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_newarrival_enabled">Show New Arrival:</label></td>';
      						$str = $str . '<td class="value">';
      						$str = $str . '<select class=" select" name="homepage_element_1_newarrival_enabled" id="homepage_element_1_newarrival_enabled">';
      						foreach($newarrival as $newarrivalkey => $newarrivalvalue)
      						{
      							if($collectiondata["homepage_element_1_newarrival_enabled"] == $newarrivalkey)
      							{
      								$str = $str . '<option value="'.$newarrivalkey.'" selected="selected">'.$newarrivalvalue.'</option>';
      							}
      							else
      							{
      								$str = $str . '<option value="'.$newarrivalkey.'">'.$newarrivalvalue.'</option>';
      							}
      						}
      						$str = $str . '</select>';
      						$str = $str . '</td>';
      						$str = $str . '</tr>';
      						$str = $str . '</tbody>';
      						$str = $str . '</table>';
      						$str = $str . '</td>';
      						$str = $str . '</tr>';
      						$str = $str . '</tbody>';
      						$str = $str . '</table>';
      					}
      					//else if($selectElement == '33_%_left_50_%_right_boxes_right_updown_width')
      					{
      						if($selectElement == 'homepage_element_1_show_special_product')
      						{
      							$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="homepage_element_1_show_special_product" style="display: block">';
      						}
      						else
      						{
      							$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="homepage_element_1_show_special_product"  style="display: none">';
      						}
      						$special = array(0=>'No', 1=>'Yes');
      						//$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="33_percentage_left_50_percentage_right_boxes_right_updown_width">';
      						$str = $str . '<tbody>';
      						$str = $str . '<tr>';
      						$str = $str . '<td>';
      						$str = $str . '<table cellspacing="0" class="form-list allpageelement" style="display: table-cell;">';
      						$str = $str . '<tbody>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_special_enabled">Show Special :</label></td>';
      						$str = $str . '<td class="value">';
      						$str = $str . '<select class=" select" name="homepage_element_1_special_enabled" id="homepage_element_1_special_enabled">';
      						foreach($special as $specialkey => $specialvalue)
      						{
      							if($collectiondata["homepage_element_1_special_enabled"] == $specialkey)
      							{
      								$str = $str . '<option value="'.$specialkey.'" selected="selected">'.$specialvalue.'</option>';
      							}
      							else
      							{
      								$str = $str . '<option value="'.$specialkey.'">'.$specialvalue.'</option>';
      							}
      						}
      						$str = $str . '</select>';
      						$str = $str . '</td>';
      						$str = $str . '</tr>';
      						$str = $str . '</tbody>';
      						$str = $str . '</table>';
      						$str = $str . '</td>';
      						$str = $str . '</tr>';
      						$str = $str . '</tbody>';
      						$str = $str . '</table>';
      					}
      					//else if($selectElement == '33_%_left_50_%_right_boxes_right_updown_width')
      					{
      						if($selectElement == 'homepage_element_1_show_bestsellers_product')
      						{
      							$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="homepage_element_1_show_bestsellers_product" style="display: block">';
      						}
      						else
      						{
      							$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="homepage_element_1_show_bestsellers_product"  style="display: none">';
      						}
      						$bestsellers = array(0=>'No', 1=>'Yes');
      						//$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="33_percentage_left_50_percentage_right_boxes_right_updown_width">';
      						$str = $str . '<tbody>';
      						$str = $str . '<tr>';
      						$str = $str . '<td>';
      						$str = $str . '<table cellspacing="0" class="form-list allpageelement" style="display: table-cell;">';
      						$str = $str . '<tbody>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_bestsellers_enabled">Show Best Sellers :</label></td>';
      						$str = $str . '<td class="value">';
      						$str = $str . '<select class=" select" name="homepage_element_1_bestsellers_enabled" id="homepage_element_1_bestsellers_enabled">';
      						foreach($bestsellers as $bestsellerskey => $bestsellersvalue)
      						{
      							if($collectiondata["homepage_element_1_bestsellers_enabled"] == $bestsellerskey)
      							{
      								$str = $str . '<option value="'.$bestsellerskey.'" selected="selected">'.$bestsellersvalue.'</option>';
      							}
      							else
      							{
      								$str = $str . '<option value="'.$bestsellerskey.'">'.$bestsellersvalue.'</option>';
      							}
      						}
      						$str = $str . '</select>';
      						$str = $str . '</td>';
      						$str = $str . '</tr>';
      						$str = $str . '</tbody>';
      						$str = $str . '</table>';
      						$str = $str . '</td>';
      						$str = $str . '</tr>';
      						$str = $str . '</tbody>';
      						$str = $str . '</table>';
      					}
      					//else if($selectElement == '33_%_left_50_%_right_boxes_right_updown_width')
      					{
      						if($selectElement == 'homepage_element_1_show_mostviewed_product')
      						{
      							$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="homepage_element_1_show_mostviewed_product" style="display: block">';
      						}
      						else
      						{
      							$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="homepage_element_1_show_mostviewed_product"  style="display: none">';
      						}
      						$mostviewed = array(0=>'No', 1=>'Yes');
      						//$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="33_percentage_left_50_percentage_right_boxes_right_updown_width">';
      						$str = $str . '<tbody>';
      						$str = $str . '<tr>';
      						$str = $str . '<td>';
      						$str = $str . '<table cellspacing="0" class="form-list allpageelement" style="display: table-cell;">';
      						$str = $str . '<tbody>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_mostviewed_enabled">Show Most Viewed :</label></td>';
      						$str = $str . '<td class="value">';
      						$str = $str . '<select class=" select" name="homepage_element_1_mostviewed_enabled" id="homepage_element_1_mostviewed_enabled">';
      						foreach($mostviewed as $mostviewedkey => $mostviewedvalue)
      						{
      							if($collectiondata["homepage_element_1_mostviewed_enabled"] == $mostviewedkey)
      							{
      								$str = $str . '<option value="'.$mostviewedkey.'" selected="selected">'.$mostviewedvalue.'</option>';
      							}
      							else
      							{
      								$str = $str . '<option value="'.$mostviewedkey.'">'.$mostviewedvalue.'</option>';
      							}
      						}
      						$str = $str . '</select>';
      						$str = $str . '</td>';
      						$str = $str . '</tr>';
      						$str = $str . '</tbody>';
      						$str = $str . '</table>';
      						$str = $str . '</td>';
      						$str = $str . '</tr>';
      						$str = $str . '</tbody>';
      						$str = $str . '</table>';
      					}
      					//else if($selectElement == '33_%_left_50_%_right_boxes_right_updown_width')
      					{
      						if($selectElement == 'homepage_element_1_show_featured_product')
      						{
      							$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="homepage_element_1_show_featured_product" style="display: block">';
      						}
      						else
      						{
      							$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="homepage_element_1_show_featured_product"  style="display: none">';
      						}
      						$featured = array(0=>'No', 1=>'Yes');
      						//$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="33_percentage_left_50_percentage_right_boxes_right_updown_width">';
      						$str = $str . '<tbody>';
      						$str = $str . '<tr>';
      						$str = $str . '<td>';
      						$newarrival = array(0=>'No', 1=>'Yes');
      						$str = $str . '<table cellspacing="0" class="form-list">';
      						$str = $str . '<tbody>';
      						$str = $str . '<tr>';
      						$str = $str . '<td>';
      						$str = $str . '<table cellspacing="0" class="form-list allpageelement" style="display: table-cell;">';
      						$str = $str . '<tbody>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_newarrival_enabled">Show New Arrival:</label></td>';
      						$str = $str . '<td class="value">';
      						$str = $str . '<select class=" select" name="homepage_element_1_newarrival_enabled" id="homepage_element_1_newarrival_enabled">';
      						foreach($newarrival as $newarrivalkey => $newarrivalvalue)
      						{
      							if($collectiondata["homepage_element_1_newarrival_enabled"] == $newarrivalkey)
      							{
      								$str = $str . '<option value="'.$newarrivalkey.'" selected="selected">'.$newarrivalvalue.'</option>';
      							}
      							else
      							{
      								$str = $str . '<option value="'.$newarrivalkey.'">'.$newarrivalvalue.'</option>';
      							}
      						}
      						$str = $str . '</select>';
      						$str = $str . '</td>';
      						$str = $str . '</tr>';
      						$str = $str . '</tbody>';
      						$str = $str . '</table>';
      						$str = $str . '</td>';
      						$str = $str . '</tr>';
      						$str = $str . '</tbody>';
      						$str = $str . '</table>';
      						$str = $str . '</td>';
      						$str = $str . '</tr>';
      						$str = $str . '<tr>';
      						$str = $str . '<td>';
      						$special = array(0=>'No', 1=>'Yes');
      						$str = $str . '<table cellspacing="0" class="form-list">';
      						$str = $str . '<tbody>';
      						$str = $str . '<tr>';
      						$str = $str . '<td>';
      						$str = $str . '<table cellspacing="0" class="form-list allpageelement" style="display: table-cell;">';
      						$str = $str . '<tbody>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_special_enabled">Show Special :</label></td>';
      						$str = $str . '<td class="value">';
      						$str = $str . '<select class=" select" name="homepage_element_1_special_enabled" id="homepage_element_1_special_enabled">';
      						foreach($special as $specialkey => $specialvalue)
      						{
      							if($collectiondata["homepage_element_1_special_enabled"] == $specialkey)
      							{
      								$str = $str . '<option value="'.$specialkey.'" selected="selected">'.$specialvalue.'</option>';
      							}
      							else
      							{
      								$str = $str . '<option value="'.$specialkey.'">'.$specialvalue.'</option>';
      							}
      						}
      						$str = $str . '</select>';
      						$str = $str . '</td>';
      						$str = $str . '</tr>';
      						$str = $str . '</tbody>';
      						$str = $str . '</table>';
      						$str = $str . '</td>';
      						$str = $str . '</tr>';
      						$str = $str . '</tbody>';
      						$str = $str . '</table>';
      						$str = $str . '</td>';
      						$str = $str . '</tr>';
      						$str = $str . '<tr>';
      						$str = $str . '<td>';
      						$bestsellers = array(0=>'No', 1=>'Yes');
      						$str = $str . '<table cellspacing="0" class="form-list">';
      						$str = $str . '<tbody>';
      						$str = $str . '<tr>';
      						$str = $str . '<td>';
      						$str = $str . '<table cellspacing="0" class="form-list allpageelement" style="display: table-cell;">';
      						$str = $str . '<tbody>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_bestsellers_enabled">Show Best Sellers :</label></td>';
      						$str = $str . '<td class="value">';
      						$str = $str . '<select class=" select" name="homepage_element_1_bestsellers_enabled" id="homepage_element_1_bestsellers_enabled">';
      						foreach($bestsellers as $bestsellerskey => $bestsellersvalue)
      						{
      							if($collectiondata["homepage_element_1_bestsellers_enabled"] == $bestsellerskey)
      							{
      								$str = $str . '<option value="'.$bestsellerskey.'" selected="selected">'.$bestsellersvalue.'</option>';
      							}
      							else
      							{
      								$str = $str . '<option value="'.$bestsellerskey.'">'.$bestsellersvalue.'</option>';
      							}
      						}
      						$str = $str . '</select>';
      						$str = $str . '</td>';
      						$str = $str . '</tr>';
      						$str = $str . '</tbody>';
      						$str = $str . '</table>';
      						$str = $str . '</td>';
      						$str = $str . '</tr>';
      						$str = $str . '</tbody>';
      						$str = $str . '</table>';
      						$str = $str . '</td>';
      						$str = $str . '</tr>';
      						$str = $str . '<tr>';
      						$str = $str . '<td>';
      						$mostviewed = array(0=>'No', 1=>'Yes');
      						$str = $str . '<table cellspacing="0" class="form-list">';
      						$str = $str . '<tbody>';
      						$str = $str . '<tr>';
      						$str = $str . '<td>';
      						$str = $str . '<table cellspacing="0" class="form-list allpageelement" style="display: table-cell;">';
      						$str = $str . '<tbody>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_mostviewed_enabled">Show Most Viewed :</label></td>';
      						$str = $str . '<td class="value">';
      						$str = $str . '<select class=" select" name="homepage_element_1_mostviewed_enabled" id="homepage_element_1_mostviewed_enabled">';
      						foreach($mostviewed as $mostviewedkey => $mostviewedvalue)
      						{
      							if($collectiondata["homepage_element_1_mostviewed_enabled"] == $mostviewedkey)
      							{
      								$str = $str . '<option value="'.$mostviewedkey.'" selected="selected">'.$mostviewedvalue.'</option>';
      							}
      							else
      							{
      								$str = $str . '<option value="'.$mostviewedkey.'">'.$mostviewedvalue.'</option>';
      							}
      						}
      						$str = $str . '</select>';
      						$str = $str . '</td>';
      						$str = $str . '</tr>';
      						$str = $str . '</tbody>';
      						$str = $str . '</table>';
      						$str = $str . '</td>';
      						$str = $str . '</tr>';
      						$str = $str . '</tbody>';
      						$str = $str . '</table>';
      						$str = $str . '</td>';
      						$str = $str . '</tr>';
      						$str = $str . '<tr>';
      						$str = $str . '<td>';
      						$str = $str . '<table cellspacing="0" class="form-list allpageelement" style="display: table-cell;">';
      						$str = $str . '<tbody>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_featured_enabled">Show Featured :</label></td>';
      						$str = $str . '<td class="value">';
      						$str = $str . '<select class=" select" name="homepage_element_1_featured_enabled" id="homepage_element_1_featured_enabled">';
      						foreach($featured as $featuredkey => $featuredvalue)
      						{
      							if($collectiondata["homepage_element_1_featured_enabled"] == $featuredkey)
      							{
      								$str = $str . '<option value="'.$featuredkey.'" selected="selected">'.$featuredvalue.'</option>';
      							}
      							else
      							{
      								$str = $str . '<option value="'.$featuredkey.'">'.$featuredvalue.'</option>';
      							}
      						}
      						$str = $str . '</select>';
      						$str = $str . '</td>';
      						$str = $str . '</tr>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_featured_category_id">Featured Category:</label></td>';
      						$str = $str . '<td class="value">';
      						$str = $str . '<select class=" select" name="homepage_element_1_featured_category_id" id="homepage_element_1_featured_category_id">';
      						foreach(Mage::getModel('evolved/category')->toOptionArray() as $featuredcatid => $featuredcatname)
      						{
      							if($collectiondata["homepage_element_1_featured_category_id"] == $featuredcatid)
      							{
      								$str = $str . '<option value="'.$featuredcatid.'" selected="selected">'.$featuredcatname.'</option>';
      							}
      							else
      							{
      								$str = $str . '<option value="'.$featuredcatid.'">'.$featuredcatname.'</option>';
      							}
      						}
      						$str = $str . '</select>';
      						$str = $str . '</td>';
      						$str = $str . '</tr>';
      						$str = $str . '</tbody>';
      						$str = $str . '</table>';
      						$str = $str . '</td>';
      						$str = $str . '</tr>';
      						$str = $str . '</tbody>';
      						$str = $str . '</table>';
      					}
      					//echo "<pre>";
      					//print_r(Mage::getModel('evolved/category')->toOptionArray());
      					//exit;
      					//else if($selectElement == '33_%_left_50_%_right_boxes_right_updown_width')
      					{
      						if($selectElement == 'homepage_element_1_show_brand_manager')
      						{
      							$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="homepage_element_1_show_brand_manager" style="display: block">';
      						}
      						else
      						{
      							$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="homepage_element_1_show_brand_manager"  style="display: none">';
      						}
      						$brand_manager = array(0=>'No', 1=>'Yes');
      						//$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="33_percentage_left_50_percentage_right_boxes_right_updown_width">';
      						$str = $str . '<tbody>';
      						$str = $str . '<tr>';
      						$str = $str . '<td>';
      						$str = $str . '<table cellspacing="0" class="form-list allpageelement" style="display: table-cell;">';
      						$str = $str . '<tbody>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_brand_manager_enabled">Show Brand Manager :</label></td>';
      						$str = $str . '<td class="value">';
      						$str = $str . '<select class=" select" name="homepage_element_1_brand_manager_enabled" id="homepage_element_1_brand_manager_enabled">';
      						foreach($brand_manager as $brand_managerkey => $brand_managervalue)
      						{
      							if($collectiondata["homepage_element_1_brand_manager_enabled"] == $brand_managerkey)
      							{
      								$str = $str . '<option value="'.$brand_managerkey.'" selected="selected">'.$brand_managervalue.'</option>';
      							}
      							else
      							{
      								$str = $str . '<option value="'.$brand_managerkey.'">'.$brand_managervalue.'</option>';
      							}
      						}
      						$str = $str . '</select>';
      						$str = $str . '</td>';
      						$str = $str . '</tr>';
      						$str = $str . '</tbody>';
      						$str = $str . '</table>';
      						$str = $str . '</td>';
      						$str = $str . '</tr>';
      						$str = $str . '</tbody>';
      						$str = $str . '</table>';
      					}
      					//else if($selectElement == '33_%_left_50_%_right_boxes_right_updown_width')
      					{
      						if($selectElement == 'homepage_element_1_show_slideshow_banner')
      						{
      							$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="homepage_element_1_show_slideshow_banner" style="display: block">';
      						}
      						else
      						{
      							$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="homepage_element_1_show_slideshow_banner"  style="display: none">';
      						}
      						$slideshow_banner = array(0=>'No', 1=>'Yes');
      						//$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="33_percentage_left_50_percentage_right_boxes_right_updown_width">';
      						$str = $str . '<tbody>';
      						$str = $str . '<tr>';
      						$str = $str . '<td>';
      						$str = $str . '<table cellspacing="0" class="form-list allpageelement" style="display: table-cell;">';
      						$str = $str . '<tbody>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_slideshow_banner_enabled">Show Main Banner :</label></td>';
      						$str = $str . '<td class="value">';
      						$str = $str . '<select class=" select" name="homepage_element_1_slideshow_banner_enabled" id="homepage_element_1_slideshow_banner_enabled">';
      						foreach($slideshow_banner as $slideshow_bannerkey => $slideshow_bannervalue)
      						{
      							if($collectiondata["homepage_element_1_slideshow_banner_enabled"] == $slideshow_bannerkey)
      							{
      								$str = $str . '<option value="'.$slideshow_bannerkey.'" selected="selected">'.$slideshow_bannervalue.'</option>';
      							}
      							else
      							{
      								$str = $str . '<option value="'.$slideshow_bannerkey.'">'.$slideshow_bannervalue.'</option>';
      							}
      						}
      						$str = $str . '</select>';
      						$str = $str . '</td>';
      						$str = $str . '</tr>';
      						$str = $str . '</tbody>';
      						$str = $str . '</table>';
      						$str = $str . '</td>';
      						$str = $str . '</tr>';
      						$str = $str . '</tbody>';
      						$str = $str . '</table>';
      					}
    	//else if($selectElement == '1920_by_800_banner')
	      				{
      						//alert('hi');
	      					if($selectElement == 'homepage_element_1_show_diamondrow')
	      					{
	      						$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="homepage_element_1_show_diamondrow" style="display: block">';
	      					}
	      					else
	      					{
	      						$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="homepage_element_1_show_diamondrow"  style="display: none">';
	      					}
	      					$diamondrow = array(0=>'No', 1=>'Yes');
	      					//$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="1920_by_800_banner">';
	      					$str = $str . '<tbody>';
	      					$str = $str . '<tr>';
	      					$str = $str . '<td>';
      						$str = $str . '<table cellspacing="0" class="form-list allpageelement">';
							$str = $str . '<tbody>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_diamondrow_enabled">Show Diamond row :</label></td>';
      						$str = $str . '<td class="value">';
      						$str = $str . '<select class=" select" name="homepage_element_1_diamondrow_enabled" id="homepage_element_1_diamondrow_enabled">';
      						foreach($diamondrow as $diamondrowkey => $diamondrowvalue)
      						{
      							if($collectiondata["homepage_element_1_diamondrow_enabled"] == $diamondrowkey)
      							{
      								$str = $str . '<option value="'.$diamondrowkey.'" selected="selected">'.$diamondrowvalue.'</option>';
      							}
      							else
      							{
      								$str = $str . '<option value="'.$diamondrowkey.'">'.$diamondrowvalue.'</option>';
      							}
      						}
      						$str = $str . '</select>';
      						$str = $str . '</td>';
      						$str = $str . '</tr>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_1_diamondrow_style_image">Image:</label></td>';
      						//$str = $str . '<td class="value"><div id="buttonshomepage_element_1_diamondrow_style_image" class="buttons-set"><button type="button" class="scalable show-hide" style="" id="togglehomepage_element_1_diamondrow_style_image"><span><span><span>Show / Hide Editor</span></span></span></button><button type="button" class="scalable add-widget plugin" onclick="widgetTools.openDialog('.$baseurl.'evolved/widget/index/widget_target_id/homepage_element_1_diamondrow_style_image)" style=""><span><span><span>Insert Widget...</span></span></span></button><button type="button" class="scalable add-image plugin" onclick="MediabrowserUtility.openDialog('.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_1_diamondrow_style_image/)" style=""><span><span><span>Insert Image...</span></span></span></button><button type="button" class="scalable add-variable plugin" onclick="MagentovariablePlugin.loadChooser('.$baseurl.'evolved/system_variable/wysiwygPlugin/, homepage_element_1_diamondrow_style_image);"><span><span><span>Insert Variable...</span></span></span></button></div><textarea name="homepage_element_1_diamondrow_style_image" title="" id="homepage_element_1_diamondrow_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_1_diamondrow_style_image'].'</textarea><small>Image size must be 1920*480 pixels</small></td>';
      						$str = $str . '<td class="value"><button id="togglehomepage_element_1_diamondrow_style_image" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><div id="buttonshomepage_element_1_diamondrow_style_image" class="buttons-set"><button style="" onclick="MediabrowserUtility.openDialog(\''.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_1_diamondrow_style_image/\')" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button></div><textarea name="homepage_element_1_diamondrow_style_image" title="" id="homepage_element_1_diamondrow_style_image" class="textarea " style="height:200px;" rows="2" cols="15">'.$collectiondata['homepage_element_1_diamondrow_style_image'].'</textarea></td>';
      						$str = $str . '<script type="text/javascript">';
      						$str = $str . ' openEditorPopup = function(url, name, specs, parent) {';
      						$str = $str . ' if ((typeof popups == "undefined") || popups[name] == undefined || popups[name].closed) {';
      						$str = $str . ' if (typeof popups == "undefined") {';
      						$str = $str . ' popups = new Array();';
      						$str = $str . ' }';
      						$str = $str . ' var opener = (parent != undefined ? parent : window);';
      						$str = $str . 'popups[name] = opener.open(url, name, specs);';
      						$str = $str . ' } else {';
      						$str = $str . ' popups[name].focus();';
      						$str = $str . ' }';
      						$str = $str . 'return popups[name];';
      						$str = $str . '}';
      						$str = $str . 'closeEditorPopup = function(name) {';
      						$str = $str . 'if ((typeof popups != "undefined") &amp;&amp; popups[name] != undefined &amp;&amp; !popups[name].closed) {';
      						$str = $str . 'popups[name].close();';
      						$str = $str . '}';
      						$str = $str . '}';
      						$str = $str . ' </script>';
      						$str = $str . '<script type="text/javascript">';
      						$str = $str . 'if ("undefined" != typeof(Translator)) {';
      						$str = $str . 'Translator.add({"Insert Image...":"Insert Image...","Insert Media...":"Insert Media...","Insert File...":"Insert File..."});';
      						$str = $str . '}wysiwyghomepage_element_1_diamondrow_style_image = new tinyMceWysiwygSetup("homepage_element_1_diamondrow_style_image", {"enabled":true,"hidden":true,"use_container":false,"add_variables":true,"add_widgets":true,"add_images":true,"no_display":false,"translator":{},"encode_directives":true,"directives_url":"'.$baseurl.'evolved/cms_wysiwyg/directive/","popup_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/dialog.css","content_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/content.css","width":"100%","plugins":[{"name":"magentovariable","src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentovariable/editor_plugin.js","options":{"title":"Insert Variable...","url":"'.$baseurl.'evolved/system_variable/wysiwygPlugin/","onclick":{"search":["html_id"],"subject":"MagentovariablePlugin.loadChooser(\''.$baseurl.'evolved/system_variable/wysiwygPlugin/\', \'{{html_id}}\');"},"class":"add-variable plugin"}}],"directives_url_quoted":"'.$baseurl.'evolved/cms_wysiwyg/directive/","files_browser_window_url":"'.$baseurl.'idealAdmin/cms_wysiwyg_images/index/","files_browser_window_width":1000,"files_browser_window_height":600,"widget_plugin_src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentowidget/editor_plugin.js","widget_images_url":"'.$siteurl.'skin/adminhtml/default/default/images/widget/","widget_placeholders":["Thumbs.db","catalog__category_widget_link.gif","catalog__product_widget_link.gif","catalog__product_widget_new.gif","cms__widget_block.gif","cms__widget_page_link.gif","default.gif","reports__product_widget_compared.gif","reports__product_widget_viewed.gif"],"widget_window_url":"'.$baseurl.'evolved/widget/index/","firebug_warning_title":"Warning","firebug_warning_text":"Firebug is known to make the WYSIWYG editor slow unless it is turned off or configured properly.","firebug_warning_anchor":"Hide"});';
      						$str = $str . 'editorFormValidationHandler = wysiwyghomepage_element_1_diamondrow_style_image.onFormValidation.bind(wysiwyghomepage_element_1_diamondrow_style_image);';
      						$str = $str . 'Event.observe("togglehomepage_element_1_diamondrow_style_image", "click", wysiwyghomepage_element_1_diamondrow_style_image.toggle.bind(wysiwyghomepage_element_1_diamondrow_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("formSubmit", editorFormValidationHandler);';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceBeforeSetContent", wysiwyghomepage_element_1_diamondrow_style_image.beforeSetContent.bind(wysiwyghomepage_element_1_diamondrow_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceSaveContent", wysiwyghomepage_element_1_diamondrow_style_image.saveContent.bind(wysiwyghomepage_element_1_diamondrow_style_image));';
      						$str = $str . 'varienGlobalEvents.clearEventHandlers("open_browser_callback");';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("open_browser_callback", wysiwyghomepage_element_1_diamondrow_style_image.openFileBrowser.bind(wysiwyghomepage_element_1_diamondrow_style_image));';
      						$str = $str . '</script>';
      						$str = $str . '</tr>';
      						$str = $str . '</tbody>';
      						$str = $str . '</table>';
      						$str = $str . '</td>';
      						$str = $str . '</tr>';
      						$str = $str . '</tbody>';
      						$str = $str . '</table>';
						}
						//else if($selectElement == '1920_by_800_banner')
						{
							//alert('hi');
							if($selectElement == 'homepage_element_1_show_textrow')
							{
								$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="homepage_element_1_show_textrow" style="display: block">';
							}
							else
							{
								$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="homepage_element_1_show_textrow"  style="display: none">';
							}
							$textrow = array(0=>'No', 1=>'Yes');
							//$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="1920_by_800_banner">';
							$str = $str . '<tbody>';
							$str = $str . '<tr>';
							$str = $str . '<td>';
							$str = $str . '<table cellspacing="0" class="form-list allpageelement">';
							$str = $str . '<tbody>';
							$str = $str . '<tr>';
							$str = $str . '<td class="label"><label for="homepage_element_1_textrow_enabled">Show Text Row :</label></td>';
							$str = $str . '<td class="value">';
							$str = $str . '<select class=" select" name="homepage_element_1_textrow_enabled" id="homepage_element_1_textrow_enabled">';
							foreach($textrow as $textrowkey => $textrowvalue)
							{
								if($collectiondata["homepage_element_1_textrow_enabled"] == $textrowkey)
								{
									$str = $str . '<option value="'.$textrowkey.'" selected="selected">'.$textrowvalue.'</option>';
								}
								else
								{
									$str = $str . '<option value="'.$textrowkey.'">'.$textrowvalue.'</option>';
								}
							}
							$str = $str . '</select>';
							$str = $str . '</td>';
							$str = $str . '</tr>';
							$str = $str . '<tr>';
							$str = $str . '<td class="label"><label for="homepage_element_1_textrow_style_image">Image:</label></td>';
							//$str = $str . '<td class="value"><div id="buttonshomepage_element_1_textrow_style_image" class="buttons-set"><button type="button" class="scalable show-hide" style="" id="togglehomepage_element_1_textrow_style_image"><span><span><span>Show / Hide Editor</span></span></span></button><button type="button" class="scalable add-widget plugin" onclick="widgetTools.openDialog('.$baseurl.'evolved/widget/index/widget_target_id/homepage_element_1_textrow_style_image)" style=""><span><span><span>Insert Widget...</span></span></span></button><button type="button" class="scalable add-image plugin" onclick="MediabrowserUtility.openDialog('.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_1_textrow_style_image/)" style=""><span><span><span>Insert Image...</span></span></span></button><button type="button" class="scalable add-variable plugin" onclick="MagentovariablePlugin.loadChooser('.$baseurl.'evolved/system_variable/wysiwygPlugin/, homepage_element_1_textrow_style_image);"><span><span><span>Insert Variable...</span></span></span></button></div><textarea name="homepage_element_1_textrow_style_image" title="" id="homepage_element_1_textrow_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_1_textrow_style_image'].'</textarea><small>Image size must be 1920*480 pixels</small></td>';
							$str = $str . '<td class="value"><button id="togglehomepage_element_1_textrow_style_image" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><div id="buttonshomepage_element_1_textrow_style_image" class="buttons-set"><button style="" onclick="MediabrowserUtility.openDialog(\''.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_1_textrow_style_image/\')" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button></div><textarea name="homepage_element_1_textrow_style_image" title="" id="homepage_element_1_textrow_style_image" class="textarea " style="height:200px;" rows="2" cols="15">'.$collectiondata['homepage_element_1_textrow_style_image'].'</textarea></td>';
							$str = $str . '<script type="text/javascript">';
							$str = $str . ' openEditorPopup = function(url, name, specs, parent) {';
							$str = $str . ' if ((typeof popups == "undefined") || popups[name] == undefined || popups[name].closed) {';
							$str = $str . ' if (typeof popups == "undefined") {';
							$str = $str . ' popups = new Array();';
							$str = $str . ' }';
							$str = $str . ' var opener = (parent != undefined ? parent : window);';
							$str = $str . 'popups[name] = opener.open(url, name, specs);';
							$str = $str . ' } else {';
							$str = $str . ' popups[name].focus();';
							$str = $str . ' }';
							$str = $str . 'return popups[name];';
							$str = $str . '}';
							$str = $str . 'closeEditorPopup = function(name) {';
							$str = $str . 'if ((typeof popups != "undefined") &amp;&amp; popups[name] != undefined &amp;&amp; !popups[name].closed) {';
							$str = $str . 'popups[name].close();';
							$str = $str . '}';
							$str = $str . '}';
							$str = $str . ' </script>';
							$str = $str . '<script type="text/javascript">';
							$str = $str . 'if ("undefined" != typeof(Translator)) {';
							$str = $str . 'Translator.add({"Insert Image...":"Insert Image...","Insert Media...":"Insert Media...","Insert File...":"Insert File..."});';
							$str = $str . '}wysiwyghomepage_element_1_textrow_style_image = new tinyMceWysiwygSetup("homepage_element_1_textrow_style_image", {"enabled":true,"hidden":true,"use_container":false,"add_variables":true,"add_widgets":true,"add_images":true,"no_display":false,"translator":{},"encode_directives":true,"directives_url":"'.$baseurl.'evolved/cms_wysiwyg/directive/","popup_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/dialog.css","content_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/content.css","width":"100%","plugins":[{"name":"magentovariable","src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentovariable/editor_plugin.js","options":{"title":"Insert Variable...","url":"'.$baseurl.'evolved/system_variable/wysiwygPlugin/","onclick":{"search":["html_id"],"subject":"MagentovariablePlugin.loadChooser(\''.$baseurl.'evolved/system_variable/wysiwygPlugin/\', \'{{html_id}}\');"},"class":"add-variable plugin"}}],"directives_url_quoted":"'.$baseurl.'evolved/cms_wysiwyg/directive/","files_browser_window_url":"'.$baseurl.'idealAdmin/cms_wysiwyg_images/index/","files_browser_window_width":1000,"files_browser_window_height":600,"widget_plugin_src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentowidget/editor_plugin.js","widget_images_url":"'.$siteurl.'skin/adminhtml/default/default/images/widget/","widget_placeholders":["Thumbs.db","catalog__category_widget_link.gif","catalog__product_widget_link.gif","catalog__product_widget_new.gif","cms__widget_block.gif","cms__widget_page_link.gif","default.gif","reports__product_widget_compared.gif","reports__product_widget_viewed.gif"],"widget_window_url":"'.$baseurl.'evolved/widget/index/","firebug_warning_title":"Warning","firebug_warning_text":"Firebug is known to make the WYSIWYG editor slow unless it is turned off or configured properly.","firebug_warning_anchor":"Hide"});';
							$str = $str . 'editorFormValidationHandler = wysiwyghomepage_element_1_textrow_style_image.onFormValidation.bind(wysiwyghomepage_element_1_textrow_style_image);';
							$str = $str . 'Event.observe("togglehomepage_element_1_textrow_style_image", "click", wysiwyghomepage_element_1_textrow_style_image.toggle.bind(wysiwyghomepage_element_1_textrow_style_image));';
							$str = $str . 'varienGlobalEvents.attachEventHandler("formSubmit", editorFormValidationHandler);';
							$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceBeforeSetContent", wysiwyghomepage_element_1_textrow_style_image.beforeSetContent.bind(wysiwyghomepage_element_1_textrow_style_image));';
							$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceSaveContent", wysiwyghomepage_element_1_textrow_style_image.saveContent.bind(wysiwyghomepage_element_1_textrow_style_image));';
							$str = $str . 'varienGlobalEvents.clearEventHandlers("open_browser_callback");';
							$str = $str . 'varienGlobalEvents.attachEventHandler("open_browser_callback", wysiwyghomepage_element_1_textrow_style_image.openFileBrowser.bind(wysiwyghomepage_element_1_textrow_style_image));';
							$str = $str . '</script>';
							$str = $str . '</tr>';
							$str = $str . '<tr>';
							$str = $str . '<td class="label"><label for="homepage_element_1_textrow_style_marker_checkbox">Marker:</label></td>';
							$str = $str . '<td class="value">';
							$str = $str . '<ul class="checkboxes">';
							$markerarr = array('top','right','bottom','left');
							$homepage_element_1_textrow_style_marker_checkbox = unserialize($collectiondata['homepage_element_1_textrow_style_marker_checkbox']);
							foreach($markerarr as $marker)
							{
								if($homepage_element_1_textrow_style_marker_checkbox[$marker] == $marker){
									$str = $str . '<li><input type="checkbox" value="'.$marker.'" name="homepage_element_1_textrow_style_marker_checkbox['.$marker.']" id="homepage_element_1_textrow_style_marker_checkbox['.$marker.']" checked > <label for="'.$marker.'" >'.$marker.'</label></li>';
								}
								else {
									$str = $str . '<li><input type="checkbox" value="'.$marker.'" name="homepage_element_1_textrow_style_marker_checkbox['.$marker.']" id="homepage_element_1_textrow_style_marker_checkbox['.$marker.']"> <label for="'.$marker.'">'.$marker.'</label></li>';
								}
							}
							$str = $str . '</ul>';
							$str = $str . '</td>';
							$str = $str . '</tr>';
							$str = $str . '<tr>';
							$str = $str . '<td class="label"><label for="header_background_image">Marker Image:</label></td>';
							$str = $str . '<td class="value"><input type="file" class="input-file" value="'.$collectiondata["homepage_element_1_textrow_style_marker_image"].'" name="homepage_element_1_textrow_style_marker_image" id="homepage_element_1_textrow_style_marker_image"></td>';
							$str = $str . '</tr>';
							$str = $str . '</tbody>';
							$str = $str . '</table>';
							$str = $str . '</td>';
							$str = $str . '</tr>';
							$str = $str . '</tbody>';
							$str = $str . '</table>';
						}
    	return $str;
        
    }
}