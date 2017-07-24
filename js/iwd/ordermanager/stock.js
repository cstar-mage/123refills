;window.hasOwnProperty = function (obj) {return (this[obj]) ? true : false;};

IWD.OrderManager.Stock = {
    iwdAssignStockFormUrl: "",
    iwdAssignStockUrl: "",
    reloadAfterAssign: false,
    isAllStocksAssigned: true,
    changed: false,

    init: function()
    {
        var inputs = '#stock_ordered_items_form .input input';
        var self = this;

        $ji(document).on('hidden.bs.modal', '#iwd_om_stocks_popup' ,function () {
            $ji(".stocks-assign .assign-stock-table .stocks-table").getNiceScroll().hide();
        });

        $ji(document).on('focus', inputs, function(){$ji(this).attr('data-val', $ji(this).val()); $ji(this).select()});
        $ji(document).on('click', inputs, function(e){self.clickStockItemsInputQty(e, this)});
        $ji(document).on('change paste blur', inputs, function(e){self.changeStockItemsInputQty(this);});
        $ji(document).on('keypress', inputs, function(e){
            if (e.which == 13){return 1;}
            if('+-*/'.indexOf(String.fromCharCode(e.which)) != -1){return $ji(this).val($ji(this).val());}
            return ('1234567890.+-*/'.indexOf(String.fromCharCode(e.which)) != -1);
        });

        $ji('#iwd_om_stocks_popup').on('hide.bs.modal', function () {
            if($ji('input[name="reload"]').val() == 1 || IWD.OrderManager.Stock.reloadAfterAssign){
                self.ShowLoadingMask();

                if (typeof IWD.OrderManager.Stock.reloadAfterAssign === 'string') {
                    document.location.href = IWD.OrderManager.Stock.reloadAfterAssign;
                } else {
                    location.reload();
                }
            }
        });
    },

    ShowLoadingMask: function () {
        $ji('#loading-mask').width($ji("html").width()).height($ji("html").height()).css('top', 0).css('left', -2).css('z-index', 10000).show();
    },

    HideLadingMask: function(){
        $ji('#loading-mask').hide();
    },

    showAssignStockForm: function(orderId)
    {
        var self = this;
        var data = "form_key=" + FORM_KEY + "&order_id=" + orderId;
        IWD.OrderManager.Stock.changed = false;
        this.postRequest(data, this.iwdAssignStockFormUrl, function(result){
            $ji('#iwd_om_popup_stocks_form').html(result.form);

            self.initProductMarkers();
            self.initNiceScroll();
            self.showPopup();
        });
    },

    initNiceScroll: function()
    {
        $ji(".stocks-assign .assign-stock-table .stocks-table")
            .niceScroll({cursorcolor:"#000", cursorborder:'', cursoropacitymin:0.2, cursoropacitymax:0.5, cursorfixedheight:57, cursorwidth:9,cursorborderradius:5, railoffset:{left:28}});
    },

    initProductMarkers:function()
    {
        var self = this;
        $ji('#stock_ordered_items_form tbody tr td:nth-child(2) input').each(function(){
            var orderedQty = self.getOrderedQty(this);
            var assignedQty = self.getAssignedQty(this);
            IWD.OrderManager.Stock.isAllStocksAssigned = IWD.OrderManager.Stock.isAllStocksAssigned ? (orderedQty == assignedQty) : IWD.OrderManager.Stock.isAllStocksAssigned;
            self.changeProductMarker(this, (assignedQty == orderedQty));
        });
    },

    showPopup:function()
    {
        var options = {"backdrop":"static", "show":true};
        $ji('#iwd_om_stocks_popup').modaliwd(options);
        $ji('#iwd-om-popup-box .om-iwd-modal-content').attr('class','om-iwd-modal-content')
            .addClass("warehouses-" + $ji('#iwd_om_stocks_popup .assign-stock-table').attr('data-warehouses'));
    },

    closeAssignStockForm: function(orderId) {
        $ji('#stock_ordered_items_' + orderId).remove();
    },

    assignStock: function(orderId) {
        var self = this;
        var formData = $ji("#stock_ordered_items_form :input[value!='']").serialize();

        formData += "&form_key=" + FORM_KEY + "&order_id=" + orderId;

        this.postRequest(formData, this.iwdAssignStockUrl, function(result){
            if(result.reload){
                $ji('#iwd_om_stocks_popup').modaliwd('hide');
                self.ShowLoadingMask();
                location.reload();
            }else {
                $ji(".inventory_order_item_" + orderId).html($ji(result.info).html()).effect({effect:"shake", direction:"horizontal", distance:"5", times:"3"});
                self.closeAssignStockForm(orderId);
                $ji('#iwd_om_stocks_popup').modaliwd('hide');
            }
        });
    },

    postRequest: function(data, url, successResponse) {
        var self = this;
        self.ShowLoadingMask();

        $ji.ajax({url: url,
            type: "POST",
            dataType: 'json',
            data: data,
            success: function (result) {
                if (result.ajaxExpired) {
                    document.location.reload(true);
                    return;
                }
                if (result.status) {
                    successResponse(result);
                }
                self.HideLadingMask();
            },
            error: function () {
                self.HideLadingMask();
            }
        });
    },

    clickStockItemsInputQty:function(e, item)
    {
        var orderedQty = this.getOrderedQty(item);
        var assignedQty = this.getAssignedQty(item);
        var value = parseFloat($ji(item).val());

        if(!value){
            value = orderedQty - assignedQty;
            value = Math.min($ji(item).data('max'), value);
            if(value != 0){
                this.changeProductMarker(item, true);
                this.updateQty(item, value);
            }
        }

        $ji(item).select();
    },

    changeStockItemsInputQty:function(item)
    {
        var value = $ji(item).val();
        var preValue = parseFloat($ji(item).attr('data-val')); preValue = preValue ? preValue : 0;
        value = eval(value); value = value ? value : 0;
        var orderedQty = this.getOrderedQty(item);
        var assignedQty = this.getAssignedQty(item);

        if(value < 0 || assignedQty > orderedQty){
            preValue = Math.min($ji(item).data('max'), preValue);
            if (value != 0) {
                this.updateQty(item, preValue);
            }
            return;
        }

        this.changeProductMarker(item, (assignedQty == orderedQty));
        value = Math.min($ji(item).data('max'), value);
        this.updateQty(item, value);
    },

    updateQty:function(item, value)
    {
        $ji(item).val(value);
        $ji(item).attr('value', value);
        this.updateStockQty(item, value);

        $ji(item).attr('data-val', value);
    },

    updateStockQty:function(item, value)
    {
        var preValue = parseFloat($ji(item).attr('data-val')); preValue = preValue ? preValue : 0;
        var stockId = $ji(item).attr('data-stock-id');
        var productId = $ji(item).attr('data-product-id');
        var inStock = $ji('input[name="stock_item[' + productId + '][' + stockId + ']"]');

        var qtyInStock = parseFloat($ji(inStock).val());
        IWD.OrderManager.Stock.changed = IWD.OrderManager.Stock.changed ? IWD.OrderManager.Stock.changed : (value != preValue);
        this.disableEnableButton();

        $ji(inStock).val(qtyInStock + preValue - value);
    },

    disableEnableButton:function()
    {
        if (this.changed) {
            $ji('.assign-stock-table .actions button').removeClass('disabled').removeAttr('disabled');
        } else {
            $ji('.assign-stock-table .actions button').addClass('disabled').attr('disabled', 'disabled');
        }
    },

    changeProductMarker:function(item, assigned)
    {
        var itemId = $ji(item).data("item-id");
        var productName = $ji('.product-name-'+itemId+' .marker');

        if (assigned) {
            $ji(productName).addClass('fa-check').removeClass('fa-times');
            $ji('.item_' + itemId).addClass('assigned');
        } else {
            $ji(productName).addClass('fa-times').removeClass('fa-check');
            $ji('.item_' + itemId).removeClass('assigned');
        }

        var rowId = $ji(item).data("row");
        if($ji('.products-table .row_' + rowId).not('.parent').length == $ji('.products-table .assigned.row_' + rowId).not('.parent').length){
            $ji('.parent.row_' + rowId).addClass('assigned');
        } else {
            $ji('.parent.row_' + rowId).removeClass('assigned');
        }
    },

    getAssignedQty:function(item)
    {
        var itemId = $ji(item).data("item-id");
        var assignedQty = 0;
        $ji('.assign-stock-table input[data-item-id="' + itemId + '"]').each(function(elem){
            var value = eval($ji(this).val()); value = value ? value : 0;
            assignedQty += (value) ? parseFloat(value) : 0;
        });

        return assignedQty;
    },

    getOrderedQty:function(item)
    {
        var itemId = $ji(item).data("item-id");
        var orderItem = $ji('.assign-stock-table input[name="item[' + itemId + ']"]');
        return parseFloat($ji(orderItem).attr('data-ordered'));
    }
};

