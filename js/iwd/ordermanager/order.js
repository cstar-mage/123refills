;IWD.OrderManager.Popup = {
    showModal: function (title, content) {
        $ji('#iwd_om_popup').modaliwd({"backdrop": "static", "show": true});
        $ji('#iwd_om_popup .om-iwd-modal-title').html(title);
        $ji('#iwd_om_popup .om-iwd-modal-body').html(content);

        setTimeout(function () {$ji(window).trigger('resize');}, 500);
    },

    hideModal: function () {
        $ji('#iwd_om_popup').modaliwd('hide');
    }
};

IWD.OrderManager.NotifyPopup = {
    currentPopup: null,
    popupValues: {},
    popupTitles: {},
    content: '',

    showModal: function (block) {
        this.currentPopup = block;
        IWD.OrderManager.Popup.showModal(this.popupTitles[this.currentPopup], this.content);

        var form = $ji('#control_form_' + this.currentPopup).html();
        if (form.length) {
            $ji('#iwd_om_popup_form').html("<form>" + form + "</form>");
        }

        if (typeof(this.popupValues[this.currentPopup]) != "undefined") {
            $ji.each(this.popupValues[this.currentPopup], function () {
                $ji('#iwd_om_popup_form [name="' + this.name + '"]').val(this.value);
            });
        } else {
            $ji.each($ji('#iwd_om_popup_form form').find('input, textarea'), function () {
                $ji(this).val($ji(this).attr("value"));
            });
        }
    },

    cancelModal: function () {
        IWD.OrderManager.Popup.hideModal();
    },

    updateModal: function () {
        if (!this.validatePopupForm()) {
            return;
        }

        var blockId = '#control_form_' + this.currentPopup;

        var form = $ji('#iwd_om_popup_form').html();
        $ji(blockId).html(form);

        this.popupValues[this.currentPopup] = $ji('#iwd_om_popup_form form').serializeArray();
        $ji.each(this.popupValues[this.currentPopup], function () {
            $ji(blockId + ' [name="' + this.name + '"]').val(this.value);
        });

        IWD.OrderManager.Popup.hideModal();
    },

    validatePopupForm: function () {
        var self = this;
        var result = true;
        $ji.each($ji('#iwd_om_popup_form input, #iwd_om_popup_form textarea'), function () {
            $ji(this).removeClass('validation-failed');

            if ($ji(this).attr('required') == 'required' && $ji(this).val() == "") {
                $ji(this).addClass('validation-failed');
                result = false;
                return true;
            }

            if ($ji(this).attr('name') == "comment_email") {
                if (self.isEmail($ji(this).val()) == false) {
                    $ji(this).addClass('validation-failed');
                    result = false;
                    return true;
                }
            }
        });
        return result;
    },

    isEmail: function (email) {
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        var result = true;

        email.split(',').each(function (mail) {
            mail = mail.trim();
            if (mail.length > 0) {
                result = regex.test(mail) == false ? false : result;
            }
        });

        return result;
    }
};

IWD.OrderManager.OrderedItems = {
    urlEditOrderedItemsForm: '',
    urlEditOrderedItems: '',
    urlAddOrderedItemsForm: '',
    urlAddOrderedItems: '',
    discountTax: 0,
    applyTaxAfterDiscount: 0,
    order: null,
    orderedItems: null,
    configureItems: {},
    newItemOptions: {},

    initProductConfigure: function () {
    },

    init: function () {
        var self = this;
        $ji("#ordered_items_edit").on("click", function (event) {
            self.editOrderedItemsForm(event);
        });
    },

    /**** edit ordered items ****/
    editOrderedItemsForm: function (event) {
        event.preventDefault();

        IWD.OrderManager.ShowLoadingMask();

        $ji.ajax({
            url: this.urlEditOrderedItemsForm,
            type: "POST",
            dataType: 'json',
            data: "form_key=" + FORM_KEY + "&order_id=" + IWD.OrderManager.orderId,
            success: function (result) {
                if (result.ajaxExpired) {
                    location.reload();
                }
                else if (result.status) {
                    $ji('#ordered_items_table').hide();
                    $ji('#ordered_items_edit_form').remove();
                    $ji('#add_ordered_items_form').remove();
                    $ji("#ordered_items_box").append(result.form.toString());
                }

                IWD.OrderManager.HideLoadingMask();
            },
            error: function () {
                IWD.OrderManager.HideLoadingMask();
            }
        });
    },

    editOrderedItemsSubmit: function () {
        var orderedItemsFormValidation = new varienForm('ordered_items_form');
        if (!orderedItemsFormValidation.validator.validate()) {
            return;
        }

        /* if all items checked */
        if ($ji('.ordered_item_remove').size() == $ji('.ordered_item_remove input:checkbox:checked').size()) {
            alert("Sorry, but you can not delete all items in order. Maybe, better remove this order?");
            return;
        }

        IWD.OrderManager.ShowLoadingMask();

        var formData = $ji('#ordered_items_form').serialize();
        $ji.ajax({
            url: this.urlEditOrderedItems,
            type: "POST",
            dataType: 'json',
            data: "form_key=" + FORM_KEY + "&" + formData,
            success: function (result) {
                if (result.ajaxExpired) {
                    location.reload();
                }
                if (result.form) {
                    IWD.OrderManager.Stock.Order.displayAssignStockForm(result.form);
                    IWD.OrderManager.HideLoadingMask();
                } else {
                    location.reload();
                }
            },
            error: function () {
                IWD.OrderManager.handleErrorResult(result);
            }
        });
    },

    editOrderedItemsCancel: function () {
        $ji('#ordered_items_table').show();
        $ji('#ordered_items_edit_form').remove();
        $ji('#add_ordered_items_form').remove();
    },

    /**** add new items ****/
    addOrderedItemsForm: function () {
        var self = this;
        IWD.OrderManager.ShowLoadingMask();

        $ji('#button_add_selected_items').show();
        $ji('#button_search_items_form').hide();

        this.order.gridProducts = $H({});

        if ($ji("#add_ordered_items_form").length > 0) {
            $ji("#add_ordered_items_form").show();
            IWD.OrderManager.HideLoadingMask();
            return;
        }

        $ji.ajax({
            url: this.urlAddOrderedItemsForm,
            type: "POST",
            dataType: 'json',
            data: "form_key=" + FORM_KEY + "&order_id=" + IWD.OrderManager.orderId,
            success: function (result) {
                if (result.ajaxExpired) {
                    location.reload();
                }
                else if (result.status == 1) {
                    $ji("#add_ordered_items_form").remove();

                    $ji.getScript(result.url_configure_js, function () {
                        $ji('form#product_composite_configure_form').remove();
                        $ji('#popup-window-mask').remove();
                        $ji('#product_composite_configure').remove();

                        $ji("#anchor-content").append(result.configure_form.toString());
                        self.initProductConfigure();

                        $ji("#ordered_items_box").append('<div id="add_ordered_items_form">' + result.form.toString() + '</div>');

                        $ji('form#product_composite_configure_form button[type="submit"]').on('click', function () {
                            var formData = $ji('form#product_composite_configure_form').serializeArray();
                            var productId = productConfigure.current.itemId;
                            self.configureItems[productId] = formData;
                        });

                        IWD.OrderManager.HideLoadingMask();
                    });
                }
            },
            error: function () {
                IWD.OrderManager.HideLoadingMask();
            }
        });
    },

    addOrderedItems: function () {
        var self = this;
        IWD.OrderManager.ShowLoadingMask();

        var selected_items = self.order.gridProducts.toObject();

        if (Object.keys(selected_items).length <= 0) {
            $ji("#add_ordered_items_form").hide();
            $ji('#button_add_selected_items').hide();
            $ji('#button_search_items_form').show();
            IWD.OrderManager.HideLoadingMask();
            return;
        }
        $ji.ajax({
            url: self.urlAddOrderedItems,
            type: "POST",
            dataType: 'json',
            data: "form_key=" + FORM_KEY +
            "&order_id=" + IWD.OrderManager.orderId +
            "&items=" + JSON.stringify(selected_items, null, 2) +
            "&options=" + JSON.stringify(self.configureItems, null, 2),
            success: function (result) {
                if (result.ajaxExpired) {
                    location.reload();
                }
                if (result.status == 1) {
                    $ji("#add_ordered_items_form").hide();
                    $ji('#button_add_selected_items').hide();
                    $ji('#button_search_items_form').show();

                    self.order.gridProducts = $H({});
                    self.enabledSubmitButton();
                    $ji("#ordered_items_edit_table").append(result.form);
                }
                else if (result.status == 0) {
                    alert(result.error_message);
                }

                IWD.OrderManager.HideLoadingMask();
            },
            error: function () {
                IWD.OrderManager.HideLoadingMask();
            }
        });
    },

    editOrderedItemsOptions: function (item_id) {
        IWD.OrderManager.ShowLoadingMask();

        var form = new FormData($('iwd_om_product_composite_configure_form'));
        var url = this.urlEditOrderedItemsOptions + "&form_key=" + FORM_KEY
            + "&order_id=" + IWD.OrderManager.orderId + "&item_id=" + item_id;

        $ji.ajax({
            url: url,
            type: "POST",
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            data: form,
            success: function (result) {
                if (result.ajaxExpired) {
                    location.reload();
                }
                if (result.status == 1) {
                    $ji('.item_name_' + item_id).html(result['name']);
                    $ji('.item_sku_' + item_id).html(result['sku']);
                    $ji('.item_options_' + item_id).html(result['options_html']);
                    $ji('input[name="items[' + item_id + '][price]"]').val(result['price']).change();
                    $ji('input[name="items[' + item_id + '][product_options]"]').val(result['product_options']);
                }
                else if (result.status == 0) {
                    alert(result.error_message);
                }

                IWD.OrderManager.HideLoadingMask();
            },
            error: function () {
                IWD.OrderManager.HideLoadingMask();
            }
        });
    },

    /**** enabled submit button after edit ****/
    enabledSubmitButton: function () {
        $ji('#edit_ordered_items_submit').removeAttr('disabled').removeClass('disabled');
    },

    showItemConfiguration: function (id) {
        var listType = 'iwd_quote_items';
        var qtyElement = $('ordered_items_edit_table').select('input[name="items\[' + id + '\]\[fact_qty\]"]')[0];

        productConfigureIWDOMEdit.setConfirmCallback(listType, function () {
            var confirmedCurrentQty = productConfigureIWDOMEdit.getCurrentFormQtyElement();
            if (qtyElement && confirmedCurrentQty && !isNaN(confirmedCurrentQty.value)) {
                qtyElement.value = confirmedCurrentQty.value;
            }
            fireEvent(qtyElement, 'change');
        }.bind(this));

        productConfigureIWDOMEdit.setShowWindowCallback(listType, function () {
            var formCurrentQty = productConfigureIWDOMEdit.getCurrentFormQtyElement();
            if (formCurrentQty && qtyElement && !isNaN(qtyElement.value)) {
                formCurrentQty.value = qtyElement.value;
            }
        }.bind(this));

        productConfigureIWDOMEdit.showItemConfiguration(listType, id);
    }
};

