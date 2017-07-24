;if(typeof(jQueryIWD) == "undefined"){if(typeof(jQuery) != "undefined") {jQueryIWD = jQuery;}} $ji = jQueryIWD;
IWD.OrderManager.Massaction = {
    selectActions: '#sales_order_grid_massaction-select',
    manageButtonId: 'iwd-manage-massaction',
    manageMassactionListId: 'iwd-manage-massaction-list',
    updateUrl: '#',
    options: {},

    init: function(options) {
        try {
            this.options = JSON.parse(options);
        } catch(e) {
            this.options = {};
        }

        this.initMassActionsSelect();
        this.addManageButton();
        this.initManageButton();
        this.generateActionsList();
        this.massactionTestArea();
    },

    reInit: function() {
        this.initMassActionsSelect();
        this.addManageButton();
        this.generateActionsList();
        this.massactionTestArea();
    },

    massactionTestArea: function() {
        $ji(document).on('focus', '.iwd_order_massaction_comments', function () {
            $ji(this).closest('.field-row').css('position','relative');
            $ji(this).after('<div class="iwd_order_massaction_comments-fix"></div>');
            $ji(this).addClass('big-textarea');
        }).on('focusout', '.iwd_order_massaction_comments', function () {
            $ji(this).removeClass('big-textarea');
            $ji('.iwd_order_massaction_comments-fix').remove();
        });
    },

    initMassActionsSelect: function () {
        var self = this;
        if (this.options.length == 0) {
            return;
        }

        var newOptions = [];

        $ji.each(this.options, function (i, val) {
            var option = $ji(self.selectActions + ' option[value=' + i + ']');
            val == 0 ? option.hide() : option.show();
            newOptions.push(option);
        });

        $ji.each(newOptions, function (i, val) {
            $ji(self.selectActions).append(val);
        });
    },

    addManageButton: function () {
        //var newFeature = '<span>New feature! Now you can manage your list of grid actions.</span>';
        var manageButton = '<span id="' + this.manageButtonId + '" title="Manage your list of grid actions"><i class="fa fa-cogs" aria-hidden="true"></i></span>';
        $ji('#' + this.manageButtonId).remove();
        $ji(this.selectActions).parent().prepend(manageButton);
    },

    initManageButton: function () {
        var self = this;
        $ji(document).off('click', '#' + this.manageButtonId);
        $ji(document).on('click', '#' + this.manageButtonId, function () {
            self.openCloseActionsList();
        });
    },

    openCloseActionsList: function () {
        if ($ji('#' + this.manageMassactionListId).hasClass('show')) {
            $ji('#' + this.manageMassactionListId).removeClass('show');
        } else {
            $ji('#' + this.manageMassactionListId).addClass('show');
        }
    },

    generateActionsList: function() {
        var self = this;
        var actionsList = '<div id="' + this.manageMassactionListId + '"><ul>';

        $ji(this.selectActions + ' option').each(function () {
            var val = $ji(this).attr('value');
            if (val) {
                var checked = (self.options[val] == 0) ? '' : 'checked="checked"';
                actionsList += '<li><label><input type="checkbox" value="' + val + '" ' + checked + '/>' + $ji(this).text() + '</label></li>';
            }
        });

        actionsList += '</ul><div class="actions">' +
            '<button type="button" onclick="IWD.OrderManager.Massaction.openCloseActionsList()">Cancel</button>' +
            '<button type="button" onclick="IWD.OrderManager.Massaction.updateActionListState()">Update</button>' +
            '</div><div class="loader"></div><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i></div>';

        $ji(this.selectActions).parent().prepend(actionsList);

        $ji('#' + this.manageMassactionListId)
            .width($ji(this.selectActions).width())
            .find('ul').sortable({placeholder: "ui-state-highlight"});
    },

    updateActionListState: function() {
        var self = this;
        this.readActionListState();
        this.showLoader();

        $ji.ajax({
            url: this.updateUrl,
            type: "POST",
            dataType: 'json',
            data: "form_key=" + FORM_KEY + "&options=" + JSON.stringify(this.options),
            success: function (result) {
                if (result.status == 1) {
                    self.openCloseActionsList();
                    self.initMassActionsSelect();
                } else {
                    console.log(result.message);
                }
                self.hideLoader();
            },
            error: function (result) {
                console.log(result);
                self.hideLoader();
            }
        });
    },

    showLoader: function () {
        $ji('#' + this.manageMassactionListId + ' .loader, #' + this.manageMassactionListId+ ' .fa-spinner').show();
    },

    hideLoader: function () {
        $ji('#' + this.manageMassactionListId + ' .loader, #' + this.manageMassactionListId+ ' .fa-spinner').hide();
    },

    readActionListState: function() {
        var self = this;
        self.options = {};
        $ji('#' + self.manageMassactionListId + ' input').each(function(){
            self.options[$ji(this).attr('value')] = $ji(this).prop('checked') ? 1 : 0;
        });
    }
};