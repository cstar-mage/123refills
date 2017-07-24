IBMEditorCss = {

    cssEditorId: 'appearances',

    currentEditedBlock: null,

    controlsElementsHtml: [],

    //-------------------------------------------

    afterPerformElementChangesCallbacks: [],

    //-------------------------------------------

    initialize: function() {

        var self = this;

        jQuery(document).ready(function() {

            jQuery(document).on('click', '.block_wrapper', function () {
                var blockId = jQuery(this).attr('ibm_block_id');

                if (jQuery(this).hasClass('current_editing')) {
                    return;
                } else {
                    jQuery(self.currentEditedBlock).removeClass('current_editing');
                    jQuery('#'+self.cssEditorId).html('');

                    jQuery(this).addClass('current_editing');
					// jQuery(this).css({"display":"block","width":"100%","text-align":"center"});
                    self.currentEditedBlock = this;
                }

                IBMApiManager.getBlockControlsMap(self.gotControlsData, blockId);
            });

            jQuery(document).on('mouseenter', '.can_edit', function() {
                jQuery(this).attr('contenteditable', true);
            });

            jQuery(document).on('change', '.js_change_range', function() {
                self.changeRangeInputValue(this);
            });

            jQuery(document).on('click', '.js_css_editor_control', function () {
                self.performElementChanges(this);
            });

            jQuery(document).on('change', '.js_css_editor_control', function () {
                self.performElementChanges(this);
            });

            jQuery(document).on('blur', '.current_editing .can_edit', function () {
                var elem = jQuery(this).parents('.block_wrapper');
                elem && elem.trigger('resize');
            });

            IBMEditorCss.afterPerformElementChangesCallbacks.push(IBMEditorCss.historyAfterPerformElementChangesCallback);
        });
    },

    setHistorySnapshotFromEditor: function() {
        if (jQuery('#frame .current_editing').size() > 0) {
            var text = jQuery('#frame').html();
            jQuery(document.createElement(text)).find('.current_editing').removeClass('current_editing');
            IBMEditorCss.setHistorySnapshot(text);
        }
    },

    historyAfterPerformElementChangesCallback: function (block) {
        IBMEditorCss.setHistorySnapshot();
    },

    gotControlsData: function(response) {

        if (response.data == null || response.data.controls_map == null) {
            return;
        }

        var blockId = response.data.block_id;
        
        var blockName  = response.data.block_name;

        IBMBuilderStorage.setBlockData(blockId, response.data.controls_map);

        IBMEditorCss.renderControlsHtml(blockId, blockName);
    },

    renderControlsHtml: function(blockId, blockName) {

        var controlsData = IBMBuilderStorage.getControls(blockId) !== undefined ? IBMBuilderStorage.getControls(blockId) : {};
        var groupsData = IBMBuilderStorage.getGroups(blockId) !== undefined ? IBMBuilderStorage.getGroups(blockId) : {};
        groupsData['__no_group'] = '';

        if (controlsData == null) {
            return;
        }

        IBMEditorCss.beforeRenderControlsHtml();

        jQuery.each(controlsData, function(dependent_element_id, ibmIdObject) {

            jQuery.each(ibmIdObject, function(index, controlInfo) {

                if (controlInfo.control_group === undefined) {
                    controlInfo.control_group = '__no_group';
                }
                
                var controlHtml = '<div class="css_editor_control_container" ' +
                    'control_type="'+controlInfo.control_type+'" ' +
                    'control_property="'+controlInfo.control_property+'" ';

                controlHtml += ' block_id="'+blockId+'" dependent_element_id="'+dependent_element_id+'" control_index="'+index+'" ';

                if (controlInfo.control_units != null) {
                    controlHtml += 'control_units="'+controlInfo.control_units+'" ';
                }

                if (controlInfo.control_type == 'switcher') {
                    controlHtml += 'on="'+controlInfo.options.on+'" off="'+controlInfo.options.off+'" ';
                }

                if (controlInfo.control_attribute !== undefined && controlInfo.control_attribute != '') {
                    controlHtml += 'control_attribute="'+controlInfo.control_attribute+'" ';
                }

                controlHtml += '>';

                var existedPropertyValue;
                if (controlInfo.control_attribute !== undefined && controlInfo.control_attribute != '') {
                    existedPropertyValue = IBMEditorCss.getAttributeValue(dependent_element_id, controlInfo);
                } else {
                    existedPropertyValue = IBMEditorCss.getCssProperty(dependent_element_id, controlInfo);
                }

                // if (existedPropertyValue !== '' && controlInfo.control_default_value == '') {
                if (existedPropertyValue !== '') {
                    controlInfo.control_default_value = existedPropertyValue;
                }

                    switch (controlInfo.control_type) {
                        case "range":
                            controlHtml += IBMEditorCss.renderRangeElement(controlInfo);
                            break;
                        case "color":
                            controlHtml += IBMEditorCss.renderColorElement(controlInfo);
                            break;
                        case "dropdown":
                            controlHtml += IBMEditorCss.renderDropdownElement(controlInfo);
                            break;
                        case "switcher":
                            controlHtml += IBMEditorCss.renderSwitcherElement(controlInfo);
                            break;
                        case "image":
                            controlHtml += IBMEditorCss.renderImageElement(controlInfo);
                            break;
                        case "custom":
                            controlHtml += IBMEditorCss.renderTextElement(controlInfo);
                            break;
                    }

                controlHtml += '</div>';

                if (typeof IBMEditorCss.controlsElementsHtml[controlInfo.control_type] == 'undefined') {
                    IBMEditorCss.controlsElementsHtml[controlInfo.control_type] = {};
                }

                if (typeof IBMEditorCss.controlsElementsHtml[controlInfo.control_type][controlInfo.control_group] == 'undefined') {
                    IBMEditorCss.controlsElementsHtml[controlInfo.control_type][controlInfo.control_group] = [];
                }

                IBMEditorCss.controlsElementsHtml[controlInfo.control_type][controlInfo.control_group].push(controlHtml);
            });
        });

        var typesOrder = ['color', 'range', 'dropdown', 'switcher','image', 'custom'];

        var htmlForInsert = '<div class="block_title">'+blockName+'</div>';

        jQuery.each(groupsData, function (groupId, groupTitle) {

            htmlForInsert += '<span class="active">'+groupTitle+'</span><ul>';

            jQuery.each(typesOrder, function(index, controlType) {
                if (typeof IBMEditorCss.controlsElementsHtml[controlType] == 'undefined' ||
                    typeof IBMEditorCss.controlsElementsHtml[controlType][groupId] == 'undefined') {

                    return;
                }

                var controls = IBMEditorCss.controlsElementsHtml[controlType][groupId];
                for (var key in controls) {
                    // skip loop if the property is from prototype
                    if(!controls.hasOwnProperty(key)) continue;

                    htmlForInsert += '<li>'+IBMEditorCss.controlsElementsHtml[controlType][groupId][key]+'</li>';
                }
            });

            htmlForInsert += '</ul>';
        });

        jQuery('#'+IBMEditorCss.cssEditorId).html(htmlForInsert);

        IBMEditorCss.afterRenderControlsHtml();

    },

    beforeRenderControlsHtml: function () {

        IBMEditorCss.controlsElementsHtml = [];

        // Picker clearing
        jQuery('#picker').html('');
    },

    afterRenderControlsHtml: function () {

        // Colorpickers creation
        jQuery.each(jQuery('#'+IBMEditorCss.cssEditorId+' .js_colorpicker'), function(index, element) {
            var holderId = jQuery(element).attr('holder');

            jQuery('#'+holderId).farbtastic('#'+jQuery(element).attr('id'));

            // Hack for live block updating
            jQuery('#'+holderId).click(function() {
                setTimeout(function() {
                    jQuery('#'+IBMEditorCss.cssEditorId+' .js_colorpicker').trigger('change');
                }, 100);
            });
            //-----------------------------

            jQuery(element).on('click', function() {
                jQuery('#picker .colorpicker').css("display","none");
                jQuery('#'+jQuery(this).attr('holder')).css("display","inline-block");
            });
            jQuery(element).on('blur', function () {
                jQuery('#picker .colorpicker').css("display","none");
            });
        });
        //-----------------------

        jQuery('#'+IBMEditorCss.cssEditorId+' .js_css_editor_control').trigger('change');
        
        jQuery('.can_edit').popline({position: 'relative'});

        jQuery("#appearances > span").click(function() {
             event.preventDefault();
            jQuery(this).toggleClass( "active" );
            jQuery(this).next("ul").slideToggle("slow");
        });
    },

    // Controls renderers
    //-------------------------------------------

    renderRangeElement: function (controlData) {
        var minValue = controlData.control_limits.min;

        if (typeof controlData.additional_properties != "undefined" &&
            controlData.additional_properties.length !== 0) {

            minValue = minValue - (5 * controlData.additional_properties.length);
        }

        return '<span>'+controlData.control_label+'</span>' +
            '<span class="range">' +
                '<input type="text" class="js_change_range" id="" style="border: 0; color:#8C8A8A; font-weight: bold;" />' +
                '<input id="" type="range" class="js_range js_css_editor_control" min="'+minValue+'" ' +
                    'max="'+controlData.control_limits.max+'" value="'+controlData.control_default_value+'" />' +
            '</span>';
    },

    renderColorElement: function (controlData) {

        var id = IBMEditorCss.getUniqueControlId('color', controlData.control_group);

        jQuery('#picker').append('<div id="js_colorpicker_holder_'+id+'" class="colorpicker" style="display: none;"></div>');

        return '<span>'+controlData.control_label+'</span>' +
            '<input class="js_colorpicker js_css_editor_control colorpicker" id="js_colorpicker_'+id+'" ' +
                'holder="js_colorpicker_holder_'+id+'" ' +
                'type="text" value="'+controlData.control_default_value+'"/>';
    },

    renderDropdownElement: function (controlData) {
        var options = '';

        jQuery.each(controlData.options, function(index, element) {
            options += '<option value="'+element.value+'"';

            if (element.value == controlData.control_default_value) {
                options+= ' selected="selected"';
            }

            options +='>'+element.label+'</option>';
        });

        return '<span>'+controlData.control_label+'</span>' +
            '<select class="js_css_editor_control">'+options+'</select>';
    },

    renderSwitcherElement: function (controlData) {

        var id = IBMEditorCss.getUniqueControlId('switcher', controlData.control_group);

        var html = '<span>'+controlData.control_label+'</span>' +
            '<div class="switch">' +
            '<input id="switcher_element_'+id+'" class="cmn-toggle cmn-toggle-round js_checkbox js_css_editor_control" type="checkbox"';
        
        if (controlData.control_default_value == 'on') {
            html += ' checked="checked" ';
        }
        
        html += ' /><label for="switcher_element_'+id+'"></label></div>';
        return html;
    },

    renderImageElement: function(controlData) {

        var id = IBMEditorCss.getUniqueControlId('image', controlData.control_group);

        var url = IBMEditorCss.imageEditorOnClickUrl;
        url += 'target_element_id/image_holder_'+id;
        
        var onclickHtml = "MediabrowserUtility.openDialog('"+url+"'); IBMEditorCss.mediaGalleryPopupWatcher(this, '.js_css_editor_control')";

        return '<span>'+controlData.control_label+'</span>' +
            '<input type="hidden" id="image_holder_'+id+'" class="js_css_editor_control js_image" value="'+controlData.control_default_value+'" />' +
            '<input type="button" value="Change" onclick="'+onclickHtml+'" />';
    },

    renderTextElement: function (controlData) {
        return '<span>'+controlData.control_label+'</span>' +
            '<input class="js_css_editor_control js_custom" type="text" value="'+controlData.control_default_value+'" />';
    },

    // Functions
    //-------------------------------------------

    performElementChanges: function (element) {
        var parent = jQuery(element).parents('div[class="css_editor_control_container"]');

        var blockId = parent.attr('block_id');
        var ibmId = parent.attr('dependent_element_id');
        var index = parent.attr('control_index');

        var controlData = IBMBuilderStorage.getControlDataByIndex(blockId, ibmId, index);
        
        if (typeof controlData == 'undefined') {
            return;
        }

        var property = controlData.control_property;

        var selector = jQuery(this.currentEditedBlock).find('[ibm_id="'+ibmId+'"]');

        if (jQuery(selector).length > 0) {

            var value = '';

            if (jQuery(element).hasClass('js_checkbox')) {

                value = jQuery(element).is(':checked') ? controlData.options.on : controlData.options.off;

            } else if (jQuery(element).hasClass('js_image')) {

                if (controlData.control_attribute === undefined ||
                    controlData.control_attribute == '') {

                    value = 'url("' + jQuery(element).val() + '")';
                } else {
                    value = jQuery(element).val();
                }

            } else if (jQuery(element).hasClass('js_range')) {

                value = jQuery(element).val();

                // Not numeric properties in "range" control
                if (controlData.additional_properties !== undefined &&
                    controlData.additional_properties.length !== 0 &&
                    value < controlData.control_limits.min) {

                    var interval = 5;

                    var additionalProperties = controlData.additional_properties;

                    var wasFound = false;
                    var rangeMax = controlData.control_limits.min;
                    jQuery.each(additionalProperties, function (index, property) {
                        if (wasFound) {
                            return;
                        }

                        var rangeMin = rangeMax - interval;

                        if (value >= rangeMin && value < rangeMax) {
                            value = property;
                            return;
                        }

                        rangeMax = rangeMin;
                    });


                    // todo Improve
                    parent.find('.js_change_range').val(value);

                } else {

                    // todo Improve
                    parent.find('.js_change_range').val(value);

                    if (controlData.control_units != null) {
                        value += controlData.control_units;
                    }
                }

            } else {

                value = jQuery(element).val();
                if (controlData.control_units != null) {
                    value += controlData.control_units;
                }
            }

            if (controlData.control_attribute === undefined ||
                controlData.control_attribute == '') {
                
                jQuery(selector).css(property, value);
            } else {
                jQuery(selector).attr(controlData.control_attribute, value);
            }

            IBMEditorCss.fireEvent('afterPerformElementChanges', {blockId: jQuery(this.currentEditedBlock).attr('id')});
        }
    },

    getAttributeValue: function (ibmId, controlInfo) {
        var attribute = jQuery(this.currentEditedBlock).find('[ibm_id="'+ibmId+'"]').attr(controlInfo.control_attribute);

        if (typeof attribute == 'undefined') {
            return '';
        }

        if (controlInfo.control_type == 'switcher') {
            attribute = controlInfo.options.on == attribute ? 'on' : 'off';
        }

        return attribute;
    },

    getCssProperty: function(ibmId, controlInfo) {

        var value = IBMEditorCss.getCss(jQuery(this.currentEditedBlock).find('[ibm_id="'+ibmId+'"]'), controlInfo.control_property);

        if (typeof value == 'undefined') {
            return '';
        }

        switch (controlInfo.control_type) {

            case "color":
                value = IBMEditorCss.rgb2hex(value);
                break;
            case "range":
                // todo improve (reg. expression)
                value = value.replace('px', '');
                value = value.replace('%', '');
                value = value.replace('pt', '');
                break;
            case "image":
                // todo improve (reg. expression)
                value = value.replace('url("', '');
                value = value.replace('")', '');
                break;
            case "switcher":

                if (controlInfo.options.on == value) {
                    value = 'on';
                } else if (controlInfo.options.off == value) {
                    value = 'off';
                } else {
                    value = '';
                }

                break;
            case "dropdown":

                var wasFound = false;

                jQuery.each(controlInfo.options, function(index, option) {
                    if (option.value == value) {
                        wasFound = true;
                    }
                });

                if (!wasFound) {
                    value = '';
                }
                break;
        }

        return value;
    },

    getCss: function($elem, prop) {
        if (prop == 'display') {
            return $elem.css(prop);
        }
        var wasVisible = $elem.css('display') !== 'none';
        try {
            return $elem.hide().css(prop);
        } finally {
            if (wasVisible) $elem.show();
        }
    },

    getUniqueControlId: function (type, group) {
        var existedControls = IBMEditorCss.controlsElementsHtml;

        return existedControls[type] === undefined || existedControls[type][group] === undefined ?
            group + 0 :
            group + Object.keys(existedControls[type][group]).length;
    },
    
    mediaGalleryPopupWatcher: function (element, selector) {
        setTimeout(function() {
            if (jQuery('#browser_window').is(':visible')) {
                IBMEditorCss.mediaGalleryPopupWatcher(element, selector);
            } else {
                jQuery.ajax({
                    url: getBaseUrl() + 'ibmbuilder/MediaStorage/getImageUrl',
                    data: {
                        name: jQuery(element).siblings(selector).val()
                    },
                    success: function (data) {
                        if (data == '') {
                            return;
                        }
                        jQuery(element).siblings(selector).val(data);
                        jQuery(element).siblings(selector).trigger('change');
                    }
                });
            }
        }, 200);
    },

    changeRangeInputValue: function (element) {
        var value = parseInt(jQuery(element).val());

        var control = jQuery(element).siblings('.js_css_editor_control');

        if (isNaN(value)) {
            jQuery(element).val(control.val());
            return;
        }

        var min = parseInt(control.attr('min'));
        var max = parseInt(control.attr('max'));

        if (value < min) {
            jQuery(element).val(min);
            return;
        }

        if (value > max) {
            jQuery(element).val(max);
            return;
        }

        control.val(value);
        control.trigger('change');
    },

    rgb2hex: function(rgb){
        rgb = rgb.match(/^rgba?[\s+]?\([\s+]?(\d+)[\s+]?,[\s+]?(\d+)[\s+]?,[\s+]?(\d+)[\s+]?/i);
        return (rgb && rgb.length === 4) ? "#" +
        ("0" + parseInt(rgb[1],10).toString(16)).slice(-2) +
        ("0" + parseInt(rgb[2],10).toString(16)).slice(-2) +
        ("0" + parseInt(rgb[3],10).toString(16)).slice(-2) : '';
    },

    setHistorySnapshot: function (text) {
        if (typeof text !== 'undefined' ) {
            IBMBuilderHistory.setSnapshot(text);
        } else {
            IBMBuilderHistory.setSnapshot(jQuery('#frame').html());
        }
    },

    //-------------------------------------------

    fireEvent: function(eventName, data) {
        jQuery.each(IBMEditorCss[eventName + 'Callbacks'], function (index, event) {
            if (typeof event == 'undefined') {
                return;
            }
            event(data);
        });
    }

    //-------------------------------------------

}