IWD.OrderManager.OrderedItemsName = {
    itemNameClass: "#ordered_items_edit_form .item_name",

    itemOptionLabelClass: "#ordered_items_edit_form .item-options dt.option",
    itemOptionValueClass: "#ordered_items_edit_form .item-options dd.option",

    itemAttributeLabelClass: "#ordered_items_edit_form .item-options dt.attribute",
    itemAttributeValueClass: "#ordered_items_edit_form .item-options dd.attribute",

    itemBundleOptionLabelClass: "#ordered_items_edit_form .option-label",

    closeClass: "#ordered_items_edit_form .fa-times",

    init: function () {
        var self = this;

        $ji(document).on('click', this.itemNameClass, function () {
            $ji(this).after(self.addInputForEdit(this, 'product_name', 'edit-product-name'));
            $ji(this).hide();
        });

        $ji(document).on('click', this.itemOptionLabelClass, function () {
            $ji(this).after(self.addInputForEdit(this, 'option_label][' + $ji(this).data('id'), 'edit-option-label'));
            $ji(this).hide();
        });
        $ji(document).on('click', this.itemOptionValueClass, function () {
            $ji(this).after(self.addInputForEdit(this, 'option_value][' + $ji(this).data('id'), 'edit-option-value'));
            $ji(this).hide();
        });

        $ji(document).on('click', this.itemAttributeLabelClass, function () {
            $ji(this).after(self.addInputForEdit(this, 'attribute_label][' + $ji(this).data('id'), 'edit-option-label'));
            $ji(this).hide();
        });
        $ji(document).on('click', this.itemAttributeValueClass, function () {
            $ji(this).after(self.addInputForEdit(this, 'attribute_value][' + $ji(this).data('id'), 'edit-option-value'));
            $ji(this).hide();
        });

        $ji(document).on('click', this.itemBundleOptionLabelClass, function () {
            $ji(this).after(self.addInputForEdit(this, 'bundle_option_label', 'bundle-option-label'));
            $ji(this).hide();
        });

        $ji(document).on('click', this.closeClass, function () {
            $ji(this).closest('div').prev().show();
            $ji(this).closest('div').remove();
        });
    },

    getItemId: function (item) {
        return $ji(item).closest('tr').data('item-id');
    },

    addInputForEdit: function (item, name, className) {
        return '<div class="' + className + '"><label><input class="edit_order_item required-entry close-button" type="input" name="items[' + this.getItemId(item) + '][' + name + ']" value="' + $ji(item).text().trim() + '" />' +
            '</label><i class="fa fa-times" aria-hidden="true" title="CANCEL"></i></div>';
    }
};

IWD.OrderManager.Address = {
    urlEditAddressForm: '',
    urlEditAddressSubmit: '',

    init: function () {
        var self = this;
        $ji(".order_address_edit").on("click", function (event) {
            event.preventDefault();
            var address_id = this.id.split('_').last();
            self.editAddressForm(address_id);
        });
    },

    editAddressForm: function (address_id) {
        IWD.OrderManager.ShowLoadingMask();

        $ji.ajax({
            url: this.urlEditAddressForm,
            type: "POST",
            dataType: 'json',
            data: "form_key=" + FORM_KEY + "&address_id=" + address_id,
            success: function (result) {
                if (result.ajaxExpired) {
                    location.reload();
                }
                else if (result.status) {
                    var order_address_block = $ji("#order_address_" + address_id);
                    order_address_block.hide();
                    $ji('#address_edit_form_' + address_id).remove();

                    var html = result.form.toString();
                    var VRegExp = new RegExp(/"region_id"/g);
                    html = html.replace(VRegExp, '"region_id_' + address_id + '"');
                    VRegExp = new RegExp(/"region"/g);
                    html = html.replace(VRegExp, '"region_' + address_id + '"');
                    VRegExp = new RegExp(/"country_id"/g);
                    html = html.replace(VRegExp, '"country_id_' + address_id + '"');
                    VRegExp = new RegExp(/"vat_id"/g);
                    html = html.replace(VRegExp, '"vat_id_' + address_id + '"');

                    order_address_block.parent().append(html);
                }

                IWD.OrderManager.HideLoadingMask();
            },
            error: function () {
                IWD.OrderManager.HideLoadingMask();
            }
        });
    },

    editAddressSubmit: function (address_id) {
        var addressFormValidation = eval('addressFormValidation_' + address_id);
        if (!addressFormValidation.validator.validate()) {
            return;
        }

        IWD.OrderManager.ShowLoadingMask();

        var form = $ji('#address_edit_form_' + address_id);
        var formData = form.serialize();

        $ji.ajax({
            url: this.urlEditAddressSubmit,
            type: "POST",
            dataType: 'json',
            data: "form_key=" + FORM_KEY + "&" + formData,
            success: function (result) {
                if (result.ajaxExpired || result.status != 1 || result.address == false) {
                    location.reload();
                } else {
                    form.remove();
                    $ji("#order_address_" + address_id).html(result.address).show();
                    IWD.OrderManager.HideLoadingMask();
                }
            },
            error: function (result) {
                IWD.OrderManager.HideLoadingMask();
            }
        });
    },

    editAddressCancel: function (address_id) {
        $ji('#address_edit_form_' + address_id).remove();
        $ji("#order_address_" + address_id).show();
    }
};

