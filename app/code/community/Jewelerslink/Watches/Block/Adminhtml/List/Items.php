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
 * TheJewelerslink watches product grid container
 *
 * @category    Jewelerslink
 * @package     Jewelerslink_Watches
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Jewelerslink_Watches_Block_Adminhtml_List_Items extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    /**
     * Initialize grid container settings
     *
     */
    public function __construct()
    {
        $this->_blockGroup = 'watches';
        $this->_controller = 'adminhtml_list_items';
        $this->_headerText = Mage::helper('watches')->__('Select products to be exported to jewelerslink');

        parent::__construct();

        $this->_removeButton('add');
    }
}
