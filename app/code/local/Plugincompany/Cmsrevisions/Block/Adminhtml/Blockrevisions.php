<?php
/**
 *
 * Created by:  Milan Simek
 * Company:     Plugin Company
 *
 * LICENSE: http://plugin.company/docs/magento-extensions/magento-extension-license-agreement
 *
 * YOU WILL ALSO FIND A PDF COPY OF THE LICENSE IN THE DOWNLOADED ZIP FILE
 *
 * FOR QUESTIONS AND SUPPORT
 * PLEASE DON'T HESITATE TO CONTACT US AT:
 *
 * SUPPORT@PLUGIN.COMPANY
 *
 */

class Plugincompany_Cmsrevisions_Block_Adminhtml_Blockrevisions extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('block_revisions_grid');
        $this->setDefaultSort('block_revision_id');
        $this->setUseAjax(true);
        $this->setTemplate('plugincompany/cmsrevisions/grid.phtml');
    }



    /**
     * Prepare CMS Block collection
     *
     * @return Mage_Adminhtml_Block_Widget_Grid
     */
    protected function _prepareCollection()
    {
        $blockId = Mage::app()->getRequest()->getParam('block_id');
        $collection = Mage::getModel('plugincompany_cmsrevisions/block')->getCollection();
        $collection->addFieldToFilter('block_id',$blockId);

        $collection->getSelect()
            ->joinLeft(
                    array('user'=> Mage::getSingleton("core/resource")->getTableName('admin_user')),
                    'main_table.admin_user_id=user.user_id',
                    array('*')
                );
        $collection->addExpressionFieldToSelect('username', new Zend_Db_Expr ("CONCAT(user.firstname,' ',user.lastname)"),'');

        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * Add columns to grid
     *
     * @return Mage_Adminhtml_Block_Widget_Grid
     */
    protected function _prepareColumns()
    {

        $this->addColumn('block_revision_id', array(
            'header'    => Mage::helper('catalog')->__('ID'),
            'sortable'  => true,
            'width'     => 60,
            'index'     => 'plugincompany_cms_block_id'
        ));


        $this->addColumn('cmsrevisions_is_current_revision', array(
            'header'    => Mage::helper('catalog')->__('Current revision'),
            'sortable'  => true,
            'width'     => 60,
            'index'     => 'is_current_revision',
            'type'      => 'options',
            'options'   => array('no','yes')
        ));


        $this->addColumn('block_revision_date', array(
            'header'    => Mage::helper('catalog')->__('Update Date'),
            'width'     => 100,
            'index'     => 'revision_created_on',
            'type'      => 'date',
        ));


        $this->addColumn('block_username', array(
            'header'    => Mage::helper('catalog')->__('Update by'),
            'sortable'  => true,
            'width'     => 60,
            'index'     => 'username'
        ));

        $this->addColumn('block_title', array(
            'header'    => Mage::helper('catalog')->__('Block Title'),
            'sortable'  => true,
            'index'     => 'title'
        ));

        $this->addColumn('block_identifier', array(
            'header'    => Mage::helper('catalog')->__('Identifier'),
            'sortable'  => true,
            'index'     => 'identifier'
        ));

        $this->addColumn('block_action',array(
                'header'    => Mage::helper('sales')->__('Load in editor'),
                'width'     => '124px',
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'plugincompany_cms_block_id',
                'renderer'  => 'Plugincompany_Cmsrevisions_Block_Adminhtml_Blockrevisions_Popuplink',
                'align'     => 'center'
            )
        );

        $this->addColumn('block_restore',array(
                'header'    => Mage::helper('sales')->__('Restore'),
                'width'     => '90px',
                'filter'    => false,
                'sortable'  => false,
                'align'     => 'center',
                'index'     => 'plugincompany_cms_block_id',
                'renderer'  => 'Plugincompany_Cmsrevisions_Block_Adminhtml_Blockrevisions_Restore'
            )
        );

        $this->addColumn('block_delete',array(
                'header'    => Mage::helper('sales')->__('Delete'),
                'width'     => '90px',
                'filter'    => false,
                'sortable'  => false,
                'align'     => 'center',
                'index'     => 'plugincompany_cms_block_id',
                'renderer'  => 'Plugincompany_Cmsrevisions_Block_Adminhtml_Blockrevisions_Delete'
            )
        );


        return parent::_prepareColumns();
    }

    /**
     * Rerieve grid URL
     *
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getUrl('cmsrevisions/index/viewblockrevisions', array('_current'=>true));
    }

    public function getRowUrl($item)
    {
        return false;
    }


}