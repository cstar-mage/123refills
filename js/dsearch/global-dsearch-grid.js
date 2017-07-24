var results_table, recentlyview_table, compare_table;
var lastAjax = null;
var dontshowAttrListStatic = ['gem_advisor', 'helium_report'];
var param_offset=0;
var selections = [];
function preparePostParams() {
	var params=new Object();
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
	jQuery('#input-colormin > option').each(function () {
		if(this.value>=parseInt(color_slider.noUiSlider.get()[0]) && this.value<parseInt(color_slider.noUiSlider.get()[1])) colors.push(this.text);
	});
	params.colors = colors.join();
	
	var fancycolors = [];
	jQuery('#input-fancycolormin > option').each(function () {
		if(this.value>=parseInt(fancycolor_slider.noUiSlider.get()[0]) && this.value<parseInt(fancycolor_slider.noUiSlider.get()[1])) fancycolors.push(this.text);
	});
	params.fancycolors = fancycolors.join();
	
	params.is_fancy = 0;
	if(jQuery("div.row.color").css('display')=='none') params.is_fancy = 1;

	var clarities = [];
	jQuery('#input-claritymin > option').each(function () {
		if(this.value>=parseInt(clarity_slider.noUiSlider.get()[0]) && this.value<parseInt(clarity_slider.noUiSlider.get()[1])) clarities.push(this.text);
	});
	params.clarities = clarities.join();
	
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
	
	params.limit = jQuery("#show_limit").val();
	//params.offset = (jQuery('#pagination_grid li.active a').attr("data-pn")-1)*jQuery("#show_limit").val();
	params.offset = param_offset;
	param_offset=0;
	
	params.order = jQuery("#sort_dir").attr("data-dir");
	params.sort = jQuery("#sort_by").val();
	
	params.compare_params = readCookie("compare_params");

	//setting params to COOKIE
	createCookie("search_params", JSON.stringify(params), 1);
	//return JSON.stringify(params); // body data
	return params;
}
function toQueryString(obj){
	var formattedVals = [];
	for(var prop in obj){
		formattedVals.push(prop + "=" + obj[prop]);
	}
	return formattedVals.join("&");
}
function prepareShareableUrl(){
	//For Browser state urls
	var baseUrl = sharing_url +'?shared=1&';
	var preparedUrl = "";
	var allParams = new Array();
	
	var search_params = jQuery.parseJSON(readCookie("search_params"));
	if(search_params){
		preparedUrl = toQueryString(search_params);
	}
	jQuery("#share_link_block #share_link_text").val(baseUrl+toQueryString(search_params));
	jQuery("#share_link_block").toggle("fast");
	//console.log(baseUrl+toQueryString(search_params));
	//window.history.pushState('search_results', 'Search Results', baseUrl+preparedUrl);
}
function preparePagination(total_pages, curr_page){
	//console.log("total_pages" + total_pages + "curr_page" + curr_page);
	//jQuery("#pagination_grid")
	
	var startPage = curr_page - 2;
	var endPage = curr_page + 2;
	
	if (startPage <= 0) {
		endPage -= (startPage - 1);
		startPage = 1;
	}
	if (endPage > total_pages)
		endPage = total_pages;
		
	var pages = [];
	
	if (startPage > 1) pages.push('<li><a data-pn="1" title="First" href="javascript:">&laquo;</a></li>');
	
	for(var i=startPage; i<=endPage; i++) {
		if(i==curr_page)
			pages.push('<li class="active"><a data-pn="'+i+'" href="javascript:">'+i+'</a></li>');
		else
			pages.push('<li><a data-pn="'+i+'" href="javascript:">'+i+'</a></li>');
	}
	if (endPage < total_pages) pages.push('<li><a data-pn="'+total_pages+'" title="Last" href="javascript:">&raquo;</a></li>');

	jQuery("#pagination_grid").html(pages.join(""));
													
}
function fillTable(rows, tablename){
	var results_html = "";
	for(var i=0;i<rows.length;i++){
		results_html += "<div class='col-md-3 text-center pt15 item'>";
		if(rows[i].image){
			results_html += "<div class='diam-image'>";
			results_html += "<img src='"+rows[i].image+"' class='img-responsive' />";
			results_html += "</div>";
		}else{
			results_html += "<div class='diam-image'>";
			results_html += "Image not Available";
			results_html += "</div>";					
		}
		
		results_html += "<div class='shape-name'>"+rows[i].shape_fullname+"</div>";
		results_html += "<div class='info'>";
		if(rows[i].carat)
			results_html += rows[i].carat+"CT ";
		if(rows[i].color)
			results_html += rows[i].color+" ";
		if(rows[i].clarity)
			results_html += rows[i].clarity+" ";
		if(rows[i].color)
			results_html += rows[i].cut+" CUT";
		results_html += "</div>";

		results_html += "<div class='diam-price'>"+rows[i].totalprice+"</div>";
		
		results_html += "<div class='row pt10 buttons'>";

		results_html += "<div class='col-md-6'><a href='"+addtocart_url+"/id/"+rows[i].id+"' class='btn btn-block btn-addtocart'>ADD TO CART</a></div>";
		results_html += "<div class='col-md-6'><a href='"+rows[i].view+"' class='btn btn-block btn-viewdetail'>VIEW DETAILS</a></div>";
		results_html += "</div>";
		
		results_html += "</div>";
		if((i+1)%4==0)results_html += "<div class='itm-clr'></div>";
	}
	if (!results_html.trim())
		jQuery(tablename).html("<div class='col-md-12 pt10'>No Diamonds Found</div>");
	else	
		jQuery(tablename).html(results_html);
}

