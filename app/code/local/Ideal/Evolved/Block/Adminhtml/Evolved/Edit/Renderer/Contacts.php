<script>
function contactsdefaultconfig_fn(value)
{
	if(value == "disable")
	{
		jQuery('tr.contacts_default_config_editor').css("display","table-row");
		jQuery('tr.contacts_content_address').css("display","none");
		jQuery('tr.contacts_content_address_map').css("display","none");		
	}
	else
	{
		jQuery('tr.contacts_default_config_editor').css("display","none");
		jQuery('tr.contacts_content_address').css("display","table-row");
		jQuery('tr.contacts_content_address_map').css("display","table-row");
	}
}
</script>
<?php
class Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Contacts extends Varien_Data_Form_Element_Text
{
	public function getHtml()
	{
		$baseurl = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB);
		$siteurl = str_replace("/index.php/","/",$baseurl);
		$elementonemodel = Mage::getModel('evolved/evolved');
		$elementonecollection = $elementonemodel->getCollection();
		$elementonecollection->addFieldToFilter('field', array('in' => array('contacts_default_config','contacts_default_config_editor','contacts_content_address','contacts_content_address_map','contacts_title','contacts_meta_description')));
		//$elementonecollection->addFieldToFilter('field', array('like' => 'contacts_content_address'));
		//echo "<pre>"; print_r($elementonecollection->getData()); exit;
		foreach($elementonecollection->getData() as $elementonecollectionkey => $elementonecollectionvalue)
		{
			foreach($elementonecollectionvalue as $elementonecollectionvaluekey => $elementonecollectionvaluevalue)
			{
				//echo "<pre>"; print_r($elementonecollectionvalue);
				//echo "<br />".$elementonecollectionvaluekey."  ".$elementonecollectionvaluevalue;
				if($elementonecollectionvaluekey == "field")
				{
					$fieldname = $elementonecollectionvaluevalue;
				}
				else if($elementonecollectionvaluekey == "value")
				{
					$contactsdefaultconfigdata[$fieldname] = $elementonecollectionvaluevalue;
				}
			}
			//echo "<br />".$elementonecollectionkey."  ".$elementonecollectionvalue;
			//$contactsdefaultconfigdata[''] = $elementonecollection1['value'];
		}
		//echo "<pre>"; print_r($contactsdefaultconfigdata);
		//exit;


		$defaultconfigarr = array(''=>'Please Select','enable'=>'Enable','disable'=>'Disable');
			$str = $str . '<tr style="display: table-row;">';
				$str = $str . '<td class="label"><label for="default_config">Default Config:</label></td>';
      			$str = $str . '<td class="value">';
      				$str = $str . '<select id="contacts_default_config" name="evolved_form_contacts[contacts_default_config]" onChange="contactsdefaultconfig_fn(this.value);" >';
      					foreach($defaultconfigarr as $defaultconfigarrkey => $defaultconfigarrvalue)
      					{
      						if($contactsdefaultconfigdata['contacts_default_config']==$defaultconfigarrkey)
      						{
      							$str = $str . '<option value='.$defaultconfigarrkey.' selected>'.$defaultconfigarrvalue.'</option>';
      						}
      						else
      						{
      							$str = $str . '<option value='.$defaultconfigarrkey.'>'.$defaultconfigarrvalue.'</option>';
      						}
      					}
      				$str = $str . '</select>';
      			$str = $str . '</td>';
			$str = $str . '</tr>'; 

			$str = $str . '<tr style="display: table-row;">';
				$str = $str . '<td class="label"><label for="page_meta_title">Page Meta Title:</label></td>';
				$str = $str . '<td class="value">';
					$str = $str . '<input type="text" class=" input-text" value="'.$contactsdefaultconfigdata['contacts_title'].'" name="evolved_form_contacts[contacts_title]" id="contacts_title">';
				$str = $str . '</td>';
			$str = $str . '</tr>';
			
