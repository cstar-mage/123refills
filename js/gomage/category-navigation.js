/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE_AFL.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Varien
 * @package     js
 * @copyright   Copyright (c) 2014 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 */

/**
 * @classDescription simple Navigation with replacing old handlers
 * @param {String} id id of ul element with navigation lists
 * @param {Object} settings object with settings
 */
var mainNav = function() {

    var main = {
        obj_nav :   $(arguments[0]) || $("nav"),

        settings :  {
            show_delay      :   0,
            hide_delay      :   0,
            _ie6            :   /MSIE 6.+Win/.test(navigator.userAgent),
            _ie7            :   /MSIE 7.+Win/.test(navigator.userAgent)
        },

        init :  function(obj, level) {
            obj.lists = obj.childElements();
            obj.lists.each(function(el,ind){
                main.handlNavElement(el);
                if((main.settings._ie6 || main.settings._ie7) && level){
                    main.ieFixZIndex(el, ind, obj.lists.size());
                }
            });
            if(main.settings._ie6 && !level){
                document.execCommand("BackgroundImageCache", false, true);
            }
        },

        handlNavElement :   function(list) {
            if(list !== undefined){
                list.onmouseover = function(){
                    main.fireNavEvent(this,true);
                };
                list.onmouseout = function(){
                    main.fireNavEvent(this,false);
                };
                if(list.down("ul")){
                    main.init(list.down("ul"), true);
                }
            }
        },

        ieFixZIndex : function(el, i, l) {
            if(el.tagName.toString().toLowerCase().indexOf("iframe") == -1){
                el.style.zIndex = l - i;
            } else {
                el.onmouseover = "null";
                el.onmouseout = "null";
            }
        },

        fireNavEvent :  function(elm,ev) {
            if(ev){
                elm.addClassName("over");
                elm.down("a").addClassName("over");
                if (elm.childElements()[1]) {
                    main.show(elm.childElements()[1]);
                }
            } else {
                elm.removeClassName("over");
                elm.down("a").removeClassName("over");
                if (elm.childElements()[1]) {
                    main.hide(elm.childElements()[1]);
                }
            }
        },

        show : function (sub_elm) {
            if (sub_elm.hide_time_id) {
                clearTimeout(sub_elm.hide_time_id);
            }
            sub_elm.show_time_id = setTimeout(function() {
                if (!sub_elm.hasClassName("shown-sub")) {
                    sub_elm.addClassName("shown-sub");
                }
            }, main.settings.show_delay);
        },

        hide : function (sub_elm) {
            if (sub_elm.show_time_id) {
                clearTimeout(sub_elm.show_time_id);
            }
            sub_elm.hide_time_id = setTimeout(function(){
                if (sub_elm.hasClassName("shown-sub")) {
                    sub_elm.removeClassName("shown-sub");
                }
            }, main.settings.hide_delay);
        }

    };
    if (arguments[1]) {
        main.settings = Object.extend(main.settings, arguments[1]);
    }
    if (main.obj_nav) {
        main.init(main.obj_nav, false);
    }
};

navigationOpenFilters = {};
navigation_eval_js = null;
var gan_slider_datas = new Array();

document.observe("dom:loaded", function() {   	
	ganLoadForPlain();	
});

document.onreadystatechange = ganLoadForPlain;

function ganLoadForPlain() {
	mainNav("gan_nav_left", {"show_delay":"100","hide_delay":"100"});
	mainNav("gan_nav_top", {"show_delay":"100","hide_delay":"100"});
	mainNav("gan_nav_right", {"show_delay":"100","hide_delay":"100"});
	ganInitSliders();
}

function ganInitSliders(){
	for(var i=0;i< gan_slider_datas.length;i++){
      $(gan_slider_datas[i].code+'-value-from').innerHTML = gan_slider_datas[i].from;
      $(gan_slider_datas[i].code+'-value-to').innerHTML = gan_slider_datas[i].to;
      $(gan_slider_datas[i].code+'-value').innerHTML = gan_slider_datas[i].htmlvalue;
    }
    gan_slider_datas = new Array();
} 


function showNavigationNote(id, control){
	
	var arr = $(control).cumulativeOffset();
	$(id).style.left = arr[0] + 'px'; 
	$(id).style.top = arr[1] + 'px';
	$(id).style.display = 'block';			
}

function hideNavigationNote(){
	
	$$('.filter-note-content').each(function(e){e.style.display = 'none';});
	
}


function navigationOpenFilter(request_var){
	
	var id = 'advancednavigation-filter-content-'+request_var;
	
	if( $(id).style.display == 'none' ){
		
		$(id).style.display = 'block';
		
		if (navigation_eval_js) {
			eval(navigation_eval_js);
			ganInitSliders();
		}	
		
		navigationOpenFilters[request_var+'_is_open'] = true;
		
	}else{
		
		$(id).style.display = 'none' ;
		
		navigationOpenFilters[request_var+'_is_open'] = false;
		
	}	
}

function xtendNavigationOpenFilter(request_var, url){
	
	var id = 'advancednavigation-filter-content-'+request_var;
	
	if( $(id).style.display == 'none' ){
		
		$(id).style.display = 'block';
		
		if (navigation_eval_js) {
			eval(navigation_eval_js);
			ganInitSliders();
		}	
		
		navigationOpenFilters[request_var+'_is_open'] = true;
		
	}else{
		
		$(id).style.display = 'none' ;
		
		navigationOpenFilters[request_var+'_is_open'] = false;
		
		if(url != ""){
			setNavigationUrl(url);
		}
		
	}	
}