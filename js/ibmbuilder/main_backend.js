jQuery(document).ready(function() {
    var baseUrl = getBaseJsUrl();

    // if (typeof jQuery.farbtastic == 'undefined') {
        loadScript(baseUrl+'ibmbuilder/farbtastic.js');
    // }

    loadScript(baseUrl+'ibmbuilder/popline/jquery.popline.js');

    function addPopLinePlugins() {
        setTimeout(function () {
            if (jQuery.popline != 'undefined') {
                loadScript(baseUrl+'ibmbuilder/popline/plugins/jquery.popline.textcolor.js');
                loadScript(baseUrl+'ibmbuilder/popline/plugins/jquery.popline.fontfamily.js');
                loadScript(baseUrl+'ibmbuilder/popline/plugins/jquery.popline.fontsize.js');
                loadScript(baseUrl+'ibmbuilder/popline/plugins/jquery.popline.subsuper.js');
                loadScript(baseUrl+'ibmbuilder/popline/plugins/jquery.popline.blockformat.js');
                loadScript(baseUrl+'ibmbuilder/popline/plugins/jquery.popline.blockquote.js');
                loadScript(baseUrl+'ibmbuilder/popline/plugins/jquery.popline.justify.js');
                loadScript(baseUrl+'ibmbuilder/popline/plugins/jquery.popline.link.js');
                loadScript(baseUrl+'ibmbuilder/popline/plugins/jquery.popline.list.js');
                loadScript(baseUrl+'ibmbuilder/popline/plugins/jquery.popline.decoration.js');

                loadScript(baseUrl+'ibmbuilder/tools/links.js');
                loadScript(baseUrl+'ibmbuilder/tools/images.js');

                loadScript(baseUrl+'ibmbuilder/builder_functions.js');
                loadScript(baseUrl+'ibmbuilder/webfont.js');
            } else {
                addPopLinePlugins();
            }
        }, 300);
    }
    addPopLinePlugins();

    var builderButtonContainer = jQuery('#builder_button_container');

    if (builderButtonContainer.length == 0) {
        return;
    }

    jQuery('#buttonspage_content') && jQuery('#buttonspage_content').append(builderButtonContainer.html());

    builderButtonContainer.remove();

    IBMEditor.initialize();
    IBMEditorCss.initialize();
});

function loadScript(url) {
    jQuery.ajax({
        url: url,
        dataType: 'script',
        async: true
    });
}