			$str = $str . '<tr style="display: table-row;">';
				$str = $str . '<td class="label"><label for="contacts_meta_description">Page Meta Description:</label></td>';
				$str = $str . '<td class="value">';
					$str = $str . '<input type="text" class=" input-text" value="'.$contactsdefaultconfigdata['contacts_meta_description'].'" name="evolved_form_contacts[contacts_meta_description]" id="contacts_meta_description">';
				$str = $str . '</td>';
			$str = $str . '</tr>';
				if($contactsdefaultconfigdata['contacts_default_config'] == "disable")
				{
					$str = $str . '<tr class="contacts_default_config_editor" style="display:table-row;">';
				}
				else
				{
					$str = $str . '<tr class="contacts_default_config_editor" style="display:none;">';
				}
      			$str = $str . '<td class="label"><label for="contacts_default_config_editor">Content:</label></td>';
      			//$str = $str . '<td class="value"><div id="buttonscontacts_default_config_editor" class="buttons-set"><button type="button" class="scalable show-hide" style="" id="togglecontacts_default_config_editor"><span><span><span>Show / Hide Editor</span></span></span></button><button type="button" class="scalable add-widget plugin" onclick="widgetTools.openDialog('.$baseurl.'evolved/widget/index/widget_target_id/contacts_default_config_editor)" style=""><span><span><span>Insert Widget...</span></span></span></button><button type="button" class="scalable add-image plugin" onclick="MediabrowserUtility.openDialog('.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/contacts_default_config_editor/)" style=""><span><span><span>Insert Image...</span></span></span></button><button type="button" class="scalable add-variable plugin" onclick="MagentovariablePlugin.loadChooser('.$baseurl.'evolved/system_variable/wysiwygPlugin/, contacts_default_config_editor);"><span><span><span>Insert Variable...</span></span></span></button></div><textarea name="contacts_default_config_editor" title="" id="contacts_default_config_editor" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['contacts_default_config_editor'].'</textarea><small>Image size must be 1920*480 pixels</small></td>';
      			$str = $str . '<td class="value"><button id="togglecontacts_default_config_editor" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><div id="buttonscontacts_default_config_editor" class="buttons-set"><button style="" onclick="MediabrowserUtility.openDialog(\''.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/contacts_default_config_editor/\')" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button></div><textarea name="evolved_form_contacts[contacts_default_config_editor]" title="" id="contacts_default_config_editor" class="textarea "  rows="2" cols="15">'.$contactsdefaultconfigdata['contacts_default_config_editor'].'</textarea></td>';
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
      				$str = $str . '}wysiwygcontacts_default_config_editor = new tinyMceWysiwygSetup("contacts_default_config_editor", {"enabled":true,"hidden":true,"use_container":false,"add_variables":true,"add_widgets":true,"add_images":true,"no_display":false,"translator":{},"encode_directives":true,"directives_url":"'.$baseurl.'evolved/cms_wysiwyg/directive/","popup_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/dialog.css","content_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/content.css","width":"100%","plugins":[{"name":"magentovariable","src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentovariable/editor_plugin.js","options":{"title":"Insert Variable...","url":"'.$baseurl.'evolved/system_variable/wysiwygPlugin/","onclick":{"search":["html_id"],"subject":"MagentovariablePlugin.loadChooser(\''.$baseurl.'evolved/system_variable/wysiwygPlugin/\', \'{{html_id}}\');"},"class":"add-variable plugin"}}],"directives_url_quoted":"'.$baseurl.'evolved/cms_wysiwyg/directive/","files_browser_window_url":"'.$baseurl.'idealAdmin/cms_wysiwyg_images/index/","files_browser_window_width":1000,"files_browser_window_height":600,"widget_plugin_src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentowidget/editor_plugin.js","widget_images_url":"'.$siteurl.'skin/adminhtml/default/default/images/widget/","widget_placeholders":["Thumbs.db","catalog__category_widget_link.gif","catalog__product_widget_link.gif","catalog__product_widget_new.gif","cms__widget_block.gif","cms__widget_page_link.gif","default.gif","reports__product_widget_compared.gif","reports__product_widget_viewed.gif"],"widget_window_url":"'.$baseurl.'evolved/widget/index/","firebug_warning_title":"Warning","firebug_warning_text":"Firebug is known to make the WYSIWYG editor slow unless it is turned off or configured properly.","firebug_warning_anchor":"Hide"});';
      				$str = $str . 'editorFormValidationHandler = wysiwygcontacts_default_config_editor.onFormValidation.bind(wysiwygcontacts_default_config_editor);';
      				$str = $str . 'Event.observe("togglecontacts_default_config_editor", "click", wysiwygcontacts_default_config_editor.toggle.bind(wysiwygcontacts_default_config_editor));';
      				$str = $str . 'varienGlobalEvents.attachEventHandler("formSubmit", editorFormValidationHandler);';
      				$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceBeforeSetContent", wysiwygcontacts_default_config_editor.beforeSetContent.bind(wysiwygcontacts_default_config_editor));';
      				$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceSaveContent", wysiwygcontacts_default_config_editor.saveContent.bind(wysiwygcontacts_default_config_editor));';
      				$str = $str . 'varienGlobalEvents.clearEventHandlers("open_browser_callback");';
      				$str = $str . 'varienGlobalEvents.attachEventHandler("open_browser_callback", wysiwygcontacts_default_config_editor.openFileBrowser.bind(wysiwygcontacts_default_config_editor));';
      				$str = $str . '</script>';
      		$str = $str . '</tr>';
      		
