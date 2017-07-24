;(function ($) {

    var fontSizes = [8, 9, 10, 11, 12, 14, 18, 24, 30, 36, 48, 60, 72, 96];

    var getFontSizeChooser = function () {

        var id = $.popline.getUniqueId();

        var html = '<input type="text" name="product" class="popline_font_size_input" list="popline_font_size_datalist_' + id + '" style="width: 40px;" /><datalist id="popline_font_size_datalist_' + id + '">';
        $.each(fontSizes, function (index, elem) {
            html += '<option value="' + elem + '">' + elem + '</option>';
        });
        html += '</datalist>';

        var button = {};
        button.content = html;
        button.action = function (event) {

        };
        return button;
    };

    $.popline.addButton({
        font_size: {
            iconClass: "fa fa-font-size",
            beforeShow: function (event) {
                var elem = jQuery(this).find('.popline_font_size_input');

                var fontSize = $($.popline.utils.selection().range().commonAncestorContainer.parentNode).css('font-size');
                fontSize = parseInt(fontSize);

                if (fontSize != 'undefine') {
                    elem.val(fontSize);
                }

                elem.bind('change', function () {
                    var size = jQuery(this).val();
                    $.popline.selectCurrentEditedText();

                    document.execCommand('FontSize', false, size + 'px');
                    jQuery("font[size]", event.target).removeAttr("size").css("font-size", size + 'px');
                });
            },
            directContent: getFontSizeChooser()
        }
    });
})(jQuery);