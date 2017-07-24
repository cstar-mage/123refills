;window.hasOwnProperty = function (obj) {return (this[obj]) ? true : false;};
if(typeof(jQueryIWD) == "undefined"){if(typeof(jQuery) != "undefined") {jQueryIWD = jQuery;}} $ji = jQueryIWD;

IWD.OrderManager.FlagsOrderGrid = {
    iwdFlagCell: '.iwd-om-flag-cell',
    iwdFlagAssign: '.flag-assign',
    flagsTypesRelation: {},
    applyUrl: '',
    orderId: 0,
    flagId: 0,
    flagTypeId: 0,
    currentFlag: null,

    init: function() {
        this.iconImageChange();
        this.initNiceScroll();
    },

    iconImageChange: function() {
        var self = this;
        $ji(document).on('click', this.iwdFlagCell, function(){
            self.orderId = $ji(this).data('order-id');
            self.flagTypeId = $ji(this).data('flag-type');
            self.currentFlag = $ji(this);
            self.flagId = $ji(this).find('.iwd-om-flag-image, .iwd-om-flag-font').data('flag-id');

            var incrementId = $ji(this).data('order-increment-id');
            $ji('#iwd_om_flags_popup .order_number').html(incrementId);

            self.prepareFlagsForType();
            $ji('#iwd_om_flags_popup').modaliwd('show');
            self.reinitNiceScroll();
        });
    },

    prepareFlagsForType: function() {
        $ji('.iwd-om-flag-popup').hide();
        $ji('.iwd-om-flag-popup button.assign').show();
        $ji('.iwd-om-flag-popup button.unassign').hide();

        var flags = (typeof(this.flagsTypesRelation[this.flagTypeId]) != "undefined") ? this.flagsTypesRelation[this.flagTypeId] : [];
        $ji.each(flags, function(i, id){
            $ji('.iwd-om-flag-popup[data-id='+id+']').show();
        });

        var currentFlag = $ji('.iwd-om-flag-popup[data-id='+this.flagId+']');
        $ji(currentFlag).find('button.assign').hide();
        $ji(currentFlag).find('button.unassign').show();
    },

    assignFlagToOrder: function(flag) {
        var self = this;
        var data = {form_key:FORM_KEY, flag_id:flag, order_id:self.orderId, type_id:self.flagTypeId};
        self.showLoadingMask();

        $ji.ajax({url: this.applyUrl,
            type: "POST",
            dataType: 'json',
            data: data,
            success: function (result) {
                if (result.ajaxExpired) {
                    document.location.reload(true);
                    return;
                }
                if (result.status) {
                    $ji('#iwd_om_flags_popup').modaliwd('hide');
                    $ji(self.currentFlag).html(result.flagHtml);
                }
                self.hideLadingMask();
            },
            error: function () {
                self.hideLadingMask();
            }
        });
    },

    initNiceScroll: function()
    {
        var self = this;
        $ji("#iwd_om_flags_popup .flag-table")
            .niceScroll({cursorcolor:"#000", cursorborder:'', cursoropacitymin:0.2, cursoropacitymax:0.5, cursorfixedheight:57, cursorwidth:9,cursorborderradius:5, railoffset:{left:28}});
        $ji(document).on('hidden.bs.modal', '#iwd_om_flags_popup' ,function () {
            self.reinitNiceScroll();
        });
    },

    reinitNiceScroll: function(){
        setTimeout(function() {
            $ji("#iwd_om_flags_popup .flag-table").getNiceScroll().resize();
        }, 500);
    },

    showLoadingMask: function () {
        $ji('#loading-mask').width($ji("html").width()).height($ji("html").height()).css('top', 0).css('left', -2).css('z-index', 10000).show();
    },

    hideLadingMask: function(){
        $ji('#loading-mask').hide();
    }
};
