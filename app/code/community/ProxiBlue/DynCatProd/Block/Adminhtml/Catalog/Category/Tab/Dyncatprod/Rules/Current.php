<?php

/**
 * Tab in admin category
 *
 * @category  ProxiBlue
 * @package   DynCatProd
 * @author    Lucas van Staden <sales@proxiblue.com.au>
 * @copyright 2016 Lucas van Staden (ProxiBlue)
 * @license   http://www.proxiblue.com.au/eula EULA
 * @link      http://www.proxiblue.com.au
 */
class ProxiBlue_DynCatProd_Block_Adminhtml_Catalog_Category_Tab_Dyncatprod_Rules_Current
    extends
    ProxiBlue_DynCatProd_Block_Adminhtml_Catalog_Category_Tab_Dyncatprod_Rules_Abstract
{
    protected $_htmlIdPrefix = 'window.rule_';
    protected $_conditions = 'conditions';
    protected $_attribute_name = 'dynamic_attributes';
    protected $_render_template = 'rules/current.phtml';
    protected $_fieldset_heading = 'Dynamically assign products to this category:';


}