      		if($contactsdefaultconfigdata['contacts_default_config'] != "disable")
      		{
      			$str = $str . '<tr class="contacts_content_address" style="display:table-row;">';
      		}
      		else
      		{
      			$str = $str . '<tr class="contacts_content_address" style="display:none;">';
      		}
      		$str = $str . '<td class="label"><label for="contacts_content_address">Contact Addresses:</label></td>';
      		//$str = $str . '<td class="value"><div id="buttonscontacts_content_address" class="buttons-set"><button type="button" class="scalable show-hide" style="" id="togglecontacts_content_address"><span><span><span>Show / Hide Editor</span></span></span></button><button type="button" class="scalable add-widget plugin" onclick="widgetTools.openDialog('.$baseurl.'evolved/widget/index/widget_target_id/contacts_content_address)" style=""><span><span><span>Insert Widget...</span></span></span></button><button type="button" class="scalable add-image plugin" onclick="MediabrowserUtility.openDialog('.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/contacts_content_address/)" style=""><span><span><span>Insert Image...</span></span></span></button><button type="button" class="scalable add-variable plugin" onclick="MagentovariablePlugin.loadChooser('.$baseurl.'evolved/system_variable/wysiwygPlugin/, contacts_content_address);"><span><span><span>Insert Variable...</span></span></span></button></div><textarea name="contacts_content_address" title="" id="contacts_content_address" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['contacts_content_address'].'</textarea><small>Image size must be 1920*480 pixels</small></td>';
      		$str = $str . '<td class="value"><button id="togglecontacts_content_address" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><div id="buttonscontacts_content_address" class="buttons-set"><button style="" onclick="MediabrowserUtility.openDialog(\''.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/contacts_content_address/\')" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button></div><textarea name="evolved_form_contacts[contacts_content_address]" title="" id="contacts_content_address" class="textarea "  rows="2" cols="15">'.$contactsdefaultconfigdata['contacts_content_address'].'</textarea></td>';
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
      		$str = $str . '}wysiwygcontacts_content_address = new tinyMceWysiwygSetup("contacts_content_address", {"enabled":true,"hidden":true,"use_container":false,"add_variables":true,"add_widgets":true,"add_images":true,"no_display":false,"translator":{},"encode_directives":true,"directives_url":"'.$baseurl.'evolved/cms_wysiwyg/directive/","popup_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/dialog.css","content_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/content.css","width":"100%","plugins":[{"name":"magentovariable","src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentovariable/editor_plugin.js","options":{"title":"Insert Variable...","url":"'.$baseurl.'evolved/system_variable/wysiwygPlugin/","onclick":{"search":["html_id"],"subject":"MagentovariablePlugin.loadChooser(\''.$baseurl.'evolved/system_variable/wysiwygPlugin/\', \'{{html_id}}\');"},"class":"add-variable plugin"}}],"directives_url_quoted":"'.$baseurl.'evolved/cms_wysiwyg/directive/","files_browser_window_url":"'.$baseurl.'idealAdmin/cms_wysiwyg_images/index/","files_browser_window_width":1000,"files_browser_window_height":600,"widget_plugin_src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentowidget/editor_plugin.js","widget_images_url":"'.$siteurl.'skin/adminhtml/default/default/images/widget/","widget_placeholders":["Thumbs.db","catalog__category_widget_link.gif","catalog__product_widget_link.gif","catalog__product_widget_new.gif","cms__widget_block.gif","cms__widget_page_link.gif","default.gif","reports__product_widget_compared.gif","reports__product_widget_viewed.gif"],"widget_window_url":"'.$baseurl.'evolved/widget/index/","firebug_warning_title":"Warning","firebug_warning_text":"Firebug is known to make the WYSIWYG editor slow unless it is turned off or configured properly.","firebug_warning_anchor":"Hide"});';
      		$str = $str . 'editorFormValidationHandler = wysiwygcontacts_content_address.onFormValidation.bind(wysiwygcontacts_content_address);';
      		$str = $str . 'Event.observe("togglecontacts_content_address", "click", wysiwygcontacts_content_address.toggle.bind(wysiwygcontacts_content_address));';
      		$str = $str . 'varienGlobalEvents.attachEventHandler("formSubmit", editorFormValidationHandler);';
      		$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceBeforeSetContent", wysiwygcontacts_content_address.beforeSetContent.bind(wysiwygcontacts_content_address));';
      		$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceSaveContent", wysiwygcontacts_content_address.saveContent.bind(wysiwygcontacts_content_address));';
      		$str = $str . 'varienGlobalEvents.clearEventHandlers("open_browser_callback");';
      		$str = $str . 'varienGlobalEvents.attachEventHandler("open_browser_callback", wysiwygcontacts_content_address.openFileBrowser.bind(wysiwygcontacts_content_address));';
      		$str = $str . '</script>';
      		$str = $str . '</tr>';
      		
