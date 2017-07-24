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

class Plugincompany_Cmsrevisions_Block_Adminhtml_Pagerevisions extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('page_revisions_grid');
        $this->setDefaultSort('page_revision_id');
        $this->setUseAjax(true);
        $this->setTemplate('plugincompany/cmsrevisions/grid.phtml');
    }


    /**
     * Prepare CMS Page collection
     *
     * @return Mage_Adminhtml_Block_Widget_Grid
     */
    protected function _prepareCollection()
    {
        $pageId = Mage::app()->getRequest()->getParam('page_id');
        $collection = Mage::getModel('plugincompany_cmsrevisions/page')->getCollection();
        $collection->addFieldToFilter('page_id',$pageId);

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

        $this->addColumn('page_revision_id', array(
            'header'    => Mage::helper('catalog')->__('ID'),
            'sortable'  => true,
            'width'     => 60,
            'index'     => 'plugincompany_cms_page_id'
        ));

        $this->addColumn('cmsrevisions_is_current_revision', array(
            'header'    => Mage::helper('catalog')->__('Current'),
            'sortable'  => true,
            'width'     => '20px',
            'index'     => 'is_current_revision',
            'type'      => 'options',
            'options'   => array('no','yes')
        ));

        $this->addColumn('page_revision_date', array(
            'header'    => Mage::helper('catalog')->__('Update Date'),
            'width'     => 100,
            'index'     => 'revision_created_on',
            'type'      => 'date',
        ));


        $this->addColumn('page_username', array(
            'header'    => Mage::helper('catalog')->__('Update by'),
            'sortable'  => true,
            'width'     => '100px',
            'index'     => 'username'
        ));

        $this->addColumn('page_title', array(
            'header'    => Mage::helper('catalog')->__('Page Title'),
            'sortable'  => true,
            'index'     => 'title'
        ));

        $this->addColumn('page_content_heading', array(
            'header'    => Mage::helper('catalog')->__('Content Heading'),
            'sortable'  => true,
            'index'     => 'content_heading'
        ));


        $this->addColumn('page_url_key', array(
            'header'    => Mage::helper('catalog')->__('Url Identifier'),
            'sortable'  => true,
            'index'     => 'identifier'
        ));


        $this->addColumn('page_action',array(
                'header'    => Mage::helper('sales')->__('Preview revision in store'),
                'width'     => '190px',
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'plugincompany_cms_page_id',
                'renderer'  => 'Plugincompany_Cmsrevisions_Block_Adminhtml_Pagerevisions_Popuplink'
            )
        );

        $this->addColumn('page_restore',array(
                'header'    => Mage::helper('sales')->__('Restore'),
                'width'     => '60px',
                'filter'    => false,
                'sortable'  => false,
                'align'     => 'center',
                'index'     => 'plugincompany_cms_page_id',
                'renderer'  => 'Plugincompany_Cmsrevisions_Block_Adminhtml_Pagerevisions_Restore'
            )
        );

        $this->addColumn('page_delete',array(
                'header'    => Mage::helper('sales')->__('Delete'),
                'width'     => '60px',
                'filter'    => false,
                'sortable'  => false,
                'align'     => 'center',
                'index'     => 'plugincompany_cms_page_id',
                'renderer'  => 'Plugincompany_Cmsrevisions_Block_Adminhtml_Pagerevisions_Delete'
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
        return $this->_getData('grid_url') ? $this->_getData('grid_url') : $this->getUrl('cmsrevisions/index/viewpagerevisions', array('_current'=>true));
    }

    public function getRowUrl($item)
    {
        return false;
    }
}
