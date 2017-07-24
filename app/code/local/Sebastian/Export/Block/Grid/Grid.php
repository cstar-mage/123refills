<?php

/**
 *
 * Copyright Sebastian Enzinger <sebastian@enzinger.de> www.sebastian-enzinger.de
 *
 * All rights reserved.
 *
**/

class Sebastian_Export_Block_Grid_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('exportGrid');
        $this->setDefaultSort('id');
        $this->setDefaultDir('desc');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
        $this->setVarNameFilter('export_filter');

    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('export/export')->getCollection();

        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _addColumnFilterToCollection($column)
    {
        //nothing more yet
        return parent::_addColumnFilterToCollection($column);
    }

    protected function _prepareColumns()
    {
        $this->addColumn('id',
            array(
                'header'=> Mage::helper('export')->__('ID'),
                'width' => '50px',
                'type'  => 'number',
                'index' => 'export_id'
        ));

        $this->addColumn('displayfiles',
            array(
                'header'=> Mage::helper('export')->__('Files'),
                'index' => 'displayfiles',
                'width' => '175px',
        ));

        $this->addColumn('type',
            array(
                'header'=> Mage::helper('export')->__('Type'),
                'width' => '50px',
                'index' => 'type'
        ));

        $this->addColumn('count',
            array(
                'header'=> Mage::helper('export')->__('Order Count'),
                'width' => '20px',
                'index' => 'count'
        ));


        $this->addColumn('ftpupload',
            array(
                'header'=> Mage::helper('export')->__('FTP-Upload'),
                'width' => '20px',
                'index' => 'ftpupload',
                'align' => 'center',
                'type' => 'options',
                'options' => array(
                    0 => Mage::helper('export')->__('No'),
                    1 => Mage::helper('export')->__('Done'),
                    2 => Mage::helper('export')->__('Failed')
                ),
                'renderer' => 'Sebastian_Export_Block_Grid_FtpUploadRenderer'
        ));

        $this->addColumn('autoexport',
            array(
                'header'=> Mage::helper('export')->__('Auto-Export'),
                'width' => '20px',
                'index' => 'autoexport',
                'align' => 'center',
                'type' => 'options',
                'options' => array(
                    0 => Mage::helper('export')->__('No'),
                    1 => Mage::helper('export')->__('Yes'),
                ),
                'renderer' => 'Sebastian_Export_Block_Grid_AutoExportRenderer'
        ));

        $this->addColumn('downloaded',
            array(
                'header'=> Mage::helper('export')->__('Downloaded'),
                'width' => '10px',
                'index' => 'downloaded',
                'align' => 'center',
                'type' => 'options',
                'options' => array(
                    0 => Mage::helper('export')->__('No'),
                    1 => Mage::helper('export')->__('Yes'),
                ),
                'renderer' => 'Sebastian_Export_Block_Grid_DownloadedRenderer'
        ));

        $this->addColumn('created',
            array(
                'header'=> Mage::helper('export')->__('Created at'),
                'width' => '60px',
                'index' => 'created',
                'type'      => 'datetime',
                'default'   => '--'
        ));

        $this->addColumn('download',
            array(
                'header'    => Mage::helper('export')->__('Download'),
                'width'     => '40px',
                'type'      => 'action',
                'getter'     => 'getId',
                'align' => 'center',
                'actions'   => array(
                    array(
                        'caption' => Mage::helper('export')->__('Download'),
                        'url'     => array(
                            'base'=>'export/index/get'
                        ),
                        'field'   => 'export_id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false
        ));

        $this->addColumn('delete',
            array(
                'header'    => Mage::helper('export')->__('Delete'),
                'width'     => '30px',
                'type'      => 'action',
                'getter'     => 'getId',
                'align' => 'center',
                'actions'   => array(
                    array(
                        'caption' => Mage::helper('export')->__('Delete'),
                        'url'     => array(
                            'base'=>'export/index/delete'
                        ),
                        'field'   => 'export_id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                //'index'     => 'export_id',
        ));

        return parent::_prepareColumns();
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('export_id');
        $this->getMassactionBlock()->setFormFieldName('export');

        $this->getMassactionBlock()->addItem('download', array(
             'label'=> Mage::helper('export')->__('Mass download'),
             'url'  => $this->getUrl('*/*/massDownload')
        ));

        $this->getMassactionBlock()->addItem('delete', array(
             'label'=> Mage::helper('export')->__('Delete'),
             'url'  => $this->getUrl('*/*/massDelete'),
             'confirm' => Mage::helper('export')->__('Are you sure?')
        ));

        return $this;
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current'=>true));
    }

    public function getRowUrl($row)
    {
        /*return $this->getUrl('/edit', array(
            'store'=>$this->getRequest()->getParam('store'),
            'id'=>$row->getId())
        );*/
    }
}