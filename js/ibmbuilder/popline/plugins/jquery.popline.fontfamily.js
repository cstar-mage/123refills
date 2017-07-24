;(function($) {

    var getFontChooser = function () {

        var html = "<select class=\"dont_prevent_default popline_font_family_input\">";
        html += "</select><select style=\"display: none;\" class=\"dont_prevent_default popline_font_family_style_input\"></select>";

        var button = {};
        button.content = html;
        button.beforeShow = function (event) {

        };
        button.action = function (event) {

        };
        return button;
    };

    var getGoogleFonts = function () {
        var serviceData = IBMBuilderStorage.getStorageData('service_data');
        return serviceData.google_fonts;
    };

    $.popline.addButton({
        font_family: {
            iconClass: "fa fa-font-family",
            mode: "edit",
            directContent: getFontChooser(),
            beforeShow: function (event) {
                var elem = jQuery(this).find('.popline_font_family_input');

                elem.html('');

                var html = '<option value="-1"></option>';
                $.each(getGoogleFonts().items, function (index, elem) {
                    html += "<option value=\""+index+"\">"+elem.family+"</option>";
                });
                elem.html(html);

                elem.bind('change', function () {

                    var value = jQuery(this).val();
                    if (value == '-1') {
                        return;
                    }

                    var variants = getGoogleFonts().items[value]['variants'];
                    var html = '<option value="-1"></option>';

                    jQuery.each(variants, function(index, element) {
                        html += '<option value="'+index+'">'+element+'</option>';
                    });
                    var variantElem = elem.siblings('.popline_font_family_style_input');

                    variantElem.attr('font_index', value);

                    variantElem.html(html);

                    variantElem.show();

                    variantElem.bind('change', function () {

                        var variantValue = jQuery(this).val();

                        if (variantValue == '-1') {
                            return;
                        }
                        
                        var fontIndex = jQuery(this).attr('font_index');

                        var fontItems = getGoogleFonts().items;
                        var fontName = fontItems[fontIndex]['family'];
                        var variantName = fontItems[fontIndex]['variants'][variantValue];

                        variantElem.hide();

                        $.popline.selectCurrentEditedText();

                        WebFont.load({
                            google: {
                                families: [fontName+':'+variantName]
                            }
                        });

                        var weight = variantName.match(/\d{3,}/);
                        if (weight != null && weight.length > 0) {
                            weight = weight[0];
                        }

                        var style = variantName.match(/[a-z]{5,}/);
                        if (style != null && style.length > 0) {
                            style = style[0];
                        }

                        document.execCommand('fontName', false, fontName);
                        var fontElem = jQuery("font[face]", event.target).removeAttr("face");
                        fontElem.css("font-family", fontName);

                        if (weight) {
                            fontElem.css("font-weight", weight);
                        }

                        if (style) {
                            fontElem.css("font-style", style);
                        }
                    });
                });
            }
        }
    });
})(jQuery);