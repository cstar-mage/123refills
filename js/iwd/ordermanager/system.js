;if(typeof(jQueryIWD) == "undefined"){if(typeof(jQuery) != "undefined"){jQueryIWD = jQuery;}} $ji = jQueryIWD;
if (!window.hasOwnProperty('IWD')) {IWD = {};}
if (!window.hasOwnProperty('IWD.OrderManager')) {IWD.OrderManager = {};}

IWD.OrderManager.Settings = {
    init: function() {
        this.initMultiselect();
        this.initColumnsWidth();
        this.initStatusColor();
    },

    initMultiselect: function() {
        $ji("#iwd_ordermanager_grid_order_columns").multiselect();
        $ji("#iwd_ordermanager_customer_orders_orders_grid_columns").multiselect();
        $ji("#iwd_ordermanager_customer_orders_resent_orders_grid_columns").multiselect();
    },

    initColumnsWidth: function() {
        $ji('<input type="text" class="col-width min" placeholder="min"/>-<input type="text" class="col-width max" placeholder="max"/>')
            .insertAfter(".ui-state-default.ui-element > span");

        var columnsWidth = this.readColumnsWidth();
        this.initColumnsWidthData(columnsWidth);

        $ji(document).on('change', '.ui-multiselect .col-width', function() {
            var title = $ji(this).closest('li').attr('title');
            var column = $ji(this).closest('td').find('select.multiselect option').filter(function(){
                return $ji(this).html() == title;
            }).val();
            var group = $ji(this).closest('tr').attr('id');
            columnsWidth[group] = (typeof columnsWidth[group] == "undefined") ? columnsWidth[group] = {} : columnsWidth[group];
            columnsWidth[group][column] = (typeof columnsWidth[group][column] == "undefined") ? columnsWidth[group][column] = {} : columnsWidth[group][column];

            if ($ji(this).hasClass('min')) {
                columnsWidth[group][column]['min'] = $ji(this).val();
            } else if ($ji(this).hasClass('max')) {
                columnsWidth[group][column]['max'] = $ji(this).val();
            }

            $ji('#iwd_ordermanager_grid_order_columns_width').val(JSON.stringify(columnsWidth));
        });

        $ji(document).on('focus', '.ui-multiselect .col-width', function(){$ji(this).select()});
    },

    readColumnsWidth: function () {
        var columnsWidth = $ji('#iwd_ordermanager_grid_order_columns_width').val();
        try {
            columnsWidth = columnsWidth
                .replace(/\\+/g, '\\')
                .replace(/\\'/g, "'")
                .replace(/\\"/g, '"')
                .replace(/[\u0000-\u001F]+/g, "");
            columnsWidth = JSON.parse(columnsWidth);
        } catch (e) {
            columnsWidth = {};
        }
        return columnsWidth;
    },

    initColumnsWidthData: function(columnsWidth) {
        $ji.each(columnsWidth, function (group, columns) {
            $ji.each(columns, function (column, width) {
                column = $ji('#' + group + ' select option[value="' + column + '"]').html();
                if (typeof width['min'] != 'undefined') {
                    $ji('#' + group + ' .ui-multiselect li[title="' + column + '"] input.col-width.min').val(width['min']);
                }
                if (typeof width['max'] != 'undefined') {
                    $ji('#' + group + ' .ui-multiselect li[title="' + column + '"] input.col-width.max').val(width['max']);
                }
            });
        });
    },

    initStatusColor: function() {
        var self = this;

        if ($ji("#iwd_ordermanager_grid_order_status_color").length > 0) {
            var colorsArray = self.initColorsArray();
            var currentColor = "ffffff";
            $ji('.color-box').on('click',function () {
                currentColor = $ji(this).closest('li').css('background-color');
                currentColor = self.rgb2hex(currentColor);
            }).colpick({
                onBeforeShow: function () {
                    $ji(this).colpickSetColor(currentColor);
                },
                colorScheme: 'light',
                layout: 'rgbhex',
                onSubmit: function (hsb, hex, rgb, el) {
                    $ji(el).colpickHide();
                    $ji(el).closest('li').css('background-color', '#' + hex);
                    var id = $ji(el).closest('li')[0].id;
                    colorsArray[id] = hex;
                    var colorsString = self.serialize(colorsArray);
                    $ji("#iwd_ordermanager_grid_order_status_color").val(colorsString);
                }
            });

            $ji('.clear-color').on('click', function (e) {
                var li = $ji(this).closest('li')[0];
                if (delete(colorsArray[li.id])) {
                    $ji(li).css('background-color', '');
                    var colorsString = self.serialize(colorsArray);
                    $ji("#iwd_ordermanager_grid_order_status_color").val(colorsString);
                }
            });
        }
    },

    initColorsArray: function() {
        var self = this;
        var colorsString = $ji("#iwd_ordermanager_grid_order_status_color").val();
        var colorsArray = self.unserialize(colorsString);

        $ji('#order_status_color li').each(function () {
            var color = colorsArray[this.id];
            if (color){
                $ji(this).css('background-color', '#' + color);
            }
        });

        return colorsArray;
    },

    serialize: function(arrayData) {
        var a = [];
        for (key in arrayData) {
            a.push(key + ":" + arrayData[key]);
        }
        return a.join(";");
    },

    unserialize: function(stringData) {
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
    },

    rgb2hex: function(rgb) {
        rgb = rgb.match(/^rgb\w*\((\d+),\s*(\d+),\s*(\d+)/);
        if(rgb == null){
            return "#FFFFFF";
        }
        return "#" +
            ("0" + parseInt(rgb[1], 10).toString(16)).slice(-2) +
            ("0" + parseInt(rgb[2], 10).toString(16)).slice(-2) +
            ("0" + parseInt(rgb[3], 10).toString(16)).slice(-2);
    }
};

$ji(document).ready(function () {
    IWD.OrderManager.Settings.init();
});