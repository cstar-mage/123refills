;(function($) {

    var activeElement = null;

    $('#frame').on('mouseenter', '.block_wrapper.current_editing img', function() {
        showToolImage(this);
    });

    $('#frame').on('mouseleave', '.block_wrapper img', function() {

        setTimeout(function() {
            if ($('#ibm_tool_image_element:hover').length > 0 || $('#ibm_tool_image_element').hasClass('not_remove')) {
                return;
            }
            removeToolImage();
        }, 500);
    });

    $('#frame').on('click', '#ibm_tool_image_element_button', function() {
        simulateControlClick();
    });

    $('#frame').on('click', '#ibm_tool_image_change_button', function() {

        var id = 'ibm_tool_image_holder';
        var url = IBMEditorCss.imageEditorOnClickUrl;
        url += 'target_element_id/'+id;
        MediabrowserUtility.openDialog(url); IBMEditorCss.mediaGalleryPopupWatcher(this, '#ibm_tool_image_holder');
    });

    var changeImage = function() {
        var image = $('#ibm_tool_image_holder').val();
        $('#ibm_tool_image_element').siblings('img').attr('src', image);
        removeToolImage();
    };

    var showToolImage = function (element) {
        if (activeElement != null) {
            return;
        }

        activeElement = $(element);

        var toolHtml = '<div id="ibm_tool_image_element">'+activeElement.width()+' x '+activeElement.height();
        if (isControlExists(activeElement.attr('ibm_id'))) {
            toolHtml += ' <input type="button" id="ibm_tool_image_element_button" value="Change" />';
        } else {
            $('#ibm_tool_image_element').addClass('not_remove');
            var id = 'ibm_tool_image_holder';
            toolHtml += '<input type="hidden" id="'+id+'" />';
            toolHtml += '<input type="button" id="ibm_tool_image_change_button" value="Change" />';
        }
        toolHtml += '</div>';

        activeElement.parent().append(toolHtml);

        jQuery('#ibm_tool_image_holder').change(function() {changeImage();});
    };

    var simulateControlClick = function () {
        var ibmId = activeElement.attr('ibm_id');
        selectElementControlButton(ibmId).trigger('click');
        removeToolImage();
    };

    var isControlExists = function (ibmId) {
        if (ibmId == 'undefined') {
            return false;
        }

        var elementControlButton = selectElementControlButton(ibmId);

        return elementControlButton.length > 0;
    };

    var selectElementControlButton = function(ibmId) {
        return $('#blocks_style_container .css_editor_control_container[dependent_element_id="'+ibmId+'"][control_attribute="src"] input[type="button"]');
    };

    var removeToolImage = function () {
        activeElement = null;
        $('#ibm_tool_image_element').remove();
    }
})(jQuery);