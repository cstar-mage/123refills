;(function($) {

    var editedElement = null;

    $('#frame').on('mouseenter', '.block_wrapper.current_editing a', function() {
        showToolLink(this);
    });

    $('#frame').on('mouseleave', '.block_wrapper.current_editing a', function() {
        setTimeout(function() {
            if ($('#ibm_tool_link_element:hover').length > 0) {
                return;
            }
            removeToolLink();
        }, 500);
    });

    $('#frame').on('click', '#ibm_tool_link_element_button', function () {
        setLinkValue($('#ibm_tool_link_element_input').val());
        removeToolLink();
    });

    $('#frame').on('blur', '#ibm_tool_link_element', function () {
        setTimeout(function() {
            removeToolLink();
        }, 100);
    });

    var showToolLink = function (element) {
        if (editedElement != null) {
            return;
        }

        editedElement = $(element);

        var toolHtml = '<div id="ibm_tool_link_element" style="display: inline;">' +
            '<input id="ibm_tool_link_element_input" value="'+editedElement.attr('href')+'" />' +
            '<input type="button" id="ibm_tool_link_element_button" value="Set" />'+
            '</div>';

        editedElement.parent().append(toolHtml);
    };

    var setLinkValue = function (value) {
        if (value == '') {
            value = '#';
        }

        editedElement.attr('href', value);
    };

    var removeToolLink = function () {
        editedElement = null;
        $('#ibm_tool_link_element').remove();
    }
})(jQuery);