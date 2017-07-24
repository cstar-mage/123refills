var reset_offset = false;
function postQueryParams() {
	var params = new Object();
	var shapes=[];
	jQuery("ul.product-shape li.active").each(function(){
		shapes.push(jQuery(this).find("a").attr("data-shape"));
	});
	if(shapes.length===0) params.shapes = "All";
	else params.shapes = shapes.join();
	
	params.min_carat = jQuery("#input-caratmin").val();
	params.max_carat = jQuery("#input-caratmax").val();
	params.min_price = jQuery("#input-pricemin").val();
	params.max_price = jQuery("#input-pricemax").val();
	
	
	var colors = [];
	var fancycolors = [];
	var clarities = [];

	if(enable_optionslider){
		jQuery("#color_slider li").each(function(){
			if(jQuery(this).hasClass("active")){
				colors.push(jQuery(this).data("val"));
			}
		});
		params.colors = colors.join();
		
		jQuery("#fancycolor_slider li").each(function(){
			if(jQuery(this).hasClass("active")){
				fancycolors.push(jQuery(this).data("val"));
			}
		});
		params.fancycolors = fancycolors.join();
		
		jQuery("#clarity_slider li").each(function(){
			if(jQuery(this).hasClass("active")){
				clarities.push(jQuery(this).data("val"));
			}
		});
		params.clarities = clarities.join();
	}else{
		jQuery('#input-colormin > option').each(function () {
			if(this.value>=parseInt(color_slider.noUiSlider.get()[0]) && this.value<parseInt(color_slider.noUiSlider.get()[1])) colors.push(this.text);
		});
		params.colors = colors.join();
		
		jQuery('#input-fancycolormin > option').each(function () {
			if(this.value>=parseInt(fancycolor_slider.noUiSlider.get()[0]) && this.value<parseInt(fancycolor_slider.noUiSlider.get()[1])) fancycolors.push(this.text);
		});
		params.fancycolors = fancycolors.join();
		
		jQuery('#input-claritymin > option').each(function () {
			if(this.value>=parseInt(clarity_slider.noUiSlider.get()[0]) && this.value<parseInt(clarity_slider.noUiSlider.get()[1])) clarities.push(this.text);
		});
		params.clarities = clarities.join();
	}
	
	params.is_fancy = 0;
	if(jQuery("div.row.color").css('display')=='none') params.is_fancy = 1;

	params.stock_number = jQuery("#stock_number").val();
	
	var cuts = [];
	jQuery('#input-cutmin > option').each(function () {
		if(this.value>=parseInt(cut_slider.noUiSlider.get()[0]) && this.value<parseInt(cut_slider.noUiSlider.get()[1])) cuts.push(this.text);
	});
	params.cuts = cuts.join();
	
	params.min_ratio = jQuery("#input-ratiomin").val();
	params.max_ratio = jQuery("#input-ratiomax").val();

	var fluorescences = [];
	jQuery('#input-fluorescencemin > option').each(function () {
		if(this.value>=parseInt(fluorescence_slider.noUiSlider.get()[0]) && this.value<parseInt(fluorescence_slider.noUiSlider.get()[1])) fluorescences.push(this.text);
	});
	params.fluorescences = fluorescences.join();
	
	var certificates = [];
	jQuery.each(jQuery("input[name='input-certificates[]']:checked"), function() {
		certificates.push(jQuery(this).val());
	});
	params.certificates = certificates.join();
	
	var custom_certs = [];
	jQuery.each(jQuery("input[name='input-customcert[]']:checked"), function() {
		custom_certs.push(jQuery(this).val());
	});
	params.custom_certs = custom_certs.join();

	params.is_inhouse = jQuery("input[name='input-inhouse']:checked").length;
	
	var custom_images = [];
	jQuery.each(jQuery("input[name='input-images[]']:checked"), function() {
		custom_images.push(jQuery(this).val());
	});
	params.custom_images = custom_images.join();
	
	params.order=jQuery("#select_sortby option:selected").attr("data-order");
	params.sort=jQuery("#select_sortby option:selected").attr("data-sort");
	
	params.reset_offset=reset_offset;
	
	//setting params to COOKIE
	createCookie("search_params", JSON.stringify(params), cookie_exp_min);
	//return JSON.stringify(params); // body data
	return params;
}
function setShapeRanges(){
	var p_min=[];
	var p_max=[];
	var c_min=[];
	var c_max=[];
	try {
		jQuery("ul.product-shape li.active").each(function(){
			p_min.push(shape_ranges[jQuery(this).find("a").attr("data-shape")][0]);
			p_max.push(shape_ranges[jQuery(this).find("a").attr("data-shape")][1]);
			c_min.push(shape_ranges[jQuery(this).find("a").attr("data-shape")][2]);
			c_max.push(shape_ranges[jQuery(this).find("a").attr("data-shape")][3]);
		});
		
		//carat_slider.noUiSlider.set([Math.min.apply(Math,c_min), Math.max.apply(Math,c_max)]);
		//price_slider.noUiSlider.set([Math.min.apply(Math,p_min), Math.max.apply(Math,p_max)]);
		
		//Changing ranges, NOT values, So replacing this Code
		var range = {'min': Math.min.apply(Math,p_min),'max': Math.max.apply(Math,p_max)};
		if(Math.max.apply(Math,p_max)>200000){
			range = {
				'min': Math.min.apply(Math,p_min),
				'60%': 10000,
				'70%': 100000,
				'max': Math.max.apply(Math,p_max)
			}
		}
		price_slider.noUiSlider.updateOptions({
			range:range
		});
		range = {'min': Math.min.apply(Math,c_min),'max': Math.max.apply(Math,c_max)};
		if(Math.max.apply(Math,c_max)>6){
			range = {
				'min': Math.min.apply(Math,c_min),
				'60%': 3,
				'70%': 6,
				'max': Math.max.apply(Math,c_max)
			}
		}
		carat_slider.noUiSlider.updateOptions({
			range:range
		});
			
			
					
	}
	catch(ex){console.log("error setting Carat and Price ranges.\n"+ex);}
}
function colorSelectBoxChange(){
	var minCol = parseInt(jQuery("#input-colormin").val());
	var maxCol = parseInt(jQuery("#input-colormax").val());
	
	if(minCol >= maxCol){
		jQuery("#input-colormin").val(maxCol);
		minCol = maxCol;
	}
	
	jQuery("#color_slider li").removeAttr("class");
	jQuery("#color_slider li").each(function(){
		if(minCol <= jQuery(this).data("seq") && jQuery(this).data("seq") <= maxCol ){
			jQuery(this).addClass("active");
		}else{
			jQuery(this).removeClass("active");
		}
	});
}
function fancycolorSelectBoxChange(){
	var minCol = parseInt(jQuery("#input-fancycolormin").val());
	var maxCol = parseInt(jQuery("#input-fancycolormax").val());
	
	if(minCol >= maxCol){
		jQuery("#input-fancycolormin").val(maxCol);
		minCol = maxCol;
	}
	
	jQuery("#fancycolor_slider li").removeAttr("class");
	jQuery("#fancycolor_slider li").each(function(){
		if(minCol <= jQuery(this).data("seq") && jQuery(this).data("seq") <= maxCol ){
			jQuery(this).addClass("active");
		}else{
			jQuery(this).removeClass("active");
		}
	});
}
function claritySelectBoxChange(){
	var minCol = parseInt(jQuery("#input-claritymin").val());
	var maxCol = parseInt(jQuery("#input-claritymax").val());
	
	if(minCol >= maxCol){
		jQuery("#input-claritymin").val(maxCol);
		minCol = maxCol;
	}
	
	jQuery("#clarity_slider li").removeAttr("class");
	jQuery("#clarity_slider li").each(function(){
		if(minCol <= jQuery(this).data("seq") && jQuery(this).data("seq") <= maxCol ){
			jQuery(this).addClass("active");
		}else{
			jQuery(this).removeClass("active");
		}
	});
}

