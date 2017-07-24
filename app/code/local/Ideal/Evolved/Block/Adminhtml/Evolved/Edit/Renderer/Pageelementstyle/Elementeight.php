<?php
class Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Pageelementstyle_Elementeight extends Varien_Data_Form_Element_Text
{
    /**
     * Override field method to add js
     *
     * @param Varien_Data_Form_Element_Ab$stract $this
     * @return String
     */
	public function getHtml()
    {
    	$baseurl = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB);
		$siteurl = str_replace("/index.php/","/",$baseurl);
		$loosdiamond_simple_without_radio = '<div class="shape"><div class="imageshape"><a href="{{store url=\'diamond-search\'}}"><img alt="" src="{{media url=\'search/logo1.png\'}}"></a><a href="{{store url=\'diamond-search\'}}?shape=round"><img alt="" src="{{media url=\'search/round.jpg\'}}">Round</a><a href="{{store url=\'diamond-search\'}}?shape=princess"><img alt="" src="{{media url=\'search/princess.jpg\'}}">Princess</a><a href="{{store url=\'diamond-search\'}}?shape=emerald"><img alt="" src="{{media url=\'search/emerald.jpg\'}}">Emerald</a><a href="{{store url=\'diamond-search\'}}?shape=marquise"><img alt="" src="{{media url=\'search/marquise.jpg\'}}">Marquise</a><a href="{{store url=\'diamond-search\'}}?shape=asscher"><img alt="" src="{{media url=\'search/asscher.jpg\'}}">Asscher</a><a href="{{store url=\'diamond-search\'}}?shape=oval"><img alt="" src="{{media url=\'search/oval.jpg\'}}">Oval</a><a href="{{store url=\'diamond-search\'}}?shape=radiant"><img alt="" src="{{media url=\'search/radiant.jpg\'}}">Radiant</a><a href="{{store url=\'diamond-search\'}}?shape=pear"><img alt="" src="{{media url=\'search/pear.jpg\'}}">Pear</a><a href="{{store url=\'diamond-search\'}}?shape=heart"><img alt="" src="{{media url=\'search/heart.jpg\'}}">Heart</a><a href="{{store url=\'diamond-search\'}}?shape=cushion"><img alt="" src="{{media url=\'search/cushion.jpg\'}}">Cushion</a></div></div>';
		$loosdiamond_simple_with_radio = '<div class="shape"><div class="imageshape"><div class="titlediamond"><h2><img src="{{media url="wysiwyg/slideshow/icon.png"}}" alt="" />  <span>diamond search</span>  <img src="{{media url="wysiwyg/slideshow/icon.png"}}" alt="" /></h2><span class="subtitle">Choose a shape and search for perfect conflict-free diamonds. To learn more about diamonds use our diamond education search.</span></div><ul><li class="first"><p><img alt="" src="{{media url=\'search/radio/round.jpg\'}}"></p><input type="radio" checked="checked" value="round" name="shape"><p>Round</p></li><li><p><img alt="" src="{{media url=\'search/radio/princess.jpg\'}}"></p><input type="radio" value="princess" name="shape"><p>Princess</p></li><li><p><img alt="" src="{{media url=\'search/radio/emerald.jpg\'}}"></p><input type="radio" value="emerald" name="shape"><p>Emerald</p></li><li class="last"><p><img alt="" src="{{media url=\'search/radio/marquise.jpg\'}}"></p><input type="radio" value="marquise" name="shape"><p>Marquise</p></li><li><p><img alt="" src="{{media url=\'search/radio/asscher.jpg\'}}"></p><input type="radio" value="asscher" name="shape"><p>Asscher</p></li><li><p><img alt="" src="{{media url=\'search/radio/oval.jpg\'}}"></p><input type="radio" value="oval" name="shape"><p>Oval</p></li><li><p><img alt="" src="{{media url=\'search/radio/radiant.jpg\'}}"></p><input type="radio" value="radiant" name="shape"><p>Radiant</p></li><li><p><img alt="" src="{{media url=\'search/radio/pear.jpg\'}}"></p><input type="radio" value="pear" name="shape"><p>Pear</p></li><li><p><img alt="" src="{{media url=\'search/radio/heart.jpg\'}}"></p><input type="radio" value="heart" name="shape"><p>Heart</p></li><li><p><img alt="" src="{{media url=\'search/radio/heart.jpg\'}}"></p><input type="radio" value="cushion" name="shape"><p>Cushion</p></li></ul><div class="search"><input class="searchloosedia-btn" type="button" value="search"></div></div></div><script>jQuery(document).ready(function(){ jQuery(\'.searchloosedia-btn\').click(function(){ window.location = \'{{store url=\'diamond-search\'}}?shape=\' + jQuery(\'input[name=shape]:checked\').val(); });});</script>';
		$elementonemodel = Mage::getModel('evolved/evolved');
		$elementonecollection = $elementonemodel->getCollection();
		$elementonecollection->addFieldToFilter('field', array('like' => 'homepage_element_eight_style'));
		foreach($elementonecollection as $elementonecollection1)
		{
			$selectElement = $elementonecollection1['value'];
			//$selectElement = $elementonecollection1['field'];
		}
		$elementonemodeldata = Mage::getModel('evolved/evolved');
		$elementonecollectiondata = $elementonemodeldata->getCollection();
		$elementonecollectiondata->addFieldToFilter('field', array('like' => 'homepage_element_8_%'));
		//echo "<pre>"; print_r($elementonecollectiondata->getData()); exit;
		foreach ($elementonecollectiondata as $elementonecollectiondata1)
		{
			//    		echo $collection_arr['field']."   value: ".$collection_arr['value']."<br />";
			$collectiondata[$elementonecollectiondata1['field']] = $elementonecollectiondata1['value'];
		}
		//echo "<pre>"; print_r($collectiondata); exit;
		$elementonemodelshapedata = Mage::getModel('evolved/evolved');
		$elementonemodelshapedata = $elementonemodelshapedata->getCollection();
		$elementonemodelshapedata->addFieldToFilter('field', array('like' => 'homepage_element_8_diamondrow_dynamic_shape_table_row%'));
		//echo "<pre>"; print_r($elementonemodelshapedata->getData()); exit;
		$elementonemodelshapedataarr = array();
		foreach($elementonemodelshapedata as $elementonemodelshapedata1)
		{
			$elementonemodelshapedataarr[] = $elementonemodelshapedata1['value'];
		}
		//echo max($elementonemodelshapedataarr); exit;
		
		foreach ($elementonecollectiondata as $elementonecollectiondata1)
		{
			//    		echo $collection_arr['field']."   value: ".$collection_arr['value']."<br />";
			$collectiondata[$elementonecollectiondata1['field']] = $elementonecollectiondata1['value'];
		}
		$targetarr = array(''=>'Please Select','_blank'=>'New','_self'=>'Self');
        // Get the default HTML for this option
        //$html = parent::getHtml();
    	//$selectElement = '30_70_boxes_full_width';
        				//if($selectElement == '1920_by_480_banner')
	      				{
	      					if($selectElement == 'homepage_element_8_1920_by_480_banner')
	      					{
	      						$str = '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="homepage_element_8_1920_by_480_banner" style="display: block">';
	      					}
	      					else 
	      					{
	      						$str = '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="homepage_element_8_1920_by_480_banner"  style="display: none">';
	      					}
	      					$str = $str . '<tbody>';
	      					$str = $str . '<tr>';
	      					$str = $str . '<td>';
      						$str = $str . '<table cellspacing="0" class="form-list allpageelement">';
							$str = $str . '<tbody>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_one_style_title">Title:</label></td>';  
      						$str = $str . '<td class="value"><input id="homepage_element_8_one_style_title"  value="'.$collectiondata['homepage_element_8_one_style_title'].'"  name="homepage_element_8_1920_by_480_banner[homepage_element_8_one_style_title]"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str .	'<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_one_style_link">Link:</label></td>';
      						$str = $str . '<td class="value"><input id="homepage_element_8_one_style_link" value="'.$collectiondata['homepage_element_8_one_style_link'].'" name="homepage_element_8_1920_by_480_banner[homepage_element_8_one_style_link]"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';      						
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_one_style_target">Target:</label></td>';
      						$str = $str . '<td class="value">';
      						$str = $str . '<select id="homepage_element_8_one_style_target" name="homepage_element_8_1920_by_480_banner[homepage_element_8_one_style_target]" >';
      						foreach($targetarr as $targetarrkey => $targetarrvalue)
      						{
      							if($collectiondata['homepage_element_8_one_style_target']==$targetarrkey)
      							{
      								$str = $str . '<option value='.$targetarrkey.' selected>'.$targetarrvalue.'</option>';
      							}
      							else
      							{
      								$str = $str . '<option value='.$targetarrkey.'>'.$targetarrvalue.'</option>';
      							}
      						}
      						$str = $str . '</select>';
      						$str = $str . '</td>';
      						$str = $str . '</tr>';      						
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_one_style_image">Image:</label></td>';
      						//$str = $str . '<td class="value"><div id="buttonshomepage_element_8_one_style_image" class="buttons-set"><button type="button" class="scalable show-hide" style="" id="togglehomepage_element_8_one_style_image"><span><span><span>Show / Hide Editor</span></span></span></button><button type="button" class="scalable add-widget plugin" onclick="widgetTools.openDialog('.$baseurl.'evolved/widget/index/widget_target_id/homepage_element_8_one_style_image)" style=""><span><span><span>Insert Widget...</span></span></span></button><button type="button" class="scalable add-image plugin" onclick="MediabrowserUtility.openDialog('.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_8_one_style_image/)" style=""><span><span><span>Insert Image...</span></span></span></button><button type="button" class="scalable add-variable plugin" onclick="MagentovariablePlugin.loadChooser('.$baseurl.'evolved/system_variable/wysiwygPlugin/, homepage_element_8_one_style_image);"><span><span><span>Insert Variable...</span></span></span></button></div><textarea name="homepage_element_8_one_style_image" title="" id="homepage_element_8_one_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_8_one_style_image'].'</textarea><small>Image size must be 1920*480 pixels</small></td>';
      						$str = $str . '<td class="value"><button id="togglehomepage_element_8_one_style_image" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><div id="buttonshomepage_element_8_one_style_image" class="buttons-set"><button style="" onclick="MediabrowserUtility.openDialog(\''.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_8_one_style_image/\')" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button></div><textarea name="homepage_element_8_1920_by_480_banner[homepage_element_8_one_style_image]" title="" id="homepage_element_8_one_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_8_one_style_image'].'</textarea><small>Image size must be 1920*480 pixels</small></td>';
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
      						$str = $str . '}wysiwyghomepage_element_8_one_style_image = new tinyMceWysiwygSetup("homepage_element_8_one_style_image", {"enabled":true,"hidden":true,"use_container":false,"add_variables":true,"add_widgets":true,"add_images":true,"no_display":false,"translator":{},"encode_directives":true,"directives_url":"'.$baseurl.'evolved/cms_wysiwyg/directive/","popup_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/dialog.css","content_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/content.css","width":"100%","plugins":[{"name":"magentovariable","src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentovariable/editor_plugin.js","options":{"title":"Insert Variable...","url":"'.$baseurl.'evolved/system_variable/wysiwygPlugin/","onclick":{"search":["html_id"],"subject":"MagentovariablePlugin.loadChooser(\''.$baseurl.'evolved/system_variable/wysiwygPlugin/\', \'{{html_id}}\');"},"class":"add-variable plugin"}}],"directives_url_quoted":"'.$baseurl.'evolved/cms_wysiwyg/directive/","files_browser_window_url":"'.$baseurl.'idealAdmin/cms_wysiwyg_images/index/","files_browser_window_width":1000,"files_browser_window_height":600,"widget_plugin_src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentowidget/editor_plugin.js","widget_images_url":"'.$siteurl.'skin/adminhtml/default/default/images/widget/","widget_placeholders":["Thumbs.db","catalog__category_widget_link.gif","catalog__product_widget_link.gif","catalog__product_widget_new.gif","cms__widget_block.gif","cms__widget_page_link.gif","default.gif","reports__product_widget_compared.gif","reports__product_widget_viewed.gif"],"widget_window_url":"'.$baseurl.'evolved/widget/index/","firebug_warning_title":"Warning","firebug_warning_text":"Firebug is known to make the WYSIWYG editor slow unless it is turned off or configured properly.","firebug_warning_anchor":"Hide"});';
      						$str = $str . 'editorFormValidationHandler = wysiwyghomepage_element_8_one_style_image.onFormValidation.bind(wysiwyghomepage_element_8_one_style_image);';
      						$str = $str . 'Event.observe("togglehomepage_element_8_one_style_image", "click", wysiwyghomepage_element_8_one_style_image.toggle.bind(wysiwyghomepage_element_8_one_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("formSubmit", editorFormValidationHandler);';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceBeforeSetContent", wysiwyghomepage_element_8_one_style_image.beforeSetContent.bind(wysiwyghomepage_element_8_one_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceSaveContent", wysiwyghomepage_element_8_one_style_image.saveContent.bind(wysiwyghomepage_element_8_one_style_image));';
      						$str = $str . 'varienGlobalEvents.clearEventHandlers("open_browser_callback");';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("open_browser_callback", wysiwyghomepage_element_8_one_style_image.openFileBrowser.bind(wysiwyghomepage_element_8_one_style_image));';
      						$str = $str . '</script>';
      						$str = $str . '</tr>';
      						$str = $str . '</tbody>';
      						$str = $str . '</table>';	
      						$str = $str . '</td>';
      						$str = $str . '<td>';
      						$str = $str . '<table cellspacing="0" class="form-list allpageelement">';
      						$str = $str . '<tbody>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_one_mobile_style_title">Title:</label></td>';
      						$str = $str . '<td class="value"><input id="homepage_element_8_one_mobile_style_title"  value="'.$collectiondata['homepage_element_8_one_mobile_style_title'].'"  name="homepage_element_8_1920_by_480_banner[homepage_element_8_one_mobile_style_title]"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str .	'<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_one_mobile_style_link">Link:</label></td>';
      						$str = $str . '<td class="value"><input id="homepage_element_8_one_mobile_style_link" value="'.$collectiondata['homepage_element_8_one_mobile_style_link'].'" name="homepage_element_8_1920_by_480_banner[homepage_element_8_one_mobile_style_link]"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_one_mobile_style_target">Target:</label></td>';
      						$str = $str . '<td class="value">';
      						$str = $str . '<select id="homepage_element_8_one_mobile_style_target" name="homepage_element_8_1920_by_480_banner[homepage_element_8_one_mobile_style_target]" >';
      						foreach($targetarr as $targetarrkey => $targetarrvalue)
      						{
      							if($collectiondata['homepage_element_8_one_mobile_style_target']==$targetarrkey)
      							{
      								$str = $str . '<option value='.$targetarrkey.' selected>'.$targetarrvalue.'</option>';
      							}
      							else
      							{
      								$str = $str . '<option value='.$targetarrkey.'>'.$targetarrvalue.'</option>';
      							}
      						}
      						$str = $str . '</select>';
      						$str = $str . '</td>';
      						$str = $str . '</tr>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_one_mobile_style_image">Image:</label></td>';
      						//$str = $str . '<td class="value"><div id="buttonshomepage_element_8_one_mobile_style_image" class="buttons-set"><button type="button" class="scalable show-hide" style="" id="togglehomepage_element_8_one_mobile_style_image"><span><span><span>Show / Hide Editor</span></span></span></button><button type="button" class="scalable add-widget plugin" onclick="widgetTools.openDialog('.$baseurl.'evolved/widget/index/widget_target_id/homepage_element_8_one_mobile_style_image)" style=""><span><span><span>Insert Widget...</span></span></span></button><button type="button" class="scalable add-image plugin" onclick="MediabrowserUtility.openDialog('.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_8_one_mobile_style_image/)" style=""><span><span><span>Insert Image...</span></span></span></button><button type="button" class="scalable add-variable plugin" onclick="MagentovariablePlugin.loadChooser('.$baseurl.'evolved/system_variable/wysiwygPlugin/, homepage_element_8_one_mobile_style_image);"><span><span><span>Insert Variable...</span></span></span></button></div><textarea name="homepage_element_8_one_mobile_style_image" title="" id="homepage_element_8_one_mobile_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_8_one_mobile_style_image'].'</textarea><small>Image size must be 1920*480 pixels</small></td>';
      						$str = $str . '<td class="value"><button id="togglehomepage_element_8_one_mobile_style_image" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><div id="buttonshomepage_element_8_one_mobile_style_image" class="buttons-set"><button style="" onclick="MediabrowserUtility.openDialog(\''.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_8_one_mobile_style_image/\')" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button></div><textarea name="homepage_element_8_1920_by_480_banner[homepage_element_8_one_mobile_style_image]" title="" id="homepage_element_8_one_mobile_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_8_one_mobile_style_image'].'</textarea><small>Mobile/Tablet Image size must be 768*480 pixels</small></td>';
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
      						$str = $str . '}wysiwyghomepage_element_8_one_mobile_style_image = new tinyMceWysiwygSetup("homepage_element_8_one_mobile_style_image", {"enabled":true,"hidden":true,"use_container":false,"add_variables":true,"add_widgets":true,"add_images":true,"no_display":false,"translator":{},"encode_directives":true,"directives_url":"'.$baseurl.'evolved/cms_wysiwyg/directive/","popup_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/dialog.css","content_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/content.css","width":"100%","plugins":[{"name":"magentovariable","src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentovariable/editor_plugin.js","options":{"title":"Insert Variable...","url":"'.$baseurl.'evolved/system_variable/wysiwygPlugin/","onclick":{"search":["html_id"],"subject":"MagentovariablePlugin.loadChooser(\''.$baseurl.'evolved/system_variable/wysiwygPlugin/\', \'{{html_id}}\');"},"class":"add-variable plugin"}}],"directives_url_quoted":"'.$baseurl.'evolved/cms_wysiwyg/directive/","files_browser_window_url":"'.$baseurl.'idealAdmin/cms_wysiwyg_images/index/","files_browser_window_width":1000,"files_browser_window_height":600,"widget_plugin_src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentowidget/editor_plugin.js","widget_images_url":"'.$siteurl.'skin/adminhtml/default/default/images/widget/","widget_placeholders":["Thumbs.db","catalog__category_widget_link.gif","catalog__product_widget_link.gif","catalog__product_widget_new.gif","cms__widget_block.gif","cms__widget_page_link.gif","default.gif","reports__product_widget_compared.gif","reports__product_widget_viewed.gif"],"widget_window_url":"'.$baseurl.'evolved/widget/index/","firebug_warning_title":"Warning","firebug_warning_text":"Firebug is known to make the WYSIWYG editor slow unless it is turned off or configured properly.","firebug_warning_anchor":"Hide"});';
      						$str = $str . 'editorFormValidationHandler = wysiwyghomepage_element_8_one_mobile_style_image.onFormValidation.bind(wysiwyghomepage_element_8_one_mobile_style_image);';
      						$str = $str . 'Event.observe("togglehomepage_element_8_one_mobile_style_image", "click", wysiwyghomepage_element_8_one_mobile_style_image.toggle.bind(wysiwyghomepage_element_8_one_mobile_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("formSubmit", editorFormValidationHandler);';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceBeforeSetContent", wysiwyghomepage_element_8_one_mobile_style_image.beforeSetContent.bind(wysiwyghomepage_element_8_one_mobile_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceSaveContent", wysiwyghomepage_element_8_one_mobile_style_image.saveContent.bind(wysiwyghomepage_element_8_one_mobile_style_image));';
      						$str = $str . 'varienGlobalEvents.clearEventHandlers("open_browser_callback");';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("open_browser_callback", wysiwyghomepage_element_8_one_mobile_style_image.openFileBrowser.bind(wysiwyghomepage_element_8_one_mobile_style_image));';
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
							if($selectElement == 'homepage_element_8_1920_by_800_banner')
							{
								$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="homepage_element_8_1920_by_800_banner" style="display: block">';
							}
							else
							{
								$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="homepage_element_8_1920_by_800_banner"  style="display: none">';
							}
							//$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="1920_by_800_banner">';
							$str = $str . '<tbody>';
							$str = $str . '<tr>';
							$str = $str . '<td>';
							$str = $str . '<table cellspacing="0" class="form-list allpageelement">';
							$str = $str . '<tbody>';
							$str = $str . '<tr>';
							$str = $str . '<td class="label"><label for="homepage_element_8_two_style_title">Title:</label></td>';
							$str = $str . '<td class="value"><input id="homepage_element_8_two_style_title" value="'.$collectiondata['homepage_element_8_two_style_title'].'"  name="homepage_element_8_1920_by_800_banner[homepage_element_8_two_style_title]"  type="text" class=" input-text"></td>';
							$str = $str . '</tr>';
							$str = $str .	'<tr>';
							$str = $str . '<td class="label"><label for="homepage_element_8_two_style_link">Link:</label></td>';
							$str = $str . '<td class="value"><input id="homepage_element_8_two_style_link" value="'.$collectiondata['homepage_element_8_two_style_link'].'" name="homepage_element_8_1920_by_800_banner[homepage_element_8_two_style_link]"  type="text" class=" input-text"></td>';
							$str = $str . '</tr>';
							$str = $str . '<tr>';
							$str = $str . '<td class="label"><label for="homepage_element_8_two_style_target">Target:</label></td>';
							$str = $str . '<td class="value">';
							$str = $str . '<select id="homepage_element_8_two_style_target" name="homepage_element_8_1920_by_800_banner[homepage_element_8_two_style_target]" >';
							foreach($targetarr as $targetarrkey => $targetarrvalue)
							{
								if($collectiondata['homepage_element_8_two_style_target']==$targetarrkey)
								{
									$str = $str . '<option value='.$targetarrkey.' selected>'.$targetarrvalue.'</option>';
								}
								else
								{
									$str = $str . '<option value='.$targetarrkey.'>'.$targetarrvalue.'</option>';
								}
							}
							$str = $str . '</select>';
							$str = $str . '</td>';
							$str = $str . '</tr>';
							$str = $str . '<tr>';
							$str = $str . '<td class="label"><label for="homepage_element_8_two_style_image">Image:</label></td>';
							//$str = $str . '<td class="value"><div id="buttonshomepage_element_8_two_style_image" class="buttons-set"><button type="button" class="scalable show-hide" style="" id="togglehomepage_element_8_two_style_image"><span><span><span>Show / Hide Editor</span></span></span></button><button type="button" class="scalable add-widget plugin" onclick="widgetTools.openDialog('.$baseurl.'evolved/widget/index/widget_target_id/homepage_element_8_two_style_image)" style=""><span><span><span>Insert Widget...</span></span></span></button><button type="button" class="scalable add-image plugin" onclick="MediabrowserUtility.openDialog('.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_8_two_style_image/)" style=""><span><span><span>Insert Image...</span></span></span></button><button type="button" class="scalable add-variable plugin" onclick="MagentovariablePlugin.loadChooser('.$baseurl.'evolved/system_variable/wysiwygPlugin/, homepage_element_8_two_style_image);"><span><span><span>Insert Variable...</span></span></span></button></div><textarea name="homepage_element_8_two_style_image" title="" id="homepage_element_8_two_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_8_two_style_image'].'</textarea><small>Image size must be 1920*480 pixels</small></td>';
							$str = $str . '<td class="value"><button id="togglehomepage_element_8_two_style_image" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><div id="buttonshomepage_element_8_two_style_image" class="buttons-set"><button style="" onclick="MediabrowserUtility.openDialog(\''.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_8_two_style_image/\')" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button></div><textarea name="homepage_element_8_1920_by_800_banner[homepage_element_8_two_style_image]" title="" id="homepage_element_8_two_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_8_two_style_image'].'</textarea><small>Image size must be 1920*800 pixels</small></td>';
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
							$str = $str . '}wysiwyghomepage_element_8_two_style_image = new tinyMceWysiwygSetup("homepage_element_8_two_style_image", {"enabled":true,"hidden":true,"use_container":false,"add_variables":true,"add_widgets":true,"add_images":true,"no_display":false,"translator":{},"encode_directives":true,"directives_url":"'.$baseurl.'evolved/cms_wysiwyg/directive/","popup_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/dialog.css","content_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/content.css","width":"100%","plugins":[{"name":"magentovariable","src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentovariable/editor_plugin.js","options":{"title":"Insert Variable...","url":"'.$baseurl.'evolved/system_variable/wysiwygPlugin/","onclick":{"search":["html_id"],"subject":"MagentovariablePlugin.loadChooser(\''.$baseurl.'evolved/system_variable/wysiwygPlugin/\', \'{{html_id}}\');"},"class":"add-variable plugin"}}],"directives_url_quoted":"'.$baseurl.'evolved/cms_wysiwyg/directive/","files_browser_window_url":"'.$baseurl.'idealAdmin/cms_wysiwyg_images/index/","files_browser_window_width":1000,"files_browser_window_height":600,"widget_plugin_src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentowidget/editor_plugin.js","widget_images_url":"'.$siteurl.'skin/adminhtml/default/default/images/widget/","widget_placeholders":["Thumbs.db","catalog__category_widget_link.gif","catalog__product_widget_link.gif","catalog__product_widget_new.gif","cms__widget_block.gif","cms__widget_page_link.gif","default.gif","reports__product_widget_compared.gif","reports__product_widget_viewed.gif"],"widget_window_url":"'.$baseurl.'evolved/widget/index/","firebug_warning_title":"Warning","firebug_warning_text":"Firebug is known to make the WYSIWYG editor slow unless it is turned off or configured properly.","firebug_warning_anchor":"Hide"});';
							$str = $str . 'editorFormValidationHandler = wysiwyghomepage_element_8_two_style_image.onFormValidation.bind(wysiwyghomepage_element_8_two_style_image);';
							$str = $str . 'Event.observe("togglehomepage_element_8_two_style_image", "click", wysiwyghomepage_element_8_two_style_image.toggle.bind(wysiwyghomepage_element_8_two_style_image));';
							$str = $str . 'varienGlobalEvents.attachEventHandler("formSubmit", editorFormValidationHandler);';
							$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceBeforeSetContent", wysiwyghomepage_element_8_two_style_image.beforeSetContent.bind(wysiwyghomepage_element_8_two_style_image));';
							$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceSaveContent", wysiwyghomepage_element_8_two_style_image.saveContent.bind(wysiwyghomepage_element_8_two_style_image));';
							$str = $str . 'varienGlobalEvents.clearEventHandlers("open_browser_callback");';
							$str = $str . 'varienGlobalEvents.attachEventHandler("open_browser_callback", wysiwyghomepage_element_8_two_style_image.openFileBrowser.bind(wysiwyghomepage_element_8_two_style_image));';
							$str = $str . '</script>';
							$str = $str . '</tr>';
							$str = $str . '</tbody>';
							$str = $str . '</table>';
							$str = $str . '</td>';
							$str = $str . '<td>';
							$str = $str . '<table cellspacing="0" class="form-list allpageelement">';
							$str = $str . '<tbody>';
							$str = $str . '<tr>';
							$str = $str . '<td class="label"><label for="homepage_element_8_two_mobile_style_title">Title:</label></td>';
							$str = $str . '<td class="value"><input id="homepage_element_8_two_mobile_style_title"  value="'.$collectiondata['homepage_element_8_two_mobile_style_title'].'"  name="homepage_element_8_1920_by_800_banner[homepage_element_8_two_mobile_style_title]"  type="text" class=" input-text"></td>';
							$str = $str . '</tr>';
							$str = $str .	'<tr>';
							$str = $str . '<td class="label"><label for="homepage_element_8_two_mobile_style_link">Link:</label></td>';
							$str = $str . '<td class="value"><input id="homepage_element_8_two_mobile_style_link" value="'.$collectiondata['homepage_element_8_two_mobile_style_link'].'" name="homepage_element_8_1920_by_800_banner[homepage_element_8_two_mobile_style_link]"  type="text" class=" input-text"></td>';
							$str = $str . '</tr>';
							$str = $str . '<tr>';
							$str = $str . '<td class="label"><label for="homepage_element_8_two_mobile_style_target">Target:</label></td>';
							$str = $str . '<td class="value">';
							$str = $str . '<select id="homepage_element_8_two_mobile_style_target" name="homepage_element_8_1920_by_800_banner[homepage_element_8_two_mobile_style_target]" >';
							foreach($targetarr as $targetarrkey => $targetarrvalue)
							{
								if($collectiondata['homepage_element_8_two_mobile_style_target']==$targetarrkey)
								{
									$str = $str . '<option value='.$targetarrkey.' selected>'.$targetarrvalue.'</option>';
								}
								else
								{
									$str = $str . '<option value='.$targetarrkey.'>'.$targetarrvalue.'</option>';
								}
							}
							$str = $str . '</select>';
							$str = $str . '</td>';
							$str = $str . '</tr>';
							$str = $str . '<tr>';
							$str = $str . '<td class="label"><label for="homepage_element_8_two_mobile_style_image">Image:</label></td>';
							//$str = $str . '<td class="value"><div id="buttonshomepage_element_8_two_mobile_style_image" class="buttons-set"><button type="button" class="scalable show-hide" style="" id="togglehomepage_element_8_two_mobile_style_image"><span><span><span>Show / Hide Editor</span></span></span></button><button type="button" class="scalable add-widget plugin" onclick="widgetTools.openDialog('.$baseurl.'evolved/widget/index/widget_target_id/homepage_element_8_two_mobile_style_image)" style=""><span><span><span>Insert Widget...</span></span></span></button><button type="button" class="scalable add-image plugin" onclick="MediabrowserUtility.openDialog('.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_8_two_mobile_style_image/)" style=""><span><span><span>Insert Image...</span></span></span></button><button type="button" class="scalable add-variable plugin" onclick="MagentovariablePlugin.loadChooser('.$baseurl.'evolved/system_variable/wysiwygPlugin/, homepage_element_8_two_mobile_style_image);"><span><span><span>Insert Variable...</span></span></span></button></div><textarea name="homepage_element_8_two_mobile_style_image" title="" id="homepage_element_8_two_mobile_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_8_two_mobile_style_image'].'</textarea><small>Image size must be 1920*480 pixels</small></td>';
							$str = $str . '<td class="value"><button id="togglehomepage_element_8_two_mobile_style_image" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><div id="buttonshomepage_element_8_two_mobile_style_image" class="buttons-set"><button style="" onclick="MediabrowserUtility.openDialog(\''.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_8_two_mobile_style_image/\')" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button></div><textarea name="homepage_element_8_1920_by_800_banner[homepage_element_8_two_mobile_style_image]" title="" id="homepage_element_8_two_mobile_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_8_two_mobile_style_image'].'</textarea><small>Mobile/Tablet Image size must be 768*480 pixels</small></td>';
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
							$str = $str . '}wysiwyghomepage_element_8_two_mobile_style_image = new tinyMceWysiwygSetup("homepage_element_8_two_mobile_style_image", {"enabled":true,"hidden":true,"use_container":false,"add_variables":true,"add_widgets":true,"add_images":true,"no_display":false,"translator":{},"encode_directives":true,"directives_url":"'.$baseurl.'evolved/cms_wysiwyg/directive/","popup_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/dialog.css","content_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/content.css","width":"100%","plugins":[{"name":"magentovariable","src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentovariable/editor_plugin.js","options":{"title":"Insert Variable...","url":"'.$baseurl.'evolved/system_variable/wysiwygPlugin/","onclick":{"search":["html_id"],"subject":"MagentovariablePlugin.loadChooser(\''.$baseurl.'evolved/system_variable/wysiwygPlugin/\', \'{{html_id}}\');"},"class":"add-variable plugin"}}],"directives_url_quoted":"'.$baseurl.'evolved/cms_wysiwyg/directive/","files_browser_window_url":"'.$baseurl.'idealAdmin/cms_wysiwyg_images/index/","files_browser_window_width":1000,"files_browser_window_height":600,"widget_plugin_src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentowidget/editor_plugin.js","widget_images_url":"'.$siteurl.'skin/adminhtml/default/default/images/widget/","widget_placeholders":["Thumbs.db","catalog__category_widget_link.gif","catalog__product_widget_link.gif","catalog__product_widget_new.gif","cms__widget_block.gif","cms__widget_page_link.gif","default.gif","reports__product_widget_compared.gif","reports__product_widget_viewed.gif"],"widget_window_url":"'.$baseurl.'evolved/widget/index/","firebug_warning_title":"Warning","firebug_warning_text":"Firebug is known to make the WYSIWYG editor slow unless it is turned off or configured properly.","firebug_warning_anchor":"Hide"});';
							$str = $str . 'editorFormValidationHandler = wysiwyghomepage_element_8_two_mobile_style_image.onFormValidation.bind(wysiwyghomepage_element_8_two_mobile_style_image);';
							$str = $str . 'Event.observe("togglehomepage_element_8_two_mobile_style_image", "click", wysiwyghomepage_element_8_two_mobile_style_image.toggle.bind(wysiwyghomepage_element_8_two_mobile_style_image));';
							$str = $str . 'varienGlobalEvents.attachEventHandler("formSubmit", editorFormValidationHandler);';
							$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceBeforeSetContent", wysiwyghomepage_element_8_two_mobile_style_image.beforeSetContent.bind(wysiwyghomepage_element_8_two_mobile_style_image));';
							$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceSaveContent", wysiwyghomepage_element_8_two_mobile_style_image.saveContent.bind(wysiwyghomepage_element_8_two_mobile_style_image));';
							$str = $str . 'varienGlobalEvents.clearEventHandlers("open_browser_callback");';
							$str = $str . 'varienGlobalEvents.attachEventHandler("open_browser_callback", wysiwyghomepage_element_8_two_mobile_style_image.openFileBrowser.bind(wysiwyghomepage_element_8_two_mobile_style_image));';
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
	      					if($selectElement == 'homepage_element_8_30_70_boxes_full_width')
	      					{
	      						$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="homepage_element_8_30_70_boxes_full_width" style="display: block">';
	      					}
	      					else
	      					{
	      						$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="homepage_element_8_30_70_boxes_full_width"  style="display: none">';
	      					}
	      					//$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="30_70_boxes_full_width">';
	      					$str = $str . '<tbody>';
	      					$str = $str . '<tr>';
	      					$str = $str . '<td>';
      						$str = $str . '<table cellspacing="0" class="form-list allpageelement" style="display: table-cell;">';
							$str = $str . '<tbody>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_three_one_style_title">Title:</label></td>';  
      						$str = $str . '<td class="value"><input id="homepage_element_8_three_one_style_title" value="'.$collectiondata['homepage_element_8_three_one_style_title'].'" name="homepage_element_8_30_70_boxes_full_width[homepage_element_8_three_one_style_title]"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str .	'<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_three_one_style_link">Link:</label></td>';
      						$str = $str . '<td class="value"><input id="homepage_element_8_three_one_style_link"  value="'.$collectiondata['homepage_element_8_three_one_style_link'].'" name="homepage_element_8_30_70_boxes_full_width[homepage_element_8_three_one_style_link]"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_three_one_style_target">Target:</label></td>';
      						$str = $str . '<td class="value">';
      						$str = $str . '<select id="homepage_element_8_three_one_style_target" name="homepage_element_8_30_70_boxes_full_width[homepage_element_8_three_one_style_target]" >';
      						foreach($targetarr as $targetarrkey => $targetarrvalue)
      						{
      							if($collectiondata['homepage_element_8_three_one_style_target']==$targetarrkey)
      							{
      								$str = $str . '<option value='.$targetarrkey.' selected>'.$targetarrvalue.'</option>';
      							}
      							else
      							{
      								$str = $str . '<option value='.$targetarrkey.'>'.$targetarrvalue.'</option>';
      							}
      						}
      						$str = $str . '</select>';
      						$str = $str . '</td>';
      						$str = $str . '</tr>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_three_one_style_image">Image:</label></td>';
      						//$str = $str . '<td class="value"><div id="buttonshomepage_element_8_three_one_style_image" class="buttons-set"><button type="button" class="scalable show-hide" style="" id="togglehomepage_element_8_three_one_style_image"><span><span><span>Show / Hide Editor</span></span></span></button><button type="button" class="scalable add-widget plugin" onclick="widgetTools.openDialog('.$baseurl.'evolved/widget/index/widget_target_id/homepage_element_8_three_one_style_image)" style=""><span><span><span>Insert Widget...</span></span></span></button><button type="button" class="scalable add-image plugin" onclick="MediabrowserUtility.openDialog('.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_8_three_one_style_image/)" style=""><span><span><span>Insert Image...</span></span></span></button><button type="button" class="scalable add-variable plugin" onclick="MagentovariablePlugin.loadChooser('.$baseurl.'evolved/system_variable/wysiwygPlugin/, homepage_element_8_three_one_style_image);"><span><span><span>Insert Variable...</span></span></span></button></div><textarea name="homepage_element_8_three_one_style_image" title="" id="homepage_element_8_three_one_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_8_three_one_style_image'].'</textarea><small>Image size must be 1920*480 pixels</small></td>';
      						$str = $str . '<td class="value"><button id="togglehomepage_element_8_three_one_style_image" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><div id="buttonshomepage_element_8_three_one_style_image" class="buttons-set"><button style="" onclick="MediabrowserUtility.openDialog(\''.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_8_three_one_style_image/\')" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button></div><textarea name="homepage_element_8_30_70_boxes_full_width[homepage_element_8_three_one_style_image]" title="" id="homepage_element_8_three_one_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_8_three_one_style_image'].'</textarea><small>Image size must be 640*400 pixels</small></td>';
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
      						$str = $str . '}wysiwyghomepage_element_8_three_one_style_image = new tinyMceWysiwygSetup("homepage_element_8_three_one_style_image", {"enabled":true,"hidden":true,"use_container":false,"add_variables":true,"add_widgets":true,"add_images":true,"no_display":false,"translator":{},"encode_directives":true,"directives_url":"'.$baseurl.'evolved/cms_wysiwyg/directive/","popup_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/dialog.css","content_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/content.css","width":"100%","plugins":[{"name":"magentovariable","src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentovariable/editor_plugin.js","options":{"title":"Insert Variable...","url":"'.$baseurl.'evolved/system_variable/wysiwygPlugin/","onclick":{"search":["html_id"],"subject":"MagentovariablePlugin.loadChooser(\''.$baseurl.'evolved/system_variable/wysiwygPlugin/\', \'{{html_id}}\');"},"class":"add-variable plugin"}}],"directives_url_quoted":"'.$baseurl.'evolved/cms_wysiwyg/directive/","files_browser_window_url":"'.$baseurl.'idealAdmin/cms_wysiwyg_images/index/","files_browser_window_width":1000,"files_browser_window_height":600,"widget_plugin_src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentowidget/editor_plugin.js","widget_images_url":"'.$siteurl.'skin/adminhtml/default/default/images/widget/","widget_placeholders":["Thumbs.db","catalog__category_widget_link.gif","catalog__product_widget_link.gif","catalog__product_widget_new.gif","cms__widget_block.gif","cms__widget_page_link.gif","default.gif","reports__product_widget_compared.gif","reports__product_widget_viewed.gif"],"widget_window_url":"'.$baseurl.'evolved/widget/index/","firebug_warning_title":"Warning","firebug_warning_text":"Firebug is known to make the WYSIWYG editor slow unless it is turned off or configured properly.","firebug_warning_anchor":"Hide"});';
      						$str = $str . 'editorFormValidationHandler = wysiwyghomepage_element_8_three_one_style_image.onFormValidation.bind(wysiwyghomepage_element_8_three_one_style_image);';
      						$str = $str . 'Event.observe("togglehomepage_element_8_three_one_style_image", "click", wysiwyghomepage_element_8_three_one_style_image.toggle.bind(wysiwyghomepage_element_8_three_one_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("formSubmit", editorFormValidationHandler);';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceBeforeSetContent", wysiwyghomepage_element_8_three_one_style_image.beforeSetContent.bind(wysiwyghomepage_element_8_three_one_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceSaveContent", wysiwyghomepage_element_8_three_one_style_image.saveContent.bind(wysiwyghomepage_element_8_three_one_style_image));';
      						$str = $str . 'varienGlobalEvents.clearEventHandlers("open_browser_callback");';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("open_browser_callback", wysiwyghomepage_element_8_three_one_style_image.openFileBrowser.bind(wysiwyghomepage_element_8_three_one_style_image));';
      						$str = $str . '</script>';
      						$str = $str . '</tr>';
      						$str = $str . '</tbody>';
      						$str = $str . '</table>';
      						$str = $str . '<table cellspacing="0" class="form-list allpageelement" style="display: table-cell;">';
							$str = $str . '<tbody>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_three_two_style_title">Title:</label></td>';  
      						$str = $str . '<td class="value"><input id="homepage_element_8_three_two_style_title" value="'.$collectiondata['homepage_element_8_three_two_style_title'].'" name="homepage_element_8_30_70_boxes_full_width[homepage_element_8_three_two_style_title]"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str .	'<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_three_two_style_link">Link:</label></td>';
      						$str = $str . '<td class="value"><input id="homepage_element_8_three_two_style_link"  value="'.$collectiondata['homepage_element_8_three_two_style_link'].'" name="homepage_element_8_30_70_boxes_full_width[homepage_element_8_three_two_style_link]"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_three_two_style_target">Target:</label></td>';
      						$str = $str . '<td class="value">';
      						$str = $str . '<select id="homepage_element_8_three_two_style_target" name="homepage_element_8_30_70_boxes_full_width[homepage_element_8_three_two_style_target]" >';
      						foreach($targetarr as $targetarrkey => $targetarrvalue)
      						{
      							if($collectiondata['homepage_element_8_three_two_style_target']==$targetarrkey)
      							{
      								$str = $str . '<option value='.$targetarrkey.' selected>'.$targetarrvalue.'</option>';
      							}
      							else
      							{
      								$str = $str . '<option value='.$targetarrkey.'>'.$targetarrvalue.'</option>';
      							}
      						}
      						$str = $str . '</select>';
      						$str = $str . '</td>';
      						$str = $str . '</tr>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_three_two_style_image">Image:</label></td>';
      						//$str = $str . '<td class="value"><div id="buttonshomepage_element_8_three_two_style_image" class="buttons-set"><button type="button" class="scalable show-hide" style="" id="togglehomepage_element_8_three_two_style_image"><span><span><span>Show / Hide Editor</span></span></span></button><button type="button" class="scalable add-widget plugin" onclick="widgetTools.openDialog('.$baseurl.'evolved/widget/index/widget_target_id/homepage_element_8_three_two_style_image)" style=""><span><span><span>Insert Widget...</span></span></span></button><button type="button" class="scalable add-image plugin" onclick="MediabrowserUtility.openDialog('.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_8_three_two_style_image/)" style=""><span><span><span>Insert Image...</span></span></span></button><button type="button" class="scalable add-variable plugin" onclick="MagentovariablePlugin.loadChooser('.$baseurl.'evolved/system_variable/wysiwygPlugin/, homepage_element_8_three_two_style_image);"><span><span><span>Insert Variable...</span></span></span></button></div><textarea name="homepage_element_8_three_two_style_image" title="" id="homepage_element_8_three_two_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_8_three_two_style_image'].'</textarea><small>Image size must be 1920*480 pixels</small></td>';
      						$str = $str . '<td class="value"><button id="togglehomepage_element_8_three_two_style_image" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><div id="buttonshomepage_element_8_three_two_style_image" class="buttons-set"><button style="" onclick="MediabrowserUtility.openDialog(\''.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_8_three_two_style_image/\')" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button></div><textarea name="homepage_element_8_30_70_boxes_full_width[homepage_element_8_three_two_style_image]" title="" id="homepage_element_8_three_two_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_8_three_two_style_image'].'</textarea><small>Image size must be 640*400 pixels</small></td>';
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
      						$str = $str . '}wysiwyghomepage_element_8_three_two_style_image = new tinyMceWysiwygSetup("homepage_element_8_three_two_style_image", {"enabled":true,"hidden":true,"use_container":false,"add_variables":true,"add_widgets":true,"add_images":true,"no_display":false,"translator":{},"encode_directives":true,"directives_url":"'.$baseurl.'evolved/cms_wysiwyg/directive/","popup_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/dialog.css","content_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/content.css","width":"100%","plugins":[{"name":"magentovariable","src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentovariable/editor_plugin.js","options":{"title":"Insert Variable...","url":"'.$baseurl.'evolved/system_variable/wysiwygPlugin/","onclick":{"search":["html_id"],"subject":"MagentovariablePlugin.loadChooser(\''.$baseurl.'evolved/system_variable/wysiwygPlugin/\', \'{{html_id}}\');"},"class":"add-variable plugin"}}],"directives_url_quoted":"'.$baseurl.'evolved/cms_wysiwyg/directive/","files_browser_window_url":"'.$baseurl.'idealAdmin/cms_wysiwyg_images/index/","files_browser_window_width":1000,"files_browser_window_height":600,"widget_plugin_src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentowidget/editor_plugin.js","widget_images_url":"'.$siteurl.'skin/adminhtml/default/default/images/widget/","widget_placeholders":["Thumbs.db","catalog__category_widget_link.gif","catalog__product_widget_link.gif","catalog__product_widget_new.gif","cms__widget_block.gif","cms__widget_page_link.gif","default.gif","reports__product_widget_compared.gif","reports__product_widget_viewed.gif"],"widget_window_url":"'.$baseurl.'evolved/widget/index/","firebug_warning_title":"Warning","firebug_warning_text":"Firebug is known to make the WYSIWYG editor slow unless it is turned off or configured properly.","firebug_warning_anchor":"Hide"});';
      						$str = $str . 'editorFormValidationHandler = wysiwyghomepage_element_8_three_two_style_image.onFormValidation.bind(wysiwyghomepage_element_8_three_two_style_image);';
      						$str = $str . 'Event.observe("togglehomepage_element_8_three_two_style_image", "click", wysiwyghomepage_element_8_three_two_style_image.toggle.bind(wysiwyghomepage_element_8_three_two_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("formSubmit", editorFormValidationHandler);';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceBeforeSetContent", wysiwyghomepage_element_8_three_two_style_image.beforeSetContent.bind(wysiwyghomepage_element_8_three_two_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceSaveContent", wysiwyghomepage_element_8_three_two_style_image.saveContent.bind(wysiwyghomepage_element_8_three_two_style_image));';
      						$str = $str . 'varienGlobalEvents.clearEventHandlers("open_browser_callback");';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("open_browser_callback", wysiwyghomepage_element_8_three_two_style_image.openFileBrowser.bind(wysiwyghomepage_element_8_three_two_style_image));';
      						$str = $str . '</script>';
      						$str = $str . '</tr>';
      						$str = $str . '</tbody>';
      						$str = $str . '</table>';
      						$str = $str . '<table cellspacing="0" class="form-list allpageelement" style="display: table-cell;">';
							$str = $str . '<tbody>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_three_three_style_title">Title:</label></td>';  
      						$str = $str . '<td class="value"><input id="homepage_element_8_three_three_style_title"  value="'.$collectiondata['homepage_element_8_three_three_style_title'].'" name="homepage_element_8_30_70_boxes_full_width[homepage_element_8_three_three_style_title]"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str .	'<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_three_three_style_link">Link:</label></td>';
      						$str = $str . '<td class="value"><input id="homepage_element_8_three_three_style_link" value="'.$collectiondata['homepage_element_8_three_three_style_link'].'" name="homepage_element_8_30_70_boxes_full_width[homepage_element_8_three_three_style_link]"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_three_three_style_target">Target:</label></td>';
      						$str = $str . '<td class="value">';
      						$str = $str . '<select id="homepage_element_8_three_three_style_target" name="homepage_element_8_30_70_boxes_full_width[homepage_element_8_three_three_style_target]" >';
      						foreach($targetarr as $targetarrkey => $targetarrvalue)
      						{
      							if($collectiondata['homepage_element_8_three_three_style_target']==$targetarrkey)
      							{
      								$str = $str . '<option value='.$targetarrkey.' selected>'.$targetarrvalue.'</option>';
      							}
      							else
      							{
      								$str = $str . '<option value='.$targetarrkey.'>'.$targetarrvalue.'</option>';
      							}
      						}
      						$str = $str . '</select>';
      						$str = $str . '</td>';
      						$str = $str . '</tr>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_three_three_style_image">Image:</label></td>';
      						//$str = $str . '<td class="value"><div id="buttonshomepage_element_8_three_three_style_image" class="buttons-set"><button type="button" class="scalable show-hide" style="" id="togglehomepage_element_8_three_three_style_image"><span><span><span>Show / Hide Editor</span></span></span></button><button type="button" class="scalable add-widget plugin" onclick="widgetTools.openDialog('.$baseurl.'evolved/widget/index/widget_target_id/homepage_element_8_three_three_style_image)" style=""><span><span><span>Insert Widget...</span></span></span></button><button type="button" class="scalable add-image plugin" onclick="MediabrowserUtility.openDialog('.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_8_three_three_style_image/)" style=""><span><span><span>Insert Image...</span></span></span></button><button type="button" class="scalable add-variable plugin" onclick="MagentovariablePlugin.loadChooser('.$baseurl.'evolved/system_variable/wysiwygPlugin/, homepage_element_8_three_three_style_image);"><span><span><span>Insert Variable...</span></span></span></button></div><textarea name="homepage_element_8_three_three_style_image" title="" id="homepage_element_8_three_three_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_8_three_three_style_image'].'</textarea><small>Image size must be 1920*480 pixels</small></td>';
      						$str = $str . '<td class="value"><button id="togglehomepage_element_8_three_three_style_image" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><div id="buttonshomepage_element_8_three_three_style_image" class="buttons-set"><button style="" onclick="MediabrowserUtility.openDialog(\''.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_8_three_three_style_image/\')" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button></div><textarea name="homepage_element_8_30_70_boxes_full_width[homepage_element_8_three_three_style_image]" title="" id="homepage_element_8_three_three_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_8_three_three_style_image'].'</textarea><small>Image size must be 1280*800 pixels</small></td>';
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
      						$str = $str . '}wysiwyghomepage_element_8_three_three_style_image = new tinyMceWysiwygSetup("homepage_element_8_three_three_style_image", {"enabled":true,"hidden":true,"use_container":false,"add_variables":true,"add_widgets":true,"add_images":true,"no_display":false,"translator":{},"encode_directives":true,"directives_url":"'.$baseurl.'evolved/cms_wysiwyg/directive/","popup_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/dialog.css","content_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/content.css","width":"100%","plugins":[{"name":"magentovariable","src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentovariable/editor_plugin.js","options":{"title":"Insert Variable...","url":"'.$baseurl.'evolved/system_variable/wysiwygPlugin/","onclick":{"search":["html_id"],"subject":"MagentovariablePlugin.loadChooser(\''.$baseurl.'evolved/system_variable/wysiwygPlugin/\', \'{{html_id}}\');"},"class":"add-variable plugin"}}],"directives_url_quoted":"'.$baseurl.'evolved/cms_wysiwyg/directive/","files_browser_window_url":"'.$baseurl.'idealAdmin/cms_wysiwyg_images/index/","files_browser_window_width":1000,"files_browser_window_height":600,"widget_plugin_src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentowidget/editor_plugin.js","widget_images_url":"'.$siteurl.'skin/adminhtml/default/default/images/widget/","widget_placeholders":["Thumbs.db","catalog__category_widget_link.gif","catalog__product_widget_link.gif","catalog__product_widget_new.gif","cms__widget_block.gif","cms__widget_page_link.gif","default.gif","reports__product_widget_compared.gif","reports__product_widget_viewed.gif"],"widget_window_url":"'.$baseurl.'evolved/widget/index/","firebug_warning_title":"Warning","firebug_warning_text":"Firebug is known to make the WYSIWYG editor slow unless it is turned off or configured properly.","firebug_warning_anchor":"Hide"});';
      						$str = $str . 'editorFormValidationHandler = wysiwyghomepage_element_8_three_three_style_image.onFormValidation.bind(wysiwyghomepage_element_8_three_three_style_image);';
      						$str = $str . 'Event.observe("togglehomepage_element_8_three_three_style_image", "click", wysiwyghomepage_element_8_three_three_style_image.toggle.bind(wysiwyghomepage_element_8_three_three_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("formSubmit", editorFormValidationHandler);';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceBeforeSetContent", wysiwyghomepage_element_8_three_three_style_image.beforeSetContent.bind(wysiwyghomepage_element_8_three_three_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceSaveContent", wysiwyghomepage_element_8_three_three_style_image.saveContent.bind(wysiwyghomepage_element_8_three_three_style_image));';
      						$str = $str . 'varienGlobalEvents.clearEventHandlers("open_browser_callback");';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("open_browser_callback", wysiwyghomepage_element_8_three_three_style_image.openFileBrowser.bind(wysiwyghomepage_element_8_three_three_style_image));';
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
	      					if($selectElement == 'homepage_element_8_70_30_boxes_full_width')
	      					{
	      						$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="homepage_element_8_70_30_boxes_full_width" style="display: block">';
	      					}
	      					else
	      					{
	      						$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="homepage_element_8_70_30_boxes_full_width"  style="display: none">';
	      					}
	      					//$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="70_30_boxes_full_width">';
	      					$str = $str . '<tbody>';
	      					$str = $str . '<tr>';
	      					$str = $str . '<td>';
      						$str = $str . '<table cellspacing="0" class="form-list allpageelement" style="display: table-cell;">';
							$str = $str . '<tbody>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_four_one_style_title">Title:</label></td>';  
      						$str = $str . '<td class="value"><input id="homepage_element_8_four_one_style_title"  value="'.$collectiondata['homepage_element_8_four_one_style_title'].'" name="homepage_element_8_70_30_boxes_full_width[homepage_element_8_four_one_style_title]"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_four_one_style_link">Link:</label></td>';
      						$str = $str . '<td class="value"><input id="homepage_element_8_four_one_style_link" value="'.$collectiondata['homepage_element_8_four_one_style_link'].'" name="homepage_element_8_70_30_boxes_full_width[homepage_element_8_four_one_style_link]"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_four_one_style_target">Target:</label></td>';
      						$str = $str . '<td class="value">';
      						$str = $str . '<select id="homepage_element_8_four_one_style_target" name="homepage_element_8_70_30_boxes_full_width[homepage_element_8_four_one_style_target]" >';
      						foreach($targetarr as $targetarrkey => $targetarrvalue)
      						{
      							if($collectiondata['homepage_element_8_four_one_style_target']==$targetarrkey)
      							{
      								$str = $str . '<option value='.$targetarrkey.' selected>'.$targetarrvalue.'</option>';
      							}
      							else
      							{
      								$str = $str . '<option value='.$targetarrkey.'>'.$targetarrvalue.'</option>';
      							}
      						}
      						$str = $str . '</select>';
      						$str = $str . '</td>';
      						$str = $str . '</tr>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_four_one_style_image">Image:</label></td>';
      						//$str = $str . '<td class="value"><div id="buttonshomepage_element_8_four_one_style_image" class="buttons-set"><button type="button" class="scalable show-hide" style="" id="togglehomepage_element_8_four_one_style_image"><span><span><span>Show / Hide Editor</span></span></span></button><button type="button" class="scalable add-widget plugin" onclick="widgetTools.openDialog('.$baseurl.'evolved/widget/index/widget_target_id/homepage_element_8_four_one_style_image)" style=""><span><span><span>Insert Widget...</span></span></span></button><button type="button" class="scalable add-image plugin" onclick="MediabrowserUtility.openDialog('.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_8_four_one_style_image/)" style=""><span><span><span>Insert Image...</span></span></span></button><button type="button" class="scalable add-variable plugin" onclick="MagentovariablePlugin.loadChooser('.$baseurl.'evolved/system_variable/wysiwygPlugin/, homepage_element_8_four_one_style_image);"><span><span><span>Insert Variable...</span></span></span></button></div><textarea name="homepage_element_8_four_one_style_image" title="" id="homepage_element_8_four_one_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_8_four_one_style_image'].'</textarea><small>Image size must be 1920*480 pixels</small></td>';
      						$str = $str . '<td class="value"><button id="togglehomepage_element_8_four_one_style_image" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><div id="buttonshomepage_element_8_four_one_style_image" class="buttons-set"><button style="" onclick="MediabrowserUtility.openDialog(\''.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_8_four_one_style_image/\')" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button></div><textarea name="homepage_element_8_70_30_boxes_full_width[homepage_element_8_four_one_style_image]" title="" id="homepage_element_8_four_one_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_8_four_one_style_image'].'</textarea><small>Image size must be 1280*800 pixels</small></td>';
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
      						$str = $str . '}wysiwyghomepage_element_8_four_one_style_image = new tinyMceWysiwygSetup("homepage_element_8_four_one_style_image", {"enabled":true,"hidden":true,"use_container":false,"add_variables":true,"add_widgets":true,"add_images":true,"no_display":false,"translator":{},"encode_directives":true,"directives_url":"'.$baseurl.'evolved/cms_wysiwyg/directive/","popup_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/dialog.css","content_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/content.css","width":"100%","plugins":[{"name":"magentovariable","src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentovariable/editor_plugin.js","options":{"title":"Insert Variable...","url":"'.$baseurl.'evolved/system_variable/wysiwygPlugin/","onclick":{"search":["html_id"],"subject":"MagentovariablePlugin.loadChooser(\''.$baseurl.'evolved/system_variable/wysiwygPlugin/\', \'{{html_id}}\');"},"class":"add-variable plugin"}}],"directives_url_quoted":"'.$baseurl.'evolved/cms_wysiwyg/directive/","files_browser_window_url":"'.$baseurl.'idealAdmin/cms_wysiwyg_images/index/","files_browser_window_width":1000,"files_browser_window_height":600,"widget_plugin_src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentowidget/editor_plugin.js","widget_images_url":"'.$siteurl.'skin/adminhtml/default/default/images/widget/","widget_placeholders":["Thumbs.db","catalog__category_widget_link.gif","catalog__product_widget_link.gif","catalog__product_widget_new.gif","cms__widget_block.gif","cms__widget_page_link.gif","default.gif","reports__product_widget_compared.gif","reports__product_widget_viewed.gif"],"widget_window_url":"'.$baseurl.'evolved/widget/index/","firebug_warning_title":"Warning","firebug_warning_text":"Firebug is known to make the WYSIWYG editor slow unless it is turned off or configured properly.","firebug_warning_anchor":"Hide"});';
      						$str = $str . 'editorFormValidationHandler = wysiwyghomepage_element_8_four_one_style_image.onFormValidation.bind(wysiwyghomepage_element_8_four_one_style_image);';
      						$str = $str . 'Event.observe("togglehomepage_element_8_four_one_style_image", "click", wysiwyghomepage_element_8_four_one_style_image.toggle.bind(wysiwyghomepage_element_8_four_one_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("formSubmit", editorFormValidationHandler);';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceBeforeSetContent", wysiwyghomepage_element_8_four_one_style_image.beforeSetContent.bind(wysiwyghomepage_element_8_four_one_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceSaveContent", wysiwyghomepage_element_8_four_one_style_image.saveContent.bind(wysiwyghomepage_element_8_four_one_style_image));';
      						$str = $str . 'varienGlobalEvents.clearEventHandlers("open_browser_callback");';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("open_browser_callback", wysiwyghomepage_element_8_four_one_style_image.openFileBrowser.bind(wysiwyghomepage_element_8_four_one_style_image));';
      						$str = $str . '</script>';
      						$str = $str . '</tr>';
      						$str = $str . '</tbody>';
      						$str = $str . '</table>'; 
      						$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelement" style="display: table-cell;">';
							$str = $str . '<tbody>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_four_two_style_title">Title:</label></td>';  
      						$str = $str . '<td class="value"><input id="homepage_element_8_four_two_style_title" value="'.$collectiondata['homepage_element_8_four_two_style_title'].'" name="homepage_element_8_70_30_boxes_full_width[homepage_element_8_four_two_style_title]"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str .	'<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_four_two_style_link">Link:</label></td>';
      						$str = $str . '<td class="value"><input id="homepage_element_8_four_two_style_link" value="'.$collectiondata['homepage_element_8_four_two_style_link'].'" name="homepage_element_8_70_30_boxes_full_width[homepage_element_8_four_two_style_link]"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_four_two_style_target">Target:</label></td>';
      						$str = $str . '<td class="value">';
      						$str = $str . '<select id="homepage_element_8_four_two_style_target" name="homepage_element_8_70_30_boxes_full_width[homepage_element_8_four_two_style_target]" >';
      						foreach($targetarr as $targetarrkey => $targetarrvalue)
      						{
      							if($collectiondata['homepage_element_8_four_two_style_target']==$targetarrkey)
      							{
      								$str = $str . '<option value='.$targetarrkey.' selected>'.$targetarrvalue.'</option>';
      							}
      							else
      							{
      								$str = $str . '<option value='.$targetarrkey.'>'.$targetarrvalue.'</option>';
      							}
      						}
      						$str = $str . '</select>';
      						$str = $str . '</td>';
      						$str = $str . '</tr>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_four_two_style_image">Image:</label></td>';
      						//$str = $str . '<td class="value"><div id="buttonshomepage_element_8_four_two_style_image" class="buttons-set"><button type="button" class="scalable show-hide" style="" id="togglehomepage_element_8_four_two_style_image"><span><span><span>Show / Hide Editor</span></span></span></button><button type="button" class="scalable add-widget plugin" onclick="widgetTools.openDialog('.$baseurl.'evolved/widget/index/widget_target_id/homepage_element_8_four_two_style_image)" style=""><span><span><span>Insert Widget...</span></span></span></button><button type="button" class="scalable add-image plugin" onclick="MediabrowserUtility.openDialog('.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_8_four_two_style_image/)" style=""><span><span><span>Insert Image...</span></span></span></button><button type="button" class="scalable add-variable plugin" onclick="MagentovariablePlugin.loadChooser('.$baseurl.'evolved/system_variable/wysiwygPlugin/, homepage_element_8_four_two_style_image);"><span><span><span>Insert Variable...</span></span></span></button></div><textarea name="homepage_element_8_four_two_style_image" title="" id="homepage_element_8_four_two_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_8_four_two_style_image'].'</textarea><small>Image size must be 1920*480 pixels</small></td>';
      						$str = $str . '<td class="value"><button id="togglehomepage_element_8_four_two_style_image" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><div id="buttonshomepage_element_8_four_two_style_image" class="buttons-set"><button style="" onclick="MediabrowserUtility.openDialog(\''.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_8_four_two_style_image/\')" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button></div><textarea name="homepage_element_8_70_30_boxes_full_width[homepage_element_8_four_two_style_image]" title="" id="homepage_element_8_four_two_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_8_four_two_style_image'].'</textarea><small>Image size must be 640*400 pixels</small></td>';
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
      						$str = $str . '}wysiwyghomepage_element_8_four_two_style_image = new tinyMceWysiwygSetup("homepage_element_8_four_two_style_image", {"enabled":true,"hidden":true,"use_container":false,"add_variables":true,"add_widgets":true,"add_images":true,"no_display":false,"translator":{},"encode_directives":true,"directives_url":"'.$baseurl.'evolved/cms_wysiwyg/directive/","popup_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/dialog.css","content_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/content.css","width":"100%","plugins":[{"name":"magentovariable","src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentovariable/editor_plugin.js","options":{"title":"Insert Variable...","url":"'.$baseurl.'evolved/system_variable/wysiwygPlugin/","onclick":{"search":["html_id"],"subject":"MagentovariablePlugin.loadChooser(\''.$baseurl.'evolved/system_variable/wysiwygPlugin/\', \'{{html_id}}\');"},"class":"add-variable plugin"}}],"directives_url_quoted":"'.$baseurl.'evolved/cms_wysiwyg/directive/","files_browser_window_url":"'.$baseurl.'idealAdmin/cms_wysiwyg_images/index/","files_browser_window_width":1000,"files_browser_window_height":600,"widget_plugin_src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentowidget/editor_plugin.js","widget_images_url":"'.$siteurl.'skin/adminhtml/default/default/images/widget/","widget_placeholders":["Thumbs.db","catalog__category_widget_link.gif","catalog__product_widget_link.gif","catalog__product_widget_new.gif","cms__widget_block.gif","cms__widget_page_link.gif","default.gif","reports__product_widget_compared.gif","reports__product_widget_viewed.gif"],"widget_window_url":"'.$baseurl.'evolved/widget/index/","firebug_warning_title":"Warning","firebug_warning_text":"Firebug is known to make the WYSIWYG editor slow unless it is turned off or configured properly.","firebug_warning_anchor":"Hide"});';
      						$str = $str . 'editorFormValidationHandler = wysiwyghomepage_element_8_four_two_style_image.onFormValidation.bind(wysiwyghomepage_element_8_four_two_style_image);';
      						$str = $str . 'Event.observe("togglehomepage_element_8_four_two_style_image", "click", wysiwyghomepage_element_8_four_two_style_image.toggle.bind(wysiwyghomepage_element_8_four_two_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("formSubmit", editorFormValidationHandler);';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceBeforeSetContent", wysiwyghomepage_element_8_four_two_style_image.beforeSetContent.bind(wysiwyghomepage_element_8_four_two_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceSaveContent", wysiwyghomepage_element_8_four_two_style_image.saveContent.bind(wysiwyghomepage_element_8_four_two_style_image));';
      						$str = $str . 'varienGlobalEvents.clearEventHandlers("open_browser_callback");';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("open_browser_callback", wysiwyghomepage_element_8_four_two_style_image.openFileBrowser.bind(wysiwyghomepage_element_8_four_two_style_image));';
      						$str = $str . '</script>';
      						$str = $str . '</tr>';
      						$str = $str . '</tbody>';
      						$str = $str . '</table>';
      						$str = $str . '<table cellspacing="0" class="form-list allpageelement" style="display: table-cell;">';
							$str = $str . '<tbody>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_four_three_style_title">Title:</label></td>';  
      						$str = $str . '<td class="value"><input id="homepage_element_8_four_three_style_title" value="'.$collectiondata['homepage_element_8_four_three_style_title'].'" name="homepage_element_8_70_30_boxes_full_width[homepage_element_8_four_three_style_title]"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_four_three_style_link">Link:</label></td>';
      						$str = $str . '<td class="value"><input id="homepage_element_8_four_three_style_link" value="'.$collectiondata['homepage_element_8_four_three_style_link'].'" name="homepage_element_8_70_30_boxes_full_width[homepage_element_8_four_three_style_link]"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_four_three_style_target">Target:</label></td>';
      						$str = $str . '<td class="value">';
      						$str = $str . '<select id="homepage_element_8_four_three_style_target" name="homepage_element_8_70_30_boxes_full_width[homepage_element_8_four_three_style_target]" >';
      						foreach($targetarr as $targetarrkey => $targetarrvalue)
      						{
      							if($collectiondata['homepage_element_8_four_three_style_target']==$targetarrkey)
      							{
      								$str = $str . '<option value='.$targetarrkey.' selected>'.$targetarrvalue.'</option>';
      							}
      							else
      							{
      								$str = $str . '<option value='.$targetarrkey.'>'.$targetarrvalue.'</option>';
      							}
      						}
      						$str = $str . '</select>';
      						$str = $str . '</td>';
      						$str = $str . '</tr>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_four_three_style_image">Image:</label></td>';
      						//$str = $str . '<td class="value"><div id="buttonshomepage_element_8_four_three_style_image" class="buttons-set"><button type="button" class="scalable show-hide" style="" id="togglehomepage_element_8_four_three_style_image"><span><span><span>Show / Hide Editor</span></span></span></button><button type="button" class="scalable add-widget plugin" onclick="widgetTools.openDialog('.$baseurl.'evolved/widget/index/widget_target_id/homepage_element_8_four_three_style_image)" style=""><span><span><span>Insert Widget...</span></span></span></button><button type="button" class="scalable add-image plugin" onclick="MediabrowserUtility.openDialog('.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_8_four_three_style_image/)" style=""><span><span><span>Insert Image...</span></span></span></button><button type="button" class="scalable add-variable plugin" onclick="MagentovariablePlugin.loadChooser('.$baseurl.'evolved/system_variable/wysiwygPlugin/, homepage_element_8_four_three_style_image);"><span><span><span>Insert Variable...</span></span></span></button></div><textarea name="homepage_element_8_four_three_style_image" title="" id="homepage_element_8_four_three_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_8_four_three_style_image'].'</textarea><small>Image size must be 1920*480 pixels</small></td>';
      						$str = $str . '<td class="value"><button id="togglehomepage_element_8_four_three_style_image" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><div id="buttonshomepage_element_8_four_three_style_image" class="buttons-set"><button style="" onclick="MediabrowserUtility.openDialog(\''.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_8_four_three_style_image/\')" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button></div><textarea name="homepage_element_8_70_30_boxes_full_width[homepage_element_8_four_three_style_image]" title="" id="homepage_element_8_four_three_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_8_four_three_style_image'].'</textarea><small>Image size must be 640*400 pixels</small></td>';
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
      						$str = $str . '}wysiwyghomepage_element_8_four_three_style_image = new tinyMceWysiwygSetup("homepage_element_8_four_three_style_image", {"enabled":true,"hidden":true,"use_container":false,"add_variables":true,"add_widgets":true,"add_images":true,"no_display":false,"translator":{},"encode_directives":true,"directives_url":"'.$baseurl.'evolved/cms_wysiwyg/directive/","popup_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/dialog.css","content_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/content.css","width":"100%","plugins":[{"name":"magentovariable","src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentovariable/editor_plugin.js","options":{"title":"Insert Variable...","url":"'.$baseurl.'evolved/system_variable/wysiwygPlugin/","onclick":{"search":["html_id"],"subject":"MagentovariablePlugin.loadChooser(\''.$baseurl.'evolved/system_variable/wysiwygPlugin/\', \'{{html_id}}\');"},"class":"add-variable plugin"}}],"directives_url_quoted":"'.$baseurl.'evolved/cms_wysiwyg/directive/","files_browser_window_url":"'.$baseurl.'idealAdmin/cms_wysiwyg_images/index/","files_browser_window_width":1000,"files_browser_window_height":600,"widget_plugin_src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentowidget/editor_plugin.js","widget_images_url":"'.$siteurl.'skin/adminhtml/default/default/images/widget/","widget_placeholders":["Thumbs.db","catalog__category_widget_link.gif","catalog__product_widget_link.gif","catalog__product_widget_new.gif","cms__widget_block.gif","cms__widget_page_link.gif","default.gif","reports__product_widget_compared.gif","reports__product_widget_viewed.gif"],"widget_window_url":"'.$baseurl.'evolved/widget/index/","firebug_warning_title":"Warning","firebug_warning_text":"Firebug is known to make the WYSIWYG editor slow unless it is turned off or configured properly.","firebug_warning_anchor":"Hide"});';
      						$str = $str . 'editorFormValidationHandler = wysiwyghomepage_element_8_four_three_style_image.onFormValidation.bind(wysiwyghomepage_element_8_four_three_style_image);';
      						$str = $str . 'Event.observe("togglehomepage_element_8_four_three_style_image", "click", wysiwyghomepage_element_8_four_three_style_image.toggle.bind(wysiwyghomepage_element_8_four_three_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("formSubmit", editorFormValidationHandler);';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceBeforeSetContent", wysiwyghomepage_element_8_four_three_style_image.beforeSetContent.bind(wysiwyghomepage_element_8_four_three_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceSaveContent", wysiwyghomepage_element_8_four_three_style_image.saveContent.bind(wysiwyghomepage_element_8_four_three_style_image));';
      						$str = $str . 'varienGlobalEvents.clearEventHandlers("open_browser_callback");';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("open_browser_callback", wysiwyghomepage_element_8_four_three_style_image.openFileBrowser.bind(wysiwyghomepage_element_8_four_three_style_image));';
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
      						if($selectElement == 'homepage_element_8_33_percentage_640_by_400_three_boxes_full_width')
      						{
      							$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="homepage_element_8_33_percentage_640_by_400_three_boxes_full_width" style="display: block">';
      						}
      						else
      						{
      							$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="homepage_element_8_33_percentage_640_by_400_three_boxes_full_width"  style="display: none">';
      						}
      						//$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="33_percentage_640_by_400_three_boxes_full_width">';
      						$str = $str . '<tbody>';
      						$str = $str . '<tr>';
      						$str = $str . '<td>';
      						$str = $str . '<table cellspacing="0" class="form-list allpageelement" style="display: table-cell;">';
							$str = $str . '<tbody>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_five_one_style_title">Title:</label></td>';  
      						$str = $str . '<td class="value"><input id="homepage_element_8_five_one_style_title" value="'.$collectiondata['homepage_element_8_five_one_style_title'].'" name="homepage_element_8_33_percentage_640_by_400_three_boxes_full_width[homepage_element_8_five_one_style_title]"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_five_one_style_link">Link:</label></td>';
      						$str = $str . '<td class="value"><input id="homepage_element_8_five_one_style_link" value="'.$collectiondata['homepage_element_8_five_one_style_link'].'" name="homepage_element_8_33_percentage_640_by_400_three_boxes_full_width[homepage_element_8_five_one_style_link]"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_five_one_style_target">Target:</label></td>';
      						$str = $str . '<td class="value">';
      						$str = $str . '<select id="homepage_element_8_five_one_style_target" name="homepage_element_8_33_percentage_640_by_400_three_boxes_full_width[homepage_element_8_five_one_style_target]" >';
      						foreach($targetarr as $targetarrkey => $targetarrvalue)
      						{
      							if($collectiondata['homepage_element_8_five_one_style_target']==$targetarrkey)
      							{
      								$str = $str . '<option value='.$targetarrkey.' selected>'.$targetarrvalue.'</option>';
      							}
      							else
      							{
      								$str = $str . '<option value='.$targetarrkey.'>'.$targetarrvalue.'</option>';
      							}
      						}
      						$str = $str . '</select>';
      						$str = $str . '</td>';
      						$str = $str . '</tr>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_five_one_style_image">Image:</label></td>';
      						//$str = $str . '<td class="value"><div id="buttonshomepage_element_8_five_one_style_image" class="buttons-set"><button type="button" class="scalable show-hide" style="" id="togglehomepage_element_8_five_one_style_image"><span><span><span>Show / Hide Editor</span></span></span></button><button type="button" class="scalable add-widget plugin" onclick="widgetTools.openDialog('.$baseurl.'evolved/widget/index/widget_target_id/homepage_element_8_five_one_style_image)" style=""><span><span><span>Insert Widget...</span></span></span></button><button type="button" class="scalable add-image plugin" onclick="MediabrowserUtility.openDialog('.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_8_five_one_style_image/)" style=""><span><span><span>Insert Image...</span></span></span></button><button type="button" class="scalable add-variable plugin" onclick="MagentovariablePlugin.loadChooser('.$baseurl.'evolved/system_variable/wysiwygPlugin/, homepage_element_8_five_one_style_image);"><span><span><span>Insert Variable...</span></span></span></button></div><textarea name="homepage_element_8_five_one_style_image" title="" id="homepage_element_8_five_one_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_8_five_one_style_image'].'</textarea><small>Image size must be 1920*480 pixels</small></td>';
      						$str = $str . '<td class="value"><button id="togglehomepage_element_8_five_one_style_image" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><div id="buttonshomepage_element_8_five_one_style_image" class="buttons-set"><button style="" onclick="MediabrowserUtility.openDialog(\''.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_8_five_one_style_image/\')" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button></div><textarea name="homepage_element_8_33_percentage_640_by_400_three_boxes_full_width[homepage_element_8_five_one_style_image]" title="" id="homepage_element_8_five_one_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_8_five_one_style_image'].'</textarea><small>Image size must be 640*400 pixels</small></td>';
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
      						$str = $str . '}wysiwyghomepage_element_8_five_one_style_image = new tinyMceWysiwygSetup("homepage_element_8_five_one_style_image", {"enabled":true,"hidden":true,"use_container":false,"add_variables":true,"add_widgets":true,"add_images":true,"no_display":false,"translator":{},"encode_directives":true,"directives_url":"'.$baseurl.'evolved/cms_wysiwyg/directive/","popup_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/dialog.css","content_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/content.css","width":"100%","plugins":[{"name":"magentovariable","src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentovariable/editor_plugin.js","options":{"title":"Insert Variable...","url":"'.$baseurl.'evolved/system_variable/wysiwygPlugin/","onclick":{"search":["html_id"],"subject":"MagentovariablePlugin.loadChooser(\''.$baseurl.'evolved/system_variable/wysiwygPlugin/\', \'{{html_id}}\');"},"class":"add-variable plugin"}}],"directives_url_quoted":"'.$baseurl.'evolved/cms_wysiwyg/directive/","files_browser_window_url":"'.$baseurl.'idealAdmin/cms_wysiwyg_images/index/","files_browser_window_width":1000,"files_browser_window_height":600,"widget_plugin_src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentowidget/editor_plugin.js","widget_images_url":"'.$siteurl.'skin/adminhtml/default/default/images/widget/","widget_placeholders":["Thumbs.db","catalog__category_widget_link.gif","catalog__product_widget_link.gif","catalog__product_widget_new.gif","cms__widget_block.gif","cms__widget_page_link.gif","default.gif","reports__product_widget_compared.gif","reports__product_widget_viewed.gif"],"widget_window_url":"'.$baseurl.'evolved/widget/index/","firebug_warning_title":"Warning","firebug_warning_text":"Firebug is known to make the WYSIWYG editor slow unless it is turned off or configured properly.","firebug_warning_anchor":"Hide"});';
      						$str = $str . 'editorFormValidationHandler = wysiwyghomepage_element_8_five_one_style_image.onFormValidation.bind(wysiwyghomepage_element_8_five_one_style_image);';
      						$str = $str . 'Event.observe("togglehomepage_element_8_five_one_style_image", "click", wysiwyghomepage_element_8_five_one_style_image.toggle.bind(wysiwyghomepage_element_8_five_one_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("formSubmit", editorFormValidationHandler);';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceBeforeSetContent", wysiwyghomepage_element_8_five_one_style_image.beforeSetContent.bind(wysiwyghomepage_element_8_five_one_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceSaveContent", wysiwyghomepage_element_8_five_one_style_image.saveContent.bind(wysiwyghomepage_element_8_five_one_style_image));';
      						$str = $str . 'varienGlobalEvents.clearEventHandlers("open_browser_callback");';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("open_browser_callback", wysiwyghomepage_element_8_five_one_style_image.openFileBrowser.bind(wysiwyghomepage_element_8_five_one_style_image));';
      						$str = $str . '</script>';
      						$str = $str . '</tr>';
      						$str = $str . '</tbody>';
      						$str = $str . '</table>'; 
      						$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelement" style="display: table-cell;">';
							$str = $str . '<tbody>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_five_two_style_title">Title:</label></td>';  
      						$str = $str . '<td class="value"><input id="homepage_element_8_five_two_style_title"  value="'.$collectiondata['homepage_element_8_five_two_style_title'].'" name="homepage_element_8_33_percentage_640_by_400_three_boxes_full_width[homepage_element_8_five_two_style_title]"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_five_two_style_link">Link:</label></td>';
      						$str = $str . '<td class="value"><input id="homepage_element_8_five_two_style_link" value="'.$collectiondata['homepage_element_8_five_two_style_link'].'" name="homepage_element_8_33_percentage_640_by_400_three_boxes_full_width[homepage_element_8_five_two_style_link]"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_five_two_style_target">Target:</label></td>';
      						$str = $str . '<td class="value">';
      						$str = $str . '<select id="homepage_element_8_five_two_style_target" name="homepage_element_8_33_percentage_640_by_400_three_boxes_full_width[homepage_element_8_five_two_style_target]" >';
      						foreach($targetarr as $targetarrkey => $targetarrvalue)
      						{
      							if($collectiondata['homepage_element_8_five_two_style_target']==$targetarrkey)
      							{
      								$str = $str . '<option value='.$targetarrkey.' selected>'.$targetarrvalue.'</option>';
      							}
      							else
      							{
      								$str = $str . '<option value='.$targetarrkey.'>'.$targetarrvalue.'</option>';
      							}
      						}
      						$str = $str . '</select>';
      						$str = $str . '</td>';
      						$str = $str . '</tr>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_five_two_style_image">Image:</label></td>';
      						//$str = $str . '<td class="value"><div id="buttonshomepage_element_8_five_two_style_image" class="buttons-set"><button type="button" class="scalable show-hide" style="" id="togglehomepage_element_8_five_two_style_image"><span><span><span>Show / Hide Editor</span></span></span></button><button type="button" class="scalable add-widget plugin" onclick="widgetTools.openDialog('.$baseurl.'evolved/widget/index/widget_target_id/homepage_element_8_five_two_style_image)" style=""><span><span><span>Insert Widget...</span></span></span></button><button type="button" class="scalable add-image plugin" onclick="MediabrowserUtility.openDialog('.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_8_five_two_style_image/)" style=""><span><span><span>Insert Image...</span></span></span></button><button type="button" class="scalable add-variable plugin" onclick="MagentovariablePlugin.loadChooser('.$baseurl.'evolved/system_variable/wysiwygPlugin/, homepage_element_8_five_two_style_image);"><span><span><span>Insert Variable...</span></span></span></button></div><textarea name="homepage_element_8_five_two_style_image" title="" id="homepage_element_8_five_two_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_8_five_two_style_image'].'</textarea><small>Image size must be 1920*480 pixels</small></td>';
      						$str = $str . '<td class="value"><button id="togglehomepage_element_8_five_two_style_image" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><div id="buttonshomepage_element_8_five_two_style_image" class="buttons-set"><button style="" onclick="MediabrowserUtility.openDialog(\''.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_8_five_two_style_image/\')" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button></div><textarea name="homepage_element_8_33_percentage_640_by_400_three_boxes_full_width[homepage_element_8_five_two_style_image]" title="" id="homepage_element_8_five_two_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_8_five_two_style_image'].'</textarea><small>Image size must be 640*400 pixels</small></td>';
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
      						$str = $str . '}wysiwyghomepage_element_8_five_two_style_image = new tinyMceWysiwygSetup("homepage_element_8_five_two_style_image", {"enabled":true,"hidden":true,"use_container":false,"add_variables":true,"add_widgets":true,"add_images":true,"no_display":false,"translator":{},"encode_directives":true,"directives_url":"'.$baseurl.'evolved/cms_wysiwyg/directive/","popup_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/dialog.css","content_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/content.css","width":"100%","plugins":[{"name":"magentovariable","src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentovariable/editor_plugin.js","options":{"title":"Insert Variable...","url":"'.$baseurl.'evolved/system_variable/wysiwygPlugin/","onclick":{"search":["html_id"],"subject":"MagentovariablePlugin.loadChooser(\''.$baseurl.'evolved/system_variable/wysiwygPlugin/\', \'{{html_id}}\');"},"class":"add-variable plugin"}}],"directives_url_quoted":"'.$baseurl.'evolved/cms_wysiwyg/directive/","files_browser_window_url":"'.$baseurl.'idealAdmin/cms_wysiwyg_images/index/","files_browser_window_width":1000,"files_browser_window_height":600,"widget_plugin_src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentowidget/editor_plugin.js","widget_images_url":"'.$siteurl.'skin/adminhtml/default/default/images/widget/","widget_placeholders":["Thumbs.db","catalog__category_widget_link.gif","catalog__product_widget_link.gif","catalog__product_widget_new.gif","cms__widget_block.gif","cms__widget_page_link.gif","default.gif","reports__product_widget_compared.gif","reports__product_widget_viewed.gif"],"widget_window_url":"'.$baseurl.'evolved/widget/index/","firebug_warning_title":"Warning","firebug_warning_text":"Firebug is known to make the WYSIWYG editor slow unless it is turned off or configured properly.","firebug_warning_anchor":"Hide"});';
      						$str = $str . 'editorFormValidationHandler = wysiwyghomepage_element_8_five_two_style_image.onFormValidation.bind(wysiwyghomepage_element_8_five_two_style_image);';
      						$str = $str . 'Event.observe("togglehomepage_element_8_five_two_style_image", "click", wysiwyghomepage_element_8_five_two_style_image.toggle.bind(wysiwyghomepage_element_8_five_two_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("formSubmit", editorFormValidationHandler);';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceBeforeSetContent", wysiwyghomepage_element_8_five_two_style_image.beforeSetContent.bind(wysiwyghomepage_element_8_five_two_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceSaveContent", wysiwyghomepage_element_8_five_two_style_image.saveContent.bind(wysiwyghomepage_element_8_five_two_style_image));';
      						$str = $str . 'varienGlobalEvents.clearEventHandlers("open_browser_callback");';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("open_browser_callback", wysiwyghomepage_element_8_five_two_style_image.openFileBrowser.bind(wysiwyghomepage_element_8_five_two_style_image));';
      						$str = $str . '</script>';
      						$str = $str . '</tr>';
      						$str = $str . '</tbody>';
      						$str = $str . '</table>';
      						$str = $str . '<table cellspacing="0" class="form-list allpageelement" style="display: table-cell;">';
							$str = $str . '<tbody>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_five_three_style_title">Title:</label></td>';  
      						$str = $str . '<td class="value"><input id="homepage_element_8_five_three_style_title"  value="'.$collectiondata['homepage_element_8_five_three_style_title'].'" name="homepage_element_8_33_percentage_640_by_400_three_boxes_full_width[homepage_element_8_five_three_style_title]"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_five_three_style_link">Link:</label></td>';
      						$str = $str . '<td class="value"><input id="homepage_element_8_five_three_style_link" value="'.$collectiondata['homepage_element_8_five_three_style_link'].'" name="homepage_element_8_33_percentage_640_by_400_three_boxes_full_width[homepage_element_8_five_three_style_link]"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_five_three_style_target">Target:</label></td>';
      						$str = $str . '<td class="value">';
      						$str = $str . '<select id="homepage_element_8_five_three_style_target" name="homepage_element_8_33_percentage_640_by_400_three_boxes_full_width[homepage_element_8_five_three_style_target]" >';
      						foreach($targetarr as $targetarrkey => $targetarrvalue)
      						{
      							if($collectiondata['homepage_element_8_five_three_style_target']==$targetarrkey)
      							{
      								$str = $str . '<option value='.$targetarrkey.' selected>'.$targetarrvalue.'</option>';
      							}
      							else
      							{
      								$str = $str . '<option value='.$targetarrkey.'>'.$targetarrvalue.'</option>';
      							}
      						}
      						$str = $str . '</select>';
      						$str = $str . '</td>';
      						$str = $str . '</tr>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_five_three_style_image">Image:</label></td>';
      						//$str = $str . '<td class="value"><div id="buttonshomepage_element_8_five_three_style_image" class="buttons-set"><button type="button" class="scalable show-hide" style="" id="togglehomepage_element_8_five_three_style_image"><span><span><span>Show / Hide Editor</span></span></span></button><button type="button" class="scalable add-widget plugin" onclick="widgetTools.openDialog('.$baseurl.'evolved/widget/index/widget_target_id/homepage_element_8_five_three_style_image)" style=""><span><span><span>Insert Widget...</span></span></span></button><button type="button" class="scalable add-image plugin" onclick="MediabrowserUtility.openDialog('.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_8_five_three_style_image/)" style=""><span><span><span>Insert Image...</span></span></span></button><button type="button" class="scalable add-variable plugin" onclick="MagentovariablePlugin.loadChooser('.$baseurl.'evolved/system_variable/wysiwygPlugin/, homepage_element_8_five_three_style_image);"><span><span><span>Insert Variable...</span></span></span></button></div><textarea name="homepage_element_8_five_three_style_image" title="" id="homepage_element_8_five_three_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_8_five_three_style_image'].'</textarea><small>Image size must be 1920*480 pixels</small></td>';
      						$str = $str . '<td class="value"><button id="togglehomepage_element_8_five_three_style_image" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><div id="buttonshomepage_element_8_five_three_style_image" class="buttons-set"><button style="" onclick="MediabrowserUtility.openDialog(\''.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_8_five_three_style_image/\')" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button></div><textarea name="homepage_element_8_33_percentage_640_by_400_three_boxes_full_width[homepage_element_8_five_three_style_image]" title="" id="homepage_element_8_five_three_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_8_five_three_style_image'].'</textarea><small>Image size must be 640*400 pixels</small></td>';
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
      						$str = $str . '}wysiwyghomepage_element_8_five_three_style_image = new tinyMceWysiwygSetup("homepage_element_8_five_three_style_image", {"enabled":true,"hidden":true,"use_container":false,"add_variables":true,"add_widgets":true,"add_images":true,"no_display":false,"translator":{},"encode_directives":true,"directives_url":"'.$baseurl.'evolved/cms_wysiwyg/directive/","popup_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/dialog.css","content_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/content.css","width":"100%","plugins":[{"name":"magentovariable","src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentovariable/editor_plugin.js","options":{"title":"Insert Variable...","url":"'.$baseurl.'evolved/system_variable/wysiwygPlugin/","onclick":{"search":["html_id"],"subject":"MagentovariablePlugin.loadChooser(\''.$baseurl.'evolved/system_variable/wysiwygPlugin/\', \'{{html_id}}\');"},"class":"add-variable plugin"}}],"directives_url_quoted":"'.$baseurl.'evolved/cms_wysiwyg/directive/","files_browser_window_url":"'.$baseurl.'idealAdmin/cms_wysiwyg_images/index/","files_browser_window_width":1000,"files_browser_window_height":600,"widget_plugin_src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentowidget/editor_plugin.js","widget_images_url":"'.$siteurl.'skin/adminhtml/default/default/images/widget/","widget_placeholders":["Thumbs.db","catalog__category_widget_link.gif","catalog__product_widget_link.gif","catalog__product_widget_new.gif","cms__widget_block.gif","cms__widget_page_link.gif","default.gif","reports__product_widget_compared.gif","reports__product_widget_viewed.gif"],"widget_window_url":"'.$baseurl.'evolved/widget/index/","firebug_warning_title":"Warning","firebug_warning_text":"Firebug is known to make the WYSIWYG editor slow unless it is turned off or configured properly.","firebug_warning_anchor":"Hide"});';
      						$str = $str . 'editorFormValidationHandler = wysiwyghomepage_element_8_five_three_style_image.onFormValidation.bind(wysiwyghomepage_element_8_five_three_style_image);';
      						$str = $str . 'Event.observe("togglehomepage_element_8_five_three_style_image", "click", wysiwyghomepage_element_8_five_three_style_image.toggle.bind(wysiwyghomepage_element_8_five_three_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("formSubmit", editorFormValidationHandler);';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceBeforeSetContent", wysiwyghomepage_element_8_five_three_style_image.beforeSetContent.bind(wysiwyghomepage_element_8_five_three_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceSaveContent", wysiwyghomepage_element_8_five_three_style_image.saveContent.bind(wysiwyghomepage_element_8_five_three_style_image));';
      						$str = $str . 'varienGlobalEvents.clearEventHandlers("open_browser_callback");';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("open_browser_callback", wysiwyghomepage_element_8_five_three_style_image.openFileBrowser.bind(wysiwyghomepage_element_8_five_three_style_image));';
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
      						if($selectElement == 'homepage_element_8_25_percentage_480_by_400_four_boxes_full_width')
      						{
      							$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="homepage_element_8_25_percentage_480_by_400_four_boxes_full_width" style="display: block">';
      						}
      						else
      						{
      							$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="homepage_element_8_25_percentage_480_by_400_four_boxes_full_width"  style="display: none">';
      						}
      						//$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="25_percentage_480_by_400_four_boxes_full_width">';
      						$str = $str . '<tbody>';
      						$str = $str . '<tr>';
      						$str = $str . '<td>';
      						$str = $str . '<table cellspacing="0" class="form-list allpageelement" style="display: table-cell;">';
							$str = $str . '<tbody>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_six_one_style_title">Title:</label></td>';  
      						$str = $str . '<td class="value"><input id="homepage_element_8_six_one_style_title" value="'.$collectiondata['homepage_element_8_six_one_style_title'].'" name="homepage_element_8_25_percentage_480_by_400_four_boxes_full_width[homepage_element_8_six_one_style_title]"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_six_one_style_link">Link:</label></td>';
      						$str = $str . '<td class="value"><input id="homepage_element_8_six_one_style_link" value="'.$collectiondata['homepage_element_8_six_one_style_link'].'" name="homepage_element_8_25_percentage_480_by_400_four_boxes_full_width[homepage_element_8_six_one_style_link]"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_six_one_style_target">Target:</label></td>';
      						$str = $str . '<td class="value">';
      						$str = $str . '<select id="homepage_element_8_six_one_style_target" name="homepage_element_8_25_percentage_480_by_400_four_boxes_full_width[homepage_element_8_six_one_style_target]" >';
      						foreach($targetarr as $targetarrkey => $targetarrvalue)
      						{
      							if($collectiondata['homepage_element_8_six_one_style_target']==$targetarrkey)
      							{
      								$str = $str . '<option value='.$targetarrkey.' selected>'.$targetarrvalue.'</option>';
      							}
      							else
      							{
      								$str = $str . '<option value='.$targetarrkey.'>'.$targetarrvalue.'</option>';
      							}
      						}
      						$str = $str . '</select>';
      						$str = $str . '</td>';
      						$str = $str . '</tr>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_six_one_style_image">Image:</label></td>';
      						//$str = $str . '<td class="value"><div id="buttonshomepage_element_8_six_one_style_image" class="buttons-set"><button type="button" class="scalable show-hide" style="" id="togglehomepage_element_8_six_one_style_image"><span><span><span>Show / Hide Editor</span></span></span></button><button type="button" class="scalable add-widget plugin" onclick="widgetTools.openDialog('.$baseurl.'evolved/widget/index/widget_target_id/homepage_element_8_six_one_style_image)" style=""><span><span><span>Insert Widget...</span></span></span></button><button type="button" class="scalable add-image plugin" onclick="MediabrowserUtility.openDialog('.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_8_six_one_style_image/)" style=""><span><span><span>Insert Image...</span></span></span></button><button type="button" class="scalable add-variable plugin" onclick="MagentovariablePlugin.loadChooser('.$baseurl.'evolved/system_variable/wysiwygPlugin/, homepage_element_8_six_one_style_image);"><span><span><span>Insert Variable...</span></span></span></button></div><textarea name="homepage_element_8_six_one_style_image" title="" id="homepage_element_8_six_one_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_8_six_one_style_image'].'</textarea><small>Image size must be 1920*480 pixels</small></td>';
      						$str = $str . '<td class="value"><button id="togglehomepage_element_8_six_one_style_image" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><div id="buttonshomepage_element_8_six_one_style_image" class="buttons-set"><button style="" onclick="MediabrowserUtility.openDialog(\''.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_8_six_one_style_image/\')" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button></div><textarea name="homepage_element_8_25_percentage_480_by_400_four_boxes_full_width[homepage_element_8_six_one_style_image]" title="" id="homepage_element_8_six_one_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_8_six_one_style_image'].'</textarea><small>Image size must be 480*400 pixels</small></td>';
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
      						$str = $str . '}wysiwyghomepage_element_8_six_one_style_image = new tinyMceWysiwygSetup("homepage_element_8_six_one_style_image", {"enabled":true,"hidden":true,"use_container":false,"add_variables":true,"add_widgets":true,"add_images":true,"no_display":false,"translator":{},"encode_directives":true,"directives_url":"'.$baseurl.'evolved/cms_wysiwyg/directive/","popup_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/dialog.css","content_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/content.css","width":"100%","plugins":[{"name":"magentovariable","src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentovariable/editor_plugin.js","options":{"title":"Insert Variable...","url":"'.$baseurl.'evolved/system_variable/wysiwygPlugin/","onclick":{"search":["html_id"],"subject":"MagentovariablePlugin.loadChooser(\''.$baseurl.'evolved/system_variable/wysiwygPlugin/\', \'{{html_id}}\');"},"class":"add-variable plugin"}}],"directives_url_quoted":"'.$baseurl.'evolved/cms_wysiwyg/directive/","files_browser_window_url":"'.$baseurl.'idealAdmin/cms_wysiwyg_images/index/","files_browser_window_width":1000,"files_browser_window_height":600,"widget_plugin_src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentowidget/editor_plugin.js","widget_images_url":"'.$siteurl.'skin/adminhtml/default/default/images/widget/","widget_placeholders":["Thumbs.db","catalog__category_widget_link.gif","catalog__product_widget_link.gif","catalog__product_widget_new.gif","cms__widget_block.gif","cms__widget_page_link.gif","default.gif","reports__product_widget_compared.gif","reports__product_widget_viewed.gif"],"widget_window_url":"'.$baseurl.'evolved/widget/index/","firebug_warning_title":"Warning","firebug_warning_text":"Firebug is known to make the WYSIWYG editor slow unless it is turned off or configured properly.","firebug_warning_anchor":"Hide"});';
      						$str = $str . 'editorFormValidationHandler = wysiwyghomepage_element_8_six_one_style_image.onFormValidation.bind(wysiwyghomepage_element_8_six_one_style_image);';
      						$str = $str . 'Event.observe("togglehomepage_element_8_six_one_style_image", "click", wysiwyghomepage_element_8_six_one_style_image.toggle.bind(wysiwyghomepage_element_8_six_one_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("formSubmit", editorFormValidationHandler);';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceBeforeSetContent", wysiwyghomepage_element_8_six_one_style_image.beforeSetContent.bind(wysiwyghomepage_element_8_six_one_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceSaveContent", wysiwyghomepage_element_8_six_one_style_image.saveContent.bind(wysiwyghomepage_element_8_six_one_style_image));';
      						$str = $str . 'varienGlobalEvents.clearEventHandlers("open_browser_callback");';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("open_browser_callback", wysiwyghomepage_element_8_six_one_style_image.openFileBrowser.bind(wysiwyghomepage_element_8_six_one_style_image));';
      						$str = $str . '</script>';
      						$str = $str . '</tr>';
      						$str = $str . '</tbody>';
      						$str = $str . '</table>'; 
      						$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelement" style="display: table-cell;">';
							$str = $str . '<tbody>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_six_two_style_title">Title:</label></td>';  
      						$str = $str . '<td class="value"><input id="homepage_element_8_six_two_style_title" value="'.$collectiondata['homepage_element_8_six_two_style_title'].'" name="homepage_element_8_25_percentage_480_by_400_four_boxes_full_width[homepage_element_8_six_two_style_title]"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_six_two_style_link">Link:</label></td>';
      						$str = $str . '<td class="value"><input id="homepage_element_8_six_two_style_link" value="'.$collectiondata['homepage_element_8_six_two_style_link'].'" name="homepage_element_8_25_percentage_480_by_400_four_boxes_full_width[homepage_element_8_six_two_style_link]"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_six_two_style_target">Target:</label></td>';
      						$str = $str . '<td class="value">';
      						$str = $str . '<select id="homepage_element_8_six_two_style_target" name="homepage_element_8_25_percentage_480_by_400_four_boxes_full_width[homepage_element_8_six_two_style_target]" >';
      						foreach($targetarr as $targetarrkey => $targetarrvalue)
      						{
      							if($collectiondata['homepage_element_8_six_two_style_target']==$targetarrkey)
      							{
      								$str = $str . '<option value='.$targetarrkey.' selected>'.$targetarrvalue.'</option>';
      							}
      							else
      							{
      								$str = $str . '<option value='.$targetarrkey.'>'.$targetarrvalue.'</option>';
      							}
      						}
      						$str = $str . '</select>';
      						$str = $str . '</td>';
      						$str = $str . '</tr>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_six_two_style_image">Image:</label></td>';
      						//$str = $str . '<td class="value"><div id="buttonshomepage_element_8_six_two_style_image" class="buttons-set"><button type="button" class="scalable show-hide" style="" id="togglehomepage_element_8_six_two_style_image"><span><span><span>Show / Hide Editor</span></span></span></button><button type="button" class="scalable add-widget plugin" onclick="widgetTools.openDialog('.$baseurl.'evolved/widget/index/widget_target_id/homepage_element_8_six_two_style_image)" style=""><span><span><span>Insert Widget...</span></span></span></button><button type="button" class="scalable add-image plugin" onclick="MediabrowserUtility.openDialog('.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_8_six_two_style_image/)" style=""><span><span><span>Insert Image...</span></span></span></button><button type="button" class="scalable add-variable plugin" onclick="MagentovariablePlugin.loadChooser('.$baseurl.'evolved/system_variable/wysiwygPlugin/, homepage_element_8_six_two_style_image);"><span><span><span>Insert Variable...</span></span></span></button></div><textarea name="homepage_element_8_six_two_style_image" title="" id="homepage_element_8_six_two_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_8_six_two_style_image'].'</textarea><small>Image size must be 1920*480 pixels</small></td>';
      						$str = $str . '<td class="value"><button id="togglehomepage_element_8_six_two_style_image" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><div id="buttonshomepage_element_8_six_two_style_image" class="buttons-set"><button style="" onclick="MediabrowserUtility.openDialog(\''.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_8_six_two_style_image/\')" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button></div><textarea name="homepage_element_8_25_percentage_480_by_400_four_boxes_full_width[homepage_element_8_six_two_style_image]" title="" id="homepage_element_8_six_two_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_8_six_two_style_image'].'</textarea><small>Image size must be 480*400 pixels</small></td>';
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
      						$str = $str . '}wysiwyghomepage_element_8_six_two_style_image = new tinyMceWysiwygSetup("homepage_element_8_six_two_style_image", {"enabled":true,"hidden":true,"use_container":false,"add_variables":true,"add_widgets":true,"add_images":true,"no_display":false,"translator":{},"encode_directives":true,"directives_url":"'.$baseurl.'evolved/cms_wysiwyg/directive/","popup_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/dialog.css","content_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/content.css","width":"100%","plugins":[{"name":"magentovariable","src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentovariable/editor_plugin.js","options":{"title":"Insert Variable...","url":"'.$baseurl.'evolved/system_variable/wysiwygPlugin/","onclick":{"search":["html_id"],"subject":"MagentovariablePlugin.loadChooser(\''.$baseurl.'evolved/system_variable/wysiwygPlugin/\', \'{{html_id}}\');"},"class":"add-variable plugin"}}],"directives_url_quoted":"'.$baseurl.'evolved/cms_wysiwyg/directive/","files_browser_window_url":"'.$baseurl.'idealAdmin/cms_wysiwyg_images/index/","files_browser_window_width":1000,"files_browser_window_height":600,"widget_plugin_src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentowidget/editor_plugin.js","widget_images_url":"'.$siteurl.'skin/adminhtml/default/default/images/widget/","widget_placeholders":["Thumbs.db","catalog__category_widget_link.gif","catalog__product_widget_link.gif","catalog__product_widget_new.gif","cms__widget_block.gif","cms__widget_page_link.gif","default.gif","reports__product_widget_compared.gif","reports__product_widget_viewed.gif"],"widget_window_url":"'.$baseurl.'evolved/widget/index/","firebug_warning_title":"Warning","firebug_warning_text":"Firebug is known to make the WYSIWYG editor slow unless it is turned off or configured properly.","firebug_warning_anchor":"Hide"});';
      						$str = $str . 'editorFormValidationHandler = wysiwyghomepage_element_8_six_two_style_image.onFormValidation.bind(wysiwyghomepage_element_8_six_two_style_image);';
      						$str = $str . 'Event.observe("togglehomepage_element_8_six_two_style_image", "click", wysiwyghomepage_element_8_six_two_style_image.toggle.bind(wysiwyghomepage_element_8_six_two_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("formSubmit", editorFormValidationHandler);';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceBeforeSetContent", wysiwyghomepage_element_8_six_two_style_image.beforeSetContent.bind(wysiwyghomepage_element_8_six_two_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceSaveContent", wysiwyghomepage_element_8_six_two_style_image.saveContent.bind(wysiwyghomepage_element_8_six_two_style_image));';
      						$str = $str . 'varienGlobalEvents.clearEventHandlers("open_browser_callback");';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("open_browser_callback", wysiwyghomepage_element_8_six_two_style_image.openFileBrowser.bind(wysiwyghomepage_element_8_six_two_style_image));';
      						$str = $str . '</script>';
      						$str = $str . '</tr>';
      						$str = $str . '</tbody>';
      						$str = $str . '</table>';
      						$str = $str . '<table cellspacing="0" class="form-list allpageelement" style="display: table-cell;">';
							$str = $str . '<tbody>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_six_three_style_title">Title:</label></td>';  
      						$str = $str . '<td class="value"><input id="homepage_element_8_six_three_style_title" value="'.$collectiondata['homepage_element_8_six_three_style_title'].'" name="homepage_element_8_25_percentage_480_by_400_four_boxes_full_width[homepage_element_8_six_three_style_title]"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_six_three_style_link">Link:</label></td>';
      						$str = $str . '<td class="value"><input id="homepage_element_8_six_three_style_link" value="'.$collectiondata['homepage_element_8_six_three_style_link'].'" name="homepage_element_8_25_percentage_480_by_400_four_boxes_full_width[homepage_element_8_six_three_style_link]"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_six_three_style_target">Target:</label></td>';
      						$str = $str . '<td class="value">';
      						$str = $str . '<select id="homepage_element_8_six_three_style_target" name="homepage_element_8_25_percentage_480_by_400_four_boxes_full_width[homepage_element_8_six_three_style_target]" >';
      						foreach($targetarr as $targetarrkey => $targetarrvalue)
      						{
      							if($collectiondata['homepage_element_8_six_three_style_target']==$targetarrkey)
      							{
      								$str = $str . '<option value='.$targetarrkey.' selected>'.$targetarrvalue.'</option>';
      							}
      							else
      							{
      								$str = $str . '<option value='.$targetarrkey.'>'.$targetarrvalue.'</option>';
      							}
      						}
      						$str = $str . '</select>';
      						$str = $str . '</td>';
      						$str = $str . '</tr>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_six_three_style_image">Image:</label></td>';
      						//$str = $str . '<td class="value"><div id="buttonshomepage_element_8_six_three_style_image" class="buttons-set"><button type="button" class="scalable show-hide" style="" id="togglehomepage_element_8_six_three_style_image"><span><span><span>Show / Hide Editor</span></span></span></button><button type="button" class="scalable add-widget plugin" onclick="widgetTools.openDialog('.$baseurl.'evolved/widget/index/widget_target_id/homepage_element_8_six_three_style_image)" style=""><span><span><span>Insert Widget...</span></span></span></button><button type="button" class="scalable add-image plugin" onclick="MediabrowserUtility.openDialog('.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_8_six_three_style_image/)" style=""><span><span><span>Insert Image...</span></span></span></button><button type="button" class="scalable add-variable plugin" onclick="MagentovariablePlugin.loadChooser('.$baseurl.'evolved/system_variable/wysiwygPlugin/, homepage_element_8_six_three_style_image);"><span><span><span>Insert Variable...</span></span></span></button></div><textarea name="homepage_element_8_six_three_style_image" title="" id="homepage_element_8_six_three_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_8_six_three_style_image'].'</textarea><small>Image size must be 1920*480 pixels</small></td>';
      						$str = $str . '<td class="value"><button id="togglehomepage_element_8_six_three_style_image" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><div id="buttonshomepage_element_8_six_three_style_image" class="buttons-set"><button style="" onclick="MediabrowserUtility.openDialog(\''.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_8_six_three_style_image/\')" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button></div><textarea name="homepage_element_8_25_percentage_480_by_400_four_boxes_full_width[homepage_element_8_six_three_style_image]" title="" id="homepage_element_8_six_three_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_8_six_three_style_image'].'</textarea><small>Image size must be 480*400 pixels</small></td>';
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
      						$str = $str . '}wysiwyghomepage_element_8_six_three_style_image = new tinyMceWysiwygSetup("homepage_element_8_six_three_style_image", {"enabled":true,"hidden":true,"use_container":false,"add_variables":true,"add_widgets":true,"add_images":true,"no_display":false,"translator":{},"encode_directives":true,"directives_url":"'.$baseurl.'evolved/cms_wysiwyg/directive/","popup_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/dialog.css","content_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/content.css","width":"100%","plugins":[{"name":"magentovariable","src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentovariable/editor_plugin.js","options":{"title":"Insert Variable...","url":"'.$baseurl.'evolved/system_variable/wysiwygPlugin/","onclick":{"search":["html_id"],"subject":"MagentovariablePlugin.loadChooser(\''.$baseurl.'evolved/system_variable/wysiwygPlugin/\', \'{{html_id}}\');"},"class":"add-variable plugin"}}],"directives_url_quoted":"'.$baseurl.'evolved/cms_wysiwyg/directive/","files_browser_window_url":"'.$baseurl.'idealAdmin/cms_wysiwyg_images/index/","files_browser_window_width":1000,"files_browser_window_height":600,"widget_plugin_src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentowidget/editor_plugin.js","widget_images_url":"'.$siteurl.'skin/adminhtml/default/default/images/widget/","widget_placeholders":["Thumbs.db","catalog__category_widget_link.gif","catalog__product_widget_link.gif","catalog__product_widget_new.gif","cms__widget_block.gif","cms__widget_page_link.gif","default.gif","reports__product_widget_compared.gif","reports__product_widget_viewed.gif"],"widget_window_url":"'.$baseurl.'evolved/widget/index/","firebug_warning_title":"Warning","firebug_warning_text":"Firebug is known to make the WYSIWYG editor slow unless it is turned off or configured properly.","firebug_warning_anchor":"Hide"});';
      						$str = $str . 'editorFormValidationHandler = wysiwyghomepage_element_8_six_three_style_image.onFormValidation.bind(wysiwyghomepage_element_8_six_three_style_image);';
      						$str = $str . 'Event.observe("togglehomepage_element_8_six_three_style_image", "click", wysiwyghomepage_element_8_six_three_style_image.toggle.bind(wysiwyghomepage_element_8_six_three_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("formSubmit", editorFormValidationHandler);';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceBeforeSetContent", wysiwyghomepage_element_8_six_three_style_image.beforeSetContent.bind(wysiwyghomepage_element_8_six_three_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceSaveContent", wysiwyghomepage_element_8_six_three_style_image.saveContent.bind(wysiwyghomepage_element_8_six_three_style_image));';
      						$str = $str . 'varienGlobalEvents.clearEventHandlers("open_browser_callback");';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("open_browser_callback", wysiwyghomepage_element_8_six_three_style_image.openFileBrowser.bind(wysiwyghomepage_element_8_six_three_style_image));';
      						$str = $str . '</script>';
      						$str = $str . '</tr>';
      						$str = $str . '</tbody>';
      						$str = $str . '</table>';
      						$str = $str . '<table cellspacing="0" class="form-list allpageelement" style="display: table-cell;">';
							$str = $str . '<tbody>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_six_four_style_title">Title:</label></td>';  
      						$str = $str . '<td class="value"><input id="homepage_element_8_six_four_style_title" value="'.$collectiondata['homepage_element_8_six_four_style_title'].'" name="homepage_element_8_25_percentage_480_by_400_four_boxes_full_width[homepage_element_8_six_four_style_title]"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_six_four_style_link">Link:</label></td>';
      						$str = $str . '<td class="value"><input id="homepage_element_8_six_four_style_link" value="'.$collectiondata['homepage_element_8_six_four_style_link'].'" name="homepage_element_8_25_percentage_480_by_400_four_boxes_full_width[homepage_element_8_six_four_style_link]"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_six_four_style_target">Target:</label></td>';
      						$str = $str . '<td class="value">';
      						$str = $str . '<select id="homepage_element_8_six_four_style_target" name="homepage_element_8_25_percentage_480_by_400_four_boxes_full_width[homepage_element_8_six_four_style_target]" >';
      						foreach($targetarr as $targetarrkey => $targetarrvalue)
      						{
      							if($collectiondata['homepage_element_8_six_four_style_target']==$targetarrkey)
      							{
      								$str = $str . '<option value='.$targetarrkey.' selected>'.$targetarrvalue.'</option>';
      							}
      							else
      							{
      								$str = $str . '<option value='.$targetarrkey.'>'.$targetarrvalue.'</option>';
      							}
      						}
      						$str = $str . '</select>';
      						$str = $str . '</td>';
      						$str = $str . '</tr>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_six_four_style_image">Image:</label></td>';
      						//$str = $str . '<td class="value"><div id="buttonshomepage_element_8_six_four_style_image" class="buttons-set"><button type="button" class="scalable show-hide" style="" id="togglehomepage_element_8_six_four_style_image"><span><span><span>Show / Hide Editor</span></span></span></button><button type="button" class="scalable add-widget plugin" onclick="widgetTools.openDialog('.$baseurl.'evolved/widget/index/widget_target_id/homepage_element_8_six_four_style_image)" style=""><span><span><span>Insert Widget...</span></span></span></button><button type="button" class="scalable add-image plugin" onclick="MediabrowserUtility.openDialog('.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_8_six_four_style_image/)" style=""><span><span><span>Insert Image...</span></span></span></button><button type="button" class="scalable add-variable plugin" onclick="MagentovariablePlugin.loadChooser('.$baseurl.'evolved/system_variable/wysiwygPlugin/, homepage_element_8_six_four_style_image);"><span><span><span>Insert Variable...</span></span></span></button></div><textarea name="homepage_element_8_six_four_style_image" title="" id="homepage_element_8_six_four_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_8_six_four_style_image'].'</textarea><small>Image size must be 1920*480 pixels</small></td>';
      						$str = $str . '<td class="value"><button id="togglehomepage_element_8_six_four_style_image" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><div id="buttonshomepage_element_8_six_four_style_image" class="buttons-set"><button style="" onclick="MediabrowserUtility.openDialog(\''.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_8_six_four_style_image/\')" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button></div><textarea name="homepage_element_8_25_percentage_480_by_400_four_boxes_full_width[homepage_element_8_six_four_style_image]" title="" id="homepage_element_8_six_four_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_8_six_four_style_image'].'</textarea><small>Image size must be 480*400 pixels</small></td>';
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
      						$str = $str . '}wysiwyghomepage_element_8_six_four_style_image = new tinyMceWysiwygSetup("homepage_element_8_six_four_style_image", {"enabled":true,"hidden":true,"use_container":false,"add_variables":true,"add_widgets":true,"add_images":true,"no_display":false,"translator":{},"encode_directives":true,"directives_url":"'.$baseurl.'evolved/cms_wysiwyg/directive/","popup_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/dialog.css","content_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/content.css","width":"100%","plugins":[{"name":"magentovariable","src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentovariable/editor_plugin.js","options":{"title":"Insert Variable...","url":"'.$baseurl.'evolved/system_variable/wysiwygPlugin/","onclick":{"search":["html_id"],"subject":"MagentovariablePlugin.loadChooser(\''.$baseurl.'evolved/system_variable/wysiwygPlugin/\', \'{{html_id}}\');"},"class":"add-variable plugin"}}],"directives_url_quoted":"'.$baseurl.'evolved/cms_wysiwyg/directive/","files_browser_window_url":"'.$baseurl.'idealAdmin/cms_wysiwyg_images/index/","files_browser_window_width":1000,"files_browser_window_height":600,"widget_plugin_src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentowidget/editor_plugin.js","widget_images_url":"'.$siteurl.'skin/adminhtml/default/default/images/widget/","widget_placeholders":["Thumbs.db","catalog__category_widget_link.gif","catalog__product_widget_link.gif","catalog__product_widget_new.gif","cms__widget_block.gif","cms__widget_page_link.gif","default.gif","reports__product_widget_compared.gif","reports__product_widget_viewed.gif"],"widget_window_url":"'.$baseurl.'evolved/widget/index/","firebug_warning_title":"Warning","firebug_warning_text":"Firebug is known to make the WYSIWYG editor slow unless it is turned off or configured properly.","firebug_warning_anchor":"Hide"});';
      						$str = $str . 'editorFormValidationHandler = wysiwyghomepage_element_8_six_four_style_image.onFormValidation.bind(wysiwyghomepage_element_8_six_four_style_image);';
      						$str = $str . 'Event.observe("togglehomepage_element_8_six_four_style_image", "click", wysiwyghomepage_element_8_six_four_style_image.toggle.bind(wysiwyghomepage_element_8_six_four_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("formSubmit", editorFormValidationHandler);';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceBeforeSetContent", wysiwyghomepage_element_8_six_four_style_image.beforeSetContent.bind(wysiwyghomepage_element_8_six_four_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceSaveContent", wysiwyghomepage_element_8_six_four_style_image.saveContent.bind(wysiwyghomepage_element_8_six_four_style_image));';
      						$str = $str . 'varienGlobalEvents.clearEventHandlers("open_browser_callback");';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("open_browser_callback", wysiwyghomepage_element_8_six_four_style_image.openFileBrowser.bind(wysiwyghomepage_element_8_six_four_style_image));';
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
      						if($selectElement == 'homepage_element_8_33_percentage_346_by_170_three_boxes_width')
      						{
      							$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="homepage_element_8_33_percentage_346_by_170_three_boxes_width" style="display: block">';
      						}
      						else
      						{
      							$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="homepage_element_8_33_percentage_346_by_170_three_boxes_width"  style="display: none">';
      						}
      						//$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="33_percentage_346_by_170_three_boxes_width">';
      						$str = $str . '<tbody>';
      						$str = $str . '<tr>';
      						$str = $str . '<td>';
      						$str = $str . '<table cellspacing="0" class="form-list allpageelement" style="display: table-cell;">';
							$str = $str . '<tbody>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_seven_one_style_title">Title:</label></td>';  
      						$str = $str . '<td class="value"><input id="homepage_element_8_seven_one_style_title" value="'.$collectiondata['homepage_element_8_seven_one_style_title'].'" name="homepage_element_8_33_percentage_346_by_170_three_boxes_width[homepage_element_8_seven_one_style_title]"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_seven_one_style_link">Link:</label></td>';
      						$str = $str . '<td class="value"><input id="homepage_element_8_seven_one_style_link" value="'.$collectiondata['homepage_element_8_seven_one_style_link'].'" name="homepage_element_8_33_percentage_346_by_170_three_boxes_width[homepage_element_8_seven_one_style_link]"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_seven_one_style_target">Target:</label></td>';
      						$str = $str . '<td class="value">';
      						$str = $str . '<select id="homepage_element_8_seven_one_style_target" name="homepage_element_8_33_percentage_346_by_170_three_boxes_width[homepage_element_8_seven_one_style_target]" >';
      						foreach($targetarr as $targetarrkey => $targetarrvalue)
      						{
      							if($collectiondata['homepage_element_8_seven_one_style_target']==$targetarrkey)
      							{
      								$str = $str . '<option value='.$targetarrkey.' selected>'.$targetarrvalue.'</option>';
      							}
      							else
      							{
      								$str = $str . '<option value='.$targetarrkey.'>'.$targetarrvalue.'</option>';
      							}
      						}
      						$str = $str . '</select>';
      						$str = $str . '</td>';
      						$str = $str . '</tr>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_seven_one_style_image">Image:</label></td>';
      						//$str = $str . '<td class="value"><div id="buttonshomepage_element_8_seven_one_style_image" class="buttons-set"><button type="button" class="scalable show-hide" style="" id="togglehomepage_element_8_seven_one_style_image"><span><span><span>Show / Hide Editor</span></span></span></button><button type="button" class="scalable add-widget plugin" onclick="widgetTools.openDialog('.$baseurl.'evolved/widget/index/widget_target_id/homepage_element_8_seven_one_style_image)" style=""><span><span><span>Insert Widget...</span></span></span></button><button type="button" class="scalable add-image plugin" onclick="MediabrowserUtility.openDialog('.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_8_seven_one_style_image/)" style=""><span><span><span>Insert Image...</span></span></span></button><button type="button" class="scalable add-variable plugin" onclick="MagentovariablePlugin.loadChooser('.$baseurl.'evolved/system_variable/wysiwygPlugin/, homepage_element_8_seven_one_style_image);"><span><span><span>Insert Variable...</span></span></span></button></div><textarea name="homepage_element_8_seven_one_style_image" title="" id="homepage_element_8_seven_one_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_8_seven_one_style_image'].'</textarea><small>Image size must be 1920*480 pixels</small></td>';
      						$str = $str . '<td class="value"><button id="togglehomepage_element_8_seven_one_style_image" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><div id="buttonshomepage_element_8_seven_one_style_image" class="buttons-set"><button style="" onclick="MediabrowserUtility.openDialog(\''.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_8_seven_one_style_image/\')" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button></div><textarea name="homepage_element_8_33_percentage_346_by_170_three_boxes_width[homepage_element_8_seven_one_style_image]" title="" id="homepage_element_8_seven_one_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_8_seven_one_style_image'].'</textarea><small>Image size must be 346*170 pixels</small></td>';
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
      						$str = $str . '}wysiwyghomepage_element_8_seven_one_style_image = new tinyMceWysiwygSetup("homepage_element_8_seven_one_style_image", {"enabled":true,"hidden":true,"use_container":false,"add_variables":true,"add_widgets":true,"add_images":true,"no_display":false,"translator":{},"encode_directives":true,"directives_url":"'.$baseurl.'evolved/cms_wysiwyg/directive/","popup_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/dialog.css","content_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/content.css","width":"100%","plugins":[{"name":"magentovariable","src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentovariable/editor_plugin.js","options":{"title":"Insert Variable...","url":"'.$baseurl.'evolved/system_variable/wysiwygPlugin/","onclick":{"search":["html_id"],"subject":"MagentovariablePlugin.loadChooser(\''.$baseurl.'evolved/system_variable/wysiwygPlugin/\', \'{{html_id}}\');"},"class":"add-variable plugin"}}],"directives_url_quoted":"'.$baseurl.'evolved/cms_wysiwyg/directive/","files_browser_window_url":"'.$baseurl.'idealAdmin/cms_wysiwyg_images/index/","files_browser_window_width":1000,"files_browser_window_height":600,"widget_plugin_src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentowidget/editor_plugin.js","widget_images_url":"'.$siteurl.'skin/adminhtml/default/default/images/widget/","widget_placeholders":["Thumbs.db","catalog__category_widget_link.gif","catalog__product_widget_link.gif","catalog__product_widget_new.gif","cms__widget_block.gif","cms__widget_page_link.gif","default.gif","reports__product_widget_compared.gif","reports__product_widget_viewed.gif"],"widget_window_url":"'.$baseurl.'evolved/widget/index/","firebug_warning_title":"Warning","firebug_warning_text":"Firebug is known to make the WYSIWYG editor slow unless it is turned off or configured properly.","firebug_warning_anchor":"Hide"});';
      						$str = $str . 'editorFormValidationHandler = wysiwyghomepage_element_8_seven_one_style_image.onFormValidation.bind(wysiwyghomepage_element_8_seven_one_style_image);';
      						$str = $str . 'Event.observe("togglehomepage_element_8_seven_one_style_image", "click", wysiwyghomepage_element_8_seven_one_style_image.toggle.bind(wysiwyghomepage_element_8_seven_one_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("formSubmit", editorFormValidationHandler);';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceBeforeSetContent", wysiwyghomepage_element_8_seven_one_style_image.beforeSetContent.bind(wysiwyghomepage_element_8_seven_one_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceSaveContent", wysiwyghomepage_element_8_seven_one_style_image.saveContent.bind(wysiwyghomepage_element_8_seven_one_style_image));';
      						$str = $str . 'varienGlobalEvents.clearEventHandlers("open_browser_callback");';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("open_browser_callback", wysiwyghomepage_element_8_seven_one_style_image.openFileBrowser.bind(wysiwyghomepage_element_8_seven_one_style_image));';
      						$str = $str . '</script>';
      						$str = $str . '</tr>';
      						$str = $str . '</tbody>';
      						$str = $str . '</table>'; 
      						$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelement" style="display: table-cell;">';
							$str = $str . '<tbody>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_seven_two_style_title">Title:</label></td>';  
      						$str = $str . '<td class="value"><input id="homepage_element_8_seven_two_style_title" value="'.$collectiondata['homepage_element_8_seven_two_style_title'].'" name="homepage_element_8_33_percentage_346_by_170_three_boxes_width[homepage_element_8_seven_two_style_title]"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_seven_two_style_link">Link:</label></td>';
      						$str = $str . '<td class="value"><input id="homepage_element_8_seven_two_style_link" value="'.$collectiondata['homepage_element_8_seven_two_style_link'].'" name="homepage_element_8_33_percentage_346_by_170_three_boxes_width[homepage_element_8_seven_two_style_link]"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_seven_two_style_target">Target:</label></td>';
      						$str = $str . '<td class="value">';
      						$str = $str . '<select id="homepage_element_8_seven_two_style_target" name="homepage_element_8_33_percentage_346_by_170_three_boxes_width[homepage_element_8_seven_two_style_target]" >';
      						foreach($targetarr as $targetarrkey => $targetarrvalue)
      						{
      							if($collectiondata['homepage_element_8_seven_two_style_target']==$targetarrkey)
      							{
      								$str = $str . '<option value='.$targetarrkey.' selected>'.$targetarrvalue.'</option>';
      							}
      							else
      							{
      								$str = $str . '<option value='.$targetarrkey.'>'.$targetarrvalue.'</option>';
      							}
      						}
      						$str = $str . '</select>';
      						$str = $str . '</td>';
      						$str = $str . '</tr>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_seven_two_style_image">Image:</label></td>';
      						//$str = $str . '<td class="value"><div id="buttonshomepage_element_8_seven_two_style_image" class="buttons-set"><button type="button" class="scalable show-hide" style="" id="togglehomepage_element_8_seven_two_style_image"><span><span><span>Show / Hide Editor</span></span></span></button><button type="button" class="scalable add-widget plugin" onclick="widgetTools.openDialog('.$baseurl.'evolved/widget/index/widget_target_id/homepage_element_8_seven_two_style_image)" style=""><span><span><span>Insert Widget...</span></span></span></button><button type="button" class="scalable add-image plugin" onclick="MediabrowserUtility.openDialog('.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_8_seven_two_style_image/)" style=""><span><span><span>Insert Image...</span></span></span></button><button type="button" class="scalable add-variable plugin" onclick="MagentovariablePlugin.loadChooser('.$baseurl.'evolved/system_variable/wysiwygPlugin/, homepage_element_8_seven_two_style_image);"><span><span><span>Insert Variable...</span></span></span></button></div><textarea name="homepage_element_8_seven_two_style_image" title="" id="homepage_element_8_seven_two_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_8_seven_two_style_image'].'</textarea><small>Image size must be 1920*480 pixels</small></td>';
      						$str = $str . '<td class="value"><button id="togglehomepage_element_8_seven_two_style_image" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><div id="buttonshomepage_element_8_seven_two_style_image" class="buttons-set"><button style="" onclick="MediabrowserUtility.openDialog(\''.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_8_seven_two_style_image/\')" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button></div><textarea name="homepage_element_8_33_percentage_346_by_170_three_boxes_width[homepage_element_8_seven_two_style_image]" title="" id="homepage_element_8_seven_two_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_8_seven_two_style_image'].'</textarea><small>Image size must be 346*170 pixels</small></td>';
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
      						$str = $str . '}wysiwyghomepage_element_8_seven_two_style_image = new tinyMceWysiwygSetup("homepage_element_8_seven_two_style_image", {"enabled":true,"hidden":true,"use_container":false,"add_variables":true,"add_widgets":true,"add_images":true,"no_display":false,"translator":{},"encode_directives":true,"directives_url":"'.$baseurl.'evolved/cms_wysiwyg/directive/","popup_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/dialog.css","content_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/content.css","width":"100%","plugins":[{"name":"magentovariable","src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentovariable/editor_plugin.js","options":{"title":"Insert Variable...","url":"'.$baseurl.'evolved/system_variable/wysiwygPlugin/","onclick":{"search":["html_id"],"subject":"MagentovariablePlugin.loadChooser(\''.$baseurl.'evolved/system_variable/wysiwygPlugin/\', \'{{html_id}}\');"},"class":"add-variable plugin"}}],"directives_url_quoted":"'.$baseurl.'evolved/cms_wysiwyg/directive/","files_browser_window_url":"'.$baseurl.'idealAdmin/cms_wysiwyg_images/index/","files_browser_window_width":1000,"files_browser_window_height":600,"widget_plugin_src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentowidget/editor_plugin.js","widget_images_url":"'.$siteurl.'skin/adminhtml/default/default/images/widget/","widget_placeholders":["Thumbs.db","catalog__category_widget_link.gif","catalog__product_widget_link.gif","catalog__product_widget_new.gif","cms__widget_block.gif","cms__widget_page_link.gif","default.gif","reports__product_widget_compared.gif","reports__product_widget_viewed.gif"],"widget_window_url":"'.$baseurl.'evolved/widget/index/","firebug_warning_title":"Warning","firebug_warning_text":"Firebug is known to make the WYSIWYG editor slow unless it is turned off or configured properly.","firebug_warning_anchor":"Hide"});';
      						$str = $str . 'editorFormValidationHandler = wysiwyghomepage_element_8_seven_two_style_image.onFormValidation.bind(wysiwyghomepage_element_8_seven_two_style_image);';
      						$str = $str . 'Event.observe("togglehomepage_element_8_seven_two_style_image", "click", wysiwyghomepage_element_8_seven_two_style_image.toggle.bind(wysiwyghomepage_element_8_seven_two_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("formSubmit", editorFormValidationHandler);';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceBeforeSetContent", wysiwyghomepage_element_8_seven_two_style_image.beforeSetContent.bind(wysiwyghomepage_element_8_seven_two_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceSaveContent", wysiwyghomepage_element_8_seven_two_style_image.saveContent.bind(wysiwyghomepage_element_8_seven_two_style_image));';
      						$str = $str . 'varienGlobalEvents.clearEventHandlers("open_browser_callback");';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("open_browser_callback", wysiwyghomepage_element_8_seven_two_style_image.openFileBrowser.bind(wysiwyghomepage_element_8_seven_two_style_image));';
      						$str = $str . '</script>';
      						$str = $str . '</tr>';
      						$str = $str . '</tbody>';
      						$str = $str . '</table>';
      						$str = $str . '<table cellspacing="0" class="form-list allpageelement" style="display: table-cell;">';
							$str = $str . '<tbody>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_seven_three_style_title">Title:</label></td>';  
      						$str = $str . '<td class="value"><input id="homepage_element_8_seven_three_style_title" value="'.$collectiondata['homepage_element_8_seven_three_style_title'].'" name="homepage_element_8_33_percentage_346_by_170_three_boxes_width[homepage_element_8_seven_three_style_title]"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_seven_three_style_link">Link:</label></td>';
      						$str = $str . '<td class="value"><input id="homepage_element_8_seven_three_style_link" value="'.$collectiondata['homepage_element_8_seven_three_style_link'].'" name="homepage_element_8_33_percentage_346_by_170_three_boxes_width[homepage_element_8_seven_three_style_link]"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_seven_three_style_target">Target:</label></td>';
      						$str = $str . '<td class="value">';
      						$str = $str . '<select id="homepage_element_8_seven_three_style_target" name="homepage_element_8_33_percentage_346_by_170_three_boxes_width[homepage_element_8_seven_three_style_target]" >';
      						foreach($targetarr as $targetarrkey => $targetarrvalue)
      						{
      							if($collectiondata['homepage_element_8_seven_three_style_target']==$targetarrkey)
      							{
      								$str = $str . '<option value='.$targetarrkey.' selected>'.$targetarrvalue.'</option>';
      							}
      							else
      							{
      								$str = $str . '<option value='.$targetarrkey.'>'.$targetarrvalue.'</option>';
      							}
      						}
      						$str = $str . '</select>';
      						$str = $str . '</td>';
      						$str = $str . '</tr>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_seven_three_style_image">Image:</label></td>';
      						//$str = $str . '<td class="value"><div id="buttonshomepage_element_8_seven_three_style_image" class="buttons-set"><button type="button" class="scalable show-hide" style="" id="togglehomepage_element_8_seven_three_style_image"><span><span><span>Show / Hide Editor</span></span></span></button><button type="button" class="scalable add-widget plugin" onclick="widgetTools.openDialog('.$baseurl.'evolved/widget/index/widget_target_id/homepage_element_8_seven_three_style_image)" style=""><span><span><span>Insert Widget...</span></span></span></button><button type="button" class="scalable add-image plugin" onclick="MediabrowserUtility.openDialog('.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_8_seven_three_style_image/)" style=""><span><span><span>Insert Image...</span></span></span></button><button type="button" class="scalable add-variable plugin" onclick="MagentovariablePlugin.loadChooser('.$baseurl.'evolved/system_variable/wysiwygPlugin/, homepage_element_8_seven_three_style_image);"><span><span><span>Insert Variable...</span></span></span></button></div><textarea name="homepage_element_8_seven_three_style_image" title="" id="homepage_element_8_seven_three_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_8_seven_three_style_image'].'</textarea><small>Image size must be 1920*480 pixels</small></td>';
      						$str = $str . '<td class="value"><button id="togglehomepage_element_8_seven_three_style_image" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><div id="buttonshomepage_element_8_seven_three_style_image" class="buttons-set"><button style="" onclick="MediabrowserUtility.openDialog(\''.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_8_seven_three_style_image/\')" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button></div><textarea name="homepage_element_8_33_percentage_346_by_170_three_boxes_width[homepage_element_8_seven_three_style_image]" title="" id="homepage_element_8_seven_three_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_8_seven_three_style_image'].'</textarea><small>Image size must be 346*170 pixels</small></td>';
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
      						$str = $str . '}wysiwyghomepage_element_8_seven_three_style_image = new tinyMceWysiwygSetup("homepage_element_8_seven_three_style_image", {"enabled":true,"hidden":true,"use_container":false,"add_variables":true,"add_widgets":true,"add_images":true,"no_display":false,"translator":{},"encode_directives":true,"directives_url":"'.$baseurl.'evolved/cms_wysiwyg/directive/","popup_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/dialog.css","content_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/content.css","width":"100%","plugins":[{"name":"magentovariable","src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentovariable/editor_plugin.js","options":{"title":"Insert Variable...","url":"'.$baseurl.'evolved/system_variable/wysiwygPlugin/","onclick":{"search":["html_id"],"subject":"MagentovariablePlugin.loadChooser(\''.$baseurl.'evolved/system_variable/wysiwygPlugin/\', \'{{html_id}}\');"},"class":"add-variable plugin"}}],"directives_url_quoted":"'.$baseurl.'evolved/cms_wysiwyg/directive/","files_browser_window_url":"'.$baseurl.'idealAdmin/cms_wysiwyg_images/index/","files_browser_window_width":1000,"files_browser_window_height":600,"widget_plugin_src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentowidget/editor_plugin.js","widget_images_url":"'.$siteurl.'skin/adminhtml/default/default/images/widget/","widget_placeholders":["Thumbs.db","catalog__category_widget_link.gif","catalog__product_widget_link.gif","catalog__product_widget_new.gif","cms__widget_block.gif","cms__widget_page_link.gif","default.gif","reports__product_widget_compared.gif","reports__product_widget_viewed.gif"],"widget_window_url":"'.$baseurl.'evolved/widget/index/","firebug_warning_title":"Warning","firebug_warning_text":"Firebug is known to make the WYSIWYG editor slow unless it is turned off or configured properly.","firebug_warning_anchor":"Hide"});';
      						$str = $str . 'editorFormValidationHandler = wysiwyghomepage_element_8_seven_three_style_image.onFormValidation.bind(wysiwyghomepage_element_8_seven_three_style_image);';
      						$str = $str . 'Event.observe("togglehomepage_element_8_seven_three_style_image", "click", wysiwyghomepage_element_8_seven_three_style_image.toggle.bind(wysiwyghomepage_element_8_seven_three_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("formSubmit", editorFormValidationHandler);';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceBeforeSetContent", wysiwyghomepage_element_8_seven_three_style_image.beforeSetContent.bind(wysiwyghomepage_element_8_seven_three_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceSaveContent", wysiwyghomepage_element_8_seven_three_style_image.saveContent.bind(wysiwyghomepage_element_8_seven_three_style_image));';
      						$str = $str . 'varienGlobalEvents.clearEventHandlers("open_browser_callback");';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("open_browser_callback", wysiwyghomepage_element_8_seven_three_style_image.openFileBrowser.bind(wysiwyghomepage_element_8_seven_three_style_image));';
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
      						if($selectElement == 'homepage_element_8_33_percentage_346_by_346_three_boxes_width')
      						{
      							$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="homepage_element_8_33_percentage_346_by_346_three_boxes_width" style="display: block">';
      						}
      						else
      						{
      							$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="homepage_element_8_33_percentage_346_by_346_three_boxes_width"  style="display: none">';
      						}
      						//$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="33_percentage_346_by_346_three_boxes_width">';
      						$str = $str . '<tbody>';
      						$str = $str . '<tr>';
      						$str = $str . '<td>';
      						$str = $str . '<table cellspacing="0" class="form-list allpageelement" style="display: table-cell;">';
							$str = $str . '<tbody>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_eight_one_style_title">Title:</label></td>';  
      						$str = $str . '<td class="value"><input id="homepage_element_8_eight_one_style_title" value="'.$collectiondata['homepage_element_8_eight_one_style_title'].'" name="homepage_element_8_33_percentage_346_by_346_three_boxes_width[homepage_element_8_eight_one_style_title]"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str .	'<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_eight_one_style_link">Link:</label></td>';
      						$str = $str . '<td class="value"><input id="homepage_element_8_eight_one_style_link" value="'.$collectiondata['homepage_element_8_eight_one_style_link'].'" name="homepage_element_8_33_percentage_346_by_346_three_boxes_width[homepage_element_8_eight_one_style_link]"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_eight_one_style_target">Target:</label></td>';
      						$str = $str . '<td class="value">';
      						$str = $str . '<select id="homepage_element_8_eight_one_style_target" name="homepage_element_8_33_percentage_346_by_346_three_boxes_width[homepage_element_8_eight_one_style_target]" >';
      						foreach($targetarr as $targetarrkey => $targetarrvalue)
      						{
      							if($collectiondata['homepage_element_8_eight_one_style_target']==$targetarrkey)
      							{
      								$str = $str . '<option value='.$targetarrkey.' selected>'.$targetarrvalue.'</option>';
      							}
      							else
      							{
      								$str = $str . '<option value='.$targetarrkey.'>'.$targetarrvalue.'</option>';
      							}
      						}
      						$str = $str . '</select>';
      						$str = $str . '</td>';
      						$str = $str . '</tr>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_eight_one_style_image">Image:</label></td>';
      						//$str = $str . '<td class="value"><div id="buttonshomepage_element_8_eight_one_style_image" class="buttons-set"><button type="button" class="scalable show-hide" style="" id="togglehomepage_element_8_eight_one_style_image"><span><span><span>Show / Hide Editor</span></span></span></button><button type="button" class="scalable add-widget plugin" onclick="widgetTools.openDialog('.$baseurl.'evolved/widget/index/widget_target_id/homepage_element_8_eight_one_style_image)" style=""><span><span><span>Insert Widget...</span></span></span></button><button type="button" class="scalable add-image plugin" onclick="MediabrowserUtility.openDialog('.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_8_eight_one_style_image/)" style=""><span><span><span>Insert Image...</span></span></span></button><button type="button" class="scalable add-variable plugin" onclick="MagentovariablePlugin.loadChooser('.$baseurl.'evolved/system_variable/wysiwygPlugin/, homepage_element_8_eight_one_style_image);"><span><span><span>Insert Variable...</span></span></span></button></div><textarea name="homepage_element_8_eight_one_style_image" title="" id="homepage_element_8_eight_one_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_8_eight_one_style_image'].'</textarea><small>Image size must be 1920*480 pixels</small></td>';
      						$str = $str . '<td class="value"><button id="togglehomepage_element_8_eight_one_style_image" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><div id="buttonshomepage_element_8_eight_one_style_image" class="buttons-set"><button style="" onclick="MediabrowserUtility.openDialog(\''.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_8_eight_one_style_image/\')" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button></div><textarea name="homepage_element_8_33_percentage_346_by_346_three_boxes_width[homepage_element_8_eight_one_style_image]" title="" id="homepage_element_8_eight_one_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_8_eight_one_style_image'].'</textarea><small>Image size must be 346*346 pixels</small></td>';
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
      						$str = $str . '}wysiwyghomepage_element_8_eight_one_style_image = new tinyMceWysiwygSetup("homepage_element_8_eight_one_style_image", {"enabled":true,"hidden":true,"use_container":false,"add_variables":true,"add_widgets":true,"add_images":true,"no_display":false,"translator":{},"encode_directives":true,"directives_url":"'.$baseurl.'evolved/cms_wysiwyg/directive/","popup_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/dialog.css","content_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/content.css","width":"100%","plugins":[{"name":"magentovariable","src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentovariable/editor_plugin.js","options":{"title":"Insert Variable...","url":"'.$baseurl.'evolved/system_variable/wysiwygPlugin/","onclick":{"search":["html_id"],"subject":"MagentovariablePlugin.loadChooser(\''.$baseurl.'evolved/system_variable/wysiwygPlugin/\', \'{{html_id}}\');"},"class":"add-variable plugin"}}],"directives_url_quoted":"'.$baseurl.'evolved/cms_wysiwyg/directive/","files_browser_window_url":"'.$baseurl.'idealAdmin/cms_wysiwyg_images/index/","files_browser_window_width":1000,"files_browser_window_height":600,"widget_plugin_src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentowidget/editor_plugin.js","widget_images_url":"'.$siteurl.'skin/adminhtml/default/default/images/widget/","widget_placeholders":["Thumbs.db","catalog__category_widget_link.gif","catalog__product_widget_link.gif","catalog__product_widget_new.gif","cms__widget_block.gif","cms__widget_page_link.gif","default.gif","reports__product_widget_compared.gif","reports__product_widget_viewed.gif"],"widget_window_url":"'.$baseurl.'evolved/widget/index/","firebug_warning_title":"Warning","firebug_warning_text":"Firebug is known to make the WYSIWYG editor slow unless it is turned off or configured properly.","firebug_warning_anchor":"Hide"});';
      						$str = $str . 'editorFormValidationHandler = wysiwyghomepage_element_8_eight_one_style_image.onFormValidation.bind(wysiwyghomepage_element_8_eight_one_style_image);';
      						$str = $str . 'Event.observe("togglehomepage_element_8_eight_one_style_image", "click", wysiwyghomepage_element_8_eight_one_style_image.toggle.bind(wysiwyghomepage_element_8_eight_one_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("formSubmit", editorFormValidationHandler);';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceBeforeSetContent", wysiwyghomepage_element_8_eight_one_style_image.beforeSetContent.bind(wysiwyghomepage_element_8_eight_one_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceSaveContent", wysiwyghomepage_element_8_eight_one_style_image.saveContent.bind(wysiwyghomepage_element_8_eight_one_style_image));';
      						$str = $str . 'varienGlobalEvents.clearEventHandlers("open_browser_callback");';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("open_browser_callback", wysiwyghomepage_element_8_eight_one_style_image.openFileBrowser.bind(wysiwyghomepage_element_8_eight_one_style_image));';
      						$str = $str . '</script>';
      						$str = $str . '</tr>';
      						$str = $str . '</tbody>';
      						$str = $str . '</table>'; 
      						$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelement" style="display: table-cell;">';
							$str = $str . '<tbody>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_eight_two_style_title">Title:</label></td>';  
      						$str = $str . '<td class="value"><input id="homepage_element_8_eight_two_style_title"  value="'.$collectiondata['homepage_element_8_eight_two_style_title'].'" name="homepage_element_8_33_percentage_346_by_346_three_boxes_width[homepage_element_8_eight_two_style_title]"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str .	'<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_eight_two_style_link">Link:</label></td>';
      						$str = $str . '<td class="value"><input id="homepage_element_8_eight_two_style_link" value="'.$collectiondata['homepage_element_8_eight_two_style_link'].'" name="homepage_element_8_33_percentage_346_by_346_three_boxes_width[homepage_element_8_eight_two_style_link]"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_eight_two_style_target">Target:</label></td>';
      						$str = $str . '<td class="value">';
      						$str = $str . '<select id="homepage_element_8_eight_two_style_target" name="homepage_element_8_33_percentage_346_by_346_three_boxes_width[homepage_element_8_eight_two_style_target]" >';
      						foreach($targetarr as $targetarrkey => $targetarrvalue)
      						{
      							if($collectiondata['homepage_element_8_eight_two_style_target']==$targetarrkey)
      							{
      								$str = $str . '<option value='.$targetarrkey.' selected>'.$targetarrvalue.'</option>';
      							}
      							else
      							{
      								$str = $str . '<option value='.$targetarrkey.'>'.$targetarrvalue.'</option>';
      							}
      						}
      						$str = $str . '</select>';
      						$str = $str . '</td>';
      						$str = $str . '</tr>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_eight_two_style_image">Image:</label></td>';
      						//$str = $str . '<td class="value"><div id="buttonshomepage_element_8_eight_two_style_image" class="buttons-set"><button type="button" class="scalable show-hide" style="" id="togglehomepage_element_8_eight_two_style_image"><span><span><span>Show / Hide Editor</span></span></span></button><button type="button" class="scalable add-widget plugin" onclick="widgetTools.openDialog('.$baseurl.'evolved/widget/index/widget_target_id/homepage_element_8_eight_two_style_image)" style=""><span><span><span>Insert Widget...</span></span></span></button><button type="button" class="scalable add-image plugin" onclick="MediabrowserUtility.openDialog('.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_8_eight_two_style_image/)" style=""><span><span><span>Insert Image...</span></span></span></button><button type="button" class="scalable add-variable plugin" onclick="MagentovariablePlugin.loadChooser('.$baseurl.'evolved/system_variable/wysiwygPlugin/, homepage_element_8_eight_two_style_image);"><span><span><span>Insert Variable...</span></span></span></button></div><textarea name="homepage_element_8_eight_two_style_image" title="" id="homepage_element_8_eight_two_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_8_eight_two_style_image'].'</textarea><small>Image size must be 1920*480 pixels</small></td>';
      						$str = $str . '<td class="value"><button id="togglehomepage_element_8_eight_two_style_image" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><div id="buttonshomepage_element_8_eight_two_style_image" class="buttons-set"><button style="" onclick="MediabrowserUtility.openDialog(\''.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_8_eight_two_style_image/\')" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button></div><textarea name="homepage_element_8_33_percentage_346_by_346_three_boxes_width[homepage_element_8_eight_two_style_image]" title="" id="homepage_element_8_eight_two_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_8_eight_two_style_image'].'</textarea><small>Image size must be 346*346 pixels</small></td>';
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
      						$str = $str . '}wysiwyghomepage_element_8_eight_two_style_image = new tinyMceWysiwygSetup("homepage_element_8_eight_two_style_image", {"enabled":true,"hidden":true,"use_container":false,"add_variables":true,"add_widgets":true,"add_images":true,"no_display":false,"translator":{},"encode_directives":true,"directives_url":"'.$baseurl.'evolved/cms_wysiwyg/directive/","popup_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/dialog.css","content_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/content.css","width":"100%","plugins":[{"name":"magentovariable","src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentovariable/editor_plugin.js","options":{"title":"Insert Variable...","url":"'.$baseurl.'evolved/system_variable/wysiwygPlugin/","onclick":{"search":["html_id"],"subject":"MagentovariablePlugin.loadChooser(\''.$baseurl.'evolved/system_variable/wysiwygPlugin/\', \'{{html_id}}\');"},"class":"add-variable plugin"}}],"directives_url_quoted":"'.$baseurl.'evolved/cms_wysiwyg/directive/","files_browser_window_url":"'.$baseurl.'idealAdmin/cms_wysiwyg_images/index/","files_browser_window_width":1000,"files_browser_window_height":600,"widget_plugin_src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentowidget/editor_plugin.js","widget_images_url":"'.$siteurl.'skin/adminhtml/default/default/images/widget/","widget_placeholders":["Thumbs.db","catalog__category_widget_link.gif","catalog__product_widget_link.gif","catalog__product_widget_new.gif","cms__widget_block.gif","cms__widget_page_link.gif","default.gif","reports__product_widget_compared.gif","reports__product_widget_viewed.gif"],"widget_window_url":"'.$baseurl.'evolved/widget/index/","firebug_warning_title":"Warning","firebug_warning_text":"Firebug is known to make the WYSIWYG editor slow unless it is turned off or configured properly.","firebug_warning_anchor":"Hide"});';
      						$str = $str . 'editorFormValidationHandler = wysiwyghomepage_element_8_eight_two_style_image.onFormValidation.bind(wysiwyghomepage_element_8_eight_two_style_image);';
      						$str = $str . 'Event.observe("togglehomepage_element_8_eight_two_style_image", "click", wysiwyghomepage_element_8_eight_two_style_image.toggle.bind(wysiwyghomepage_element_8_eight_two_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("formSubmit", editorFormValidationHandler);';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceBeforeSetContent", wysiwyghomepage_element_8_eight_two_style_image.beforeSetContent.bind(wysiwyghomepage_element_8_eight_two_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceSaveContent", wysiwyghomepage_element_8_eight_two_style_image.saveContent.bind(wysiwyghomepage_element_8_eight_two_style_image));';
      						$str = $str . 'varienGlobalEvents.clearEventHandlers("open_browser_callback");';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("open_browser_callback", wysiwyghomepage_element_8_eight_two_style_image.openFileBrowser.bind(wysiwyghomepage_element_8_eight_two_style_image));';
      						$str = $str . '</script>';
      						$str = $str . '</tr>';
      						$str = $str . '</tbody>';
      						$str = $str . '</table>';
      						$str = $str . '<table cellspacing="0" class="form-list allpageelement" style="display: table-cell;">';
							$str = $str . '<tbody>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_eight_three_style_title">Title:</label></td>';  
      						$str = $str . '<td class="value"><input id="homepage_element_8_eight_three_style_title" value="'.$collectiondata['homepage_element_8_eight_three_style_title'].'" name="homepage_element_8_33_percentage_346_by_346_three_boxes_width[homepage_element_8_eight_three_style_title]"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str .	'<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_eight_three_style_link">Link:</label></td>';
      						$str = $str . '<td class="value"><input id="homepage_element_8_eight_three_style_link" value="'.$collectiondata['homepage_element_8_eight_three_style_link'].'" name="homepage_element_8_33_percentage_346_by_346_three_boxes_width[homepage_element_8_eight_three_style_link]"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_eight_three_style_target">Target:</label></td>';
      						$str = $str . '<td class="value">';
      						$str = $str . '<select id="homepage_element_8_eight_three_style_target" name="homepage_element_8_33_percentage_346_by_346_three_boxes_width[homepage_element_8_eight_three_style_target]" >';
      						foreach($targetarr as $targetarrkey => $targetarrvalue)
      						{
      							if($collectiondata['homepage_element_8_eight_three_style_target']==$targetarrkey)
      							{
      								$str = $str . '<option value='.$targetarrkey.' selected>'.$targetarrvalue.'</option>';
      							}
      							else
      							{
      								$str = $str . '<option value='.$targetarrkey.'>'.$targetarrvalue.'</option>';
      							}
      						}
      						$str = $str . '</select>';
      						$str = $str . '</td>';
      						$str = $str . '</tr>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_eight_three_style_image">Image:</label></td>';
      						//$str = $str . '<td class="value"><div id="buttonshomepage_element_8_eight_three_style_image" class="buttons-set"><button type="button" class="scalable show-hide" style="" id="togglehomepage_element_8_eight_three_style_image"><span><span><span>Show / Hide Editor</span></span></span></button><button type="button" class="scalable add-widget plugin" onclick="widgetTools.openDialog('.$baseurl.'evolved/widget/index/widget_target_id/homepage_element_8_eight_three_style_image)" style=""><span><span><span>Insert Widget...</span></span></span></button><button type="button" class="scalable add-image plugin" onclick="MediabrowserUtility.openDialog('.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_8_eight_three_style_image/)" style=""><span><span><span>Insert Image...</span></span></span></button><button type="button" class="scalable add-variable plugin" onclick="MagentovariablePlugin.loadChooser('.$baseurl.'evolved/system_variable/wysiwygPlugin/, homepage_element_8_eight_three_style_image);"><span><span><span>Insert Variable...</span></span></span></button></div><textarea name="homepage_element_8_eight_three_style_image" title="" id="homepage_element_8_eight_three_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_8_eight_three_style_image'].'</textarea><small>Image size must be 1920*480 pixels</small></td>';
      						$str = $str . '<td class="value"><button id="togglehomepage_element_8_eight_three_style_image" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><div id="buttonshomepage_element_8_eight_three_style_image" class="buttons-set"><button style="" onclick="MediabrowserUtility.openDialog(\''.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_8_eight_three_style_image/\')" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button></div><textarea name="homepage_element_8_33_percentage_346_by_346_three_boxes_width[homepage_element_8_eight_three_style_image]" title="" id="homepage_element_8_eight_three_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_8_eight_three_style_image'].'</textarea><small>Image size must be 346*346 pixels</small></td>';
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
      						$str = $str . '}wysiwyghomepage_element_8_eight_three_style_image = new tinyMceWysiwygSetup("homepage_element_8_eight_three_style_image", {"enabled":true,"hidden":true,"use_container":false,"add_variables":true,"add_widgets":true,"add_images":true,"no_display":false,"translator":{},"encode_directives":true,"directives_url":"'.$baseurl.'evolved/cms_wysiwyg/directive/","popup_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/dialog.css","content_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/content.css","width":"100%","plugins":[{"name":"magentovariable","src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentovariable/editor_plugin.js","options":{"title":"Insert Variable...","url":"'.$baseurl.'evolved/system_variable/wysiwygPlugin/","onclick":{"search":["html_id"],"subject":"MagentovariablePlugin.loadChooser(\''.$baseurl.'evolved/system_variable/wysiwygPlugin/\', \'{{html_id}}\');"},"class":"add-variable plugin"}}],"directives_url_quoted":"'.$baseurl.'evolved/cms_wysiwyg/directive/","files_browser_window_url":"'.$baseurl.'idealAdmin/cms_wysiwyg_images/index/","files_browser_window_width":1000,"files_browser_window_height":600,"widget_plugin_src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentowidget/editor_plugin.js","widget_images_url":"'.$siteurl.'skin/adminhtml/default/default/images/widget/","widget_placeholders":["Thumbs.db","catalog__category_widget_link.gif","catalog__product_widget_link.gif","catalog__product_widget_new.gif","cms__widget_block.gif","cms__widget_page_link.gif","default.gif","reports__product_widget_compared.gif","reports__product_widget_viewed.gif"],"widget_window_url":"'.$baseurl.'evolved/widget/index/","firebug_warning_title":"Warning","firebug_warning_text":"Firebug is known to make the WYSIWYG editor slow unless it is turned off or configured properly.","firebug_warning_anchor":"Hide"});';
      						$str = $str . 'editorFormValidationHandler = wysiwyghomepage_element_8_eight_three_style_image.onFormValidation.bind(wysiwyghomepage_element_8_eight_three_style_image);';
      						$str = $str . 'Event.observe("togglehomepage_element_8_eight_three_style_image", "click", wysiwyghomepage_element_8_eight_three_style_image.toggle.bind(wysiwyghomepage_element_8_eight_three_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("formSubmit", editorFormValidationHandler);';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceBeforeSetContent", wysiwyghomepage_element_8_eight_three_style_image.beforeSetContent.bind(wysiwyghomepage_element_8_eight_three_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceSaveContent", wysiwyghomepage_element_8_eight_three_style_image.saveContent.bind(wysiwyghomepage_element_8_eight_three_style_image));';
      						$str = $str . 'varienGlobalEvents.clearEventHandlers("open_browser_callback");';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("open_browser_callback", wysiwyghomepage_element_8_eight_three_style_image.openFileBrowser.bind(wysiwyghomepage_element_8_eight_three_style_image));';
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
      						if($selectElement == 'homepage_element_8_33_percentage_346_by_346_three_boxes_middle_updown_width')
      						{
      							$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="homepage_element_8_33_percentage_346_by_346_three_boxes_middle_updown_width" style="display: block">';
      						}
      						else
      						{
      							$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="homepage_element_8_33_percentage_346_by_346_three_boxes_middle_updown_width"  style="display: none">';
      						}
      						//$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="33_percentage_346_by_346_three_boxes_middle_updown_width">';
      						$str = $str . '<tbody>';
      						$str = $str . '<tr>';
      						$str = $str . '<td>';
      						$str = $str . '<table cellspacing="0" class="form-list allpageelement" style="display: table-cell;">';
							$str = $str . '<tbody>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_nine_one_style_title">Title:</label></td>';  
      						$str = $str . '<td class="value"><input id="homepage_element_8_nine_one_style_title" value="'.$collectiondata['homepage_element_8_nine_one_style_title'].'" name="homepage_element_8_33_percentage_346_by_346_three_boxes_middle_updown_width[homepage_element_8_nine_one_style_title]"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str .	'<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_nine_one_style_link">Link:</label></td>';
      						$str = $str . '<td class="value"><input id="homepage_element_8_nine_one_style_link" value="'.$collectiondata['homepage_element_8_nine_one_style_link'].'" name="homepage_element_8_33_percentage_346_by_346_three_boxes_middle_updown_width[homepage_element_8_nine_one_style_link]"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_nine_one_style_target">Target:</label></td>';
      						$str = $str . '<td class="value">';
      						$str = $str . '<select id="homepage_element_8_nine_one_style_target" name="homepage_element_8_33_percentage_346_by_346_three_boxes_middle_updown_width[homepage_element_8_nine_one_style_target]" >';
      						foreach($targetarr as $targetarrkey => $targetarrvalue)
      						{
      							if($collectiondata['homepage_element_8_nine_one_style_target']==$targetarrkey)
      							{
      								$str = $str . '<option value='.$targetarrkey.' selected>'.$targetarrvalue.'</option>';
      							}
      							else
      							{
      								$str = $str . '<option value='.$targetarrkey.'>'.$targetarrvalue.'</option>';
      							}
      						}
      						$str = $str . '</select>';
      						$str = $str . '</td>';
      						$str = $str . '</tr>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_nine_one_style_image">Image:</label></td>';
      						//$str = $str . '<td class="value"><div id="buttonshomepage_element_8_nine_one_style_image" class="buttons-set"><button type="button" class="scalable show-hide" style="" id="togglehomepage_element_8_nine_one_style_image"><span><span><span>Show / Hide Editor</span></span></span></button><button type="button" class="scalable add-widget plugin" onclick="widgetTools.openDialog('.$baseurl.'evolved/widget/index/widget_target_id/homepage_element_8_nine_one_style_image)" style=""><span><span><span>Insert Widget...</span></span></span></button><button type="button" class="scalable add-image plugin" onclick="MediabrowserUtility.openDialog('.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_8_nine_one_style_image/)" style=""><span><span><span>Insert Image...</span></span></span></button><button type="button" class="scalable add-variable plugin" onclick="MagentovariablePlugin.loadChooser('.$baseurl.'evolved/system_variable/wysiwygPlugin/, homepage_element_8_nine_one_style_image);"><span><span><span>Insert Variable...</span></span></span></button></div><textarea name="homepage_element_8_nine_one_style_image" title="" id="homepage_element_8_nine_one_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_8_nine_one_style_image'].'</textarea><small>Image size must be 1920*480 pixels</small></td>';
      						$str = $str . '<td class="value"><button id="togglehomepage_element_8_nine_one_style_image" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><div id="buttonshomepage_element_8_nine_one_style_image" class="buttons-set"><button style="" onclick="MediabrowserUtility.openDialog(\''.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_8_nine_one_style_image/\')" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button></div><textarea name="homepage_element_8_33_percentage_346_by_346_three_boxes_middle_updown_width[homepage_element_8_nine_one_style_image]" title="" id="homepage_element_8_nine_one_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_8_nine_one_style_image'].'</textarea><small>Image size must be 346*346 pixels</small></td>';
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
      						$str = $str . '}wysiwyghomepage_element_8_nine_one_style_image = new tinyMceWysiwygSetup("homepage_element_8_nine_one_style_image", {"enabled":true,"hidden":true,"use_container":false,"add_variables":true,"add_widgets":true,"add_images":true,"no_display":false,"translator":{},"encode_directives":true,"directives_url":"'.$baseurl.'evolved/cms_wysiwyg/directive/","popup_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/dialog.css","content_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/content.css","width":"100%","plugins":[{"name":"magentovariable","src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentovariable/editor_plugin.js","options":{"title":"Insert Variable...","url":"'.$baseurl.'evolved/system_variable/wysiwygPlugin/","onclick":{"search":["html_id"],"subject":"MagentovariablePlugin.loadChooser(\''.$baseurl.'evolved/system_variable/wysiwygPlugin/\', \'{{html_id}}\');"},"class":"add-variable plugin"}}],"directives_url_quoted":"'.$baseurl.'evolved/cms_wysiwyg/directive/","files_browser_window_url":"'.$baseurl.'idealAdmin/cms_wysiwyg_images/index/","files_browser_window_width":1000,"files_browser_window_height":600,"widget_plugin_src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentowidget/editor_plugin.js","widget_images_url":"'.$siteurl.'skin/adminhtml/default/default/images/widget/","widget_placeholders":["Thumbs.db","catalog__category_widget_link.gif","catalog__product_widget_link.gif","catalog__product_widget_new.gif","cms__widget_block.gif","cms__widget_page_link.gif","default.gif","reports__product_widget_compared.gif","reports__product_widget_viewed.gif"],"widget_window_url":"'.$baseurl.'evolved/widget/index/","firebug_warning_title":"Warning","firebug_warning_text":"Firebug is known to make the WYSIWYG editor slow unless it is turned off or configured properly.","firebug_warning_anchor":"Hide"});';
      						$str = $str . 'editorFormValidationHandler = wysiwyghomepage_element_8_nine_one_style_image.onFormValidation.bind(wysiwyghomepage_element_8_nine_one_style_image);';
      						$str = $str . 'Event.observe("togglehomepage_element_8_nine_one_style_image", "click", wysiwyghomepage_element_8_nine_one_style_image.toggle.bind(wysiwyghomepage_element_8_nine_one_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("formSubmit", editorFormValidationHandler);';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceBeforeSetContent", wysiwyghomepage_element_8_nine_one_style_image.beforeSetContent.bind(wysiwyghomepage_element_8_nine_one_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceSaveContent", wysiwyghomepage_element_8_nine_one_style_image.saveContent.bind(wysiwyghomepage_element_8_nine_one_style_image));';
      						$str = $str . 'varienGlobalEvents.clearEventHandlers("open_browser_callback");';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("open_browser_callback", wysiwyghomepage_element_8_nine_one_style_image.openFileBrowser.bind(wysiwyghomepage_element_8_nine_one_style_image));';
      						$str = $str . '</script>';
      						$str = $str . '</tr>';
      						$str = $str . '</tbody>';
      						$str = $str . '</table>'; 
      						$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelement" style="display: table-cell;">';
							$str = $str . '<tbody>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_nine_two_up_style_title">Title:</label></td>';  
      						$str = $str . '<td class="value"><input id="homepage_element_8_nine_two_up_style_title" value="'.$collectiondata['homepage_element_8_nine_two_up_style_title'].'" name="homepage_element_8_33_percentage_346_by_346_three_boxes_middle_updown_width[homepage_element_8_nine_two_up_style_title]"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str .	'<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_nine_two_up_style_link">Link:</label></td>';
      						$str = $str . '<td class="value"><input id="homepage_element_8_nine_two_up_style_link" value="'.$collectiondata['homepage_element_8_nine_two_up_style_link'].'" name="homepage_element_8_33_percentage_346_by_346_three_boxes_middle_updown_width[homepage_element_8_nine_two_up_style_link]"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_nine_two_up_style_target">Target:</label></td>';
      						$str = $str . '<td class="value">';
      						$str = $str . '<select id="homepage_element_8_nine_two_up_style_target" name="homepage_element_8_33_percentage_346_by_346_three_boxes_middle_updown_width[homepage_element_8_nine_two_up_style_target]" >';
      						foreach($targetarr as $targetarrkey => $targetarrvalue)
      						{
      							if($collectiondata['homepage_element_8_nine_two_up_style_target']==$targetarrkey)
      							{
      								$str = $str . '<option value='.$targetarrkey.' selected>'.$targetarrvalue.'</option>';
      							}
      							else
      							{
      								$str = $str . '<option value='.$targetarrkey.'>'.$targetarrvalue.'</option>';
      							}
      						}
      						$str = $str . '</select>';
      						$str = $str . '</td>';
      						$str = $str . '</tr>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_nine_two_up_style_image">Image:</label></td>';
      						//$str = $str . '<td class="value"><div id="buttonshomepage_element_8_nine_two_up_style_image" class="buttons-set"><button type="button" class="scalable show-hide" style="" id="togglehomepage_element_8_nine_two_up_style_image"><span><span><span>Show / Hide Editor</span></span></span></button><button type="button" class="scalable add-widget plugin" onclick="widgetTools.openDialog('.$baseurl.'evolved/widget/index/widget_target_id/homepage_element_8_nine_two_up_style_image)" style=""><span><span><span>Insert Widget...</span></span></span></button><button type="button" class="scalable add-image plugin" onclick="MediabrowserUtility.openDialog('.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_8_nine_two_up_style_image/)" style=""><span><span><span>Insert Image...</span></span></span></button><button type="button" class="scalable add-variable plugin" onclick="MagentovariablePlugin.loadChooser('.$baseurl.'evolved/system_variable/wysiwygPlugin/, homepage_element_8_nine_two_up_style_image);"><span><span><span>Insert Variable...</span></span></span></button></div><textarea name="homepage_element_8_nine_two_up_style_image" title="" id="homepage_element_8_nine_two_up_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_8_nine_two_up_style_image'].'</textarea><small>Image size must be 1920*480 pixels</small></td>';
      						$str = $str . '<td class="value"><button id="togglehomepage_element_8_nine_two_up_style_image" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><div id="buttonshomepage_element_8_nine_two_up_style_image" class="buttons-set"><button style="" onclick="MediabrowserUtility.openDialog(\''.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_8_nine_two_up_style_image/\')" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button></div><textarea name="homepage_element_8_33_percentage_346_by_346_three_boxes_middle_updown_width[homepage_element_8_nine_two_up_style_image]" title="" id="homepage_element_8_nine_two_up_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_8_nine_two_up_style_image'].'</textarea><small>Image size must be 346*170 pixels</small></td>';
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
      						$str = $str . '}wysiwyghomepage_element_8_nine_two_up_style_image = new tinyMceWysiwygSetup("homepage_element_8_nine_two_up_style_image", {"enabled":true,"hidden":true,"use_container":false,"add_variables":true,"add_widgets":true,"add_images":true,"no_display":false,"translator":{},"encode_directives":true,"directives_url":"'.$baseurl.'evolved/cms_wysiwyg/directive/","popup_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/dialog.css","content_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/content.css","width":"100%","plugins":[{"name":"magentovariable","src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentovariable/editor_plugin.js","options":{"title":"Insert Variable...","url":"'.$baseurl.'evolved/system_variable/wysiwygPlugin/","onclick":{"search":["html_id"],"subject":"MagentovariablePlugin.loadChooser(\''.$baseurl.'evolved/system_variable/wysiwygPlugin/\', \'{{html_id}}\');"},"class":"add-variable plugin"}}],"directives_url_quoted":"'.$baseurl.'evolved/cms_wysiwyg/directive/","files_browser_window_url":"'.$baseurl.'idealAdmin/cms_wysiwyg_images/index/","files_browser_window_width":1000,"files_browser_window_height":600,"widget_plugin_src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentowidget/editor_plugin.js","widget_images_url":"'.$siteurl.'skin/adminhtml/default/default/images/widget/","widget_placeholders":["Thumbs.db","catalog__category_widget_link.gif","catalog__product_widget_link.gif","catalog__product_widget_new.gif","cms__widget_block.gif","cms__widget_page_link.gif","default.gif","reports__product_widget_compared.gif","reports__product_widget_viewed.gif"],"widget_window_url":"'.$baseurl.'evolved/widget/index/","firebug_warning_title":"Warning","firebug_warning_text":"Firebug is known to make the WYSIWYG editor slow unless it is turned off or configured properly.","firebug_warning_anchor":"Hide"});';
      						$str = $str . 'editorFormValidationHandler = wysiwyghomepage_element_8_nine_two_up_style_image.onFormValidation.bind(wysiwyghomepage_element_8_nine_two_up_style_image);';
      						$str = $str . 'Event.observe("togglehomepage_element_8_nine_two_up_style_image", "click", wysiwyghomepage_element_8_nine_two_up_style_image.toggle.bind(wysiwyghomepage_element_8_nine_two_up_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("formSubmit", editorFormValidationHandler);';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceBeforeSetContent", wysiwyghomepage_element_8_nine_two_up_style_image.beforeSetContent.bind(wysiwyghomepage_element_8_nine_two_up_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceSaveContent", wysiwyghomepage_element_8_nine_two_up_style_image.saveContent.bind(wysiwyghomepage_element_8_nine_two_up_style_image));';
      						$str = $str . 'varienGlobalEvents.clearEventHandlers("open_browser_callback");';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("open_browser_callback", wysiwyghomepage_element_8_nine_two_up_style_image.openFileBrowser.bind(wysiwyghomepage_element_8_nine_two_up_style_image));';
      						$str = $str . '</script>';
      						$str = $str . '</tr>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_nine_two_down_style_title">Title:</label></td>';  
      						$str = $str . '<td class="value"><input id="homepage_element_8_nine_two_down_style_title" value="'.$collectiondata['homepage_element_8_nine_two_down_style_title'].'" name="homepage_element_8_33_percentage_346_by_346_three_boxes_middle_updown_width[homepage_element_8_nine_two_down_style_title]"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str .	'<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_nine_two_down_style_link">Link:</label></td>';
      						$str = $str . '<td class="value"><input id="homepage_element_8_nine_two_down_style_link" value="'.$collectiondata['homepage_element_8_nine_two_down_style_link'].'" name="homepage_element_8_33_percentage_346_by_346_three_boxes_middle_updown_width[homepage_element_8_nine_two_down_style_link]"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_nine_two_down_style_target">Target:</label></td>';
      						$str = $str . '<td class="value">';
      						$str = $str . '<select id="homepage_element_8_nine_two_down_style_target" name="homepage_element_8_33_percentage_346_by_346_three_boxes_middle_updown_width[homepage_element_8_nine_two_down_style_target]" >';
      						foreach($targetarr as $targetarrkey => $targetarrvalue)
      						{
      							if($collectiondata['homepage_element_8_nine_two_down_style_target']==$targetarrkey)
      							{
      								$str = $str . '<option value='.$targetarrkey.' selected>'.$targetarrvalue.'</option>';
      							}
      							else
      							{
      								$str = $str . '<option value='.$targetarrkey.'>'.$targetarrvalue.'</option>';
      							}
      						}
      						$str = $str . '</select>';
      						$str = $str . '</td>';
      						$str = $str . '</tr>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_nine_two_down_style_image">Image:</label></td>';
      						//$str = $str . '<td class="value"><div id="buttonshomepage_element_8_nine_two_down_style_image" class="buttons-set"><button type="button" class="scalable show-hide" style="" id="togglehomepage_element_8_nine_two_down_style_image"><span><span><span>Show / Hide Editor</span></span></span></button><button type="button" class="scalable add-widget plugin" onclick="widgetTools.openDialog('.$baseurl.'evolved/widget/index/widget_target_id/homepage_element_8_nine_two_down_style_image)" style=""><span><span><span>Insert Widget...</span></span></span></button><button type="button" class="scalable add-image plugin" onclick="MediabrowserUtility.openDialog('.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_8_nine_two_down_style_image/)" style=""><span><span><span>Insert Image...</span></span></span></button><button type="button" class="scalable add-variable plugin" onclick="MagentovariablePlugin.loadChooser('.$baseurl.'evolved/system_variable/wysiwygPlugin/, homepage_element_8_nine_two_down_style_image);"><span><span><span>Insert Variable...</span></span></span></button></div><textarea name="homepage_element_8_nine_two_down_style_image" title="" id="homepage_element_8_nine_two_down_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_8_nine_two_down_style_image'].'</textarea><small>Image size must be 1920*480 pixels</small></td>';
      						$str = $str . '<td class="value"><button id="togglehomepage_element_8_nine_two_down_style_image" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><div id="buttonshomepage_element_8_nine_two_down_style_image" class="buttons-set"><button style="" onclick="MediabrowserUtility.openDialog(\''.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_8_nine_two_down_style_image/\')" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button></div><textarea name="homepage_element_8_33_percentage_346_by_346_three_boxes_middle_updown_width[homepage_element_8_nine_two_down_style_image]" title="" id="homepage_element_8_nine_two_down_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_8_nine_two_down_style_image'].'</textarea><small>Image size must be 346*170 pixels</small></td>';
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
      						$str = $str . '}wysiwyghomepage_element_8_nine_two_down_style_image = new tinyMceWysiwygSetup("homepage_element_8_nine_two_down_style_image", {"enabled":true,"hidden":true,"use_container":false,"add_variables":true,"add_widgets":true,"add_images":true,"no_display":false,"translator":{},"encode_directives":true,"directives_url":"'.$baseurl.'evolved/cms_wysiwyg/directive/","popup_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/dialog.css","content_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/content.css","width":"100%","plugins":[{"name":"magentovariable","src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentovariable/editor_plugin.js","options":{"title":"Insert Variable...","url":"'.$baseurl.'evolved/system_variable/wysiwygPlugin/","onclick":{"search":["html_id"],"subject":"MagentovariablePlugin.loadChooser(\''.$baseurl.'evolved/system_variable/wysiwygPlugin/\', \'{{html_id}}\');"},"class":"add-variable plugin"}}],"directives_url_quoted":"'.$baseurl.'evolved/cms_wysiwyg/directive/","files_browser_window_url":"'.$baseurl.'idealAdmin/cms_wysiwyg_images/index/","files_browser_window_width":1000,"files_browser_window_height":600,"widget_plugin_src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentowidget/editor_plugin.js","widget_images_url":"'.$siteurl.'skin/adminhtml/default/default/images/widget/","widget_placeholders":["Thumbs.db","catalog__category_widget_link.gif","catalog__product_widget_link.gif","catalog__product_widget_new.gif","cms__widget_block.gif","cms__widget_page_link.gif","default.gif","reports__product_widget_compared.gif","reports__product_widget_viewed.gif"],"widget_window_url":"'.$baseurl.'evolved/widget/index/","firebug_warning_title":"Warning","firebug_warning_text":"Firebug is known to make the WYSIWYG editor slow unless it is turned off or configured properly.","firebug_warning_anchor":"Hide"});';
      						$str = $str . 'editorFormValidationHandler = wysiwyghomepage_element_8_nine_two_down_style_image.onFormValidation.bind(wysiwyghomepage_element_8_nine_two_down_style_image);';
      						$str = $str . 'Event.observe("togglehomepage_element_8_nine_two_down_style_image", "click", wysiwyghomepage_element_8_nine_two_down_style_image.toggle.bind(wysiwyghomepage_element_8_nine_two_down_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("formSubmit", editorFormValidationHandler);';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceBeforeSetContent", wysiwyghomepage_element_8_nine_two_down_style_image.beforeSetContent.bind(wysiwyghomepage_element_8_nine_two_down_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceSaveContent", wysiwyghomepage_element_8_nine_two_down_style_image.saveContent.bind(wysiwyghomepage_element_8_nine_two_down_style_image));';
      						$str = $str . 'varienGlobalEvents.clearEventHandlers("open_browser_callback");';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("open_browser_callback", wysiwyghomepage_element_8_nine_two_down_style_image.openFileBrowser.bind(wysiwyghomepage_element_8_nine_two_down_style_image));';
      						$str = $str . '</script>';
      						$str = $str . '</tr>';
      						$str = $str . '</tbody>';
      						$str = $str . '</table>';
      						$str = $str . '<table cellspacing="0" class="form-list allpageelement" style="display: table-cell;">';
							$str = $str . '<tbody>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_nine_three_style_title">Title:</label></td>';  
      						$str = $str . '<td class="value"><input id="homepage_element_8_nine_three_style_title" value="'.$collectiondata['homepage_element_8_nine_three_style_title'].'" name="homepage_element_8_33_percentage_346_by_346_three_boxes_middle_updown_width[homepage_element_8_nine_three_style_title]"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str .	'<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_nine_three_style_link">Link:</label></td>';
      						$str = $str . '<td class="value"><input id="homepage_element_8_nine_three_style_link" value="'.$collectiondata['homepage_element_8_nine_three_style_link'].'" name="homepage_element_8_33_percentage_346_by_346_three_boxes_middle_updown_width[homepage_element_8_nine_three_style_link]"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_nine_three_style_target">Target:</label></td>';
      						$str = $str . '<td class="value">';
      						$str = $str . '<select id="homepage_element_8_nine_three_style_target" name="homepage_element_8_33_percentage_346_by_346_three_boxes_middle_updown_width[homepage_element_8_nine_three_style_target]" >';
      						foreach($targetarr as $targetarrkey => $targetarrvalue)
      						{
      							if($collectiondata['homepage_element_8_nine_three_style_target']==$targetarrkey)
      							{
      								$str = $str . '<option value='.$targetarrkey.' selected>'.$targetarrvalue.'</option>';
      							}
      							else
      							{
      								$str = $str . '<option value='.$targetarrkey.'>'.$targetarrvalue.'</option>';
      							}
      						}
      						$str = $str . '</select>';
      						$str = $str . '</td>';
      						$str = $str . '</tr>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_nine_three_style_image">Image:</label></td>';
      						//$str = $str . '<td class="value"><div id="buttonshomepage_element_8_nine_three_style_image" class="buttons-set"><button type="button" class="scalable show-hide" style="" id="togglehomepage_element_8_nine_three_style_image"><span><span><span>Show / Hide Editor</span></span></span></button><button type="button" class="scalable add-widget plugin" onclick="widgetTools.openDialog('.$baseurl.'evolved/widget/index/widget_target_id/homepage_element_8_nine_three_style_image)" style=""><span><span><span>Insert Widget...</span></span></span></button><button type="button" class="scalable add-image plugin" onclick="MediabrowserUtility.openDialog('.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_8_nine_three_style_image/)" style=""><span><span><span>Insert Image...</span></span></span></button><button type="button" class="scalable add-variable plugin" onclick="MagentovariablePlugin.loadChooser('.$baseurl.'evolved/system_variable/wysiwygPlugin/, homepage_element_8_nine_three_style_image);"><span><span><span>Insert Variable...</span></span></span></button></div><textarea name="homepage_element_8_nine_three_style_image" title="" id="homepage_element_8_nine_three_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_8_nine_three_style_image'].'</textarea><small>Image size must be 1920*480 pixels</small></td>';
      						$str = $str . '<td class="value"><button id="togglehomepage_element_8_nine_three_style_image" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><div id="buttonshomepage_element_8_nine_three_style_image" class="buttons-set"><button style="" onclick="MediabrowserUtility.openDialog(\''.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_8_nine_three_style_image/\')" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button></div><textarea name="homepage_element_8_33_percentage_346_by_346_three_boxes_middle_updown_width[homepage_element_8_nine_three_style_image]" title="" id="homepage_element_8_nine_three_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_8_nine_three_style_image'].'</textarea><small>Image size must be 346*346 pixels</small></td>';
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
      						$str = $str . '}wysiwyghomepage_element_8_nine_three_style_image = new tinyMceWysiwygSetup("homepage_element_8_nine_three_style_image", {"enabled":true,"hidden":true,"use_container":false,"add_variables":true,"add_widgets":true,"add_images":true,"no_display":false,"translator":{},"encode_directives":true,"directives_url":"'.$baseurl.'evolved/cms_wysiwyg/directive/","popup_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/dialog.css","content_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/content.css","width":"100%","plugins":[{"name":"magentovariable","src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentovariable/editor_plugin.js","options":{"title":"Insert Variable...","url":"'.$baseurl.'evolved/system_variable/wysiwygPlugin/","onclick":{"search":["html_id"],"subject":"MagentovariablePlugin.loadChooser(\''.$baseurl.'evolved/system_variable/wysiwygPlugin/\', \'{{html_id}}\');"},"class":"add-variable plugin"}}],"directives_url_quoted":"'.$baseurl.'evolved/cms_wysiwyg/directive/","files_browser_window_url":"'.$baseurl.'idealAdmin/cms_wysiwyg_images/index/","files_browser_window_width":1000,"files_browser_window_height":600,"widget_plugin_src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentowidget/editor_plugin.js","widget_images_url":"'.$siteurl.'skin/adminhtml/default/default/images/widget/","widget_placeholders":["Thumbs.db","catalog__category_widget_link.gif","catalog__product_widget_link.gif","catalog__product_widget_new.gif","cms__widget_block.gif","cms__widget_page_link.gif","default.gif","reports__product_widget_compared.gif","reports__product_widget_viewed.gif"],"widget_window_url":"'.$baseurl.'evolved/widget/index/","firebug_warning_title":"Warning","firebug_warning_text":"Firebug is known to make the WYSIWYG editor slow unless it is turned off or configured properly.","firebug_warning_anchor":"Hide"});';
      						$str = $str . 'editorFormValidationHandler = wysiwyghomepage_element_8_nine_three_style_image.onFormValidation.bind(wysiwyghomepage_element_8_nine_three_style_image);';
      						$str = $str . 'Event.observe("togglehomepage_element_8_nine_three_style_image", "click", wysiwyghomepage_element_8_nine_three_style_image.toggle.bind(wysiwyghomepage_element_8_nine_three_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("formSubmit", editorFormValidationHandler);';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceBeforeSetContent", wysiwyghomepage_element_8_nine_three_style_image.beforeSetContent.bind(wysiwyghomepage_element_8_nine_three_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceSaveContent", wysiwyghomepage_element_8_nine_three_style_image.saveContent.bind(wysiwyghomepage_element_8_nine_three_style_image));';
      						$str = $str . 'varienGlobalEvents.clearEventHandlers("open_browser_callback");';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("open_browser_callback", wysiwyghomepage_element_8_nine_three_style_image.openFileBrowser.bind(wysiwyghomepage_element_8_nine_three_style_image));';
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
      						if($selectElement == 'homepage_element_8_33_percentage_346_by_346_three_boxes_leftright_updown_width')
      						{
      							$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="homepage_element_8_33_percentage_346_by_346_three_boxes_leftright_updown_width" style="display: block">';
      						}
      						else
      						{
      							$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="homepage_element_8_33_percentage_346_by_346_three_boxes_leftright_updown_width"  style="display: none">';
      						}
      						//$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="33_percentage_346_by_346_three_boxes_leftright_updown_width">';
      						$str = $str . '<tbody>';
      						$str = $str . '<tr>';
      						$str = $str . '<td>';
      						$str = $str . '<table cellspacing="0" class="form-list allpageelement" style="display: table-cell;">';
							$str = $str . '<tbody>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_ten_one_up_style_title">Title:</label></td>';  
      						$str = $str . '<td class="value"><input id="homepage_element_8_ten_one_up_style_title" value="'.$collectiondata['homepage_element_8_ten_one_up_style_title'].'" name="homepage_element_8_33_percentage_346_by_346_three_boxes_leftright_updown_width[homepage_element_8_ten_one_up_style_title]"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str .	'<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_ten_one_up_style_link">Link:</label></td>';
      						$str = $str . '<td class="value"><input id="homepage_element_8_ten_one_up_style_link" value="'.$collectiondata['homepage_element_8_ten_one_up_style_link'].'" name="homepage_element_8_33_percentage_346_by_346_three_boxes_leftright_updown_width[homepage_element_8_ten_one_up_style_link]"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_ten_one_up_style_target">Target:</label></td>';
      						$str = $str . '<td class="value">';
      						$str = $str . '<select id="homepage_element_8_ten_one_up_style_target" name="homepage_element_8_33_percentage_346_by_346_three_boxes_leftright_updown_width[homepage_element_8_ten_one_up_style_target]" >';
      						foreach($targetarr as $targetarrkey => $targetarrvalue)
      						{
      							if($collectiondata['homepage_element_8_ten_one_up_style_target']==$targetarrkey)
      							{
      								$str = $str . '<option value='.$targetarrkey.' selected>'.$targetarrvalue.'</option>';
      							}
      							else
      							{
      								$str = $str . '<option value='.$targetarrkey.'>'.$targetarrvalue.'</option>';
      							}
      						}
      						$str = $str . '</select>';
      						$str = $str . '</td>';
      						$str = $str . '</tr>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_ten_one_up_style_image">Image:</label></td>';
      						//$str = $str . '<td class="value"><div id="buttonshomepage_element_8_ten_one_up_style_image" class="buttons-set"><button type="button" class="scalable show-hide" style="" id="togglehomepage_element_8_ten_one_up_style_image"><span><span><span>Show / Hide Editor</span></span></span></button><button type="button" class="scalable add-widget plugin" onclick="widgetTools.openDialog('.$baseurl.'evolved/widget/index/widget_target_id/homepage_element_8_ten_one_up_style_image)" style=""><span><span><span>Insert Widget...</span></span></span></button><button type="button" class="scalable add-image plugin" onclick="MediabrowserUtility.openDialog('.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_8_ten_one_up_style_image/)" style=""><span><span><span>Insert Image...</span></span></span></button><button type="button" class="scalable add-variable plugin" onclick="MagentovariablePlugin.loadChooser('.$baseurl.'evolved/system_variable/wysiwygPlugin/, homepage_element_8_ten_one_up_style_image);"><span><span><span>Insert Variable...</span></span></span></button></div><textarea name="homepage_element_8_ten_one_up_style_image" title="" id="homepage_element_8_ten_one_up_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_8_ten_one_up_style_image'].'</textarea><small>Image size must be 1920*480 pixels</small></td>';
      						$str = $str . '<td class="value"><button id="togglehomepage_element_8_ten_one_up_style_image" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><div id="buttonshomepage_element_8_ten_one_up_style_image" class="buttons-set"><button style="" onclick="MediabrowserUtility.openDialog(\''.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_8_ten_one_up_style_image/\')" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button></div><textarea name="homepage_element_8_33_percentage_346_by_346_three_boxes_leftright_updown_width[homepage_element_8_ten_one_up_style_image]" title="" id="homepage_element_8_ten_one_up_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_8_ten_one_up_style_image'].'</textarea><small>Image size must be 346*170 pixels</small></td>';
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
      						$str = $str . '}wysiwyghomepage_element_8_ten_one_up_style_image = new tinyMceWysiwygSetup("homepage_element_8_ten_one_up_style_image", {"enabled":true,"hidden":true,"use_container":false,"add_variables":true,"add_widgets":true,"add_images":true,"no_display":false,"translator":{},"encode_directives":true,"directives_url":"'.$baseurl.'evolved/cms_wysiwyg/directive/","popup_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/dialog.css","content_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/content.css","width":"100%","plugins":[{"name":"magentovariable","src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentovariable/editor_plugin.js","options":{"title":"Insert Variable...","url":"'.$baseurl.'evolved/system_variable/wysiwygPlugin/","onclick":{"search":["html_id"],"subject":"MagentovariablePlugin.loadChooser(\''.$baseurl.'evolved/system_variable/wysiwygPlugin/\', \'{{html_id}}\');"},"class":"add-variable plugin"}}],"directives_url_quoted":"'.$baseurl.'evolved/cms_wysiwyg/directive/","files_browser_window_url":"'.$baseurl.'idealAdmin/cms_wysiwyg_images/index/","files_browser_window_width":1000,"files_browser_window_height":600,"widget_plugin_src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentowidget/editor_plugin.js","widget_images_url":"'.$siteurl.'skin/adminhtml/default/default/images/widget/","widget_placeholders":["Thumbs.db","catalog__category_widget_link.gif","catalog__product_widget_link.gif","catalog__product_widget_new.gif","cms__widget_block.gif","cms__widget_page_link.gif","default.gif","reports__product_widget_compared.gif","reports__product_widget_viewed.gif"],"widget_window_url":"'.$baseurl.'evolved/widget/index/","firebug_warning_title":"Warning","firebug_warning_text":"Firebug is known to make the WYSIWYG editor slow unless it is turned off or configured properly.","firebug_warning_anchor":"Hide"});';
      						$str = $str . 'editorFormValidationHandler = wysiwyghomepage_element_8_ten_one_up_style_image.onFormValidation.bind(wysiwyghomepage_element_8_ten_one_up_style_image);';
      						$str = $str . 'Event.observe("togglehomepage_element_8_ten_one_up_style_image", "click", wysiwyghomepage_element_8_ten_one_up_style_image.toggle.bind(wysiwyghomepage_element_8_ten_one_up_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("formSubmit", editorFormValidationHandler);';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceBeforeSetContent", wysiwyghomepage_element_8_ten_one_up_style_image.beforeSetContent.bind(wysiwyghomepage_element_8_ten_one_up_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceSaveContent", wysiwyghomepage_element_8_ten_one_up_style_image.saveContent.bind(wysiwyghomepage_element_8_ten_one_up_style_image));';
      						$str = $str . 'varienGlobalEvents.clearEventHandlers("open_browser_callback");';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("open_browser_callback", wysiwyghomepage_element_8_ten_one_up_style_image.openFileBrowser.bind(wysiwyghomepage_element_8_ten_one_up_style_image));';
      						$str = $str . '</script>';
      						$str = $str . '</tr>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_ten_one_down_style_title">Title:</label></td>';  
      						$str = $str . '<td class="value"><input id="homepage_element_8_ten_one_down_style_title" value="'.$collectiondata['homepage_element_8_ten_one_down_style_title'].'" name="homepage_element_8_33_percentage_346_by_346_three_boxes_leftright_updown_width[homepage_element_8_ten_one_down_style_title]"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str .	'<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_ten_one_down_style_link">Link:</label></td>';
      						$str = $str . '<td class="value"><input id="homepage_element_8_ten_one_down_style_link" value="'.$collectiondata['homepage_element_8_ten_one_down_style_link'].'" name="homepage_element_8_33_percentage_346_by_346_three_boxes_leftright_updown_width[homepage_element_8_ten_one_down_style_link]"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_ten_one_down_style_target">Target:</label></td>';
      						$str = $str . '<td class="value">';
      						$str = $str . '<select id="homepage_element_8_ten_one_down_style_target" name="homepage_element_8_33_percentage_346_by_346_three_boxes_leftright_updown_width[homepage_element_8_ten_one_down_style_target]" >';
      						foreach($targetarr as $targetarrkey => $targetarrvalue)
      						{
      							if($collectiondata['homepage_element_8_ten_one_down_style_target']==$targetarrkey)
      							{
      								$str = $str . '<option value='.$targetarrkey.' selected>'.$targetarrvalue.'</option>';
      							}
      							else
      							{
      								$str = $str . '<option value='.$targetarrkey.'>'.$targetarrvalue.'</option>';
      							}
      						}
      						$str = $str . '</select>';
      						$str = $str . '</td>';
      						$str = $str . '</tr>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_ten_one_down_style_image">Image:</label></td>';
      						//$str = $str . '<td class="value"><div id="buttonshomepage_element_8_ten_one_down_style_image" class="buttons-set"><button type="button" class="scalable show-hide" style="" id="togglehomepage_element_8_ten_one_down_style_image"><span><span><span>Show / Hide Editor</span></span></span></button><button type="button" class="scalable add-widget plugin" onclick="widgetTools.openDialog('.$baseurl.'evolved/widget/index/widget_target_id/homepage_element_8_ten_one_down_style_image)" style=""><span><span><span>Insert Widget...</span></span></span></button><button type="button" class="scalable add-image plugin" onclick="MediabrowserUtility.openDialog('.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_8_ten_one_down_style_image/)" style=""><span><span><span>Insert Image...</span></span></span></button><button type="button" class="scalable add-variable plugin" onclick="MagentovariablePlugin.loadChooser('.$baseurl.'evolved/system_variable/wysiwygPlugin/, homepage_element_8_ten_one_down_style_image);"><span><span><span>Insert Variable...</span></span></span></button></div><textarea name="homepage_element_8_ten_one_down_style_image" title="" id="homepage_element_8_ten_one_down_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_8_ten_one_down_style_image'].'</textarea><small>Image size must be 1920*480 pixels</small></td>';
      						$str = $str . '<td class="value"><button id="togglehomepage_element_8_ten_one_down_style_image" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><div id="buttonshomepage_element_8_ten_one_down_style_image" class="buttons-set"><button style="" onclick="MediabrowserUtility.openDialog(\''.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_8_ten_one_down_style_image/\')" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button></div><textarea name="homepage_element_8_33_percentage_346_by_346_three_boxes_leftright_updown_width[homepage_element_8_ten_one_down_style_image]" title="" id="homepage_element_8_ten_one_down_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_8_ten_one_down_style_image'].'</textarea><small>Image size must be 346*170 pixels</small></td>';
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
      						$str = $str . '}wysiwyghomepage_element_8_ten_one_down_style_image = new tinyMceWysiwygSetup("homepage_element_8_ten_one_down_style_image", {"enabled":true,"hidden":true,"use_container":false,"add_variables":true,"add_widgets":true,"add_images":true,"no_display":false,"translator":{},"encode_directives":true,"directives_url":"'.$baseurl.'evolved/cms_wysiwyg/directive/","popup_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/dialog.css","content_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/content.css","width":"100%","plugins":[{"name":"magentovariable","src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentovariable/editor_plugin.js","options":{"title":"Insert Variable...","url":"'.$baseurl.'evolved/system_variable/wysiwygPlugin/","onclick":{"search":["html_id"],"subject":"MagentovariablePlugin.loadChooser(\''.$baseurl.'evolved/system_variable/wysiwygPlugin/\', \'{{html_id}}\');"},"class":"add-variable plugin"}}],"directives_url_quoted":"'.$baseurl.'evolved/cms_wysiwyg/directive/","files_browser_window_url":"'.$baseurl.'idealAdmin/cms_wysiwyg_images/index/","files_browser_window_width":1000,"files_browser_window_height":600,"widget_plugin_src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentowidget/editor_plugin.js","widget_images_url":"'.$siteurl.'skin/adminhtml/default/default/images/widget/","widget_placeholders":["Thumbs.db","catalog__category_widget_link.gif","catalog__product_widget_link.gif","catalog__product_widget_new.gif","cms__widget_block.gif","cms__widget_page_link.gif","default.gif","reports__product_widget_compared.gif","reports__product_widget_viewed.gif"],"widget_window_url":"'.$baseurl.'evolved/widget/index/","firebug_warning_title":"Warning","firebug_warning_text":"Firebug is known to make the WYSIWYG editor slow unless it is turned off or configured properly.","firebug_warning_anchor":"Hide"});';
      						$str = $str . 'editorFormValidationHandler = wysiwyghomepage_element_8_ten_one_down_style_image.onFormValidation.bind(wysiwyghomepage_element_8_ten_one_down_style_image);';
      						$str = $str . 'Event.observe("togglehomepage_element_8_ten_one_down_style_image", "click", wysiwyghomepage_element_8_ten_one_down_style_image.toggle.bind(wysiwyghomepage_element_8_ten_one_down_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("formSubmit", editorFormValidationHandler);';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceBeforeSetContent", wysiwyghomepage_element_8_ten_one_down_style_image.beforeSetContent.bind(wysiwyghomepage_element_8_ten_one_down_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceSaveContent", wysiwyghomepage_element_8_ten_one_down_style_image.saveContent.bind(wysiwyghomepage_element_8_ten_one_down_style_image));';
      						$str = $str . 'varienGlobalEvents.clearEventHandlers("open_browser_callback");';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("open_browser_callback", wysiwyghomepage_element_8_ten_one_down_style_image.openFileBrowser.bind(wysiwyghomepage_element_8_ten_one_down_style_image));';
      						$str = $str . '</script>';
      						$str = $str . '</tr>';
      						$str = $str . '</tbody>';
      						$str = $str . '</table>'; 
      						$str = $str . '<table cellspacing="0" class="form-list allpageelement" style="display: table-cell;">';
							$str = $str . '<tbody>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_ten_two_style_title">Title:</label></td>';  
      						$str = $str . '<td class="value"><input id="homepage_element_8_ten_two_style_title" value="'.$collectiondata['homepage_element_8_ten_two_style_title'].'" name="homepage_element_8_33_percentage_346_by_346_three_boxes_leftright_updown_width[homepage_element_8_ten_two_style_title]"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str .	'<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_ten_two_style_link">Link:</label></td>';
      						$str = $str . '<td class="value"><input id="homepage_element_8_ten_two_style_link" value="'.$collectiondata['homepage_element_8_ten_two_style_link'].'" name="homepage_element_8_33_percentage_346_by_346_three_boxes_leftright_updown_width[homepage_element_8_ten_two_style_link]"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_ten_two_style_target">Target:</label></td>';
      						$str = $str . '<td class="value">';
      						$str = $str . '<select id="homepage_element_8_ten_two_style_target" name="homepage_element_8_33_percentage_346_by_346_three_boxes_leftright_updown_width[homepage_element_8_ten_two_style_target]" >';
      						foreach($targetarr as $targetarrkey => $targetarrvalue)
      						{
      							if($collectiondata['homepage_element_8_ten_two_style_target']==$targetarrkey)
      							{
      								$str = $str . '<option value='.$targetarrkey.' selected>'.$targetarrvalue.'</option>';
      							}
      							else
      							{
      								$str = $str . '<option value='.$targetarrkey.'>'.$targetarrvalue.'</option>';
      							}
      						}
      						$str = $str . '</select>';
      						$str = $str . '</td>';
      						$str = $str . '</tr>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_ten_two_style_image">Image:</label></td>';
      						//$str = $str . '<td class="value"><div id="buttonshomepage_element_8_ten_two_style_image" class="buttons-set"><button type="button" class="scalable show-hide" style="" id="togglehomepage_element_8_ten_two_style_image"><span><span><span>Show / Hide Editor</span></span></span></button><button type="button" class="scalable add-widget plugin" onclick="widgetTools.openDialog('.$baseurl.'evolved/widget/index/widget_target_id/homepage_element_8_ten_two_style_image)" style=""><span><span><span>Insert Widget...</span></span></span></button><button type="button" class="scalable add-image plugin" onclick="MediabrowserUtility.openDialog('.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_8_ten_two_style_image/)" style=""><span><span><span>Insert Image...</span></span></span></button><button type="button" class="scalable add-variable plugin" onclick="MagentovariablePlugin.loadChooser('.$baseurl.'evolved/system_variable/wysiwygPlugin/, homepage_element_8_ten_two_style_image);"><span><span><span>Insert Variable...</span></span></span></button></div><textarea name="homepage_element_8_ten_two_style_image" title="" id="homepage_element_8_ten_two_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_8_ten_two_style_image'].'</textarea><small>Image size must be 1920*480 pixels</small></td>';
      						$str = $str . '<td class="value"><button id="togglehomepage_element_8_ten_two_style_image" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><div id="buttonshomepage_element_8_ten_two_style_image" class="buttons-set"><button style="" onclick="MediabrowserUtility.openDialog(\''.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_8_ten_two_style_image/\')" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button></div><textarea name="homepage_element_8_33_percentage_346_by_346_three_boxes_leftright_updown_width[homepage_element_8_ten_two_style_image]" title="" id="homepage_element_8_ten_two_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_8_ten_two_style_image'].'</textarea><small>Image size must be 346*346 pixels</small></td>';
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
      						$str = $str . '}wysiwyghomepage_element_8_ten_two_style_image = new tinyMceWysiwygSetup("homepage_element_8_ten_two_style_image", {"enabled":true,"hidden":true,"use_container":false,"add_variables":true,"add_widgets":true,"add_images":true,"no_display":false,"translator":{},"encode_directives":true,"directives_url":"'.$baseurl.'evolved/cms_wysiwyg/directive/","popup_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/dialog.css","content_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/content.css","width":"100%","plugins":[{"name":"magentovariable","src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentovariable/editor_plugin.js","options":{"title":"Insert Variable...","url":"'.$baseurl.'evolved/system_variable/wysiwygPlugin/","onclick":{"search":["html_id"],"subject":"MagentovariablePlugin.loadChooser(\''.$baseurl.'evolved/system_variable/wysiwygPlugin/\', \'{{html_id}}\');"},"class":"add-variable plugin"}}],"directives_url_quoted":"'.$baseurl.'evolved/cms_wysiwyg/directive/","files_browser_window_url":"'.$baseurl.'idealAdmin/cms_wysiwyg_images/index/","files_browser_window_width":1000,"files_browser_window_height":600,"widget_plugin_src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentowidget/editor_plugin.js","widget_images_url":"'.$siteurl.'skin/adminhtml/default/default/images/widget/","widget_placeholders":["Thumbs.db","catalog__category_widget_link.gif","catalog__product_widget_link.gif","catalog__product_widget_new.gif","cms__widget_block.gif","cms__widget_page_link.gif","default.gif","reports__product_widget_compared.gif","reports__product_widget_viewed.gif"],"widget_window_url":"'.$baseurl.'evolved/widget/index/","firebug_warning_title":"Warning","firebug_warning_text":"Firebug is known to make the WYSIWYG editor slow unless it is turned off or configured properly.","firebug_warning_anchor":"Hide"});';
      						$str = $str . 'editorFormValidationHandler = wysiwyghomepage_element_8_ten_two_style_image.onFormValidation.bind(wysiwyghomepage_element_8_ten_two_style_image);';
      						$str = $str . 'Event.observe("togglehomepage_element_8_ten_two_style_image", "click", wysiwyghomepage_element_8_ten_two_style_image.toggle.bind(wysiwyghomepage_element_8_ten_two_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("formSubmit", editorFormValidationHandler);';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceBeforeSetContent", wysiwyghomepage_element_8_ten_two_style_image.beforeSetContent.bind(wysiwyghomepage_element_8_ten_two_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceSaveContent", wysiwyghomepage_element_8_ten_two_style_image.saveContent.bind(wysiwyghomepage_element_8_ten_two_style_image));';
      						$str = $str . 'varienGlobalEvents.clearEventHandlers("open_browser_callback");';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("open_browser_callback", wysiwyghomepage_element_8_ten_two_style_image.openFileBrowser.bind(wysiwyghomepage_element_8_ten_two_style_image));';
      						$str = $str . '</script>';
      						$str = $str . '</tr>';
      						$str = $str . '</tbody>';
      						$str = $str . '</table>';
      						$str = $str . '<table cellspacing="0" class="form-list allpageelement" style="display: table-cell;">';
							$str = $str . '<tbody>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_ten_three_up_style_title">Title:</label></td>';  
      						$str = $str . '<td class="value"><input id="homepage_element_8_ten_three_up_style_title" value="'.$collectiondata['homepage_element_8_ten_three_up_style_title'].'" name="homepage_element_8_33_percentage_346_by_346_three_boxes_leftright_updown_width[homepage_element_8_ten_three_up_style_title]"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str .	'<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_ten_three_up_style_link">Link:</label></td>';
      						$str = $str . '<td class="value"><input id="homepage_element_8_ten_three_up_style_link" value="'.$collectiondata['homepage_element_8_ten_three_up_style_link'].'" name="homepage_element_8_33_percentage_346_by_346_three_boxes_leftright_updown_width[homepage_element_8_ten_three_up_style_link]"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_ten_three_up_style_target">Target:</label></td>';
      						$str = $str . '<td class="value">';
      						$str = $str . '<select id="homepage_element_8_ten_three_up_style_target" name="homepage_element_8_33_percentage_346_by_346_three_boxes_leftright_updown_width[homepage_element_8_ten_three_up_style_target]" >';
      						foreach($targetarr as $targetarrkey => $targetarrvalue)
      						{
      							if($collectiondata['homepage_element_8_ten_three_up_style_target']==$targetarrkey)
      							{
      								$str = $str . '<option value='.$targetarrkey.' selected>'.$targetarrvalue.'</option>';
      							}
      							else
      							{
      								$str = $str . '<option value='.$targetarrkey.'>'.$targetarrvalue.'</option>';
      							}
      						}
      						$str = $str . '</select>';
      						$str = $str . '</td>';
      						$str = $str . '</tr>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_ten_three_up_style_image">Image:</label></td>';
      						//$str = $str . '<td class="value"><div id="buttonshomepage_element_8_ten_three_up_style_image" class="buttons-set"><button type="button" class="scalable show-hide" style="" id="togglehomepage_element_8_ten_three_up_style_image"><span><span><span>Show / Hide Editor</span></span></span></button><button type="button" class="scalable add-widget plugin" onclick="widgetTools.openDialog('.$baseurl.'evolved/widget/index/widget_target_id/homepage_element_8_ten_three_up_style_image)" style=""><span><span><span>Insert Widget...</span></span></span></button><button type="button" class="scalable add-image plugin" onclick="MediabrowserUtility.openDialog('.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_8_ten_three_up_style_image/)" style=""><span><span><span>Insert Image...</span></span></span></button><button type="button" class="scalable add-variable plugin" onclick="MagentovariablePlugin.loadChooser('.$baseurl.'evolved/system_variable/wysiwygPlugin/, homepage_element_8_ten_three_up_style_image);"><span><span><span>Insert Variable...</span></span></span></button></div><textarea name="homepage_element_8_ten_three_up_style_image" title="" id="homepage_element_8_ten_three_up_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_8_ten_three_up_style_image'].'</textarea><small>Image size must be 1920*480 pixels</small></td>';
      						$str = $str . '<td class="value"><button id="togglehomepage_element_8_ten_three_up_style_image" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><div id="buttonshomepage_element_8_ten_three_up_style_image" class="buttons-set"><button style="" onclick="MediabrowserUtility.openDialog(\''.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_8_ten_three_up_style_image/\')" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button></div><textarea name="homepage_element_8_33_percentage_346_by_346_three_boxes_leftright_updown_width[homepage_element_8_ten_three_up_style_image]" title="" id="homepage_element_8_ten_three_up_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_8_ten_three_up_style_image'].'</textarea><small>Image size must be 346*170 pixels</small></td>';
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
      						$str = $str . '}wysiwyghomepage_element_8_ten_three_up_style_image = new tinyMceWysiwygSetup("homepage_element_8_ten_three_up_style_image", {"enabled":true,"hidden":true,"use_container":false,"add_variables":true,"add_widgets":true,"add_images":true,"no_display":false,"translator":{},"encode_directives":true,"directives_url":"'.$baseurl.'evolved/cms_wysiwyg/directive/","popup_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/dialog.css","content_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/content.css","width":"100%","plugins":[{"name":"magentovariable","src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentovariable/editor_plugin.js","options":{"title":"Insert Variable...","url":"'.$baseurl.'evolved/system_variable/wysiwygPlugin/","onclick":{"search":["html_id"],"subject":"MagentovariablePlugin.loadChooser(\''.$baseurl.'evolved/system_variable/wysiwygPlugin/\', \'{{html_id}}\');"},"class":"add-variable plugin"}}],"directives_url_quoted":"'.$baseurl.'evolved/cms_wysiwyg/directive/","files_browser_window_url":"'.$baseurl.'idealAdmin/cms_wysiwyg_images/index/","files_browser_window_width":1000,"files_browser_window_height":600,"widget_plugin_src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentowidget/editor_plugin.js","widget_images_url":"'.$siteurl.'skin/adminhtml/default/default/images/widget/","widget_placeholders":["Thumbs.db","catalog__category_widget_link.gif","catalog__product_widget_link.gif","catalog__product_widget_new.gif","cms__widget_block.gif","cms__widget_page_link.gif","default.gif","reports__product_widget_compared.gif","reports__product_widget_viewed.gif"],"widget_window_url":"'.$baseurl.'evolved/widget/index/","firebug_warning_title":"Warning","firebug_warning_text":"Firebug is known to make the WYSIWYG editor slow unless it is turned off or configured properly.","firebug_warning_anchor":"Hide"});';
      						$str = $str . 'editorFormValidationHandler = wysiwyghomepage_element_8_ten_three_up_style_image.onFormValidation.bind(wysiwyghomepage_element_8_ten_three_up_style_image);';
      						$str = $str . 'Event.observe("togglehomepage_element_8_ten_three_up_style_image", "click", wysiwyghomepage_element_8_ten_three_up_style_image.toggle.bind(wysiwyghomepage_element_8_ten_three_up_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("formSubmit", editorFormValidationHandler);';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceBeforeSetContent", wysiwyghomepage_element_8_ten_three_up_style_image.beforeSetContent.bind(wysiwyghomepage_element_8_ten_three_up_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceSaveContent", wysiwyghomepage_element_8_ten_three_up_style_image.saveContent.bind(wysiwyghomepage_element_8_ten_three_up_style_image));';
      						$str = $str . 'varienGlobalEvents.clearEventHandlers("open_browser_callback");';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("open_browser_callback", wysiwyghomepage_element_8_ten_three_up_style_image.openFileBrowser.bind(wysiwyghomepage_element_8_ten_three_up_style_image));';
      						$str = $str . '</script>';
      						$str = $str . '</tr>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_ten_three_down_style_title">Title:</label></td>';  
      						$str = $str . '<td class="value"><input id="homepage_element_8_ten_three_down_style_title" value="'.$collectiondata['homepage_element_8_ten_three_down_style_title'].'" name="homepage_element_8_33_percentage_346_by_346_three_boxes_leftright_updown_width[homepage_element_8_ten_three_down_style_title]"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str .	'<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_ten_three_down_style_link">Link:</label></td>';
      						$str = $str . '<td class="value"><input id="homepage_element_8_ten_three_down_style_link" value="'.$collectiondata['homepage_element_8_ten_three_down_style_link'].'" name="homepage_element_8_33_percentage_346_by_346_three_boxes_leftright_updown_width[homepage_element_8_ten_three_down_style_link]"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_ten_three_down_style_target">Target:</label></td>';
      						$str = $str . '<td class="value">';
      						$str = $str . '<select id="homepage_element_8_ten_three_down_style_target" name="homepage_element_8_33_percentage_346_by_346_three_boxes_leftright_updown_width[homepage_element_8_ten_three_down_style_target]" >';
      						foreach($targetarr as $targetarrkey => $targetarrvalue)
      						{
      							if($collectiondata['homepage_element_8_ten_three_down_style_target']==$targetarrkey)
      							{
      								$str = $str . '<option value='.$targetarrkey.' selected>'.$targetarrvalue.'</option>';
      							}
      							else
      							{
      								$str = $str . '<option value='.$targetarrkey.'>'.$targetarrvalue.'</option>';
      							}
      						}
      						$str = $str . '</select>';
      						$str = $str . '</td>';
      						$str = $str . '</tr>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_ten_three_down_style_image">Image:</label></td>';
      						//$str = $str . '<td class="value"><div id="buttonshomepage_element_8_ten_three_down_style_image" class="buttons-set"><button type="button" class="scalable show-hide" style="" id="togglehomepage_element_8_ten_three_down_style_image"><span><span><span>Show / Hide Editor</span></span></span></button><button type="button" class="scalable add-widget plugin" onclick="widgetTools.openDialog('.$baseurl.'evolved/widget/index/widget_target_id/homepage_element_8_ten_three_down_style_image)" style=""><span><span><span>Insert Widget...</span></span></span></button><button type="button" class="scalable add-image plugin" onclick="MediabrowserUtility.openDialog('.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_8_ten_three_down_style_image/)" style=""><span><span><span>Insert Image...</span></span></span></button><button type="button" class="scalable add-variable plugin" onclick="MagentovariablePlugin.loadChooser('.$baseurl.'evolved/system_variable/wysiwygPlugin/, homepage_element_8_ten_three_down_style_image);"><span><span><span>Insert Variable...</span></span></span></button></div><textarea name="homepage_element_8_ten_three_down_style_image" title="" id="homepage_element_8_ten_three_down_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_8_ten_three_down_style_image'].'</textarea><small>Image size must be 1920*480 pixels</small></td>';
      						$str = $str . '<td class="value"><button id="togglehomepage_element_8_ten_three_down_style_image" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><div id="buttonshomepage_element_8_ten_three_down_style_image" class="buttons-set"><button style="" onclick="MediabrowserUtility.openDialog(\''.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_8_ten_three_down_style_image/\')" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button></div><textarea name="homepage_element_8_33_percentage_346_by_346_three_boxes_leftright_updown_width[homepage_element_8_ten_three_down_style_image]" title="" id="homepage_element_8_ten_three_down_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_8_ten_three_down_style_image'].'</textarea><small>Image size must be 346*170 pixels</small></td>';
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
      						$str = $str . '}wysiwyghomepage_element_8_ten_three_down_style_image = new tinyMceWysiwygSetup("homepage_element_8_ten_three_down_style_image", {"enabled":true,"hidden":true,"use_container":false,"add_variables":true,"add_widgets":true,"add_images":true,"no_display":false,"translator":{},"encode_directives":true,"directives_url":"'.$baseurl.'evolved/cms_wysiwyg/directive/","popup_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/dialog.css","content_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/content.css","width":"100%","plugins":[{"name":"magentovariable","src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentovariable/editor_plugin.js","options":{"title":"Insert Variable...","url":"'.$baseurl.'evolved/system_variable/wysiwygPlugin/","onclick":{"search":["html_id"],"subject":"MagentovariablePlugin.loadChooser(\''.$baseurl.'evolved/system_variable/wysiwygPlugin/\', \'{{html_id}}\');"},"class":"add-variable plugin"}}],"directives_url_quoted":"'.$baseurl.'evolved/cms_wysiwyg/directive/","files_browser_window_url":"'.$baseurl.'idealAdmin/cms_wysiwyg_images/index/","files_browser_window_width":1000,"files_browser_window_height":600,"widget_plugin_src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentowidget/editor_plugin.js","widget_images_url":"'.$siteurl.'skin/adminhtml/default/default/images/widget/","widget_placeholders":["Thumbs.db","catalog__category_widget_link.gif","catalog__product_widget_link.gif","catalog__product_widget_new.gif","cms__widget_block.gif","cms__widget_page_link.gif","default.gif","reports__product_widget_compared.gif","reports__product_widget_viewed.gif"],"widget_window_url":"'.$baseurl.'evolved/widget/index/","firebug_warning_title":"Warning","firebug_warning_text":"Firebug is known to make the WYSIWYG editor slow unless it is turned off or configured properly.","firebug_warning_anchor":"Hide"});';
      						$str = $str . 'editorFormValidationHandler = wysiwyghomepage_element_8_ten_three_down_style_image.onFormValidation.bind(wysiwyghomepage_element_8_ten_three_down_style_image);';
      						$str = $str . 'Event.observe("togglehomepage_element_8_ten_three_down_style_image", "click", wysiwyghomepage_element_8_ten_three_down_style_image.toggle.bind(wysiwyghomepage_element_8_ten_three_down_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("formSubmit", editorFormValidationHandler);';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceBeforeSetContent", wysiwyghomepage_element_8_ten_three_down_style_image.beforeSetContent.bind(wysiwyghomepage_element_8_ten_three_down_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceSaveContent", wysiwyghomepage_element_8_ten_three_down_style_image.saveContent.bind(wysiwyghomepage_element_8_ten_three_down_style_image));';
      						$str = $str . 'varienGlobalEvents.clearEventHandlers("open_browser_callback");';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("open_browser_callback", wysiwyghomepage_element_8_ten_three_down_style_image.openFileBrowser.bind(wysiwyghomepage_element_8_ten_three_down_style_image));';
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
      						if($selectElement == 'homepage_element_8_50_percentage_522_by_170_two_boxes_width')
      						{
      							$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="homepage_element_8_50_percentage_522_by_170_two_boxes_width" style="display: block">';
      						}
      						else
      						{
      							$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="homepage_element_8_50_percentage_522_by_170_two_boxes_width"  style="display: none">';
      						}
      						//$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="50_percentage_522_by_170_two_boxes_width">';
      						$str = $str . '<tbody>';
      						$str = $str . '<tr>';
      						$str = $str . '<td>';
      						$str = $str . '<table cellspacing="0" class="form-list allpageelement" style="display: table-cell;">';
							$str = $str . '<tbody>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_eleven_one_style_title">Title:</label></td>';  
      						$str = $str . '<td class="value"><input id="homepage_element_8_eleven_one_style_title" value="'.$collectiondata['homepage_element_8_eleven_one_style_title'].'" name="homepage_element_8_50_percentage_522_by_170_two_boxes_width[homepage_element_8_eleven_one_style_title]"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str .	'<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_eleven_one_style_link">Link:</label></td>';
      						$str = $str . '<td class="value"><input id="homepage_element_8_eleven_one_style_link" value="'.$collectiondata['homepage_element_8_eleven_one_style_link'].'" name="homepage_element_8_50_percentage_522_by_170_two_boxes_width[homepage_element_8_eleven_one_style_link]"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_eleven_one_style_target">Target:</label></td>';
      						$str = $str . '<td class="value">';
      						$str = $str . '<select id="homepage_element_8_eleven_one_style_target" name="homepage_element_8_50_percentage_522_by_170_two_boxes_width[homepage_element_8_eleven_one_style_target]" >';
      						foreach($targetarr as $targetarrkey => $targetarrvalue)
      						{
      							if($collectiondata['homepage_element_8_eleven_one_style_target']==$targetarrkey)
      							{
      								$str = $str . '<option value='.$targetarrkey.' selected>'.$targetarrvalue.'</option>';
      							}
      							else
      							{
      								$str = $str . '<option value='.$targetarrkey.'>'.$targetarrvalue.'</option>';
      							}
      						}
      						$str = $str . '</select>';
      						$str = $str . '</td>';
      						$str = $str . '</tr>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_eleven_one_style_image">Image:</label></td>';
      						//$str = $str . '<td class="value"><div id="buttonshomepage_element_8_eleven_one_style_image" class="buttons-set"><button type="button" class="scalable show-hide" style="" id="togglehomepage_element_8_eleven_one_style_image"><span><span><span>Show / Hide Editor</span></span></span></button><button type="button" class="scalable add-widget plugin" onclick="widgetTools.openDialog('.$baseurl.'evolved/widget/index/widget_target_id/homepage_element_8_eleven_one_style_image)" style=""><span><span><span>Insert Widget...</span></span></span></button><button type="button" class="scalable add-image plugin" onclick="MediabrowserUtility.openDialog('.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_8_eleven_one_style_image/)" style=""><span><span><span>Insert Image...</span></span></span></button><button type="button" class="scalable add-variable plugin" onclick="MagentovariablePlugin.loadChooser('.$baseurl.'evolved/system_variable/wysiwygPlugin/, homepage_element_8_eleven_one_style_image);"><span><span><span>Insert Variable...</span></span></span></button></div><textarea name="homepage_element_8_eleven_one_style_image" title="" id="homepage_element_8_eleven_one_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_8_eleven_one_style_image'].'</textarea><small>Image size must be 1920*480 pixels</small></td>';
      						$str = $str . '<td class="value"><button id="togglehomepage_element_8_eleven_one_style_image" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><div id="buttonshomepage_element_8_eleven_one_style_image" class="buttons-set"><button style="" onclick="MediabrowserUtility.openDialog(\''.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_8_eleven_one_style_image/\')" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button></div><textarea name="homepage_element_8_50_percentage_522_by_170_two_boxes_width[homepage_element_8_eleven_one_style_image]" title="" id="homepage_element_8_eleven_one_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_8_eleven_one_style_image'].'</textarea><small>Image size must be 522*170 pixels</small></td>';
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
      						$str = $str . '}wysiwyghomepage_element_8_eleven_one_style_image = new tinyMceWysiwygSetup("homepage_element_8_eleven_one_style_image", {"enabled":true,"hidden":true,"use_container":false,"add_variables":true,"add_widgets":true,"add_images":true,"no_display":false,"translator":{},"encode_directives":true,"directives_url":"'.$baseurl.'evolved/cms_wysiwyg/directive/","popup_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/dialog.css","content_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/content.css","width":"100%","plugins":[{"name":"magentovariable","src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentovariable/editor_plugin.js","options":{"title":"Insert Variable...","url":"'.$baseurl.'evolved/system_variable/wysiwygPlugin/","onclick":{"search":["html_id"],"subject":"MagentovariablePlugin.loadChooser(\''.$baseurl.'evolved/system_variable/wysiwygPlugin/\', \'{{html_id}}\');"},"class":"add-variable plugin"}}],"directives_url_quoted":"'.$baseurl.'evolved/cms_wysiwyg/directive/","files_browser_window_url":"'.$baseurl.'idealAdmin/cms_wysiwyg_images/index/","files_browser_window_width":1000,"files_browser_window_height":600,"widget_plugin_src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentowidget/editor_plugin.js","widget_images_url":"'.$siteurl.'skin/adminhtml/default/default/images/widget/","widget_placeholders":["Thumbs.db","catalog__category_widget_link.gif","catalog__product_widget_link.gif","catalog__product_widget_new.gif","cms__widget_block.gif","cms__widget_page_link.gif","default.gif","reports__product_widget_compared.gif","reports__product_widget_viewed.gif"],"widget_window_url":"'.$baseurl.'evolved/widget/index/","firebug_warning_title":"Warning","firebug_warning_text":"Firebug is known to make the WYSIWYG editor slow unless it is turned off or configured properly.","firebug_warning_anchor":"Hide"});';
      						$str = $str . 'editorFormValidationHandler = wysiwyghomepage_element_8_eleven_one_style_image.onFormValidation.bind(wysiwyghomepage_element_8_eleven_one_style_image);';
      						$str = $str . 'Event.observe("togglehomepage_element_8_eleven_one_style_image", "click", wysiwyghomepage_element_8_eleven_one_style_image.toggle.bind(wysiwyghomepage_element_8_eleven_one_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("formSubmit", editorFormValidationHandler);';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceBeforeSetContent", wysiwyghomepage_element_8_eleven_one_style_image.beforeSetContent.bind(wysiwyghomepage_element_8_eleven_one_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceSaveContent", wysiwyghomepage_element_8_eleven_one_style_image.saveContent.bind(wysiwyghomepage_element_8_eleven_one_style_image));';
      						$str = $str . 'varienGlobalEvents.clearEventHandlers("open_browser_callback");';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("open_browser_callback", wysiwyghomepage_element_8_eleven_one_style_image.openFileBrowser.bind(wysiwyghomepage_element_8_eleven_one_style_image));';
      						$str = $str . '</script>';
      						$str = $str . '</tr>';
      						$str = $str . '</tbody>';
      						$str = $str . '</table>'; 
      						$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelement" style="display: table-cell;">';
							$str = $str . '<tbody>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_eleven_two_style_title">Title:</label></td>';  
      						$str = $str . '<td class="value"><input id="homepage_element_8_eleven_two_style_title" value="'.$collectiondata['homepage_element_8_eleven_two_style_title'].'" name="homepage_element_8_50_percentage_522_by_170_two_boxes_width[homepage_element_8_eleven_two_style_title]"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str .	'<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_eleven_two_style_link">Link:</label></td>';
      						$str = $str . '<td class="value"><input id="homepage_element_8_eleven_two_style_link" value="'.$collectiondata['homepage_element_8_eleven_two_style_link'].'" name="homepage_element_8_50_percentage_522_by_170_two_boxes_width[homepage_element_8_eleven_two_style_link]"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_eleven_two_style_target">Target:</label></td>';
      						$str = $str . '<td class="value">';
      						$str = $str . '<select id="homepage_element_8_eleven_two_style_target" name="homepage_element_8_50_percentage_522_by_170_two_boxes_width[homepage_element_8_eleven_two_style_target]" >';
      						foreach($targetarr as $targetarrkey => $targetarrvalue)
      						{
      							if($collectiondata['homepage_element_8_eleven_two_style_target']==$targetarrkey)
      							{
      								$str = $str . '<option value='.$targetarrkey.' selected>'.$targetarrvalue.'</option>';
      							}
      							else
      							{
      								$str = $str . '<option value='.$targetarrkey.'>'.$targetarrvalue.'</option>';
      							}
      						}
      						$str = $str . '</select>';
      						$str = $str . '</td>';
      						$str = $str . '</tr>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_eleven_two_style_image">Image:</label></td>';
      						//$str = $str . '<td class="value"><div id="buttonshomepage_element_8_eleven_two_style_image" class="buttons-set"><button type="button" class="scalable show-hide" style="" id="togglehomepage_element_8_eleven_two_style_image"><span><span><span>Show / Hide Editor</span></span></span></button><button type="button" class="scalable add-widget plugin" onclick="widgetTools.openDialog('.$baseurl.'evolved/widget/index/widget_target_id/homepage_element_8_eleven_two_style_image)" style=""><span><span><span>Insert Widget...</span></span></span></button><button type="button" class="scalable add-image plugin" onclick="MediabrowserUtility.openDialog('.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_8_eleven_two_style_image/)" style=""><span><span><span>Insert Image...</span></span></span></button><button type="button" class="scalable add-variable plugin" onclick="MagentovariablePlugin.loadChooser('.$baseurl.'evolved/system_variable/wysiwygPlugin/, homepage_element_8_eleven_two_style_image);"><span><span><span>Insert Variable...</span></span></span></button></div><textarea name="homepage_element_8_eleven_two_style_image" title="" id="homepage_element_8_eleven_two_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_8_eleven_two_style_image'].'</textarea><small>Image size must be 1920*480 pixels</small></td>';
      						$str = $str . '<td class="value"><button id="togglehomepage_element_8_eleven_two_style_image" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><div id="buttonshomepage_element_8_eleven_two_style_image" class="buttons-set"><button style="" onclick="MediabrowserUtility.openDialog(\''.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_8_eleven_two_style_image/\')" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button></div><textarea name="homepage_element_8_50_percentage_522_by_170_two_boxes_width[homepage_element_8_eleven_two_style_image]" title="" id="homepage_element_8_eleven_two_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_8_eleven_two_style_image'].'</textarea><small>Image size must be 522*170 pixels</small></td>';
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
      						$str = $str . '}wysiwyghomepage_element_8_eleven_two_style_image = new tinyMceWysiwygSetup("homepage_element_8_eleven_two_style_image", {"enabled":true,"hidden":true,"use_container":false,"add_variables":true,"add_widgets":true,"add_images":true,"no_display":false,"translator":{},"encode_directives":true,"directives_url":"'.$baseurl.'evolved/cms_wysiwyg/directive/","popup_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/dialog.css","content_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/content.css","width":"100%","plugins":[{"name":"magentovariable","src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentovariable/editor_plugin.js","options":{"title":"Insert Variable...","url":"'.$baseurl.'evolved/system_variable/wysiwygPlugin/","onclick":{"search":["html_id"],"subject":"MagentovariablePlugin.loadChooser(\''.$baseurl.'evolved/system_variable/wysiwygPlugin/\', \'{{html_id}}\');"},"class":"add-variable plugin"}}],"directives_url_quoted":"'.$baseurl.'evolved/cms_wysiwyg/directive/","files_browser_window_url":"'.$baseurl.'idealAdmin/cms_wysiwyg_images/index/","files_browser_window_width":1000,"files_browser_window_height":600,"widget_plugin_src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentowidget/editor_plugin.js","widget_images_url":"'.$siteurl.'skin/adminhtml/default/default/images/widget/","widget_placeholders":["Thumbs.db","catalog__category_widget_link.gif","catalog__product_widget_link.gif","catalog__product_widget_new.gif","cms__widget_block.gif","cms__widget_page_link.gif","default.gif","reports__product_widget_compared.gif","reports__product_widget_viewed.gif"],"widget_window_url":"'.$baseurl.'evolved/widget/index/","firebug_warning_title":"Warning","firebug_warning_text":"Firebug is known to make the WYSIWYG editor slow unless it is turned off or configured properly.","firebug_warning_anchor":"Hide"});';
      						$str = $str . 'editorFormValidationHandler = wysiwyghomepage_element_8_eleven_two_style_image.onFormValidation.bind(wysiwyghomepage_element_8_eleven_two_style_image);';
      						$str = $str . 'Event.observe("togglehomepage_element_8_eleven_two_style_image", "click", wysiwyghomepage_element_8_eleven_two_style_image.toggle.bind(wysiwyghomepage_element_8_eleven_two_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("formSubmit", editorFormValidationHandler);';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceBeforeSetContent", wysiwyghomepage_element_8_eleven_two_style_image.beforeSetContent.bind(wysiwyghomepage_element_8_eleven_two_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceSaveContent", wysiwyghomepage_element_8_eleven_two_style_image.saveContent.bind(wysiwyghomepage_element_8_eleven_two_style_image));';
      						$str = $str . 'varienGlobalEvents.clearEventHandlers("open_browser_callback");';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("open_browser_callback", wysiwyghomepage_element_8_eleven_two_style_image.openFileBrowser.bind(wysiwyghomepage_element_8_eleven_two_style_image));';
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
      						if($selectElement == 'homepage_element_8_50_percentage_522_by_346_two_boxes_width')
      						{
      							$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="homepage_element_8_50_percentage_522_by_346_two_boxes_width" style="display: block">';
      						}
      						else
      						{
      							$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="homepage_element_8_50_percentage_522_by_346_two_boxes_width"  style="display: none">';
      						}
      						//$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="50_percentage_522_by_346_two_boxes_width">';
      						$str = $str . '<tbody>';
      						$str = $str . '<tr>';
      						$str = $str . '<td>';
      						$str = $str . '<table cellspacing="0" class="form-list allpageelement" style="display: table-cell;">';
							$str = $str . '<tbody>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_twelve_one_style_title">Title:</label></td>';  
      						$str = $str . '<td class="value"><input id="homepage_element_8_twelve_one_style_title" value="'.$collectiondata['homepage_element_8_twelve_one_style_title'].'" name="homepage_element_8_50_percentage_522_by_346_two_boxes_width[homepage_element_8_twelve_one_style_title]"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str .	'<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_twelve_one_style_link">Link:</label></td>';
      						$str = $str . '<td class="value"><input id="homepage_element_8_twelve_one_style_link" value="'.$collectiondata['homepage_element_8_twelve_one_style_link'].'" name="homepage_element_8_50_percentage_522_by_346_two_boxes_width[homepage_element_8_twelve_one_style_link]"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_twelve_one_style_target">Target:</label></td>';
      						$str = $str . '<td class="value">';
      						$str = $str . '<select id="homepage_element_8_twelve_one_style_target" name="homepage_element_8_50_percentage_522_by_346_two_boxes_width[homepage_element_8_twelve_one_style_target]" >';
      						foreach($targetarr as $targetarrkey => $targetarrvalue)
      						{
      							if($collectiondata['homepage_element_8_twelve_one_style_target']==$targetarrkey)
      							{
      								$str = $str . '<option value='.$targetarrkey.' selected>'.$targetarrvalue.'</option>';
      							}
      							else
      							{
      								$str = $str . '<option value='.$targetarrkey.'>'.$targetarrvalue.'</option>';
      							}
      						}
      						$str = $str . '</select>';
      						$str = $str . '</td>';
      						$str = $str . '</tr>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_twelve_one_style_image">Image:</label></td>';
      						//$str = $str . '<td class="value"><div id="buttonshomepage_element_8_twelve_one_style_image" class="buttons-set"><button type="button" class="scalable show-hide" style="" id="togglehomepage_element_8_twelve_one_style_image"><span><span><span>Show / Hide Editor</span></span></span></button><button type="button" class="scalable add-widget plugin" onclick="widgetTools.openDialog('.$baseurl.'evolved/widget/index/widget_target_id/homepage_element_8_twelve_one_style_image)" style=""><span><span><span>Insert Widget...</span></span></span></button><button type="button" class="scalable add-image plugin" onclick="MediabrowserUtility.openDialog('.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_8_twelve_one_style_image/)" style=""><span><span><span>Insert Image...</span></span></span></button><button type="button" class="scalable add-variable plugin" onclick="MagentovariablePlugin.loadChooser('.$baseurl.'evolved/system_variable/wysiwygPlugin/, homepage_element_8_twelve_one_style_image);"><span><span><span>Insert Variable...</span></span></span></button></div><textarea name="homepage_element_8_twelve_one_style_image" title="" id="homepage_element_8_twelve_one_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_8_twelve_one_style_image'].'</textarea><small>Image size must be 1920*480 pixels</small></td>';
      						$str = $str . '<td class="value"><button id="togglehomepage_element_8_twelve_one_style_image" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><div id="buttonshomepage_element_8_twelve_one_style_image" class="buttons-set"><button style="" onclick="MediabrowserUtility.openDialog(\''.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_8_twelve_one_style_image/\')" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button></div><textarea name="homepage_element_8_50_percentage_522_by_346_two_boxes_width[homepage_element_8_twelve_one_style_image]" title="" id="homepage_element_8_twelve_one_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_8_twelve_one_style_image'].'</textarea><small>Image size must be 522*346 pixels</small></td>';
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
      						$str = $str . '}wysiwyghomepage_element_8_twelve_one_style_image = new tinyMceWysiwygSetup("homepage_element_8_twelve_one_style_image", {"enabled":true,"hidden":true,"use_container":false,"add_variables":true,"add_widgets":true,"add_images":true,"no_display":false,"translator":{},"encode_directives":true,"directives_url":"'.$baseurl.'evolved/cms_wysiwyg/directive/","popup_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/dialog.css","content_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/content.css","width":"100%","plugins":[{"name":"magentovariable","src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentovariable/editor_plugin.js","options":{"title":"Insert Variable...","url":"'.$baseurl.'evolved/system_variable/wysiwygPlugin/","onclick":{"search":["html_id"],"subject":"MagentovariablePlugin.loadChooser(\''.$baseurl.'evolved/system_variable/wysiwygPlugin/\', \'{{html_id}}\');"},"class":"add-variable plugin"}}],"directives_url_quoted":"'.$baseurl.'evolved/cms_wysiwyg/directive/","files_browser_window_url":"'.$baseurl.'idealAdmin/cms_wysiwyg_images/index/","files_browser_window_width":1000,"files_browser_window_height":600,"widget_plugin_src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentowidget/editor_plugin.js","widget_images_url":"'.$siteurl.'skin/adminhtml/default/default/images/widget/","widget_placeholders":["Thumbs.db","catalog__category_widget_link.gif","catalog__product_widget_link.gif","catalog__product_widget_new.gif","cms__widget_block.gif","cms__widget_page_link.gif","default.gif","reports__product_widget_compared.gif","reports__product_widget_viewed.gif"],"widget_window_url":"'.$baseurl.'evolved/widget/index/","firebug_warning_title":"Warning","firebug_warning_text":"Firebug is known to make the WYSIWYG editor slow unless it is turned off or configured properly.","firebug_warning_anchor":"Hide"});';
      						$str = $str . 'editorFormValidationHandler = wysiwyghomepage_element_8_twelve_one_style_image.onFormValidation.bind(wysiwyghomepage_element_8_twelve_one_style_image);';
      						$str = $str . 'Event.observe("togglehomepage_element_8_twelve_one_style_image", "click", wysiwyghomepage_element_8_twelve_one_style_image.toggle.bind(wysiwyghomepage_element_8_twelve_one_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("formSubmit", editorFormValidationHandler);';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceBeforeSetContent", wysiwyghomepage_element_8_twelve_one_style_image.beforeSetContent.bind(wysiwyghomepage_element_8_twelve_one_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceSaveContent", wysiwyghomepage_element_8_twelve_one_style_image.saveContent.bind(wysiwyghomepage_element_8_twelve_one_style_image));';
      						$str = $str . 'varienGlobalEvents.clearEventHandlers("open_browser_callback");';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("open_browser_callback", wysiwyghomepage_element_8_twelve_one_style_image.openFileBrowser.bind(wysiwyghomepage_element_8_twelve_one_style_image));';
      						$str = $str . '</script>';
      						$str = $str . '</tr>';
      						$str = $str . '</tbody>';
      						$str = $str . '</table>'; 
      						$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelement" style="display: table-cell;">';
							$str = $str . '<tbody>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_twelve_two_style_title">Title:</label></td>';  
      						$str = $str . '<td class="value"><input id="homepage_element_8_twelve_two_style_title" value="'.$collectiondata['homepage_element_8_twelve_two_style_title'].'" name="homepage_element_8_50_percentage_522_by_346_two_boxes_width[homepage_element_8_twelve_two_style_title]"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str .	'<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_twelve_two_style_link">Link:</label></td>';
      						$str = $str . '<td class="value"><input id="homepage_element_8_twelve_two_style_link" value="'.$collectiondata['homepage_element_8_twelve_two_style_link'].'" name="homepage_element_8_50_percentage_522_by_346_two_boxes_width[homepage_element_8_twelve_two_style_link]"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_twelve_two_style_target">Target:</label></td>';
      						$str = $str . '<td class="value">';
      						$str = $str . '<select id="homepage_element_8_twelve_two_style_target" name="homepage_element_8_50_percentage_522_by_346_two_boxes_width[homepage_element_8_twelve_two_style_target]" >';
      						foreach($targetarr as $targetarrkey => $targetarrvalue)
      						{
      							if($collectiondata['homepage_element_8_twelve_two_style_target']==$targetarrkey)
      							{
      								$str = $str . '<option value='.$targetarrkey.' selected>'.$targetarrvalue.'</option>';
      							}
      							else
      							{
      								$str = $str . '<option value='.$targetarrkey.'>'.$targetarrvalue.'</option>';
      							}
      						}
      						$str = $str . '</select>';
      						$str = $str . '</td>';
      						$str = $str . '</tr>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_twelve_two_style_image">Image:</label></td>';
      						//$str = $str . '<td class="value"><div id="buttonshomepage_element_8_twelve_two_style_image" class="buttons-set"><button type="button" class="scalable show-hide" style="" id="togglehomepage_element_8_twelve_two_style_image"><span><span><span>Show / Hide Editor</span></span></span></button><button type="button" class="scalable add-widget plugin" onclick="widgetTools.openDialog('.$baseurl.'evolved/widget/index/widget_target_id/homepage_element_8_twelve_two_style_image)" style=""><span><span><span>Insert Widget...</span></span></span></button><button type="button" class="scalable add-image plugin" onclick="MediabrowserUtility.openDialog('.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_8_twelve_two_style_image/)" style=""><span><span><span>Insert Image...</span></span></span></button><button type="button" class="scalable add-variable plugin" onclick="MagentovariablePlugin.loadChooser('.$baseurl.'evolved/system_variable/wysiwygPlugin/, homepage_element_8_twelve_two_style_image);"><span><span><span>Insert Variable...</span></span></span></button></div><textarea name="homepage_element_8_twelve_two_style_image" title="" id="homepage_element_8_twelve_two_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_8_twelve_two_style_image'].'</textarea><small>Image size must be 1920*480 pixels</small></td>';
      						$str = $str . '<td class="value"><button id="togglehomepage_element_8_twelve_two_style_image" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><div id="buttonshomepage_element_8_twelve_two_style_image" class="buttons-set"><button style="" onclick="MediabrowserUtility.openDialog(\''.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_8_twelve_two_style_image/\')" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button></div><textarea name="homepage_element_8_50_percentage_522_by_346_two_boxes_width[homepage_element_8_twelve_two_style_image]" title="" id="homepage_element_8_twelve_two_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_8_twelve_two_style_image'].'</textarea><small>Image size must be 522*346 pixels</small></td>';
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
      						$str = $str . '}wysiwyghomepage_element_8_twelve_two_style_image = new tinyMceWysiwygSetup("homepage_element_8_twelve_two_style_image", {"enabled":true,"hidden":true,"use_container":false,"add_variables":true,"add_widgets":true,"add_images":true,"no_display":false,"translator":{},"encode_directives":true,"directives_url":"'.$baseurl.'evolved/cms_wysiwyg/directive/","popup_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/dialog.css","content_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/content.css","width":"100%","plugins":[{"name":"magentovariable","src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentovariable/editor_plugin.js","options":{"title":"Insert Variable...","url":"'.$baseurl.'evolved/system_variable/wysiwygPlugin/","onclick":{"search":["html_id"],"subject":"MagentovariablePlugin.loadChooser(\''.$baseurl.'evolved/system_variable/wysiwygPlugin/\', \'{{html_id}}\');"},"class":"add-variable plugin"}}],"directives_url_quoted":"'.$baseurl.'evolved/cms_wysiwyg/directive/","files_browser_window_url":"'.$baseurl.'idealAdmin/cms_wysiwyg_images/index/","files_browser_window_width":1000,"files_browser_window_height":600,"widget_plugin_src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentowidget/editor_plugin.js","widget_images_url":"'.$siteurl.'skin/adminhtml/default/default/images/widget/","widget_placeholders":["Thumbs.db","catalog__category_widget_link.gif","catalog__product_widget_link.gif","catalog__product_widget_new.gif","cms__widget_block.gif","cms__widget_page_link.gif","default.gif","reports__product_widget_compared.gif","reports__product_widget_viewed.gif"],"widget_window_url":"'.$baseurl.'evolved/widget/index/","firebug_warning_title":"Warning","firebug_warning_text":"Firebug is known to make the WYSIWYG editor slow unless it is turned off or configured properly.","firebug_warning_anchor":"Hide"});';
      						$str = $str . 'editorFormValidationHandler = wysiwyghomepage_element_8_twelve_two_style_image.onFormValidation.bind(wysiwyghomepage_element_8_twelve_two_style_image);';
      						$str = $str . 'Event.observe("togglehomepage_element_8_twelve_two_style_image", "click", wysiwyghomepage_element_8_twelve_two_style_image.toggle.bind(wysiwyghomepage_element_8_twelve_two_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("formSubmit", editorFormValidationHandler);';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceBeforeSetContent", wysiwyghomepage_element_8_twelve_two_style_image.beforeSetContent.bind(wysiwyghomepage_element_8_twelve_two_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceSaveContent", wysiwyghomepage_element_8_twelve_two_style_image.saveContent.bind(wysiwyghomepage_element_8_twelve_two_style_image));';
      						$str = $str . 'varienGlobalEvents.clearEventHandlers("open_browser_callback");';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("open_browser_callback", wysiwyghomepage_element_8_twelve_two_style_image.openFileBrowser.bind(wysiwyghomepage_element_8_twelve_two_style_image));';
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
      						if($selectElement == 'homepage_element_8_1050_by_170_banner')
      						{
      							$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="homepage_element_8_1050_by_170_banner" style="display: block">';
      						}
      						else
      						{
      							$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="homepage_element_8_1050_by_170_banner"  style="display: none">';
      						}
      						//$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="1050_by_170_banner">';
      						$str = $str . '<tbody>';
      						$str = $str . '<tr>';
      						$str = $str . '<td>';
      						$str = $str . '<table cellspacing="0" class="form-list allpageelement" style="display: table-cell;">';
							$str = $str . '<tbody>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_thirteen_one_style_title">Title:</label></td>';  
      						$str = $str . '<td class="value"><input id="homepage_element_8_thirteen_one_style_title" value="'.$collectiondata['homepage_element_8_thirteen_one_style_title'].'" name="homepage_element_8_1050_by_170_banner[homepage_element_8_thirteen_one_style_title]"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str .	'<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_thirteen_one_style_link">Link:</label></td>';
      						$str = $str . '<td class="value"><input id="homepage_element_8_thirteen_one_style_link" value="'.$collectiondata['homepage_element_8_thirteen_one_style_link'].'" name="homepage_element_8_1050_by_170_banner[homepage_element_8_thirteen_one_style_link]"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_thirteen_one_style_target">Target:</label></td>';
      						$str = $str . '<td class="value">';
      						$str = $str . '<select id="homepage_element_8_thirteen_one_style_target" name="homepage_element_8_1050_by_170_banner[homepage_element_8_thirteen_one_style_target]" >';
      						foreach($targetarr as $targetarrkey => $targetarrvalue)
      						{
      							if($collectiondata['homepage_element_8_thirteen_one_style_target']==$targetarrkey)
      							{
      								$str = $str . '<option value='.$targetarrkey.' selected>'.$targetarrvalue.'</option>';
      							}
      							else
      							{
      								$str = $str . '<option value='.$targetarrkey.'>'.$targetarrvalue.'</option>';
      							}
      						}
      						$str = $str . '</select>';
      						$str = $str . '</td>';
      						$str = $str . '</tr>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_thirteen_one_style_image">Image:</label></td>';
      						//$str = $str . '<td class="value"><div id="buttonshomepage_element_8_thirteen_one_style_image" class="buttons-set"><button type="button" class="scalable show-hide" style="" id="togglehomepage_element_8_thirteen_one_style_image"><span><span><span>Show / Hide Editor</span></span></span></button><button type="button" class="scalable add-widget plugin" onclick="widgetTools.openDialog('.$baseurl.'evolved/widget/index/widget_target_id/homepage_element_8_thirteen_one_style_image)" style=""><span><span><span>Insert Widget...</span></span></span></button><button type="button" class="scalable add-image plugin" onclick="MediabrowserUtility.openDialog('.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_8_thirteen_one_style_image/)" style=""><span><span><span>Insert Image...</span></span></span></button><button type="button" class="scalable add-variable plugin" onclick="MagentovariablePlugin.loadChooser('.$baseurl.'evolved/system_variable/wysiwygPlugin/, homepage_element_8_thirteen_one_style_image);"><span><span><span>Insert Variable...</span></span></span></button></div><textarea name="homepage_element_8_thirteen_one_style_image" title="" id="homepage_element_8_thirteen_one_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_8_thirteen_one_style_image'].'</textarea><small>Image size must be 1920*480 pixels</small></td>';
      						$str = $str . '<td class="value"><button id="togglehomepage_element_8_thirteen_one_style_image" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><div id="buttonshomepage_element_8_thirteen_one_style_image" class="buttons-set"><button style="" onclick="MediabrowserUtility.openDialog(\''.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_8_thirteen_one_style_image/\')" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button></div><textarea name="homepage_element_8_1050_by_170_banner[homepage_element_8_thirteen_one_style_image]" title="" id="homepage_element_8_thirteen_one_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_8_thirteen_one_style_image'].'</textarea><small>Image size must be 1050*170 pixels</small></td>';
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
      						$str = $str . '}wysiwyghomepage_element_8_thirteen_one_style_image = new tinyMceWysiwygSetup("homepage_element_8_thirteen_one_style_image", {"enabled":true,"hidden":true,"use_container":false,"add_variables":true,"add_widgets":true,"add_images":true,"no_display":false,"translator":{},"encode_directives":true,"directives_url":"'.$baseurl.'evolved/cms_wysiwyg/directive/","popup_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/dialog.css","content_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/content.css","width":"100%","plugins":[{"name":"magentovariable","src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentovariable/editor_plugin.js","options":{"title":"Insert Variable...","url":"'.$baseurl.'evolved/system_variable/wysiwygPlugin/","onclick":{"search":["html_id"],"subject":"MagentovariablePlugin.loadChooser(\''.$baseurl.'evolved/system_variable/wysiwygPlugin/\', \'{{html_id}}\');"},"class":"add-variable plugin"}}],"directives_url_quoted":"'.$baseurl.'evolved/cms_wysiwyg/directive/","files_browser_window_url":"'.$baseurl.'idealAdmin/cms_wysiwyg_images/index/","files_browser_window_width":1000,"files_browser_window_height":600,"widget_plugin_src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentowidget/editor_plugin.js","widget_images_url":"'.$siteurl.'skin/adminhtml/default/default/images/widget/","widget_placeholders":["Thumbs.db","catalog__category_widget_link.gif","catalog__product_widget_link.gif","catalog__product_widget_new.gif","cms__widget_block.gif","cms__widget_page_link.gif","default.gif","reports__product_widget_compared.gif","reports__product_widget_viewed.gif"],"widget_window_url":"'.$baseurl.'evolved/widget/index/","firebug_warning_title":"Warning","firebug_warning_text":"Firebug is known to make the WYSIWYG editor slow unless it is turned off or configured properly.","firebug_warning_anchor":"Hide"});';
      						$str = $str . 'editorFormValidationHandler = wysiwyghomepage_element_8_thirteen_one_style_image.onFormValidation.bind(wysiwyghomepage_element_8_thirteen_one_style_image);';
      						$str = $str . 'Event.observe("togglehomepage_element_8_thirteen_one_style_image", "click", wysiwyghomepage_element_8_thirteen_one_style_image.toggle.bind(wysiwyghomepage_element_8_thirteen_one_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("formSubmit", editorFormValidationHandler);';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceBeforeSetContent", wysiwyghomepage_element_8_thirteen_one_style_image.beforeSetContent.bind(wysiwyghomepage_element_8_thirteen_one_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceSaveContent", wysiwyghomepage_element_8_thirteen_one_style_image.saveContent.bind(wysiwyghomepage_element_8_thirteen_one_style_image));';
      						$str = $str . 'varienGlobalEvents.clearEventHandlers("open_browser_callback");';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("open_browser_callback", wysiwyghomepage_element_8_thirteen_one_style_image.openFileBrowser.bind(wysiwyghomepage_element_8_thirteen_one_style_image));';
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
      						if($selectElement == 'homepage_element_8_1050_by_346_banner')
      						{
      							$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="homepage_element_8_1050_by_346_banner" style="display: block">';
      						}
      						else
      						{
      							$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="homepage_element_8_1050_by_346_banner"  style="display: none">';
      						}
      						//$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="1050_by_346_banner">';
      						$str = $str . '<tbody>';
      						$str = $str . '<tr>';
      						$str = $str . '<td>';
      						$str = $str . '<table cellspacing="0" class="form-list allpageelement" style="display: table-cell;">';
							$str = $str . '<tbody>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_fourteen_one_style_title">Title:</label></td>';  
      						$str = $str . '<td class="value"><input id="homepage_element_8_fourteen_one_style_title" value="'.$collectiondata['homepage_element_8_fourteen_one_style_title'].'" name="homepage_element_8_1050_by_346_banner[homepage_element_8_fourteen_one_style_title]"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str .	'<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_fourteen_one_style_link">Link:</label></td>';
      						$str = $str . '<td class="value"><input id="homepage_element_8_fourteen_one_style_link" value="'.$collectiondata['homepage_element_8_fourteen_one_style_link'].'" name="homepage_element_8_1050_by_346_banner[homepage_element_8_fourteen_one_style_link]"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_fourteen_one_style_target">Target:</label></td>';
      						$str = $str . '<td class="value">';
      						$str = $str . '<select id="homepage_element_8_fourteen_one_style_target" name="homepage_element_8_1050_by_346_banner[homepage_element_8_fourteen_one_style_target]" >';
      						foreach($targetarr as $targetarrkey => $targetarrvalue)
      						{
      							if($collectiondata['homepage_element_8_fourteen_one_style_target']==$targetarrkey)
      							{
      								$str = $str . '<option value='.$targetarrkey.' selected>'.$targetarrvalue.'</option>';
      							}
      							else
      							{
      								$str = $str . '<option value='.$targetarrkey.'>'.$targetarrvalue.'</option>';
      							}
      						}
      						$str = $str . '</select>';
      						$str = $str . '</td>';
      						$str = $str . '</tr>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_fourteen_one_style_image">Image:</label></td>';
      						//$str = $str . '<td class="value"><div id="buttonshomepage_element_8_fourteen_one_style_image" class="buttons-set"><button type="button" class="scalable show-hide" style="" id="togglehomepage_element_8_fourteen_one_style_image"><span><span><span>Show / Hide Editor</span></span></span></button><button type="button" class="scalable add-widget plugin" onclick="widgetTools.openDialog('.$baseurl.'evolved/widget/index/widget_target_id/homepage_element_8_fourteen_one_style_image)" style=""><span><span><span>Insert Widget...</span></span></span></button><button type="button" class="scalable add-image plugin" onclick="MediabrowserUtility.openDialog('.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_8_fourteen_one_style_image/)" style=""><span><span><span>Insert Image...</span></span></span></button><button type="button" class="scalable add-variable plugin" onclick="MagentovariablePlugin.loadChooser('.$baseurl.'evolved/system_variable/wysiwygPlugin/, homepage_element_8_fourteen_one_style_image);"><span><span><span>Insert Variable...</span></span></span></button></div><textarea name="homepage_element_8_fourteen_one_style_image" title="" id="homepage_element_8_fourteen_one_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_8_fourteen_one_style_image'].'</textarea><small>Image size must be 1920*480 pixels</small></td>';
      						$str = $str . '<td class="value"><button id="togglehomepage_element_8_fourteen_one_style_image" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><div id="buttonshomepage_element_8_fourteen_one_style_image" class="buttons-set"><button style="" onclick="MediabrowserUtility.openDialog(\''.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_8_fourteen_one_style_image/\')" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button></div><textarea name="homepage_element_8_1050_by_346_banner[homepage_element_8_fourteen_one_style_image]" title="" id="homepage_element_8_fourteen_one_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_8_fourteen_one_style_image'].'</textarea><small>Image size must be 1050*346 pixels</small></td>';
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
      						$str = $str . '}wysiwyghomepage_element_8_fourteen_one_style_image = new tinyMceWysiwygSetup("homepage_element_8_fourteen_one_style_image", {"enabled":true,"hidden":true,"use_container":false,"add_variables":true,"add_widgets":true,"add_images":true,"no_display":false,"translator":{},"encode_directives":true,"directives_url":"'.$baseurl.'evolved/cms_wysiwyg/directive/","popup_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/dialog.css","content_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/content.css","width":"100%","plugins":[{"name":"magentovariable","src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentovariable/editor_plugin.js","options":{"title":"Insert Variable...","url":"'.$baseurl.'evolved/system_variable/wysiwygPlugin/","onclick":{"search":["html_id"],"subject":"MagentovariablePlugin.loadChooser(\''.$baseurl.'evolved/system_variable/wysiwygPlugin/\', \'{{html_id}}\');"},"class":"add-variable plugin"}}],"directives_url_quoted":"'.$baseurl.'evolved/cms_wysiwyg/directive/","files_browser_window_url":"'.$baseurl.'idealAdmin/cms_wysiwyg_images/index/","files_browser_window_width":1000,"files_browser_window_height":600,"widget_plugin_src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentowidget/editor_plugin.js","widget_images_url":"'.$siteurl.'skin/adminhtml/default/default/images/widget/","widget_placeholders":["Thumbs.db","catalog__category_widget_link.gif","catalog__product_widget_link.gif","catalog__product_widget_new.gif","cms__widget_block.gif","cms__widget_page_link.gif","default.gif","reports__product_widget_compared.gif","reports__product_widget_viewed.gif"],"widget_window_url":"'.$baseurl.'evolved/widget/index/","firebug_warning_title":"Warning","firebug_warning_text":"Firebug is known to make the WYSIWYG editor slow unless it is turned off or configured properly.","firebug_warning_anchor":"Hide"});';
      						$str = $str . 'editorFormValidationHandler = wysiwyghomepage_element_8_fourteen_one_style_image.onFormValidation.bind(wysiwyghomepage_element_8_fourteen_one_style_image);';
      						$str = $str . 'Event.observe("togglehomepage_element_8_fourteen_one_style_image", "click", wysiwyghomepage_element_8_fourteen_one_style_image.toggle.bind(wysiwyghomepage_element_8_fourteen_one_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("formSubmit", editorFormValidationHandler);';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceBeforeSetContent", wysiwyghomepage_element_8_fourteen_one_style_image.beforeSetContent.bind(wysiwyghomepage_element_8_fourteen_one_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceSaveContent", wysiwyghomepage_element_8_fourteen_one_style_image.saveContent.bind(wysiwyghomepage_element_8_fourteen_one_style_image));';
      						$str = $str . 'varienGlobalEvents.clearEventHandlers("open_browser_callback");';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("open_browser_callback", wysiwyghomepage_element_8_fourteen_one_style_image.openFileBrowser.bind(wysiwyghomepage_element_8_fourteen_one_style_image));';
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
      						if($selectElement == 'homepage_element_8_33_percentage_left_50_percentage_right_boxes_right_updown_width')
      						{
      							$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="homepage_element_8_33_percentage_left_50_percentage_right_boxes_right_updown_width" style="display: block">';
      						}
      						else
      						{
      							$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="homepage_element_8_33_percentage_left_50_percentage_right_boxes_right_updown_width"  style="display: none">';
      						}
      						//$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="33_percentage_left_50_percentage_right_boxes_right_updown_width">';
      						$str = $str . '<tbody>';
      						$str = $str . '<tr>';
      						$str = $str . '<td>';
      						$str = $str . '<table cellspacing="0" class="form-list allpageelement" style="display: table-cell;">';
							$str = $str . '<tbody>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_fifthteen_one_style_title">Title:</label></td>';  
      						$str = $str . '<td class="value"><input id="homepage_element_8_fifthteen_one_style_title" value="'.$collectiondata['homepage_element_8_fifthteen_one_style_title'].'" name="homepage_element_8_33_percentage_left_50_percentage_right_boxes_right_updown_width[homepage_element_8_fifthteen_one_style_title]"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str .	'<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_fifthteen_one_style_link">Link:</label></td>';
      						$str = $str . '<td class="value"><input id="homepage_element_8_fifthteen_one_style_link" value="'.$collectiondata['homepage_element_8_fifthteen_one_style_link'].'" name="homepage_element_8_33_percentage_left_50_percentage_right_boxes_right_updown_width[homepage_element_8_fifthteen_one_style_link]"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_fifthteen_one_style_target">Target:</label></td>';
      						$str = $str . '<td class="value">';
      						$str = $str . '<select id="homepage_element_8_fifthteen_one_style_target" name="homepage_element_8_33_percentage_left_50_percentage_right_boxes_right_updown_width[homepage_element_8_fifthteen_one_style_target]" >';
      						foreach($targetarr as $targetarrkey => $targetarrvalue)
      						{
      							if($collectiondata['homepage_element_8_fifthteen_one_style_target']==$targetarrkey)
      							{
      								$str = $str . '<option value='.$targetarrkey.' selected>'.$targetarrvalue.'</option>';
      							}
      							else
      							{
      								$str = $str . '<option value='.$targetarrkey.'>'.$targetarrvalue.'</option>';
      							}
      						}
      						$str = $str . '</select>';
      						$str = $str . '</td>';
      						$str = $str . '</tr>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_fifthteen_one_style_image">Image:</label></td>';
      						//$str = $str . '<td class="value"><div id="buttonshomepage_element_8_fifthteen_one_style_image" class="buttons-set"><button type="button" class="scalable show-hide" style="" id="togglehomepage_element_8_fifthteen_one_style_image"><span><span><span>Show / Hide Editor</span></span></span></button><button type="button" class="scalable add-widget plugin" onclick="widgetTools.openDialog('.$baseurl.'evolved/widget/index/widget_target_id/homepage_element_8_fifthteen_one_style_image)" style=""><span><span><span>Insert Widget...</span></span></span></button><button type="button" class="scalable add-image plugin" onclick="MediabrowserUtility.openDialog('.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_8_fifthteen_one_style_image/)" style=""><span><span><span>Insert Image...</span></span></span></button><button type="button" class="scalable add-variable plugin" onclick="MagentovariablePlugin.loadChooser('.$baseurl.'evolved/system_variable/wysiwygPlugin/, homepage_element_8_fifthteen_one_style_image);"><span><span><span>Insert Variable...</span></span></span></button></div><textarea name="homepage_element_8_fifthteen_one_style_image" title="" id="homepage_element_8_fifthteen_one_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_8_fifthteen_one_style_image'].'</textarea><small>Image size must be 1920*480 pixels</small></td>';
      						$str = $str . '<td class="value"><button id="togglehomepage_element_8_fifthteen_one_style_image" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><div id="buttonshomepage_element_8_fifthteen_one_style_image" class="buttons-set"><button style="" onclick="MediabrowserUtility.openDialog(\''.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_8_fifthteen_one_style_image/\')" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button></div><textarea name="homepage_element_8_33_percentage_left_50_percentage_right_boxes_right_updown_width[homepage_element_8_fifthteen_one_style_image]" title="" id="homepage_element_8_fifthteen_one_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_8_fifthteen_one_style_image'].'</textarea><small>Image size must be 522*346 pixels</small></td>';
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
      						$str = $str . '}wysiwyghomepage_element_8_fifthteen_one_style_image = new tinyMceWysiwygSetup("homepage_element_8_fifthteen_one_style_image", {"enabled":true,"hidden":true,"use_container":false,"add_variables":true,"add_widgets":true,"add_images":true,"no_display":false,"translator":{},"encode_directives":true,"directives_url":"'.$baseurl.'evolved/cms_wysiwyg/directive/","popup_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/dialog.css","content_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/content.css","width":"100%","plugins":[{"name":"magentovariable","src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentovariable/editor_plugin.js","options":{"title":"Insert Variable...","url":"'.$baseurl.'evolved/system_variable/wysiwygPlugin/","onclick":{"search":["html_id"],"subject":"MagentovariablePlugin.loadChooser(\''.$baseurl.'evolved/system_variable/wysiwygPlugin/\', \'{{html_id}}\');"},"class":"add-variable plugin"}}],"directives_url_quoted":"'.$baseurl.'evolved/cms_wysiwyg/directive/","files_browser_window_url":"'.$baseurl.'idealAdmin/cms_wysiwyg_images/index/","files_browser_window_width":1000,"files_browser_window_height":600,"widget_plugin_src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentowidget/editor_plugin.js","widget_images_url":"'.$siteurl.'skin/adminhtml/default/default/images/widget/","widget_placeholders":["Thumbs.db","catalog__category_widget_link.gif","catalog__product_widget_link.gif","catalog__product_widget_new.gif","cms__widget_block.gif","cms__widget_page_link.gif","default.gif","reports__product_widget_compared.gif","reports__product_widget_viewed.gif"],"widget_window_url":"'.$baseurl.'evolved/widget/index/","firebug_warning_title":"Warning","firebug_warning_text":"Firebug is known to make the WYSIWYG editor slow unless it is turned off or configured properly.","firebug_warning_anchor":"Hide"});';
      						$str = $str . 'editorFormValidationHandler = wysiwyghomepage_element_8_fifthteen_one_style_image.onFormValidation.bind(wysiwyghomepage_element_8_fifthteen_one_style_image);';
      						$str = $str . 'Event.observe("togglehomepage_element_8_fifthteen_one_style_image", "click", wysiwyghomepage_element_8_fifthteen_one_style_image.toggle.bind(wysiwyghomepage_element_8_fifthteen_one_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("formSubmit", editorFormValidationHandler);';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceBeforeSetContent", wysiwyghomepage_element_8_fifthteen_one_style_image.beforeSetContent.bind(wysiwyghomepage_element_8_fifthteen_one_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceSaveContent", wysiwyghomepage_element_8_fifthteen_one_style_image.saveContent.bind(wysiwyghomepage_element_8_fifthteen_one_style_image));';
      						$str = $str . 'varienGlobalEvents.clearEventHandlers("open_browser_callback");';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("open_browser_callback", wysiwyghomepage_element_8_fifthteen_one_style_image.openFileBrowser.bind(wysiwyghomepage_element_8_fifthteen_one_style_image));';
      						$str = $str . '</script>';
      						$str = $str . '</tr>';
      						$str = $str . '</tbody>';
      						$str = $str . '</table>'; 
      						$str = $str . '<table cellspacing="0" class="form-list allpageelement" style="display: table-cell;">';
							$str = $str . '<tbody>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_fifthteen_two_up_style_title">Title:</label></td>';  
      						$str = $str . '<td class="value"><input id="homepage_element_8_fifthteen_two_up_style_title" value="'.$collectiondata['homepage_element_8_fifthteen_two_up_style_title'].'" name="homepage_element_8_33_percentage_left_50_percentage_right_boxes_right_updown_width[homepage_element_8_fifthteen_two_up_style_title]"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str .	'<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_fifthteen_two_up_style_link">Link:</label></td>';
      						$str = $str . '<td class="value"><input id="homepage_element_8_fifthteen_two_up_style_link" value="'.$collectiondata['homepage_element_8_fifthteen_two_up_style_link'].'" name="homepage_element_8_33_percentage_left_50_percentage_right_boxes_right_updown_width[homepage_element_8_fifthteen_two_up_style_link]"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_fifthteen_two_up_style_target">Target:</label></td>';
      						$str = $str . '<td class="value">';
      						$str = $str . '<select id="homepage_element_8_fifthteen_two_up_style_target" name="homepage_element_8_33_percentage_left_50_percentage_right_boxes_right_updown_width[homepage_element_8_fifthteen_two_up_style_target]" >';
      						foreach($targetarr as $targetarrkey => $targetarrvalue)
      						{
      							if($collectiondata['homepage_element_8_fifthteen_two_up_style_target']==$targetarrkey)
      							{
      								$str = $str . '<option value='.$targetarrkey.' selected>'.$targetarrvalue.'</option>';
      							}
      							else
      							{
      								$str = $str . '<option value='.$targetarrkey.'>'.$targetarrvalue.'</option>';
      							}
      						}
      						$str = $str . '</select>';
      						$str = $str . '</td>';
      						$str = $str . '</tr>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_fifthteen_two_up_style_image">Image:</label></td>';
      						//$str = $str . '<td class="value"><div id="buttonshomepage_element_8_fifthteen_two_up_style_image" class="buttons-set"><button type="button" class="scalable show-hide" style="" id="togglehomepage_element_8_fifthteen_two_up_style_image"><span><span><span>Show / Hide Editor</span></span></span></button><button type="button" class="scalable add-widget plugin" onclick="widgetTools.openDialog('.$baseurl.'evolved/widget/index/widget_target_id/homepage_element_8_fifthteen_two_up_style_image)" style=""><span><span><span>Insert Widget...</span></span></span></button><button type="button" class="scalable add-image plugin" onclick="MediabrowserUtility.openDialog('.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_8_fifthteen_two_up_style_image/)" style=""><span><span><span>Insert Image...</span></span></span></button><button type="button" class="scalable add-variable plugin" onclick="MagentovariablePlugin.loadChooser('.$baseurl.'evolved/system_variable/wysiwygPlugin/, homepage_element_8_fifthteen_two_up_style_image);"><span><span><span>Insert Variable...</span></span></span></button></div><textarea name="homepage_element_8_fifthteen_two_up_style_image" title="" id="homepage_element_8_fifthteen_two_up_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_8_fifthteen_two_up_style_image'].'</textarea><small>Image size must be 1920*480 pixels</small></td>';
      						$str = $str . '<td class="value"><button id="togglehomepage_element_8_fifthteen_two_up_style_image" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><div id="buttonshomepage_element_8_fifthteen_two_up_style_image" class="buttons-set"><button style="" onclick="MediabrowserUtility.openDialog(\''.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_8_fifthteen_two_up_style_image/\')" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button></div><textarea name="homepage_element_8_33_percentage_left_50_percentage_right_boxes_right_updown_width[homepage_element_8_fifthteen_two_up_style_image]" title="" id="homepage_element_8_fifthteen_two_up_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_8_fifthteen_two_up_style_image'].'</textarea><small>Image size must be 522*170 pixels</small></td>';
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
      						$str = $str . '}wysiwyghomepage_element_8_fifthteen_two_up_style_image = new tinyMceWysiwygSetup("homepage_element_8_fifthteen_two_up_style_image", {"enabled":true,"hidden":true,"use_container":false,"add_variables":true,"add_widgets":true,"add_images":true,"no_display":false,"translator":{},"encode_directives":true,"directives_url":"'.$baseurl.'evolved/cms_wysiwyg/directive/","popup_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/dialog.css","content_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/content.css","width":"100%","plugins":[{"name":"magentovariable","src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentovariable/editor_plugin.js","options":{"title":"Insert Variable...","url":"'.$baseurl.'evolved/system_variable/wysiwygPlugin/","onclick":{"search":["html_id"],"subject":"MagentovariablePlugin.loadChooser(\''.$baseurl.'evolved/system_variable/wysiwygPlugin/\', \'{{html_id}}\');"},"class":"add-variable plugin"}}],"directives_url_quoted":"'.$baseurl.'evolved/cms_wysiwyg/directive/","files_browser_window_url":"'.$baseurl.'idealAdmin/cms_wysiwyg_images/index/","files_browser_window_width":1000,"files_browser_window_height":600,"widget_plugin_src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentowidget/editor_plugin.js","widget_images_url":"'.$siteurl.'skin/adminhtml/default/default/images/widget/","widget_placeholders":["Thumbs.db","catalog__category_widget_link.gif","catalog__product_widget_link.gif","catalog__product_widget_new.gif","cms__widget_block.gif","cms__widget_page_link.gif","default.gif","reports__product_widget_compared.gif","reports__product_widget_viewed.gif"],"widget_window_url":"'.$baseurl.'evolved/widget/index/","firebug_warning_title":"Warning","firebug_warning_text":"Firebug is known to make the WYSIWYG editor slow unless it is turned off or configured properly.","firebug_warning_anchor":"Hide"});';
      						$str = $str . 'editorFormValidationHandler = wysiwyghomepage_element_8_fifthteen_two_up_style_image.onFormValidation.bind(wysiwyghomepage_element_8_fifthteen_two_up_style_image);';
      						$str = $str . 'Event.observe("togglehomepage_element_8_fifthteen_two_up_style_image", "click", wysiwyghomepage_element_8_fifthteen_two_up_style_image.toggle.bind(wysiwyghomepage_element_8_fifthteen_two_up_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("formSubmit", editorFormValidationHandler);';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceBeforeSetContent", wysiwyghomepage_element_8_fifthteen_two_up_style_image.beforeSetContent.bind(wysiwyghomepage_element_8_fifthteen_two_up_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceSaveContent", wysiwyghomepage_element_8_fifthteen_two_up_style_image.saveContent.bind(wysiwyghomepage_element_8_fifthteen_two_up_style_image));';
      						$str = $str . 'varienGlobalEvents.clearEventHandlers("open_browser_callback");';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("open_browser_callback", wysiwyghomepage_element_8_fifthteen_two_up_style_image.openFileBrowser.bind(wysiwyghomepage_element_8_fifthteen_two_up_style_image));';
      						$str = $str . '</script>';
      						$str = $str . '</tr>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_fifthteen_two_down_style_title">Title:</label></td>';  
      						$str = $str . '<td class="value"><input id="homepage_element_8_fifthteen_two_down_style_title" value="'.$collectiondata['homepage_element_8_fifthteen_two_down_style_title'].'" name="homepage_element_8_33_percentage_left_50_percentage_right_boxes_right_updown_width[homepage_element_8_fifthteen_two_down_style_title]"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str .	'<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_fifthteen_two_down_style_link">Link:</label></td>';
      						$str = $str . '<td class="value"><input id="homepage_element_8_fifthteen_two_down_style_link" value="'.$collectiondata['homepage_element_8_fifthteen_two_down_style_link'].'" name="homepage_element_8_33_percentage_left_50_percentage_right_boxes_right_updown_width[homepage_element_8_fifthteen_two_down_style_link]"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_fifthteen_two_down_style_target">Target:</label></td>';
      						$str = $str . '<td class="value">';
      						$str = $str . '<select id="homepage_element_8_fifthteen_two_down_style_target" name="homepage_element_8_33_percentage_left_50_percentage_right_boxes_right_updown_width[homepage_element_8_fifthteen_two_down_style_target]" >';
      						foreach($targetarr as $targetarrkey => $targetarrvalue)
      						{
      							if($collectiondata['homepage_element_8_fifthteen_two_down_style_target']==$targetarrkey)
      							{
      								$str = $str . '<option value='.$targetarrkey.' selected>'.$targetarrvalue.'</option>';
      							}
      							else
      							{
      								$str = $str . '<option value='.$targetarrkey.'>'.$targetarrvalue.'</option>';
      							}
      						}
      						$str = $str . '</select>';
      						$str = $str . '</td>';
      						$str = $str . '</tr>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_fifthteen_two_down_style_image">Image:</label></td>';
      						//$str = $str . '<td class="value"><div id="buttonshomepage_element_8_fifthteen_two_down_style_image" class="buttons-set"><button type="button" class="scalable show-hide" style="" id="togglehomepage_element_8_fifthteen_two_down_style_image"><span><span><span>Show / Hide Editor</span></span></span></button><button type="button" class="scalable add-widget plugin" onclick="widgetTools.openDialog('.$baseurl.'evolved/widget/index/widget_target_id/homepage_element_8_fifthteen_two_down_style_image)" style=""><span><span><span>Insert Widget...</span></span></span></button><button type="button" class="scalable add-image plugin" onclick="MediabrowserUtility.openDialog('.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_8_fifthteen_two_down_style_image/)" style=""><span><span><span>Insert Image...</span></span></span></button><button type="button" class="scalable add-variable plugin" onclick="MagentovariablePlugin.loadChooser('.$baseurl.'evolved/system_variable/wysiwygPlugin/, homepage_element_8_fifthteen_two_down_style_image);"><span><span><span>Insert Variable...</span></span></span></button></div><textarea name="homepage_element_8_fifthteen_two_down_style_image" title="" id="homepage_element_8_fifthteen_two_down_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_8_fifthteen_two_down_style_image'].'</textarea><small>Image size must be 1920*480 pixels</small></td>';
      						$str = $str . '<td class="value"><button id="togglehomepage_element_8_fifthteen_two_down_style_image" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><div id="buttonshomepage_element_8_fifthteen_two_down_style_image" class="buttons-set"><button style="" onclick="MediabrowserUtility.openDialog(\''.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_8_fifthteen_two_down_style_image/\')" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button></div><textarea name="homepage_element_8_33_percentage_left_50_percentage_right_boxes_right_updown_width[homepage_element_8_fifthteen_two_down_style_image]" title="" id="homepage_element_8_fifthteen_two_down_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_8_fifthteen_two_down_style_image'].'</textarea><small>Image size must be 522*170 pixels</small></td>';
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
      						$str = $str . '}wysiwyghomepage_element_8_fifthteen_two_down_style_image = new tinyMceWysiwygSetup("homepage_element_8_fifthteen_two_down_style_image", {"enabled":true,"hidden":true,"use_container":false,"add_variables":true,"add_widgets":true,"add_images":true,"no_display":false,"translator":{},"encode_directives":true,"directives_url":"'.$baseurl.'evolved/cms_wysiwyg/directive/","popup_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/dialog.css","content_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/content.css","width":"100%","plugins":[{"name":"magentovariable","src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentovariable/editor_plugin.js","options":{"title":"Insert Variable...","url":"'.$baseurl.'evolved/system_variable/wysiwygPlugin/","onclick":{"search":["html_id"],"subject":"MagentovariablePlugin.loadChooser(\''.$baseurl.'evolved/system_variable/wysiwygPlugin/\', \'{{html_id}}\');"},"class":"add-variable plugin"}}],"directives_url_quoted":"'.$baseurl.'evolved/cms_wysiwyg/directive/","files_browser_window_url":"'.$baseurl.'idealAdmin/cms_wysiwyg_images/index/","files_browser_window_width":1000,"files_browser_window_height":600,"widget_plugin_src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentowidget/editor_plugin.js","widget_images_url":"'.$siteurl.'skin/adminhtml/default/default/images/widget/","widget_placeholders":["Thumbs.db","catalog__category_widget_link.gif","catalog__product_widget_link.gif","catalog__product_widget_new.gif","cms__widget_block.gif","cms__widget_page_link.gif","default.gif","reports__product_widget_compared.gif","reports__product_widget_viewed.gif"],"widget_window_url":"'.$baseurl.'evolved/widget/index/","firebug_warning_title":"Warning","firebug_warning_text":"Firebug is known to make the WYSIWYG editor slow unless it is turned off or configured properly.","firebug_warning_anchor":"Hide"});';
      						$str = $str . 'editorFormValidationHandler = wysiwyghomepage_element_8_fifthteen_two_down_style_image.onFormValidation.bind(wysiwyghomepage_element_8_fifthteen_two_down_style_image);';
      						$str = $str . 'Event.observe("togglehomepage_element_8_fifthteen_two_down_style_image", "click", wysiwyghomepage_element_8_fifthteen_two_down_style_image.toggle.bind(wysiwyghomepage_element_8_fifthteen_two_down_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("formSubmit", editorFormValidationHandler);';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceBeforeSetContent", wysiwyghomepage_element_8_fifthteen_two_down_style_image.beforeSetContent.bind(wysiwyghomepage_element_8_fifthteen_two_down_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceSaveContent", wysiwyghomepage_element_8_fifthteen_two_down_style_image.saveContent.bind(wysiwyghomepage_element_8_fifthteen_two_down_style_image));';
      						$str = $str . 'varienGlobalEvents.clearEventHandlers("open_browser_callback");';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("open_browser_callback", wysiwyghomepage_element_8_fifthteen_two_down_style_image.openFileBrowser.bind(wysiwyghomepage_element_8_fifthteen_two_down_style_image));';
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
							if($selectElement == 'homepage_element_8_25_percentage_258_by_170_four_boxes_width')
      						{
      							$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="homepage_element_8_25_percentage_258_by_170_four_boxes_width" style="display: block">';
      						}
      						else
      						{
      							$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="homepage_element_8_25_percentage_258_by_170_four_boxes_width"  style="display: none">';
      						}
      						//$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="25_percentage_480_by_400_four_boxes_full_width">';
      						$str = $str . '<tbody>';
      						$str = $str . '<tr>';
      						$str = $str . '<td>';
      						$str = $str . '<table cellspacing="0" class="form-list allpageelement" style="display: table-cell;">';
							$str = $str . '<tbody>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_sixteen_one_style_title">Title:</label></td>';  
      						$str = $str . '<td class="value"><input id="homepage_element_8_sixteen_one_style_title" value="'.$collectiondata['homepage_element_8_sixteen_one_style_title'].'" name="homepage_element_8_25_percentage_258_by_170_four_boxes_width[homepage_element_8_sixteen_one_style_title]"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_sixteen_one_style_link">Link:</label></td>';
      						$str = $str . '<td class="value"><input id="homepage_element_8_sixteen_one_style_link" value="'.$collectiondata['homepage_element_8_sixteen_one_style_link'].'" name="homepage_element_8_25_percentage_258_by_170_four_boxes_width[homepage_element_8_sixteen_one_style_link]"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_sixteen_one_style_target">Target:</label></td>';
      						$str = $str . '<td class="value">';
      						$str = $str . '<select id="homepage_element_8_sixteen_one_style_target" name="homepage_element_8_25_percentage_258_by_170_four_boxes_width[homepage_element_8_sixteen_one_style_target]" >';
      						foreach($targetarr as $targetarrkey => $targetarrvalue)
      						{
      							if($collectiondata['homepage_element_8_sixteen_one_style_target']==$targetarrkey)
      							{
      								$str = $str . '<option value='.$targetarrkey.' selected>'.$targetarrvalue.'</option>';
      							}
      							else
      							{
      								$str = $str . '<option value='.$targetarrkey.'>'.$targetarrvalue.'</option>';
      							}
      						}
      						$str = $str . '</select>';
      						$str = $str . '</td>';
      						$str = $str . '</tr>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_sixteen_one_style_image">Image:</label></td>';
      						//$str = $str . '<td class="value"><div id="buttonshomepage_element_8_sixteen_one_style_image" class="buttons-set"><button type="button" class="scalable show-hide" style="" id="togglehomepage_element_8_sixteen_one_style_image"><span><span><span>Show / Hide Editor</span></span></span></button><button type="button" class="scalable add-widget plugin" onclick="widgetTools.openDialog('.$baseurl.'evolved/widget/index/widget_target_id/homepage_element_8_sixteen_one_style_image)" style=""><span><span><span>Insert Widget...</span></span></span></button><button type="button" class="scalable add-image plugin" onclick="MediabrowserUtility.openDialog('.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_8_sixteen_one_style_image/)" style=""><span><span><span>Insert Image...</span></span></span></button><button type="button" class="scalable add-variable plugin" onclick="MagentovariablePlugin.loadChooser('.$baseurl.'evolved/system_variable/wysiwygPlugin/, homepage_element_8_sixteen_one_style_image);"><span><span><span>Insert Variable...</span></span></span></button></div><textarea name="homepage_element_8_sixteen_one_style_image" title="" id="homepage_element_8_sixteen_one_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_8_sixteen_one_style_image'].'</textarea><small>Image size must be 1920*480 pixels</small></td>';
      						$str = $str . '<td class="value"><button id="togglehomepage_element_8_sixteen_one_style_image" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><div id="buttonshomepage_element_8_sixteen_one_style_image" class="buttons-set"><button style="" onclick="MediabrowserUtility.openDialog(\''.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_8_sixteen_one_style_image/\')" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button></div><textarea name="homepage_element_8_25_percentage_258_by_170_four_boxes_width[homepage_element_8_sixteen_one_style_image]" title="" id="homepage_element_8_sixteen_one_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_8_sixteen_one_style_image'].'</textarea><small>Image size must be 258*170 pixels</small></td>';
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
      						$str = $str . '}wysiwyghomepage_element_8_sixteen_one_style_image = new tinyMceWysiwygSetup("homepage_element_8_sixteen_one_style_image", {"enabled":true,"hidden":true,"use_container":false,"add_variables":true,"add_widgets":true,"add_images":true,"no_display":false,"translator":{},"encode_directives":true,"directives_url":"'.$baseurl.'evolved/cms_wysiwyg/directive/","popup_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/dialog.css","content_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/content.css","width":"100%","plugins":[{"name":"magentovariable","src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentovariable/editor_plugin.js","options":{"title":"Insert Variable...","url":"'.$baseurl.'evolved/system_variable/wysiwygPlugin/","onclick":{"search":["html_id"],"subject":"MagentovariablePlugin.loadChooser(\''.$baseurl.'evolved/system_variable/wysiwygPlugin/\', \'{{html_id}}\');"},"class":"add-variable plugin"}}],"directives_url_quoted":"'.$baseurl.'evolved/cms_wysiwyg/directive/","files_browser_window_url":"'.$baseurl.'idealAdmin/cms_wysiwyg_images/index/","files_browser_window_width":1000,"files_browser_window_height":600,"widget_plugin_src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentowidget/editor_plugin.js","widget_images_url":"'.$siteurl.'skin/adminhtml/default/default/images/widget/","widget_placeholders":["Thumbs.db","catalog__category_widget_link.gif","catalog__product_widget_link.gif","catalog__product_widget_new.gif","cms__widget_block.gif","cms__widget_page_link.gif","default.gif","reports__product_widget_compared.gif","reports__product_widget_viewed.gif"],"widget_window_url":"'.$baseurl.'evolved/widget/index/","firebug_warning_title":"Warning","firebug_warning_text":"Firebug is known to make the WYSIWYG editor slow unless it is turned off or configured properly.","firebug_warning_anchor":"Hide"});';
      						$str = $str . 'editorFormValidationHandler = wysiwyghomepage_element_8_sixteen_one_style_image.onFormValidation.bind(wysiwyghomepage_element_8_sixteen_one_style_image);';
      						$str = $str . 'Event.observe("togglehomepage_element_8_sixteen_one_style_image", "click", wysiwyghomepage_element_8_sixteen_one_style_image.toggle.bind(wysiwyghomepage_element_8_sixteen_one_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("formSubmit", editorFormValidationHandler);';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceBeforeSetContent", wysiwyghomepage_element_8_sixteen_one_style_image.beforeSetContent.bind(wysiwyghomepage_element_8_sixteen_one_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceSaveContent", wysiwyghomepage_element_8_sixteen_one_style_image.saveContent.bind(wysiwyghomepage_element_8_sixteen_one_style_image));';
      						$str = $str . 'varienGlobalEvents.clearEventHandlers("open_browser_callback");';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("open_browser_callback", wysiwyghomepage_element_8_sixteen_one_style_image.openFileBrowser.bind(wysiwyghomepage_element_8_sixteen_one_style_image));';
      						$str = $str . '</script>';
      						$str = $str . '</tr>';
      						$str = $str . '</tbody>';
      						$str = $str . '</table>'; 
      						$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelement" style="display: table-cell;">';
							$str = $str . '<tbody>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_sixteen_two_style_title">Title:</label></td>';  
      						$str = $str . '<td class="value"><input id="homepage_element_8_sixteen_two_style_title" value="'.$collectiondata['homepage_element_8_sixteen_two_style_title'].'" name="homepage_element_8_25_percentage_258_by_170_four_boxes_width[homepage_element_8_sixteen_two_style_title]"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_sixteen_two_style_link">Link:</label></td>';
      						$str = $str . '<td class="value"><input id="homepage_element_8_sixteen_two_style_link" value="'.$collectiondata['homepage_element_8_sixteen_two_style_link'].'" name="homepage_element_8_25_percentage_258_by_170_four_boxes_width[homepage_element_8_sixteen_two_style_link]"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_sixteen_two_style_target">Target:</label></td>';
      						$str = $str . '<td class="value">';
      						$str = $str . '<select id="homepage_element_8_sixteen_two_style_target" name="homepage_element_8_25_percentage_258_by_170_four_boxes_width[homepage_element_8_sixteen_two_style_target]" >';
      						foreach($targetarr as $targetarrkey => $targetarrvalue)
      						{
      							if($collectiondata['homepage_element_8_sixteen_two_style_target']==$targetarrkey)
      							{
      								$str = $str . '<option value='.$targetarrkey.' selected>'.$targetarrvalue.'</option>';
      							}
      							else
      							{
      								$str = $str . '<option value='.$targetarrkey.'>'.$targetarrvalue.'</option>';
      							}
      						}
      						$str = $str . '</select>';
      						$str = $str . '</td>';
      						$str = $str . '</tr>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_sixteen_two_style_image">Image:</label></td>';
      						//$str = $str . '<td class="value"><div id="buttonshomepage_element_8_sixteen_two_style_image" class="buttons-set"><button type="button" class="scalable show-hide" style="" id="togglehomepage_element_8_sixteen_two_style_image"><span><span><span>Show / Hide Editor</span></span></span></button><button type="button" class="scalable add-widget plugin" onclick="widgetTools.openDialog('.$baseurl.'evolved/widget/index/widget_target_id/homepage_element_8_sixteen_two_style_image)" style=""><span><span><span>Insert Widget...</span></span></span></button><button type="button" class="scalable add-image plugin" onclick="MediabrowserUtility.openDialog('.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_8_sixteen_two_style_image/)" style=""><span><span><span>Insert Image...</span></span></span></button><button type="button" class="scalable add-variable plugin" onclick="MagentovariablePlugin.loadChooser('.$baseurl.'evolved/system_variable/wysiwygPlugin/, homepage_element_8_sixteen_two_style_image);"><span><span><span>Insert Variable...</span></span></span></button></div><textarea name="homepage_element_8_sixteen_two_style_image" title="" id="homepage_element_8_sixteen_two_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_8_sixteen_two_style_image'].'</textarea><small>Image size must be 1920*480 pixels</small></td>';
      						$str = $str . '<td class="value"><button id="togglehomepage_element_8_sixteen_two_style_image" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><div id="buttonshomepage_element_8_sixteen_two_style_image" class="buttons-set"><button style="" onclick="MediabrowserUtility.openDialog(\''.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_8_sixteen_two_style_image/\')" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button></div><textarea name="homepage_element_8_25_percentage_258_by_170_four_boxes_width[homepage_element_8_sixteen_two_style_image]" title="" id="homepage_element_8_sixteen_two_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_8_sixteen_two_style_image'].'</textarea><small>Image size must be 258*170 pixels</small></td>';
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
      						$str = $str . '}wysiwyghomepage_element_8_sixteen_two_style_image = new tinyMceWysiwygSetup("homepage_element_8_sixteen_two_style_image", {"enabled":true,"hidden":true,"use_container":false,"add_variables":true,"add_widgets":true,"add_images":true,"no_display":false,"translator":{},"encode_directives":true,"directives_url":"'.$baseurl.'evolved/cms_wysiwyg/directive/","popup_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/dialog.css","content_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/content.css","width":"100%","plugins":[{"name":"magentovariable","src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentovariable/editor_plugin.js","options":{"title":"Insert Variable...","url":"'.$baseurl.'evolved/system_variable/wysiwygPlugin/","onclick":{"search":["html_id"],"subject":"MagentovariablePlugin.loadChooser(\''.$baseurl.'evolved/system_variable/wysiwygPlugin/\', \'{{html_id}}\');"},"class":"add-variable plugin"}}],"directives_url_quoted":"'.$baseurl.'evolved/cms_wysiwyg/directive/","files_browser_window_url":"'.$baseurl.'idealAdmin/cms_wysiwyg_images/index/","files_browser_window_width":1000,"files_browser_window_height":600,"widget_plugin_src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentowidget/editor_plugin.js","widget_images_url":"'.$siteurl.'skin/adminhtml/default/default/images/widget/","widget_placeholders":["Thumbs.db","catalog__category_widget_link.gif","catalog__product_widget_link.gif","catalog__product_widget_new.gif","cms__widget_block.gif","cms__widget_page_link.gif","default.gif","reports__product_widget_compared.gif","reports__product_widget_viewed.gif"],"widget_window_url":"'.$baseurl.'evolved/widget/index/","firebug_warning_title":"Warning","firebug_warning_text":"Firebug is known to make the WYSIWYG editor slow unless it is turned off or configured properly.","firebug_warning_anchor":"Hide"});';
      						$str = $str . 'editorFormValidationHandler = wysiwyghomepage_element_8_sixteen_two_style_image.onFormValidation.bind(wysiwyghomepage_element_8_sixteen_two_style_image);';
      						$str = $str . 'Event.observe("togglehomepage_element_8_sixteen_two_style_image", "click", wysiwyghomepage_element_8_sixteen_two_style_image.toggle.bind(wysiwyghomepage_element_8_sixteen_two_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("formSubmit", editorFormValidationHandler);';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceBeforeSetContent", wysiwyghomepage_element_8_sixteen_two_style_image.beforeSetContent.bind(wysiwyghomepage_element_8_sixteen_two_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceSaveContent", wysiwyghomepage_element_8_sixteen_two_style_image.saveContent.bind(wysiwyghomepage_element_8_sixteen_two_style_image));';
      						$str = $str . 'varienGlobalEvents.clearEventHandlers("open_browser_callback");';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("open_browser_callback", wysiwyghomepage_element_8_sixteen_two_style_image.openFileBrowser.bind(wysiwyghomepage_element_8_sixteen_two_style_image));';
      						$str = $str . '</script>';
      						$str = $str . '</tr>';
      						$str = $str . '</tbody>';
      						$str = $str . '</table>';
      						$str = $str . '<table cellspacing="0" class="form-list allpageelement" style="display: table-cell;">';
							$str = $str . '<tbody>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_sixteen_three_style_title">Title:</label></td>';  
      						$str = $str . '<td class="value"><input id="homepage_element_8_sixteen_three_style_title" value="'.$collectiondata['homepage_element_8_sixteen_three_style_title'].'" name="homepage_element_8_25_percentage_258_by_170_four_boxes_width[homepage_element_8_sixteen_three_style_title]"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_sixteen_three_style_link">Link:</label></td>';
      						$str = $str . '<td class="value"><input id="homepage_element_8_sixteen_three_style_link" value="'.$collectiondata['homepage_element_8_sixteen_three_style_link'].'" name="homepage_element_8_25_percentage_258_by_170_four_boxes_width[homepage_element_8_sixteen_three_style_link]"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_sixteen_three_style_target">Target:</label></td>';
      						$str = $str . '<td class="value">';
      						$str = $str . '<select id="homepage_element_8_sixteen_three_style_target" name="homepage_element_8_25_percentage_258_by_170_four_boxes_width[homepage_element_8_sixteen_three_style_target]" >';
      						foreach($targetarr as $targetarrkey => $targetarrvalue)
      						{
      							if($collectiondata['homepage_element_8_sixteen_three_style_target']==$targetarrkey)
      							{
      								$str = $str . '<option value='.$targetarrkey.' selected>'.$targetarrvalue.'</option>';
      							}
      							else
      							{
      								$str = $str . '<option value='.$targetarrkey.'>'.$targetarrvalue.'</option>';
      							}
      						}
      						$str = $str . '</select>';
      						$str = $str . '</td>';
      						$str = $str . '</tr>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_sixteen_three_style_image">Image:</label></td>';
      						//$str = $str . '<td class="value"><div id="buttonshomepage_element_8_sixteen_three_style_image" class="buttons-set"><button type="button" class="scalable show-hide" style="" id="togglehomepage_element_8_sixteen_three_style_image"><span><span><span>Show / Hide Editor</span></span></span></button><button type="button" class="scalable add-widget plugin" onclick="widgetTools.openDialog('.$baseurl.'evolved/widget/index/widget_target_id/homepage_element_8_sixteen_three_style_image)" style=""><span><span><span>Insert Widget...</span></span></span></button><button type="button" class="scalable add-image plugin" onclick="MediabrowserUtility.openDialog('.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_8_sixteen_three_style_image/)" style=""><span><span><span>Insert Image...</span></span></span></button><button type="button" class="scalable add-variable plugin" onclick="MagentovariablePlugin.loadChooser('.$baseurl.'evolved/system_variable/wysiwygPlugin/, homepage_element_8_sixteen_three_style_image);"><span><span><span>Insert Variable...</span></span></span></button></div><textarea name="homepage_element_8_sixteen_three_style_image" title="" id="homepage_element_8_sixteen_three_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_8_sixteen_three_style_image'].'</textarea><small>Image size must be 1920*480 pixels</small></td>';
      						$str = $str . '<td class="value"><button id="togglehomepage_element_8_sixteen_three_style_image" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><div id="buttonshomepage_element_8_sixteen_three_style_image" class="buttons-set"><button style="" onclick="MediabrowserUtility.openDialog(\''.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_8_sixteen_three_style_image/\')" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button></div><textarea name="homepage_element_8_25_percentage_258_by_170_four_boxes_width[homepage_element_8_sixteen_three_style_image]" title="" id="homepage_element_8_sixteen_three_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_8_sixteen_three_style_image'].'</textarea><small>Image size must be 258*170 pixels</small></td>';
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
      						$str = $str . '}wysiwyghomepage_element_8_sixteen_three_style_image = new tinyMceWysiwygSetup("homepage_element_8_sixteen_three_style_image", {"enabled":true,"hidden":true,"use_container":false,"add_variables":true,"add_widgets":true,"add_images":true,"no_display":false,"translator":{},"encode_directives":true,"directives_url":"'.$baseurl.'evolved/cms_wysiwyg/directive/","popup_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/dialog.css","content_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/content.css","width":"100%","plugins":[{"name":"magentovariable","src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentovariable/editor_plugin.js","options":{"title":"Insert Variable...","url":"'.$baseurl.'evolved/system_variable/wysiwygPlugin/","onclick":{"search":["html_id"],"subject":"MagentovariablePlugin.loadChooser(\''.$baseurl.'evolved/system_variable/wysiwygPlugin/\', \'{{html_id}}\');"},"class":"add-variable plugin"}}],"directives_url_quoted":"'.$baseurl.'evolved/cms_wysiwyg/directive/","files_browser_window_url":"'.$baseurl.'idealAdmin/cms_wysiwyg_images/index/","files_browser_window_width":1000,"files_browser_window_height":600,"widget_plugin_src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentowidget/editor_plugin.js","widget_images_url":"'.$siteurl.'skin/adminhtml/default/default/images/widget/","widget_placeholders":["Thumbs.db","catalog__category_widget_link.gif","catalog__product_widget_link.gif","catalog__product_widget_new.gif","cms__widget_block.gif","cms__widget_page_link.gif","default.gif","reports__product_widget_compared.gif","reports__product_widget_viewed.gif"],"widget_window_url":"'.$baseurl.'evolved/widget/index/","firebug_warning_title":"Warning","firebug_warning_text":"Firebug is known to make the WYSIWYG editor slow unless it is turned off or configured properly.","firebug_warning_anchor":"Hide"});';
      						$str = $str . 'editorFormValidationHandler = wysiwyghomepage_element_8_sixteen_three_style_image.onFormValidation.bind(wysiwyghomepage_element_8_sixteen_three_style_image);';
      						$str = $str . 'Event.observe("togglehomepage_element_8_sixteen_three_style_image", "click", wysiwyghomepage_element_8_sixteen_three_style_image.toggle.bind(wysiwyghomepage_element_8_sixteen_three_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("formSubmit", editorFormValidationHandler);';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceBeforeSetContent", wysiwyghomepage_element_8_sixteen_three_style_image.beforeSetContent.bind(wysiwyghomepage_element_8_sixteen_three_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceSaveContent", wysiwyghomepage_element_8_sixteen_three_style_image.saveContent.bind(wysiwyghomepage_element_8_sixteen_three_style_image));';
      						$str = $str . 'varienGlobalEvents.clearEventHandlers("open_browser_callback");';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("open_browser_callback", wysiwyghomepage_element_8_sixteen_three_style_image.openFileBrowser.bind(wysiwyghomepage_element_8_sixteen_three_style_image));';
      						$str = $str . '</script>';
      						$str = $str . '</tr>';
      						$str = $str . '</tbody>';
      						$str = $str . '</table>';
      						$str = $str . '<table cellspacing="0" class="form-list allpageelement" style="display: table-cell;">';
							$str = $str . '<tbody>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_sixteen_four_style_title">Title:</label></td>';  
      						$str = $str . '<td class="value"><input id="homepage_element_8_sixteen_four_style_title" value="'.$collectiondata['homepage_element_8_sixteen_four_style_title'].'" name="homepage_element_8_25_percentage_258_by_170_four_boxes_width[homepage_element_8_sixteen_four_style_title]"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_sixteen_four_style_link">Link:</label></td>';
      						$str = $str . '<td class="value"><input id="homepage_element_8_sixteen_four_style_link" value="'.$collectiondata['homepage_element_8_sixteen_four_style_link'].'" name="homepage_element_8_25_percentage_258_by_170_four_boxes_width[homepage_element_8_sixteen_four_style_link]"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_sixteen_four_style_target">Target:</label></td>';
      						$str = $str . '<td class="value">';
      						$str = $str . '<select id="homepage_element_8_sixteen_four_style_target" name="homepage_element_8_25_percentage_258_by_170_four_boxes_width[homepage_element_8_sixteen_four_style_target]" >';
      						foreach($targetarr as $targetarrkey => $targetarrvalue)
      						{
      							if($collectiondata['homepage_element_8_sixteen_four_style_target']==$targetarrkey)
      							{
      								$str = $str . '<option value='.$targetarrkey.' selected>'.$targetarrvalue.'</option>';
      							}
      							else
      							{
      								$str = $str . '<option value='.$targetarrkey.'>'.$targetarrvalue.'</option>';
      							}
      						}
      						$str = $str . '</select>';
      						$str = $str . '</td>';
      						$str = $str . '</tr>';
							$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_sixteen_four_style_image">Image:</label></td>';
      						//$str = $str . '<td class="value"><div id="buttonshomepage_element_8_sixteen_four_style_image" class="buttons-set"><button type="button" class="scalable show-hide" style="" id="togglehomepage_element_8_sixteen_four_style_image"><span><span><span>Show / Hide Editor</span></span></span></button><button type="button" class="scalable add-widget plugin" onclick="widgetTools.openDialog('.$baseurl.'evolved/widget/index/widget_target_id/homepage_element_8_sixteen_four_style_image)" style=""><span><span><span>Insert Widget...</span></span></span></button><button type="button" class="scalable add-image plugin" onclick="MediabrowserUtility.openDialog('.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_8_sixteen_four_style_image/)" style=""><span><span><span>Insert Image...</span></span></span></button><button type="button" class="scalable add-variable plugin" onclick="MagentovariablePlugin.loadChooser('.$baseurl.'evolved/system_variable/wysiwygPlugin/, homepage_element_8_sixteen_four_style_image);"><span><span><span>Insert Variable...</span></span></span></button></div><textarea name="homepage_element_8_sixteen_four_style_image" title="" id="homepage_element_8_sixteen_four_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_8_sixteen_four_style_image'].'</textarea><small>Image size must be 1920*480 pixels</small></td>';
      						$str = $str . '<td class="value"><button id="togglehomepage_element_8_sixteen_four_style_image" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><div id="buttonshomepage_element_8_sixteen_four_style_image" class="buttons-set"><button style="" onclick="MediabrowserUtility.openDialog(\''.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_8_sixteen_four_style_image/\')" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button></div><textarea name="homepage_element_8_25_percentage_258_by_170_four_boxes_width[homepage_element_8_sixteen_four_style_image]" title="" id="homepage_element_8_sixteen_four_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_8_sixteen_four_style_image'].'</textarea><small>Image size must be 258*170 pixels</small></td>';
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
      						$str = $str . '}wysiwyghomepage_element_8_sixteen_four_style_image = new tinyMceWysiwygSetup("homepage_element_8_sixteen_four_style_image", {"enabled":true,"hidden":true,"use_container":false,"add_variables":true,"add_widgets":true,"add_images":true,"no_display":false,"translator":{},"encode_directives":true,"directives_url":"'.$baseurl.'evolved/cms_wysiwyg/directive/","popup_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/dialog.css","content_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/content.css","width":"100%","plugins":[{"name":"magentovariable","src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentovariable/editor_plugin.js","options":{"title":"Insert Variable...","url":"'.$baseurl.'evolved/system_variable/wysiwygPlugin/","onclick":{"search":["html_id"],"subject":"MagentovariablePlugin.loadChooser(\''.$baseurl.'evolved/system_variable/wysiwygPlugin/\', \'{{html_id}}\');"},"class":"add-variable plugin"}}],"directives_url_quoted":"'.$baseurl.'evolved/cms_wysiwyg/directive/","files_browser_window_url":"'.$baseurl.'idealAdmin/cms_wysiwyg_images/index/","files_browser_window_width":1000,"files_browser_window_height":600,"widget_plugin_src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentowidget/editor_plugin.js","widget_images_url":"'.$siteurl.'skin/adminhtml/default/default/images/widget/","widget_placeholders":["Thumbs.db","catalog__category_widget_link.gif","catalog__product_widget_link.gif","catalog__product_widget_new.gif","cms__widget_block.gif","cms__widget_page_link.gif","default.gif","reports__product_widget_compared.gif","reports__product_widget_viewed.gif"],"widget_window_url":"'.$baseurl.'evolved/widget/index/","firebug_warning_title":"Warning","firebug_warning_text":"Firebug is known to make the WYSIWYG editor slow unless it is turned off or configured properly.","firebug_warning_anchor":"Hide"});';
      						$str = $str . 'editorFormValidationHandler = wysiwyghomepage_element_8_sixteen_four_style_image.onFormValidation.bind(wysiwyghomepage_element_8_sixteen_four_style_image);';
      						$str = $str . 'Event.observe("togglehomepage_element_8_sixteen_four_style_image", "click", wysiwyghomepage_element_8_sixteen_four_style_image.toggle.bind(wysiwyghomepage_element_8_sixteen_four_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("formSubmit", editorFormValidationHandler);';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceBeforeSetContent", wysiwyghomepage_element_8_sixteen_four_style_image.beforeSetContent.bind(wysiwyghomepage_element_8_sixteen_four_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceSaveContent", wysiwyghomepage_element_8_sixteen_four_style_image.saveContent.bind(wysiwyghomepage_element_8_sixteen_four_style_image));';
      						$str = $str . 'varienGlobalEvents.clearEventHandlers("open_browser_callback");';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("open_browser_callback", wysiwyghomepage_element_8_sixteen_four_style_image.openFileBrowser.bind(wysiwyghomepage_element_8_sixteen_four_style_image));';
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
      						if($selectElement == 'homepage_element_8_show_newarrival_product')
      						{
      							$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="homepage_element_8_show_newarrival_product" style="display: block">';
      						}
      						else
      						{
      							$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="homepage_element_8_show_newarrival_product"  style="display: none">';
      						}
      						$newarrival = array(0=>'No', 1=>'Yes');
      						//$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="33_percentage_left_50_percentage_right_boxes_right_updown_width">';
      						$str = $str . '<tbody>';
      						$str = $str . '<tr>';
      						$str = $str . '<td>';
      						$str = $str . '<table cellspacing="0" class="form-list allpageelement" style="display: table-cell;">';
      						$str = $str . '<tbody>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_newarrival_enabled">Show New Arrival:</label></td>';
      						$str = $str . '<td class="value">';
      						$str = $str . '<select class=" select" name="homepage_element_8_show_newarrival_product[homepage_element_8_newarrival_enabled]" id="homepage_element_8_newarrival_enabled">';
      						foreach($newarrival as $newarrivalkey => $newarrivalvalue)
      						{
      							if($collectiondata["homepage_element_8_newarrival_enabled"] == $newarrivalkey)
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
      						if($selectElement == 'homepage_element_8_show_special_product')
      						{
      							$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="homepage_element_8_show_special_product" style="display: block">';
      						}
      						else
      						{
      							$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="homepage_element_8_show_special_product"  style="display: none">';
      						}
      						$special = array(0=>'No', 1=>'Yes');
      						//$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="33_percentage_left_50_percentage_right_boxes_right_updown_width">';
      						$str = $str . '<tbody>';
      						$str = $str . '<tr>';
      						$str = $str . '<td>';
      						$str = $str . '<table cellspacing="0" class="form-list allpageelement" style="display: table-cell;">';
      						$str = $str . '<tbody>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_special_enabled">Show Special :</label></td>';
      						$str = $str . '<td class="value">';
      						$str = $str . '<select class=" select" name="homepage_element_8_show_special_product[homepage_element_8_special_enabled]" id="homepage_element_8_special_enabled">';
      						foreach($special as $specialkey => $specialvalue)
      						{
      							if($collectiondata["homepage_element_8_special_enabled"] == $specialkey)
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
      						if($selectElement == 'homepage_element_8_show_bestsellers_product')
      						{
      							$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="homepage_element_8_show_bestsellers_product" style="display: block">';
      						}
      						else
      						{
      							$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="homepage_element_8_show_bestsellers_product"  style="display: none">';
      						}
      						$bestsellers = array(0=>'No', 1=>'Yes');
      						//$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="33_percentage_left_50_percentage_right_boxes_right_updown_width">';
      						$str = $str . '<tbody>';
      						$str = $str . '<tr>';
      						$str = $str . '<td>';
      						$str = $str . '<table cellspacing="0" class="form-list allpageelement" style="display: table-cell;">';
      						$str = $str . '<tbody>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_bestsellers_enabled">Show Best Sellers :</label></td>';
      						$str = $str . '<td class="value">';
      						$str = $str . '<select class=" select" name="homepage_element_8_show_bestsellers_product[homepage_element_8_bestsellers_enabled]" id="homepage_element_8_bestsellers_enabled">';
      						foreach($bestsellers as $bestsellerskey => $bestsellersvalue)
      						{
      							if($collectiondata["homepage_element_8_bestsellers_enabled"] == $bestsellerskey)
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
      						if($selectElement == 'homepage_element_8_show_mostviewed_product')
      						{
      							$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="homepage_element_8_show_mostviewed_product" style="display: block">';
      						}
      						else
      						{
      							$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="homepage_element_8_show_mostviewed_product"  style="display: none">';
      						}
      						$mostviewed = array(0=>'No', 1=>'Yes');
      						//$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="33_percentage_left_50_percentage_right_boxes_right_updown_width">';
      						$str = $str . '<tbody>';
      						$str = $str . '<tr>';
      						$str = $str . '<td>';
      						$str = $str . '<table cellspacing="0" class="form-list allpageelement" style="display: table-cell;">';
      						$str = $str . '<tbody>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_mostviewed_enabled">Show Most Viewed :</label></td>';
      						$str = $str . '<td class="value">';
      						$str = $str . '<select class=" select" name="homepage_element_8_show_mostviewed_product[homepage_element_8_mostviewed_enabled]" id="homepage_element_8_mostviewed_enabled">';
      						foreach($mostviewed as $mostviewedkey => $mostviewedvalue)
      						{
      							if($collectiondata["homepage_element_8_mostviewed_enabled"] == $mostviewedkey)
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
      						if($selectElement == 'homepage_element_8_show_featured_product')
      						{
      							$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="homepage_element_8_show_featured_product" style="display: block">';
      						}
      						else
      						{
      							$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="homepage_element_8_show_featured_product"  style="display: none">';
      						}
      						//$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="33_percentage_left_50_percentage_right_boxes_right_updown_width">';
      						$str = $str . '<tbody>';
							$str = $str . '<tr>';
							$str = $str . '<td>';
							$str = $str . '<table cellspacing="0" class="form-list"><tbody>';
							$str = $str . '<tr>';
							$str = $str . '<td class="label"><label for="homepage_element_8_show_featured_product_name_enabled">Show Product Name:</label></td>';
							$str = $str . '<td class="value">';
							$str = $str . '<select class=" select" name="homepage_element_8_show_featured_product[homepage_element_8_show_featured_product_name_enabled]" id="homepage_element_8_show_featured_product_name_enabled">';
							$featuretabproductname = array(0=>'No', 1=>'Yes');
							foreach($featuretabproductname as $featuretabproductnamekey => $featuretabproductnamevalue)
							{
								if($collectiondata["homepage_element_8_show_featured_product_name_enabled"] == $featuretabproductnamekey)
								{
									$str = $str . '<option value="'.$featuretabproductnamekey.'" selected="selected">'.$featuretabproductnamevalue.'</option>';
								}
								else
								{
									$str = $str . '<option value="'.$featuretabproductnamekey.'">'.$featuretabproductnamevalue.'</option>';
								}
							}
							$str = $str . '</select>';
							$str = $str . '</td>';
							$str = $str . '</tr>';
							$str = $str . '<tr>';
							$str = $str . '<td class="label"><label for="homepage_element_8_show_featured_product_price_enabled">Show Product Price:</label></td>';
							$str = $str . '<td class="value">';
							$str = $str . '<select class=" select" name="homepage_element_8_show_featured_product[homepage_element_8_show_featured_product_price_enabled]" id="homepage_element_8_show_featured_product_price_enabled">';
							$featuretabproductprice = array(0=>'No', 1=>'Yes');
							foreach($featuretabproductprice as $featuretabproductpricekey => $featuretabproductpricevalue)
							{
								if($collectiondata["homepage_element_8_show_featured_product_price_enabled"] == $featuretabproductpricekey)
								{
									$str = $str . '<option value="'.$featuretabproductpricekey.'" selected="selected">'.$featuretabproductpricevalue.'</option>';
								}
								else
								{
									$str = $str . '<option value="'.$featuretabproductpricekey.'">'.$featuretabproductpricevalue.'</option>';
								}
							}
							$str = $str . '</select>';
							$str = $str . '</td>';
							$str = $str . '</tr>';
							$str = $str . '<tr>';
							$str = $str . '<td class="label"><label for="homepage_element_8_show_featured_product_visible_product">Show Visible Product:</label></td>';
							$str = $str . '<td class="value">';
							$str = $str . '<input type="text" name="homepage_element_8_show_featured_product[homepage_element_8_show_featured_product_visible_product]" value="'.$collectiondata["homepage_element_8_show_featured_product_visible_product"].'" style="width: 50px; " />';
							$str = $str . '</td>';
							$str = $str . '</tr>';
							$str = $str . '<tr>';
							$str = $str . '<td class="label"><label for="homepage_element_8_show_featured_product_button_text">Show Product Button Text:</label></td>';
							$str = $str . '<td class="value">';
							$str = $str . '<input type="text" name="homepage_element_8_show_featured_product[homepage_element_8_show_featured_product_button_text]" value="'.$collectiondata["homepage_element_8_show_featured_product_button_text"].'" style="width: 150px; " />';
							$str = $str . '</td>';
							$str = $str . '</tr>';
							$str = $str . '<tr>';
							$str = $str . '<td class="label"><label for="homepage_element_8_show_featured_product_button_image_size">Show Product Image Size:</label></td>';
							$str = $str . '<td class="value">';
							$str = $str . '<label for="homepage_element_8_show_featured_product_button_image_size_width">Width : </label><input type="text" name="homepage_element_8_show_featured_product[homepage_element_8_show_featured_product_button_image_size_width]" value="'.$collectiondata["homepage_element_8_show_featured_product_button_image_size_width"].'" style="width: 60px; margin-right: 2px; " />px';
							$str = $str . '<label for="homepage_element_8_show_featured_product_button_image_size_height" style="margin-left: 15px; ">Height : </label><input type="text" name="homepage_element_8_show_featured_product[homepage_element_8_show_featured_product_button_image_size_height]" value="'.$collectiondata["homepage_element_8_show_featured_product_button_image_size_height"].'" style="width: 60px; margin-right: 2px; " />px';
							$str = $str . '</td>';
							$str = $str . '</tr>';							
							$str = $str . '<tr>';
							$str = $str . '<td class="label"><label for="homepage_element_8_show_featured_product_button_url">Show Product Button Url:</label></td>';
							$str = $str . '<td class="value">';
							$buttonurlval = array('cart'=>'Cart', 'view'=>'View');
							$str = $str . '<select class=" select homepage_element_show_featured_product" name="homepage_element_8_show_featured_product[homepage_element_8_show_featured_product_button_url]" id="homepage_element_8_show_featured_product_button_url">';
							foreach($buttonurlval as $buttonurlvalkey => $buttonurlvalvalue)
							{
								if($collectiondata["homepage_element_8_show_featured_product_button_url"] == $buttonurlvalkey)
								{
									$str = $str . '<option value="'.$buttonurlvalkey.'" selected="selected">'.$buttonurlvalvalue.'</option>';
								}
								else
								{
									$str = $str . '<option value="'.$buttonurlvalkey.'">'.$buttonurlvalvalue.'</option>';
								}
							}
							$str = $str . '</select>';
							$str = $str . '</td>';
							$str = $str . '</tr>';
							$str = $str . '</tbody></table>';
							$str = $str . '</td>';
							$str = $str . '</tr>';
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
      						$str = $str . '<td class="label"><label for="homepage_element_8_newarrival_enabled">Show New Arrival:</label></td>';
      						$str = $str . '<td class="value">';
      						$str = $str . '<select class=" select homepage_element_show_featured_product" name="homepage_element_8_show_featured_product[homepage_element_8_newarrival_enabled]" id="homepage_element_8_newarrival_enabled">';
      						foreach($newarrival as $newarrivalkey => $newarrivalvalue)
      						{
      							if($collectiondata["homepage_element_8_newarrival_enabled"] == $newarrivalkey)
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
      						$str = $str . '<tr class="homepage_element_8_newarrival_enabled">';
      						$str = $str . '<td class="label"><label for="homepage_element_8_show_featured_product_newarrival_title">New Arrival Title:</label></td>';
      						$str = $str . '<td class="value">';
      						if($collectiondata["homepage_element_8_show_featured_product_newarrival_title"] == "")
      						{
      							$collectiondata["homepage_element_8_show_featured_product_newarrival_title"] = "New Arrival";
      						}
      						$str = $str . '<input type="text" name="homepage_element_8_show_featured_product[homepage_element_8_show_featured_product_newarrival_title]" value="'.$collectiondata["homepage_element_8_show_featured_product_newarrival_title"].'" style="width: 150px; " />';
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
      						$str = $str . '<td class="label"><label for="homepage_element_8_special_enabled">Show Special :</label></td>';
      						$str = $str . '<td class="value">';
      						$str = $str . '<select class=" select homepage_element_show_featured_product" name="homepage_element_8_show_featured_product[homepage_element_8_special_enabled]" id="homepage_element_8_special_enabled">';
      						foreach($special as $specialkey => $specialvalue)
      						{
      							if($collectiondata["homepage_element_8_special_enabled"] == $specialkey)
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
      						$str = $str . '<tr class="homepage_element_8_special_enabled">';
      						$str = $str . '<td class="label"><label for="homepage_element_8_show_featured_product_special_title">Special Title:</label></td>';
      						$str = $str . '<td class="value">';
      						if($collectiondata["homepage_element_8_show_featured_product_special_title"] == "")
      						{
      							$collectiondata["homepage_element_8_show_featured_product_special_title"] = "Special";
      						}
      						$str = $str . '<input type="text" name="homepage_element_8_show_featured_product[homepage_element_8_show_featured_product_special_title]" value="'.$collectiondata["homepage_element_8_show_featured_product_special_title"].'" style="width: 150px; " />';
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
      						$str = $str . '<td class="label"><label for="homepage_element_8_bestsellers_enabled">Show Best Sellers :</label></td>';
      						$str = $str . '<td class="value">';
      						$str = $str . '<select class=" select homepage_element_show_featured_product" name="homepage_element_8_show_featured_product[homepage_element_8_bestsellers_enabled]" id="homepage_element_8_bestsellers_enabled">';
      						foreach($bestsellers as $bestsellerskey => $bestsellersvalue)
      						{
      							if($collectiondata["homepage_element_8_bestsellers_enabled"] == $bestsellerskey)
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
      						$str = $str . '<tr class="homepage_element_8_bestsellers_enabled">';
      						$str = $str . '<td class="label"><label for="homepage_element_8_show_featured_product_bestsellers_title">Best Sellers Title:</label></td>';
      						$str = $str . '<td class="value">';
      						if($collectiondata["homepage_element_8_show_featured_product_bestsellers_title"] == "")
      						{
      							$collectiondata["homepage_element_8_show_featured_product_bestsellers_title"] = "Best Sellers";
      						}
      						$str = $str . '<input type="text" name="homepage_element_8_show_featured_product[homepage_element_8_show_featured_product_bestsellers_title]" value="'.$collectiondata["homepage_element_8_show_featured_product_bestsellers_title"].'" style="width: 150px; " />';
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
      						$str = $str . '<td class="label"><label for="homepage_element_8_mostviewed_enabled">Show Most Viewed :</label></td>';
      						$str = $str . '<td class="value">';
      						$str = $str . '<select class=" select homepage_element_show_featured_product" name="homepage_element_8_show_featured_product[homepage_element_8_mostviewed_enabled]" id="homepage_element_8_mostviewed_enabled">';
      						foreach($mostviewed as $mostviewedkey => $mostviewedvalue)
      						{
      							if($collectiondata["homepage_element_8_mostviewed_enabled"] == $mostviewedkey)
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
      						$str = $str . '<tr class="homepage_element_8_mostviewed_enabled">';
      						$str = $str . '<td class="label"><label for="homepage_element_8_show_featured_product_mostviewed_title">Most Viewed Title:</label></td>';
      						$str = $str . '<td class="value">';
      						if($collectiondata["homepage_element_8_show_featured_product_mostviewed_title"] == "")
      						{
      							$collectiondata["homepage_element_8_show_featured_product_mostviewed_title"] = "Most Viewed";
      						}
      						$str = $str . '<input type="text" name="homepage_element_8_show_featured_product[homepage_element_8_show_featured_product_mostviewed_title]" value="'.$collectiondata["homepage_element_8_show_featured_product_mostviewed_title"].'" style="width: 150px; " />';
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
      						$featured = array(0=>'No', 1=>'Yes');
      						$str = $str . '<table cellspacing="0" class="form-list allpageelement" style="display: table-cell;">';
      						$str = $str . '<tbody>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_featured_enabled">Show Featured :</label></td>';
      						$str = $str . '<td class="value">';
      						$str = $str . '<select class=" select homepage_element_show_featured_product" name="homepage_element_8_show_featured_product[homepage_element_8_featured_enabled]" id="homepage_element_8_featured_enabled">';
      						foreach($featured as $featuredkey => $featuredvalue)
      						{
      							if($collectiondata["homepage_element_8_featured_enabled"] == $featuredkey)
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
      						$str = $str . '<tr class="homepage_element_8_featured_enabled">';
      						$str = $str . '<td class="label"><label for="homepage_element_8_show_featured_product_featured_title">Featured Title:</label></td>';
      						$str = $str . '<td class="value">';
      						if($collectiondata["homepage_element_8_show_featured_product_featured_title"] == "")
      						{
      							$collectiondata["homepage_element_8_show_featured_product_featured_title"] = "Featured";
      						}
      						$str = $str . '<input type="text" name="homepage_element_8_show_featured_product[homepage_element_8_show_featured_product_featured_title]" value="'.$collectiondata["homepage_element_8_show_featured_product_featured_title"].'" style="width: 150px; " />';
      						$str = $str . '</td>';
      						$str = $str . '</tr>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_featured_category_id">Featured Category:</label></td>';
      						$str = $str . '<td class="value">';
      						$str = $str . '<select class=" select" name="homepage_element_8_show_featured_product[homepage_element_8_featured_category_id]" id="homepage_element_8_featured_category_id">';
      						foreach(Mage::getModel('evolved/category')->toOptionArray() as $featuredcatid => $featuredcatname)
      						{
      							if($collectiondata["homepage_element_8_featured_category_id"] == $featuredcatid)
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
      						
      						
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_show_featured_product_category_link">Show Category Link:</label></td>';
      						$str = $str . '<td class="value">';
      						$str = $str . '<select class=" select" name="homepage_element_8_show_featured_product[homepage_element_8_show_featured_product_category_link]" id="homepage_element_8_show_featured_product_category_link">';
      						$featuretabcategoryname = array(0=>'No', 1=>'Yes');
      						foreach($featuretabcategoryname as $featuretabcategorynamekey => $featuretabcategorynamevalue)
      						{
      							if($collectiondata["homepage_element_8_show_featured_product_category_link"] == $featuretabcategorynamekey)
      							{
      								$str = $str . '<option value="'.$featuretabcategorynamekey.'" selected="selected">'.$featuretabcategorynamevalue.'</option>';
      							}
      							else
      							{
      								$str = $str . '<option value="'.$featuretabcategorynamekey.'">'.$featuretabcategorynamevalue.'</option>';
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
      						if($selectElement == 'homepage_element_8_show_brand_manager')
      						{
      							$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="homepage_element_8_show_brand_manager" style="display: block">';
      						}
      						else
      						{
      							$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="homepage_element_8_show_brand_manager"  style="display: none">';
      						}
      						$brand_manager = array(0=>'No', 1=>'Yes');
      						//$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="33_percentage_left_50_percentage_right_boxes_right_updown_width">';
      						$str = $str . '<tbody>';
      						$str = $str . '<tr>';
      						$str = $str . '<td>';
      						$str = $str . '<table cellspacing="0" class="form-list allpageelement" style="display: table-cell;">';
      						$str = $str . '<tbody>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_brand_manager_enabled">Show Brand Manager :</label></td>';
      						$str = $str . '<td class="value">';
      						$str = $str . '<select class=" select" name="homepage_element_8_show_brand_manager[homepage_element_8_brand_manager_enabled]" id="homepage_element_8_brand_manager_enabled">';
      						foreach($brand_manager as $brand_managerkey => $brand_managervalue)
      						{
      							if($collectiondata["homepage_element_8_brand_manager_enabled"] == $brand_managerkey)
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
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_brand_manager_title">Title</label></td>';
      						$str = $str . '<td class="value">';
      						$str = $str . '<input type="text" class=" input-text" value="'.$collectiondata["homepage_element_8_brand_manager_title"].'" name="homepage_element_8_show_brand_manager[homepage_element_8_brand_manager_title]" id="homepage_element_8_brand_manager_title"></td>';
      						$str = $str . '</tr>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_brand_manager_visiblebrands">Show Visible Brands</label></td>';
      						$str = $str . '<td class="value">';
      						$str = $str . '<input type="text" class=" input-text" value="'.$collectiondata["homepage_element_8_brand_manager_visiblebrands"].'" name="homepage_element_8_show_brand_manager[homepage_element_8_brand_manager_visiblebrands]" id="homepage_element_8_brand_manager_visiblebrands"></td>';
      						$str = $str . '</tr>';
      						$brand_autoscroll = array(0=>'No', 1=>'Yes');
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_brand_manager_autoscroll_enabled">Auto Scroll Enable :</label></td>';
      						$str = $str . '<td class="value">';
      						$str = $str . '<select class=" select" name="homepage_element_8_show_brand_manager[homepage_element_8_brand_manager_autoscroll_enabled]" id="homepage_element_8_brand_manager_autoscroll_enabled">';
      						foreach($brand_autoscroll as $brand_autoscrollkey => $brand_autoscrollvalue)
      						{
      							if($collectiondata["homepage_element_8_brand_manager_autoscroll_enabled"] == $brand_autoscrollkey)
      							{
      								$str = $str . '<option value="'.$brand_autoscrollkey.'" selected="selected">'.$brand_autoscrollvalue.'</option>';
      							}
      							else
      							{
      								$str = $str . '<option value="'.$brand_autoscrollkey.'">'.$brand_autoscrollvalue.'</option>';
      							}
      						}
      						$str = $str . '</select>';
      						$str = $str . '</td>';
      						$str = $str . '</tr>';
      						$brandtargetarr = array(''=>'Please Select','_blank'=>'New','_self'=>'Self');
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_brand_manager_target">Target:</label></td>';
      						$str = $str . '<td class="value">';
      						$str = $str . '<select id="homepage_element_8_brand_manager_target" name="homepage_element_8_show_brand_manager[homepage_element_8_brand_manager_target]" >';
      						foreach($brandtargetarr as $brandtargetarrkey => $brandtargetarrvalue)
      						{
      							if($collectiondata['homepage_element_8_brand_manager_target']==$brandtargetarrkey)
      							{
      								$str = $str . '<option value='.$brandtargetarrkey.' selected>'.$brandtargetarrvalue.'</option>';
      							}
      							else
      							{
      								$str = $str . '<option value='.$brandtargetarrkey.'>'.$brandtargetarrvalue.'</option>';
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
      						if($selectElement == 'homepage_element_8_show_slideshow_banner')
      						{
      							$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="homepage_element_8_show_slideshow_banner" style="display: block">';
      						}
      						else
      						{
      							$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="homepage_element_8_show_slideshow_banner"  style="display: none">';
      						}
      						$slideshow_banner = array(0=>'No', 1=>'Yes');
      						//$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="33_percentage_left_50_percentage_right_boxes_right_updown_width">';
      						$str = $str . '<tbody>';
      						/*$str = $str . '<tr>';
      						$str = $str . '<td>';
      						$str = $str . '<table cellspacing="0" class="form-list allpageelement" style="display: table-cell;">';
      						$str = $str . '<tbody>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_slideshow_banner_enabled">Show Main Banner :</label></td>';
      						$str = $str . '<td class="value">';
      						$str = $str . '<select class=" select" name="homepage_element_8_slideshow_banner_enabled" id="homepage_element_8_slideshow_banner_enabled">';
      						foreach($slideshow_banner as $slideshow_bannerkey => $slideshow_bannervalue)
      						{
      							if($collectiondata["homepage_element_8_slideshow_banner_enabled"] == $slideshow_bannerkey)
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
      						$str = $str . '</tr>';*/
      						
      						$slideshow_banner_style = array(''=>'Please Select','simple'=>'Simple', 'nearby'=>'Nearby');
      						$str = $str . '<tr>';
      						$str = $str . '<td>';
      						$str = $str . '<table cellspacing="0" class="form-list allpageelement" style="display: table-cell;">';
      						$str = $str . '<tbody>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_slideshow_banner_style">Banner Style :</label></td>';
      						$str = $str . '<td class="value">';
      						$str = $str . '<select class=" select" name="homepage_element_8_show_slideshow_banner[homepage_element_8_slideshow_banner_style]" id="homepage_element_8_slideshow_banner_style" onChange="homepageBannerStyle(\'homepage_element_8_slideshow_banner_style\',this.value);">';
      						foreach($slideshow_banner_style as $slideshow_banner_stylekey => $slideshow_banner_stylevalue)
      						{
      							if($collectiondata["homepage_element_8_slideshow_banner_style"] == $slideshow_banner_stylekey)
      							{
      								$str = $str . '<option value="'.$slideshow_banner_stylekey.'" selected="selected">'.$slideshow_banner_stylevalue.'</option>';
      							}
      							else
      							{
      								$str = $str . '<option value="'.$slideshow_banner_stylekey.'">'.$slideshow_banner_stylevalue.'</option>';
      							}
      						}
      						$str = $str . '</select>';
      						$str = $str . '</td>';
      						$str = $str . '</tr>';
      						
      						$str = $str . '<tr>';
      						$str = $str . '<td colspan=2>';
      						if($collectiondata["homepage_element_8_slideshow_banner_style"] == 'nearby')
      						{
      							$str = $str . '<table cellspacing="0" class="form-list allpageelement homepage_element_8_slideshow_banner_style_nearby" style="display: block; ">';      							
      						}
      						else
      						{
      							$str = $str . '<table cellspacing="0" class="form-list allpageelement homepage_element_8_slideshow_banner_style_nearby" style="display: none; ">';
      						}
      						$str = $str . '<tbody>';     						
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_slideshow_banner_style_nearby_width">Width</label></td>';
      						$str = $str . '<td class="value">';
      						$str = $str . '<input type="text" class=" input-text" value="'.$collectiondata["homepage_element_8_slideshow_banner_style_nearby_width"].'" name="homepage_element_8_show_slideshow_banner[homepage_element_8_slideshow_banner_style_nearby_width]" id="homepage_element_8_slideshow_banner_style_nearby_width"></td>';
      						$str = $str . '</tr>';			
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_slideshow_banner_style_nearby_height">Height</label></td>';
      						$str = $str . '<td class="value">';
      						$str = $str . '<input type="text" class=" input-text" value="'.$collectiondata["homepage_element_8_slideshow_banner_style_nearby_height"].'" name="homepage_element_8_show_slideshow_banner[homepage_element_8_slideshow_banner_style_nearby_height]" id="homepage_element_8_slideshow_banner_style_nearby_height"></td>';
      						$str = $str . '</tr>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_slideshow_banner_style_nearby_slidesSpacing">Slides Spacing</label></td>';
      						$str = $str . '<td class="value">';
      						$str = $str . '<input type="text" class=" input-text" value="'.$collectiondata["homepage_element_8_slideshow_banner_style_nearby_slidesSpacing"].'" name="homepage_element_8_show_slideshow_banner[homepage_element_8_slideshow_banner_style_nearby_slidesSpacing]" id="homepage_element_8_slideshow_banner_style_nearby_slidesSpacing"></td>';
      						$str = $str . '</tr>';
      						$str = $str . '</tbody>';
      						$str = $str . '</table>';
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
    	      			{      						//alert('hi');
	      					if($selectElement == 'homepage_element_8_show_diamondrow')
	      					{
	      						$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="homepage_element_8_show_diamondrow" style="display: block">';
	      					}
	      					else
	      					{
	      						$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="homepage_element_8_show_diamondrow"  style="display: none">';
	      					}
	      					$diamondrow = array(0=>'No', 1=>'Yes');
	      					//$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="1920_by_800_banner">';
	      					$str = $str . '<tbody>';
	      					$str = $str . '<tr>';
	      					$str = $str . '<td>';
      						$str = $str . '<table cellspacing="0" class="form-list allpageelement">';
							$str = $str . '<tbody>';
							/*
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_diamondrow_enabled">Show Diamond row :</label></td>';
      						$str = $str . '<td class="value">';
      						$str = $str . '<select class=" select" name="homepage_element_8_diamondrow_enabled" id="homepage_element_8_diamondrow_enabled">';
      						foreach($diamondrow as $diamondrowkey => $diamondrowvalue)
      						{
      							if($collectiondata["homepage_element_8_diamondrow_enabled"] == $diamondrowkey)
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
      						*/
							$str = $str . '<tr>';
							$str = $str . '<td class="label"><label for="homepage_element_8_diamondrow_style_background_image">Background Image:</label></td>';
							$str = $str . '<td class="value">';
//							echo $collectiondata["homepage_element_8_diamondrow_style_background_image"]; exit;
							if($collectiondata["homepage_element_8_diamondrow_style_background_image"])
							{
								$str = $str . '<a onclick="imagePreview(\'homepage_element_8_diamondrow_style_background_image_image\'); return false;" href="'.Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA).$collectiondata["homepage_element_8_diamondrow_style_background_image"].'"><img width="22" height="22" class="small-image-preview v-middle" alt="'.$collectiondata["homepage_element_8_diamondrow_style_background_image"].'" title="'.$collectiondata["homepage_element_8_diamondrow_style_background_image"].'" id="homepage_element_8_diamondrow_style_background_image_image" src="'.Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA).$collectiondata["homepage_element_8_diamondrow_style_background_image"].'"></a>';
								$str = $str . '<input type="file" class="input-file" value="'.$collectiondata["homepage_element_8_diamondrow_style_background_image"].'" name="homepage_element_8_show_diamondrow[homepage_element_8_diamondrow_style_background_image]" id="homepage_element_8_diamondrow_style_background_image">';
								$str = $str . '<span class="delete-image"><input type="checkbox" name="homepage_element_8_show_diamondrow[homepage_element_8_diamondrow_style_background_image][delete]" value="1" class="checkbox" id="homepage_element_8_diamondrow_style_background_image_delete"><label for="homepage_element_8_diamondrow_style_background_image_delete"> Delete Image</label><input type="hidden" name="homepage_element_8_show_diamondrow[homepage_element_8_diamondrow_style_background_image][value]" value="'.$collectiondata["homepage_element_8_diamondrow_style_background_image"].'"></span>';
							}
							else
							{
								$str = $str . '<input type="file" class="input-file" value="" name="homepage_element_8_show_diamondrow[homepage_element_8_diamondrow_style_background_image]" id="homepage_element_8_diamondrow_style_background_image">';
							}
							$str = $str . '</td>';
							$str = $str . '</tr>';
							$str = $str . '<tr>';
							$str = $str . '<td class="label"><label for="homepage_element_8_diamondrow_style_background_color">Background color:</label></td>';
							$str = $str . '<td class="value">';
							$str = $str . '<input type="text" class="input-text mColorPicker" value="'.$collectiondata["homepage_element_8_diamondrow_style_background_color"].'" name="homepage_element_8_show_diamondrow[homepage_element_8_diamondrow_style_background_color]" id="homepage_element_8_diamondrow_style_background_color" data-hex="true" style="background-color: '.$collectiondata["homepage_element_8_diamondrow_style_background_color"].'; ">';
							$str = $str . '<span id="mcp_homepage_element_8_diamondrow_style_background_color" class="mColorPickerTrigger" style="display: inline-block; cursor: pointer;">';
							$str = $str . '<img src="'.$siteurl.'js/evolved/mColorPicker/color.png" style="border: 0px none; margin: 0px 0px 0px 3px; vertical-align: text-bottom;">';
							$str = $str . '</span>';
							$str = $str . '</td>';
							$str = $str . '</tr>';
							$str = $str . '<tr>';
							$str = $str . '<td class="label"><label for="homepage_element_8_diamondrow_style_font">Diamond Row Font:</label></td>';
							$str = $str . '<td class="value">';
							$str = $str . '<select name="homepage_element_8_show_diamondrow[homepage_element_8_diamondrow_style_font]" id="homepage_element_8_diamondrow_style_font">';
							$homepage_element_8_diamondrow_style_font_collection = Mage::getModel('evolved/Font')->toOptionArray();
							//echo "<pre>"; print_r($homepage_element_8_diamondrow_style_font_collection); exit;
							$str = $str . '<option value=""></option>';
							foreach($homepage_element_8_diamondrow_style_font_collection as $homepage_element_8_diamondrow_style_font_collection1)
							{
								if($homepage_element_8_diamondrow_style_font_collection1['value'])
								{
									if($homepage_element_8_diamondrow_style_font_collection1['value'] == $collectiondata['homepage_element_8_diamondrow_style_font'])
									{
										$str = $str . '<option value="'.$homepage_element_8_diamondrow_style_font_collection1['value'].'" selected>'.$homepage_element_8_diamondrow_style_font_collection1['label'].'</option>';
									}
									else
									{
										$str = $str . '<option value="'.$homepage_element_8_diamondrow_style_font_collection1['value'].'">'.$homepage_element_8_diamondrow_style_font_collection1['label'].'</option>';									
									}									
								}
							}
							$str = $str . '</select>';
							$str = $str . '<br><div id="athlete_gfont_previewhomepage_element_8_diamondrow_style_font" style="font-size: 20px; margin-top: 5px;">The quick
											brown fox jumps over the lazy dog</div>';
							$str = $str . '<script>
									var googleFontPreviewModelhomepage_element_8_diamondrow_style_font = Class.create();

									googleFontPreviewModelhomepage_element_8_diamondrow_style_font.prototype = {
										initialize : function()
										{
											this.fontElement = $("homepage_element_8_diamondrow_style_font");
											this.previewElement = $("athlete_gfont_previewhomepage_element_8_diamondrow_style_font");
											this.loadedFonts = "";

											this.refreshPreview();
											this.bindFontChange();
										},
										bindFontChange : function()
										{
											Event.observe(this.fontElement, "change", this.refreshPreview.bind(this));
											Event.observe(this.fontElement, "keyup", this.refreshPreview.bind(this));
											Event.observe(this.fontElement, "keydown", this.refreshPreview.bind(this));
										},
										refreshPreview : function()
										{
											if ( this.loadedFonts.indexOf( this.fontElement.value ) > -1 ) {
												this.updateFontFamily();
												return;
											}

											var ss = document.createElement("link");
											ss.type = "text/css";
											ss.rel = "stylesheet";
											ss.href = "//fonts.googleapis.com/css?family=" + this.fontElement.value;
											document.getElementsByTagName("head")[0].appendChild(ss);

											this.updateFontFamily();

											this.loadedFonts += this.fontElement.value + ",";
										},
										updateFontFamily : function()
										{
											$(this.previewElement).setStyle({ fontFamily: this.fontElement[this.fontElement.selectedIndex].text });  
											//$(this.previewElement).setStyle({ fontFamily: this.fontElement.value });
										}
									}
									googleFontPreviewhomepage_element_8_diamondrow_style_font = new googleFontPreviewModelhomepage_element_8_diamondrow_style_font();
									</script>';
							$str = $str . '<p class="note" id="note_homepage_element_8_diamondrow_style_font"><span>Enable google font to use this option</span></p>';
							$str = $str . '</td>';
							$str = $str . '</tr>';
							$str = $str . '<tr>';
							$str = $str . '<td class="label"><label for="homepage_element_8_diamondrow_style_font_color">Font color:</label></td>';
							$str = $str . '<td class="value">';
							$str = $str . '<input type="text" class="input-text mColorPicker" value="'.$collectiondata["homepage_element_8_diamondrow_style_font_color"].'" name="homepage_element_8_show_diamondrow[homepage_element_8_diamondrow_style_font_color]" id="homepage_element_8_diamondrow_style_font_color" data-hex="true" style="background-color: '.$collectiondata["homepage_element_8_diamondrow_style_font_color"].'; ">';
							$str = $str . '<span id="mcp_homepage_element_8_diamondrow_style_font_color" class="mColorPickerTrigger" style="display: inline-block; cursor: pointer;">';
							$str = $str . '<img src="'.$siteurl.'js/evolved/mColorPicker/color.png" style="border: 0px none; margin: 0px 0px 0px 3px; vertical-align: text-bottom;">';
							$str = $str . '</span>';
							$str = $str . '</td>';
							$str = $str . '</tr>';
						

							
							$str = $str . '<tr>';
							$str = $str . '<td class="label"><label for="homepage_element_8_diamondrow_style_content_option">Diamond Shape Content:</label></td>';
							$str = $str . '<td class="value">';
							$diamondstyle = array(''=>'Please Select', 'static'=>'Static', 'dynamic'=>'Dynamic');
							$str = $str . '<select name="homepage_element_8_show_diamondrow[homepage_element_8_diamondrow_style_content_option]" class="homepage_element_8_diamondrow_style_content_option" id="homepage_element_8_diamondrow_style_content_option" onChange="diamondstylecontent(\'homepage_element_8_diamondrow_style_option\',\'homepage_element_8_diamondrow_style_content_option_\'+this.value);">';
							foreach($diamondstyle as $diamondstylekey => $diamondstylevalue)
							{
								if($collectiondata["homepage_element_8_diamondrow_style_content_option"] == $diamondstylekey)
								{
									$str = $str . '<option value="'.$diamondstylekey.'" selected="selected">'.$diamondstylevalue.'</option>';
								}
								else
								{
									$str = $str . '<option value="'.$diamondstylekey.'">'.$diamondstylevalue.'</option>';
								}
							}
							$str = $str . '</select>';
							$str = $str . '</td>';
							$str = $str . '</tr>';
							
	      					if($collectiondata["homepage_element_8_diamondrow_style_content_option"] != "dynamic")
							{
								$str = $str . '<tr class="homepage_element_8_diamondrow_style_content_option_static homepage_element_8_diamondrow_style_option" style=" display: table-row;">';
							}
							else 
							{
								$str = $str . '<tr class="homepage_element_8_diamondrow_style_content_option_static homepage_element_8_diamondrow_style_option" style=" display: none;">';
							}
							$str = $str . '<td class="label"><label for="homepage_element_8_diamondrow_style_button_color">Button Text color:</label></td>';
							$str = $str . '<td class="value">';
							$str = $str . '<input type="text" class="input-text mColorPicker" value="'.$collectiondata["homepage_element_8_diamondrow_style_button_color"].'" name="homepage_element_8_show_diamondrow[homepage_element_8_diamondrow_style_button_color]" id="homepage_element_8_diamondrow_style_button_color" data-hex="true" style="background-color: '.$collectiondata["homepage_element_8_diamondrow_style_button_color"].'; ">';
							$str = $str . '<span id="mcp_homepage_element_8_diamondrow_style_button_color" class="mColorPickerTrigger" style="display: inline-block; cursor: pointer;">';
							$str = $str . '<img src="'.$siteurl.'js/evolved/mColorPicker/color.png" style="border: 0px none; margin: 0px 0px 0px 3px; vertical-align: text-bottom;">';
							$str = $str . '</span>';
							$str = $str . '</td>';
							$str = $str . '</tr>';
							
	      					if($collectiondata["homepage_element_8_diamondrow_style_content_option"] != "dynamic")
							{
								$str = $str . '<tr class="homepage_element_8_diamondrow_style_content_option_static homepage_element_8_diamondrow_style_option" style=" display: table-row;">';
							}
							else 
							{
								$str = $str . '<tr class="homepage_element_8_diamondrow_style_content_option_static homepage_element_8_diamondrow_style_option" style=" display: none;">';
							}
							$str = $str . '<td class="label"><label for="homepage_element_8_diamondrow_style_button_backgroundcolor">Button Background color:</label></td>';
							$str = $str . '<td class="value">';
							$str = $str . '<input type="text" class="input-text mColorPicker" value="'.$collectiondata["homepage_element_8_diamondrow_style_button_backgroundcolor"].'" name="homepage_element_8_show_diamondrow[homepage_element_8_diamondrow_style_button_backgroundcolor]" id="homepage_element_8_diamondrow_style_button_backgroundcolor" data-hex="true" style="background-color: '.$collectiondata["homepage_element_8_diamondrow_style_button_backgroundcolor"].'; ">';
							$str = $str . '<span id="mcp_homepage_element_8_diamondrow_style_button_backgroundcolor" class="mColorPickerTrigger" style="display: inline-block; cursor: pointer;">';
							$str = $str . '<img src="'.$siteurl.'js/evolved/mColorPicker/color.png" style="border: 0px none; margin: 0px 0px 0px 3px; vertical-align: text-bottom;">';
							$str = $str . '</span>';
							$str = $str . '</td>';
							$str = $str . '</tr>';
							
	      					if($collectiondata["homepage_element_8_diamondrow_style_content_option"] != "dynamic")
							{
								$str = $str . '<tr class="homepage_element_8_diamondrow_style_content_option_static homepage_element_8_diamondrow_style_option" style=" display: table-row;">';
							}
							else 
							{
								$str = $str . '<tr class="homepage_element_8_diamondrow_style_content_option_static homepage_element_8_diamondrow_style_option" style=" display: none;">';
							}
							$str = $str . '<td class="label"><label for="homepage_element_8_diamondrow_style_select">Diamond Style Select:</label></td>';
							$str = $str . '<td class="value">';
							$diamondstyle = array('without_radio'=>'Without Radio', 'with_radio'=>'With Radio');
							$str = $str . '<select name="homepage_element_8_show_diamondrow[homepage_element_8_diamondrow_style_select]" class="homepage_element_8_diamondrow_style_image" id="homepage_element_8_diamondrow_style_select" onChange="diamondstyle(this.value,\'homepage_element_8_diamondrow_style_image\');">';
							foreach($diamondstyle as $diamondstylekey => $diamondstylevalue)
							{
								if($collectiondata["homepage_element_8_diamondrow_style_select"] == $diamondstylekey)
								{
									$str = $str . '<option value="'.$diamondstylekey.'" selected="selected">'.$diamondstylevalue.'</option>';
								}
								else
								{
									$str = $str . '<option value="'.$diamondstylekey.'">'.$diamondstylevalue.'</option>';
								}
							}
							$str = $str . '</select>';
							$str = $str . '</td>';
							$str = $str . '</tr>';
							
							
	      				    if($collectiondata["homepage_element_8_diamondrow_style_content_option"] != "dynamic")
      						{
      							$str = $str . '<tr class="homepage_element_8_diamondrow_style_content_option_dynamic homepage_element_8_diamondrow_style_option" style=" display: none;">';
      						}
      						else
      						{
      							$str = $str . '<tr class="homepage_element_8_diamondrow_style_content_option_dynamic homepage_element_8_diamondrow_style_option" style=" display: table-row;">';
      						}
							$str = $str . '<td class="label">Title text</td>';
							$str = $str . '<td class="value">';
							$str = $str . '<input type="text" name="homepage_element_8_show_diamondrow[homepage_element_8_diamondrow_dynamic_style_content_title]" id="homepage_element_8_diamondrow_dynamic_style_content_title" value="'.$collectiondata['homepage_element_8_diamondrow_dynamic_style_content_title'].'" />';
							$str = $str . '</td>';
							$str = $str . '</tr>';
							
							if($collectiondata["homepage_element_8_diamondrow_style_content_option"] != "dynamic")
							{
								$str = $str . '<tr class="homepage_element_8_diamondrow_style_content_option_dynamic homepage_element_8_diamondrow_style_option" style=" display: none;">';
							}
							else
							{
								$str = $str . '<tr class="homepage_element_8_diamondrow_style_content_option_dynamic homepage_element_8_diamondrow_style_option" style=" display: table-row;">';
							}
							$str = $str . '<td class="label">Title Url</td>';
							$str = $str . '<td class="value">';
							$str = $str . '<input type="text" name="homepage_element_8_show_diamondrow[homepage_element_8_diamondrow_dynamic_style_content_title_url]" id="homepage_element_8_diamondrow_dynamic_style_content_title_url" value="'.$collectiondata['homepage_element_8_diamondrow_dynamic_style_content_title_url'].'" />';
							$str = $str . '</td>';
							$str = $str . '</tr>';
							
	      				    if($collectiondata["homepage_element_8_diamondrow_style_content_option"] != "dynamic")
      						{
      							$str = $str . '<tr class="homepage_element_8_diamondrow_style_content_option_dynamic homepage_element_8_diamondrow_style_option" style=" display: none;">';
      						}
      						else
      						{
      							$str = $str . '<tr class="homepage_element_8_diamondrow_style_content_option_dynamic homepage_element_8_diamondrow_style_option" style=" display: table-row;">';
      						}
							$str = $str . '<td class="label">Content below title</td>';
							$str = $str . '<td class="value"><button id="togglehomepage_element_8_diamondrow_dynamic_style_content_below_title" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><div id="buttonshomepage_element_8_diamondrow_dynamic_style_content_below_title" class="buttons-set"><button style="" onclick="MediabrowserUtility.openDialog(\''.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_8_diamondrow_dynamic_style_content_below_title/\')" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button></div><textarea name="homepage_element_8_show_diamondrow[homepage_element_8_diamondrow_dynamic_style_content_below_title]" title="" id="homepage_element_8_diamondrow_dynamic_style_content_below_title" class="textarea " style="height:200px;" rows="2" cols="15">'.$collectiondata['homepage_element_8_diamondrow_dynamic_style_content_below_title'].'</textarea></td>';
							$str = $str . '<script type="text/javascript">
										//<![CDATA[
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
										//]]>
										</script>';
							$str = $str . '<script type="text/javascript">';
							$str = $str . 'if ("undefined" != typeof(Translator)) {';
							$str = $str . 'Translator.add({"Insert Image...":"Insert Image...","Insert Media...":"Insert Media...","Insert File...":"Insert File..."});';
							$str = $str . '}wysiwyghomepage_element_8_diamondrow_dynamic_style_content_below_title = new tinyMceWysiwygSetup("homepage_element_8_diamondrow_dynamic_style_content_below_title", {"enabled":true,"hidden":true,"use_container":false,"add_variables":true,"add_widgets":true,"add_images":true,"no_display":false,"translator":{},"encode_directives":true,"directives_url":"'.$baseurl.'evolved/cms_wysiwyg/directive/","popup_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/dialog.css","content_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/content.css","width":"100%","plugins":[{"name":"magentovariable","src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentovariable/editor_plugin.js","options":{"title":"Insert Variable...","url":"'.$baseurl.'evolved/system_variable/wysiwygPlugin/","onclick":{"search":["html_id"],"subject":"MagentovariablePlugin.loadChooser(\''.$baseurl.'evolved/system_variable/wysiwygPlugin/\', \'{{html_id}}\');"},"class":"add-variable plugin"}}],"directives_url_quoted":"'.$baseurl.'evolved/cms_wysiwyg/directive/","files_browser_window_url":"'.$baseurl.'idealAdmin/cms_wysiwyg_images/index/","files_browser_window_width":1000,"files_browser_window_height":600,"widget_plugin_src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentowidget/editor_plugin.js","widget_images_url":"'.$siteurl.'skin/adminhtml/default/default/images/widget/","widget_placeholders":["Thumbs.db","catalog__category_widget_link.gif","catalog__product_widget_link.gif","catalog__product_widget_new.gif","cms__widget_block.gif","cms__widget_page_link.gif","default.gif","reports__product_widget_compared.gif","reports__product_widget_viewed.gif"],"widget_window_url":"'.$baseurl.'evolved/widget/index/","firebug_warning_title":"Warning","firebug_warning_text":"Firebug is known to make the WYSIWYG editor slow unless it is turned off or configured properly.","firebug_warning_anchor":"Hide"});';
							$str = $str . 'editorFormValidationHandler = wysiwyghomepage_element_8_diamondrow_dynamic_style_content_below_title.onFormValidation.bind(wysiwyghomepage_element_8_diamondrow_dynamic_style_content_below_title);';
							$str = $str . 'Event.observe("togglehomepage_element_8_diamondrow_dynamic_style_content_below_title", "click", wysiwyghomepage_element_8_diamondrow_dynamic_style_content_below_title.toggle.bind(wysiwyghomepage_element_8_diamondrow_dynamic_style_content_below_title));';
							$str = $str . 'varienGlobalEvents.attachEventHandler("formSubmit", editorFormValidationHandler);';
							$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceBeforeSetContent", wysiwyghomepage_element_8_diamondrow_dynamic_style_content_below_title.beforeSetContent.bind(wysiwyghomepage_element_8_diamondrow_dynamic_style_content_below_title));';
							$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceSaveContent", wysiwyghomepage_element_8_diamondrow_dynamic_style_content_below_title.saveContent.bind(wysiwyghomepage_element_8_diamondrow_dynamic_style_content_below_title));';
							$str = $str . 'varienGlobalEvents.clearEventHandlers("open_browser_callback");';
							$str = $str . 'varienGlobalEvents.attachEventHandler("open_browser_callback", wysiwyghomepage_element_8_diamondrow_dynamic_style_content_below_title.openFileBrowser.bind(wysiwyghomepage_element_8_diamondrow_dynamic_style_content_below_title));';
							$str = $str . '</script>';
							$str = $str . '</tr>';
							

							if($collectiondata["homepage_element_8_diamondrow_style_content_option"] != "dynamic")
							{
								$str = $str . '<tr class="homepage_element_8_diamondrow_style_content_option_static homepage_element_8_diamondrow_style_option" style=" display: table-row;">';
							}
							else 
							{
								$str = $str . '<tr class="homepage_element_8_diamondrow_style_content_option_static homepage_element_8_diamondrow_style_option" style=" display: none;">';
							}
      						$str = $str . '<td class="label"><label for="homepage_element_8_diamondrow_style_image">Image:</label></td>';
      						//$str = $str . '<td class="value"><div id="buttonshomepage_element_8_diamondrow_style_image" class="buttons-set"><button type="button" class="scalable show-hide" style="" id="togglehomepage_element_8_diamondrow_style_image"><span><span><span>Show / Hide Editor</span></span></span></button><button type="button" class="scalable add-widget plugin" onclick="widgetTools.openDialog('.$baseurl.'evolved/widget/index/widget_target_id/homepage_element_8_diamondrow_style_image)" style=""><span><span><span>Insert Widget...</span></span></span></button><button type="button" class="scalable add-image plugin" onclick="MediabrowserUtility.openDialog('.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_8_diamondrow_style_image/)" style=""><span><span><span>Insert Image...</span></span></span></button><button type="button" class="scalable add-variable plugin" onclick="MagentovariablePlugin.loadChooser('.$baseurl.'evolved/system_variable/wysiwygPlugin/, homepage_element_8_diamondrow_style_image);"><span><span><span>Insert Variable...</span></span></span></button></div><textarea name="homepage_element_8_diamondrow_style_image" title="" id="homepage_element_8_diamondrow_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_8_diamondrow_style_image'].'</textarea><small>Image size must be 1920*480 pixels</small></td>';

      						//echo $defaulttylecheckbox;
      						if($collectiondata['homepage_element_8_diamondrow_style_image'])
							{
								$str = $str . '<td class="value"><button id="togglehomepage_element_8_diamondrow_style_image" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><div id="buttonshomepage_element_8_diamondrow_style_image" class="buttons-set"><button style="" onclick="MediabrowserUtility.openDialog(\''.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_8_diamondrow_style_image/\')" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button></div><textarea name="homepage_element_8_show_diamondrow[homepage_element_8_diamondrow_style_image]" title="" id="homepage_element_8_diamondrow_style_image" class="textarea " style="height:200px;" rows="2" cols="15">'.$collectiondata['homepage_element_8_diamondrow_style_image'].'</textarea></td>';									
							}
							else
							{
								$str = $str . '<td class="value"><button id="togglehomepage_element_8_diamondrow_style_image" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><div id="buttonshomepage_element_8_diamondrow_style_image" class="buttons-set"><button style="" onclick="MediabrowserUtility.openDialog(\''.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_8_diamondrow_style_image/\')" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button></div><textarea name="homepage_element_8_show_diamondrow[homepage_element_8_diamondrow_style_image]" title="" id="homepage_element_8_diamondrow_style_image" class="textarea " style="height:200px;" rows="2" cols="15" readonly="true">'.$loosdiamond_simple_without_radio.'</textarea></td>';
							}
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
      						$str = $str . '}wysiwyghomepage_element_8_diamondrow_style_image = new tinyMceWysiwygSetup("homepage_element_8_diamondrow_style_image", {"enabled":true,"hidden":true,"use_container":false,"add_variables":true,"add_widgets":true,"add_images":true,"no_display":false,"translator":{},"encode_directives":true,"directives_url":"'.$baseurl.'evolved/cms_wysiwyg/directive/","popup_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/dialog.css","content_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/content.css","width":"100%","plugins":[{"name":"magentovariable","src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentovariable/editor_plugin.js","options":{"title":"Insert Variable...","url":"'.$baseurl.'evolved/system_variable/wysiwygPlugin/","onclick":{"search":["html_id"],"subject":"MagentovariablePlugin.loadChooser(\''.$baseurl.'evolved/system_variable/wysiwygPlugin/\', \'{{html_id}}\');"},"class":"add-variable plugin"}}],"directives_url_quoted":"'.$baseurl.'evolved/cms_wysiwyg/directive/","files_browser_window_url":"'.$baseurl.'idealAdmin/cms_wysiwyg_images/index/","files_browser_window_width":1000,"files_browser_window_height":600,"widget_plugin_src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentowidget/editor_plugin.js","widget_images_url":"'.$siteurl.'skin/adminhtml/default/default/images/widget/","widget_placeholders":["Thumbs.db","catalog__category_widget_link.gif","catalog__product_widget_link.gif","catalog__product_widget_new.gif","cms__widget_block.gif","cms__widget_page_link.gif","default.gif","reports__product_widget_compared.gif","reports__product_widget_viewed.gif"],"widget_window_url":"'.$baseurl.'evolved/widget/index/","firebug_warning_title":"Warning","firebug_warning_text":"Firebug is known to make the WYSIWYG editor slow unless it is turned off or configured properly.","firebug_warning_anchor":"Hide"});';
      						$str = $str . 'editorFormValidationHandler = wysiwyghomepage_element_8_diamondrow_style_image.onFormValidation.bind(wysiwyghomepage_element_8_diamondrow_style_image);';
      						$str = $str . 'Event.observe("togglehomepage_element_8_diamondrow_style_image", "click", wysiwyghomepage_element_8_diamondrow_style_image.toggle.bind(wysiwyghomepage_element_8_diamondrow_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("formSubmit", editorFormValidationHandler);';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceBeforeSetContent", wysiwyghomepage_element_8_diamondrow_style_image.beforeSetContent.bind(wysiwyghomepage_element_8_diamondrow_style_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceSaveContent", wysiwyghomepage_element_8_diamondrow_style_image.saveContent.bind(wysiwyghomepage_element_8_diamondrow_style_image));';
      						$str = $str . 'varienGlobalEvents.clearEventHandlers("open_browser_callback");';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("open_browser_callback", wysiwyghomepage_element_8_diamondrow_style_image.openFileBrowser.bind(wysiwyghomepage_element_8_diamondrow_style_image));';
      						$str = $str . '</script>';
      						$str = $str . '</tr>';
      						
      						if($collectiondata["homepage_element_8_diamondrow_style_content_option"] != "dynamic")
      						{
      							$str = $str . '<tr class="homepage_element_8_diamondrow_style_content_option_dynamic homepage_element_8_diamondrow_style_option" style=" display: none;">';
      						}
      						else
      						{
      							$str = $str . '<tr class="homepage_element_8_diamondrow_style_content_option_dynamic homepage_element_8_diamondrow_style_option" style=" display: table-row;">';
      						}
      						$str = $str . '<td class="label"><label for="homepage_element_8_diamondrow_style_image">Image:</label></td>';
      						$str = $str . '<td class="value grid">';
      						$str = $str . '<button id="addbtn" onClick="addshaperow(\'homepage_element_8_show_diamondrow\',\'homepage_element_8_diamondrow\'); return false;"><span>Add</span></button>';
      						$str = $str . '<table id="homepage_element_8_diamondrow_dynamic_shape_table" class="homepage_element_diamondrow_dynamic_shape_table">';
      						$str = $str . '<tr class="headings">';
      						$str = $str . '<th>Uplode Shape</th>';
      						$str = $str . '<th>Label</th>';
      						$str = $str . '<th>Enable</th>';
      						$str = $str . '<th>Sort Order</th>';
      						$str = $str . '</tr>';
      						
      						$str = $str . '<tr style="display:none; ">';
      						$str = $str . '<td colspan=3><input type="hidden" name="homepage_element_8_show_diamondrow[homepage_element_8_diamondrow_dynamic_shape_table_row_count]" class="homepage_element_8_diamondrow_dynamic_shape_table_row_count" value="'.$collectiondata['homepage_element_8_diamondrow_dynamic_shape_table_row_count'].'" /></td>';
      						$str = $str . '</tr>';
      						
      						$shapeenablearr = array('-1'=>'Please Select', '1'=>'Enable', '0'=>'Disable');
      						for($shapeconut=1; $shapeconut<=$collectiondata['homepage_element_8_diamondrow_dynamic_shape_table_row_count']; $shapeconut++)
      						{
      							$str = $str . '<tr>';
      							$str = $str . '<td><input type="hidden" class="homepage_element_diamondrow_dynamic_shape_table_row" name="homepage_element_8_show_diamondrow[homepage_element_8_diamondrow_dynamic_shape_table_row'.$shapeconut.']" value='.$collectiondata["homepage_element_8_diamondrow_dynamic_shape_table_row".$shapeconut].' />';
      							
      							if($collectiondata["homepage_element_8_diamondrow_dynamic_shape_table_image_row".$shapeconut."_image"])
								{
									$str = $str . '<a onclick="imagePreview(\'homepage_element_8_diamondrow_dynamic_shape_table_image_row'.$shapeconut.'_image\'); return false;" href="'.Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA).$collectiondata["homepage_element_8_diamondrow_dynamic_shape_table_image_row".$shapeconut."_image"].'"><img width="22" height="22" class="small-image-preview v-middle" alt="'.$collectiondata["homepage_element_8_diamondrow_dynamic_shape_table_image_row".$shapeconut."_image"].'" title="'.$collectiondata["homepage_element_8_diamondrow_dynamic_shape_table_image_row".$shapeconut."_image"].'" id="homepage_element_8_diamondrow_dynamic_shape_table_image_row'.$shapeconut.'_image" src="'.Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA).$collectiondata["homepage_element_8_diamondrow_dynamic_shape_table_image_row".$shapeconut."_image"].'"></a>';
									$str = $str . '<input type="file" class="input-file" value="'.$collectiondata["homepage_element_8_diamondrow_dynamic_shape_table_image_row".$shapeconut."_image"].'" name="homepage_element_8_show_diamondrow[homepage_element_8_diamondrow_dynamic_shape_table_image_row'.$shapeconut.'_image]" id="homepage_element_8_diamondrow_dynamic_shape_table_image_row'.$shapeconut.'_image">';
									$str = $str . '<span class="delete-image"><input type="checkbox" name="homepage_element_8_show_diamondrow[homepage_element_8_diamondrow_dynamic_shape_table_image_row'.$shapeconut.'_image][delete]" value="1" class="checkbox" id="homepage_element_8_diamondrow_dynamic_shape_table_image_row'.$shapeconut.'_image_delete"><label for="homepage_element_8_diamondrow_dynamic_shape_table_image_row'.$shapeconut.'_image_delete"> Delete Image</label><input type="hidden" name="homepage_element_8_show_diamondrow[homepage_element_8_diamondrow_dynamic_shape_table_image_row'.$shapeconut.'_image][value]" value="'.$collectiondata["homepage_element_8_diamondrow_dynamic_shape_table_image_row".$shapeconut."_image"].'"></span>';
								}
      							else
      							{
      								$str = $str . '<input type="file" class="input-file" value="" name="homepage_element_8_show_diamondrow[homepage_element_8_diamondrow_dynamic_shape_table_image_row'.$shapeconut.'_image]" id="homepage_element_8_diamondrow_dynamic_shape_table_image_row'.$shapeconut.'_image">';
      							}      							
      							$str = $str . '</td>';
      							
      							$str = $str . '<td><input type="text" name="homepage_element_8_show_diamondrow[homepage_element_8_diamondrow_dynamic_shape_table_title_row'.$shapeconut.']" value="'.$collectiondata["homepage_element_8_diamondrow_dynamic_shape_table_title_row".$shapeconut].'"></td>';
      							$str = $str . '<td><select name="homepage_element_8_show_diamondrow[homepage_element_8_diamondrow_dynamic_shape_table_enable_row'.$shapeconut.']" style="width: 100px;" >';
      							foreach($shapeenablearr as $shapeenablearrekey => $shapeenablearrvalue)
      							{
      								if($collectiondata["homepage_element_8_diamondrow_dynamic_shape_table_enable_row".$shapeconut] == $shapeenablearrekey)
      								{
      									$str = $str . '<option value="'.$shapeenablearrekey.'" selected="selected">'.$shapeenablearrvalue.'</option>';
      								}
      								else
      								{
      									$str = $str . '<option value="'.$shapeenablearrekey.'">'.$shapeenablearrvalue.'</option>';
      								}
      							}
      							$str = $str . '</select></td>';
      							$str = $str . '<td><input type="text" name="homepage_element_8_show_diamondrow[homepage_element_8_diamondrow_dynamic_shape_table_sortorder_row'.$shapeconut.']" value="'.$collectiondata["homepage_element_8_diamondrow_dynamic_shape_table_sortorder_row".$shapeconut].'" /></td>';
      							$str = $str . '</tr>';
      						}    						
      						
      						$str = $str . '</table>';
      						
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
							if($selectElement == 'homepage_element_8_show_textrow')
							{
								$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="homepage_element_8_show_textrow" style="display: block">';
							}
							else
							{
								$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="homepage_element_8_show_textrow"  style="display: none">';
							}
							$textrow = array(0=>'No', 1=>'Yes');
							//$str = $str . '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="1920_by_800_banner">';
							$str = $str . '<tbody>';
							$str = $str . '<tr>';
							$str = $str . '<td>';
							$str = $str . '<table cellspacing="0" class="form-list allpageelement">';
							$str = $str . '<tbody>';
							$str = $str . '<tr>';
							$str = $str . '<td class="label"><label for="homepage_element_8_textrow_enabled">Show Text Row :</label></td>';
							$str = $str . '<td class="value">';
							$str = $str . '<select class=" select" name="homepage_element_8_show_textrow[homepage_element_8_textrow_enabled]" id="homepage_element_8_textrow_enabled">';
							foreach($textrow as $textrowkey => $textrowvalue)
							{
								if($collectiondata["homepage_element_8_textrow_enabled"] == $textrowkey)
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
							$str = $str . '<td class="label"><label for="homepage_element_8_textrow_style_image">Image:</label></td>';
							//$str = $str . '<td class="value"><div id="buttonshomepage_element_8_textrow_style_image" class="buttons-set"><button type="button" class="scalable show-hide" style="" id="togglehomepage_element_8_textrow_style_image"><span><span><span>Show / Hide Editor</span></span></span></button><button type="button" class="scalable add-widget plugin" onclick="widgetTools.openDialog('.$baseurl.'evolved/widget/index/widget_target_id/homepage_element_8_textrow_style_image)" style=""><span><span><span>Insert Widget...</span></span></span></button><button type="button" class="scalable add-image plugin" onclick="MediabrowserUtility.openDialog('.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_8_textrow_style_image/)" style=""><span><span><span>Insert Image...</span></span></span></button><button type="button" class="scalable add-variable plugin" onclick="MagentovariablePlugin.loadChooser('.$baseurl.'evolved/system_variable/wysiwygPlugin/, homepage_element_8_textrow_style_image);"><span><span><span>Insert Variable...</span></span></span></button></div><textarea name="homepage_element_8_textrow_style_image" title="" id="homepage_element_8_textrow_style_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_8_textrow_style_image'].'</textarea><small>Image size must be 1920*480 pixels</small></td>';
							$str = $str . '<td class="value"><button id="togglehomepage_element_8_textrow_style_image" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><div id="buttonshomepage_element_8_textrow_style_image" class="buttons-set"><button style="" onclick="MediabrowserUtility.openDialog(\''.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_8_textrow_style_image/\')" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button></div><textarea name="homepage_element_8_show_textrow[homepage_element_8_textrow_style_image]" title="" id="homepage_element_8_textrow_style_image" class="textarea " style="height:200px;" rows="2" cols="15">'.$collectiondata['homepage_element_8_textrow_style_image'].'</textarea></td>';
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
							$str = $str . '}wysiwyghomepage_element_8_textrow_style_image = new tinyMceWysiwygSetup("homepage_element_8_textrow_style_image", {"enabled":true,"hidden":true,"use_container":false,"add_variables":true,"add_widgets":true,"add_images":true,"no_display":false,"translator":{},"encode_directives":true,"directives_url":"'.$baseurl.'evolved/cms_wysiwyg/directive/","popup_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/dialog.css","content_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/content.css","width":"100%","plugins":[{"name":"magentovariable","src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentovariable/editor_plugin.js","options":{"title":"Insert Variable...","url":"'.$baseurl.'evolved/system_variable/wysiwygPlugin/","onclick":{"search":["html_id"],"subject":"MagentovariablePlugin.loadChooser(\''.$baseurl.'evolved/system_variable/wysiwygPlugin/\', \'{{html_id}}\');"},"class":"add-variable plugin"}}],"directives_url_quoted":"'.$baseurl.'evolved/cms_wysiwyg/directive/","files_browser_window_url":"'.$baseurl.'idealAdmin/cms_wysiwyg_images/index/","files_browser_window_width":1000,"files_browser_window_height":600,"widget_plugin_src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentowidget/editor_plugin.js","widget_images_url":"'.$siteurl.'skin/adminhtml/default/default/images/widget/","widget_placeholders":["Thumbs.db","catalog__category_widget_link.gif","catalog__product_widget_link.gif","catalog__product_widget_new.gif","cms__widget_block.gif","cms__widget_page_link.gif","default.gif","reports__product_widget_compared.gif","reports__product_widget_viewed.gif"],"widget_window_url":"'.$baseurl.'evolved/widget/index/","firebug_warning_title":"Warning","firebug_warning_text":"Firebug is known to make the WYSIWYG editor slow unless it is turned off or configured properly.","firebug_warning_anchor":"Hide"});';
							$str = $str . 'editorFormValidationHandler = wysiwyghomepage_element_8_textrow_style_image.onFormValidation.bind(wysiwyghomepage_element_8_textrow_style_image);';
							$str = $str . 'Event.observe("togglehomepage_element_8_textrow_style_image", "click", wysiwyghomepage_element_8_textrow_style_image.toggle.bind(wysiwyghomepage_element_8_textrow_style_image));';
							$str = $str . 'varienGlobalEvents.attachEventHandler("formSubmit", editorFormValidationHandler);';
							$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceBeforeSetContent", wysiwyghomepage_element_8_textrow_style_image.beforeSetContent.bind(wysiwyghomepage_element_8_textrow_style_image));';
							$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceSaveContent", wysiwyghomepage_element_8_textrow_style_image.saveContent.bind(wysiwyghomepage_element_8_textrow_style_image));';
							$str = $str . 'varienGlobalEvents.clearEventHandlers("open_browser_callback");';
							$str = $str . 'varienGlobalEvents.attachEventHandler("open_browser_callback", wysiwyghomepage_element_8_textrow_style_image.openFileBrowser.bind(wysiwyghomepage_element_8_textrow_style_image));';
							$str = $str . '</script>';
							$str = $str . '</tr>';
							$str = $str . '<tr>';
							$str = $str . '<td class="label"><label for="homepage_element_8_textrow_style_marker_checkbox">Marker:</label></td>';
							$str = $str . '<td class="value">';
							$str = $str . '<ul class="checkboxes">';
							$markerarr = array('top','right','bottom','left');
							$homepage_element_8_textrow_style_marker_checkbox = unserialize($collectiondata['homepage_element_8_textrow_style_marker_checkbox']);
							foreach($markerarr as $marker)
							{
								if($homepage_element_8_textrow_style_marker_checkbox[$marker] == $marker){
									$str = $str . '<li><input type="checkbox" value="'.$marker.'" name="homepage_element_8_show_textrow[homepage_element_8_textrow_style_marker_checkbox]['.$marker.']" id="homepage_element_8_textrow_style_marker_checkbox['.$marker.']" checked > <label for="'.$marker.'" >'.$marker.'</label></li>';
								}
								else {
									$str = $str . '<li><input type="checkbox" value="'.$marker.'" name="homepage_element_8_show_textrow[homepage_element_8_textrow_style_marker_checkbox]['.$marker.']" id="homepage_element_8_textrow_style_marker_checkbox['.$marker.']"> <label for="'.$marker.'">'.$marker.'</label></li>';
								}
							}
							$str = $str . '</ul>';
							$str = $str . '</td>';
							$str = $str . '</tr>';
							$str = $str . '<tr>';
							$str = $str . '<td class="label"><label for="homepage_element_8_textrow_style_marker_image">Marker Image:</label></td>';
							$str = $str . '<td class="value">';
							if($collectiondata["homepage_element_8_textrow_style_marker_image"])
							{
								$str = $str . '<a onclick="imagePreview(\'homepage_element_8_textrow_style_marker_image_image\'); return false;" href="'.Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA).$collectiondata["homepage_element_8_textrow_style_marker_image"].'"><img width="22" height="22" class="small-image-preview v-middle" alt="'.$collectiondata["homepage_element_8_textrow_style_marker_image"].'" title="'.$collectiondata["homepage_element_8_textrow_style_marker_image"].'" id="homepage_element_8_textrow_style_marker_image_image" src="'.Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA).$collectiondata["homepage_element_8_textrow_style_marker_image"].'"></a>';
								$str = $str . '<input type="file" class="input-file" value="'.$collectiondata["homepage_element_8_textrow_style_marker_image"].'" name="homepage_element_8_show_textrow[homepage_element_8_textrow_style_marker_image]" id="homepage_element_8_textrow_style_marker_image">';
								$str = $str . '<span class="delete-image"><input type="checkbox" name="homepage_element_8_show_textrow[homepage_element_8_textrow_style_marker_image][delete]" value="1" class="checkbox" id="homepage_element_8_textrow_style_marker_image_delete"><label for="homepage_element_8_textrow_style_marker_image_delete"> Delete Image</label><input type="hidden" name="homepage_element_8_show_textrow[homepage_element_8_textrow_style_marker_image][value]" value="'.$collectiondata["homepage_element_8_textrow_style_marker_image"].'"></span>';
							}
							else
							{
								$str = $str . '<input type="file" class="input-file" value="" name="homepage_element_8_show_textrow[homepage_element_8_textrow_style_marker_image]" id="homepage_element_8_textrow_style_marker_image">';
							}
							$str = $str . '</td>';
							$str = $str . '</tr>';
							$str = $str . '<tr>';
							$str = $str . '<td class="label"><label for="homepage_element_8_textrow_style_background_color">Textrow Background color:</label></td>';
							$str = $str . '<td class="value">';
							$str = $str . '<input type="text" class="input-text mColorPicker" value="'.$collectiondata["homepage_element_8_textrow_style_background_color"].'" name="homepage_element_8_show_textrow[homepage_element_8_textrow_style_background_color]" id="homepage_element_8_textrow_style_background_color" data-hex="true" style="background-color: '.$collectiondata["homepage_element_8_textrow_style_background_color"].'; ">';
							$str = $str . '<span id="mcp_homepage_element_8_textrow_style_background_color" class="mColorPickerTrigger" style="display: inline-block; cursor: pointer;">';
							$str = $str . '<img src="'.$siteurl.'js/evolved/mColorPicker/color.png" style="border: 0px none; margin: 0px 0px 0px 3px; vertical-align: text-bottom;">';
							$str = $str . '</span>';
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
							if($selectElement == 'homepage_element_8_show_image_with_feature_slider')
	      					{
	      						$str .= '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="homepage_element_8_show_image_with_feature_slider" style="display: block">';
	      					}
	      					else 
	      					{
	      						$str .= '<table cellspacing="0" class="form-list allpageelement allpageelementmaintable" id="homepage_element_8_show_image_with_feature_slider"  style="display: none">';
	      					}
	      					$str = $str . '<tbody>';
	      					$str = $str . '<tr>';
	      					$str = $str . '<td>';
      						$str = $str . '<table cellspacing="0" class="form-list allpageelement">';
								$str = $str . '<tbody>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_show_image_with_feature_slider_one_title">Title:</label></td>';  
      						$str = $str . '<td class="value"><input id="homepage_element_8_show_image_with_feature_slider_one_title"  value="'.$collectiondata['homepage_element_8_show_image_with_feature_slider_one_title'].'"  name="homepage_element_8_show_image_with_feature_slider[homepage_element_8_show_image_with_feature_slider_one_title]"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str .	'<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_show_image_with_feature_slider_one_link">Link:</label></td>';
      						$str = $str . '<td class="value"><input id="homepage_element_8_show_image_with_feature_slider_one_link" value="'.$collectiondata['homepage_element_8_show_image_with_feature_slider_one_link'].'" name="homepage_element_8_show_image_with_feature_slider[homepage_element_8_show_image_with_feature_slider_one_link]"  type="text" class=" input-text"></td>';
      						$str = $str . '</tr>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_show_image_with_feature_slider_one_image">Image:</label></td>';
      						//$str = $str . '<td class="value"><div id="buttonshomepage_element_8_show_image_with_feature_slider_one_image" class="buttons-set"><button type="button" class="scalable show-hide" style="" id="togglehomepage_element_8_show_image_with_feature_slider_one_image"><span><span><span>Show / Hide Editor</span></span></span></button><button type="button" class="scalable add-widget plugin" onclick="widgetTools.openDialog('.$baseurl.'evolved/widget/index/widget_target_id/homepage_element_8_show_image_with_feature_slider_one_image)" style=""><span><span><span>Insert Widget...</span></span></span></button><button type="button" class="scalable add-image plugin" onclick="MediabrowserUtility.openDialog('.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_8_show_image_with_feature_slider_one_image/)" style=""><span><span><span>Insert Image...</span></span></span></button><button type="button" class="scalable add-variable plugin" onclick="MagentovariablePlugin.loadChooser('.$baseurl.'evolved/system_variable/wysiwygPlugin/, homepage_element_8_show_image_with_feature_slider_one_image);"><span><span><span>Insert Variable...</span></span></span></button></div><textarea name="homepage_element_8_show_image_with_feature_slider_one_image" title="" id="homepage_element_8_show_image_with_feature_slider_one_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_8_show_image_with_feature_slider_one_image'].'</textarea><small>Image size must be 1920*480 pixels</small></td>';
      						$str = $str . '<td class="value"><button id="togglehomepage_element_8_show_image_with_feature_slider_one_image" style="" class="scalable show-hide" type="button"><span><span><span>Show / Hide Editor</span></span></span></button><div id="buttonshomepage_element_8_show_image_with_feature_slider_one_image" class="buttons-set"><button style="" onclick="MediabrowserUtility.openDialog(\''.$baseurl.'idealAdmin/cms_wysiwyg_images/index/target_element_id/homepage_element_8_show_image_with_feature_slider_one_image/\')" class="scalable add-image plugin" type="button"><span><span><span>Insert Image...</span></span></span></button></div><textarea name="homepage_element_8_show_image_with_feature_slider[homepage_element_8_show_image_with_feature_slider_one_image]" title="" id="homepage_element_8_show_image_with_feature_slider_one_image" class="textarea " style="height:50px;" rows="2" cols="15">'.$collectiondata['homepage_element_8_show_image_with_feature_slider_one_image'].'</textarea></td>';
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
      						$str = $str . '}wysiwyghomepage_element_8_show_image_with_feature_slider_one_image = new tinyMceWysiwygSetup("homepage_element_8_show_image_with_feature_slider_one_image", {"enabled":true,"hidden":true,"use_container":false,"add_variables":true,"add_widgets":true,"add_images":true,"no_display":false,"translator":{},"encode_directives":true,"directives_url":"'.$baseurl.'evolved/cms_wysiwyg/directive/","popup_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/dialog.css","content_css":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/themes/advanced/skins/default/content.css","width":"100%","plugins":[{"name":"magentovariable","src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentovariable/editor_plugin.js","options":{"title":"Insert Variable...","url":"'.$baseurl.'evolved/system_variable/wysiwygPlugin/","onclick":{"search":["html_id"],"subject":"MagentovariablePlugin.loadChooser(\''.$baseurl.'evolved/system_variable/wysiwygPlugin/\', \'{{html_id}}\');"},"class":"add-variable plugin"}}],"directives_url_quoted":"'.$baseurl.'evolved/cms_wysiwyg/directive/","files_browser_window_url":"'.$baseurl.'idealAdmin/cms_wysiwyg_images/index/","files_browser_window_width":1000,"files_browser_window_height":600,"widget_plugin_src":"'.$siteurl.'js/mage/adminhtml/wysiwyg/tiny_mce/plugins/magentowidget/editor_plugin.js","widget_images_url":"'.$siteurl.'skin/adminhtml/default/default/images/widget/","widget_placeholders":["Thumbs.db","catalog__category_widget_link.gif","catalog__product_widget_link.gif","catalog__product_widget_new.gif","cms__widget_block.gif","cms__widget_page_link.gif","default.gif","reports__product_widget_compared.gif","reports__product_widget_viewed.gif"],"widget_window_url":"'.$baseurl.'evolved/widget/index/","firebug_warning_title":"Warning","firebug_warning_text":"Firebug is known to make the WYSIWYG editor slow unless it is turned off or configured properly.","firebug_warning_anchor":"Hide"});';
      						$str = $str . 'editorFormValidationHandler = wysiwyghomepage_element_8_show_image_with_feature_slider_one_image.onFormValidation.bind(wysiwyghomepage_element_8_show_image_with_feature_slider_one_image);';
      						$str = $str . 'Event.observe("togglehomepage_element_8_show_image_with_feature_slider_one_image", "click", wysiwyghomepage_element_8_show_image_with_feature_slider_one_image.toggle.bind(wysiwyghomepage_element_8_show_image_with_feature_slider_one_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("formSubmit", editorFormValidationHandler);';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceBeforeSetContent", wysiwyghomepage_element_8_show_image_with_feature_slider_one_image.beforeSetContent.bind(wysiwyghomepage_element_8_show_image_with_feature_slider_one_image));';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("tinymceSaveContent", wysiwyghomepage_element_8_show_image_with_feature_slider_one_image.saveContent.bind(wysiwyghomepage_element_8_show_image_with_feature_slider_one_image));';
      						$str = $str . 'varienGlobalEvents.clearEventHandlers("open_browser_callback");';
      						$str = $str . 'varienGlobalEvents.attachEventHandler("open_browser_callback", wysiwyghomepage_element_8_show_image_with_feature_slider_one_image.openFileBrowser.bind(wysiwyghomepage_element_8_show_image_with_feature_slider_one_image));';
      						$str = $str . '</script>';
      						$str = $str . '</tr>';
      						$str = $str . '</tbody>';
      						$str = $str . '</table>';	
      						$str = $str . '</td>';
      						$str = $str . '<td>';
								$str = $str . '<table cellspacing="0" class="form-list allpageelement" style="display: table-cell;">';
      						$str = $str . '<tbody>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_image_with_featured_enabled">Show image_with_featured :</label></td>';
      						$str = $str . '<td class="value">';
      						$str = $str . '<select class=" select" name="homepage_element_8_show_image_with_feature_slider[homepage_element_8_image_with_featured_enabled]" id="homepage_element_8_image_with_featured_enabled">';
      						$image_with_featured = array(0=>'No', 1=>'Yes');      						
      						foreach($image_with_featured as $image_with_featuredkey => $image_with_featuredvalue)
      						{
      							if($collectiondata["homepage_element_8_image_with_featured_enabled"] == $image_with_featuredkey)
      							{
      								$str = $str . '<option value="'.$image_with_featuredkey.'" selected="selected">'.$image_with_featuredvalue.'</option>';
      							}
      							else
      							{
      								$str = $str . '<option value="'.$image_with_featuredkey.'">'.$image_with_featuredvalue.'</option>';
      							}
      						}
      						$str = $str . '</select>';
      						$str = $str . '</td>';
      						$str = $str . '</tr>';
      						$str = $str . '<tr>';
      						$str = $str . '<td class="label"><label for="homepage_element_8_image_with_featured_category_id">image_with_featured Category:</label></td>';
      						$str = $str . '<td class="value">';
      						$str = $str . '<select class=" select" name="homepage_element_8_show_image_with_feature_slider[homepage_element_8_image_with_featured_category_id]" id="homepage_element_8_image_with_featured_category_id">';
      						foreach(Mage::getModel('evolved/category')->toOptionArray() as $image_with_featuredcatid => $image_with_featuredcatname)
      						{
      							if($collectiondata["homepage_element_8_image_with_featured_category_id"] == $image_with_featuredcatid)
      							{
      								$str = $str . '<option value="'.$image_with_featuredcatid.'" selected="selected">'.$image_with_featuredcatname.'</option>';
      							}
      							else
      							{
      								$str = $str . '<option value="'.$image_with_featuredcatid.'">'.$image_with_featuredcatname.'</option>';
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
		return $str;
		
    }
}
?>