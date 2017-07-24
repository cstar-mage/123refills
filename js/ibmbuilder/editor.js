var IBMEditor = {

    finishAnimationCallbacks: jQuery.Callbacks(),

    //-------------------------------------------

    showEditor: function() {
        jQuery('#frame').get(0).innerHTML = (jQuery('#page_content').val());

        jQuery('#frame #ibm_builder_content_fonts').remove();

        jQuery('#blocks_thumbnails_container').html('');
        jQuery('#'+IBMEditorCss.cssEditorId).html('');

        var fonts = IBMEditor.getUsedFonts();
        if (fonts.length > 0) {
            IBMBuilderFunctions.loadGoogleFonts(fonts);
        }

        jQuery('#ibm_editor_wrapper').show();

        IBMEditor.evalContentScripts();

        IBMBuilderFunctions.applyGoogleMaps(false, true);
        IBMEditorCss.afterPerformElementChangesCallbacks.push(IBMEditor.googleMapAfterPerformElementChangesCallback);

        IBMBuilderFunctions.initSliders();

        IBMEditor.modifyFrameDecoration();
        IBMEditor.correctClearButton();

        IBMEditorCss.setHistorySnapshot();
    },

    hideEditor: function() {
        jQuery('#ibm_editor_wrapper').hide();
    },

    // Initialise Editor (Fill the content, got from API, other manipulations)
    //-------------------------------------------

    initialize: function () {
        this.initializeBuilderHtml();

        this.initializeServiceData();

        this.initializeStartState();

        this.initializeEventsListeners();

        this.initializeObservers();

        this.initializeWorkSpace();

        this.initializeDraggable();

        this.initializeSortable();
    },

    initializeBuilderHtml: function () {
        jQuery('#ibm_editor_wrapper').appendTo('.wrapper');
    },

    initializeServiceData: function () {
        IBMApiManager.getServiceData(this.getServiceDataCallback);
    },

    initializeEventsListeners: function () {

        var self = this;

        jQuery(document).on('click', '.category_element', function() {
            var categoryId = jQuery(this).attr('category_id');

            //todo Check
            if (categoryId == '') {
                return;
            }

            IBMApiManager.getCategoryBlocks(self.getCategoryBlocksCallback, categoryId);
        });

        jQuery(document).on('click', '.block_thumbnail', function() {
            var blockId = jQuery(this).attr('block_id');

            IBMApiManager.getBlockHtml(self.getBlockHtmlCallback, blockId);
        });

        jQuery(document).on('click', '#clear_template', function() {
            jQuery('#ibm_dialog_container').html('are you sure you want to clear all blocks');

            jQuery('#ibm_dialog_container').dialog({
                dialogClass: "no-close",
                modal: true,
                title: "clear layout",
                width: 270,
                buttons: [
                    {
                        text: "YES",
                        click: function() {
                            jQuery('#frame').html('');
                            self.modifyFrameDecoration();

                            jQuery( this ).dialog("destroy");
                        }
                    },
                    {
                        text: "NO",
                        click: function() {
                            self.modifyFrameDecoration();

                            jQuery( this ).dialog("destroy");
                        }
                    }
                ]
            }).show();

        });

        jQuery(document).on('mouseenter', '.block_wrapper', function () {
            jQuery(this).prepend('<div class="ibm_sortable_handle"></div>');
        });
        jQuery(document).on('mouseleave', '.block_wrapper', function () {
            jQuery(this).find('div.ibm_sortable_handle').remove();
        });
		
		jQuery(document).on('mouseenter', '.block_wrapper', function () {
            jQuery(this).prepend('<div class="ibm_remove_handle" onclick="IBMEditor.removeBlock(this);"></div>');
        });
        jQuery(document).on('mouseleave', '.block_wrapper', function () {
            jQuery(this).find('div.ibm_remove_handle').remove();
        });
		
		jQuery(document).on('mouseenter', '.block_wrapper', function () {
            jQuery(this).prepend('<div class="ibm_copy_handle" onclick="IBMEditor.copyBlock(this);"></div>');
        });
        jQuery(document).on('mouseleave', '.block_wrapper', function () {
            jQuery(this).find('div.ibm_copy_handle').remove();
        });

        jQuery(document).on('click', '.blocks_container_close a', function () {
            IBMEditor.hideBlocksContainer();
        });

        jQuery(document).on('click', '.css_editor_close a', function () {
            IBMEditor.hideBlockStyleContainer();
        });
        
        jQuery(document).on('click', '.category_container_minmax a', function () {
            if (jQuery(this).hasClass('min')) {
                jQuery('.category_container').addClass('minimize');
                jQuery(this).siblings('.max').show();
                IBMEditor.correctClearButton();
            } else {
                jQuery('.category_container').removeClass('minimize');
                jQuery(this).siblings('.min').show();
                IBMEditor.correctClearButton();
            }
        });

        jQuery(document).on('click', '.ibm_undo', function () {
            var text = IBMBuilderHistory.getUndo();
            if (text === null) {
                return;
            }

            IBMEditor.hideThumbnailsContainer();
            IBMEditor.hideBlockStyleContainer();

            jQuery('#frame').html(text);

            jQuery('#frame .current_editing').removeClass('current_editing');

            IBMEditor.evalContentScripts();

            IBMEditor.modifyFrameDecoration();
        });

        jQuery(document).on('click', '.ibm_redo', function () {
            var text = IBMBuilderHistory.getRedo();
            if (text === null) {
                return;
            }

            IBMEditor.hideThumbnailsContainer();
            IBMEditor.hideBlockStyleContainer();

            jQuery('#frame').html(text);

            jQuery('#frame .current_editing').removeClass('current_editing');

            IBMEditor.evalContentScripts();
        });

        jQuery(document).on('click','#frame .block_wrapper',function(e) {
            IBMEditor.hideThumbnailsContainer();
            IBMEditor.showBlockStyleContainer();
        });

        jQuery(document).on('click','#categories_list_container .category_element',function(e){
            IBMEditor.hideBlockStyleContainer();
            IBMEditor.showThumbnailsContainer();
        });

        jQuery(document).on('change','#headline_a_range',function () {
            var v1 = jQuery(this).val();
            jQuery('div').css('font-size', v1 + 'px')
            jQuery('#headline_a').val(v1);
        });

        jQuery(document).on('change','#main_button_range', function () {
            var v2 = jQuery(this).val();
            jQuery('div').css('font-size', v2 + 'px');
            jQuery('#main_button').val(v2);
        });

        jQuery(document).on('click', '.ibm_preview_button', function () {
            jQuery('.preview_btns .ibm_preview_button').removeClass('active');
            jQuery(this).addClass('active');

            if (jQuery(this).hasClass('ibm_tablet')) {
                jQuery('#blocks_html_holder').css({'max-width' : 768, 'margin-left' : 'auto', 'margin-right' : 'auto'});
            } else if (jQuery(this).hasClass('ibm_phone')) {
                jQuery('#blocks_html_holder').css({'max-width' : 370, 'margin-left' : 'auto', 'margin-right' : 'auto'});
            } else {
                jQuery('#blocks_html_holder').css({'max-width' : '100%', 'margin-left' : 'auto', 'margin-right' : 'auto'});
            }
            EQCSS.load();
            EQCSS.apply();
            // IBMEditor.showPreview(this);
        });

        jQuery(window).resize(function() {
            IBMEditor.correctClearButton();
        });

        jQuery('.category_container').bind("transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd", function() {
            IBMEditor.correctClearButton();
        });
    },

    initializeObservers: function () {
        IBMEditor.finishAnimationCallbacks.add(IBMEditor.finishAnimationCallback);
    },

    initializeWorkSpace: function () {
        if (jQuery(window).width() <= 768) {
            jQuery('.preview_btns').hide();
        }

        if (jQuery(window).width() <= 1024) {
            jQuery('.preview_btns .ibm_screen').hide();
            jQuery('.preview_btns .ibm_tablet').trigger('click');
        }
        
        if (jQuery(window).width() < 1240) {
            jQuery('.category_container').addClass('minimize');
            jQuery('.category_container_minmax a.min').hide();
        } else {
            jQuery('.category_container_minmax a.max').hide();
        }
    },
	
	removeBlock: function(element) {
        jQuery(element).parent().remove();
        IBMEditorCss.setHistorySnapshot();
    },
	
	copyBlock: function(element) {
        var block = jQuery(element).parent().clone().removeClass('current_editing');

        var oldId = block.attr('id');

        var newId = IBMEditor.generateUniqueBlockId();
        block.attr('id', newId);


        var newHtml = block.html().replace(new RegExp(oldId, "g"), newId);
        block.html(newHtml);

        block.insertAfter(jQuery(element).parent());

        IBMEditorCss.setHistorySnapshot();
    },

    initializeStartState: function() {
        IBMApiManager.getCategoriesList(this.getCategoriesListCallback);
    },

    initializeDraggable: function() {
        jQuery('.block_thumbnail').draggable({

            connectToSortable: '#frame',
            scroll: false,
            zIndex: 1000,
            helper: 'clone',
            delay: 100,
            revert: 'invalid',
            start : function(event, ui) {

                //make the frame sortable
                jQuery('#frame').sortable({ });

                //set cursor
                jQuery('.block_thumbnail').css('cursor','-webkit-grabbing');

                //ui helper 250px
                ui.helper.css({
                    width: 250,
                    height: 'auto',
                });

                jQuery('.ui-draggable.ui-draggable-dragging p').css('outline','none');

            },
            stop: function(event, ui){

                //reset cursor
                jQuery('.block_thumbnail').css('cursor','-webkit-grab');

            },
            complete: function(event, ui){

                //on complete

            },

        });
    },

    initializeSortable: function() {
        var self = this;

        jQuery('#frame').sortable({
            axis: 'y',
            opacity: 0.9,
            scroll: false,
            zIndex: 1000,
            refreshPositions: true,
            cursor: '-webkit-grabbing',
            handle: '.ibm_sortable_handle',
            over: function(event, ui) {

                var mouseX, mouseY;
                var offset = jQuery('#frame').offset();
                w = jQuery(window).width();

                jQuery(document).mousemove(function(e) {

                    mouseX = e.pageX - offset.left - (parseInt(ui.item[0].style.width) / 2);
                    mouseY = e.pageY + jQuery('#blocks_html_holder').scrollTop() - (parseInt(ui.item[0].style.height) / 2) - 75;

                    jQuery('#frame .ui-draggable.ui-draggable-dragging').css('left', mouseX);
                    jQuery('#frame .ui-draggable.ui-draggable-dragging').css('top', mouseY);

                    height_ui = jQuery('.ui-sortable-placeholder').height();

                    if (jQuery('.ui-draggable.ui-draggable-dragging').length > 0) {

                        if(jQuery('.ui-sortable-placeholder').next().is('div')) {

                            if (self.countBlocksInFrame() > 0) {

                                //todo check using global variables w , a , b , c

                                w = jQuery(window).width();

                                if(w < 1600){
                                    a = 250 / 350;
                                } else {
                                    a = 250 / 450;
                                }

                                b = mouseX * a;

                                if(b > 250){
                                    c = 500 - b;
                                    jQuery('.ui-sortable-placeholder').css('height',c+'px');
                                } else {
                                    jQuery('.ui-sortable-placeholder').css('height',b+'px');
                                }

                            } else {
                                jQuery('.ui-sortable-placeholder').css('height','250px');
                            }

                        } else {
                            jQuery('.ui-sortable-placeholder').css('height','250px');
                        }

                    }

                });

            },
            deactivate: function (event, ui) {
                jQuery(document).unbind('mousemove');
                jQuery('#frame').css('min-height','250px');
            },
            out: function (event, ui) {
                jQuery('#frame').css('min-height','250px').sortable({});
            },
            receive: function (event, ui) {

                jQuery(document).unbind('mousemove');

                // todo improve (if exists the method)
                var item = ui.item[0];

                var blockId = jQuery(item).attr('block_id');

                IBMApiManager.getBlockHtml(self.getBlockHtmlCallback, blockId);
            }
        });
    },

    // Html creation
    //-------------------------------------------

    createCategoriesList: function (categories) {
        var html = '';

        jQuery.each(categories, function (index, item) {
            html += '<div class="category_element" onclick="addActive(this)" category_id="'+item.id+'"><span>'+item.name+'</span></div>';
        });
			//html += '<a class="export_blocks" href="javascript:;" onclick="IBMEditor.fitHtmlToMagentoTextArea()">Save Page</a>'

        return html;
    },

    createCategoryBlocksList: function (blocks) {
        var html = '';
            html += '<span class="blocks_container_close editor_tab_close"><a href="#">Close</a></span>';
			html += '<div class="drag_page">Drag or click to add block</div>';

        if (blocks == null) {
            return html;
        }

        jQuery.each(blocks, function(index, item) {
            html += '<div class="block_title">'+item.name+'</div><div id="'+item.id+'" class="block_thumbnail" ' +
                    'block_id="'+item.id+'"><img alt="'+item.name+'" src="'+item.thumbnail+'" /></div>';
        });

        return html;
    },
    
    // Api Callbacks
    //-------------------------------------------

    getServiceDataCallback: function (response) {
        IBMBuilderStorage.setStorageData('service_data', response.data);
    },

    getCategoriesListCallback: function(response) {
        var listHtml = IBMEditor.createCategoriesList(response.data);

        jQuery('#categories_list_container').append(listHtml);
    },

    getCategoryBlocksCallback: function(response) {

        var listHtml = IBMEditor.createCategoryBlocksList(response.data);

        jQuery('#blocks_thumbnails_container').html('').append(listHtml);

        IBMEditor.initializeDraggable();
    },
    
    getBlockHtmlCallback: function(response) {

        var generatedId = IBMEditor.generateUniqueBlockId();

        var content = response.data.content;
        content = content.replace(/0block_id_placeholder0/g, generatedId);

        var blockHtml = '<div class="block_wrapper" id="'+generatedId+'" ibm_block_id="'+response.data.block_id+'">'
            + content + '</div>';

        var frameThumbnail = jQuery('#frame').find('div[block_id="'+response.data.block_id+'"]');

        if (frameThumbnail.length > 0) {
            frameThumbnail.get(0).innerHTML = blockHtml;
            frameThumbnail.get(0).innerHTML.evalScripts();
            frameThumbnail.contents().unwrap();
        } else {
            var frame = document.getElementById('frame');
            frame.innerHTML = frame.innerHTML + blockHtml;
            frame.innerHTML.evalScripts();
        }

        IBMBuilderFunctions.applyGoogleMaps(false, true);
        
        IBMBuilderFunctions.initSliders();

        IBMEditor.modifyFrameDecoration();

        IBMEditorCss.setHistorySnapshot();
    },

    // Functions
    //-------------------------------------------

    showPreview: function(element) {
        var elem = jQuery(element);
        var content = IBMEditor.getPreparedContent(true);
        var pageId = jQuery('#ibm_page_id').val();

        jQuery.ajax({
            url: getBaseUrl() + 'ibmbuilder/preview/prepare',
            method: 'POST',
            data: {
                form_key: jQuery('#ibm_form_key').val(),
                id: pageId,
                content: content
            },
            beforeSend: function(){
                jQuery('#ibm-loader').show();
            },
            success: function () {

                jQuery('#ibm_dialog_container').html('<iframe id="ibm_preview_frame"></iframe>');

                var frame = jQuery('#ibm_preview_frame');

                var width = jQuery(window).width() - 40;
                var height = jQuery(window).height() / 100 * 80;

                if (elem.hasClass('ibm_phone')) {
                    width = 766;
                }
                if (elem.hasClass('ibm_tablet')) {
                    width = 1024;
                }
                frame.css('width', width);

                frame.css('height', height);

                if (width > jQuery(window).width()) {
                    width = jQuery(window).width() - 40;
                }

                frame.attr('src', '/builder_temporary_preview_page');

                jQuery('#ibm_dialog_container').dialog({
                    modal: true,
                    title: "Preview",
                    resize: false,
                    beforeClose: function( event, ui ) {
                        jQuery('#ibm_dialog_container').html('');
                    },
                    close: function( event, ui ) {
                        jQuery.ajax({
                            url: getBaseUrl() + 'ibmbuilder/preview/delete'
                        });
                        jQuery( this ).dialog("destroy");
                    }
                }).show();
                jQuery("#ibm_dialog_container").dialog({height:'auto', width:'auto'});
            },
            complete: function () {
                jQuery('#ibm-loader').hide();
            }
        });
    },

    modifyFrameDecoration: function() {
        setTimeout(function() {
            var frame = jQuery('#frame');
            var clearBtn = jQuery('#clear_template');

            if (frame.html() != '') {
                frame.removeClass('empty');
                clearBtn.show();
                IBMEditor.correctClearButton();
            } else {
                frame.addClass('empty');
                clearBtn.hide();
            }
        }, 100);
    },

    countBlocksInFrame: function() {
        return jQuery('#frame div').size();
    },

    fitHtmlToMagentoTextArea: function() {
        var html = this.getPreparedContent();

        jQuery('#page_content').val(html);

        this.applyMagentoLoadedImages(html);

        this.hideEditor();
    },

    getPreparedContent: function(useTemp) {

        var container = useTemp ? '#ibm_builder_temp_data_container' : '#frame';

        if (useTemp) {
            jQuery(container).html(jQuery('#frame').html());
        }

        IBMEditor.resetGoogleMaps(container);
        
        jQuery(container + ' .ibm_slider_container').html('');

        jQuery(container).find('[contenteditable="true"]').removeAttr('contenteditable');
        jQuery(container).find('.current_editing').removeClass('current_editing');

        var usedFonts = this.getUsedFonts();
        if (usedFonts.length > 0) {
            var fontsHtmlElement = '<div id="ibm_builder_content_fonts" style="display: none;">'+JSON.stringify(usedFonts)+'</div>';
            jQuery(container).append(fontsHtmlElement);
        }

        jQuery(container).find('style').removeAttr('data-eqcss-read');
       /* jQuery(container).find('.spinnerElement').spinner( "destroy" );*/

       if( jQuery(container).find( ".locationAdress .ui-spinner-input" ).length > 0 && jQuery(container).find( ".locationAdress .ui-spinner-input" ).textSpinner( "instance" ) != undefined) {
                jQuery(container).find( ".locationAdress .ui-spinner-input" ).textSpinner( "destroy" );
                var textSpinner = jQuery(container).find( ".locationAdress input" );
            }
        if(jQuery(container).find( ".timeText .ui-spinner-input" ).length > 0 && jQuery(container).find( ".timeText .ui-spinner-input" ).timespinner( "instance" ) != undefined) {
            jQuery(container).find( ".timeText .ui-spinner-input" ).timespinner( "destroy" );
            var timespinner = jQuery(container).find( ".timeText input" );
        }
        return jQuery(container).html();
    },

    googleMapAfterPerformElementChangesCallback: function(data) {
        IBMEditor.resetGoogleMaps('#'+data.blockId);
        
        IBMBuilderFunctions.applyGoogleMaps('#'+data.blockId, true);
    },
    
    resetGoogleMaps: function (container) {
        
        if (!container) {
            container = '#frame';
        }
        
        var mapContainers = jQuery(container).find('.ibm_google_map');

        jQuery.each(mapContainers, function (index, mapContainer) {
            var saveMapContainer = jQuery(mapContainers).find('.ibm_google_map_save_widget');
            if (saveMapContainer.length != 0) {
                
                if (saveMapContainer.length > 1) {
                    saveMapContainer = saveMapContainer[0];
                }

                saveMapContainer = jQuery(saveMapContainer);

                saveMapContainer.appendTo(jQuery(mapContainer).parent());
                saveMapContainer.find('iframe').remove();
            }
            jQuery(mapContainer).html('');
        });
    },

    generateUniqueBlockId: function () {
        
        var id = 'ibm_block_' + Date.now();

        do {
            var isExists = false;

            var editorBlocks = jQuery('#frame .block_wrapper');

            jQuery.each(editorBlocks, function (index, element) {
                if (jQuery(element).attr('id') == id) {
                    isExists = true;
                    id += '_';
                }
            });

        } while (isExists);

        return id;
    },

    applyMagentoLoadedImages: function(html) {

        var template = "https?:\/\/[a-zA-Z0-9\/\\\.]*(png|jpg|jpeg|bmp|gif)";
        var matches = html.match(new RegExp(template, "g"));

        if (matches == null || matches.length == 0) {
            return;
        }
        
        jQuery('.content-header button.save').attr('disabled','disabled');

        matches = jQuery.unique(matches);

        jQuery.ajax({
            url: getBaseUrl() + 'ibmbuilder/MediaStorage/importImage',
            data: {
                urls: matches
            },
            dataType: 'json',
            beforeSend: function(){
                jQuery('#ibm-loader').show();
            },
            success: function (data) {
                if (data == '' || data.length == 0) {
                    return false;
                }

                jQuery.each(data, function (index, elementData) {
                    var element = elementData.existedUrl;
                    var newUrl = elementData.newUrl;

                    if (newUrl == '') {
                        return;
                    }

                    var content = jQuery('#page_content').val();
                    content = content.replace(element, newUrl);
                    jQuery('#page_content').val(content);
                });
            },
            complete: function () {
                jQuery('#ibm-loader').hide();
                jQuery('.content-header button.save').removeAttr('disabled');
            }
        });
    },

    finishAnimationCallback: function() {
        var screenWidth = jQuery(window).width();

        if (screenWidth < 1024) {
            return;
        }

        setTimeout(function () {
            IBMEditor.correctClearButton();

            EQCSS.load();
            EQCSS.apply();
        }, 550);
    },

    showThumbnailsContainer: function() {
        if (jQuery('#blocks_thumbnails_container').is(':visible')) {
            return;
        }

        jQuery('#blocks_thumbnails_container').show(500,"easeInBack");

        IBMEditor.finishAnimationCallbacks.fire();
    },

    hideThumbnailsContainer: function() {
        if (!jQuery('#blocks_thumbnails_container').is(':visible')) {
            return;
        }

        jQuery('#blocks_thumbnails_container').hide(500,"easeInBack");

        IBMEditor.finishAnimationCallbacks.fire();
    },

    showBlockStyleContainer: function () {
        if (jQuery('#blocks_style_container').is(':visible')) {
            return;
        }

        jQuery('#blocks_style_container').delay(500).show({
            duration: 500,
            easing: "easeInOutQuad",
            complete: function() {
                IBMEditor.finishAnimationCallbacks.fire();
            }
        });
    },

    hideBlockStyleContainer: function () {
        if (!jQuery('#blocks_style_container').is(':visible')) {
            return;
        }

        jQuery('#blocks_style_container').delay(500).hide({
            duration: 500,
            easing: "easeInOutQuad",
            complete: function() {
                IBMEditor.finishAnimationCallbacks.fire();
            }
        });
    },

    showBlocksContainer: function () {
        if (jQuery('#blocks_thumbnails_container').is(':visible')) {
            return;
        }

        jQuery('#blocks_thumbnails_container').delay(200).show(500,"easeOutBack");

        IBMEditor.finishAnimationCallbacks.fire();
    },

    hideBlocksContainer: function () {
        if (!jQuery('#blocks_thumbnails_container').is(':visible')) {
            return;
        }

        jQuery('#blocks_thumbnails_container').delay(200).hide(500,"easeOutBack");

        IBMEditor.finishAnimationCallbacks.fire();
    },

    correctClearButton: function() {

        var width = jQuery(window).width();

        if (jQuery('#blocks_thumbnails_container').is(':visible')) {
            width -= jQuery('#blocks_thumbnails_container').outerWidth();
        }

        if (jQuery('#blocks_style_container').is(':visible')) {
            width -= jQuery('#blocks_style_container').outerWidth();
        }

        if (jQuery('.category_container').is(':visible')) {
            width -= jQuery('.category_container').outerWidth();
        }

        var marginLeft = jQuery('.left-side-buttons').offset().left + (width / 2)  - jQuery('.middle-buttons').width();

        jQuery('.ibm_control-buttons .middle-buttons').css('margin-left', marginLeft);
    },

    getUsedFonts: function (css, verbose) {

        var who, hoo, values = [], val,
            nodes = jQuery('#frame').get(0).getElementsByTagName('*'),
            L = nodes.length;
        for (var i = 0; i < L; i++) {
            who = nodes[i];
            if (who.style) {
                hoo = '#' + (who.id || who.nodeName + '(' + i + ')');
                val = who.style.fontFamily || getComputedStyle(who, '')[css];
                if (val) {
                    if (verbose) values.push([hoo, val]);
                    else if (values.indexOf(val) == -1) values.push(val);
                    // before IE9 you need to shim Array.indexOf (shown below)
                }
            }
        }

        return values;
    },

    evalContentScripts: function() {
        try {
            jQuery('#frame').get(0).innerHTML.evalScripts();
        } catch (e) {}
    }
};