IWD.OrderManager.AccountInfo = {
    urlEditAccountForm: '',
    urlEditAccountSubmit: '',

    init: function () {
        var self = this;
        $ji(".account_information_edit").click(function (event) {
            event.preventDefault();
            self.editCustomerInfoForm();
        });
    },

    editCustomerInfoForm: function () {
        IWD.OrderManager.ShowLoadingMask();

        $ji.ajax({
            url: this.urlEditAccountForm,
            type: "POST",
            dataType: 'json',
            data: "form_key=" + FORM_KEY + "&order_id=" + IWD.OrderManager.orderId,
            success: function (result) {
                if (result.ajaxExpired) {
                    location.reload();
                }
                else if (result.status) {
                    $ji("#account_information_" + IWD.OrderManager.orderId).hide();
                    $ji('#account_information_form_' + IWD.OrderManager.orderId).remove();
                    $ji("#account_information_" + IWD.OrderManager.orderId).parent().append(result.form.toString());
                }

                IWD.OrderManager.HideLoadingMask();
            },
            error: function () {
                IWD.OrderManager.HideLoadingMask();
            }
        });
    },

    editCustomerInfoSubmit: function () {
        var accountInfoFormValidation = new varienForm('account_information_form_' + IWD.OrderManager.orderId);
        if (!accountInfoFormValidation.validator.validate()) {
            return;
        }

        IWD.OrderManager.ShowLoadingMask();

        var form = $ji('#account_information_form_' + IWD.OrderManager.orderId);
        var formData = form.serialize();

        $ji.ajax({
            url: this.urlEditAccountSubmit,
            type: "POST",
            dataType: 'json',
            data: "form_key=" + FORM_KEY + "&" + formData,
            success: function (result) {
                if (result.ajaxExpired) {
                    location.reload();
                }
                IWD.OrderManager.handleSuccessResult(result, form);
            },
            error: function () {
                IWD.OrderManager.HideLoadingMask();
            }
        });
    },

    editCustomerInfoCancel: function () {
        $ji('#account_information_form_' + IWD.OrderManager.orderId).remove();
        $ji("#account_information_" + IWD.OrderManager.orderId).show();
    }
};

IWD.OrderManager.OrderInfo = {
    urlEditOrderInfoForm: '',
    urlEditOrderInfoSubmit: '',

    init: function () {
        var self = this;
        $ji(".order_information_edit").on("click", function (event) {
            event.preventDefault();
            self.editOrderInformationForm();
        });
    },

    getParams: function () {
        var params = "&order_id=" + IWD.OrderManager.orderId;

        var invoice_id = $ji(".order_information_edit").attr('data-invoice-id');
        if (typeof(invoice_id) != 'undefined') {
            params += "&invoice_id=" + invoice_id;
        }

        var shipping_id = $ji(".order_information_edit").attr('data-shipping-id');
        if (typeof(shipping_id) != 'undefined') {
            params += "&shipping_id=" + shipping_id;
        }

        var creditmemo_id = $ji(".order_information_edit").attr('data-creditmemo-id');
        if (typeof(creditmemo_id) != 'undefined') {
            params += "&creditmemo_id=" + creditmemo_id;
        }

        return params;
    },

    editOrderInformationForm: function () {
        IWD.OrderManager.ShowLoadingMask();

        $ji.ajax({
            url: this.urlEditOrderInfoForm,
            type: "POST",
            dataType: 'json',
            data: "form_key=" + FORM_KEY + this.getParams(),
            success: function (result) {
                if (result.ajaxExpired) {
                    location.reload();
                }
                else if (result.status) {
                    $ji("#order_information").hide();
                    $ji('#order_information_form').remove();
                    $ji("#order_information").parent().append(result.form.toString());
                    $ji(".jquery-ui-datepicker").datetimepicker(
                        {
                            lang: IWD.OrderManager.lang,
                            format: IWD.OrderManager.date_format
                        }
                    );
                }

                IWD.OrderManager.HideLoadingMask();
            },
            error: function () {
                IWD.OrderManager.HideLoadingMask();
            }
        });
    },

    editOrderInformationSubmit: function () {
        var orderInfoFormValidation = new varienForm('order_information_form');
        if (!orderInfoFormValidation.validator.validate()) {
            return;
        }

        IWD.OrderManager.ShowLoadingMask();

        var form = $ji('#order_information_form');
        var formData = form.serialize();

        $ji.ajax({
            url: this.urlEditOrderInfoSubmit,
            type: "POST",
            dataType: 'json',
            data: "form_key=" + FORM_KEY + "&" + formData,
            success: function (result) {
                if (result.ajaxExpired) {
                    location.reload();
                }
                IWD.OrderManager.handleSuccessResult(result, form);
            },
            error: function () {
                IWD.OrderManager.HideLoadingMask();
            }
        });
    },

    editOrderInformationCancel: function () {
        $ji('#order_information_form').remove();
        $ji("#order_information").show();
    }
};

IWD.OrderManager.Comments = {
    urlEditCommentForm: '',
    urlEditCommentSubmit: '',
    urlDeleteCommentSubmit: '',
    type: 'order',
    confirmText: "Are you sure?",

    init: function (type) {
        var self = this;
        self.type = type;

        $ji(".delete_history_icon").on('click', function () {
            self.deleteComment(this);
        });

        $ji(".update_history_icon").on('click', function () {
            self.editCommentForm(this);
        });
    },

    deleteComment: function (item) {
        if (confirm(this.confirmText)) {
            IWD.OrderManager.ShowLoadingMask();

            var comment_id = item.id.split('_').last();

            $ji.ajax({
                url: this.urlDeleteCommentSubmit,
                type: "POST",
                dataType: 'json',
                data: "form_key=" + FORM_KEY +
                "&type=" + this.type +
                "&comment_id=" + comment_id,
                success: function (result) {
                    if (result.ajaxExpired) {
                        location.reload();
                    }
                    else if (result.status) {
                        $ji(item).hide();
                        $ji(item).parent().delay(500).hide(1000);
                    }
                    IWD.OrderManager.HideLoadingMask();
                },
                error: function () {
                    IWD.OrderManager.HideLoadingMask();
                }
            });
        }
    },

    editCommentForm: function (item) {
        IWD.OrderManager.ShowLoadingMask();

        var comment_id = item.id.split('_').last();

        $ji.ajax({
            url: this.urlEditCommentForm,
            type: "POST",
            dataType: 'json',
            data: "form_key=" + FORM_KEY +
            "&type=" + this.type +
            "&comment_id=" + comment_id,
            success: function (result) {
                if (result.ajaxExpired) {
                    location.reload();
                }
                $ji("#comment_text_" + comment_id).hide();
                $ji("#updated_comment_form_" + comment_id).remove();
                $ji("#comment_text_" + comment_id).after(result.comment);
                $ji("#comment_text_" + comment_id).closest('li').find('.admin-name').hide();
                IWD.OrderManager.HideLoadingMask();
            },
            error: function () {
                IWD.OrderManager.HideLoadingMask();
            }
        });
    },

    editCommentSubmit: function (comment_id) {
        IWD.OrderManager.ShowLoadingMask();

        var comment_text = $ji("textarea#updated_comment_text_" + comment_id).val();

        $ji.ajax({
            url: this.urlEditCommentSubmit,
            type: "POST",
            dataType: 'json',
            data: "form_key=" + FORM_KEY +
            "&comment_id=" + comment_id +
            "&type=" + this.type +
            "&comment_text=" + comment_text,
            success: function (result) {
                if (result.ajaxExpired) {
                    location.reload();
                }
                else {
                    var comment = (result.comment != null) ? result.comment : '';
                    $ji("#updated_comment_form_" + comment_id).remove();
                    $ji("#comment_text_" + comment_id).html(comment).show();
                    $ji("#comment_text_" + comment_id).closest('li').find('.admin-name').show();
                    IWD.OrderManager.HideLoadingMask();
                }
            },
            error: function () {
                IWD.OrderManager.HideLoadingMask();
            }
        });
    },

    editCommentCancel: function (comment_id) {
        $ji("#updated_comment_form_" + comment_id).remove();
        $ji("#comment_text_" + comment_id).show();
        $ji("#comment_text_" + comment_id).closest('li').find('.admin-name').show();
    }
};

