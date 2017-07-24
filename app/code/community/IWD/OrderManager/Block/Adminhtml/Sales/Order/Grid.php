<?php

class IWD_OrderManager_Block_Adminhtml_Sales_Order_Grid extends Mage_Adminhtml_Block_Sales_Order_Grid
{
    const XPATH_GRID_SAVED_LIMIT = 'iwd_ordermanager/grid_order/saved_params';
    const XPATH_IS_SAVE_GRID_PARAMS = 'iwd_ordermanager/grid_order/save_grid_params';

    protected $gridParams = null;

    public function __construct()
    {
        parent::__construct();

        $this->setDefaultGridParams();
        $this->setColumnFilters(
            array('iwd_multiselect' => 'iwd_ordermanager/adminhtml_widget_grid_column_filter_multiselect')
        )->setColumnRenderers(
            array('iwd_multiselect' => 'adminhtml/widget_grid_column_renderer_options')
        );
    }

    protected function isSaveGridParams()
    {
        return Mage::getStoreConfig(self::XPATH_IS_SAVE_GRID_PARAMS);
    }

    protected function setDefaultGridParams()
    {
        if ($this->isSaveGridParams()) {
            $limit = $this->getGirdLimit();
            $this->setDefaultLimit($limit);

            $sort = $this->getGirdSort();
            $this->setDefaultSort($sort);

            $dir = $this->getGirdDir();
            $this->setDefaultDir($dir);

            $filter = $this->getGirdFilter();
            $this->setDefaultFilter($filter);
        }
    }

    protected function saveGirdParams()
    {
        if ($this->isSaveGridParams()) {
            $params = $this->getSavedGridParams();
            $adminId = Mage::getSingleton('admin/session')->getUser()->getUserId();
            $params[$adminId]['limit'] = (int)$this->getParam($this->getVarNameLimit(), $this->_defaultLimit);
            $params[$adminId]['sort'] = $this->getParam($this->getVarNameSort(), $this->_defaultSort);
            $params[$adminId]['dir'] = $this->getParam($this->getVarNameDir(), $this->_defaultDir);
            $params[$adminId]['filter'] = $this->getParam($this->getVarNameFilter(), $this->_defaultFilter);

            Mage::getModel('core/config')->saveConfig(self::XPATH_GRID_SAVED_LIMIT, serialize($params));
        }
    }

    protected function getGirdLimit()
    {
        $params = $this->getSavedGridParams();
        $adminId = Mage::getSingleton('admin/session')->getUser()->getUserId();

        return isset($params[$adminId]['limit']) ? $params[$adminId]['limit'] : $this->_defaultLimit;
    }

    protected function getGirdSort()
    {
        $params = $this->getSavedGridParams();
        $adminId = Mage::getSingleton('admin/session')->getUser()->getUserId();

        return isset($params[$adminId]['sort']) ? $params[$adminId]['sort'] : $this->_defaultSort;
    }

    protected function getGirdDir()
    {
        $params = $this->getSavedGridParams();
        $adminId = Mage::getSingleton('admin/session')->getUser()->getUserId();

        return isset($params[$adminId]['dir']) ? $params[$adminId]['dir'] : $this->_defaultDir;
    }

    protected function getGirdFilter()
    {
        $params = $this->getSavedGridParams();
        $adminId = Mage::getSingleton('admin/session')->getUser()->getUserId();

        return isset($params[$adminId]['filter']) ? $params[$adminId]['filter'] : $this->_defaultFilter;
    }

    protected function getSavedGridParams()
    {
        if ($this->gridParams == null) {
            $params = Mage::getStoreConfig(self::XPATH_GRID_SAVED_LIMIT);
            $params = unserialize($params);
            $this->gridParams = empty($params) || !is_array($params) ? array() : $params;
        }

        return $this->gridParams;
    }

    protected function _prepareCollection()
    {
        $filter = $this->prepareFilters();

        try {
            $collection = Mage::getResourceModel("sales/order_grid_collection");
            $collection = Mage::getModel('iwd_ordermanager/order_grid')->prepareCollection($filter, $collection);

            $this->setCollection($collection);
            Mage_Adminhtml_Block_Widget_Grid::_prepareCollection();
        } catch (Exception $e) {
            Mage::log($e->getMessage());

            $session = Mage::getSingleton('adminhtml/session');
            $session->unsetData($this->getId().$this->getVarNameFilter());
            $session->unsetData($this->getId().$this->getVarNameSort());
            $this->setDefaultFilter(array());
            $this->getRequest()->setParam($this->getVarNameFilter(), null);
            $this->setDefaultSort(null);
            $this->getRequest()->setParam($this->getVarNameSort(), null);

            $collection = Mage::getResourceModel("sales/order_grid_collection");
            $collection = Mage::getModel('iwd_ordermanager/order_grid')->prepareCollection($filter, $collection);
            $this->setCollection($collection);
            Mage_Adminhtml_Block_Widget_Grid::_prepareCollection();
            Mage::getSingleton('adminhtml/session')->addError($this->__('An error occurred during filtering or sorting. Filter and sort were reset.'));
        }

        $this->saveGirdParams();

        $this->getOrderManagerTotals();

        return $this;
    }

    protected function _prepareColumns()
    {
        $selectedColumns = null;
        if (!Mage::helper("iwd_ordermanager")->enableCustomGrid()) {
            $selectedColumns = array(
                'increment_id',
                'store_id',
                'created_at',
                'billing_name',
                'shipping_name',
                'base_grand_total',
                'grand_total',
                'status',
                'action'
            );
        }

        $helper = Mage::helper('iwd_ordermanager');

        $grid = Mage::getModel('iwd_ordermanager/order_grid')->prepareColumns($this, $selectedColumns);
        $grid = Mage::getModel('iwd_ordermanager/order_grid')->addHiddenColumnWithStatus($grid);

        $grid->addRssList('rss/order/new', $helper->__('New Order RSS'));
        $grid->addExportType('*/*/exportCsv', $helper->__('CSV'));
        $grid->addExportType('*/*/exportExcel', $helper->__('Excel XML'));
        $grid->sortColumnsByOrder();

        return $grid;
    }

    protected function prepareFilters()
    {
        $filter = $this->getParam($this->getVarNameFilter(), null);

        if (is_null($filter)) {
            $filter = $this->_defaultFilter;
        }

        if (is_string($filter)) {
            $filter = $this->helper('adminhtml')->prepareFilterString($filter);
        }

        return $filter;
    }

    public function getRowUrl($row)
    {
        if (Mage::getSingleton('admin/session')->isAllowed('sales/order/actions/view')) {
            return $this->getUrl('*/sales_order/view', array('order_id' => $row->getId()));
        }

        return false;
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current' => true));
    }

    public function _toHtml()
    {
        return parent::_toHtml() . $this->getJsInitScripts();
    }

    protected function getJsInitScripts()
    {
        return $this->_getChildHtml('iwd_om.order.grid.jsinit');
    }

    public function getOrderManagerTotals()
    {
        /**
         * @var $totals IWD_OrderManager_Model_Order_Totals
         */
        $totals = Mage::getModel('iwd_ordermanager/order_totals');

        $collection = $this->getCollection();
        $totals->prepareTotals($collection);
    }
}
