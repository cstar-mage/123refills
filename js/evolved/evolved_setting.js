jQuery(document).ready(function(){
		
	jQuery(".form-buttons button").click(function(){
		jQuery("#loading-mask").css("display","block");
	});
	
	jQuery(".tooltip_element_main").parent(".value").css("width","100%");
	
	/********************** Start Font Setting  ********************************/
	var fonts_main = jQuery("#fonts_main").val();
	var fonts_title = jQuery("#fonts_title").val();
	var fonts_price = jQuery("#fonts_price").val();
	var fonts_footer_title = jQuery("#fonts_footer_title").val();
	var fonts_footer_link = jQuery("#fonts_footer_link").val();
	var fonts_navigation = jQuery("#fonts_navigation").val();
	var fonts_block_title = jQuery("#fonts_block_title").val();
	var fonts_product_title = jQuery("#fonts_product_title").val();
	var fonts_productdetails_price = jQuery("#fonts_productdetails_price").val();
	var fonts_product_name = jQuery("#fonts_product_name").val();
	
	jQuery("#fonts_all").change(function(){
		//alert(jQuery(this).val());
		//jQuery("#fonts_main option:selected").val(jQuery(this).val());
			if(jQuery(this).val() != "")
			{
				jQuery("#fonts_main option[value='"+jQuery(this).val()+"']").attr('selected', 'selected');
				jQuery("#fonts_title option[value='"+jQuery(this).val()+"']").attr('selected', 'selected');
				jQuery("#fonts_price option[value='"+jQuery(this).val()+"']").attr('selected', 'selected');
				jQuery("#fonts_footer_title option[value='"+jQuery(this).val()+"']").attr('selected', 'selected');
				jQuery("#fonts_footer_link option[value='"+jQuery(this).val()+"']").attr('selected', 'selected');
				jQuery("#fonts_navigation option[value='"+jQuery(this).val()+"']").attr('selected', 'selected');
				jQuery("#fonts_block_title option[value='"+jQuery(this).val()+"']").attr('selected', 'selected');
				jQuery("#fonts_product_title option[value='"+jQuery(this).val()+"']").attr('selected', 'selected');
				jQuery("#fonts_productdetails_price option[value='"+jQuery(this).val()+"']").attr('selected', 'selected');
				jQuery("#fonts_product_name option[value='"+jQuery(this).val()+"']").attr('selected', 'selected');
			}
			else
			{
				jQuery("#fonts_main option[value='"+ fonts_main +"']").attr('selected', 'selected');
				jQuery("#fonts_title option[value='"+ fonts_title +"']").attr('selected', 'selected');
				jQuery("#fonts_price option[value='"+ fonts_price +"']").attr('selected', 'selected');
				jQuery("#fonts_footer_title option[value='"+ fonts_footer_title +"']").attr('selected', 'selected');
				jQuery("#fonts_footer_link option[value='"+ fonts_footer_link +"']").attr('selected', 'selected');
				jQuery("#fonts_navigation option[value='"+ fonts_navigation +"']").attr('selected', 'selected');
				jQuery("#fonts_block_title option[value='"+ fonts_block_title +"']").attr('selected', 'selected');
				jQuery("#fonts_product_title option[value='"+ fonts_product_title +"']").attr('selected', 'selected');
				jQuery("#fonts_productdetails_price option[value='"+ fonts_productdetails_price +"']").attr('selected', 'selected');
				jQuery("#fonts_product_name option[value='"+ fonts_product_name +"']").attr('selected', 'selected');
			}
		});
	/********************** End Font Setting  ********************************/
	
	/********************** Start expand tab Setting  ********************************/
	jQuery(".entry-edit-head").css("margin","2px 0").css("cursor","pointer");
	jQuery(".entry-edit-head").next().css("display","block");
	jQuery("#evolved_tabs_evolved_header_content .entry-edit-head, #evolved_tabs_evolved_footer_content .entry-edit-head, #evolved_tabs_evolved_homepage_content .entry-edit-head, #evolved_tabs_evolved_productlist_content .entry-edit-head, #evolved_tabs_evolved_buttons_content .entry-edit-head, #evolved_tabs_evolved_productdetails_content .entry-edit-head").next().css("display","none").css("margin-top","-2px");
	jQuery(".entry-edit-head").removeClass("evolved_close");
	jQuery(".entry-edit-head").addClass("evolved_open");
	/****************** start first tab open **********************/
	jQuery("#evolved_tabs_evolved_header_content .entry-edit-head:nth-child(1), #evolved_tabs_evolved_buttons_content .entry-edit-head:nth-child(1), #evolved_tabs_evolved_footer_content .entry-edit-head:nth-child(1), #evolved_tabs_evolved_productdetails_content .entry-edit-head:nth-child(1)").next().css("display","block");
	/****************** end first tab open **********************/
	jQuery(".entry-edit-head").click(function(){
		if(jQuery(this).next().css("display") == "block")
		{
			jQuery(this).next().css("display","none");
			jQuery(this).removeClass("evolved_close");
			jQuery(this).addClass("evolved_open");
		}
		else
		{
			jQuery(this).next().css("display","block");
			jQuery(this).addClass("evolved_close");
			jQuery(this).removeClass("evolved_open");
		}
	});
	/********************** End expand tab Setting  ********************************/
	
	/********************** Start Diamond script  *********************************/
	var diamindstr_without_radio;
	var diamindstr_with_radio;
	/********************** End Diamond script  *********************************/
});
function diamondstyle(selectvalue,textareaname)
{
	loosdiamond_simple_without_radio = '<div class="shape"><div class="imageshape"><a href="{{store url=\'diamond-search\'}}"><img alt="" src="{{media url=\'search/logo1.png\'}}"></a><a href="{{store url=\'diamond-search\'}}?shape=round"><img alt="" src="{{media url=\'search/round.jpg\'}}">Round</a><a href="{{store url=\'diamond-search\'}}?shape=princess"><img alt="" src="{{media url=\'search/princess.jpg\'}}">Princess</a><a href="{{store url=\'diamond-search\'}}?shape=emerald"><img alt="" src="{{media url=\'search/emerald.jpg\'}}">Emerald</a><a href="{{store url=\'diamond-search\'}}?shape=marquise"><img alt="" src="{{media url=\'search/marquise.jpg\'}}">Marquise</a><a href="{{store url=\'diamond-search\'}}?shape=asscher"><img alt="" src="{{media url=\'search/asscher.jpg\'}}">Asscher</a><a href="{{store url=\'diamond-search\'}}?shape=oval"><img alt="" src="{{media url=\'search/oval.jpg\'}}">Oval</a><a href="{{store url=\'diamond-search\'}}?shape=radiant"><img alt="" src="{{media url=\'search/radiant.jpg\'}}">Radiant</a><a href="{{store url=\'diamond-search\'}}?shape=pear"><img alt="" src="{{media url=\'search/pear.jpg\'}}">Pear</a><a href="{{store url=\'diamond-search\'}}?shape=heart"><img alt="" src="{{media url=\'search/heart.jpg\'}}">Heart</a><a href="{{store url=\'diamond-search\'}}?shape=cushion"><img alt="" src="{{media url=\'search/cushion.jpg\'}}">Cushion</a></div></div>';
	loosdiamond_simple_with_radio = '<div class="shape"><div class="imageshape"><div class="titlediamond"><h2><img src="{{media url="wysiwyg/slideshow/icon.png"}}" alt="" />  <span>diamond search</span>  <img src="{{media url="wysiwyg/slideshow/icon.png"}}" alt="" /></h2><span class="subtitle">Choose a shape and search for perfect conflict-free diamonds. To learn more about diamonds use our diamond education search.</span></div><ul><li class="first"><p><img alt="" src="{{media url=\'search/radio/round.jpg\'}}"></p><input type="radio" checked="checked" value="round" name="shape"><p>Round</p></li><li><p><img alt="" src="{{media url=\'search/radio/princess.jpg\'}}"></p><input type="radio" value="princess" name="shape"><p>Princess</p></li><li><p><img alt="" src="{{media url=\'search/radio/emerald.jpg\'}}"></p><input type="radio" value="emerald" name="shape"><p>Emerald</p></li><li class="last"><p><img alt="" src="{{media url=\'search/radio/marquise.jpg\'}}"></p><input type="radio" value="marquise" name="shape"><p>Marquise</p></li><li><p><img alt="" src="{{media url=\'search/radio/asscher.jpg\'}}"></p><input type="radio" value="asscher" name="shape"><p>Asscher</p></li><li><p><img alt="" src="{{media url=\'search/radio/oval.jpg\'}}"></p><input type="radio" value="oval" name="shape"><p>Oval</p></li><li><p><img alt="" src="{{media url=\'search/radio/radiant.jpg\'}}"></p><input type="radio" value="radiant" name="shape"><p>Radiant</p></li><li><p><img alt="" src="{{media url=\'search/radio/pear.jpg\'}}"></p><input type="radio" value="pear" name="shape"><p>Pear</p></li><li><p><img alt="" src="{{media url=\'search/radio/heart.jpg\'}}"></p><input type="radio" value="heart" name="shape"><p>Heart</p></li><li><p><img alt="" src="{{media url=\'search/radio/heart.jpg\'}}"></p><input type="radio" value="cushion" name="shape"><p>Cushion</p></li></ul><div class="search"><input class="searchloosedia-btn" type="button" value="search"></div></div></div><script>jQuery(document).ready(function(){ jQuery(\'.searchloosedia-btn\').click(function(){ window.location = \'{{store url=\'diamond-search\'}}?shape=\' + jQuery(\'input[name=shape]:checked\').val(); });});</script>';
	if(selectvalue=="with_radio")
	{ 
		/*diamindstr_without_radio = jQuery("#" + textareaname).val();
		if(diamindstr_with_radio != "")
		{
			jQuery("#" + textareaname).val(diamindstr_with_radio); 
		}
		else
		{
			jQuery("#" + textareaname).val(loosdiamond_simple_with_radio); 	
		}*/
		jQuery("#" + textareaname).val(loosdiamond_simple_with_radio); 	
	}
	else
	{
		/*diamindstr_with_radio = jQuery("#" + textareaname).val();
		if (typeof(diamindstr_without_radio) !== 'undefined')
		{
			jQuery("#" + textareaname).val(diamindstr_without_radio); 
		}
		else
		{
			jQuery("#" + textareaname).val(loosdiamond_simple_without_radio); 	
		}*/
		jQuery("#" + textareaname).val(loosdiamond_simple_without_radio); 	
	}
}
function diamondstylecontent(styleclass,selectvalue)
{
	jQuery("."+styleclass).css("display","none");
	jQuery("."+selectvalue).css("display","table-row");
	//alert(selectvalue);
}
function addshaperow(blocktype,idstr)
{
	var id = idstr + "_dynamic_shape_table";
	//alert(idstr + "  " + id);
	//homepage_element_7_diamondrow
	//alert(jQuery("#" + id + " tr").length);
	if(jQuery("#" + id + " tr").length == 2)
	{
		counter = 1;
		
	}
	else
	{
		counter = parseInt(jQuery("#"+ id + " tr:last .homepage_element_diamondrow_dynamic_shape_table_row").val()) + parseInt(1);
	}

	var html = "";
	html = html + "<tr>";
	html = html + "<td><input type='hidden' class='homepage_element_diamondrow_dynamic_shape_table_row' name='" + blocktype + "[" + idstr + "_dynamic_shape_table_row" + counter + "]' value=" + counter + " /><input type='file' name='" + blocktype + "[" + idstr + "_dynamic_shape_table_image_row" + counter + "_image]'></td>";
	html = html + "<td><input type='text' name='" + blocktype + "[" + idstr + "_dynamic_shape_table_title_row" + counter + "]'></td>";
	html = html + "<td><select name='" + blocktype + "[" + idstr + "_dynamic_shape_table_enable_row" + counter + "]' style='width: 100px;'><option value=''>Please Select</option><option value='1'>Enable</option><option value='0'>Disable</option></select></td>";
	html = html + "<td><input type='text' name='" + blocktype + "[" + idstr + "_dynamic_shape_table_sortorder_row" + counter + "]'></td>";
	html = html + "</tr>";
	jQuery("#"+id).append(html);
	jQuery("." + idstr + "_dynamic_shape_table_row_count").val(counter);
	//alert(jQuery("#"+ id + " tr:last .homepage_element_diamondrow_dynamic_shape_row").val());
	//alert(id);
	return false;
}
function homepageBannerStyle(classname, valuestr)
{
	if(valuestr == "nearby")
	{
		jQuery("." + classname + "_nearby").css("display","block");
	}
	else
	{
		jQuery("." + classname + "_nearby").css("display","none");
	}
//	alert(classname + "  " + valuestr);
}