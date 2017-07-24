/**
 * Created by lucas on 1/03/15.
 */

document.observe('click', function (e, element) {
    if (element = e.findElement('.expand-debug-rule-view')) {
        var raw_field_element = element.readAttribute('data-fieldset');
        $(raw_field_element).show();
        element.hide();
        element.next('img').show();
        e.stop();
    }
    if (element = e.findElement('.collapse-debug-rule-view')) {
        var raw_field_element = element.readAttribute('data-fieldset');
        $(raw_field_element).hide();
        element.hide();
        element.previous('img').show();
        e.stop();
    }
});

