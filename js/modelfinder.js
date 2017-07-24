
jQuery( document ).ready(function() { 
	
    jQuery(".dropdown-element #finder111------").change(function() {
  		//alert( "Handler for .change() called." );
		var value = jQuery(this).val();
		//alert(value);
		 jQuery("#finder22 option").remove();	
		 jQuery('#finder22').append('<option value="load">Loading .. </option>'); 
		 jQuery.ajax(
		 {	
			url : formURL,
			type: "GET",
	        data : {id:value},
 	        success:function(data, textStatus, jqXHR) 
	        {
		 		jQuery("#finder22 option[value='load']").remove();
				 //init(formData);		
				jQuery("#finder22").append(data);
	        }
	    });
		
	});  
	
	
	jQuery(".dropdown-element #finder222-----").change(function() {
  		//alert( "Handler for .change() called." );
		var value = jQuery(this).val();
		//alert(value);
		var $cat=jQuery('#finder11 option:selected').val();
		jQuery("#finder33 option").remove();
		jQuery('#finder33').append('<option value="load">Loading .. </option>'); 
		 jQuery.ajax(
		 {	
			url : modelURL,
			type: "GET",
	        data : {id:value,cat:$cat},
 	        success:function(data, textStatus, jqXHR) 
	        {
		 		jQuery("#finder33 option[value='load']").remove();
				//init(formData);		 
				jQuery("#finder33").append(data);
	        }
	    });
		
	}); 
	
	
	jQuery(".amfinder-vertical .dropdown-element #finder33").change(function() {
		
  		//alert( "Handler for .change() called." );
		var value = jQuery(this).val();
		//alert(value);
		var $cat=jQuery('#finder11 option:selected').val();
		var $ser =jQuery('#finder22 option:selected').val();
		jQuery('#loading-image').show();	
		 jQuery.ajax(
		 {	
			url : printerData,
			type: "GET",
	        data : {id:value,cat:$cat,ser:$ser},
 	        success:function(data, textStatus, jqXHR) 
	        {
		 
				 window.location.href = data;
				//jQuery('.selectprinter').remove();	
				//jQuery(".finalProductData").append(data);

	        }
	    });
		
	});  
	
	
	jQuery(".dropdown-serieslist-----").change(function() {
  		//alert( "Handler for .change() called." );
		var ser = jQuery(this).val();
		jQuery('#dropdown-serieslist').val(ser); 
		//alert(value);
		var $cat=jQuery('#seriescategory').val();
		var $ser =jQuery('.dropdown-serieslist option:selected').val();
		jQuery(".dropdown-model-list option").remove();	
		jQuery('.dropdown-model-list').append('<option value="load">Loading .. </option>');
 		jQuery.ajax(
		 {	
			url : modelURL,
			type: "GET",
	        data : {cat:$cat,id:ser},
 	        success:function(data, textStatus, jqXHR) 
	        {
		 
				 //init(formData);		
				jQuery(".dropdown-model-list option[value='load']").remove();
				jQuery(".dropdown-model-list").append(data);

	        }
	    });
		
	});  
	
	
	
	jQuery(".dropdown-model-list").change(function() {
  		//alert( "Handler for .change() called." );
		//var ser = jQuery(this).val();
		//alert(value);
		var $cat=jQuery('#seriescategory').val();
		var $ser =jQuery('.dropdown-serieslist').val();
		var mod = jQuery(this).val();

			
 		jQuery.ajax(
		 {	
			url : printerData,
			type: "GET",
	         //data : {cat:$cat,id:$ser},
			data : {id:mod,cat:$cat,ser:$ser}, 
 	        success:function(data, textStatus, jqXHR) 
	        {
		 
				 //init(formData);		
			//	jQuery(".select_btn").remove();
			//	jQuery(".selectprinter").remove();
			//	jQuery(".finalProductData").append(data);
			 window.location.href = data;

	        }
	    });
		
	});  
	
	
	
	
	 jQuery(".dropdown-element #finder111-----").change(function() {
  		//alert( "Handler for .change() called." );
		var value = jQuery(this).val();
		//alert(value);
		 jQuery("#finder222 option").remove();	
		 jQuery('#finder222').append('<option value="load">Loading .. </option>'); 
		 jQuery.ajax(
		 {	
			url : formURL,
			type: "GET",
	        data : {id:value},
 	        success:function(data, textStatus, jqXHR) 
	        {
		 		jQuery("#finder222 option[value='load']").remove();
				 //init(formData);		
				jQuery("#finder222").append(data);
	        }
	    });
		
	}); 
	
	
	jQuery(".dropdown-element #finder222-----").change(function() {
  		//alert( "Handler for .change() called." );
		var value = jQuery(this).val();
		//alert(value);
		var $cat=jQuery('#finder111 option:selected').val();
		jQuery("#finder333 option").remove();
		jQuery('#finder333').append('<option value="load">Loading .. </option>'); 
		 jQuery.ajax(
		 {	
			url : modelURL,
			type: "GET",
	        data : {id:value,cat:$cat},
 	        success:function(data, textStatus, jqXHR) 
	        {
				jQuery("#finder333 option[value='load']").remove();
				//init(formData);		 
				jQuery("#finder333").append(data);
	        }
	    });
		
	}); 
	
	
	jQuery(".amfinder-vertical .dropdown-element #finder333").change(function() {
  		 
		var value = jQuery(this).val();
		//alert(value);
		var $cat=jQuery('#finder111 option:selected').val();
		var $ser =jQuery('#finder222 option:selected').val();
		jQuery('#loading-image').show();	
		 jQuery.ajax(
		 {	
			url : printerData2,
			type: "GET",
	        data : {id:value,cat:$cat,ser:$ser},
 	        success:function(data, textStatus, jqXHR) 
	        {				
				 //init(formData);		
				jQuery('.selectprinter').remove();	
				jQuery(".finalProductData").append(data);

	        }
	    });
		
	});  
	
	
	
	
	
	
	
	
	
	jQuery(".dropdown-element #finder1111").change(function() {
  		//alert( "Handler for .change() called." );
		var value = jQuery(this).val();
		//alert(value);
		 jQuery("#finder2222 option").remove();	
		 jQuery('#finder2222').append('<option value="load">Loading .. </option>'); 
		 jQuery.ajax(
		 {	
			url : formURL,
			type: "GET",
	        data : {id:value},
 	        success:function(data, textStatus, jqXHR) 
	        {
		 		jQuery("#finder2222 option[value='load']").remove();
				 //init(formData);		
				jQuery("#finder2222").append(data);
	        }
	    });
		
	}); 
	
	
	jQuery(".dropdown-element #finder2222").change(function() {
  		//alert( "Handler for .change() called." );
		var value = jQuery(this).val();
		//alert(value);
		var $cat=jQuery('#finder1111 option:selected').val();
		jQuery("#finder3333 option").remove();
		jQuery('#finder3333').append('<option value="load">Loading .. </option>'); 
		 jQuery.ajax(
		 {	
			url : modelURL,
			type: "GET",
	        data : {id:value,cat:$cat},
 	        success:function(data, textStatus, jqXHR) 
	        {
				jQuery("#finder3333 option[value='load']").remove();
				//init(formData);		 
				jQuery("#finder3333").append(data);
	        }
	    });
		
	});  
	
	
	jQuery(".dropdown-element #finder3333").change(function() {
		
  		//alert( "Handler for .change() called." );
		var value = jQuery(this).val();
		//alert(value);
		var $cat=jQuery('#finder1111 option:selected').val();
		var $ser =jQuery('#finder2222 option:selected').val();
		jQuery('#loading-image').show();	
		 jQuery.ajax(
		 {	
			url : printerData1, 
			type: "GET",
	        data : {id:value,cat:$cat,ser:$ser},
 	        success:function(data, textStatus, jqXHR) 
	        {				
				 //init(formData);		
				jQuery('.selectprinter').remove();	
				jQuery(".finalProductData1").append(data);

	        }
	    });
		
	});  
	
	
	
	
	 
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}); 



/* brand page */

