<?php

/**
 * @category  ProxiBlue
 * @package   DynCatProd
 * @author    Lucas van Staden <sales@proxiblue.com.au>
 * @copyright 2016 Lucas van Staden (ProxiBlue)
 * @license   http://www.proxiblue.com.au/eula EULA
 * @link      http://www.proxiblue.com.au
 */
class ProxiBlue_DynCatProd_Block_Adminhtml_Catalog_Category_Tab_Dyncatprod
    extends Mage_Core_Block_Template
{

    /**
     * Constructor
     * */
    public function __construct()
    {
        parent::__construct();
        $this->setId('catalog_category_dyncatprod');
    }

    /**
     * Return url for our module config
     *
     * @return string
     */
    public function getConfigUrl()
    {
        return Mage::helper("adminhtml")->getUrl(
            "admin/system_config/edit/section/dyncatprod"
        );
    }


}
