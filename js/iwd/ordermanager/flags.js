;if(typeof(jQueryIWD) == "undefined"){if(typeof(jQuery) != "undefined") {jQueryIWD = jQuery;}} $ji = jQueryIWD;
window.hasOwnProperty = function (obj) {return (this[obj]) ? true : false;};
if (!window.hasOwnProperty('IWD')) {IWD = {};}
if (!window.hasOwnProperty('IWD.OrderManager')) {IWD.OrderManager = {};}

IWD.OrderManager.Flags = {
    iconImage: '#icon-image',
    iconFont: '#icon-font',
    iconFa: '#icon_fa',
    iconFaColor: '#icon_fa_color',
    iconFile: '#icon_img',
    iconType: '#icon_type',

    init: function() {
        this.iconImageChange();
        this.iconFontChange();
        this.initColpick();
        this.selectIconType();
        this.iconFaPreview();
        this.disableInactiveOptionsForAutoApply();
    },

    iconImageChange: function() {
        var self = this;
        $ji(document).on('change', this.iconImage, function(){
            $ji(self.iconFa).closest('tr').hide();
            $ji(self.iconFaColor).closest('tr').hide();
            $ji(self.iconFile).closest('tr').show();

            $ji(self.iconFa).removeClass('required-entry');
            $ji(self.iconFaColor).removeClass('required-entry');
            if (!$ji(self.iconFile).attr('value')) {
                $ji(self.iconFile).addClass('required-entry');
            }
        });
    },

    iconFontChange: function() {
        var self = this;
        $ji(document).on('change', this.iconFont, function(){
            $ji(self.iconFa).closest('tr').show();
            $ji(self.iconFaColor).closest('tr').show();
            $ji(self.iconFile).closest('tr').hide();

            $ji(self.iconFa).addClass('required-entry');
            $ji(self.iconFaColor).addClass('required-entry');
            $ji(self.iconFile).removeClass('required-entry');
        });
    },

    initColpick: function() {
        var self = this;
        var currentColor = $ji(this.iconFaColor).val();
        self.updateInputColor(currentColor);

        $ji(this.iconFaColor).on('click', function () {
            currentColor = $ji(this).css('background-color');
            currentColor = self.rgb2hex(currentColor);
        }).on('change', function () {
            currentColor = $ji(this).val();
            self.updateInputColor(currentColor);
        }).colpick({
            onBeforeShow: function () {
                $ji(this).colpickSetColor(currentColor);
            },
            colorScheme: 'light',
            layout: 'rgbhex',
            onSubmit: function (hsb, hex, rgb, el) {
                $ji(el).colpickHide();
                self.updateInputColor(hex);
            }
        });
    },

    updateInputColor: function(hex) {
        hex = hex.replace('#', '');
        hex = hex.trim();
        if (hex && hex.length != 0) {
            var textColor = ("012345678".indexOf(hex[0]) !== -1) ? "#FFFFFF" : "#000000";
            $ji(this.iconFaColor).css('background-color', '#' + hex)
                .css('color', textColor)
                .val('#' + hex);

            this.updateFaIcon();
        } else {
            $ji(this.iconFaColor)
                .css('background-color', '#ffffff')
                .attr('placeholder', 'Icon Color')
                .val('');

        }
    },

    rgb2hex: function(rgb) {
        rgb = rgb.match(/^rgb\w*\((\d+),\s*(\d+),\s*(\d+)/);
        if(rgb == null){
            return "#FFFFFF";
        }
        return "#" +
            ("0" + parseInt(rgb[1], 10).toString(16)).slice(-2) +
            ("0" + parseInt(rgb[2], 10).toString(16)).slice(-2) +
            ("0" + parseInt(rgb[3], 10).toString(16)).slice(-2);
    },

    selectIconType: function() {
        if ($ji(this.iconType).val() == 'font') {
            $ji(this.iconFont).attr('checked', 'checked').change();
        } else {
            $ji(this.iconImage).attr('checked', 'checked').change();
        }
    },

    iconFaPreview: function() {
        var self = this;
        $ji(this.iconFa).on('change', function(){
            self.updateFaIcon();
        });
    },

    updateFaIcon: function() {
        $ji('#icon_fa_preview').remove();
        if ($ji(this.iconFa).val()) {
            $ji(this.iconFa).before('<div id="icon_fa_preview" class="iwd-om-flag-font margin-left"><i class="fa ' + $ji(this.iconFa).val() + '" aria-hidden="true" style="color:' + $ji(this.iconFaColor).val() + ';"></i></div>')
        }
    },

    disableInactiveOptionsForAutoApply: function() {
        var autoApplyDisabled = $ji('#disallowed_autoapply_options').val();
        autoApplyDisabled = JSON.parse(autoApplyDisabled);
        $ji.each(autoApplyDisabled, function(i, options){
            $ji.each(options, function(){
                $ji('#' + i + ' option[value=' + this + ']').attr('disabled', 'disabled');
            });
        });
    }
};

$ji(document).ready(function(){
    IWD.OrderManager.Flags.init();
});