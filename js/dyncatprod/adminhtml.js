/**
 * Created by lucas on 1/03/15.
 */

document.observe('click', function (e, element) {
    if (element = e.findElement('.expand-raw-rule-view')) {
        var raw_field_element = element.readAttribute('data-fieldset');
        populateCategories(raw_field_element + '_categories');
        if($(raw_field_element + '_raw'))  { $(raw_field_element + '_raw').show(); }
        if($(raw_field_element + '_copy')) { $(raw_field_element + '_copy').show(); }
        element.hide();
        element.next('img').show();
        e.stop();
    }
    if (element = e.findElement('.collapse-raw-rule-view')) {
        var raw_field_element = element.readAttribute('data-fieldset');
        if($(raw_field_element + '_raw'))  { $(raw_field_element + '_raw').hide(); }
        if($(raw_field_element + '_copy')) { $(raw_field_element + '_copy').hide(); }
        element.hide();
        element.previous('img').show();
        e.stop();
    }
});

function copyDynamicCategoryRule(url, currentCat, type) {
    var params = {
        id: currentCat,
        copyFrom: $('rulecopyfor'+type).options[$('rulecopyfor'+type).selectedIndex].value,
        copyType: type
    }
    if (category_info_tabsJsTabs.activeTab) {
        params['active_tab_id'] = category_info_tabsJsTabs.activeTab.id;
    }
    updateContent(url, params, true);
}

function refreshCategoryList(url, raw_field_element, type) {
    debugger;
    populateCategories(raw_field_element + '_categories');
    updateContent(url, params, true);
}

function updateDynamicCategoryRule(url, currentCat, type) {
    var params = {
        id: currentCat,
        copyFrom: $('ruleupdatefor' + type).value,
        copyType: type
    }
    if (category_info_tabsJsTabs.activeTab) {
        params['active_tab_id'] = category_info_tabsJsTabs.activeTab.id;
    }
    updateContent(url, params, true);
}

function cleanListBox(id,excludeFirstData){
    if (excludeFirstData){
        var first_label = $(id).options[0].text;
        var first_value = $(id).options[0].value;
    }
    while ($(id).options.length != 0) $(id).options[0]=null;
    if (excludeFirstData) $(id).options[0] = new Option(first_label,first_value);
}

function fillListBox(id,data){
    for (var key in data) {
        if (data.hasOwnProperty(key)) {
            var newOpt = document.createElement("option");
            newOpt.text = data[key];
            newOpt.value = key;
            $(id).options.add(newOpt);
        }
    }
}

