var EsNewsSubscribers = {

    cookieLiveTime: 100,

    cookieName: 'es_newssubscriber',

    baseUrl: '',

    setCookieLiveTime: function(value)
    {
        this.cookieLiveTime = value;
    },

    setCookieName: function(value)
    {
        this.cookieName = value;
    },

    setBaseUrl: function(url)
    {
        this.baseUrl = url;
    },

    getBaseUrl: function(url)
    {
        return this.baseUrl;
    },

    createCookie: function() {
        var days = this.cookieLiveTime;
        var value = 0;
        var name = this.cookieName;
        if (days) {
            var date = new Date();
            date.setTime(date.getTime()+(days*24*60*60*1000));
            var expires = "; expires="+date.toGMTString();
        }
        else var expires = "";
        document.cookie = escape(name)+"="+escape(value)+expires+"; path=/";
    },

    readCookie: function(name) {
        var name = this.cookieName;
        var nameEQ = escape(name) + "=";
        var ca = document.cookie.split(';');
        for(var i=0;i < ca.length;i++) {
            var c = ca[i];
            while (c.charAt(0)==' ') c = c.substring(1,c.length);
            if (c.indexOf(nameEQ) == 0) return unescape(c.substring(nameEQ.length,c.length));
        }
        return null;
    },
    
    deleteCookie: function(name) {
    	 var days = this.cookieLiveTime;
         var value = 1;
         var name = this.cookieName;
         if (days) {
             var date = new Date();
             date.setTime(date.getTime()+(days*24*60*60*1000));
             var expires = "; expires="+date.toGMTString();
         }
         else var expires = "";
         document.cookie = "es_newssubscribers"+"="+escape(value)+expires+"; path=/";
    },

    boxClose: function()
    {
        jQuery('#esns_background_layer').fadeOut();
    },

    boxOpen: function()
    {
        jQuery('#esns_background_layer').fadeIn();
    }
};

jQuery(function() {
    if (EsNewsSubscribers.readCookie() != 1) {
        EsNewsSubscribers.createCookie();
        EsNewsSubscribers.boxOpen();
    }
    jQuery('#newslettercheckbox').click(function(){
        if(jQuery(this).is(':checked'))
        {
           EsNewsSubscribers.deleteCookie();
     	}
        else
        {
        	EsNewsSubscribers.createCookie();     	   
     	}
     });
    jQuery('#esns_background_layer').css('height', jQuery(document).height()+'px');
    jQuery('#esns_box_layer').css('margin-top', ((jQuery(window).height()-jQuery('#esns_box_layer').height()) /2)+'px');
    
    jQuery(document).on('click', '#esns_submit', function(e) {
        var email = jQuery('#esns_email').val();
        jQuery.post(EsNewsSubscribers.getBaseUrl()+'newsletter/subscriber/newajax/', {'email':email}, function(response) {
        	 //var resp = jQuery.parseJSON(response);
        		var resp = response;
            if (resp.errorMsg) {
                jQuery('#esns_box_subscribe_response_error').html(resp.errorMsg);
            } else {
                jQuery('#esns_box_subscribe_response_error').html('');
                jQuery('#esns_box_subscribe_response_success').html(resp.successMsg);
                jQuery('#esns_box_subscribe_form').css('display','none');
                jQuery('#esns_box_subscribe_response_success').css('display','block');
                setTimeout('EsNewsSubscribers.boxClose()', 5000)
            }
        });
  	 });
    
    jQuery('#esns_box_close').click(function(){
        EsNewsSubscribers.boxClose();
    });
	
	jQuery(document).on('click', function(e) {
	  hidePopup(e); 	  
	 });
	 
	 function hidePopup(e)
	 {
		//alert(jQuery(e.target));  
		  var id = jQuery(e.target).closest("div").attr("id");
		  if(id == 'esns_background_layer')
		  {
		   EsNewsSubscribers.boxClose();
		  }
		  //EsNewsSubscribers.boxClose();
		 }
	});