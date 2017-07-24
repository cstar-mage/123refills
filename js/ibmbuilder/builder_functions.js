var IBMBuilderFunctions = {

    googleMapStyles: {
        'map_dark': [
            {
                "featureType": "all",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "simplified"
                    },
                    {
                        "invert_lightness": true
                    },
                    {
                        "saturation": -94
                    },
                    {
                        "lightness": 17
                    },
                    {
                        "gamma": 0.96
                    }
                ]
            },
            {
                "featureType": "poi",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "off"
                    },
                    {
                        "color": "#000000"
                    }
                ]
            }
        ],
        'map_light_monochrome': [
            {
                "featureType": "water",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "simplified"
                    },
                    {
                        "hue": "#e9ebed"
                    },
                    {
                        "saturation": -78
                    },
                    {
                        "lightness": 67
                    }
                ]
            },
            {
                "featureType": "landscape",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "simplified"
                    },
                    {
                        "hue": "#ffffff"
                    },
                    {
                        "saturation": -100
                    },
                    {
                        "lightness": 100
                    }
                ]
            },
            {
                "featureType": "road",
                "elementType": "geometry",
                "stylers": [
                    {
                        "visibility": "simplified"
                    },
                    {
                        "hue": "#bbc0c4"
                    },
                    {
                        "saturation": -93
                    },
                    {
                        "lightness": 31
                    }
                ]
            },
            {
                "featureType": "poi",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "off"
                    },
                    {
                        "hue": "#ffffff"
                    },
                    {
                        "saturation": -100
                    },
                    {
                        "lightness": 100
                    }
                ]
            },
            {
                "featureType": "road.local",
                "elementType": "geometry",
                "stylers": [
                    {
                        "visibility": "simplified"
                    },
                    {
                        "hue": "#e9ebed"
                    },
                    {
                        "saturation": -90
                    },
                    {
                        "lightness": -8
                    }
                ]
            },
            {
                "featureType": "transit",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "on"
                    },
                    {
                        "hue": "#e9ebed"
                    },
                    {
                        "saturation": 10
                    },
                    {
                        "lightness": 69
                    }
                ]
            },
            {
                "featureType": "administrative.locality",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "on"
                    },
                    {
                        "hue": "#2c2e33"
                    },
                    {
                        "saturation": 7
                    },
                    {
                        "lightness": 19
                    }
                ]
            },
            {
                "featureType": "road",
                "elementType": "labels",
                "stylers": [
                    {
                        "visibility": "on"
                    },
                    {
                        "hue": "#bbc0c4"
                    },
                    {
                        "saturation": -93
                    },
                    {
                        "lightness": 31
                    }
                ]
            },
            {
                "featureType": "road.arterial",
                "elementType": "labels",
                "stylers": [
                    {
                        "visibility": "simplified"
                    },
                    {
                        "hue": "#bbc0c4"
                    },
                    {
                        "saturation": -93
                    },
                    {
                        "lightness": -2
                    }
                ]
            }
        ],
        'light_grey': [
            {
                featureType: 'all',
                stylers: [
                    {saturation: -80}
                ]
            }, {
                featureType: 'road.arterial',
                elementType: 'geometry',
                stylers: [
                    {hue: '#00ffee'},
                    {saturation: 50}
                ]
            }, {
                featureType: 'poi.business',
                elementType: 'labels',
                stylers: [
                    {visibility: 'off'}
                ]
            }
        ],
        'sand_green': [
            {
                featureType: 'water', // set the water color
                elementType: 'geometry.fill', // apply the color only to the fill
                stylers: [
                    {color: '#adc9b8'}
                ]
            }, {
                featureType: 'landscape.natural', // set the natural landscape
                elementType: 'all',
                stylers: [
                    {hue: '#809f80'},
                    {lightness: -35}
                ]
            }
            , {
                featureType: 'poi', // set the point of interest
                elementType: 'geometry',
                stylers: [
                    {hue: '#f9e0b7'},
                    {lightness: 30}
                ]
            }, {
                featureType: 'road', // set the road
                elementType: 'geometry',
                stylers: [
                    {hue: '#d5c18c'},
                    {lightness: 14}
                ]
            }, {
                featureType: 'road.local', // set the local road
                elementType: 'all',
                stylers: [
                    {hue: '#ffd7a6'},
                    {saturation: 100},
                    {lightness: -12}
                ]
            }
        ]
    },

    loadGoogleFonts: function (fonts) {

        if (!fonts) {
            var fontsElement = jQuery('#ibm_builder_content_fonts');
            if (fontsElement.length != 1) {
                return;
            }

            fonts = JSON.parse(fontsElement.html());
        }

        try {
            WebFont.load({
                google: {
                    families: fonts
                }
            });
        } catch (e) {
        }
    },

    initGoogleMaps: function () {
        if (jQuery('.applyGoogleMaps').length != 0) {
            jQuery('head').append('<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCCuY_t62l6GZgu_D5Z0CBTp8urxZWZ_Fc&signed_in=true&callback=IBMBuilderFunctions.applyGoogleMaps" async defer></script>');
        }
    },

    initSliders: function () {
        var slidersElements = jQuery('.ibm_slider_container');
        if (slidersElements.length == 0) {
            return;
        }

        IBMBuilderFunctions.loadScript('/js/ibmbuilder/royalslider/royalslider.js');

        jQuery.each(slidersElements, function (index, sliderElement) {

            sliderElement = jQuery(sliderElement);

            if (sliderElement.find('.ibmRsSliderContainer').length > 0) {
                return;
            }

            jQuery.ajax({
                url: '/ibm_builder/elements/getElementHtml/type/slider',
                success: function (data) {

                    sliderElement.append(data);

                    var autoScaleSlider = sliderElement.attr('autoscaleslider') ? JSON.parse(sliderElement.attr('autoscaleslider')) : true;
                    /* var autoScaleSliderWidth = sliderElement.attr('autoscalesliderwidth') ? sliderElement.attr('autoscalesliderwidth') : 1920;*/
                    var autoScaleSliderWidth = 1920;
                    var autoScaleSliderHeight = sliderElement.attr('autoscalesliderheight') ? sliderElement.attr('autoscalesliderheight') : 480;
                    var arrowsNav = sliderElement.attr('arrowsnav') ? JSON.parse(sliderElement.attr('arrowsnav')) : true;
                    var arrowsNavAutoHide = sliderElement.attr('arrowsnavautohide') ? JSON.parse(sliderElement.attr('arrowsnavautohide')) : true;
                    var loop = sliderElement.attr('sliderloop') ? JSON.parse(sliderElement.attr('sliderloop')) : true;
                    var slidesSpacing = sliderElement.attr('slidesspacing') ? sliderElement.attr('slidesspacing') : 0;
                    var transitionSpeed = sliderElement.attr('transitionspeed') ? sliderElement.attr('transitionspeed') : 1000;
                    var transitionType = sliderElement.attr('transitiontype') ? sliderElement.attr('transitiontype') : 'move';
                    var imageScaleMode = sliderElement.attr('imagescalemode') ? sliderElement.attr('imagescalemode') : 'none';
                    var controlNavigation = sliderElement.attr('controlnavigation') ? sliderElement.attr('controlnavigation') : 'none';

                    var autoPlayEnabled = sliderElement.attr('autoplayenabled') ? JSON.parse(sliderElement.attr('autoplayenabled')) : true;
                    var autoPlayDelay = sliderElement.attr('autoplaydelay') ? sliderElement.attr('autoplaydelay') : 4000;
                    var autoPlayPauseOnHover = sliderElement.attr('autoplaypauseonhover') ? JSON.parse(sliderElement.attr('autoplaypauseonhover')) : false;

                    sliderElement.find('.ibmRsSliderContainer').royalSlider({
                        transitionType  : transitionType,
                        slidesOrientation : "horizontal",
                        autoHeight   : false,
                        arrowsNav   : arrowsNav,
                        arrowsNavAutoHide : arrowsNavAutoHide,
                        fadeinLoadedSlide : false,
                        globalCaption  : 0,
                        loop    : loop,
                        loopRewind   : false,
                        controlNavigation : controlNavigation,
                        navigateByClick  : true,
                        autoScaleSlider   : autoScaleSlider,
                        autoScaleSliderHeight : autoScaleSliderHeight,
                        autoScaleSliderWidth : autoScaleSliderWidth,
                        transitionSpeed: transitionSpeed,
                        autoPlay :
                        {
                            enabled   : autoPlayEnabled,
                            delay   : autoPlayDelay,
                            pauseOnHover : autoPlayPauseOnHover
                        },
                        randomizeSlides  : false,
                        imageScaleMode  : imageScaleMode,
                        slidesSpacing  : slidesSpacing
                    });
                }
            });
        });
    },

    applyGoogleMaps: function (container, disable) {
        var attributes = ['zoom', 'lat', 'lng', 'place_id', 'map_type', 'map_style'];

        var mapsElements = container ? jQuery(container + ' .ibm_google_map') : jQuery('.ibm_google_map');

        jQuery.each(mapsElements, function (index, entity) {
            var mapElement = jQuery(entity);

            if (mapElement.html() != '') {
                return;
            }

            var mapInfo = {};
            var elemAttributes = {};
            jQuery.each(attributes, function (attrIndex, attribute) {
                elemAttributes[attribute] = mapElement.attr(attribute);
            });

            if (elemAttributes['zoom'] != 'undefined') {
                mapInfo['zoom'] = parseInt(elemAttributes['zoom']);
            }

            if (elemAttributes['map_style'] != 'undefined') {
                mapInfo['styles'] = IBMBuilderFunctions.googleMapStyles[elemAttributes['map_style']];
            }

            if (elemAttributes['lat'] == 'undefined' || elemAttributes['lng'] == 'undefined') {
                return;
            } else {
                mapInfo['center'] = {'lat': parseInt(elemAttributes['lat']), 'lng': parseInt(elemAttributes['lng'])};
            }

            mapInfo['mapTypeControlOptions'] = {
                mapTypeIds: [
                    'roadmap',
                    'satellite'
                ],
                position: google.maps.ControlPosition.BOTTOM_LEFT
            };

            if (disable) {
                mapInfo.navigationControl = false;
                mapInfo.mapTypeControl = false;
                mapInfo.scaleControl = false;
                mapInfo.draggable = false;
                mapInfo.scrollwheel = false;
            }

            var googleMap = new google.maps.Map(mapElement.get(0), mapInfo);

            var widgetDiv = mapElement.parents('.block_wrapper').find('.ibm_google_map_save_widget');

            if (widgetDiv.length == 0) {
                return;
            }

            widgetDiv.find('iframe').remove();

            widgetDiv = widgetDiv.get(0);
            googleMap.controls[google.maps.ControlPosition.TOP_LEFT].push(widgetDiv);

            // Append a Save Control to the existing save-widget div.
            var saveWidget = new google.maps.SaveWidget(widgetDiv, {
                place: {
                    location: {lat: parseFloat(elemAttributes['lat']), lng: parseFloat(elemAttributes['lng'])},
                    placeId: elemAttributes['place_id']
                },
                attribution: {
                    source: 'Google Maps JavaScript API',
                    webUrl: 'https://developers.google.com/maps/'
                }
            });

            var marker = new google.maps.Marker({
                map: googleMap,
                position: saveWidget.getPlace().location
            });

            googleMap.panTo(marker.getPosition());
        });
    },

    loadScript: function (url, callback, param) {
        var ajaxData = {
            url: url,
            dataType: 'script',
            async: true,
        };

        if (typeof callback != 'undefined') {
            ajaxData.success = function () {
                if (param) {
                    callback(param);
                } else {
                    callback();
                }
            };
        }

        jQuery.ajax(ajaxData);
    }
};

document.addEventListener('DOMContentLoaded', function () {
    IBMBuilderFunctions.loadGoogleFonts();
    IBMBuilderFunctions.initGoogleMaps();

    IBMBuilderFunctions.loadScript('js/ibmbuilder/jquery.validate.min.js');

    IBMBuilderFunctions.initSliders();
});