function getResultsTable() {
	request_params = preparePostParams();
	
	if(lastAjax) lastAjax.abort();
	lastAjax = jQuery.ajax({
		type: "POST",
		url: jQuery("#results_table").data("url"),
		data: (request_params),
		success: function(data){
			//preparing pagination
			preparePagination(data.total_pages, data.curr_page);
			fillTable(data.rows, "#results_table");
		},
		dataType: 'json'
	});

	lastAjax.done(function(data){
		if(data.total>0)
			jQuery("#total_summary").html("Items " + ( ( (jQuery('#pagination_grid li.active a').attr("data-pn")-1)*jQuery("#show_limit").val() ) + 1 ) + " to " + ( (((jQuery('#pagination_grid li.active a').attr("data-pn"))*jQuery("#show_limit").val()) > data.total) ? data.total : ((jQuery('#pagination_grid li.active a').attr("data-pn"))*jQuery("#show_limit").val()) ) + " of " + data.total + " total");
		else
			jQuery("#total_summary").empty();
		jQuery("#results-tab span").html(data.total);
		jQuery("#results_loader").hide();
	});
}
function getRecentlyviewTable() {
	request_params = preparePostParams();
	
	//if(lastAjax) lastAjax.abort();
	var r_ajax = jQuery.ajax({
		type: "POST",
		url: jQuery("#recentlyview_table").data("url"),
		data: (request_params),
		success: function(data){
			fillTable(data.rows, "#recentlyview_table");
		},
		dataType: 'json'
	});
	r_ajax.done(function(data){
		jQuery("#recentlyview-tab span").html(data.total);
		jQuery("#results_loader").hide();
	});
}
function getCompareTable(){
	request_params = preparePostParams();

	//if(lastAjax) lastAjax.abort();
	var c_ajax = jQuery.ajax({
		type: "POST",
		url: jQuery("#compare_table").data("url"),
		data: (request_params),
		success: function(data){
			fillTable(data.rows, "#compare_table");
		},
		dataType: 'json'
	});
	c_ajax.done(function(data){
		jQuery("#compare-tab span").html(data.total);
		jQuery("#results_loader").hide();
	});
}

