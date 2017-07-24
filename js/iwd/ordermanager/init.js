;window.hasOwnProperty = function (obj) {return (this[obj]) ? true : false;};
if (!window.hasOwnProperty('IWD')) {IWD = {};}
if(typeof(jQueryIWD) == "undefined"){if(typeof(jQuery) != "undefined") {jQueryIWD = jQuery;}} $ji = jQueryIWD;

IWD.OrderManager = {
    orderId: null,
    lang: 'en',
    is_archive: 0,

    init: function (orderId) {
        IWD.OrderManager.orderId = orderId;
        this.markAsArchived();
        if ($ji('.columns .side-col').length) {
            this.responsiveDesign();
        }
    },

    ShowLoadingMask: function () {
        $ji('#loading-mask').width($ji("html").width()).height($ji("html").height()).css('top', 0).css('left', -2).show();
    },

    HideLoadingMask: function () {
        $ji('#loading-mask').hide();
    },

    markAsArchived: function () {
        if (IWD.OrderManager.is_archive == 1) {
            var text = $ji('h3.head-sales-order').html();
            $ji('h3.head-sales-order').html(text + " | ARCHIVED");
        }
    },

    responsiveDesign: function() {
        var leftSideBottom = $ji('.columns .side-col').offset().top + $ji('.columns .side-col').height() + 10;
        $ji(window).scroll(function(e){
            if ($ji(window).scrollTop() > leftSideBottom) {
                $ji('.adminhtml-sales-order-view').addClass('iwd-om-one-column');
                $ji(window).trigger('resize');
            } else {
                $ji('.adminhtml-sales-order-view').removeClass('iwd-om-one-column');
                $ji(window).trigger('resize');
            }
        });
    },

    handleSuccessResult: function (result, parentBlock) {
        if (result.ajaxExpired || result.status == 1) {
            location.reload();
        } else {
            IWD.OrderManager.addMessage(parentBlock, result);
        }
    },

    addMessage: function(parentBlock, message, msgClass) {
        $ji(parentBlock).find('ul.messages').remove();

        if (message.error) {
            msgClass = "error-msg";
            message = message.error;
            $ji(parentBlock).prepend('<ul class="messages"><li class="' + msgClass + '" style="margin:0 !important;">' + message + '</li></ul>');
        }
        if (message.success) {
            msgClass = "success-msg";
            message = message.success;
            $ji(parentBlock).prepend('<ul class="messages"><li class="' + msgClass + '" style="margin:0 !important;">' + message + '</li></ul>');
        }

        IWD.OrderManager.HideLoadingMask();
    },

    handleErrorResult: function (result) {
        location.reload();
    }
};
