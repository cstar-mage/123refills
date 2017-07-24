<?php

class ProxiBlue_DynCatProd_Block_Adminhtml_Tools_Info_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId("proxiblueInfoGrid");
        $this->setDefaultSort("id");
        $this->setDefaultDir("ASC");
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel("dyncatprod/" . Mage::registry('grid_type'))->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $resource = Mage::getSingleton('core/resource');
        $readConnection = $resource->getConnection('core_read');
        $tableName = $resource->getTableName('dyncatprod/' . Mage::registry('grid_type'));
        $columns = $readConnection->describeTable($tableName);

        foreach($columns as $column) {
            $this->addColumn(
                $column['COLUMN_NAME'], array(
                    "header" => Mage::helper("dyncatprod")->__($column['COLUMN_NAME']),
                    "align" => "right",
                    "width" => "50px",
                    "type" => $column['DATA_TYPE'],
                    "index" => $column['COLUMN_NAME'],
                )
            );

        }

        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
        return '#';
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid/view/' . Mage::registry('grid_type'), array('_current' => true));
    }

}