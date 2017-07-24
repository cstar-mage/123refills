/*
 * Copyright (c) 2006 Jonathan Weiss <jw@innerewut.de>
 *
 * Permission to use, copy, modify, and distribute this software for any
 * purpose with or without fee is hereby granted, provided that the above
 * copyright notice and this permission notice appear in all copies.
 *
 * THE SOFTWARE IS PROVIDED "AS IS" AND THE AUTHOR DISCLAIMS ALL WARRANTIES
 * WITH REGARD TO THIS SOFTWARE INCLUDING ALL IMPLIED WARRANTIES OF
 * MERCHANTABILITY AND FITNESS. IN NO EVENT SHALL THE AUTHOR BE LIABLE FOR
 * ANY SPECIAL, DIRECT, INDIRECT, OR CONSEQUENTIAL DAMAGES OR ANY DAMAGES
 * WHATSOEVER RESULTING FROM LOSS OF USE, DATA OR PROFITS, WHETHER IN AN
 * ACTION OF CONTRACT, NEGLIGENCE OR OTHER TORTIOUS ACTION, ARISING OUT OF
 * OR IN CONNECTION WITH THE USE OR PERFORMANCE OF THIS SOFTWARE.
 */

var Tooltip = Class.create();
Tooltip.prototype = {
  initialize: function(element, tool_tip) {
    var options = Object.extend({
      default_css: false,
      margin: "0px",
	    padding: "5px",
	    backgroundColor: "#d6d6fc",
	    min_distance_x: 5,
      min_distance_y: 5,
      delta_x: 0,
      delta_y: 0,
      zindex: 1000
    }, arguments[2] || {});

    this.element      = $(element);

    this.options      = options;
    
    // use the supplied tooltip element or create our own div
    if($(tool_tip)) {
      this.tool_tip = $(tool_tip);
    } else {
      this.tool_tip = $(document.createElement("div")); 
      document.body.appendChild(this.tool_tip);
      this.tool_tip.addClassName("tooltip");
      this.tool_tip.appendChild(document.createTextNode(tool_tip));
    }

    // hide the tool-tip by default
    this.tool_tip.hide();
    //this.eventMouseOver = this.showTooltip.bindAsEventListener(this);
    this.eventMouseOut   = this.hideTooltip.bindAsEventListener(this);
    this.registerEvents();
  },

  destroy: function() {
    //Event.stopObserving(this.element, "mouseover", this.eventMouseOver);
    Event.stopObserving(this.element, "click", this.eventMouseOut);

  },

  registerEvents: function() {
    //Event.observe(this.element, "mouseover", this.eventMouseOver);
    Event.observe(this.element, "click", this.eventMouseOut);

  },

  moveTooltip: function(event){
	  Event.stop(event);
	  // get Mouse position
    var mouse_x = Event.pointerX(event);
	  var mouse_y = Event.pointerY(event);

	  // decide if wee need to switch sides for the tooltip
	  var dimensions = Element.getDimensions( this.tool_tip );
	  var element_width = dimensions.width;
	  var element_height = dimensions.height;

	  if ( (element_width + mouse_x) >= ( this.getWindowWidth() - this.options.min_distance_x) ){ // too big for X
		  mouse_x = mouse_x - element_width;
		  // apply min_distance to make sure that the mouse is not on the tool-tip
		  mouse_x = mouse_x - this.options.min_distance_x;
	  } else {
		  mouse_x = mouse_x + this.options.min_distance_x;
	  }

	  if ( (element_height + mouse_y) >= ( this.getWindowHeight() - this.options.min_distance_y) ){ // too big for Y
		  mouse_y = mouse_y - element_height;
	    // apply min_distance to make sure that the mouse is not on the tool-tip
		  mouse_y = mouse_y - this.options.min_distance_y;
	  } else {
		  mouse_y = mouse_y + this.options.min_distance_y;
	  }

	  // now set the right styles
	  this.setStyles(mouse_x, mouse_y);
  },


  showTooltip: function(event) {
    Event.stop(event);
    if(!Element.visible(this.tool_tip)) {
      this.moveTooltip(event);
      new Element.show(this.tool_tip);
    }
  },
  
  setStyles: function(x, y){
    // set the right styles to position the tool tip
	  Element.setStyle(this.tool_tip, { position:'absolute',
	 								    top:y + this.options.delta_y - 55 + "px",
	 								    left:x + this.options.delta_x + 20 + "px",
									    zindex:this.options.zindex
	 								  });
	
	  // apply default theme if wanted
	  if (this.options.default_css){
	  	  Element.setStyle(this.tool_tip, { margin:this.options.margin,
		 		  						                    padding:this.options.padding,
		                                      backgroundColor:this.options.backgroundColor,
										                      zindex:this.options.zindex
		 								    });	
	  }	
  },

  hideTooltip: function(event){
    if(!Element.visible(this.tool_tip)) {
      this.showTooltip(event);
    } else {
      new Element.hide(this.tool_tip);
    }
  },

  getWindowHeight: function(){
    var innerHeight;
	  if (navigator.appVersion.indexOf('MSIE')>0) {
		  innerHeight = document.body.clientHeight;
    } else {
		  innerHeight = window.innerHeight;
    }
    return innerHeight;	
  },
 
  getWindowWidth: function(){
    var innerWidth;
	  if (navigator.appVersion.indexOf('MSIE')>0) {
		  innerWidth = document.body.clientWidth;
    } else {
		  innerWidth = window.innerWidth;
    }
    return innerWidth;	
  }

}