IWD.OrderManager.Shipping = {
    urlEditShippingForm: '',
    urlEditShippingSubmit: '',

    init: function () {
        var self = this;
        $ji(".order_shipping_edit").on("click", function (event) {
            event.preventDefault();
            self.editShippingForm();
        });

        self.radioInit();
        self.interactiveForm();
    },

    radioInit: function () {
        var self = this;
        $ji(document).on("change", "#order-shipping-method-choose input[type=radio]", function () {
            self.showEditTable();
        });

        $ji(document).on('keypress', "#order-shipping-method-choose input.validate-number", function (e) {
            if (e.which == 13) return 1;
            var letters = '1234567890.';
            return (letters.indexOf(String.fromCharCode(e.which)) != -1);
        });
    },

    showEditTable: function () {
        $ji("#order-shipping-method-choose input[type=text]").attr('disabled', 'disabled').removeClass('required-entry');

        $ji("#order-shipping-method-choose input[name=shipping_method_radio]").each(function () {
            var code = $ji(this).attr('id');
            if ($ji("#" + code).prop('checked')) {
                $ji("#" + code + "_edit_table").show();
                $ji('#order-shipping-method-choose input[name="s_amount_excl_tax[' + $ji("#" + code).val() + ']"]').removeAttr('disabled').addClass('required-entry');
                $ji('#order-shipping-method-choose input[name="s_amount_incl_tax[' + $ji("#" + code).val() + ']"]').removeAttr('disabled').addClass('required-entry');
                $ji('#order-shipping-method-choose input[name="s_tax_percent[' + $ji("#" + code).val() + ']"]').removeAttr('disabled').addClass('required-entry');
                $ji('#order-shipping-method-choose input[name="s_description[' + $ji("#" + code).val() + ']"]').removeAttr('disabled').addClass('required-entry');
            }
            else {
                $ji("#" + code + "_edit_table").hide();
            }
        });
    },

    getInputId: function (item) {
        var reg = /items\[(\w+)\]\[(\w+)\]/i;
        var attr_name = reg.exec($ji(item).attr('name'));
        return attr_name[1];
    },

    interactiveForm: function () {
        $ji(document).on('change', "#order-shipping-method-choose input.input-text", function () {
            var code = $ji(this).attr('data-method');

            var amount_excl_tax = $ji('#order-shipping-method-choose input[name="s_amount_excl_tax[' + code + ']"]');
            var amount_incl_tax = $ji('#order-shipping-method-choose input[name="s_amount_incl_tax[' + code + ']"]');
            var tax_percent = $ji('#order-shipping-method-choose input[name="s_tax_percent[' + code + ']"]');

            if ($ji(this).hasClass('amount_excl_tax') || $ji(this).hasClass('tax_percent')) {
                var incl_tax = parseFloat(amount_excl_tax.val()) + (parseFloat(amount_excl_tax.val()) * parseFloat(tax_percent.val()) / 100);
                amount_incl_tax.val(incl_tax.toFixed(2));
            } else if ($ji(this).hasClass('amount_incl_tax')) {
                var excl_tax = parseFloat(amount_incl_tax.val()) / (1 + parseFloat(tax_percent.val()) / 100);
                amount_excl_tax.val(excl_tax.toFixed(2));
            }
        });
    },

    editShippingForm: function () {
        IWD.OrderManager.ShowLoadingMask();

        $ji.ajax({
            url: this.urlEditShippingForm,
            type: "POST",
            dataType: 'json',
            data: "form_key=" + FORM_KEY + "&order_id=" + IWD.OrderManager.orderId,
            success: function (result) {
                if (result.ajaxExpired) {
                    location.reload();
                }
                else if (result.status) {
                    $ji('#iwd_shipping_edit_form').remove();
                    $ji("#order_shipping").hide();
                    $ji("#order_shipping").parent().append(result.form.toString());
                }

                IWD.OrderManager.HideLoadingMask();
            },
            error: function () {
                IWD.OrderManager.HideLoadingMask();
            }
        });
    },

    editShippingSubmit: function () {
        var shippingFormValidation = new varienForm('iwd_shipping_edit_form');
        if (!shippingFormValidation.validator.validate())
            return;

        IWD.OrderManager.ShowLoadingMask();

        var form = $ji('#iwd_shipping_edit_form');
        var formData = form.serialize();

        $ji.ajax({
            url: this.urlEditShippingSubmit,
            type: "POST",
            dataType: 'json',
            data: "form_key=" + FORM_KEY + "&order_id=" + IWD.OrderManager.orderId + "&" + formData,
            success: function (result) {
                if (result.ajaxExpired) {
                    location.reload();
                }
                IWD.OrderManager.handleSuccessResult(result, form);
            },
            error: function (result) {
                IWD.OrderManager.handleErrorResult(result);
            }
        });
    },

    editShippingCancel: function () {
        $ji('#iwd_shipping_edit_form').remove();
        $ji("#order_shipping").show();
    }
};

IWD.OrderManager.Payment = {
    urlEditPaymentForm: '',
    urlEditPaymentSubmit: '',

    init: function () {
        var self = this;
        $ji(".order_payment_edit").on("click", function (event) {
            event.preventDefault();
            self.editPaymentForm();
        });

        self.radioInit();
    },

    radioInit: function () {
        $ji(document).on("change", "#iwd_payment_edit_form [name='payment[method]']", function () {
            $ji("#iwd_edit_payment_form_submit").removeAttr("disabled").removeClass("disabled");
        });
    },

    editPaymentForm: function () {
        IWD.OrderManager.ShowLoadingMask();

        $ji.ajax({
            url: this.urlEditPaymentForm,
            type: "POST",
            dataType: 'json',
            data: "form_key=" + FORM_KEY + "&order_id=" + IWD.OrderManager.orderId,
            success: function (result) {
                if (result.ajaxExpired) {
                    location.reload();
                }
                else if (result.status) {
                    $ji('#iwd_payment_edit_form').remove();
                    $ji("#order_payment").hide();
                    $ji("#order_payment").parent().append(result.form.toString());

                    if ($ji('#order-billing_method_form dd').length == 1) {
                        $ji("#iwd_edit_payment_form_submit").removeAttr("disabled").removeClass("disabled");
                    }

                    $ji('#iwd_payment_edit_form input[type=text]').val("");
                }

                IWD.OrderManager.HideLoadingMask();
            },
            error: function () {
                IWD.OrderManager.HideLoadingMask();
            }
        });
    },

    editPaymentSubmit: function () {
        var paymentFormValidation = new varienForm('iwd_payment_edit_form');
        if (!paymentFormValidation.validator.validate()) {
            return;
        }

        IWD.OrderManager.ShowLoadingMask();

        var formData = $ji('#iwd_payment_edit_form').serialize();

        $ji.ajax({
            url: this.urlEditPaymentSubmit,
            type: "POST",
            dataType: 'json',
            data: "form_key=" + FORM_KEY + "&order_id=" + IWD.OrderManager.orderId + "&" + formData,
            success: function (result) {
                if (result.ajaxExpired) {
                    location.reload();
                }
                IWD.OrderManager.handleSuccessResult(result);
            },
            error: function (result) {
                IWD.OrderManager.handleErrorResult(result);
            }
        });
    },

    editPaymentCancel: function () {
        $ji('#iwd_payment_edit_form').remove();
        $ji("#order_payment").show();
    }
};

