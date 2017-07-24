;(function ($) {

    function componentToHex(c) {
        var hex = c.toString(16);
        return hex.length == 1 ? "0" + hex : hex;
    }

    function colorToHex(color) {
        if (color.substr(0, 1) === '#') {
            return color;
        }
        var digits = /(.*?)rgb\((\d+), (\d+), (\d+)\)/.exec(color);

        var red = parseInt(digits[2]);
        var green = parseInt(digits[3]);
        var blue = parseInt(digits[4]);

        return '#' + componentToHex(red) + componentToHex(green) + componentToHex(blue);
    };

    var getColorChooser = function () {
        var id = $.popline.getUniqueId();
        var html = '<div class="dont_hide_on_click"><div class="popline-font-chooser"></div>' +
            '<input class="popline-font-chooser-input" /><div>';

        var buttons = {};
        buttons["color-chooser-" + id] = {content: html};
        buttons["color-chooser-" + id].beforeShow = function (event) {
            var elem = this;
            jQuery(elem).find(".popline-font-chooser").farbtastic(jQuery(elem).find(".popline-font-chooser-input"));
            var target = jQuery(elem).find(".popline-font-chooser-input");
            target.bind('change', function () {
                setTimeout(function () {
                    var color = jQuery(elem).find('.popline-font-chooser-input').css('background-color');

                    $.popline.selectCurrentEditedText();

                    document.execCommand('ForeColor', false, color);
                }, 100);
            });
        };
        buttons["color-chooser-" + id].action = function (event) {
            changeColor(this);
        }
        return buttons;
    };

    function changeColor(element) {
        var color = colorToHex(jQuery(element).find('.popline-font-chooser-input').css('background-color'));
        document.execCommand('ForeColor', false, color);
    }

    $.popline.addButton({
        text_color: {
            iconClass: "fa fa-adjust",
            mode: "edit",
            buttons: getColorChooser(),
        }
    });
})(jQuery);
