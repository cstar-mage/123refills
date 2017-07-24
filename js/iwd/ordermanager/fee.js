;IWD.OrderManager.AdditionalDiscount = {
    applyUrl: '',
    amountField: '#iwd_om_custom_amount', //excl tax
    amountInclTaxField: '#iwd_om_custom_amount_incl_tax',
    taxPercentField: '#iwd_om_custom_amount_percent',
    descriptionField: '#iwd_om_custom_amount_desc',

    amount: '',
    amountInclTax: '',
    taxPercent: '',
    description: '',

    removeButton: '#iwd_om_custom_amount_remove',
    applyButton: '#iwd_om_custom_amount_apply',
    minimalAmount: 0,
    createOrder: false,
    isManageTax: true,

    init: function() {
        this.initFields();
        this.initFieldsValue();
        this.initTaxCalculation();
        this.initApplyButton();
        this.initRemoveButton();
    },

    initFields: function() {
        var self = this;
        $ji(document).off('keypress change', '#order_custom_amount input');
        $ji(document).on('keypress change', '#order_custom_amount input', function () {
            if (self.needDisableApplyButton()) {
                self.disableApplyButton();
            } else {
                self.enableApplyButton();
            }
        });

        $ji(document).off('keypress', '.fee-decimal-validation');
        $ji(document).on('keypress', '.fee-decimal-validation', function (e) {
            if (e.which == 13 || e.which == 8) return 1;
            var letters = '1234567890.+-*/';
            return (letters.indexOf(String.fromCharCode(e.which)) != -1);
        });
    },

    initFieldsValue: function () {
        this.amount = parseFloat($ji(this.amountField).val());
        this.amount = isNaN(this.amount) ? 0.00 : this.amount;
        this.description = $ji(this.descriptionField).val();

        if (this.isManageTax) {
            this.amountInclTax = parseFloat($ji(this.amountInclTaxField).val());
            this.amountInclTax = isNaN(this.amountInclTax) ? 0.00 : this.amountInclTax;
            this.taxPercent = parseFloat($ji(this.taxPercentField).val());
            this.taxPercent = isNaN(this.taxPercent) ? 0.00 : this.taxPercent;
        }
    },

    initTaxCalculation: function() {
        if (!this.isManageTax) {
            return;
        }

        var self = this;

        $ji(document).off('change', this.amountField + ', ' + this.taxPercentField);
        $ji(document).on('change', this.amountField + ', ' + this.taxPercentField, function () {
            self.prepareValues(this);

            var percent = parseFloat($ji(self.taxPercentField).val());
            var amountExclTax = parseFloat($ji(self.amountField).val());
            var amountInclTax = amountExclTax + amountExclTax * (percent / 100);
            amountInclTax = amountInclTax < self.minimalAmount ? self.minimalAmount : amountInclTax;
            $ji(self.amountInclTaxField).val(parseFloat(amountInclTax).toFixed(2));
        });

        $ji(document).off('change', this.amountInclTaxField);
        $ji(document).on('change', this.amountInclTaxField, function () {
            self.prepareValues(this);

            var percent = parseFloat($ji(self.taxPercentField).val());
            var amountInclTax = parseFloat($ji(self.amountInclTaxField).val());
            var amountExclTax = amountInclTax / (1 + percent / 100);
            $ji(self.amountField).val(parseFloat(amountExclTax).toFixed(2));
        });
    },

    prepareValues: function (input) {
        var val = parseFloat(eval($ji(input).val().trim()));
        val = isNaN(val) ? 0.00 : val.toFixed(2);
        $ji(input).val(val);

        var percent = parseFloat($ji(this.taxPercentField).val());
        if (isNaN(percent)) {
            percent = 0.00;
            $ji(this.taxPercentField).val(percent);
        }
    },

    initApplyButton: function () {
        var self = this;
        $ji(document).off('click', self.applyButton);
        $ji(document).on('click', self.applyButton, function () {
            self.applyFee();
        });
    },

    initRemoveButton: function () {
        var self = this;
        $ji(document).off('click', self.removeButton);
        $ji(document).on('click', self.removeButton, function () {
            self.removeFee();
        });
    },

    needDisableApplyButton: function() {
        var amount = parseFloat($ji(this.amountField).val());
        amount = isNaN(amount) ? 0.00 : amount.toFixed(2);

        var amountInclTax = parseFloat($ji(this.amountInclTaxField).val());
        amountInclTax = isNaN(amountInclTax) ? 0.00 : amountInclTax.toFixed(2);

        var taxPercent = parseFloat($ji(this.taxPercentField).val());
        taxPercent = isNaN(taxPercent) ? 0.00 : taxPercent.toFixed(2);

        var description = $ji(this.descriptionField).val();

        return (description.length == 0 || description == this.description)
            && (amount == this.amount && amountInclTax == this.amountInclTax && taxPercent == this.taxPercent);
    },

    applyFee: function() {
        this.disableApplyButton();

        if (this.createOrder) {
            this.applyFeeToNewOrder();
        } else {
            this.applyFeeToExistingOrder()
        }
    },

    applyFeeToNewOrder: function() {
        var amount = $ji(this.amountField).val();
        var description = $ji(this.descriptionField).val();
        if (amount) {
            this.showRemoveButton();
        }

        var data = {'iwd_om_fee_amount':amount, 'iwd_om_fee_description':description};
        if (this.isManageTax) {
            data['iwd_om_fee_amount_incl_tax'] = $ji(this.amountInclTaxField).val();
            data['iwd_om_fee_tax_percent'] = $ji(this.taxPercentField).val();
        }

        order.loadArea(['totals', 'billing_method'], true, data);
    },

    applyFeeToExistingOrder: function () {
        IWD.OrderManager.ShowLoadingMask();

        var data = "form_key=" + FORM_KEY
            + "&amount=" + $ji(this.amountField).val()
            + "&description=" + $ji(this.descriptionField).val()
            + "&order_id=" + IWD.OrderManager.orderId;

        if (this.isManageTax) {
            data += "&percent=" + $ji(this.taxPercentField).val()
                + "&amount_incl_tax=" + $ji(this.amountInclTaxField).val();
        }

        $ji.ajax({
            url: this.applyUrl,
            type: "POST",
            dataType: 'json',
            data: data,
            success: function (result) {
                if (result.status == 1) {
                    location.reload();
                } else {
                    IWD.OrderManager.handleErrorResult(result);
                }
            },
            error: function (result) {
                IWD.OrderManager.handleErrorResult(result);
            }
        });
    },

    removeFee: function() {
        if (confirm('Are you sure you want to remove additional fee?')) {
            $ji(this.amountField).val('');
            $ji(this.descriptionField).val('');
            if (this.isManageTax) {
                $ji(this.amountInclTaxField).val('');
                $ji(this.taxPercentField).val('');
            }

            this.hideRemoveButton();
            this.applyFee();
        }
    },

    enableApplyButton: function() {
        $ji(this.applyButton).removeClass('disabled').removeAttr('disabled');
    },

    disableApplyButton: function() {
        $ji(this.applyButton).addClass('disabled').attr('disabled', 'disabled');
    },

    showRemoveButton: function() {
        $ji(this.removeButton).show();
    },

    hideRemoveButton: function() {
        $ji(this.removeButton).hide();
    }
};
