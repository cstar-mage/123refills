var IBMApiManager = {

    // Commands
    //-------------------------------------------

    getServiceData: function (callback) {
        this.sendRequest(callback, 'serviceData');
    },
    
    getCategoriesList: function (callback) {
        this.sendRequest(callback, 'categoriesList')
    },

    getCategoryBlocks: function (callback, categoryId) {
        this.sendRequest(callback, 'categoryBlocks', categoryId)
    },

    getBlockHtml: function (callback, blockId) {
        this.sendRequest(callback, 'blockHtml', blockId);
    },

    getBlockControlsMap: function(callback, blockId) {
        this.sendRequest(callback, 'blockControlsMap', blockId);
    },

    // Request
    //-------------------------------------------
    
    sendRequest: function (callback, apiMethod, option) {
        option = typeof option == 'undefined' ? '' : option;

        var url = getBaseUrl() + 'ibmbuilder/api';

        var data = {
            method: apiMethod
        };

        if (option !== '') {
            data.option = option;
        }

        jQuery.ajax({
            url: url,
            dataType: 'json',
            data: data,
            beforeSend: function(){
                jQuery('#ibm-loader').show();
            },
            success: function(data) {
                if (typeof data.error !== 'undefined') {
                    alert(data.message);
                }

                callback(data);
            },
            complete: function () {
                jQuery('#ibm-loader').hide();
            }
        });
    }

    //-------------------------------------------
}