jQuery(document).ready(function() {
	jQuery("#refresh_search").click(function(){
		eraseCookie("search_params");
		document.location.href=jQuery(this).data("href");
	});
	// SHAPE buttons
	jQuery("ul.product-shape li a").click(function(){
		if(jQuery(this).attr("data-shape")=="All"){
			jQuery(this).parent("li").addClass("active");
			jQuery("ul.product-shape li").removeClass("active");
		}
		else{
			jQuery(this).parent("li").toggleClass("active");
			jQuery("ul.product-shape li a[data-shape='All']").parent("li").removeClass("active");
		}
		//checking for ALL conditions
		if(jQuery("ul.product-shape li.active").length==0){
			jQuery("ul.product-shape li a[data-shape='All']").parent("li").addClass("active");
		}
		
		setShapeRanges();
	});
	
	// CARAT slider
	var range = {'min': min_carat,'max': max_carat};
	if(max_carat>6){
		range = {
			'min': min_carat,
			'60%': 3,
			'70%': 6,
			'max': max_carat
		}
	}
		
	var carat_slider = document.getElementById('carat_slider');
	noUiSlider.create(carat_slider, {
		start: [min_carat, max_carat],
		connect: true,
		range: range
	});
	var inputCaratMin = document.getElementById('input-caratmin');
	var inputCaratMax = document.getElementById('input-caratmax');

	carat_slider.noUiSlider.on('update', function( values, handle ) {
		var value = values[handle];
		if ( handle ) {
			inputCaratMax.value = value;
		} else {
			inputCaratMin.value = value;
		}
	});
	inputCaratMin.addEventListener('change', function(){
		carat_slider.noUiSlider.set([this.value, null]);
	});
	inputCaratMax.addEventListener('change', function(){
		carat_slider.noUiSlider.set([null, this.value]);
	});

	// PRICE slider
	if(!is_cfp){
		var range = {'min': min_price,'max': max_price};
		if(max_price>200000){
			range = {
				'min': min_price,
				'60%': 50000,
				'70%': 200000,
				'max': max_price
			}
		}
		
		var price_slider = document.getElementById('price_slider');
		noUiSlider.create(price_slider, {
			start: [min_price, max_price],
			connect: true,
			range: range
		});
		var inputPriceMin = document.getElementById('input-pricemin');
		var inputPriceMax = document.getElementById('input-pricemax');
	
		price_slider.noUiSlider.on('update', function( values, handle ) {
			var value = values[handle];
			if ( handle ) {
				inputPriceMax.value = Math.round(value);
			} else {
				inputPriceMin.value = Math.round(value);
			}
		});
		inputPriceMin.addEventListener('change', function(){
			price_slider.noUiSlider.set([this.value, null]);
		});
		inputPriceMax.addEventListener('change', function(){
			price_slider.noUiSlider.set([null, this.value]);
		});
	}
	
	if(enable_optionslider){
		// COLOR slider
		var color_slider = document.getElementById('color_slider');
		var inputColorMin = document.getElementById('input-colormin');
		var inputColorMax = document.getElementById('input-colormax');
		jQuery("#color_slider li").click(function(){
			jQuery(this).toggleClass("active");
			if(jQuery("#color_slider li.active").length==0){
				jQuery("#color_slider li").addClass("active");
			}
		});
		inputColorMin.addEventListener('change', function(){
			colorSelectBoxChange();
		});
		inputColorMax.addEventListener('change', function(){
			colorSelectBoxChange();
		});

		// FANCYCOLOR slider
		var fancycolor_slider = document.getElementById('fancycolor_slider');
		var inputFancycolorMin = document.getElementById('input-fancycolormin');
		var inputFancycolorMax = document.getElementById('input-fancycolormax');
		jQuery("#fancycolor_slider li").click(function(){
			jQuery(this).toggleClass("active");
			if(jQuery("#fancycolor_slider li.active").length==0){
				jQuery("#fancycolor_slider li").addClass("active");
			}
		});
		inputFancycolorMin.addEventListener('change', function(){
			fancycolorSelectBoxChange();
		});
		inputFancycolorMax.addEventListener('change', function(){
			fancycolorSelectBoxChange();
		});

		// CLARITY slider
		var clarity_slider = document.getElementById('clarity_slider');
		var inputClarityMin = document.getElementById('input-claritymin');
		var inputClarityMax = document.getElementById('input-claritymax');
	
		jQuery("#clarity_slider li").click(function(){
			jQuery(this).toggleClass("active");
			if(jQuery("#clarity_slider li.active").length==0){
				jQuery("#clarity_slider li").addClass("active");
			}
		});
		
		inputClarityMin.addEventListener('change', function(){
			claritySelectBoxChange();
		});
		inputClarityMax.addEventListener('change', function(){
			claritySelectBoxChange();
		});
	}else{
		// COLOR slider
		var color_slider = document.getElementById('color_slider');
		noUiSlider.create(color_slider, {
			start: [0, sliders_data.colors.length],
			connect: true,
			margin: 1,
			step: 1,
			range: {
				'min': [0],
				'max': [sliders_data.colors.length]
			}
		});
		var inputColorMin = document.getElementById('input-colormin');
		var inputColorMax = document.getElementById('input-colormax');
	
		color_slider.noUiSlider.on('update', function( values, handle ) {
			var value = values[handle];
			
			if ( handle ) {
				inputColorMax.value = Math.round(value);
			} else {
				inputColorMin.value = Math.round(value);
			}
		});
		inputColorMin.addEventListener('change', function(){
			color_slider.noUiSlider.set([this.value, null]);
		});
		inputColorMax.addEventListener('change', function(){
			color_slider.noUiSlider.set([null, this.value]);
		});
		
		// FANCYCOLOR slider
		var fancycolor_slider = document.getElementById('fancycolor_slider');
		noUiSlider.create(fancycolor_slider, {
			start: [0, sliders_data.fancycolors.length],
			connect: true,
			margin: 1,
			step: 1,
			range: {
				'min': [0],
				'max': [sliders_data.fancycolors.length]
			}
		});
		var inputFancycolorMin = document.getElementById('input-fancycolormin');
		var inputFancycolorMax = document.getElementById('input-fancycolormax');
	
		fancycolor_slider.noUiSlider.on('update', function( values, handle ) {
			var value = values[handle];
			
			if ( handle ) {
				inputFancycolorMax.value = Math.round(value);
			} else {
				inputFancycolorMin.value = Math.round(value);
			}
		});
		inputFancycolorMin.addEventListener('change', function(){
			fancycolor_slider.noUiSlider.set([this.value, null]);
		});
		inputFancycolorMax.addEventListener('change', function(){
			fancycolor_slider.noUiSlider.set([null, this.value]);
		});
		
		// CLARITY slider
		var clarity_slider = document.getElementById('clarity_slider');
		noUiSlider.create(clarity_slider, {
			start: [0, sliders_data.clarities.length],
			connect: true,
			margin: 1,
			step: 1,
			range: {
				'min': [0],
				'max': [sliders_data.clarities.length]
			}
		});
		var inputClarityMin = document.getElementById('input-claritymin');
		var inputClarityMax = document.getElementById('input-claritymax');
	
		clarity_slider.noUiSlider.on('update', function( values, handle ) {
			var value = values[handle];
			if ( handle ) {
				inputClarityMax.value = Math.round(value);
			} else {
				inputClarityMin.value = Math.round(value);
			}
		});
		inputClarityMin.addEventListener('change', function(){
			clarity_slider.noUiSlider.set([this.value, null]);
		});
		inputClarityMax.addEventListener('change', function(){
			clarity_slider.noUiSlider.set([null, this.value]);
		});
	}
	
	//Color Switcher event
	jQuery(".color_switcher").click(function(){
		if(jQuery(this).hasClass("color")){
			jQuery("div.row.color").hide();
			jQuery("div.row.fancycolor").show();
		}
		else{
			jQuery("div.row.color").show();
			jQuery("div.row.fancycolor").hide();
		}
	});
	
	//Stocknumber Form event
	jQuery("form#frm-stocknumber").submit(function(e){
		e.preventDefault();
	});
	
	// CUT slider
	var cut_slider = document.getElementById('cut_slider');
	noUiSlider.create(cut_slider, {
		start: [0, sliders_data.cuts.length],
		connect: true,
		margin: 1,
		step: 1,
		range: {
			'min': [0],
			'max': [sliders_data.cuts.length]
		}
	});
	var inputCutMin = document.getElementById('input-cutmin');
	var inputCutMax = document.getElementById('input-cutmax');

	cut_slider.noUiSlider.on('update', function( values, handle ) {
		var value = values[handle];
		
		if ( handle ) {
			inputCutMax.value = Math.round(value);
		} else {
			inputCutMin.value = Math.round(value);
		}
	});
	inputCutMin.addEventListener('change', function(){
		cut_slider.noUiSlider.set([this.value, null]);
	});
	inputCutMax.addEventListener('change', function(){
		cut_slider.noUiSlider.set([null, this.value]);
	});
	
	// RATIO slider
	var ratio_slider = document.getElementById('ratio_slider');
	noUiSlider.create(ratio_slider, {
		start: [min_ratio, max_ratio],
		connect: true,
		range: {
			'min': min_ratio,
			'max': max_ratio
		}
	});
	var inputRatioMin = document.getElementById('input-ratiomin');
	var inputRatioMax = document.getElementById('input-ratiomax');

	ratio_slider.noUiSlider.on('update', function( values, handle ) {
		var value = values[handle];
		if ( handle ) {
			inputRatioMax.value = value;
		} else {
			inputRatioMin.value = value;
		}
	});
	inputRatioMin.addEventListener('change', function(){
		ratio_slider.noUiSlider.set([this.value, null]);
	});
	inputRatioMax.addEventListener('change', function(){
		ratio_slider.noUiSlider.set([null, this.value]);
	});
	
	// fluorescence slider
	var fluorescence_slider = document.getElementById('fluorescence_slider');
	noUiSlider.create(fluorescence_slider, {
		start: [0, sliders_data.fluorescences.length],
		connect: true,
		margin: 1,
		step: 1,
		range: {
			'min': [0],
			'max': [sliders_data.fluorescences.length]
		}
	});
	var inputFluorescenceMin = document.getElementById('input-fluorescencemin');
	var inputFluorescenceMax = document.getElementById('input-fluorescencemax');

	fluorescence_slider.noUiSlider.on('update', function( values, handle ) {
		var value = values[handle];
		
		if ( handle ) {
			inputFluorescenceMax.value = Math.round(value);
		} else {
			inputFluorescenceMin.value = Math.round(value);
		}
	});
	inputFluorescenceMin.addEventListener('change', function(){
		fluorescence_slider.noUiSlider.set([this.value, null]);
	});
	inputFluorescenceMax.addEventListener('change', function(){
		fluorescence_slider.noUiSlider.set([null, this.value]);
	});
	
	jQuery("#select_sortby").change(function(){
		console.log("asdasdas");
		jQuery("table#search-results").html("");
		reset_offset = true;
		//loadResultsData();
		jQuery(window).scroll();
		reset_offset = false;
	});
	//setting from COOKIES
	var search_params = jQuery.parseJSON(readCookie("search_params"));
	if(search_params){
		var shapes = search_params.shapes.split(',');
		
		var carat = [search_params.min_carat, search_params.max_carat];
		var price = [search_params.min_price,search_params.max_price];
		var colors = search_params.colors.split(',');
		var fancycolors = search_params.fancycolors.split(',');
		var is_fancy = search_params.is_fancy;
		var clarities = search_params.clarities.split(',');
		var stock_number = search_params.stock_number;
		var cuts = search_params.cuts.split(',');
		var ratio = [search_params.min_ratio, search_params.max_ratio];
		var fluorescences = search_params.fluorescences.split(',');
		var certificates = search_params.certificates.split(',');
		var custom_certs = search_params.custom_certs.split(',');
		var custom_images = search_params.custom_images.split(',');
		var is_inhouse = search_params.is_inhouse;
		
		jQuery("ul.product-shape li").each(function(){
			if(jQuery.inArray(jQuery(this).find("a").attr("data-shape"),shapes)!==-1)
				jQuery(this).addClass("active");
		});
		
		carat_slider.noUiSlider.set(carat);
		if(!is_cfp){
			price_slider.noUiSlider.set(price);
		}
		
		if(enable_optionslider){
			jQuery("#color_slider li").each(function(){
				if(jQuery.inArray(jQuery(this).attr("data-val"),colors) !==-1 ){
					jQuery(this).addClass("active");
				}else{
					jQuery(this).removeClass("active");
				}
			});
			jQuery("#input-colormin").val(sliders_data.colors.indexOf(colors.first()));
			jQuery("#input-colormax").val(sliders_data.colors.indexOf(colors.last()));
			
			jQuery("#fancycolor_slider li").each(function(){
				if(jQuery.inArray(jQuery(this).attr("data-val"),fancycolors) !==-1 ){
					jQuery(this).addClass("active");
				}else{
					jQuery(this).removeClass("active");
				}
			});
			jQuery("#input-fancycolormin").val(sliders_data.fancycolors.indexOf(fancycolors.first()));
			jQuery("#input-fancycolormax").val(sliders_data.fancycolors.indexOf(fancycolors.last()));
			
			jQuery("#clarity_slider li").each(function(){
				if(jQuery.inArray(jQuery(this).attr("data-val"),clarities) !==-1 ){
					jQuery(this).addClass("active");
				}else{
					jQuery(this).removeClass("active");
				}
			});
			jQuery("#input-claritymin").val(sliders_data.clarities.indexOf(clarities.first()));
			jQuery("#input-claritymax").val(sliders_data.clarities.indexOf(clarities.last()));
		}else{
			color_slider.noUiSlider.set([sliders_data.colors.indexOf(colors.first()), sliders_data.colors.indexOf(colors.last())+1]);
			fancycolor_slider.noUiSlider.set([sliders_data.fancycolors.indexOf(fancycolors.first()), sliders_data.fancycolors.indexOf(fancycolors.last())+1]);
			clarity_slider.noUiSlider.set([sliders_data.clarities.indexOf(clarities.first()), sliders_data.clarities.indexOf(clarities.last())+1]);
		}
		
		if(is_fancy==1){jQuery("div.row.color").hide();jQuery("div.row.fancycolor").show();}
		
		jQuery("#stock_number").val(stock_number);
		
		var isAdvanced = false;
		
		if(sliders_data.cuts.length!=cuts.length){
			isAdvanced=true;
			cut_slider.noUiSlider.set([sliders_data.cuts.indexOf(cuts.first()), sliders_data.cuts.indexOf(cuts.last())+1]);
		}
		if(min_ratio!=search_params.min_ratio || max_ratio!=search_params.max_ratio){
			isAdvanced=true;
			ratio_slider.noUiSlider.set(ratio);
		}
		if(sliders_data.fluorescences.length!=fluorescences.length){
			isAdvanced=true;
			fluorescence_slider.noUiSlider.set([sliders_data.fluorescences.indexOf(fluorescences.first()), sliders_data.fluorescences.indexOf(fluorescences.last())+1]);
		}
		jQuery("input[name='input-certificates[]']").each(function(){
			if(jQuery.inArray(jQuery(this).attr("data-certificate"),certificates)!==-1){
				isAdvanced=true;
				jQuery(this).prop('checked', true);
			}
		});
		
		jQuery("input[name='input-customcert[]']").each(function(){
			if(jQuery.inArray(jQuery(this).attr("data-customcert"),custom_certs)!==-1){
				isAdvanced=true;
				jQuery(this).prop('checked', true);
			}
		});
	
		if(is_inhouse){isAdvanced=true; jQuery("input[name='input-inhouse']").prop('checked', true);}

		jQuery("input[name='input-images[]']").each(function(){
			if(jQuery.inArray(jQuery(this).attr("data-images"),custom_images)!==-1){
				isAdvanced=true;
				jQuery(this).prop('checked', true);
			}
		});
		
		if(isAdvanced)jQuery('.adv_search_lnk').click();
		
	}
	else {
		//setting shape to ALL is cookie not set / First time loading
		jQuery("ul.product-shape li a[data-shape='All']").parent("li").addClass("active");
		setShapeRanges();
		if(enable_optionslider){
			jQuery("#color_slider li").addClass("active");
			jQuery("#input-colormin").val(jQuery("#color_slider li.active").first().data("seq"));
			jQuery("#input-colormax").val(jQuery("#color_slider li.active").last().data("seq"));
			
			jQuery("#fancycolor_slider li").addClass("active");
			jQuery("#input-fancycolormin").val(jQuery("#fancycolor_slider li.active").first().data("seq"));
			jQuery("#input-fancycolormax").val(jQuery("#fancycolor_slider li.active").last().data("seq"));
			
			jQuery("#clarity_slider li").addClass("active");
			jQuery("#input-claritymin").val(jQuery("#clarity_slider li.active").first().data("seq"));
			jQuery("#input-claritymax").val(jQuery("#clarity_slider li.active").last().data("seq"));
		}
	}
	//END setting from COOKIES
	
	
	jQuery('#btn_search_mobile').click(function(){
		jQuery('#filter_container').hide();
		jQuery('#mobile_search_results').show();
		jQuery("html, body").animate({ scrollTop: 0 }, "fast");
		loadResultsData();
	});
});
function loadResultsData(){
	jQuery('#searchListing').infiniteScroll({
		calculateBottom: function () {
			return (jQuery('#searchListing').position().top + jQuery('#searchListing').height()) - jQuery(window).height() + 50;
		},
		processResults: function (results) {
			jQuery('#number-of-results').html("<b>"+results.total+"</b> " + (use_as_gemsearch?"Diamonna Gems Found":"DIAMONDS FOUND"));
			
			for (var i = 0; i < results.rows.length; i++) {
				
				var result = results.rows[i];
				
				var loc = 'setLocation("'+result.view+'")';
				
				var html = "<tr onclick="+loc+"><td><table class='table "+(use_as_gemsearch?"gem-table":"")+"'>";
				if(use_as_gemsearch){
					html += "<tr>";
					if(result.image){
						html += '<td rowspan="3"><a href="'+result.view+'"><img width="60" alt="'+result.shape+'" src="'+result.image+'"></a><br>'+result.shape+'</td>';
					}else{
						//if(result.shape==result.shape_fullname){
						//	html += '<td rowspan="2"><a href="'+result.view+'"><img width="60" alt="" src="'+skin_url+'/'+result.shape.toLowerCase()+'_pic.jpg"></a><br>'+result.shape+'</td>';
						//}else{
							html += '<td rowspan="3"><a href="'+result.view+'"><img width="60" alt="'+result.shape+'" src="'+skin_url+'/'+((result.shape).replace(/\s+/g, '_')).toLowerCase()+'_pic.jpg"></a><br>'+result.shape+'</td>';
						//}
					}
					html += '   <td><span>'+(result.carat?result.carat:'-')+'</span><br>CARAT</td>';
					html += '	<td><span>'+(result.color?result.color:'-')+'</span><br>COLOR</td>';
					html += '	<td rowspan="3"><a class="glyphicon glyphicon-play" href="'+result.view+'"></a></td>';
					html += '  </tr>';
					html += "<tr>";
					html += '	<td><span>'+(result.cut?result.cut:'-')+'</span><br>CUT</td>';
					html += '	<td><span>'+(result.clarity?result.clarity:'-')+'</span><br>CLARITY</td>';
					html += '</tr>';
					html += "<tr>";
					
					var dim = (result.dimensions).replace(/-|x/g,'x');
					dim = dim.replace(/[ ]/g,'');
					html += '	<td><span>'+(dim?dim:'-')+'</span><br>MEASUREMENTS (mm)</td>';
					html += '	<td rowspan="3"><span>'+(is_cfp?("CALL"):(result.totalprice))+'</span><br>PRICE</td>';
					html += '</tr>';
				}else{
					html += "<tr>";
					if(result.image){
						html += '<td rowspan="2"><a href="'+result.view+'"><img width="60" alt="'+result.shape+'" src="'+result.image+'"></a><br>'+result.shape+'</td>';
					}else{
						//if(result.shape==result.shape_fullname){
						//	html += '<td rowspan="2"><a href="'+result.view+'"><img width="60" alt="" src="'+skin_url+'/'+result.shape.toLowerCase()+'_pic.jpg"></a><br>'+result.shape+'</td>';
						//}else{
							html += '<td rowspan="2"><a href="'+result.view+'"><img width="60" alt="'+result.shape+'" src="'+skin_url+'/'+((result.shape).replace(/\s+/g, '_')).toLowerCase()+'_pic.jpg"></a><br>'+result.shape+'</td>';
						//}
					}
					html += '   <td><span>'+(result.carat?result.carat:'-')+'</span><br>CARAT</td>';
					html += '	<td><span>'+(result.color?result.color:'-')+'</span><br>COLOR</td>';
					html += '	<td rowspan="2"><span>'+(is_cfp?("CALL"):(result.totalprice))+'</span><br></td>';
					html += '	<td rowspan="2"><a class="glyphicon glyphicon-play" href="'+result.view+'"></a></td>';
					html += '</tr>';
					html += "<tr>";
					html += '	<td><span>'+(result.cut?result.cut:'-')+'</span><br>CUT</td>';
					html += '	<td><span>'+(result.clarity?result.clarity:'-')+'</span><br>CLARITY</td>';
					html += '</tr>';					
				}
				html += '<table></td></tr>';
				
				jQuery('#search-results').append(html);
			}
		},
		url: jQuery('#searchListing').data('url'),
		getData: function () {
			return postQueryParams();
			//console.log({"shapes":"All","min_carat":"0.30","max_carat":"27.01"});
			//return {"shapes":"All","min_carat":"0.30","max_carat":"27.01"};
		}
	});
}
/************ STATIC functions ******************/
function createCookie(name, value, minute) {
    var expires;
    if (minute) {
        var date = new Date();
        //date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
		//date.setTime(date.getTime() + (hour * 60 * 60 * 1000));
		date.setTime(date.getTime() + (minute * 60 * 1000));
        expires = "; expires=" + date.toGMTString();
    } else {
        expires = "";
    }
    document.cookie = encodeURIComponent(name) + "=" + encodeURIComponent(value) + expires + "; path=/";
}
function readCookie(name) {
    var nameEQ = encodeURIComponent(name) + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) === ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) === 0) return decodeURIComponent(c.substring(nameEQ.length, c.length));
    }
    return null;
}
function eraseCookie(name) {
    createCookie(name, "", -1);
}
function unique(list) {
    var result = [];
    jQuery.each(list, function(i, e) {
        if (jQuery.inArray(e, result) == -1) result.push(e);
    });
    return result;
}