function addCompareParamsCookie(rowId){
	var compare_params = [];
	if(readCookie("compare_params")) compare_params = readCookie("compare_params").split(',');
	if(compare_params.length>=5){
		results_table.bootstrapTable("uncheckBy", {field:"id", values:[parseInt(rowId)]});
		alert("Can not compare more than five diamonds");
		return false;
	}
	var isIn = false;
	for(var i=0;i<compare_params.length;i++){
		if(compare_params[i]==rowId) {isIn=true; break;}
	}
	if(!isIn) compare_params.push((rowId));
	createCookie("compare_params", compare_params, 1);
	return true;
}
function removeCompareParamsCookie(rowId,isRefresh){
	var compare_params = [];
	if(readCookie("compare_params")) compare_params = readCookie("compare_params").split(',');
	compare_params = jQuery.grep(compare_params, function( n, i ) {
	  return n != rowId;
	});
	createCookie("compare_params", compare_params, 1);
	if(isRefresh){
		removeRowFromCompareTable(rowId);
		results_table.bootstrapTable("uncheckBy", {field:"id", values:[parseInt(rowId)]});
	}
}
function addRowToCompareTable(row){
	jQuery("#compare_table tr").each(function(){
		var attr = "-";
		if((typeof row[ jQuery(this).attr("data-colid") ] != 'undefined') && jQuery.trim(row[ jQuery(this).attr("data-colid") ]) != ""){
			attr = row[jQuery(this).attr("data-colid")];
			if(jQuery(this).attr("data-colid")=='polish') attr = getAbbr(attr);
			if(jQuery(this).attr("data-colid")=='fluorescence') attr = getAbbrflour(attr);
			if(jQuery(this).attr("data-colid")=='symmetry') attr = getAbbr(attr);
			if(jQuery(this).attr("data-colid")=='dimensions') attr = format_mesurement(attr);
			if(jQuery(this).attr("data-colid")=='culet') attr = getCulet(attr);
			if(jQuery(this).attr("data-colid")=='girdle') attr = getGridle(attr);
			
			if(jQuery(this).attr("data-colid")=='image') attr = "<img src='"+attr+"' class='img-responsive' width='150' />";
			
			if(jQuery(this).attr("data-colid")=='view') attr = '<a class="btn-sm btn-primary compare-viewlink" href="'+attr+'">View</a>&nbsp;<a class="btn-sm btn-danger compare-deletelink" href="javascript:" onclick="removeCompareParamsCookie('+row.id+',true)">Remove</a>';
		}
		jQuery(this).append('<td align="center" data-rowid="'+row.id+'">'+attr+'</td>');
	});
}
function removeRowFromCompareTable(rowId){
	jQuery("#compare_table tr td[data-rowid="+rowId+"]").remove();
}
function refreshCompareTable(){
	var compare_params = [];
	if(readCookie("compare_params")) compare_params = readCookie("compare_params").split(',');
	if(compare_params.length==0){
		jQuery("#compare_table").html('<tr><td align="center">No diamonds to compare</td></tr>');
		return;
	}
	
	var compTbl = "";
	var attr_pos = JSON.parse(JSON.stringify(attribute_position.concat()));
	attr_pos.push({"avilability":"1","DetailsCode":"view","JsCode":"view","Label":"View / Remove","sortorder":"1000"});
	
	for(var i=0;i<attr_pos.length;i++){
		if(attr_pos[i].avilability){

			//if(jQuery.inArray(attr_pos[i].DetailsCode, dontshowAttrListStatic) !== -1) continue;

			if(attr_pos[i].DetailsCode=='country' && show_origin==false)continue;
			if(attr_pos[i].DetailsCode=='percent_rap' && show_rapper==false)continue;
			compTbl += "<tr><th><b>"+attr_pos[i].Label+"</b></th>";
			
			for(var cp=0;cp<compare_params.length;cp++){
				var row = results_table.bootstrapTable('getRowByUniqueId',compare_params[cp]);
				var attr = "-";
				if((typeof row[ attr_pos[i].DetailsCode ] != 'undefined') && jQuery.trim(row[ attr_pos[i].DetailsCode ]) != ""){
					
					attr = row[attr_pos[i].DetailsCode];
					if(attr_pos[i].DetailsCode=='polish') attr = getAbbr(attr);
					if(attr_pos[i].DetailsCode=='fluorescence') attr = getAbbrflour(attr);
					if(attr_pos[i].DetailsCode=='symmetry') attr = getAbbr(attr);
					if(attr_pos[i].DetailsCode=='dimensions') attr = format_mesurement(attr);
					if(attr_pos[i].DetailsCode=='culet') attr = getCulet(attr);
					if(attr_pos[i].DetailsCode=='girdle') attr = getGridle(attr);
					if(attr_pos[i].DetailsCode=='view') attr = '<a class="btn-sm btn-primary compare-viewlink" href="'+attr+'">View</a>&nbsp;<a class="btn-sm btn-danger compare-deletelink" href="javascript:" onclick="removeCompareParamsCookie('+row.id+',true)">Remove</a>';
				}
				compTbl += "<td>"+attr+"</td>";
			}
			compTbl += "</tr>";
		}
	}
	jQuery("#compare_table").html(compTbl);
	
}
function getIdSelections() {
	return jQuery.map(results_table.bootstrapTable('getSelections'), function (row) {
		return row.id
	});
}
function resultstableResponseHandler(res) {
	jQuery.each(res.rows, function (i, row) {
		row.state = jQuery.inArray(row.id, selections) !== -1;
	});
	jQuery("#results-tab span.badge").html(res.total);
	return res;
}
function recentlyviewtableResponseHandler(res) {
	jQuery.each(res.rows, function (i, row) {
		row.state = jQuery.inArray(row.id, selections) !== -1;
	});
	jQuery("#recentlyview-tab span.badge").html(res.total);
	return res;
}
function detailFormatter(index, row) {
	var html = [];
	jQuery.each(row, function (key, value) {
		html.push('<p><b>' + key + ':</b> ' + value + '</p>');
	});
	return html.join('');
}
function operateFormatter(value, row, index) {
	return ['<a class="like" href="'+value+'" title="View">','View','</a>'].join('');
}
function totalTextFormatter(data) {
	return 'Total';
}
function totalNameFormatter(data) {
	return data.length;
}
function totalPriceFormatter(data) {
	var total = 0;
	jQuery.each(data, function (i, row) {
		total += +(row.price.substring(1));
	});
	return '$' + total;
}
function getHeight() {
	return jQuery(window).height() - jQuery('h1').outerHeight(true);
}
function showDetailsBlock(row,detailsId){
	if(row==null) return;
	
	var htm = "";
	var list = [];
	
	for(var i=0;i<attribute_position.length;i++){

		if(attribute_position[i].avilability && (typeof row[attribute_position[i].DetailsCode] != 'undefined') && jQuery.trim(row[attribute_position[i].DetailsCode]) != ""){
			if(attribute_position[i].DetailsCode=='country' && show_origin==false)continue;
			if(attribute_position[i].DetailsCode=='percent_rap' && show_rapper==false)continue;
			var attr = row[attribute_position[i].DetailsCode];
			if(attribute_position[i].DetailsCode=='polish') attr = getAbbr(attr);
			if(attribute_position[i].DetailsCode=='fluorescence') attr = getAbbrflour(attr);
			if(attribute_position[i].DetailsCode=='symmetry') attr = getAbbr(attr);
			if(attribute_position[i].DetailsCode=='dimensions') attr = format_mesurement(attr);
			if(attribute_position[i].DetailsCode=='culet') attr = getCulet(attr);
			if(attribute_position[i].DetailsCode=='girdle') attr = getGridle(attr);

			//if(jQuery.inArray(attribute_position[i].DetailsCode, dontshowAttrListStatic) !== -1) continue;

			list.push('<li class="list-group-item"><span class="badge">'+attr+'</span>'+attribute_position[i].Label+'</li>');
		}
	}
	htm += '<a href="'+row["view"]+'" class="btn btn-lg btn-viewdiamond" style="width:100%">VIEW DIAMOND</a>';
	htm += '<div class="row">';
	if(row["image"])
		htm += '<div class="col-md-12 text-center pt10"><img src="'+row["image"]+'" class="img-responsive"/></div>';
	htm += '<div class="col-md-12 text-center text-uppercase pt10" style="font-family:economicabold">'+row["shape_fullname"]+'</div>';
	htm += "</div>";
	htm += '<ul class="list-group pt5">'+list.join("")+'</ul>';
	//htm += "</div>";
	jQuery("#"+detailsId+"-viewdetails").html(htm);
}
function setShapeRanges(){
	var p_min=[];
	var p_max=[];
	var c_min=[];
	var c_max=[];
	
	try{
		jQuery("ul.product-shape li.active").each(function(){
			//try {
				p_min.push(shape_ranges[jQuery(this).find("a").attr("data-shape")][0]);
				p_max.push(shape_ranges[jQuery(this).find("a").attr("data-shape")][1]);
				c_min.push(shape_ranges[jQuery(this).find("a").attr("data-shape")][2]);
				c_max.push(shape_ranges[jQuery(this).find("a").attr("data-shape")][3]);
			//}catch(ex){console.log(jQuery(this).find("a").attr("data-shape") + " Shape not found.\n"+ex);}
		});
		//try {
			carat_slider.noUiSlider.set([Math.min.apply(Math,c_min), Math.max.apply(Math,c_max)]);
			price_slider.noUiSlider.set([Math.min.apply(Math,p_min), Math.max.apply(Math,p_max)]);
		//}catch(ex){console.log("Error setting Carat and Price ranges.\n"+ex);}
	}catch(ex){console.log("Error setting Carat and Price ranges.\n"+ex);}
	
}

