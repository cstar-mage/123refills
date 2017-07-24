jQuery( document ).ajaxStop(function() {
  				alert("test");
				jQuery(document).ready(function(){
			    jQuery('#in_dataspin_products').val(''); 
			    jQuery('.checkbox').change(function() {
					if(jQuery(this).is(':checked')){
					    var currentId =  jQuery(this).val();
						var includedVal = jQuery('#in_dataspin_products').val();
						if(includedVal !== '')
						{
							jQuery('#in_dataspin_products').val(includedVal + ',' + currentId);
						}else{
							jQuery('#in_dataspin_products').val(currentId);
						}
					}else{
						var exid = jQuery('#in_dataspin_products').val();
						var currentId =  jQuery(this).val();
						if(exid !== '')
						{
							var new_val = removeValue(exid,currentId);
							jQuery('#in_dataspin_products').val(new_val);
						}else{
							jQuery('#in_dataspin_products').val(currentId);
						}
					}
				});
				
				function removeValue(list, value) {
					return list.replace(new RegExp(',?' + value + ',?'), function(match) {
						var first_comma = match.charAt(0) === ',',
							second_comma;				
						if (first_comma &&
							(second_comma = match.charAt(match.length - 1) === ',')) {
						  return ',';
						}
						return '';
					});
				};
				
			});   
				
				
				
			});
			