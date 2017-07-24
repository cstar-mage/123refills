<?php

class IWD_OrderManager_Block_Adminhtml_Flags_Flags_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('orderManagerFlagsFlags');
        $this->_blockGroup = 'iwd_ordermanager';
        $this->_controller = 'adminhtml_flags_flags';

        $this->setDefaultSort('id');
        $this->setDefaultDir('DESC');
        $this->setUseAjax(true);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('iwd_ordermanager/flags_flags')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

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

        $this->addColumn('icon', array(
            'header' => $helper->__('Icon'),
            'align' => 'center',
            'type' => 'text',
            'filter' => false,
            'sortable' => false,
            'width' => '120px',
            'renderer' => new IWD_OrderManager_Block_Adminhtml_Flags_Flags_Renderer_Icon()
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
                            'base' => '*/flags_flags/edit',
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

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current' => true));
    }
}
