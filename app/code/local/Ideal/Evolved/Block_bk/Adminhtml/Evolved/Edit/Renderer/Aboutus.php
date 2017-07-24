<?php
class Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Aboutus extends Varien_Data_Form_Element_Text
{
	public function getHtml()
	{
    	$baseurl = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB);
		$siteurl = str_replace("/index.php/","/",$baseurl);
		$elementonemodel = Mage::getModel('evolved/evolved');
		$elementaboutuscollection = $elementonemodel->getCollection();
		$elementaboutuscollection->addFieldToFilter('field', array('like' => 'aboutus_element_style'));
		foreach($elementaboutuscollection as $elementaboutuscollection1)
		{
			$selectElement = $elementaboutuscollection1['value'];
			//$selectElement = $elementaboutuscollection1['field'];
		}
		
		$aboutuselementmodeldata = Mage::getModel('evolved/evolved');
		$aboutuselementcollectiondata = $aboutuselementmodeldata->getCollection();
		$aboutuselementcollectiondata->addFieldToFilter('field', array('like' => 'aboutus_element_style_%'));
		foreach ($aboutuselementcollectiondata as $aboutuselementcollectiondata1)
		{
			//    		echo $collection_arr['field']."   value: ".$collection_arr['value']."<br />";
			$collectiondata[$aboutuselementcollectiondata1['field']] = $aboutuselementcollectiondata1['value'];
		}
		//echo "<pre>"; print_r($collectiondata); echo "</pre>";
		