      		if($contactsdefaultconfigdata['contacts_default_config'] != "disable")
      		{
      			$str = $str . '<tr class="contacts_content_address_map" style="display:table-row;">';
      		}
      		else
      		{
      			$str = $str . '<tr class="contacts_content_address_map" style="display:none;">';
      		}
      		$str = $str . '<td class="label"><label for="contacts_content_address_map">Contact Map (iFrame):</label></td>';
      		//$str = $str . '<td class="value"><div id="buttonscontacts_content_address_map" class="buttons-set"><button type="button" class="scalable show-hide" style="" id="togglecontacts_content_address_map"><span><span><span>Show / Hide Editor</span></span></span></button><button type="button" class="scalable add-widget plugin" onclick="widgetTools.openDialog('.$baseurl.'evolved/widget/index/widget_target_id/contacts_content_address_map)" style=""><span><span><span>Insert Widget...</span></span></span></button><button type="button" class="scalable add-image plugin" onclick="MediabrowserUtility.openDialog('.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/contacts_content_address_map/)" style=""><span><span><span>Insert Image...</span></span></span></button><button type="button" class="scalable add-variable plugin" onclick="MagentovariablePlugin.loadChooser('.$baseurl.'evolved/system_variable/wysiwygPlugin/, contacts_content_address_map);"><span><span><span>Insert Variable...</span></span></span></button></div><textarea name="contacts_content_address_map" title="" id="contacts_content_address_map" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['contacts_content_address_map'].'</textarea><small>Image size must be 1920*480 pixels</small></td>';
      		$str = $str . '<td class="value"><button id="togglecontacts_content_address_map" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><div id="buttonscontacts_content_address_map" class="buttons-set"><button style="" onclick="MediabrowserUtility.openDialog(\''.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/contacts_content_address_map/\')" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button></div><textarea name="evolved_form_contacts[contacts_content_address_map]" title="" id="contacts_content_address_map" class="textarea "  rows="2" cols="15">'.$contactsdefaultconfigdata['contacts_content_address_map'].'</textarea></td>';
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
      		$str = $str . '}wysiwygcontacts_content_address_map = new tinyMceWysiwygSetup("contacts_content_address_map", {"enabled":true,"hidden":true,"use_container":false,"add_variables":true,"add_widgets":true,"add_images":true,"no_display":false,"translator":{},"encode_directives":true,"directives_url":"'.$baseurl.'evolved/cms_wysiwyg/directive/","popup_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/dialog.css","content_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/content.css","width":"100%","plugins":[{"name":"magentovariable","src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentovariable/editor_plugin.js","options":{"title":"Insert Variable...","url":"'.$baseurl.'evolved/system_variable/wysiwygPlugin/","onclick":{"search":["html_id"],"subject":"MagentovariablePlugin.loadChooser(\''.$baseurl.'evolved/system_variable/wysiwygPlugin/\', \'{{html_id}}\');"},"class":"add-variable plugin"}}],"directives_url_quoted":"'.$baseurl.'evolved/cms_wysiwyg/directive/","files_browser_window_url":"'.$baseurl.'idealAdmin/cms_wysiwyg_images/index/","files_browser_window_width":1000,"files_browser_window_height":600,"widget_plugin_src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentowidget/editor_plugin.js","widget_images_url":"'.$siteurl.'skin/adminhtml/default/default/images/widget/","widget_placeholders":["Thumbs.db","catalog__category_widget_link.gif","catalog__product_widget_link.gif","catalog__product_widget_new.gif","cms__widget_block.gif","cms__widget_page_link.gif","default.gif","reports__product_widget_compared.gif","reports__product_widget_viewed.gif"],"widget_window_url":"'.$baseurl.'evolved/widget/index/","firebug_warning_title":"Warning","firebug_warning_text":"Firebug is known to make the WYSIWYG editor slow unless it is turned off or configured properly.","firebug_warning_anchor":"Hide"});';
      		$str = $str . 'editorFormValidationHandler = wysiwygcontacts_content_address_map.onFormValidation.bind(wysiwygcontacts_content_address_map);';
      		$str = $str . 'Event.observe("togglecontacts_content_address_map", "click", wysiwygcontacts_content_address_map.toggle.bind(wysiwygcontacts_content_address_map));';
      		$str = $str . 'varienGlobalEvents.attachEventHandler("formSubmit", editorFormValidationHandler);';
      		$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceBeforeSetContent", wysiwygcontacts_content_address_map.beforeSetContent.bind(wysiwygcontacts_content_address_map));';
      		$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceSaveContent", wysiwygcontacts_content_address_map.saveContent.bind(wysiwygcontacts_content_address_map));';
      		$str = $str . 'varienGlobalEvents.clearEventHandlers("open_browser_callback");';
      		$str = $str . 'varienGlobalEvents.attachEventHandler("open_browser_callback", wysiwygcontacts_content_address_map.openFileBrowser.bind(wysiwygcontacts_content_address_map));';
      		$str = $str . '</script>';
      		$str = $str . '</tr>';
      		
		return $str;
	}
}
?>