IWD.OrderManager.Stock.Order = {
    init: function()
    {
        IWD.OrderManager.Stock.init();
    },

    assignStock: function(orderId) {
        var self =  IWD.OrderManager.Stock;
        var url = IWD.OrderManager.Stock.Order.iwdAssignStockUrl;

        var formData = $ji("#stock_ordered_items_form").serialize();
        formData += "&form_key=" + FORM_KEY + "&order_id=" + orderId + "&order_view=1";

        self.postRequest(formData, url, function(result){
            if(result.reload){
                $ji('#iwd_om_stocks_popup').modaliwd('hide');
                self.ShowLoadingMask();
                location.reload();
            } else {
                $ji.each(result.info, function (i, item) {
                    $ji(".inventory_order_item_" + i).html($ji(item).html()).effect({
                        effect: "shake",
                        direction: "horizontal",
                        distance: "5",
                        times: "3"
                    });
                });
                self.closeAssignStockForm(orderId);
                $ji('#iwd_om_stocks_popup').modaliwd('hide');
            }
        });
    },

    showAssignStockForm: function(orderId)
    {
        var data = "form_key=" + FORM_KEY + "&order_id=" + orderId + "&order_view=1";
        IWD.OrderManager.Stock.changed = false;
        IWD.OrderManager.Stock.postRequest(data, IWD.OrderManager.Stock.Order.iwdAssignStockFormUrl, function(result){
            IWD.OrderManager.Stock.Order.displayAssignStockForm(result.form);
        });
    },

    displayAssignStockForm: function(form)
    {
        $ji('#iwd_om_popup_stocks_form').html(form);
        IWD.OrderManager.Stock.initProductMarkers();

        if (IWD.OrderManager.Stock.isAllStocksAssigned && typeof IWD.OrderManager.Stock.reloadAfterAssign === 'string') {
            document.location.href = IWD.OrderManager.Stock.reloadAfterAssign;
        } else {
            IWD.OrderManager.Stock.initNiceScroll();
            IWD.OrderManager.Stock.showPopup();
        }
    }
};