		//return $selectElement;
//		if($selectElement == "aboutus_element_style_one_one_column")
		{
			$str = ($selectElement == "aboutus_element_style_one_one_column") ? '<table cellspacing="0" class="form-list aboutusmaintable" id="aboutus_element_style_one_one_column" style="display: block;">' : '<table cellspacing="0" class="form-list aboutusmaintable" id="aboutus_element_style_one_one_column" style="display: none;">';
			//$str = '<table cellspacing="0" class="form-list">';
				$str .= '<tbody>';
					$str .= '<tr>';
						$str .= '<td class="label"><label for="aboutus_element_style_one_page_title">Page Title:</label></td>';
						$str .= '<td class="value">';
						$str .= '<input type="text" id="aboutus_element_style_one_page_title" name="aboutus_element_style_one_page_title" value="'.$collectiondata['aboutus_element_style_one_page_title'].'" class=" input-text">';
						$str .= '</td>';
					$str .= '</tr>';
					$str .= '<tr>';
						$str .= '<td class="label"><label for="aboutus_element_style_one_page_sub_title">Page Sub-Title:</label></td>';
						$str .= '<td class="value">';
						$str .= '<input type="text" id="aboutus_element_style_one_page_sub_title" name="aboutus_element_style_one_page_sub_title" value="'.$collectiondata['aboutus_element_style_one_page_sub_title'].'" class=" input-text">';
						$str .= '</td>';
					$str .= '</tr>';
					$str .= '<tr>';
						$str .= '<td class="label"><label for="aboutus_element_style_one_upload_banner">Upload Banner:</label></td>';
						$str .= '<td class="value">';
						if($collectiondata['aboutus_element_style_one_upload_banner'])
						{
							$str .= '<a href="/media/'.$collectiondata['aboutus_element_style_one_upload_banner'].'" onclick="imagePreview(\'aboutus_element_style_one_upload_banner\'); return false;"><img width="22" height="22" src="/media/'.$collectiondata['aboutus_element_style_one_upload_banner'].'" id="aboutus_element_style_one_upload_banner" title="'.$collectiondata['aboutus_element_style_one_upload_banner'].'" alt="'.$collectiondata['aboutus_element_style_one_upload_banner'].'" class="small-image-preview v-middle"></a>';
						}
						$str .= '<input type="file" class="input-file" value="'.$collectiondata['aboutus_element_style_one_upload_banner'].'" name="aboutus_element_style_one_upload_banner" id="aboutus_element_style_one_upload_banner">';
						$str .= '</td>';
					$str .= '</tr>';
					$str .= '<tr>';
						$str .= '<td class="label"><label for="aboutus_element_style_one_current_banner">Current Banner:</label></td>';
						$str .= '<td class="value">';
						$str .= '<img src="'."/media/".$collectiondata['aboutus_element_style_one_upload_banner'].'" name="aboutus_element_style_one_current_banner" id="aboutus_element_style_one_current_banner" width="300px" height="100px" />';
						$str .= '</td>';
					$str .= '</tr>';
					$str .= '<tr>';
						$str .= '<td class="label"><label for="aboutus_element_style_one_insert_editor">Insert text/image:</label></td>';
						//$str .= '<td class="value"><div id="buttonsaboutus_element_style_one_insert_editor" class="buttons-set"><button type="button" class="scalable show-hide" style="" id="toggleaboutus_element_style_one_insert_editor"><span><span><span>Show / Hide Editor</span></span></span></button><button type="button" class="scalable add-widget plugin" onclick="widgetTools.openDialog('.$baseurl.'evolved/widget/index/widget_target_id/aboutus_element_style_one_insert_editor)" style=""><span><span><span>Insert Widget...</span></span></span></button><button type="button" class="scalable add-image plugin" onclick="MediabrowserUtility.openDialog('.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/aboutus_element_style_one_insert_editor/)" style=""><span><span><span>Insert Image...</span></span></span></button><button type="button" class="scalable add-variable plugin" onclick="MagentovariablePlugin.loadChooser('.$baseurl.'evolved/system_variable/wysiwygPlugin/, aboutus_element_style_one_insert_editor);"><span><span><span>Insert Variable...</span></span></span></button></div><textarea name="aboutus_element_style_one_insert_editor" title="" id="aboutus_element_style_one_insert_editor" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['aboutus_element_style_one_insert_editor'].'</textarea><small>*Maximum image width is 1050px </small></td>';
						$str .= '<td class="value"><button id="toggleaboutus_element_style_one_insert_editor" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><div id="buttonsaboutus_element_style_one_insert_editor" class="buttons-set"><button style="" onclick="MediabrowserUtility.openDialog(\''.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/aboutus_element_style_one_insert_editor/\')" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button></div><small class="imagelabelrequire">*Maximum image width is 1050px </small><textarea name="aboutus_element_style_one_insert_editor" title="" id="aboutus_element_style_one_insert_editor" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['aboutus_element_style_one_insert_editor'].'</textarea></td>';
						$str .= '<script type="text/javascript">
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
						$str .= '<script type="text/javascript">';
						$str .= 'if ("undefined" != typeof(Translator)) {';
						$str .= 'Translator.add({"Insert Image...":"Insert Image...","Insert Media...":"Insert Media...","Insert File...":"Insert File..."});';
						$str .= '}wysiwygaboutus_element_style_one_insert_editor = new tinyMceWysiwygSetup("aboutus_element_style_one_insert_editor", {"enabled":true,"hidden":true,"use_container":false,"add_variables":true,"add_widgets":true,"add_images":true,"no_display":false,"translator":{},"encode_directives":true,"directives_url":"'.$baseurl.'evolved/cms_wysiwyg/directive/","popup_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/dialog.css","content_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/content.css","width":"100%","plugins":[{"name":"magentovariable","src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentovariable/editor_plugin.js","options":{"title":"Insert Variable...","url":"'.$baseurl.'evolved/system_variable/wysiwygPlugin/","onclick":{"search":["html_id"],"subject":"MagentovariablePlugin.loadChooser(\''.$baseurl.'evolved/system_variable/wysiwygPlugin/\', \'{{html_id}}\');"},"class":"add-variable plugin"}}],"directives_url_quoted":"'.$baseurl.'evolved/cms_wysiwyg/directive/","files_browser_window_url":"'.$baseurl.'idealAdmin/cms_wysiwyg_images/index/","files_browser_window_width":1000,"files_browser_window_height":600,"widget_plugin_src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentowidget/editor_plugin.js","widget_images_url":"'.$siteurl.'skin/adminhtml/default/default/images/widget/","widget_placeholders":["Thumbs.db","catalog__category_widget_link.gif","catalog__product_widget_link.gif","catalog__product_widget_new.gif","cms__widget_block.gif","cms__widget_page_link.gif","default.gif","reports__product_widget_compared.gif","reports__product_widget_viewed.gif"],"widget_window_url":"'.$baseurl.'evolved/widget/index/","firebug_warning_title":"Warning","firebug_warning_text":"Firebug is known to make the WYSIWYG editor slow unless it is turned off or configured properly.","firebug_warning_anchor":"Hide"});';
						$str .= 'editorFormValidationHandler = wysiwygaboutus_element_style_one_insert_editor.onFormValidation.bind(wysiwygaboutus_element_style_one_insert_editor);';
						$str .= 'Event.observe("toggleaboutus_element_style_one_insert_editor", "click", wysiwygaboutus_element_style_one_insert_editor.toggle.bind(wysiwygaboutus_element_style_one_insert_editor));';
						$str .= 'varienGlobalEvents.attachEventHandler("formSubmit", editorFormValidationHandler);';
						$str .= 'varienGlobalEvents.attachEventHandler("tinymceBeforeSetContent", wysiwygaboutus_element_style_one_insert_editor.beforeSetContent.bind(wysiwygaboutus_element_style_one_insert_editor));';
						$str .= 'varienGlobalEvents.attachEventHandler("tinymceSaveContent", wysiwygaboutus_element_style_one_insert_editor.saveContent.bind(wysiwygaboutus_element_style_one_insert_editor));';
						$str .= 'varienGlobalEvents.clearEventHandlers("open_browser_callback");';
						$str .= 'varienGlobalEvents.attachEventHandler("open_browser_callback", wysiwygaboutus_element_style_one_insert_editor.openFileBrowser.bind(wysiwygaboutus_element_style_one_insert_editor));';
						$str .= '</script>';
					$str .= '</tr>';
				$str .= '</tbody>';
			$str .= '</table>';
		}
	//	elseif($selectElement == "aboutus_element_style_two_two_column_with_50_by_50")
		{
			$str .= ($selectElement == "aboutus_element_style_two_two_column_with_50_by_50") ? '<table cellspacing="0" class="form-list aboutusmaintable" id="aboutus_element_style_two_two_column_with_50_by_50" style="display: block;">' : '<table cellspacing="0" class="form-list aboutusmaintable" id="aboutus_element_style_two_two_column_with_50_by_50" style="display: none;">';
			//$str .= '<table cellspacing="0" class="form-list">';
				$str .= '<tbody>';
					$str .= '<tr>';
						$str .= '<td>';
							$str .= '<table cellspacing="0" class="form-list">';
								$str .= '<tbody>';
									$str .= '<tr>';
										$str .= '<td class="label"><label for="aboutus_element_style_two_page_title">Page Title:</label></td>';
										$str .= '<td class="value">';
										$str .= '<input type="text" id="aboutus_element_style_two_page_title" name="aboutus_element_style_two_page_title" value="'.$collectiondata['aboutus_element_style_two_page_title'].'" class=" input-text">';
										$str .= '</td>';
									$str .= '</tr>';
									$str .= '<tr>';
										$str .= '<td class="label"><label for="aboutus_element_style_two_page_sub_title">Page Sub-Title:</label></td>';
										$str .= '<td class="value">';
										$str .= '<input type="text" id="aboutus_element_style_two_page_sub_title" name="aboutus_element_style_two_page_sub_title" value="'.$collectiondata['aboutus_element_style_two_page_sub_title'].'" class=" input-text">';
										$str .= '</td>';
									$str .= '</tr>';
									$str .= '<tr>';
										$str .= '<td class="label"><label for="aboutus_element_style_two_upload_banner">Upload Banner:</label></td>';
										$str .= '<td class="value">';
										if($collectiondata['aboutus_element_style_two_upload_banner'])
										{
											$str .= '<a href="/media/'.$collectiondata['aboutus_element_style_two_upload_banner'].'" onclick="imagePreview(\'aboutus_element_style_two_upload_banner\'); return false;"><img width="22" height="22" src="/media/'.$collectiondata['aboutus_element_style_two_upload_banner'].'" id="aboutus_element_style_two_upload_banner" title="'.$collectiondata['aboutus_element_style_two_upload_banner'].'" alt="'.$collectiondata['aboutus_element_style_two_upload_banner'].'" class="small-image-preview v-middle"></a>';
										}
										$str .= '<input type="file" class="input-file" value="'.$collectiondata['aboutus_element_style_two_upload_banner'].'" name="aboutus_element_style_two_upload_banner" id="aboutus_element_style_two_upload_banner">';
										$str .= '</td>';
									$str .= '</tr>';
									$str .= '<tr>';
										$str .= '<td class="label"><label for="aboutus_element_style_two_current_banner">Current Banner:</label></td>';
										$str .= '<td class="value">';
										$str .= '<img src="'."/media/".$collectiondata['aboutus_element_style_two_upload_banner'].'" name="aboutus_element_style_two_current_banner" id="aboutus_element_style_two_current_banner" width="300px" height="100px" />';
										$str .= '</td>';
									$str .= '</tr>';
								$str .= '</tbody>';
							$str .= '</table>';
						$str .= '</td>';
					$str .= '</tr>';
					$str .= '<tr>';
						$str .= '<td>';
							$str .= '<table cellspacing="0" class="form-list aboutus_element_style_two_table_image">';
								$str .= '<tbody>';
									$str .= '<tr>';
										$str .= '<td class="label"><label for="aboutus_element_style_two_left_insert_editor">Insert text/image:</label></td>';
										//$str .= '<td class="value"><div id="buttonsaboutus_element_style_two_left_insert_editor" class="buttons-set"><button type="button" class="scalable show-hide" style="" id="toggleaboutus_element_style_two_left_insert_editor"><span><span><span>Show / Hide Editor</span></span></span></button><button type="button" class="scalable add-widget plugin" onclick="widgetTools.openDialog('.$baseurl.'evolved/widget/index/widget_target_id/aboutus_element_style_two_left_insert_editor)" style=""><span><span><span>Insert Widget...</span></span></span></button><button type="button" class="scalable add-image plugin" onclick="MediabrowserUtility.openDialog('.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/aboutus_element_style_two_left_insert_editor/)" style=""><span><span><span>Insert Image...</span></span></span></button><button type="button" class="scalable add-variable plugin" onclick="MagentovariablePlugin.loadChooser('.$baseurl.'evolved/system_variable/wysiwygPlugin/, aboutus_element_style_two_left_insert_editor);"><span><span><span>Insert Variable...</span></span></span></button></div><textarea name="aboutus_element_style_two_left_insert_editor" title="" id="aboutus_element_style_two_left_insert_editor" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['aboutus_element_style_two_left_insert_editor'].'</textarea><small>*Maximum image width is 1050px </small></td>';
										$str .= '<td class="value"><button id="toggleaboutus_element_style_two_left_insert_editor" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><div id="buttonsaboutus_element_style_two_left_insert_editor" class="buttons-set"><button style="" onclick="MediabrowserUtility.openDialog(\''.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/aboutus_element_style_two_left_insert_editor/\')" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button></div><small class="imagelabelrequire">*Maximum image width is 510px </small><textarea name="aboutus_element_style_two_left_insert_editor" title="" id="aboutus_element_style_two_left_insert_editor" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['aboutus_element_style_two_left_insert_editor'].'</textarea></td>';
										$str .= '<script type="text/javascript">
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
										$str .= '<script type="text/javascript">';
										$str .= 'if ("undefined" != typeof(Translator)) {';
										$str .= 'Translator.add({"Insert Image...":"Insert Image...","Insert Media...":"Insert Media...","Insert File...":"Insert File..."});';
										$str .= '}wysiwygaboutus_element_style_two_left_insert_editor = new tinyMceWysiwygSetup("aboutus_element_style_two_left_insert_editor", {"enabled":true,"hidden":true,"use_container":false,"add_variables":true,"add_widgets":true,"add_images":true,"no_display":false,"translator":{},"encode_directives":true,"directives_url":"'.$baseurl.'evolved/cms_wysiwyg/directive/","popup_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/dialog.css","content_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/content.css","width":"100%","plugins":[{"name":"magentovariable","src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentovariable/editor_plugin.js","options":{"title":"Insert Variable...","url":"'.$baseurl.'evolved/system_variable/wysiwygPlugin/","onclick":{"search":["html_id"],"subject":"MagentovariablePlugin.loadChooser(\''.$baseurl.'evolved/system_variable/wysiwygPlugin/\', \'{{html_id}}\');"},"class":"add-variable plugin"}}],"directives_url_quoted":"'.$baseurl.'evolved/cms_wysiwyg/directive/","files_browser_window_url":"'.$baseurl.'idealAdmin/cms_wysiwyg_images/index/","files_browser_window_width":1000,"files_browser_window_height":600,"widget_plugin_src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentowidget/editor_plugin.js","widget_images_url":"'.$siteurl.'skin/adminhtml/default/default/images/widget/","widget_placeholders":["Thumbs.db","catalog__category_widget_link.gif","catalog__product_widget_link.gif","catalog__product_widget_new.gif","cms__widget_block.gif","cms__widget_page_link.gif","default.gif","reports__product_widget_compared.gif","reports__product_widget_viewed.gif"],"widget_window_url":"'.$baseurl.'evolved/widget/index/","firebug_warning_title":"Warning","firebug_warning_text":"Firebug is known to make the WYSIWYG editor slow unless it is turned off or configured properly.","firebug_warning_anchor":"Hide"});';
										$str .= 'editorFormValidationHandler = wysiwygaboutus_element_style_two_left_insert_editor.onFormValidation.bind(wysiwygaboutus_element_style_two_left_insert_editor);';
										$str .= 'Event.observe("toggleaboutus_element_style_two_left_insert_editor", "click", wysiwygaboutus_element_style_two_left_insert_editor.toggle.bind(wysiwygaboutus_element_style_two_left_insert_editor));';
										$str .= 'varienGlobalEvents.attachEventHandler("formSubmit", editorFormValidationHandler);';
										$str .= 'varienGlobalEvents.attachEventHandler("tinymceBeforeSetContent", wysiwygaboutus_element_style_two_left_insert_editor.beforeSetContent.bind(wysiwygaboutus_element_style_two_left_insert_editor));';
										$str .= 'varienGlobalEvents.attachEventHandler("tinymceSaveContent", wysiwygaboutus_element_style_two_left_insert_editor.saveContent.bind(wysiwygaboutus_element_style_two_left_insert_editor));';
										$str .= 'varienGlobalEvents.clearEventHandlers("open_browser_callback");';
										$str .= 'varienGlobalEvents.attachEventHandler("open_browser_callback", wysiwygaboutus_element_style_two_left_insert_editor.openFileBrowser.bind(wysiwygaboutus_element_style_two_left_insert_editor));';
										$str .= '</script>';
									$str .= '</tr>';
								$str .= '</tbody>';
							$str .= '</table>';
							$str .= '<table cellspacing="0" class="form-list aboutus_element_style_two_table_image">';
								$str .= '<tbody>';
									$str .= '<tr>';
										$str .= '<td class="label"><label for="aboutus_element_style_two_right_insert_editor">Insert text/image:</label></td>';
										//$str .= '<td class="value"><div id="buttonsaboutus_element_style_two_right_insert_editor" class="buttons-set"><button type="button" class="scalable show-hide" style="" id="toggleaboutus_element_style_two_right_insert_editor"><span><span><span>Show / Hide Editor</span></span></span></button><button type="button" class="scalable add-widget plugin" onclick="widgetTools.openDialog('.$baseurl.'evolved/widget/index/widget_target_id/aboutus_element_style_two_right_insert_editor)" style=""><span><span><span>Insert Widget...</span></span></span></button><button type="button" class="scalable add-image plugin" onclick="MediabrowserUtility.openDialog('.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/aboutus_element_style_two_right_insert_editor/)" style=""><span><span><span>Insert Image...</span></span></span></button><button type="button" class="scalable add-variable plugin" onclick="MagentovariablePlugin.loadChooser('.$baseurl.'evolved/system_variable/wysiwygPlugin/, aboutus_element_style_two_right_insert_editor);"><span><span><span>Insert Variable...</span></span></span></button></div><textarea name="aboutus_element_style_two_right_insert_editor" title="" id="aboutus_element_style_two_right_insert_editor" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['aboutus_element_style_two_right_insert_editor'].'</textarea><small>*Maximum image width is 1050px </small></td>';
										$str .= '<td class="value"><button id="toggleaboutus_element_style_two_right_insert_editor" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><div id="buttonsaboutus_element_style_two_right_insert_editor" class="buttons-set"><button style="" onclick="MediabrowserUtility.openDialog(\''.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/aboutus_element_style_two_right_insert_editor/\')" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button></div><small class="imagelabelrequire">*Maximum image width is 510px </small><textarea name="aboutus_element_style_two_right_insert_editor" title="" id="aboutus_element_style_two_right_insert_editor" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['aboutus_element_style_two_right_insert_editor'].'</textarea></td>';
										$str .= '<script type="text/javascript">
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
										$str .= '<script type="text/javascript">';
										$str .= 'if ("undefined" != typeof(Translator)) {';
										$str .= 'Translator.add({"Insert Image...":"Insert Image...","Insert Media...":"Insert Media...","Insert File...":"Insert File..."});';
										$str .= '}wysiwygaboutus_element_style_two_right_insert_editor = new tinyMceWysiwygSetup("aboutus_element_style_two_right_insert_editor", {"enabled":true,"hidden":true,"use_container":false,"add_variables":true,"add_widgets":true,"add_images":true,"no_display":false,"translator":{},"encode_directives":true,"directives_url":"'.$baseurl.'evolved/cms_wysiwyg/directive/","popup_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/dialog.css","content_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/content.css","width":"100%","plugins":[{"name":"magentovariable","src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentovariable/editor_plugin.js","options":{"title":"Insert Variable...","url":"'.$baseurl.'evolved/system_variable/wysiwygPlugin/","onclick":{"search":["html_id"],"subject":"MagentovariablePlugin.loadChooser(\''.$baseurl.'evolved/system_variable/wysiwygPlugin/\', \'{{html_id}}\');"},"class":"add-variable plugin"}}],"directives_url_quoted":"'.$baseurl.'evolved/cms_wysiwyg/directive/","files_browser_window_url":"'.$baseurl.'idealAdmin/cms_wysiwyg_images/index/","files_browser_window_width":1000,"files_browser_window_height":600,"widget_plugin_src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentowidget/editor_plugin.js","widget_images_url":"'.$siteurl.'skin/adminhtml/default/default/images/widget/","widget_placeholders":["Thumbs.db","catalog__category_widget_link.gif","catalog__product_widget_link.gif","catalog__product_widget_new.gif","cms__widget_block.gif","cms__widget_page_link.gif","default.gif","reports__product_widget_compared.gif","reports__product_widget_viewed.gif"],"widget_window_url":"'.$baseurl.'evolved/widget/index/","firebug_warning_title":"Warning","firebug_warning_text":"Firebug is known to make the WYSIWYG editor slow unless it is turned off or configured properly.","firebug_warning_anchor":"Hide"});';
										$str .= 'editorFormValidationHandler = wysiwygaboutus_element_style_two_right_insert_editor.onFormValidation.bind(wysiwygaboutus_element_style_two_right_insert_editor);';
										$str .= 'Event.observe("toggleaboutus_element_style_two_right_insert_editor", "click", wysiwygaboutus_element_style_two_right_insert_editor.toggle.bind(wysiwygaboutus_element_style_two_right_insert_editor));';
										$str .= 'varienGlobalEvents.attachEventHandler("formSubmit", editorFormValidationHandler);';
										$str .= 'varienGlobalEvents.attachEventHandler("tinymceBeforeSetContent", wysiwygaboutus_element_style_two_right_insert_editor.beforeSetContent.bind(wysiwygaboutus_element_style_two_right_insert_editor));';
										$str .= 'varienGlobalEvents.attachEventHandler("tinymceSaveContent", wysiwygaboutus_element_style_two_right_insert_editor.saveContent.bind(wysiwygaboutus_element_style_two_right_insert_editor));';
										$str .= 'varienGlobalEvents.clearEventHandlers("open_browser_callback");';
										$str .= 'varienGlobalEvents.attachEventHandler("open_browser_callback", wysiwygaboutus_element_style_two_right_insert_editor.openFileBrowser.bind(wysiwygaboutus_element_style_two_right_insert_editor));';
										$str .= '</script>';
									$str .= '</tr>';
								$str .= '</tbody>';
							$str .= '</table>';
						$str .= '</td>';
					$str .= '</tr>';
				$str .= '</tbody>';
			$str .= '</table>';		
		}
		//elseif($selectElement == "aboutus_element_style_three_two_column_with_30_by_70")
		{
			$str .= ($selectElement == "aboutus_element_style_three_two_column_with_30_by_70") ? '<table cellspacing="0" class="form-list aboutusmaintable" id="aboutus_element_style_three_two_column_with_30_by_70" style="display: block;">' : '<table cellspacing="0" class="form-list aboutusmaintable" id="aboutus_element_style_three_two_column_with_30_by_70" style="display: none;">';
			//$str .= '<table cellspacing="0" class="form-list">';
			$str .= '<tbody>';
			$str .= '<tr>';
			$str .= '<td>';
			$str .= '<table cellspacing="0" class="form-list">';
			$str .= '<tbody>';
			$str .= '<tr>';
			$str .= '<td class="label"><label for="aboutus_element_style_three_page_title">Page Title:</label></td>';
			$str .= '<td class="value">';
			$str .= '<input type="text" id="aboutus_element_style_three_page_title" name="aboutus_element_style_three_page_title" value="'.$collectiondata['aboutus_element_style_three_page_title'].'" class=" input-text">';
			$str .= '</td>';
			$str .= '</tr>';
			$str .= '<tr>';
			$str .= '<td class="label"><label for="aboutus_element_style_three_page_sub_title">Page Sub-Title:</label></td>';
			$str .= '<td class="value">';
			$str .= '<input type="text" id="aboutus_element_style_three_page_sub_title" name="aboutus_element_style_three_page_sub_title" value="'.$collectiondata['aboutus_element_style_three_page_sub_title'].'" class=" input-text">';
			$str .= '</td>';
			$str .= '</tr>';
			$str .= '<tr>';
			$str .= '<td class="label"><label for="aboutus_element_style_three_upload_banner">Upload Banner:</label></td>';
			$str .= '<td class="value">';
			if($collectiondata['aboutus_element_style_three_upload_banner'])
			{
				$str .= '<a href="/media/'.$collectiondata['aboutus_element_style_three_upload_banner'].'" onclick="imagePreview(\'aboutus_element_style_three_upload_banner\'); return false;"><img width="22" height="22" src="/media/'.$collectiondata['aboutus_element_style_three_upload_banner'].'" id="aboutus_element_style_three_upload_banner" title="'.$collectiondata['aboutus_element_style_three_upload_banner'].'" alt="'.$collectiondata['aboutus_element_style_three_upload_banner'].'" class="small-image-preview v-middle"></a>';
			}
			$str .= '<input type="file" class="input-file" value="'.$collectiondata['aboutus_element_style_three_upload_banner'].'" name="aboutus_element_style_three_upload_banner" id="aboutus_element_style_three_upload_banner">';
			$str .= '</td>';
			$str .= '</tr>';
			$str .= '<tr>';
			$str .= '<td class="label"><label for="aboutus_element_style_three_current_banner">Current Banner:</label></td>';
			$str .= '<td class="value">';
			$str .= '<img src="'."/media/".$collectiondata['aboutus_element_style_three_upload_banner'].'" name="aboutus_element_style_three_current_banner" id="aboutus_element_style_three_current_banner" width="300px" height="100px" />';
			$str .= '</td>';
			$str .= '</tr>';
			$str .= '</tbody>';
			$str .= '</table>';
			$str .= '</td>';
			$str .= '</tr>';
			$str .= '<tr>';
			$str .= '<td>';
			$str .= '<table cellspacing="0" class="form-list aboutus_element_style_three_table_image">';
			$str .= '<tbody>';
			$str .= '<tr>';
			$str .= '<td class="label"><label for="aboutus_element_style_three_left_insert_editor">Insert text/image:</label></td>';
			//$str .= '<td class="value"><div id="buttonsaboutus_element_style_three_left_insert_editor" class="buttons-set"><button type="button" class="scalable show-hide" style="" id="toggleaboutus_element_style_three_left_insert_editor"><span><span><span>Show / Hide Editor</span></span></span></button><button type="button" class="scalable add-widget plugin" onclick="widgetTools.openDialog('.$baseurl.'evolved/widget/index/widget_target_id/aboutus_element_style_three_left_insert_editor)" style=""><span><span><span>Insert Widget...</span></span></span></button><button type="button" class="scalable add-image plugin" onclick="MediabrowserUtility.openDialog('.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/aboutus_element_style_three_left_insert_editor/)" style=""><span><span><span>Insert Image...</span></span></span></button><button type="button" class="scalable add-variable plugin" onclick="MagentovariablePlugin.loadChooser('.$baseurl.'evolved/system_variable/wysiwygPlugin/, aboutus_element_style_three_left_insert_editor);"><span><span><span>Insert Variable...</span></span></span></button></div><textarea name="aboutus_element_style_three_left_insert_editor" title="" id="aboutus_element_style_three_left_insert_editor" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['aboutus_element_style_three_left_insert_editor'].'</textarea><small>*Maximum image width is 1050px </small></td>';
			$str .= '<td class="value"><button id="toggleaboutus_element_style_three_left_insert_editor" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><div id="buttonsaboutus_element_style_three_left_insert_editor" class="buttons-set"><button style="" onclick="MediabrowserUtility.openDialog(\''.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/aboutus_element_style_three_left_insert_editor/\')" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button></div><small class="imagelabelrequire">*Maximum image width is 306px </small><textarea name="aboutus_element_style_three_left_insert_editor" title="" id="aboutus_element_style_three_left_insert_editor" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['aboutus_element_style_three_left_insert_editor'].'</textarea></td>';
			$str .= '<script type="text/javascript">
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
			$str .= '<script type="text/javascript">';
			$str .= 'if ("undefined" != typeof(Translator)) {';
			$str .= 'Translator.add({"Insert Image...":"Insert Image...","Insert Media...":"Insert Media...","Insert File...":"Insert File..."});';
			$str .= '}wysiwygaboutus_element_style_three_left_insert_editor = new tinyMceWysiwygSetup("aboutus_element_style_three_left_insert_editor", {"enabled":true,"hidden":true,"use_container":false,"add_variables":true,"add_widgets":true,"add_images":true,"no_display":false,"translator":{},"encode_directives":true,"directives_url":"'.$baseurl.'evolved/cms_wysiwyg/directive/","popup_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/dialog.css","content_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/content.css","width":"100%","plugins":[{"name":"magentovariable","src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentovariable/editor_plugin.js","options":{"title":"Insert Variable...","url":"'.$baseurl.'evolved/system_variable/wysiwygPlugin/","onclick":{"search":["html_id"],"subject":"MagentovariablePlugin.loadChooser(\''.$baseurl.'evolved/system_variable/wysiwygPlugin/\', \'{{html_id}}\');"},"class":"add-variable plugin"}}],"directives_url_quoted":"'.$baseurl.'evolved/cms_wysiwyg/directive/","files_browser_window_url":"'.$baseurl.'idealAdmin/cms_wysiwyg_images/index/","files_browser_window_width":1000,"files_browser_window_height":600,"widget_plugin_src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentowidget/editor_plugin.js","widget_images_url":"'.$siteurl.'skin/adminhtml/default/default/images/widget/","widget_placeholders":["Thumbs.db","catalog__category_widget_link.gif","catalog__product_widget_link.gif","catalog__product_widget_new.gif","cms__widget_block.gif","cms__widget_page_link.gif","default.gif","reports__product_widget_compared.gif","reports__product_widget_viewed.gif"],"widget_window_url":"'.$baseurl.'evolved/widget/index/","firebug_warning_title":"Warning","firebug_warning_text":"Firebug is known to make the WYSIWYG editor slow unless it is turned off or configured properly.","firebug_warning_anchor":"Hide"});';
			$str .= 'editorFormValidationHandler = wysiwygaboutus_element_style_three_left_insert_editor.onFormValidation.bind(wysiwygaboutus_element_style_three_left_insert_editor);';
			$str .= 'Event.observe("toggleaboutus_element_style_three_left_insert_editor", "click", wysiwygaboutus_element_style_three_left_insert_editor.toggle.bind(wysiwygaboutus_element_style_three_left_insert_editor));';
			$str .= 'varienGlobalEvents.attachEventHandler("formSubmit", editorFormValidationHandler);';
			$str .= 'varienGlobalEvents.attachEventHandler("tinymceBeforeSetContent", wysiwygaboutus_element_style_three_left_insert_editor.beforeSetContent.bind(wysiwygaboutus_element_style_three_left_insert_editor));';
			$str .= 'varienGlobalEvents.attachEventHandler("tinymceSaveContent", wysiwygaboutus_element_style_three_left_insert_editor.saveContent.bind(wysiwygaboutus_element_style_three_left_insert_editor));';
			$str .= 'varienGlobalEvents.clearEventHandlers("open_browser_callback");';
			$str .= 'varienGlobalEvents.attachEventHandler("open_browser_callback", wysiwygaboutus_element_style_three_left_insert_editor.openFileBrowser.bind(wysiwygaboutus_element_style_three_left_insert_editor));';
			$str .= '</script>';
			$str .= '</tr>';
			$str .= '</tbody>';
			$str .= '</table>';
			$str .= '<table cellspacing="0" class="form-list aboutus_element_style_three_table_image">';
			$str .= '<tbody>';
			$str .= '<tr>';
			$str .= '<td class="label"><label for="aboutus_element_style_three_right_insert_editor">Insert text/image:</label></td>';
			//$str .= '<td class="value"><div id="buttonsaboutus_element_style_three_right_insert_editor" class="buttons-set"><button type="button" class="scalable show-hide" style="" id="toggleaboutus_element_style_three_right_insert_editor"><span><span><span>Show / Hide Editor</span></span></span></button><button type="button" class="scalable add-widget plugin" onclick="widgetTools.openDialog('.$baseurl.'evolved/widget/index/widget_target_id/aboutus_element_style_three_right_insert_editor)" style=""><span><span><span>Insert Widget...</span></span></span></button><button type="button" class="scalable add-image plugin" onclick="MediabrowserUtility.openDialog('.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/aboutus_element_style_three_right_insert_editor/)" style=""><span><span><span>Insert Image...</span></span></span></button><button type="button" class="scalable add-variable plugin" onclick="MagentovariablePlugin.loadChooser('.$baseurl.'evolved/system_variable/wysiwygPlugin/, aboutus_element_style_three_right_insert_editor);"><span><span><span>Insert Variable...</span></span></span></button></div><textarea name="aboutus_element_style_three_right_insert_editor" title="" id="aboutus_element_style_three_right_insert_editor" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['aboutus_element_style_three_right_insert_editor'].'</textarea><small>*Maximum image width is 1050px </small></td>';
			$str .= '<td class="value"><button id="toggleaboutus_element_style_three_right_insert_editor" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><div id="buttonsaboutus_element_style_three_right_insert_editor" class="buttons-set"><button style="" onclick="MediabrowserUtility.openDialog(\''.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/aboutus_element_style_three_right_insert_editor/\')" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button></div><small class="imagelabelrequire">*Maximum image width is 714px </small><textarea name="aboutus_element_style_three_right_insert_editor" title="" id="aboutus_element_style_three_right_insert_editor" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['aboutus_element_style_three_right_insert_editor'].'</textarea></td>';
			$str .= '<script type="text/javascript">
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
			$str .= '<script type="text/javascript">';
			$str .= 'if ("undefined" != typeof(Translator)) {';
			$str .= 'Translator.add({"Insert Image...":"Insert Image...","Insert Media...":"Insert Media...","Insert File...":"Insert File..."});';
			$str .= '}wysiwygaboutus_element_style_three_right_insert_editor = new tinyMceWysiwygSetup("aboutus_element_style_three_right_insert_editor", {"enabled":true,"hidden":true,"use_container":false,"add_variables":true,"add_widgets":true,"add_images":true,"no_display":false,"translator":{},"encode_directives":true,"directives_url":"'.$baseurl.'evolved/cms_wysiwyg/directive/","popup_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/dialog.css","content_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/content.css","width":"100%","plugins":[{"name":"magentovariable","src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentovariable/editor_plugin.js","options":{"title":"Insert Variable...","url":"'.$baseurl.'evolved/system_variable/wysiwygPlugin/","onclick":{"search":["html_id"],"subject":"MagentovariablePlugin.loadChooser(\''.$baseurl.'evolved/system_variable/wysiwygPlugin/\', \'{{html_id}}\');"},"class":"add-variable plugin"}}],"directives_url_quoted":"'.$baseurl.'evolved/cms_wysiwyg/directive/","files_browser_window_url":"'.$baseurl.'idealAdmin/cms_wysiwyg_images/index/","files_browser_window_width":1000,"files_browser_window_height":600,"widget_plugin_src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentowidget/editor_plugin.js","widget_images_url":"'.$siteurl.'skin/adminhtml/default/default/images/widget/","widget_placeholders":["Thumbs.db","catalog__category_widget_link.gif","catalog__product_widget_link.gif","catalog__product_widget_new.gif","cms__widget_block.gif","cms__widget_page_link.gif","default.gif","reports__product_widget_compared.gif","reports__product_widget_viewed.gif"],"widget_window_url":"'.$baseurl.'evolved/widget/index/","firebug_warning_title":"Warning","firebug_warning_text":"Firebug is known to make the WYSIWYG editor slow unless it is turned off or configured properly.","firebug_warning_anchor":"Hide"});';
			$str .= 'editorFormValidationHandler = wysiwygaboutus_element_style_three_right_insert_editor.onFormValidation.bind(wysiwygaboutus_element_style_three_right_insert_editor);';
			$str .= 'Event.observe("toggleaboutus_element_style_three_right_insert_editor", "click", wysiwygaboutus_element_style_three_right_insert_editor.toggle.bind(wysiwygaboutus_element_style_three_right_insert_editor));';
			$str .= 'varienGlobalEvents.attachEventHandler("formSubmit", editorFormValidationHandler);';
			$str .= 'varienGlobalEvents.attachEventHandler("tinymceBeforeSetContent", wysiwygaboutus_element_style_three_right_insert_editor.beforeSetContent.bind(wysiwygaboutus_element_style_three_right_insert_editor));';
			$str .= 'varienGlobalEvents.attachEventHandler("tinymceSaveContent", wysiwygaboutus_element_style_three_right_insert_editor.saveContent.bind(wysiwygaboutus_element_style_three_right_insert_editor));';
			$str .= 'varienGlobalEvents.clearEventHandlers("open_browser_callback");';
			$str .= 'varienGlobalEvents.attachEventHandler("open_browser_callback", wysiwygaboutus_element_style_three_right_insert_editor.openFileBrowser.bind(wysiwygaboutus_element_style_three_right_insert_editor));';
			$str .= '</script>';
			$str .= '</tr>';
			$str .= '</tbody>';
			$str .= '</table>';
			$str .= '</td>';
			$str .= '</tr>';
			$str .= '</tbody>';
			$str .= '</table>';
		}
		//elseif($selectElement == "aboutus_element_style_four_two_column_with_70_by_30")
		{
			//$str .= '<table cellspacing="0" class="form-list">';
			$str .= ($selectElement == "aboutus_element_style_four_two_column_with_70_by_30") ? '<table cellspacing="0" class="form-list aboutusmaintable" id="aboutus_element_style_four_two_column_with_70_by_30" style="display: block;">' : '<table cellspacing="0" class="form-list aboutusmaintable" id="aboutus_element_style_four_two_column_with_70_by_30" style="display: none;">';
			$str .= '<tbody>';
			$str .= '<tr>';
			$str .= '<td>';
			$str .= '<table cellspacing="0" class="form-list">';
			$str .= '<tbody>';
			$str .= '<tr>';
			$str .= '<td class="label"><label for="aboutus_element_style_four_page_title">Page Title:</label></td>';
			$str .= '<td class="value">';
			$str .= '<input type="text" id="aboutus_element_style_four_page_title" name="aboutus_element_style_four_page_title" value="'.$collectiondata['aboutus_element_style_four_page_title'].'" class=" input-text">';
			$str .= '</td>';
			$str .= '</tr>';
			$str .= '<tr>';
			$str .= '<td class="label"><label for="aboutus_element_style_four_page_sub_title">Page Sub-Title:</label></td>';
			$str .= '<td class="value">';
			$str .= '<input type="text" id="aboutus_element_style_four_page_sub_title" name="aboutus_element_style_four_page_sub_title" value="'.$collectiondata['aboutus_element_style_four_page_sub_title'].'" class=" input-text">';
			$str .= '</td>';
			$str .= '</tr>';
			$str .= '<tr>';
			$str .= '<td class="label"><label for="aboutus_element_style_four_upload_banner">Upload Banner:</label></td>';
			$str .= '<td class="value">';
			if($collectiondata['aboutus_element_style_four_upload_banner'])
			{
				$str .= '<a href="/media/'.$collectiondata['aboutus_element_style_four_upload_banner'].'" onclick="imagePreview(\'aboutus_element_style_four_upload_banner\'); return false;"><img width="22" height="22" src="/media/'.$collectiondata['aboutus_element_style_four_upload_banner'].'" id="aboutus_element_style_four_upload_banner" title="'.$collectiondata['aboutus_element_style_four_upload_banner'].'" alt="'.$collectiondata['aboutus_element_style_four_upload_banner'].'" class="small-image-preview v-middle"></a>';
			}
			$str .= '<input type="file" class="input-file" value="'.$collectiondata['aboutus_element_style_four_upload_banner'].'" name="aboutus_element_style_four_upload_banner" id="aboutus_element_style_four_upload_banner">';
			$str .= '</td>';
			$str .= '</tr>';
			$str .= '<tr>';
			$str .= '<td class="label"><label for="aboutus_element_style_four_current_banner">Current Banner:</label></td>';
			$str .= '<td class="value">';
			$str .= '<img src="'."/media/".$collectiondata['aboutus_element_style_four_upload_banner'].'" name="aboutus_element_style_four_current_banner" id="aboutus_element_style_four_current_banner" width="300px" height="100px" />';
			$str .= '</td>';
			$str .= '</tr>';
			$str .= '</tbody>';
			$str .= '</table>';
			$str .= '</td>';
			$str .= '</tr>';
			$str .= '<tr>';
			$str .= '<td>';
			$str .= '<table cellspacing="0" class="form-list aboutus_element_style_four_table_image">';
			$str .= '<tbody>';
			$str .= '<tr>';
			$str .= '<td class="label"><label for="aboutus_element_style_four_left_insert_editor">Insert text/image:</label></td>';
			//$str .= '<td class="value"><div id="buttonsaboutus_element_style_four_left_insert_editor" class="buttons-set"><button type="button" class="scalable show-hide" style="" id="toggleaboutus_element_style_four_left_insert_editor"><span><span><span>Show / Hide Editor</span></span></span></button><button type="button" class="scalable add-widget plugin" onclick="widgetTools.openDialog('.$baseurl.'evolved/widget/index/widget_target_id/aboutus_element_style_four_left_insert_editor)" style=""><span><span><span>Insert Widget...</span></span></span></button><button type="button" class="scalable add-image plugin" onclick="MediabrowserUtility.openDialog('.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/aboutus_element_style_four_left_insert_editor/)" style=""><span><span><span>Insert Image...</span></span></span></button><button type="button" class="scalable add-variable plugin" onclick="MagentovariablePlugin.loadChooser('.$baseurl.'evolved/system_variable/wysiwygPlugin/, aboutus_element_style_four_left_insert_editor);"><span><span><span>Insert Variable...</span></span></span></button></div><textarea name="aboutus_element_style_four_left_insert_editor" title="" id="aboutus_element_style_four_left_insert_editor" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['aboutus_element_style_four_left_insert_editor'].'</textarea><small>*Maximum image width is 1050px </small></td>';
			$str .= '<td class="value"><button id="toggleaboutus_element_style_four_left_insert_editor" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><div id="buttonsaboutus_element_style_four_left_insert_editor" class="buttons-set"><button style="" onclick="MediabrowserUtility.openDialog(\''.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/aboutus_element_style_four_left_insert_editor/\')" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button></div><small class="imagelabelrequire">*Maximum image width is 714px </small><textarea name="aboutus_element_style_four_left_insert_editor" title="" id="aboutus_element_style_four_left_insert_editor" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['aboutus_element_style_four_left_insert_editor'].'</textarea></td>';
			$str .= '<script type="text/javascript">
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
			$str .= '<script type="text/javascript">';
			$str .= 'if ("undefined" != typeof(Translator)) {';
			$str .= 'Translator.add({"Insert Image...":"Insert Image...","Insert Media...":"Insert Media...","Insert File...":"Insert File..."});';
			$str .= '}wysiwygaboutus_element_style_four_left_insert_editor = new tinyMceWysiwygSetup("aboutus_element_style_four_left_insert_editor", {"enabled":true,"hidden":true,"use_container":false,"add_variables":true,"add_widgets":true,"add_images":true,"no_display":false,"translator":{},"encode_directives":true,"directives_url":"'.$baseurl.'evolved/cms_wysiwyg/directive/","popup_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/dialog.css","content_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/content.css","width":"100%","plugins":[{"name":"magentovariable","src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentovariable/editor_plugin.js","options":{"title":"Insert Variable...","url":"'.$baseurl.'evolved/system_variable/wysiwygPlugin/","onclick":{"search":["html_id"],"subject":"MagentovariablePlugin.loadChooser(\''.$baseurl.'evolved/system_variable/wysiwygPlugin/\', \'{{html_id}}\');"},"class":"add-variable plugin"}}],"directives_url_quoted":"'.$baseurl.'evolved/cms_wysiwyg/directive/","files_browser_window_url":"'.$baseurl.'idealAdmin/cms_wysiwyg_images/index/","files_browser_window_width":1000,"files_browser_window_height":600,"widget_plugin_src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentowidget/editor_plugin.js","widget_images_url":"'.$siteurl.'skin/adminhtml/default/default/images/widget/","widget_placeholders":["Thumbs.db","catalog__category_widget_link.gif","catalog__product_widget_link.gif","catalog__product_widget_new.gif","cms__widget_block.gif","cms__widget_page_link.gif","default.gif","reports__product_widget_compared.gif","reports__product_widget_viewed.gif"],"widget_window_url":"'.$baseurl.'evolved/widget/index/","firebug_warning_title":"Warning","firebug_warning_text":"Firebug is known to make the WYSIWYG editor slow unless it is turned off or configured properly.","firebug_warning_anchor":"Hide"});';
			$str .= 'editorFormValidationHandler = wysiwygaboutus_element_style_four_left_insert_editor.onFormValidation.bind(wysiwygaboutus_element_style_four_left_insert_editor);';
			$str .= 'Event.observe("toggleaboutus_element_style_four_left_insert_editor", "click", wysiwygaboutus_element_style_four_left_insert_editor.toggle.bind(wysiwygaboutus_element_style_four_left_insert_editor));';
			$str .= 'varienGlobalEvents.attachEventHandler("formSubmit", editorFormValidationHandler);';
			$str .= 'varienGlobalEvents.attachEventHandler("tinymceBeforeSetContent", wysiwygaboutus_element_style_four_left_insert_editor.beforeSetContent.bind(wysiwygaboutus_element_style_four_left_insert_editor));';
			$str .= 'varienGlobalEvents.attachEventHandler("tinymceSaveContent", wysiwygaboutus_element_style_four_left_insert_editor.saveContent.bind(wysiwygaboutus_element_style_four_left_insert_editor));';
			$str .= 'varienGlobalEvents.clearEventHandlers("open_browser_callback");';
			$str .= 'varienGlobalEvents.attachEventHandler("open_browser_callback", wysiwygaboutus_element_style_four_left_insert_editor.openFileBrowser.bind(wysiwygaboutus_element_style_four_left_insert_editor));';
			$str .= '</script>';
			$str .= '</tr>';
			$str .= '</tbody>';
			$str .= '</table>';
			$str .= '<table cellspacing="0" class="form-list aboutus_element_style_four_table_image">';
			$str .= '<tbody>';
			$str .= '<tr>';
			$str .= '<td class="label"><label for="aboutus_element_style_four_right_insert_editor">Insert text/image:</label></td>';
			//$str .= '<td class="value"><div id="buttonsaboutus_element_style_four_right_insert_editor" class="buttons-set"><button type="button" class="scalable show-hide" style="" id="toggleaboutus_element_style_four_right_insert_editor"><span><span><span>Show / Hide Editor</span></span></span></button><button type="button" class="scalable add-widget plugin" onclick="widgetTools.openDialog('.$baseurl.'evolved/widget/index/widget_target_id/aboutus_element_style_four_right_insert_editor)" style=""><span><span><span>Insert Widget...</span></span></span></button><button type="button" class="scalable add-image plugin" onclick="MediabrowserUtility.openDialog('.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/aboutus_element_style_four_right_insert_editor/)" style=""><span><span><span>Insert Image...</span></span></span></button><button type="button" class="scalable add-variable plugin" onclick="MagentovariablePlugin.loadChooser('.$baseurl.'evolved/system_variable/wysiwygPlugin/, aboutus_element_style_four_right_insert_editor);"><span><span><span>Insert Variable...</span></span></span></button></div><textarea name="aboutus_element_style_four_right_insert_editor" title="" id="aboutus_element_style_four_right_insert_editor" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['aboutus_element_style_four_right_insert_editor'].'</textarea><small>*Maximum image width is 1050px </small></td>';
			$str .= '<td class="value"><button id="toggleaboutus_element_style_four_right_insert_editor" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><div id="buttonsaboutus_element_style_four_right_insert_editor" class="buttons-set"><button style="" onclick="MediabrowserUtility.openDialog(\''.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/aboutus_element_style_four_right_insert_editor/\')" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button></div><small class="imagelabelrequire">*Maximum image width is 306px </small><textarea name="aboutus_element_style_four_right_insert_editor" title="" id="aboutus_element_style_four_right_insert_editor" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['aboutus_element_style_four_right_insert_editor'].'</textarea></td>';
			$str .= '<script type="text/javascript">
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
			$str .= '<script type="text/javascript">';
			$str .= 'if ("undefined" != typeof(Translator)) {';
			$str .= 'Translator.add({"Insert Image...":"Insert Image...","Insert Media...":"Insert Media...","Insert File...":"Insert File..."});';
			$str .= '}wysiwygaboutus_element_style_four_right_insert_editor = new tinyMceWysiwygSetup("aboutus_element_style_four_right_insert_editor", {"enabled":true,"hidden":true,"use_container":false,"add_variables":true,"add_widgets":true,"add_images":true,"no_display":false,"translator":{},"encode_directives":true,"directives_url":"'.$baseurl.'evolved/cms_wysiwyg/directive/","popup_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/dialog.css","content_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/content.css","width":"100%","plugins":[{"name":"magentovariable","src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentovariable/editor_plugin.js","options":{"title":"Insert Variable...","url":"'.$baseurl.'evolved/system_variable/wysiwygPlugin/","onclick":{"search":["html_id"],"subject":"MagentovariablePlugin.loadChooser(\''.$baseurl.'evolved/system_variable/wysiwygPlugin/\', \'{{html_id}}\');"},"class":"add-variable plugin"}}],"directives_url_quoted":"'.$baseurl.'evolved/cms_wysiwyg/directive/","files_browser_window_url":"'.$baseurl.'idealAdmin/cms_wysiwyg_images/index/","files_browser_window_width":1000,"files_browser_window_height":600,"widget_plugin_src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentowidget/editor_plugin.js","widget_images_url":"'.$siteurl.'skin/adminhtml/default/default/images/widget/","widget_placeholders":["Thumbs.db","catalog__category_widget_link.gif","catalog__product_widget_link.gif","catalog__product_widget_new.gif","cms__widget_block.gif","cms__widget_page_link.gif","default.gif","reports__product_widget_compared.gif","reports__product_widget_viewed.gif"],"widget_window_url":"'.$baseurl.'evolved/widget/index/","firebug_warning_title":"Warning","firebug_warning_text":"Firebug is known to make the WYSIWYG editor slow unless it is turned off or configured properly.","firebug_warning_anchor":"Hide"});';
			$str .= 'editorFormValidationHandler = wysiwygaboutus_element_style_four_right_insert_editor.onFormValidation.bind(wysiwygaboutus_element_style_four_right_insert_editor);';
			$str .= 'Event.observe("toggleaboutus_element_style_four_right_insert_editor", "click", wysiwygaboutus_element_style_four_right_insert_editor.toggle.bind(wysiwygaboutus_element_style_four_right_insert_editor));';
			$str .= 'varienGlobalEvents.attachEventHandler("formSubmit", editorFormValidationHandler);';
			$str .= 'varienGlobalEvents.attachEventHandler("tinymceBeforeSetContent", wysiwygaboutus_element_style_four_right_insert_editor.beforeSetContent.bind(wysiwygaboutus_element_style_four_right_insert_editor));';
			$str .= 'varienGlobalEvents.attachEventHandler("tinymceSaveContent", wysiwygaboutus_element_style_four_right_insert_editor.saveContent.bind(wysiwygaboutus_element_style_four_right_insert_editor));';
			$str .= 'varienGlobalEvents.clearEventHandlers("open_browser_callback");';
			$str .= 'varienGlobalEvents.attachEventHandler("open_browser_callback", wysiwygaboutus_element_style_four_right_insert_editor.openFileBrowser.bind(wysiwygaboutus_element_style_four_right_insert_editor));';
			$str .= '</script>';
			$str .= '</tr>';
			$str .= '</tbody>';
			$str .= '</table>';
			$str .= '</td>';
			$str .= '</tr>';
			$str .= '</tbody>';
			$str .= '</table>';
		}
		return $str;
	}
}