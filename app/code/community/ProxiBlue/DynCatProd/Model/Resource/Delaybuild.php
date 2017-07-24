<?php

/**
 *
 *
 * @category  ProxiBlue
 * @package   DynCatProd
 * @author    Lucas van Staden <sales@proxiblue.com.au>
 * @copyright 2016 Lucas van Staden (ProxiBlue)
 * @license   http://www.proxiblue.com.au/eula EULA
 * @link      http://www.proxiblue.com.au
 */
class ProxiBlue_DynCatProd_Model_Resource_Delaybuild
    extends Mage_Core_Model_Mysql4_Abstract
{

    public function _construct()
    {
        $this->_init('dyncatprod/delaybuild', 'rebuild_id');
    }

}
