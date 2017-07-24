<?php

class IWD_OrderManager_Block_Adminhtml_Flags_Types_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('orderManagerFlagsTypes');
        $this->_blockGroup = 'iwd_ordermanager';
        $this->_controller = 'adminhtml_flags_types';

        $this->setDefaultSort('id');
        $this->setDefaultDir('DESC');
        $this->setUseAjax(true);
    }

    /**
     * @return Mage_Adminhtml_Block_Widget_Grid
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('iwd_ordermanager/flags_types')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * @return $this
     * @throws Exception
     */
    protected function _prepareColumns()
    {
        $helper = Mage::helper('iwd_ordermanager');

        $this->addColumn('id', array(
            'header' => $helper->__('ID'),
            'align' => 'right',
            'width' => '50px',
            'index' => 'id',
            'filter_index' => 'id',
            'type' => 'number',
            'sortable' => true
        ));

        $this->addColumn('name', array(
            'header' => $helper->__('Name'),
            'align' => 'left',
            'index' => 'name',
            'type' => 'text',
            'filter_index' => 'name',
            'width' => '200px',
            'sortable' => true
        ));

        $this->addColumn('comment', array(
            'header' => $helper->__('Comment'),
            'align' => 'left',
            'index' => 'comment',
            'type' => 'text',
            'filter_index' => 'comment',
            'sortable' => true
        ));

        $this->addColumn('action',
            array(
                'header' => $helper->__('Action'),
                'width' => '120',
                'type' => 'action',
                'getter' => 'getId',
                'actions' => array(
                    array(
                        'caption' => $helper->__('Edit'),
                        'url' => array(
                            'base' => '*/flags_types/edit',
                        ),
                        'field' => 'id'
                    )
                ),
                'column_css_class' => 'select-confirm-action',
                'filter' => false,
                'sortable' => false,
                'index' => 'stores',
            )
        );

        return parent::_prepareColumns();
    }

    /**
     * @return $this
     */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('id');
        $this->getMassactionBlock()->setFormFieldName('id');

        $this->getMassactionBlock()->addItem('delete', array(
            'label' => Mage::helper('iwd_ordermanager')->__('Delete'),
            'url' => $this->getUrl('*/*/massDelete'),
            'confirm' => Mage::helper('iwd_ordermanager')->__('Are you sure?')
        ));

        return $this;
    }

    /**
     * @param $row
     * @return string
     */
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

    /**
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current' => true));
    }
}
