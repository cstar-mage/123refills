DLSU = Class.create();
DLSU.prototype = {
	initialize: function(id,config){
		mergeoptions = new Object(this.defaults.merge(config));
		this.config = mergeoptions.toObject();
		if (document.addEventListener){
		  document.addEventListener('scroll', this.start.bind(this));
		  window.addEventListener('resize', this.start.bind(this));
		  window.addEventListener('load', this.start.bind(this));
		} else if (document.attachEvent){
		  document.attachEvent('onclick', this.start.bind(this));
		  window.attachEvent('onresize', this.start.bind(this));
		  window.attachEvent('onload', this.start.bind(this));
		}
		this.config.anchorElem = $(id);
	},
	defaults: $H({
		duration: 0.5,
		offset: 0,
		activeOverlay: 75
	}),
	start: function(){
		scrollOffsets = document.viewport.getScrollOffsets();
    	scrollTop = scrollOffsets.top;
	    if(scrollTop >= this.config.activeOverlay){
	    	this.toggleAnchor(true,this.config.anchorElem);
	        this.config.anchorElem.down("a").observe('click', function(ce){
	            Event.stop(ce);
	        	Effect.ScrollTo($$('html body')[0],{duration:this.config.duration,offset:this.config.offset,transition: Effect.Transitions.linear});
	        }.bind(this));
	    }
	    else{
	    	this.toggleAnchor(false,this.config.anchorElem);
	    }
	},
	toggleAnchor: function(action,elem){
		if(action){
			elem.show();
		}
		else{
			elem.hide();
		}
	}
}