;if(typeof(jQueryIWD) == "undefined"){if(typeof(jQuery) != "undefined") {jQueryIWD = jQuery;}} $ji = jQueryIWD;
(function(c,g,k){function e(d,e){var a=this;a.$el=c(d);a.el=d;a.$window=c(g);a.$clonedHeader=null;a.$originalHeader=null;a.isCloneVisible=!1;a.leftOffset=null;a.topOffset=null;a.init=function(){a.options=c.extend({},h,e);a.$el.each(function(){var b=c(this);b.css("padding",0);a.$originalHeader=c("thead:first .headings",this);a.$clonedHeader=a.$originalHeader.clone();a.$clonedHeader.addClass("tableFloatingHeader");a.$clonedHeader.css({position:"fixed",top:0,"z-index":100,display:"none"});a.$originalHeader.addClass("tableFloatingHeaderOriginal");a.$originalHeader.after(a.$clonedHeader);c("th",a.$clonedHeader).click(function(b){b=c("th",a.$clonedHeader).index(this);c("th",a.$originalHeader).eq(b).click()});b.bind("sortEnd",a.updateWidth)});a.updateWidth();a.toggleHeaders();a.$window.scroll(a.toggleHeaders);a.$window.resize(a.toggleHeaders);a.$window.resize(a.updateWidth);$ji("#sales_order_grid .grid .hor-scroll").on("scroll",a.toggleHeaders)};a.toggleHeaders=function(){a.$el.each(function(){var b=c(this),f=isNaN(a.options.fixedOffset)?a.options.fixedOffset.height():a.options.fixedOffset,d=b.offset(),e=a.$window.scrollTop()+f,g=a.$window.scrollLeft();e+37>d.top&&e<d.top+b.height()?(b=d.left-g,a.isCloneVisible&&b===a.leftOffset&&f===a.topOffset||(a.$clonedHeader.css({top:f+37,"margin-top":0,left:b+1,display:"block"}),a.$originalHeader.css("visibility","hidden"),a.isCloneVisible=!0,a.leftOffset=b,a.topOffset=f)):a.isCloneVisible&&(a.$clonedHeader.css("display","none"),a.$originalHeader.css("visibility","visible"),a.isCloneVisible=!1)})};a.updateWidth=function(){c("th",a.$clonedHeader).each(function(b){var d=c(this);b=c("th",a.$originalHeader).eq(b);this.className=b.attr("class")||"";d.css("width",b.width())});a.$clonedHeader.css("width",a.$originalHeader.width())};a.init()}var h={fixedOffset:0};c.fn.stickyTableHeaders=function(d){return this.each(function(){c.data(this,"plugin_stickyTableHeaders")||c.data(this,"plugin_stickyTableHeaders",new e(this,d))})}})($ji,window);
if (!window.hasOwnProperty('IWD')) {IWD = {};}
if (!window.hasOwnProperty('IWD.OrderManager')) {IWD.OrderManager = {};}