/**** interactive edit grid ****/
IWD.OrderManager.TaxCalculation = {
    taxCalculationMethodBasedOn: 0, /* algorithm */
    taxCalculationBasedOn: 0,
    catalogPrices: 0, /* 1-include; 0-exclude tax */
    shippingPrices: 0,
    applyTaxAfterDiscount: 0, /* applyCustomerTax */
    discountTax: 0, /* applyDiscountOnPrices */
    validateStockQty: 1,

    CALC_TAX_BEFORE_DISCOUNT_ON_EXCL: '0_0',
    CALC_TAX_BEFORE_DISCOUNT_ON_INCL: '0_1',
    CALC_TAX_AFTER_DISCOUNT_ON_EXCL: '1_0',
    CALC_TAX_AFTER_DISCOUNT_ON_INCL: '1_1',

    init: function () {
        var self = this;
        $ji(document).on('keypress', "input.validate-number", function (e) {
            if (e.which == 13 || e.which == 8) return 1;
            var letters = '1234567890.';
            return (letters.indexOf(String.fromCharCode(e.which)) != -1);
        });

        $ji(document).on('change', "input.edit_order_item", function () {
            self.updateOrderItemInput(this);
            self.enabledSubmitButton();
        });

        $ji(document).on('change', "input[type=checkbox].remove_ordered_item", function () {
            self.removeItemRow(this);
            self.enabledSubmitButton();
        });
    },

    removeItemRow: function (item) {
        var parent_id = $ji(item).attr('data-parent-id') || null;
        var id = $ji(item).attr('data-item-id') || null;

        var result = $ji(item).prop("checked")
            ? this.disabledRow(id, parent_id)
            : this.enabledRow(id, parent_id);

        if (parent_id && result) {
            var bundle_items = this.getBundleItems(parent_id);
            if (!this.isRemoveAllBundleItems(bundle_items, parent_id)) {
                this.calculateBundleTotals(bundle_items, parent_id);
            }
        }
    },

    disabledRow: function (rowId, parent_id) {
        var rowItem = $ji('#ordered_items_edit_table tr[data-item-id="' + rowId + '"]');
        rowItem.addClass('removed_item');
        rowItem.find('input[type=text], button').attr('disabled', 'disabled');
        rowItem.find('button').addClass('disabled');

        /* for bundle product */
        $ji('input.remove_ordered_item.has_parent_' + rowId).prop("checked", true).click(this.deactivator);
        $ji('tr.has_parent_' + rowId).addClass('removed_item');
        $ji('tr.has_parent_' + rowId + ' input[type=text]').attr('disabled', 'disabled');

        return true;
    },

    enabledRow: function (rowId, parent_id) {
        if (parent_id && $ji('#remove_' + parent_id).prop("checked")) {
            return false;
        }

        var rowItem = $ji('#ordered_items_edit_table tr[data-item-id="' + rowId + '"]');
        rowItem.removeClass('removed_item');
        rowItem.find('input[type=text], button').removeAttr('disabled');
        rowItem.find('button').removeClass('disabled');

        /* for bundle product */
        $ji('input.remove_ordered_item.has_parent_' + rowId).prop("checked", false).unbind('click', this.deactivator);
        $ji('tr.has_parent_' + rowId).removeClass('removed_item');
        $ji('tr.has_parent_' + rowId + ' input[type=text]').removeAttr('disabled');

        return true;
    },

    calculateBundleTotals: function (bundle_items, bundle_id) {
        /* !canShowPriceInfo */
        if (!bundle_items[Object.keys(bundle_items)[0]].price.val()) {
            return false;
        }

        var self = this;
        var total_price_tax_incl = 0;
        var total_price_tax_excl = 0;
        var total_subtotal_tax_incl = 0;
        var total_subtotal_tax_excl = 0;
        var total_tax_amount = 0;
        var bundle = this.getInputs(bundle_id);

        var bundle_qty = parseFloat(bundle.fact_qty.val());
        $ji.each(bundle_items, function (i, input) {
            /* item was removed */
            if (input.remove.prop("checked")) {
                return true;
            }
            var qty = parseFloat(input.fact_qty.val()) / bundle_qty;
            total_price_tax_incl += parseFloat(input.price_incl_tax.val()) * qty;
            total_price_tax_excl += parseFloat(input.price.val()) * qty;
            total_subtotal_tax_incl += parseFloat(input.subtotal_incl_tax.val());
            total_subtotal_tax_excl += parseFloat(input.subtotal.val());
            total_tax_amount += parseFloat(input.tax_amount.val());

            self.updateQtyInBundle(input, bundle);
        });

        bundle.price_incl_tax.val(total_price_tax_incl.toFixed(2));
        bundle.price.val(total_price_tax_excl.toFixed(2));
        bundle.subtotal_incl_tax.val(total_subtotal_tax_incl.toFixed(2));
        bundle.subtotal.val(total_subtotal_tax_excl.toFixed(2));
        bundle.tax_amount.val(total_tax_amount.toFixed(2));

        return true;
    },

    isRemoveAllBundleItems: function (bundle_items, bundle_id) {
        var count_removed_items = 0;
        $ji.each(bundle_items, function (i, input) {
            if (input.remove.prop("checked")) count_removed_items++;
        });

        /* checked all bundle items */
        if (count_removed_items == Object.keys(bundle_items).length) {
            $ji('input.remove_ordered_item.has_parent_' + bundle_id).prop("checked", false);
            this.calculateBundleTotals(bundle_items, bundle_id);
            $ji('input[name="items[' + bundle_id + '][remove]"').prop("checked", true);
            this.disabledRow(bundle_id, null);
            return true;
        }

        return false;
    },

    updateBundleItems: function (name, id) {
        var self = this;
        var bundle_items = this.getBundleItems(id);
        if (Object.keys(bundle_items).length == 0) {
            return;
        }

        switch (name) {
            case "qty":
                var bundle = this.getInputs(id);
                var bundle_qty = parseFloat(bundle.fact_qty.val());
                $ji.each(bundle_items, function (i, input) {
                    var qty_item_in_bundle = parseFloat(input.qty_item_in_bundle.val());
                    input.fact_qty.val(bundle_qty * qty_item_in_bundle).change();
                    self.updateQtyInBundle(input, bundle);
                });
                break;

            case "fact_qty":
                var bundle = this.getInputs(id);
                var bundle_qty = parseFloat(bundle.fact_qty.val());
                $ji.each(bundle_items, function (i, input) {
                    var qty_item_in_bundle = parseFloat(input.qty_item_in_bundle.val());
                    input.fact_qty.val(bundle_qty * qty_item_in_bundle).change();
                    self.updateQtyInBundleFact(input, bundle);
                });
                break;
        }
    },

    /** helpers methods **/
    deactivator: function (event) {
        event.preventDefault();
    },
    getInputId: function (item) {
        var reg = /items\[(\w+)\]\[(\w+)\]/i;
        var attr_name = reg.exec($ji(item).attr('name'));
        return attr_name[1];
    },
    getInputName: function (item) {
        var reg = /items\[(\w+)\]\[(\w+)\]/i;
        var attr_name = reg.exec($ji(item).attr('name'));
        return attr_name[2];
    },
    getInputs: function (id) {
        return {
            original_price: $ji("input[name='items[" + id + "][original_price]']"),
            price: $ji("input[name='items[" + id + "][price]']"),
            price_incl_tax: $ji("input[name='items[" + id + "][price_incl_tax]']"),
            subtotal: $ji("input[name='items[" + id + "][subtotal]']"),
            subtotal_incl_tax: $ji("input[name='items[" + id + "][subtotal_incl_tax]']"),
            tax_amount: $ji("input[name='items[" + id + "][tax_amount]']"),
            hidden_tax_amount: $ji("input[name='items[" + id + "][hidden_tax_amount]']"),
            weee_tax_applied_row_amount: $ji("input[name='items[" + id + "][weee_tax_applied_row_amount]']"),
            tax_percent: $ji("input[name='items[" + id + "][tax_percent]']"),
            discount_amount: $ji("input[name='items[" + id + "][discount_amount]']"),
            discount_percent: $ji("input[name='items[" + id + "][discount_percent]']"),
            row_total: $ji("input[name='items[" + id + "][row_total]']"),

            qty_item_in_bundle: $ji("input[name='items[" + id + "][qty_item_in_bundle]']"),

            fact_qty: $ji("input[name='items[" + id + "][fact_qty]']"),

            item_id: id,

            remove: $ji("input[name='items[" + id + "][remove]']"),
            parent: $ji("input[name='items[" + id + "][parent]']")
        };
    },
    getBundleItems: function (bundle_id) {
        var children = {};
        $ji(".has_parent_" + bundle_id).each(function () {
            var item_id = $ji(this).attr('data-item-id');
            if (item_id != bundle_id) {
                children[item_id] = this.getInputs(item_id);
            }
        });
        return children;
    },
    getCalculationSequence: function () {
        if (this.applyTaxAfterDiscount) {
            return this.discountTax ? this.CALC_TAX_AFTER_DISCOUNT_ON_INCL : this.CALC_TAX_AFTER_DISCOUNT_ON_EXCL;
        } else {
            return this.discountTax ? this.CALC_TAX_BEFORE_DISCOUNT_ON_INCL : this.CALC_TAX_BEFORE_DISCOUNT_ON_EXCL;
        }
    },
    enabledSubmitButton: function () {
        $ji('#edit_ordered_items_submit').removeAttr('disabled').removeClass('disabled');
    },
    /*********************/

    _checkFactQty: function (item) {
        var data_stock_qty_increment = parseFloat($ji(item.fact_qty).attr("data-stock-qty-increment"));
        var data_stock_qty = parseFloat($ji(item.fact_qty).attr("data-stock-qty"));
        var data_stock_min_sales_qty = parseFloat($ji(item.fact_qty).attr("data-stock-min-sales-qty"));
        var data_stock_max_sales_qty = parseFloat($ji(item.fact_qty).attr("data-stock-max-sales-qty"));

        var qty_value = parseFloat($ji(item.fact_qty).val());

        if (qty_value <= 0) {
            qty_value = 1;
        }

        if (this.validateStockQty == 1) {
            /* check max sales qty */
            if (qty_value > data_stock_max_sales_qty) {
                qty_value = data_stock_max_sales_qty;
            }

            /* check min sales qty */
            if (qty_value < data_stock_min_sales_qty) {
                qty_value = data_stock_min_sales_qty;
            }
        }

        /* check stock qty */
        if (data_stock_qty < qty_value) {
            if (this.validateStockQty == 1) {
                qty_value = data_stock_qty;
            }
            $ji('.notice_' + item.item_id).show();
            $ji('.notice_' + item.item_id + ' .notice_qty').show();
        } else {
            $ji('.notice_' + item.item_id).hide();
            $ji('.notice_' + item.item_id + ' .notice_qty').hide();
        }

        /* check qty increment */
        if (qty_value % data_stock_qty_increment != 0) {
            qty_value = Math.round((qty_value / data_stock_qty_increment)) * data_stock_qty_increment;
        }

        $ji(item.fact_qty).val(qty_value);
    },

    updateQtyInBundle: function (item, parent) {
        var item_qty = $ji(item.fact_qty).val();
        var parent_qty = $ji(parent.fact_qty).val();
        var qty_in_bundle = item_qty / parent_qty;
        qty_in_bundle = qty_in_bundle != qty_in_bundle.toFixed(2) ? qty_in_bundle.toFixed(2) : qty_in_bundle;
        $ji("#qty_in_bundle_" + item.item_id).text(qty_in_bundle);
    },

    updateQtyInBundleFact: function (item, parent) {
        var item_qty = $ji(item.fact_qty).val();
        var parent_qty = $ji(parent.fact_qty).val();
        var qty_in_bundle = item_qty / parent_qty;
        qty_in_bundle = qty_in_bundle != qty_in_bundle.toFixed(2) ? qty_in_bundle.toFixed(2) : qty_in_bundle;
        $ji("#qty_in_bundle_" + item.item_id).text(qty_in_bundle);
    },

    /* 1. After every change */
    updateOrderItemInput: function (item) {
        var id = this.getInputId(item);
        var name = this.getInputName(item);
        var input = this.getInputs(id);

        /* !canShowPriceInfo */
        if (!input.price.val())
            return;

        switch (name) {
            case "original_price":
                break;
            case "price":
                this._calculatePriceExclTax(input);
                this._calculateSubtotal(input);
                break;
            case "price_incl_tax":
                this._calculatePriceInclTax(input);
                this._calculateSubtotal(input);
                break;
            case "fact_qty":
                this._checkFactQty(input);
                this._calculateSubtotal(input);
                break;
            case "tax_amount":
                break;
            case "tax_percent":
                if (parseFloat(input.tax_percent.val()) == 0 || input.tax_percent.val().trim() == "") {
                    input.tax_percent.val(0.00);
                }
                this._changePrice(input);
                this._calculateSubtotal(input);
                break;
            case "discount_amount":
                break;
            case "discount_percent":
                if (parseFloat(input.discount_percent.val()) == 0 || input.discount_percent.val().trim() == "") {
                    input.discount_amount.val(0.00);
                }
                break;
        }

        this.baseCalculation(input);
        this._calculateRowTotal(input);

        /* update related items */
        this.updateBundleItems(name, id);

        /* item is a part of bundle product (has parent) */
        if (input.parent.val()) {
            var parent_id = input.parent.val();
            var bundle_items = this.getBundleItems(parent_id);
            this.calculateBundleTotals(bundle_items, parent_id);
        }
    },

    /* 2. Select a tax calculation method */
    baseCalculation: function (input) {
        switch (this.taxCalculationMethodBasedOn) {
            case 'UNIT_BASE_CALCULATION':
                this._unitBaseCalculation(input);
                break;
            case 'ROW_BASE_CALCULATION':
                this._rowBaseCalculation(input);
                break;
            case 'TOTAL_BASE_CALCULATION':
                this._totalBaseCalculation(input);
                break;
        }
    },

    /* 2.1. Method: Unit price */
    _unitBaseCalculation: function (input) {
        var tax_amount = 0;
        var hidden_tax_amount = 0;

        switch (this.getCalculationSequence()) {
            case this.CALC_TAX_BEFORE_DISCOUNT_ON_EXCL:
                tax_amount = this._calcTaxAmount(input.subtotal.val(), input.tax_percent.val(), 0);
                this._calculateDiscountAmount(input, input.subtotal.val());
                break;
            case this.CALC_TAX_BEFORE_DISCOUNT_ON_INCL:
                tax_amount = this._calcTaxAmount(input.subtotal_incl_tax.val(), input.tax_percent.val(), 1);
                this._calculateDiscountAmount(input, input.subtotal_incl_tax.val());
                break;

            case this.CALC_TAX_AFTER_DISCOUNT_ON_EXCL:
                this._calculateDiscountAmount(input, input.subtotal.val());

                var qty = parseFloat(input.fact_qty.val());
                var discountAmount = parseFloat(input.discount_amount.val()) / qty;
                var price = parseFloat(input.price_incl_tax.val());
                var unitTaxDiscount = 0;
                var unitTax = 0;

                if (this.catalogPrices) {
                    unitTax = this._calcTaxAmount(price, input.tax_percent.val(), 1);
                    var discountRate = (price > 0) ? ((unitTax / price) * 100) : 0;
                    unitTaxDiscount = this._calcTaxAmount(discountAmount, discountRate, 0);  /*1*/
                    hidden_tax_amount = this._calcTaxAmount(discountAmount, input.tax_percent.val(), 1);
                } else {
                    price = parseFloat(input.price.val());
                    unitTax = this._calcTaxAmount(price, input.tax_percent.val(), 0);
                    unitTaxDiscount = this._calcTaxAmount(discountAmount, input.tax_percent.val(), 0);
                }

                unitTax = Math.max(unitTax - unitTaxDiscount, 0);
                tax_amount = Math.max(qty * unitTax, 0);
                hidden_tax_amount = Math.max(qty * hidden_tax_amount, 0);
                break;

            case this.CALC_TAX_AFTER_DISCOUNT_ON_INCL:
                this._calculateDiscountAmount(input, input.subtotal_incl_tax.val());

                var qty = parseFloat(input.fact_qty.val());
                var discountAmount = parseFloat(input.discount_amount.val()) / qty;
                var price = parseFloat(input.price_incl_tax.val());
                var unitTax = 0;
                var unitTaxDiscount = 0;

                if (this.catalogPrices) {
                    unitTax = this._calcTaxAmount(price, input.tax_percent.val(), 1);
                    var discountRate = (price > 0) ? (unitTax / price) * 100 : 0;
                    unitTaxDiscount = this._calcTaxAmount(discountAmount, discountRate, 0); /*1*/
                    hidden_tax_amount = this._calcTaxAmount(discountAmount, input.tax_percent.val(), 1);
                } else {
                    price = parseFloat(input.price.val());
                    unitTax = this._calcTaxAmount(price, input.tax_percent.val(), 0);
                    unitTaxDiscount = this._calcTaxAmount(discountAmount, input.tax_percent.val(), 0);
                }

                unitTax = Math.max(unitTax - unitTaxDiscount, 0);
                tax_amount = Math.max(qty * unitTax, 0);
                hidden_tax_amount = Math.max(qty * hidden_tax_amount, 0);
                break;
        }

        input.tax_amount.val(parseFloat(tax_amount).toFixed(2));
        input.hidden_tax_amount.val(parseFloat(hidden_tax_amount).toFixed(2));
    },

    /* 2.2. Method: Row total */
    _rowBaseCalculation: function (input) {
        var tax_amount = 0;
        var hidden_tax_amount = 0;

        switch (this.getCalculationSequence()) {
            case this.CALC_TAX_BEFORE_DISCOUNT_ON_EXCL:
                tax_amount = this._calcTaxAmount(input.subtotal.val(), input.tax_percent.val(), 0);
                this._calculateDiscountAmount(input, input.subtotal.val());
                break;

            case this.CALC_TAX_BEFORE_DISCOUNT_ON_INCL:
                tax_amount = this._calcTaxAmount(input.subtotal_incl_tax.val(), input.tax_percent.val(), 1);
                this._calculateDiscountAmount(input, input.subtotal_incl_tax.val());
                break;

            case this.CALC_TAX_AFTER_DISCOUNT_ON_EXCL:
                this._calculateDiscountAmount(input, input.subtotal.val());
                if (this.catalogPrices) {
                    hidden_tax_amount = this._calcTaxAmount(input.discount_amount.val(), input.tax_percent.val(), 1);
                    tax_amount = this._calcTaxAmount(input.subtotal.val(), input.tax_percent.val(), 0);
                    tax_amount -= hidden_tax_amount;
                } else {
                    tax_amount = this._calcTaxAmount(input.subtotal.val() - input.discount_amount.val(), input.tax_percent.val(), 0);
                }
                break;

            case this.CALC_TAX_AFTER_DISCOUNT_ON_INCL:
                this._calculateDiscountAmount(input, input.subtotal_incl_tax.val());
                if (this.catalogPrices) {
                    hidden_tax_amount = this._calcTaxAmount(input.discount_amount.val(), input.tax_percent.val(), 1);
                    tax_amount = this._calcTaxAmount(input.subtotal.val(), input.tax_percent.val(), 0);
                    tax_amount -= hidden_tax_amount;
                } else {
                    tax_amount = this._calcTaxAmount(input.subtotal.val() - input.discount_amount.val(), input.tax_percent.val(), 0);
                }
                break;
        }

        input.tax_amount.val(parseFloat(tax_amount).toFixed(2));
        input.hidden_tax_amount.val(parseFloat(hidden_tax_amount).toFixed(2));
    },

    /* 2.3. Method: Total */
    _totalBaseCalculation: function (input) {
        var tax_amount = 0;
        var price = 0;
        var hidden_tax_amount = 0;

        switch (this.getCalculationSequence()) {
            case this.CALC_TAX_BEFORE_DISCOUNT_ON_EXCL:
                tax_amount = this._calcTaxAmount(input.subtotal.val(), input.tax_percent.val(), 0);
                this._calculateDiscountAmount(input, input.subtotal.val());
                break;

            case this.CALC_TAX_BEFORE_DISCOUNT_ON_INCL:
                tax_amount = this._calcTaxAmount(input.subtotal_incl_tax.val(), input.tax_percent.val(), 1);
                this._calculateDiscountAmount(input, input.subtotal_incl_tax.val());
                break;

            case this.CALC_TAX_AFTER_DISCOUNT_ON_EXCL:
                this._calculateDiscountAmount(input, input.subtotal.val());
                hidden_tax_amount = this._calcTaxAmount(input.discount_amount.val(), input.tax_percent.val(), 0);
                if (this.catalogPrices) {
                    price = input.subtotal.val() - input.discount_amount.val();
                } else {
                    price = input.subtotal.val() - input.discount_amount.val() - hidden_tax_amount;
                    hidden_tax_amount = 0;
                }
                tax_amount = this._calcTaxAmount(price, input.tax_percent.val(), 0);
                break;

            case this.CALC_TAX_AFTER_DISCOUNT_ON_INCL:
                this._calculateDiscountAmount(input, input.subtotal_incl_tax.val());
                if (this.catalogPrices) {
                    hidden_tax_amount = this._calcTaxAmount(input.discount_amount.val(), input.tax_percent.val(), 1);
                    price = parseFloat(input.subtotal.val()) - parseFloat(input.discount_amount.val()) + parseFloat(hidden_tax_amount);
                } else {
                    hidden_tax_amount = 0;
                    price = input.subtotal.val() - input.discount_amount.val();
                }
                tax_amount = this._calcTaxAmount(price, input.tax_percent.val(), 0);
                break;
        }

        input.tax_amount.val(parseFloat(tax_amount).toFixed(2));
        input.hidden_tax_amount.val(parseFloat(hidden_tax_amount).toFixed(2));
    },

    _calculateDiscountAmount: function (input, subtotal) {
        var discount_percent = parseFloat(input.discount_percent.val());
        var discount_amount = parseFloat(input.discount_amount.val());
        if (!(discount_percent == 0 && discount_amount != 0)) {
            discount_amount = subtotal * discount_percent / 100;
        }

        input.discount_amount.val(discount_amount.toFixed(2));
        input.discount_percent.val(discount_percent.toFixed(2));
    },
    _calcTaxAmount: function (price, tax_percent, priceIncludeTax) {
        var tax_rate = parseFloat(tax_percent) / 100;
        price = parseFloat(price);

        var tax = (priceIncludeTax) ? price * (1 - 1 / (1 + tax_rate)) : price * tax_rate;
        return tax.toFixed(2);
    },
    _calculateSubtotal: function (input) {
        if (this.catalogPrices) {
            var subtotal = parseFloat(input.price.val()) * parseFloat(input.fact_qty.val());
            var hidden_tax_amount = this._calcTaxAmount(input.discount_amount.val(), input.tax_percent.val(), 1);
            var tax_amount = this._calcTaxAmount(subtotal, input.tax_percent.val(), 0);
            tax_amount -= hidden_tax_amount;
            var subtotal_incl_tax = parseFloat(input.price_incl_tax.val()) * parseFloat(input.fact_qty.val());
            subtotal = subtotal_incl_tax - tax_amount;
        }
        else {
            var subtotal = parseFloat(input.price.val()) * parseFloat(input.fact_qty.val());
            var subtotal_incl_tax = parseFloat(input.price_incl_tax.val()) * parseFloat(input.fact_qty.val());
        }
        input.subtotal.val(subtotal.toFixed(2));
        input.subtotal_incl_tax.val(subtotal_incl_tax.toFixed(2));
    },
    _calculateRowTotal: function (input) {
        var subtotal = parseFloat(input.subtotal.val());
        var discount_amount = parseFloat(input.discount_amount.val());
        var tax_amount = parseFloat(input.tax_amount.val());
        var hidden_tax_amount = parseFloat(input.hidden_tax_amount.val());
        var weee_tax_applied_row_amount = parseFloat(input.weee_tax_applied_row_amount.val());

        var row_total = subtotal + tax_amount + hidden_tax_amount + weee_tax_applied_row_amount - discount_amount;

        input.row_total.val(row_total.toFixed(2));
        return row_total;
    },
    _calculatePriceExclTax: function (input) {
        var price_excl_tax = parseFloat(input.price.val());
        var tax_percent = parseFloat(input.tax_percent.val());
        var price = price_excl_tax * (1 + tax_percent / 100);

        input.price.val(price_excl_tax.toFixed(2));
        input.price_incl_tax.val(price.toFixed(2));
        input.tax_percent.val(tax_percent.toFixed(2));
    },
    _calculatePriceInclTax: function (input) {
        var price_incl_tax = parseFloat(input.price_incl_tax.val());
        var tax_percent = parseFloat(input.tax_percent.val());

        var price = price_incl_tax / (1 + tax_percent / 100);

        input.price.val(price.toFixed(2));
        input.price_incl_tax.val(price_incl_tax.toFixed(2));
        input.tax_percent.val(tax_percent.toFixed(2));
    },
    _changePrice: function (input) {
        if (this.catalogPrices) {
            this._calculatePriceInclTax(input); /* incl tax fixed */
        } else {
            this._calculatePriceExclTax(input); /* excl tax fixed */
        }
    }
};