function getAbbr(short_form){
	var abbr = {
		"VG": "VERY GOOD",
		"G": "GOOD",
		"F": "FAIR",
		"I": "IDEAL",
	    "EX": "EXCELLENT",
		"N": "NONE",
	};
	if(abbr[short_form]){
		return abbr[short_form];
	}else{
		return short_form;	
	}
}

function getAbbrflour(short_form){
	var abbr = {
		"VS": "VERY STRONG",
		"S": "STRONG",
		"F": "FAINT",
		"EX": "EXCELLENT",
	    "EX": "EXCELLENT",
		"N": "NONE",
		"M":"MEDIUM",   
	};
	if(abbr[short_form]){
		return abbr[short_form];
	}else{
		return short_form;
	}
}
function getCulet(short_form){
	var abbr = {
		"L": " LARGE",
		"M": " MEDIUM",
		"N": "NONE",
		"S": " SMALL",
	    "SL": "SLIGHTLY LARGE",
		"VS": "VERY SMALL",
		 
	};
	if(abbr[short_form]){
		return abbr[short_form];
	}else{
		return short_form;	
	}
}
function getGridle(short_form){
	var abbr = {
		"M-VTK": "Medium to Very Thick",
		"STK-TK": "Slightly Thick to Thick",
		"M-M": "Medium",
		"STK-VTK": "Slightly Thick to Very Thick",
		"TN-TK": "Thin to Thick",
	    "TK-ETK": "Thick to Extremely Thick",
	    "VTN-STK":"Very Thin to Slightly Thick",
	    "TK":"Thick",
	    "M-STK":"Medium to Slightly Thick",
	    "TN":"Thin",
	    "M":"Medium",
	    "M-STK":"Medium to Slightly Thick",
	    "M-TK":"Medium to Thick",
	    "TN-STK":"Thin to Slightly Thick",
	    "M-TK" :"Medium to Thick",
	    "TN-M":"Thin to Medium",
	    "TN-VTK":"Thin to Very Thick",
	    "TK-VTK":"Thick to Very Thick",
	    "VTN-TN":"Very Thin to Thin",
	    "VTN-TK":"Very Thin to Thick",
	    "TK-TK":"Thick to Thick",
	    "ETN-STK":"Extremely Thin to Slightly Thick",
	    "STK-ETK":"Slightly Thick to Extremely Thick",
	    "VTK-ETK":"Very Thick to Extremely Thick",
	    "SLIGHTLY THIN - SLIGHTLY THIN":"Slightly Thin to Slightly Thin",
	    "SLIGHTLY THIN - SLIGHTLY THICK":"Slightly Thin to Slightly Thick",
	    "SLIGHTLY THIN - MEDIUM":"Slightly Thin to Medium",
	    "SLIGHTLY THICK - VERY THICK":"Slightly Thick to Very Thick",
	    "SLIGHTLY THICK - THIN":"Slightly Thick to Thin",
	    "SLIGHTLY THICK - THICK":"Slightly Thick to Thick",
	    "SLIGHTLY THICK - SLIGHTLY THICK":"Slightly Thick to Slightly Thick",
	    "SLIGHTLY THICK - MEDIUM":"Slightly Thick to Medium",
	    "SLIGHTLY THICK - EXTRA. THICK":"Slightly Thick to Extr. Thick",
	    "MEDIUM - VERY THICK":"Medium to Very Thick",
	    "MEDIUM - THIN":"Medium - Thin",
	    "MEDIUM - THICK":"Medium - Thick",
	    "MEDIUM - SLIGHTLY THIN": "Medium to Slightly Thin",
	    "MEDIUM - SLIGHTLY THICK":"Medium - Slightly Thick", 
	    "MEDIUM - MEDIUM":"Medium",
	    "MEDIUM - EXTR. THIN":"Medium to Extremely Thin",
	    "MEDIUM - EXTR. THICK":"Medium to Extremely Thick",
	    "EXTR. THIN - VERY THIN":"Extremely Thin to Very Thin",
	    "EXTR. THIN - VERY THICK":"Extremely Thin to Very Thick",
	    "EXTR. THIN - THIN":"Extr. Thin to Thin",	
	};  
	if(abbr[short_form]){
		return abbr[short_form];
	}else{
		return short_form;	 
	}
}
function format_mesurement(mesurevalue)
{
	var res = mesurevalue.replace(/-/g, "x");
	res = res.replace(/x/g,' x ');
	res = res.replace(/\|/g,' x ');  
	res = res.concat(' mm');
	return res;
}
