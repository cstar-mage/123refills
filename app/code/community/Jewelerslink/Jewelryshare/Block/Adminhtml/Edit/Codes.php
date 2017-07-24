<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    
 * @package     _storage
 * @copyright   Copyright (c) 2011 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */


/**
 * Attribute map edit codes form container block
 *
 * @category    Jewelerslink
 * @package     Jewelerslink_Jewelryshare
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Jewelerslink_Jewelryshare_Block_Adminhtml_Edit_Codes extends Mage_Adminhtml_Block_Widget_Form_Container
{
    /**
     * Initialize form container
     *
     */
    public function __construct()
    {
        $this->_blockGroup = 'jewelryshare';
        $this->_controller = 'adminhtml_edit_codes';

        parent::__construct();

        $this->_removeButton('back');
        $url = $this->getUrl('adminhtml/jewelryshare_codes_grid/saveForm', array('code_id' => $this->getRequest()->getParam('code_id')));
        $this->_updateButton('save', 'onclick', 'saveNewImportItem(\''.$url.'\')');
        $this->_updateButton('reset', 'label', 'Close');
        $this->_updateButton('reset', 'onclick', 'closeNewImportItem()');
    }

    /**
     * Return Form Header text
     *
     * @return string
     */
    public function getHeaderText()
    {
    	if( Mage::registry('codes_data') && Mage::registry('codes_data')->getId() ) {
    		return Mage::helper('jewelryshare')->__('Update attribute map');
    	} else {
    		return Mage::helper('jewelryshare')->__('Import attribute map');
    	}
    }
}