jQuery(document).ready(function() {
	jQuery("#share_search").click(function(){
		prepareShareableUrl();
	});
	jQuery("#refresh_search").click(function(){
		eraseCookie("search_params");
		eraseCookie("compare_params");
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
		
		getResultsTable();
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
	carat_slider.noUiSlider.on('change', function(){
		getResultsTable();
	});
	inputCaratMin.addEventListener('change', function(){
		carat_slider.noUiSlider.set([this.value, null]);
		getResultsTable();
	});
	inputCaratMax.addEventListener('change', function(){
		carat_slider.noUiSlider.set([null, this.value]);
		getResultsTable();
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
		price_slider.noUiSlider.on('change', function(){
			getResultsTable();
		});
		inputPriceMin.addEventListener('change', function(){
			price_slider.noUiSlider.set([this.value, null]);
			getResultsTable();
		});
		inputPriceMax.addEventListener('change', function(){
			price_slider.noUiSlider.set([null, this.value]);
			getResultsTable();
		});
	}
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
	color_slider.noUiSlider.on('change', function(){
		getResultsTable();
	});
	inputColorMin.addEventListener('change', function(){
		color_slider.noUiSlider.set([this.value, null]);
		getResultsTable();
	});
	inputColorMax.addEventListener('change', function(){
		color_slider.noUiSlider.set([null, this.value]);
		getResultsTable();
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
	fancycolor_slider.noUiSlider.on('change', function(){
		getResultsTable();
	});
	inputFancycolorMin.addEventListener('change', function(){
		fancycolor_slider.noUiSlider.set([this.value, null]);
		getResultsTable();
	});
	inputFancycolorMax.addEventListener('change', function(){
		fancycolor_slider.noUiSlider.set([null, this.value]);
		getResultsTable();
	});
	
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
		getResultsTable();
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
	clarity_slider.noUiSlider.on('change', function(){
		getResultsTable();
	});
	inputClarityMin.addEventListener('change', function(){
		clarity_slider.noUiSlider.set([this.value, null]);
		getResultsTable();
	});
	inputClarityMax.addEventListener('change', function(){
		clarity_slider.noUiSlider.set([null, this.value]);
		getResultsTable();
	});
	
	//Stocknumber Form event
	jQuery("form#frm-stocknumber").submit(function(e){
		e.preventDefault();
		getResultsTable();
	});
	jQuery(".chk-showcols").change(function(){
		if(jQuery(this).is(":checked"))
			results_table.bootstrapTable('showColumn', jQuery(this).val());
		else
			results_table.bootstrapTable('hideColumn', jQuery(this).val());
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
	cut_slider.noUiSlider.on('change', function(){
		jQuery("input.chk-showcols[value='cut']").prop('checked', true);
		results_table.bootstrapTable('showColumn', 'cut');
		getResultsTable();
	});
	inputCutMin.addEventListener('change', function(){
		cut_slider.noUiSlider.set([this.value, null]);
		getResultsTable();
	});
	inputCutMax.addEventListener('change', function(){
		cut_slider.noUiSlider.set([null, this.value]);
		getResultsTable();
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
	ratio_slider.noUiSlider.on('change', function(){
		jQuery("input.chk-showcols[value='ratio']").prop('checked', true);
		results_table.bootstrapTable('showColumn', 'ratio');
		getResultsTable();
	});
	inputRatioMin.addEventListener('change', function(){
		ratio_slider.noUiSlider.set([this.value, null]);
		getResultsTable();
	});
	inputRatioMax.addEventListener('change', function(){
		ratio_slider.noUiSlider.set([null, this.value]);
		getResultsTable();
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
	fluorescence_slider.noUiSlider.on('change', function(){
		jQuery("input.chk-showcols[value='fluorescence']").prop('checked', true);
		results_table.bootstrapTable('showColumn', 'fluorescence');
		getResultsTable();
	});
	inputFluorescenceMin.addEventListener('change', function(){
		fluorescence_slider.noUiSlider.set([this.value, null]);
		getResultsTable();
	});
	inputFluorescenceMax.addEventListener('change', function(){
		fluorescence_slider.noUiSlider.set([null, this.value]);
		getResultsTable();
	});
	
	jQuery(".chk-certificates").change(function(){
		jQuery("input.chk-showcols[value='certificate']").prop('checked', true);
		results_table.bootstrapTable('showColumn', 'certificate');
		getResultsTable();
	});
	jQuery(".chk-customcert").change(function(){
		getResultsTable();
	});
	jQuery(".chk-inhouse").change(function(){
		getResultsTable();
	});
	jQuery(".chk-images").change(function(){
		getResultsTable();
	});
	
	/*
	//TAB events
	jQuery('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
		if(jQuery(this).attr("data-table")){
			eval(jQuery(this).attr("data-table")).bootstrapTable('resetView', {
				height: getHeight()
			});
		}
		//console.log('showing tab ' + e.target); // Active Tab
		//console.log('showing tab ' + e.relatedTarget); // Previous Tab
	});
	*/
	jQuery(document).on('change','#sort_by', function(e){
		param_offset=(jQuery('#pagination_grid li.active a').attr("data-pn")-1)*jQuery("#show_limit").val();
		getResultsTable();
	});
	jQuery(document).on('click','#sort_dir', function(e){
		if(jQuery(this).attr("data-dir")=="asc") 
			jQuery(this).attr("data-dir","desc");
		else
			jQuery(this).attr("data-dir","asc");

		param_offset=(jQuery('#pagination_grid li.active a').attr("data-pn")-1)*jQuery("#show_limit").val();
		getResultsTable();
	});
	jQuery(document).on('change','#show_limit', function(e){
		getResultsTable();
	});
	jQuery(document).on('click','#pagination_grid li a', function(e){
		if(jQuery(this).parent("li").hasClass("active"))
			e.preventDefault();
		else {
			jQuery('#pagination_grid li').removeClass("active");
			jQuery(this).parent("li").addClass("active");
			
			param_offset=(jQuery('#pagination_grid li.active a').attr("data-pn")-1)*jQuery("#show_limit").val();
			
			getResultsTable();
		}
	});
	
	/*
	//ROW hover events
	jQuery(document).on('mouseover','table#results_table tbody tr', function(e){
		showDetailsBlock(results_table.bootstrapTable('getRowByUniqueId',jQuery(this).attr("data-uniqueid")),"results");
	});
	jQuery(document).on('mouseover','table#recentlyview_table tbody tr', function(e){
		showDetailsBlock(recentlyview_table.bootstrapTable('getRowByUniqueId',jQuery(this).attr("data-uniqueid")),"recentlyview");
	});
	//ENDS ROW hover events
	*/
	
	//var search_params;
	/* CHCKING FOR SHARED Urls */
	if(is_shared_url){
		eraseCookie("search_params");
		createCookie("search_params", JSON.stringify(shared_params), 1);
	}
	
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
		
		/*
		sort_by = search_params.sort;
		order_by = search_params.order;
		*/
		
		jQuery("ul.product-shape li").each(function(){
			if(jQuery.inArray(jQuery(this).find("a").attr("data-shape"),shapes)!==-1)
				jQuery(this).addClass("active");
		});
		
		carat_slider.noUiSlider.set(carat);
		if(!is_cfp){
			price_slider.noUiSlider.set(price);
		}
		color_slider.noUiSlider.set([sliders_data.colors.indexOf(colors.first()), sliders_data.colors.indexOf(colors.last())+1]);
		fancycolor_slider.noUiSlider.set([sliders_data.fancycolors.indexOf(fancycolors.first()), sliders_data.fancycolors.indexOf(fancycolors.last())+1]);
		if(is_fancy==1){jQuery("div.row.color").hide();jQuery("div.row.fancycolor").show();}
		
		clarity_slider.noUiSlider.set([sliders_data.clarities.indexOf(clarities.first()), sliders_data.clarities.indexOf(clarities.last())+1]);
		
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
	
		if(is_inhouse){/* isAdvanced=true; */ jQuery("input[name='input-inhouse']").prop('checked', true);}

		jQuery("input[name='input-images[]']").each(function(){
			if(jQuery.inArray(jQuery(this).attr("data-images"),custom_images)!==-1){
				isAdvanced=true;
				jQuery(this).prop('checked', true);
			}
		});
		
		if(isAdvanced)jQuery('.adv_search_lnk').click();
		
		jQuery("#sort_by").val(search_params.sort);
		jQuery("#sort_dir").attr("data-dir", search_params.order);
		jQuery("#show_limit").val(search_params.limit);
	}
	else {
		//setting shape to ALL is cookie not set / First time loading
		jQuery("ul.product-shape li a[data-shape='All']").parent("li").addClass("active");
		setShapeRanges();
	}
	//END setting from COOKIES
	
	results_table = jQuery('#results_table');
	getResultsTable();
	
	getRecentlyviewTable();
	getCompareTable();
	
	/*
	recentlyview_table = jQuery('#recentlyview_table');
	initRecentlyviewTable();
	recentlyview_table.bootstrapTable('hideColumn', 'id');
	
	initCompareTable();
	*/
});

/************ STATIC functions ******************/
function createCookie(name, value, hour) {
    var expires;
    if (hour) {
        var date = new Date();
        //date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
		date.setTime(date.getTime() + (hour * 60 * 60 * 1000));
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