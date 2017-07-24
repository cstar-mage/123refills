;if(typeof(jQueryIWD) == "undefined"){if(typeof(jQuery) != "undefined") {jQueryIWD = jQuery;}} $ji = jQueryIWD;

IWD.OrderManager.Totals = {
    totalsBlock: '.iwd-om-totals',
    showMore: '.iwd-om-totals .show-less-more',
    defaultTables: '.iwd-om-totals .default-totals',
    moreTables: '.iwd-om-totals .more-totals',

    init: function (gridOptions, totals) {
        this.initShowMoreButton();
        this.initTable(gridOptions, totals);
        this.initTableResponsive();
        this.initNiceScroll();
    },

    initShowMoreButton: function () {
        var self = this;
        $ji(document).on('click touchstart', this.showMore, function () {
            if ($ji(this).hasClass('more')) {
                self.showAdditionalTables();
            } else {
                self.hideAdditionalTables();
            }

            self.reinitNiceScroll();
            self.moreTableResponsive();
            self.defaultTableResponsive();
        });
    },

    hideAdditionalTables: function() {
        $ji(this.showMore).removeClass('less').addClass('more');
        $ji(this.defaultTables).removeClass('hide').addClass('show');
        $ji(this.moreTables).removeClass('show').addClass('hide');
    },

    showAdditionalTables: function() {
        $ji(this.showMore).removeClass('more').addClass('less');
        $ji(this.defaultTables).removeClass('show').addClass('hide');
        $ji(this.moreTables).removeClass('hide').addClass('show');
    },

    initTable: function (gridOptions, totals) {
        var self = this;
        $ji.each(totals, function (i, val){
            $ji(self.totalsBlock + ' .' + i).html(val.amount).attr('title', val.amount);
            $ji(self.totalsBlock + ' .page_' + i).html(val.page_amount).attr('title', val.page_amount);
        });

        $ji(self.totalsBlock + ' .page_from').html(gridOptions.page_from).attr('title', gridOptions.page_from);
        $ji(self.totalsBlock + ' .page_to').html(gridOptions.page_to).attr('title', gridOptions.page_to);
        $ji(self.totalsBlock + ' .orders_count').html(gridOptions.orders_count).attr('title', gridOptions.orders_count);

        if (gridOptions.orders_count == 1) {
            self.displayOneOrder('.orders_count');
        } else {
            self.displayManyOrders('.orders_count');
        }

        if (gridOptions.page_to == 0) {
            $ji(self.totalsBlock + ' .page_from_to').hide();
        } else if(gridOptions.page_to == 1) {
            $ji(self.totalsBlock + ' .page_from_to').hide();
            self.displayOneOrder('.page_from_to');
        } else {
            $ji(self.totalsBlock + ' .page_from_to').show();
            self.displayManyOrders('.page_from_to');
        }
    },

    displayManyOrders:function(opt)
    {
        var block = $ji(this.totalsBlock + ' ' + opt).closest('div');
        $ji(block).find('.many-orders').show();
        $ji(block).find('.one-order').hide();
    },

    displayOneOrder:function(opt)
    {
        var block = $ji(this.totalsBlock + ' ' + opt).closest('div');
        $ji(block).find('.many-orders').hide();
        $ji(block).find('.one-order').show();
    },

    initTableResponsive: function()
    {
        var self = this;
        self.moreTableResponsive();
        self.defaultTableResponsive();

        var resizeTimer;
        $ji(window).resize(function() {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(function() {
                self.moreTableResponsive();
                self.defaultTableResponsive();
            }, 500);
        });
    },

    moreTableResponsive: function() {
        var self = IWD.OrderManager.Totals;
        $ji(self.moreTables).removeClass('big-data');
        $ji(self.moreTables + ' .total-block').each(function(){
            var titleWidth = $ji(this).find('.total-title').outerWidth();
            var amountWidth = $ji(this).find('.total-amount').outerWidth();
            if ($ji(this).innerWidth() < titleWidth || $ji(this).innerWidth() < amountWidth) {
                $ji(self.moreTables).addClass('big-data');
                return 0;
            }
        });
    },

    defaultTableResponsive: function() {
        var self = IWD.OrderManager.Totals;
        $ji(self.defaultTables).removeClass('big-data');
        $ji(self.defaultTables + ' .total-block').each(function(){
            var titleWidth = $ji(this).find('.total-title').outerWidth();
            var amountWidth = $ji(this).find('.total-amount').outerWidth();
            if ($ji(this).innerWidth() < (titleWidth + amountWidth)) {
                $ji(self.defaultTables).addClass('big-data');
                return 0;
            }
        });
    },


    initNiceScroll: function(){
        $ji(this.moreTables).niceScroll({cursorcolor:"#000", cursorborder:'', cursoropacitymin:0.2, cursoropacitymax:0.5, cursorfixedheight:57, cursorwidth:9,cursorborderradius:5, railoffset:{left:28}});
    },

    reinitNiceScroll: function(){
        $ji(this.moreTables).getNiceScroll().resize();
    }
};