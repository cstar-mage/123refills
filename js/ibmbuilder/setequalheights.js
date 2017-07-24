/**
 * SetEqualHeights

 */
var SetEqualHeights = function(options){this.init(options);};

SetEqualHeights.prototype =
{
	/**
	 * Constructor
	 * @return void
	 */
	init: function( options )
	{
		var defaults = 
		{
			root_selector		: '',			// set container selector like .product_list
			column_selector		: '.col',		// set column selector like .col
			height_nodes		: [],			// set elements which are in the column_selector that must get an equal height
			debug				: false,
		}

		this.window		= jQuery(window);
		this.body		= jQuery('body');

		this.options	= jQuery.extend( {}, defaults, options );
		this.size		= '';

		this.debug		= this.options.debug;

		this.start();
	},

	start: function()
	{
		var _this			= this;
		var container_nodes	= jQuery(this.options.root_selector);

		container_nodes.each(function(index)
		{
			if (index)
			{
				var options = jQuery.extend({}, _this.options);

				options.selector	+= ':eq(' + index + ')';
			}
			else 
			{
				_this.container_node = jQuery(this);

				if (_this.options.height_nodes.length)
				{
					_this.setSize();
					_this.setEvents();
				}
			}
		});
	},

	setEvents: function()
	{
		var _this	= this;

		this.window.resize(function()
		{
			_this.setSize();
		});
	},

	setSize: function()
	{
		if (this.debug) console.log('-- setSize --');

		this.body.css('overflow', 'hidden');
		var window_width = this.window.width();
		this.body.css('overflow', '');

		switch (true)
		{
			case (window_width < 480) :
				var new_size = 'xs';
			break;

			case (window_width < 768) :
				var new_size = 'sm';
			break;

			case (window_width < 1024) :
				var new_size = 'md';
			break;

			case (window_width < 1280) :
				var new_size = 'lg';
			break;

			default :
				var new_size = 'xl';
			break;
		}

		if (this.size != new_size || new_size == 'xs')
		{
			if (this.debug) console.log('new size: ' + new_size);

			this.size = new_size;
			this.setHeight();
		}
	},

	setHeight: function()
	{
		if (this.debug) console.log('-- setHeight --');

		var _this			= this;
		var prev_col_nodes	= jQuery();
		var container_width	= this.container_node.width() +1;
		var items_in_row	= 0;
		var row_size		= 0;
		var node_heights	= [];

		if (this.debug) console.log('container_width: ' + container_width);

		for (i=0; i < this.options.height_nodes.length; i++)
		{
			node_heights[i] = 0;
		}

		this.container_node.find(this.options.column_selector).each(function(index)
		{
			var column_node 	= jQuery(this);
			var column_width	= column_node.outerWidth(true);

			row_size += column_width;

			if (_this.debug) console.log('column_width: ' + column_width);
			if (_this.debug) console.log('row_size: ' + row_size);

			if (row_size > container_width)
			{
				row_size		= column_width;
				prev_col_nodes	= jQuery();
				items_in_row	= 0;

				for (i=0; i < _this.options.height_nodes.length; i++)
				{
					node_heights[i] = 0;
				}
			}

			prev_col_nodes = prev_col_nodes.add(column_node);
			items_in_row++;
			
			if (_this.debug) console.log('items_in_row: ' + items_in_row);

			// loop through elements
			for (i=0; i < _this.options.height_nodes.length; i++)
			{
				var element			= column_node.find(_this.options.height_nodes[i]);

				// reset height
				element.css('height','');
				
				if (container_width != column_width)
				{
					var element_height	= element.height();

					if (_this.debug) console.log('element_height: ' + element_height);
					if (_this.debug) console.log('element_max_height: ' + node_heights[i]);
	
					if (element_height <= node_heights[i])
					{
						element.height(node_heights[i]);
					}
					else if (element_height > node_heights[i])
					{
						node_heights[i] = element_height;
						prev_col_nodes.find(_this.options.height_nodes[i]).height(node_heights[i]);
					}
				}
			}
		});
	}
}