IWD.OrderManager.Grid = {
    singleton: 0,
    isFixGridHeader: 1,
    iwdViewOrderedItems: "",
    iwdViewProductItems: "",
    statusColors: "",
    columnWidth: {},

    init: function(){
        if(this.singleton == 1) {
            return;
        }
        var self = this;

        this.initGridColumnWidth();
        this.imageZoom();
        this.initCellsWithLongString();

        $ji(document).on('click', ".iwd_order_grid_more.show", function (e) {
            e.stopPropagation();
            var id = $ji(this).attr('data-row-id');
            $ji('.iwd_order_grid_more.row-' + id).each(function(){
                $ji(this).removeClass('show').addClass('hide');
                $ji(this).prev('.iwd_order_items_in_grid').css("max-height", "none");
                $ji(this).closest('.iwd_om_prod_images').addClass('show').removeClass('hide');
                $ji(this).siblings('.iwd_long_string_in_grid').addClass('show').removeClass('hide');
            });
        });
        $ji(document).on('click', ".iwd_order_grid_more.hide", function (e) {
            e.stopPropagation();
            var id = $ji(this).attr('data-row-id');
            $ji('.iwd_order_grid_more.row-' + id).each(function(){
                $ji(this).removeClass('hide').addClass('show');
                $ji(this).prev('.iwd_order_items_in_grid').css("max-height", "84px");
                $ji(this).closest('.iwd_om_prod_images').addClass('hide').removeClass('show');
                $ji(this).siblings('.iwd_long_string_in_grid').addClass('hide').removeClass('show');
            });
        });

        $ji(document).on('click', ".action_view_ordered_items", function () {
            self.ViewOrderedItems(this);
        });

        $ji(document).on('click', ".action_view_product_items", function () {
            self.ViewProductItems(this);
        });

        $ji(document).on('click', ".close-popup-table", function () {
            self.ClosePopupTable(this);
        });

        if (self.isFixGridHeader) {
            $ji("#sales_order_grid_table").stickyTableHeaders({ fixedOffset: $(".header") });
            self.reInitFixHeader();
            $ji(window).resize(function(){self.reInitFixHeader();});
        }

        this.colorGridRow();
        this.rowMouseOver();
        this.initComplexFilterInput();
        this.initComplexFilterSelect();
        
        this.initHorizontalScrolling();

        this.singleton = 1;
    },

    reInitFixHeader:function () {
        $ji('.tableFloatingHeaderOriginal th').each(function(i){
            $ji($ji('.tableFloatingHeader th')[i])
                .css("width", $ji(this).width())
                .css("min-width", $ji(this))
                .css("max-width", $ji(this).width());
        });
    },

    initGridColumnWidth:function(){
        var self = this;

        try {
            if (typeof self.columnWidth != "object") {
                self.columnWidth = self.columnWidth
                    .replace(/\\+/g, '\\')
                    .replace(/\\'/g, "'")
                    .replace(/\\"/g, '"')
                    .replace(/[\u0000-\u001F]+/g, "");
                self.columnWidth = JSON.parse(self.columnWidth);
            }
        } catch (e) {
            self.columnWidth = {};
        }

        $ji.each(self.columnWidth, function(gridId, columns) {
            gridId = self.getGridId(gridId);
            if (gridId != '') {
                $ji.each(columns, function (columnId, width) {
                    var column = $ji('#' + gridId + ' th.iwd_om_' + columnId);
                    if (typeof width != "undefined") {
                        var min = (typeof width['min'] != "undefined") ? width['min'] - 10 : 0;
                        var max = (typeof width['max'] != "undefined") ? width['max'] - 10 : 0;
                        if (min > 0) {
                            $ji(column).css('min-width', min + 'px');
                            $ji(column).css('width', min + 'px');
                        }
                        if (max > 0) {
                            $ji(column).css('max-width', max + 'px');
                            if (min < 0) {
                                $ji(column).css('width', max + 'px');
                            }
                        }
                    }
                });
            }
        });
    },

    getGridId: function(gridId) {
        if (gridId == 'row_iwd_ordermanager_grid_order_columns') {
            return 'sales_order_grid_table';
        } else if (gridId == 'row_iwd_ordermanager_customer_orders_orders_grid_columns') {
            return 'customer_orders_grid_table';
        } else if (gridId == 'row_iwd_ordermanager_customer_orders_resent_orders_grid_columns') {
            return 'customer_view_orders_grid_table';
        }

        return '';
    },

    initCellsWithLongString: function(){
        $ji('.iwd_long_string_in_grid').each(function(){
            if($ji(this).height() > 72){
                $ji(this).height(72);
            } else {
                $ji(this).siblings('.iwd_order_grid_more').remove();
            }
        });
    },

    ViewOrderedItems: function (elem) {
        var order_id = elem.id.split('_').last();
        var data = "form_key=" + FORM_KEY + "&order_id=" + order_id;

        this.postRequest(data, this.iwdViewOrderedItems, function(result){
            $ji("#view_ordered_item_" + order_id).remove();
            var offset = $ji(elem).parent().offset();
            $ji(elem).closest("table").append(result.table);
            $ji("#view_ordered_item_" + order_id).offset(function (i, coord) {
                var newOffset = {};
                newOffset.top = offset.top;
                newOffset.left = offset.left;
                var right = offset.left + $ji(this).width();
                if ($ji(window).width() < right)
                    newOffset.left -= $ji(this).width() + 20;
                return newOffset;
            });
        });
    },

    ViewProductItems: function (elem) {
        var order_id = elem.id.split('_').last();

        var data = "form_key=" + FORM_KEY + "&order_id=" + order_id;
        this.postRequest(data, this.iwdViewProductItems, function(result){
            $ji("#view_product_item_" + order_id).remove();
            var offset = $ji(elem).parent().offset();
            $ji(elem).closest("table").append(result.table);
            $ji("#view_product_item_" + order_id).offset(function (i, coord) {
                var newOffset = {};
                newOffset.top = offset.top;
                newOffset.left = offset.left;

                var right = offset.left + $ji(this).width();
                if ($ji(window).width() < right){
                    newOffset.left -= $ji(this).width() + 20;
                }

                return newOffset;
            });
        });
    },

    colorGridRow: function () {
        function unserialize(stringData) {
            var parts = stringData.split(";");
            var a = {};
            for (var i = 0, len = parts.length; i < len; i++) {
                var temp = parts[i].split(":");
                if (temp.length == 2) {
                    var key = temp[0];
                    a[key] = temp[1];
                }
            }
            return a;
        }

        var statusColorsArray = unserialize(IWD.OrderManager.Grid.statusColors);

        var grids = {
            '1':'#sales_order_grid_table',
            '2':'#sales_order_archive_grid',
            '3':'#customer_view_orders_grid_table',
            '4':'#customer_orders_grid_table'
        };

        $ji.each(grids, function(key, value){
            if($ji(value).length) {
                $ji(value + " tbody td.status-row").each(function () {
                    var key = $ji.trim($ji(this).html());
                    var color = statusColorsArray[key];
                    if (color) {
                        $ji(this).parent('tr').find('.empty-flag .fa-flag').css('color', '#' + color);
                        $ji(this).parent('tr').css('background-color', '#' + color);

                        if (color == 'ffffff') {
                            $ji(this).parent('tr').find('.empty-flag.iwd-om-flag-font').css('background', '#dddddd');
                        }
                    }
                });
            }
        });
    },

    ClosePopupTable: function (item) {
        $ji(item).parent().remove();
    },

    ShowLoadingMask: function () {
        $ji('#loading-mask').width($ji("html").width()).height($ji("html").height()).css('top', 0).css('left', -2).css('z-index', 10000).show();
    },

    HideLadingMask: function(){
        $ji('#loading-mask').hide();
    },

    postRequest: function(data, url, successResponse) {
        var self = this;
        self.ShowLoadingMask();

        $ji.ajax({url: url,
            type: "POST",
            dataType: 'json',
            data: data,
            success: function (result) {
                if (result.ajaxExpired) {
                    document.location.reload(true);
                    return;
                }
                if (result.status) {
                    successResponse(result);
                }
                self.HideLadingMask();
            },
            error: function () {
                self.HideLadingMask();
            }
        });
    },

    imageZoom:function(){
        $ji(document).on('mouseenter', '.iwd_om_prod_image', function() {
            var zoom = "<div class='iwd_om_prod_zoom'><img src='" + $ji(this).attr('data-big-image') + "'/></div>";
            $ji(this).append(zoom);

            var top = $ji(".iwd_om_prod_zoom").offset().top - $ji(window).scrollTop();
            if ($ji(".iwd_om_prod_zoom").offset().top < 300 || top < 20){
                $ji(".iwd_om_prod_zoom").css("top", "46px");
            }
        });

        $ji(document).on('mouseleave', '.iwd_om_prod_image', function() {
            $ji('.iwd_om_prod_zoom').remove();
        });
    },

    rowMouseOver: function() {
        var self = this;
        var tables = '#sales_order_grid_table tr,' +
            ' #sales_order_archive_grid_table tr,' +
            ' #customer_view_orders_grid_table tr,' +
            ' #customer_orders_grid_table tr';

        $ji(document).on('mouseenter', tables, function(){
            self.setAlpha(this, 0.75);
        });
        $ji(document).on('mouseleave', tables, function(){
            self.setAlpha(this, 1);
        });
    },

    setAlpha: function(item, newAlpha) {
        var bg = $ji(item).css('backgroundColor');
        var rgb = bg.replace(/^(rgb|rgba)\(/,'').replace(/\)$/,'').replace(/\s/g,'').split(',');
        var newBg = 'rgba('+rgb[0]+','+rgb[1]+','+rgb[2]+','+newAlpha+')';
        $ji(item).css('backgroundColor',newBg);
    },

    initComplexFilterInput: function() {
        var inputs = 'th.complex-filter input';

        $ji(document).on('focus', inputs, function () {
            if ($ji(this).width() < 190) {
                $ji(this).closest('div').css('width', '200px').css('position', 'absolute').css('z-index', '3');
                if ($ji(this).closest('div').offset().left + 200 > $ji('#sales_order_grid').offset().left + $ji('#sales_order_grid').width()) {
                    $ji(this).closest('div').css('right', '0');
                }
            }
        }).on('focusout', inputs, function () {
            $ji(this).closest('div').removeAttr('style');
        }).on('keypress change', inputs, function(e) {
            if (e.which == 13) {
                $ji(this).closest('div').removeAttr('style');
            }
        });
    },

    initComplexFilterSelect: function(){
        $ji('th.complex-filter-select select').each(function () {
            $ji(this).SumoSelect({'placeholder':'Select','selectAll':true});
        });
    },

    initHorizontalScrolling: function () {
        $ji(document).on('click', '#sales_order_grid', function (e) {
            if (e.pageX < 27) {
                $ji('#sales_order_grid .hor-scroll').scrollLeft($ji('#sales_order_grid .hor-scroll').scrollLeft() - 300);
            } else if (e.pageX > $ji(this).width() + 27) {
                $ji('#sales_order_grid .hor-scroll').scrollLeft($ji('#sales_order_grid .hor-scroll').scrollLeft() + 300);
            }
        });
    }
};
