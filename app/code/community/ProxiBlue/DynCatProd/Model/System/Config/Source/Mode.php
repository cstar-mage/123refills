<?php
/**
 * List of  tab modes
 *
 * @category  ProxiBlue
 * @package   DynCatProd
 * @author    Lucas van Staden <sales@proxiblue.com.au>
 * @copyright 2016 Lucas van Staden (ProxiBlue)
 * @license   http://www.proxiblue.com.au/eula EULA
 * @link      http://www.proxiblue.com.au
 */
class ProxiBlue_DynCatProd_Model_System_Config_Source_Mode
{
    const TAB_MODE_MERGED = 1;
    const TAB_MODE_STANDALONE = 0;

    public function toOptionArray()
    {
        return array(
            array('value'=>self::TAB_MODE_MERGED, 'label'=>Mage::helper('sitemap')->__('Merged')),
            array('value'=>self::TAB_MODE_STANDALONE, 'label'=>Mage::helper('sitemap')->__('Standalone')),
        );
    }
}
