<?php

class IWD_OrderManager_Block_Adminhtml_Transactions_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    protected $created_at_from = '';
    protected $created_at_to = '';

    public function __construct()
    {
        parent::__construct();

        $this->setId('iwd_settlementreport_transactions_grid');
        $this->setDefaultSort('post_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('iwd_ordermanager/transactions')->getTransactionsCollection();
        $this->setCollection($collection);

        $this->addFiltersToCollection();

        $export_for_email = $this->getData('export_for_email');
        if (Mage::helper('iwd_ordermanager')->isGridExport() || (isset($export_for_email) && !empty($export_for_email))) {
            return $this;
        }

        return parent::_prepareCollection();
    }

    protected function addFiltersToCollectionForExport()
    {
        $last_days = Mage::getStoreConfig('iwd_settlementreport/emailing/last_days');

        if ($last_days != 0)
        {
            $from = new DateTime();
            $from = $from->modify("-{$last_days} day")->format('Y-m-d');
            $from = Mage::getModel('core/date')->gmtDate('Y-m-d H:i:s', $from);

            $to = new DateTime();
            $to = $to->modify('+1 day')->format('Y-m-d');
            $to = Mage::getModel('core/date')->gmtDate('Y-m-d H:i:s', $to);

            $collection = $this->getCollection();
            $collection->addFieldToFilter('main_table.created_at', array(
                'from' => $from,
                'to' => $to,
                'date' => true,
            ));

            $this->setCollection($collection);
        }
    }

    protected function addFiltersToCollection()
    {
        $export_for_email = $this->getData('export_for_email');
        if (isset($export_for_email) && !empty($export_for_email)) {
            $this->addFiltersToCollectionForExport();
            return;
        }

        $filter = $this->prepareFilters();

        if (!Mage::getStoreConfig('iwd_settlementreport/default/limit_period')) {
            if (isset($filter['created_at'])) {
                $from = isset($filter['created_at']['from']) ? date('m/d/Y', strtotime($filter['created_at']['from'])) : "";
                $to = isset($filter['created_at']['to']) ? date('m/d/Y', strtotime($filter['created_at']['to'])) : "";
                Mage::getSingleton('adminhtml/session')->setData("iwd_settlementreport_filter_from", $from);
                Mage::getSingleton('adminhtml/session')->setData("iwd_settlementreport_filter_to", $to);
            }
            return;
        }

        $collection = $this->getCollection();

        if (isset($filter['created_at']) && isset($filter['created_at']['from']) && isset($filter['created_at']['to'])) {
            $from = date('Y-m-d', strtotime($filter['created_at']['from']));
            $to = date('Y-m-d', strtotime($filter['created_at']['to']));
        } else {
            $from = date("Y-m-d", strtotime("-" . $this->getDefaultPeriodInDays() . " days"));
            $to = date('Y-m-d', strtotime("+ 1 days"));
        }

        $this->addPeriodFilterToSession($from, $to);

        $collection->addFieldToFilter('created_at', array(
            'from' => $from,
            'to' => $to,
            'date' => true,
        ));

        $this->setCollection($collection);
    }

    protected function addPeriodFilterToSession($from, $to)
    {
        $iwdSettlementreportTransactionsGridfilter = Mage::getSingleton('adminhtml/session')->getData("iwd_settlementreport_transactions_gridfilter");
        $filter = Mage::helper('adminhtml')->prepareFilterString($iwdSettlementreportTransactionsGridfilter);
        $filter['created_at']['from'] = date('m/d/Y', strtotime($from));
        $filter['created_at']['to'] = date('m/d/Y', strtotime($to));
        $filter['created_at']['locale'] = 'en_US';

        $this->created_at_from = $filter['created_at']['from'];
        $this->created_at_to = $filter['created_at']['to'];

        $filter = base64_encode(http_build_query($filter));
        Mage::getSingleton('adminhtml/session')->setData("iwd_settlementreport_transactions_gridfilter", $filter);

        Mage::getSingleton('adminhtml/session')->setData("iwd_settlementreport_filter_from", $this->created_at_from);
        Mage::getSingleton('adminhtml/session')->setData("iwd_settlementreport_filter_to", $this->created_at_to);
    }

    protected function getDefaultPeriodInDays()
    {
        $last_days = Mage::getStoreConfig('iwd_settlementreport/default/last_days');
        return !empty($last_days) ? $last_days : 7;
    }

    protected function prepareFilters(){
        $filter   = $this->getParam($this->getVarNameFilter(), null);

        if (is_null($filter)) {
            $filter = $this->_defaultFilter;
        }

        if (is_string($filter)) {
            $filter = $this->helper('adminhtml')->prepareFilterString($filter);
        }

        return $filter;
    }

    protected function _prepareColumns()
    {
        $currency_code = Mage::app()->getStore()->getBaseCurrency()->getCode();
        $helper = Mage::helper('iwd_ordermanager');
        $export = $helper->isGridExport() || $this->getData('export_for_email');

        $this->addColumn('transaction_id', array(
            'header' => $helper->__('Transaction ID'),
            'type' => 'number',
            'index' => 'transaction_id',
            'align' => 'right',
            'filter_index' => 'main_table.transaction_id',
            'width' => '50px',
            'sortable' => true,
            'renderer' => new IWD_OrderManager_Block_Adminhtml_Transactions_Renderer_Transaction(array('export'=>$export)),
        ));

        $this->addColumn('order_increment_id', array(
            'header' => $helper->__('Order ID'),
            'type' => 'number',
            'index' => 'order_increment_id',
            'align' => 'right',
            'width' => '50px',
            'filter_index' => 'main_table.order_increment_id',
            'renderer' => new IWD_OrderManager_Block_Adminhtml_Transactions_Renderer_Order(array('export'=>$export)),
        ));

        $this->addColumn('status', array(
            'header' => $helper->__('Status'),
            'index' => 'status',
            'filter_index' => 'main_table.status',
            'type' => 'options',
            'align' => 'center',
            'width' => '100px',
            'options' => Mage::getModel('adminhtml/system_config_source_yesno')->toArray(),
            'renderer' => new IWD_OrderManager_Block_Adminhtml_Transactions_Renderer_Status(array('export'=>$export)),
        ));

        $this->addColumn('created_at', array(
            'header' => $helper->__('Date'),
            'index' => 'created_at',
            'filter_index' => 'main_table.created_at',
            'type' => 'datetime',
            'align' => 'left',
            'width' => '180px',
        ));

        /* Status */
        $header = $export ? 'Status (Mage)' : 'Magento';
        $this->addColumn('mage_transaction_status', array(
            'header' => $helper->__($header),
            'index' => 'mage_transaction_status',
            'filter_index' => 'main_table.mage_transaction_status',
            'type' => 'options',
            'align' => 'right',
            'width' => '100px',
            'options' => Mage::getSingleton('iwd_ordermanager/adminhtml_options_status')->toOptionArrayMage(),
            'renderer' => new IWD_OrderManager_Block_Adminhtml_Transactions_Renderer_Colorize_Status(array('export'=>$export)),
        ));
        $header = $export ? 'Status (Auth)' : 'Authorize.Net';
        $this->addColumn('auth_transaction_status', array(
            'header' => $helper->__($header),
            'index' => 'auth_transaction_status',
            'filter_index' => 'main_table.auth_transaction_status',
            'type' => 'options',
            'align' => 'right',
            'width' => '100px',
            'options' => Mage::getSingleton('iwd_ordermanager/adminhtml_options_status')->toOptionArrayAuth(),
            'renderer' => new IWD_OrderManager_Block_Adminhtml_Transactions_Renderer_Colorize_Status(array('export'=>$export)),
        ));

        /* Authorized */
        $header = $export ? 'Authorized (Mage)' : 'Magento';
        $this->addColumn('mage_amount_authorized', array(
            'header' => $helper->__($header),
            'index' => 'mage_amount_authorized',
            'type' => 'currency',
            'filter_index' => 'main_table.mage_amount_authorized',
            'currency' => 'base_currency_code',
            'currency_code' => $currency_code,
            'renderer' => new IWD_OrderManager_Block_Adminhtml_Transactions_Renderer_Colorize_Amount(array('for_compare_coll'=>'auth_amount_authorized', 'export'=>$export)),
        ));
        $header = $export ? 'Authorized (Auth)' : 'Authorize.Net';
        $this->addColumn('auth_amount_authorized', array(
            'header' => $helper->__($header),
            'index' => 'auth_amount_authorized',
            'type' => 'currency',
            'filter_index' => 'main_table.auth_amount_authorized',
            'currency' => 'base_currency_code',
            'currency_code' => $currency_code,
            'renderer' => new IWD_OrderManager_Block_Adminhtml_Transactions_Renderer_Colorize_Amount(array('for_compare_coll'=>'mage_amount_authorized', 'export'=>$export)),
        ));

        /* Captured */
        $header = $export ? 'Captured (Mage)' : 'Magento';
        $this->addColumn('mage_amount_captured', array(
            'header' => $helper->__($header),
            'index' => 'mage_amount_captured',
            'type' => 'currency',
            'filter_index' => 'main_table.mage_amount_captured',
            'currency' => 'base_currency_code',
            'currency_code' => $currency_code,
            'renderer' => new IWD_OrderManager_Block_Adminhtml_Transactions_Renderer_Colorize_Amount(array('for_compare_coll'=>'auth_amount_captured', 'export'=>$export)),
        ));
        $header = $export ? 'Captured (Auth)' : 'Authorize.Net';
        $this->addColumn('auth_amount_captured', array(
            'header' => $helper->__($header),
            'index' => 'auth_amount_captured',
            'type' => 'currency',
            'filter_index' => 'main_table.auth_amount_captured',
            'currency' => 'base_currency_code',
            'currency_code' => $currency_code,
            'renderer' => new IWD_OrderManager_Block_Adminhtml_Transactions_Renderer_Colorize_Amount(array('for_compare_coll'=>'mage_amount_captured', 'export'=>$export)),
        ));

        /* Settlement */
        $header = $export ? 'Settlement (Mage)' : 'Magento';
        $this->addColumn('mage_amount_settlement', array(
            'header' => $helper->__($header),
            'index' => 'mage_amount_settlement',
            'type' => 'currency',
            'filter_index' => 'main_table.mage_amount_settlement',
            'currency' => 'base_currency_code',
            'currency_code' => $currency_code,
            'renderer' => new IWD_OrderManager_Block_Adminhtml_Transactions_Renderer_Colorize_Amount(array('for_compare_coll'=>'auth_amount_settlement', 'export'=>$export)),
        ));
        $header = $export ? 'Settlement (Auth)' : 'Authorize.Net';
        $this->addColumn('auth_amount_settlement', array(
            'header' => $helper->__($header),
            'index' => 'auth_amount_settlement',
            'type' => 'currency',
            'filter_index' => 'main_table.auth_amount_settlement',
            'currency' => 'base_currency_code',
            'currency_code' => $currency_code,
            'renderer' => new IWD_OrderManager_Block_Adminhtml_Transactions_Renderer_Colorize_Amount(array('for_compare_coll'=>'mage_amount_settlement', 'export'=>$export)),
        ));

        /* Refunded */
        $header = $export ? 'Refunded (Mage)' : 'Magento';
        $this->addColumn('mage_amount_refund', array(
            'header' => $helper->__($header),
            'index' => 'mage_amount_refund',
            'type' => 'currency',
            'filter_index' => 'main_table.mage_amount_refund',
            'currency' => 'base_currency_code',
            'currency_code' => $currency_code,
            'renderer' => new IWD_OrderManager_Block_Adminhtml_Transactions_Renderer_Colorize_Amount(array('for_compare_coll' => 'auth_amount_refund', 'export'=>$export)),
        ));
        $header = $export ? 'Refunded (Auth)' : 'Authorize.Net';
        $this->addColumn('auth_amount_refund', array(
            'header' => $helper->__($header),
            'index' => 'auth_amount_refund',
            'type' => 'currency',
            'filter_index' => 'main_table.auth_amount_refund',
            'currency' => 'base_currency_code',
            'currency_code' => $currency_code,
            'renderer' => new IWD_OrderManager_Block_Adminhtml_Transactions_Renderer_Colorize_Amount(array('for_compare_coll' => 'mage_amount_refund', 'export'=>$export)),
        ));



        $this->addExportType('*/*/exportCsv', $helper->__('CSV'));
        $this->addExportType('*/*/exportExcel', $helper->__('Excel XML'));

        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
        return false;
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current' => true));
    }

    public function _toHtml()
    {
        return parent::_toHtml() . $this->addJs();
    }

    public function addJs()
    {
        $helper = Mage::helper('iwd_ordermanager');

        $notify_form = sprintf("<td id='send_email_with_report'><span><img src='%s' alt=' ' class='v-middle'/>&nbsp;%s&nbsp;</span><input value='%s' id='emails'/>&nbsp;<button id='report_send_button' title='%s' type='button' class='scalable task' onclick='sendReportsViaEmail()'><span><span><span>%s</span></span></span></button>",
            $this->getSkinUrl('images/fam_newspaper_go.gif'),
            $helper->__('Send email to:'),
            Mage::getStoreConfig('iwd_settlementreport/emailing/to_emails'),
            $helper->__('Send'),
            $helper->__('Send')
        );

        $from = Mage::getSingleton('adminhtml/session')->getData("iwd_settlementreport_filter_from");
        $to = Mage::getSingleton('adminhtml/session')->getData("iwd_settlementreport_filter_to");

        return
        '<script type="text/javascript">
            if(typeof(jQueryIWD) == "undefined"){if(typeof(jQuery) != "undefined") {jQueryIWD = jQuery;}} $ji = jQueryIWD;

            $ji(document).ready(function () {
                updateHeader();
                addSendExport();
                updateFilter();
            });

            function showLoadingMask(){
                $ji("#loading-mask").width($ji("html").width()).height($ji("html").height()).css("top", 0).css("left", -2).show();
            }

            function updateFilter()
            {
                $ji("input[name=\'created_at[from]\']").val("'.$from.'");
                $ji("input[name=\'created_at[to]\']").val("'.$to.'");
            }

            function sendReportsViaEmail(){
                var email = $ji("#emails").val().trim();
                if(email.length > 5){
                    showLoadingMask();
                    var url = "' . $this->getUrl('*/*/sendreport') . '";
                    setLocation(url + "?email=" + $ji("#emails").val());
                } else {
                    alert("'.Mage::helper('iwd_ordermanager')->__('Please, enter email(s)').'");
                }
            }

            function updateHeader()
            {
                var head = document.getElementById("iwd_settlementreport_transactions_grid_table").tHead;
                var row = head.insertRow(0);
                row.className = "headings_colspan";

                var cell_id = row.insertCell(0);
                cell_id.innerHTML = "";
                cell_id.className = "empty_cell";

                var cell_order_id = row.insertCell(1);
                cell_order_id.innerHTML = "";
                cell_order_id.className = "empty_cell";

                var cell_status = row.insertCell(2);
                cell_status.innerHTML = "";
                cell_status.className = "empty_cell";

                var cell_date = row.insertCell(3);
                cell_date.innerHTML = "";
                cell_date.className = "empty_cell";

                var cell_trx_status = row.insertCell(4);
                cell_trx_status.innerHTML = "'.$helper->__("Status").'";
                cell_trx_status.colSpan  = "2";

                var cell_auth = row.insertCell(5);
                cell_auth.innerHTML = "'.$helper->__("Authorized").'";
                cell_auth.colSpan  = "2";

                var cell_captured = row.insertCell(6);
                cell_captured.innerHTML = "'.$helper->__("Captured").'";
                cell_captured.colSpan  = "2";

                var cell_settlement = row.insertCell(7);
                cell_settlement.innerHTML = "'.$helper->__("Settled").'";
                cell_settlement.colSpan  = "2";

                var cell_refund = row.insertCell(8);
                cell_refund.innerHTML = "'.$helper->__("Refunded").'";
                cell_refund.colSpan  = "2";
                cell_refund.className = "last";
            }

            function addSendExport()
            {
                $ji("' . $notify_form . '").insertAfter("#iwd_settlementreport_transactions_grid .actions tbody .pager");
            }
        </script>';
    }
}
