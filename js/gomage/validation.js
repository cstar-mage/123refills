Validation.add('gomage-validate-number',
				'Please use only numbers (0-9) in this field.', function(v) {
					return Validation.get('IsEmpty').test(v)
							|| (!isNaN(parseNumber(v)) && !/^\s+$/
									.test(parseNumber(v)));
				});

function Gomage_Navigation_fireEvent(element,event){
    if (document.createEventObject){
	    // dispatch for IE
	    var evt = document.createEventObject();
	    return element.fireEvent('on'+event,evt);
    }
    else{
	    // dispatch for firefox + others
	    var evt = document.createEvent("HTMLEvents");
	    evt.initEvent(event, true, true ); // event type,bubbling,cancelable
	    return !element.dispatchEvent(evt);
    }
}