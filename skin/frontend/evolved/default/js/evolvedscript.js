(function($) {
	/***************** start category page cookie ***************/ 
	$.fn.createCookie = function(cookiesName,cookiesValue) { 
		 var days = this.cookieLiveTime;
	     var value = cookiesValue;
	     var name = cookiesName;
	     if (days) {
	         var date = new Date();
	         date.setTime(date.getTime()+(days*24*60*60*1000));
	         var expires = "; expires="+date.toGMTString();
	     }
	     else var expires = "";
	     document.cookie = escape(name)+"="+escape(value)+expires+"; path=/";
	}	
	$.fn.readCookie = function(cookiesName) { 
	    var name = cookiesName;
	    var nameEQ = escape(name) + "=";
	    var ca = document.cookie.split(';');
	    for(var i=0;i < ca.length;i++) {
	        var c = ca[i];
	        while (c.charAt(0)==' ') c = c.substring(1,c.length);
	        if (c.indexOf(nameEQ) == 0) return unescape(c.substring(nameEQ.length,c.length));
	    }
	    return null;
	}
	$.fn.viewport_list = function(viewport_item) { 	
		
		if(viewport_item == "viewport_large")
		{
    		$(".products-grid").attr("id","products-grid-column-two");
    		$(this).createCookie('changed_class','viewport_large');
    		$(".products-grid li .product-image img").css("display","none");
    		$(".products-grid li .product-image img.product_row_2").css("display","block");
    		$(".products-grid li").css("width","45.864%");
    		$(".products-grid > li:nth-child(3n+1)").css("clear","none").css("margin-right","3.7037%");
    		$(".products-grid > li:nth-child(3n+3)").css("margin-right","3.7037%");
    		
		}
		else if(viewport_item == "viewport_middle")
		{
    		$(".products-grid").attr("id","products-grid-column-three");
    		$(this).createCookie('changed_class','viewport_middle');
    		$(".products-grid li .product-image img").css("display","none");
    		$(".products-grid li .product-image img.product_row_3").css("display","block");
    		$(".products-grid li").css("width","30.864%");
    		$(".products-grid > li:nth-child(2n+2),.products-grid > li:nth-child(4n+4)").css("margin-right","3.7037%");
    		$(".products-grid > li:nth-child(3n+3)").css("margin-right","0");    		
		}
		else
		{
    		$(".products-grid").attr("id","products-grid-column-four");
    		$(this).createCookie('changed_class','viewport_small');
    		$(".products-grid li .product-image img").css("display","none");
    		$(".products-grid li .product-image img.product_row_4").css("display","block");
    		$(".products-grid li").css("width","21.864%").css("clear","none");
    		$(".products-grid > li:nth-child(3n+3),.products-grid > li:nth-child(2n+2)").css("margin-right","3.7037%");
    		$(".products-grid > li:nth-child(4n+4)").css("margin-right","0");
		}
	}
	/***************** end category page cookie ***************/
	
	/***************** start sticky header function ***************/
	$.fn.stickyheader = function(){
		if($(window).width() >= 770)
		{
			//$('#header-search').removeClass("header-search-active");
			    var options = {
		            offset: '#showHere',
		            classes: {
		                clone:   'banner--clone',
		                stick:   'banner--stick',
		                unstick: 'banner--unstick'
		            }
		        };
		        var banner = new Headhesive('.banner', options);
		        // Initialise with options
		        // Headhesive destroy
		        // banner.destroy();
		}
	}
	/***************** end sticky header function ***************/
	
	/*************************** start submenu function ********************/
	
	/************************** end submenu function *********************/

	
	/***************** Start footer dropdown responsive function ***************/
	$.fn.footerdropdownresponsive = function(){
		$(".footerdropdownresponsive .footer .links .block-title").click(function(){
			if($(window).width() <= 770)
			{
				if($(this).hasClass("active")==true)
				{
					$(this).removeClass("active");
				}
				else
				{
					$(this).addClass("active");
				}
				$(this).next(".content").slideToggle();	
			}
//			$(".footerdropdownresponsive .footer .links .content").slideToggle();
		});
	}
	/***************** End footer dropdown responsive function *****************/

	/***************** Start toolbar dropdown responsive function ***************/
	$.fn.listtoolbar = function(eventstr){
		//console.log(eventstr);
		if($(window).width() > 500)
		{
	    	$(".toolbar .pager").addClass("columns_"+$(".category-products > .toolbar .pager .toolbar_block").size());

	    	/*console.log($(".toolbar .pager.columns_4").width());
	    	console.log("4 Left : " + $(".toolbar .pager.columns_4 .toolbar_block").first().width());
	    	console.log("4 Right : " + $(".toolbar .pager.columns_4 .toolbar_block").last().width());
	    	console.log("4 total : " + ($(".toolbar .pager.columns_4 .toolbar_block").first().width() + $(".toolbar .pager.columns_4 .toolbar_block").last().width()));  	
	    	console.log("4 center : " + ($(".toolbar .pager.columns_4").width() - ($(".toolbar .pager.columns_4 .toolbar_block").first().width() + $(".toolbar .pager.columns_4 .toolbar_block").last().width())));
			console.log("4 center width : "+ ($(".toolbar .pager.columns_4").width() - ($(".toolbar .pager.columns_4 .toolbar_block").first().width() + $(".toolbar .pager.columns_4 .toolbar_block").last().width())) / 2);
			*/
			//$(".toolbar .pager.columns_4 .toolbar_block").not(':first').css("width", (($(".toolbar .pager.columns_4").width() - ($(".toolbar .pager.columns_4 .toolbar_block").first().width() + $(".toolbar .pager.columns_4 .toolbar_block").last().width())) / 2) + "px");
			//$(".toolbar .pager.columns_4 .toolbar_block:last-child").css("width","auto");
			//console.log("4 tollbar height : " + $(".category-products .toolbar").height());
			var blockwidth;
			blockwidth = 0;
			//console.log($(window).width());
			$( ".category-products > .toolbar .pager.columns_4 .toolbar_block" ).each(function( index ) {
				if(($(this).css("display") != "none"))
				{
					//console.log( $(this).attr("class") + "  " + $(this).width());
					  
					  blockwidth += ($(this).width() + 1);
						//if((index != 0) && (index != ($(".category-products > .toolbar .pager .toolbar_block").size()-1))) 
						{
							  //console.log( index );
							  $(this).children().first().css("width", "auto");
							  //$(this).css("width", $(this).children().first().width() + "px");
							  //$(this).children().first().css("width", ($(this).children().width() + 1) + "px").css("display","inline-block");					  
								//$(".toolbar .pager.columns_3 .toolbar_block:nth-child(2) > div").css("width", $(".toolbar .pager.columns_3 .toolbar_block:nth-child(2) > div").width() + "px").css("display","block");	
						}
						if(eventstr == 'ajax') { $(this).css("width",($(this).children().first().width() + 4) + "px"); }
						else{ $(this).css("width",($(this).children().first().width() + 1) + "px"); }
				}
			});
			/*console.log("4 1 " + blockwidth);
			console.log("4 2 " + $(".toolbar .pager.columns_4").width() - blockwidth);
			console.log("4 3 " + ($(".toolbar .pager.columns_4").width() - blockwidth)/3);*/
			if($(window).width() > 1025)
			{
				if(eventstr == 'ajax') { $(".category-products .toolbar .pager.columns_4 .toolbar_block").css("margin-right", (($(".toolbar .pager.columns_4").width() - blockwidth)/3) - 1 + "px"); }
				else { $(".category-products .toolbar .pager.columns_4 .toolbar_block").css("margin-right", (($(".toolbar .pager.columns_4").width() - blockwidth)/3) + "px"); }
				//$(".toolbar .pager.columns_4 .toolbar_block").css("margin-right",((($(".toolbar .pager.columns_4").width() - ($(".toolbar .pager.columns_4 .toolbar_block").first().width() + $(".toolbar .pager.columns_4 .toolbar_block").last().width())) / 2) / 3) + 8 + "px");
				$(".category-products .toolbar .pager.columns_4 .toolbar_block:last-child").css("margin-right","0px");
			}
			else
			{
				if(eventstr == 'ajax'){ $(".category-products .toolbar .pager.columns_4 .toolbar_block").css("margin-right", (($(".toolbar .pager.columns_4").width() - blockwidth)/2) - 3 + "px"); }
				else { $(".category-products .toolbar .pager.columns_4 .toolbar_block").css("margin-right", (($(".toolbar .pager.columns_4").width() - blockwidth)/2) + "px"); }
				
				//$(".toolbar .pager.columns_4 .toolbar_block").css("margin-right",((($(".toolbar .pager.columns_4").width() - ($(".toolbar .pager.columns_4 .toolbar_block").first().width() + $(".toolbar .pager.columns_4 .toolbar_block").last().width())) / 2) / 3) + 8 + "px");
				$(".category-products .toolbar .pager.columns_4 .toolbar_block:last-child").css("margin-right","0px");
			}

			/*console.log($(".toolbar .pager.columns_3").width());
			console.log("3 Left : " + $(".toolbar .pager.columns_3 .toolbar_block").first().width());
			console.log("3 Right : " + $(".toolbar .pager.columns_3 .toolbar_block").last().width());
			console.log("3 total : " + ($(".toolbar .pager.columns_3 .toolbar_block").first().width() + $(".toolbar .pager.columns_3 .toolbar_block").last().width()));
			console.log("3 center : " + ($(".toolbar .pager.columns_3").width() - ($(".toolbar .pager.columns_3 .toolbar_block").first().width() + $(".toolbar .pager.columns_3 .toolbar_block").last().width())));
			console.log("3 center width : "+ ($(".toolbar .pager.columns_3").width() - ($(".toolbar .pager.columns_3 .toolbar_block").first().width() + $(".toolbar .pager.columns_3 .toolbar_block").last().width())) / 2);
			*/
			var centertoolbar = ($(".toolbar .pager.columns_3").width() - ($(".toolbar .pager.columns_3 .toolbar_block").first().width() + $(".toolbar .pager.columns_3 .toolbar_block").last().width()));
			if(eventstr == 'ajax')
			{
				$(".toolbar .pager.columns_3 .toolbar_block:nth-child(2)").css("width", (centertoolbar - 4) + "px");				
			}
			else
			{
				$(".toolbar .pager.columns_3 .toolbar_block:nth-child(2)").css("width", (centertoolbar - 1) + "px");
			}

			//console.log("width : " + $(".toolbar .pager.columns_3 .toolbar_block:nth-child(2) > .toolbarimgsize_content").width());
			$(".toolbar .pager.columns_3 .toolbar_block:nth-child(2) > div").css("width", $(".toolbar .pager.columns_3 .toolbar_block:nth-child(2) > div").width() + "px").css("display","block");	
		}
		else
		{
			/*$( ".toolbar .pager.columns_4 .toolbar_block" ).each(function( index ) {
				  $(this).css("height",$(this).height() + "px").css("width",($(this).width() + 1) + "px").css("margin","0 auto 10px").css("float","none");
			});*/
			$(".toolbar .pager.columns_3 .toolbar_block:nth-child(2)").css("width", "inherit");
		}
	}
	/***************** End toolbar dropdown responsive function *****************/
	
	/***************** Start footer fade function ***************/
	/*$.fn.fadefooter = function(){
		 	var datadelay = 0.5;
		    $( ".footer-container .links" ).each(function( index ) {
				$( this ).css("animation-delay",datadelay+"s").attr("data-animate","fadeInUp");
				datadelay += 0.3;
			});
			$(window).scroll(function() {
				var scrolled_val = $(window).scrollTop();
				//var scrolled_val = $(window).scrollTop() + $(window).height();
				var setfade = ($(".footer-container").position().top - $(".footer-container").height());
				//console.log(scrolled_val + " footer top " + $(".footer-container").position().top + " top footer : " + setfade);	
				if((scrolled_val+290) >= setfade)
				{
					$(".footer-container .links").removeClass("not-animated");
					$(".footer-container .links").addClass("animated").addClass("fadeInUp");
				}
				else
				{
					$(".footer-container .links").addClass("not-animated");
				}
			});
	}*/
	/***************** End footer fade function ***************/
	$(window).load(function(){
    	$(".wrapper .header_search_last .search_cls").click(function(e){
    		e.preventDefault();
    		if($(window).width() > 770)
    		{
    			$(".banner--clone .header_search_last #header-search").css("display","none");
        		$(".wrapper .header_search_last #header-search").css("top","30px").css("width","auto");
        		$(".wrapper .header_search_last #header-search").toggle();	
    		}
    	});	
    	$(".banner--clone .header_search_last .search_cls").click(function(e){
    		e.preventDefault();
    		if($(window).width() > 770)
    		{
    			$(".wrapper .header_search_last #header-search").css("display","none");
        		$(".banner--clone .header_search_last #header-search").css("top","30px").css("width","auto");
        		$(".banner--clone .header_search_last #header-search").toggle();	
    		}
    	});	
    	$('.skip-link.skip-search').on('click', function(e){	
    		if($(window).width() <= 770)
    		{    
        		e.preventDefault();
        		//alert($(this).hasClass("skip-active"));
        		if(($('.skip-content.mobile').hasClass("header_serach_block")) || ($("#header-search").hasClass("skip-active")==false))
        		{	
        			$(this).removeClass("skip-active");
        			$('.skip-content.mobile').removeClass("header_serach_block");	
        		}
        		else
        		{			
        			$(this).addClass("skip-active");
        			$('.skip-content.mobile').addClass("header_serach_block");	
        		}
    		} 
    		else
    		{
    			if($('.page-header-container #header-search').hasClass("header_serach_block"))
    			{
    				$('.page-header-container #header-search').removeClass("header_serach_block");
    			}
    			else
    			{
    				$('.page-header-container #header-search').addClass("header_serach_block");	
    			}
    		}
    	});
    	$('.skip-link.skip-nav').on('click', function(e){	
    		if($(window).width() <= 770)
    		{
        		e.preventDefault();
        		if($('.skip-content.mobile').hasClass("header_serach_block"))
        		{
        			$(".skip-link.skip-search").removeClass("skip-active");
        			$('.skip-content.mobile').removeClass("header_serach_block");	
        		}    			
    		}
    	});
	});
    $(window).load(function(){  

    	$( ".nav-primary li.parent a" ).each(function() {
  		  	$( this ).html( "<span class='submenusapn'>" +$( this ).html()+ "</span>" );
    	});
    	$( ".nav-primary li.parent a .submenusapn" ).css("margin-left","0px");
		/**************** start toolbar dropdown ************/
    	//console.log($(".category-products > .toolbar .pager .toolbar_block").size());

    	$(".sbHolder").each(function(index){
			$(this).css("width",($(this).children(".sbOptions").width() + 10)+"px");
			$(this).children(".sbOptions").css("width",($(this).children(".sbOptions").width() + 10)+"px");
			//console.log($(this).children(".sbOptions").attr("id") + " => " + $(this).children(".sbOptions").width());		    				
		});
		/**************** end toolbar dropdown **************/		    				
    	$(this).footerdropdownresponsive();
    	//if($(window).width() <= 770){ $(this).footerdropdownresponsive(); }
    	/***************** start all resize function ***************/
		    	$(window).resize(function(){
		    		
		    		$(this).listtoolbar('load');

		    		/***************************************************/
			    		if($(window).width() <= 500)
			    		{
			    			$("#two").click();
			    		}
			    		else if($(window).width() <= 1024)
			    		{
			    			$("#three").click();
			    		}
		    		/***************************************************/
		        	/***************** start search function ***************/
			    		if($(window).width() <= 770)
			    		{	
			    			/********** Start Footer dropdown responsive *********/
			    	    		//$(this).footerdropdownresponsive();
			    			/********** End Footer dropdown responsive ***********/	
			    	    	$( ".nav-primary li.parent a .submenusapn" ).css("margin-left","0px");
			    			$(".nav-primary li.parent a .submenusapn").on("touchstart", function(event) {
			    				event.preventDefault();
			    				window.location.href = $(this).parent("a").attr("href");		
			    			});
			    			/*$(".nav-primary li.level0.parent > a").on("touchstart", function(event) {
			    				if($(this).parent("li.level0").hasClass("menu-active")==true)
			    				{
			    					//window.location.href = $(this).attr("href");			    					
			    				}
			    				
			    			});*/
			    			$("#header-search").css("top","").css("left","").css("display","none");
			    			$(".skip-link.skip-nav").click(function(){ 
			    				if($(this).hasClass("skip-active") == false)
			    				{
			    					$(".nav-primary li").removeClass("menu-active");
			    				}
			    			});
			    			$(".nav-primary li.level1 a").click(function(){
			    				if($(this).parent("li").hasClass("sub-menu-active"))
			    				{
			    					$(".nav-primary li.level1").removeClass("sub-menu-active");
			    					$(this).parent("li").addClass("sub-menu-active");
			    				}
			    				else
			    				{
			    					$(".nav-primary li.level1").removeClass("sub-menu-active");
			    				}
			    			});
			    			$('.level2.nav-2-2-1 a').on('click', function(){ 
			    				if($('#header .nav-primary ul.level0 li.level2.nav-2-2-1').hasClass("parent"))
			    				{
			    					$('#header .nav-primary ul.level0 li.level1.nav-2-2.parent').addClass("sub-menu-active");
			    				}
			    				else
			    				{
			    					$('#header .nav-primary ul.level0 li.level1.nav-2-2.parent').removeClass("sub-menu-active");	
			    				}
			    			});
			    			$('.level2.nav-2-2 a').on('click', function(){ 		
			    				if($('#header .nav-primary ul.level0 li.level2.nav-2-2-1').hasClass("sub-menu-active"))
			    				{
			    					$('#header .nav-primary ul.level0 li.level1.nav-2-2-1.parent').removeClass("sub-menu-active");
			    				}
			    				else
			    				{
			    					$('#header .nav-primary ul.level0 li.level1.nav-2-2-1.parent').removeClass("sub-menu-active");	
			    				}	
			    			});
			    			 $(document).click(function (e) {
			    				 if (!$(e.target).is('#header-nav ,#nav,  #nav .nav-primary, #nav .nav-primary li,#nav .nav-primary li ul, #nav .nav-primary li ul li, #nav .nav-primary li a, #nav .nav-primary li ul li a, #nav .nav-primary li ul li ul li , #nav .nav-primary li ul li ul li a, .skip-link.skip-nav.skip-active, .skip-link.skip-nav.skip-active .icon , .skip-link.skip-nav.skip-active .label')) {		 
			    					 if ($("#header-nav" ).is(":visible")) {			 
			    						 $("#header-nav" ).removeClass("skip-active");
			    						 $(".nav-primary li").removeClass("menu-active");
			    						 $(".skip-link.skip-nav").removeClass("skip-active"); 
			    					 }		 
			    				 }
			    			});
			    		}
			    		else
			    		{
			    			/*$(".nav-primary li.level0.parent > a").on("touchstart", function(event) {			    				
			    				window.location.href = $(this).attr("href");
			    			});*/
			    			/********** Start Footer dropdown responsive *********/
		    	    		//$(this).footerdropdownresponsive();
			    			$(".footerdropdownresponsive .footer .links .content").css("display","");
			    			$(".footerdropdownresponsive .footer .links .block-title").removeClass("active");
			    			/********** End Footer dropdown responsive ***********/	
			    			/*$(".header_search_last a.search_cls").click(function(event){
			    				event.preventDefault();
			    				$(".header_search_last #header-search").css("top",($(this).offset().top + 25) + "px");
			    			});*/
			    			/*$(document).click(function(e){
					    				if($("#header-search").css("display") == "block")
						    			{
					    					var container = $("#header-search,.search_cls");
				    					    if (!container.is(e.target) && container.has(e.target).length === 0) // ... nor a descendant of the container
				    					    {
				    					    	$("#header-search").css("display","none");
				    					    }	
						    			}
			    			});	*/
			    		}
		        	/***************** end search function ***************/
		    		
		        	/***************** start sticky header function ***************/
		    			//$(this).stickyheader();
		        	/***************** end sticky header function ***************/
			    		
		    		/***************** Start footer fade function ***************/
		    	   // $(this).fadefooter();
		    		/***************** End footer fade function ***************/
			    		
		    	});
	    	/***************** end all resize function ***************/
	    	
	    	/***************** start category page cookie ***************/ 
		    	//alert($( ".toolbar" ).find( ".toolbarimgsize" ));
		    		
		    	if($( ".toolbar .toolbar_block" ).hasClass("toolbarimgsize") == true)
		    	{
			    	$(this).viewport_list($(this).readCookie('changed_class'));
			    	$(".category-products #two").click(function(){
			    		$(this).viewport_list('viewport_large');
			    	});
			    	$(".category-products #three").click(function(){
			    		$(this).viewport_list('viewport_middle');
			    	});
			    	$(".category-products #four").click(function(){
			    		$(this).viewport_list('viewport_small');
			    	});		    		
		    	}
	    	/***************** end category page cookie ***************/
	    	
	    	/***************** start to call resize function ***************/
	    		$(window).resize();
    	/***************** end to call resize function ***************/ 
	   
		/***************** Start footer fade function ***************/
	   // $(this).fadefooter();
		/***************** End footer fade function ***************/
    });
    $(document).on('click', '.category-products #two', function () {
    	$(this).viewport_list('viewport_large');
    });
    $(document).on('click', '.category-products #three', function () {
    	$(this).viewport_list('viewport_middle');
    });
    $(document).on('click', '.category-products #four', function () {
    	$(this).viewport_list('viewport_small');
    });
}(jQuery));
