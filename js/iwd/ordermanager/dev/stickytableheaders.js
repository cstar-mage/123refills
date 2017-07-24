/*! Copyright (c) 2011 by Jonas Mosbech - https://github.com/jmosbech/StickyTableHeaders MIT license info: https://github.com/jmosbech/StickyTableHeaders/blob/master/license.txt */
;(function ($, window, undefined) {
	'use strict';
	var pluginName='stickyTableHeaders';
	var defaults={fixedOffset: 0};
	function Plugin(el, options){
		var base=this;
		base.$el=$(el);
		base.el = el;
		base.$window = $(window);
		base.$clonedHeader = null;
		base.$originalHeader = null;
		base.isCloneVisible = false;
		base.leftOffset = null;
		base.topOffset = null;
		base.init = function () {
			base.options = $.extend({}, defaults, options);

			base.$el.each(function () {
				var $this = $(this);
				$this.css('padding', 0);
				base.$originalHeader = $('thead:first .headings', this);
				base.$clonedHeader = base.$originalHeader.clone();
				base.$clonedHeader.addClass('tableFloatingHeader');
				base.$clonedHeader.css({
					'position': 'fixed',
					'top': 0,
					'z-index': 100, // #18: opacity bug
					'display': 'none'
				});
				base.$originalHeader.addClass('tableFloatingHeaderOriginal');
				base.$originalHeader.after(base.$clonedHeader);
				$('th', base.$clonedHeader).click(function (e) {
					var index = $('th', base.$clonedHeader).index(this);
					$('th', base.$originalHeader).eq(index).click();
				});
				$this.bind('sortEnd', base.updateWidth);
			});
			base.updateWidth();
			base.toggleHeaders();
			base.$window.scroll(base.toggleHeaders);
			base.$window.resize(base.toggleHeaders);
			base.$window.resize(base.updateWidth);

            //IWD Order Manager
            jQuery("#sales_order_grid .grid .hor-scroll").on("scroll", base.toggleHeaders);
		};

		base.toggleHeaders = function () {
			base.$el.each(function () {
				var $this = $(this);
				var newTopOffset = isNaN(base.options.fixedOffset) ? base.options.fixedOffset.height() : base.options.fixedOffset;
				var offset = $this.offset();
				var scrollTop = base.$window.scrollTop() + newTopOffset;
				var scrollLeft = base.$window.scrollLeft();

                //IWD Order Manager
                var h = 37;

				if ((scrollTop + h > offset.top) && (scrollTop < offset.top + $this.height())) {
					var newLeft = offset.left - scrollLeft;
					if (base.isCloneVisible && (newLeft === base.leftOffset) && (newTopOffset === base.topOffset)) {
						return;
					}

					base.$clonedHeader.css({
						'top': newTopOffset + h,
						'margin-top': 0,
						'left': newLeft + 1,
						'display': 'block'
					});
					base.$originalHeader.css('visibility', 'hidden');
					base.isCloneVisible = true;
					base.leftOffset = newLeft;
					base.topOffset = newTopOffset;
				}
				else if (base.isCloneVisible) {
					base.$clonedHeader.css('display', 'none');
					base.$originalHeader.css('visibility', 'visible');
					base.isCloneVisible = false;
				}

			});
		};
		base.updateWidth = function () {
			$('th', base.$clonedHeader).each(function (index) {
				var $this = $(this);
				var $origCell = $('th', base.$originalHeader).eq(index);
				this.className = $origCell.attr('class') || '';
				$this.css('width', $origCell.width());
			});
			base.$clonedHeader.css('width', base.$originalHeader.width());
		};
		base.init();
	}
	$.fn[pluginName] = function ( options ) {
		return this.each(function () {
			if (!$.data(this, 'plugin_' + pluginName)) {
				$.data(this, 'plugin_' + pluginName, new Plugin( this, options ));
			}
		});
	};
})(jQuery, window);