<?php

class ProxiBlue_DynCatProd_Model_Adminhtml_Grid_Columns
{

    private $_grid;
    private $_collection;


    /**
     * Adjust the products grid.
     *
     * @param Varien_Event_Observer $observer
     *
     * @return $this
     */
    public function adminhtml_block_html_before(Varien_Event_Observer $observer)
    {

        try {
            $event = $observer->getEvent();
            if ($event->getBlock() instanceof
                Mage_Adminhtml_Block_Catalog_Category_Tab_Product
            ) {
                $this->_grid = $event->getBlock();
                $this->_collection = $this->_grid->getCollection();
                $this->_collection->clear();

                $this->_collection->addAttributeToSelect('image');

                $select = $this->_collection->getSelect();
                $columns = $select->getPart(Zend_Db_Select::COLUMNS);
                $select->reset(Zend_Db_Select::COLUMNS);
                $columnName = mage::helper('dyncatprod')->getColumnName($columns,'position');
                $columns[] = array(
                    $columnName,
                    'is_dynamic',
                    'is_dynamic');
                $select->setPart(
                    Zend_Db_Select::COLUMNS,
                    $columns
                );

                $this->_grid->addColumn(
                    'is_dynamic',
                    array(
                        'header'         => Mage::helper('catalog')->__('Dynamic'),
                        'index'          => 'is_dynamic',
                        'frame_callback' => array(
                            $this,
                            'catalog_product_grid_callback_method_dynamic'),
                        'align'          => "center",
                        'filter'         => false,
                        'width'          => '50px',
                    )
                );

                // force a reload of the collection
                $this->_collection->load();
            }
        } catch (Exception $e) {
            mage::logException($e);
        }

        return $this;
    }

    /**
     * Callback for the grid data.
     * Use this to try and populate any data that is not available.
     *
     * @param  string $value
     * @param  array  $row
     * @param  array  $column
     * @param  bool   $isExport
     *
     * @return string
     */
    public function catalog_product_grid_callback_method_dynamic(
        $value, $row, $column, $isExport
    ) {

        if ($value == 1) {
            $path = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN);
            $value = '<img src="' . $path . 'adminhtml/default/default/images/rule_component_apply.gif"/>';
        } else {
            $value = '';
        }

        return $value;
    }

}