IWD.OrderManager.CouponCode = {
    applyUrl: '',
    couponField: '#iwd_om_coupon_code',
    couponCode: '',
    removeButton: '#iwd_om_coupon_code_remove',
    applyButton: '#iwd_om_coupon_code_apply',

    init: function () {
        this.couponCodeField();

        var self = this;
        $ji(document).on('click', self.applyButton, function () {
            self.applyCoupon();
        });
        $ji(document).on('click', self.removeButton, function () {
            self.removeCoupon();
        });
    },

    couponCodeField: function () {
        var self = this;

        $ji(document).on('keypress change', self.couponField, function () {
            var couponCode = $ji(self.couponField).val();
            if (couponCode.length == 0 || self.couponCode == couponCode) {
                self.disableApplyButton();
            } else {
                self.enableApplyButton();
            }
        });
    },

    applyCoupon: function () {
        var self = this;
        var couponCode = $ji(self.couponField).val();
        self.disableApplyButton();
        IWD.OrderManager.ShowLoadingMask();
        $ji.ajax({
            url: self.applyUrl,
            type: "POST",
            dataType: 'json',
            data: "form_key=" + FORM_KEY + "&coupon_code=" + couponCode + "&order_id=" + IWD.OrderManager.orderId,
            success: function (result) {
                if (result.status == 1) {
                    if ($ji('#ordered_items_edit_form').length == 0) {
                        $ji("#ordered_items_box").append(result.form.toString());
                        $ji('#ordered_items_edit_form').hide();
                        self.changeOrderItems(result.items, couponCode);
                        IWD.OrderManager.OrderedItems.editOrderedItemsSubmit();
                    } else {
                        if (couponCode) {
                            self.showRemoveButton();
                        }
                        self.changeOrderItems(result.items, couponCode);
                        IWD.OrderManager.HideLoadingMask();
                    }
                } else {
                    IWD.OrderManager.addMessage('#order_coupon_code', result.message);
                }
            },
            error: function (result) {
                IWD.OrderManager.handleErrorResult(result);
            }
        });
    },

    changeOrderItems: function (items, couponCode) {
        $ji('#ordered_items_edit_form form').append('<input type="hidden" value="' + couponCode + '" name="coupon_code"/>');

        $ji.each(items, function (i, item) {
            if (item) {
                $ji('#ordered_items_form input[name="items[' + i + '][discount_percent]"]').val(item.discount_percent);
                $ji('#ordered_items_form input[name="items[' + i + '][discount_amount]"]').val(item.discount_amount);
                $ji('#ordered_items_form input[name="items[' + i + '][discount_amount]"]').change();
            }
        });
    },

    removeCoupon: function () {
        if (confirm('Are you sure you want to remove coupon code?')) {
            $ji(this.couponField).val('');
            this.hideRemoveButton();
            this.applyCoupon();
        }
    },

    enableApplyButton: function () {
        $ji(this.applyButton).removeClass('disabled').removeAttr('disabled');
    },

    disableApplyButton: function () {
        $ji(this.applyButton).addClass('disabled').attr('disabled', 'disabled');
    },

    showRemoveButton: function () {
        $ji(this.removeButton).show();
    },

    hideRemoveButton: function () {
        $ji(this.removeButton).hide();
    }
};

IWD.OrderManager.OrderedItemProductInfo = {
    items: {},
    titleSelector: '#ordered_items_table h5.title',

    init: function () {
        this.initTitleClick();
    },

    initTitleClick: function () {
        var self = this;
        $ji(document).off('click', this.titleSelector);
        $ji(document).on('click', this.titleSelector, function () {
            var id = $ji(this).find('span').attr('id');
            var product = self.items[id];

            var content = '<div id="iwd-om-ordered-item-product-info">';

            if (product.productImage) {
                content += '<div class="product-image"><img src="' + product.productImage + '"/></div>';
            }

            var urls = '<div class="product-urls">' + product.frontUrl + product.adminUrl + '<a href="javascript:void()" class="close-popup" onclick="IWD.OrderManager.Popup.hideModal()">Close</a></div>';

            content += '<div class="product-info">';
            $ji.each(product, function (title, value) {
                if (['adminUrl','frontUrl','productImage','children'].indexOf(title) == -1 && title && value) {
                    content += '<div><div class="title">' + title +'</div><div class="value">' + value + '</div></div>';
                }
            });
            if (product.children) {
                $ji.each(product.children, function (title, value) {
                    content += '<div><div class="child-title">' + title +'</div></div>';
                    $ji.each(value, function (t, v) {
                        content += '<div><div class="title">' + t +'</div><div class="value">' + v + '</div></div>';
                    });
                });
            }
            content += '</div>';
            content += urls;
            content += '</div>';

            IWD.OrderManager.Popup.showModal('Product ' + product.Title, content);
        });
    },

    addItem: function (id, data) {
        this.items[id] = data;
    }
};

IWD.OrderManager.SalesGrids = {
    init: function () {
        $ji('#order_shipments_table tr, #order_creditmemos_table tr').each(function () {
            $ji(this).attr('title',  $ji(this).attr('title') + 'order_id/' + IWD.OrderManager.orderId);
        });
    }
};