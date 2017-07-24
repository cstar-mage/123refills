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
class ProxiBlue_DynCatProd_Block_Adminhtml_Catalog_Category_Tab_Dyncatprod_Rules_Parent
    extends
    ProxiBlue_DynCatProd_Block_Adminhtml_Catalog_Category_Tab_Dyncatprod_Rules_Abstract
{

    protected $_htmlIdPrefix = 'window.rule_parent_';
    protected $_conditions = 'parent_conditions';
    protected $_attribute_name = 'parent_dynamic_attributes';
    protected $_render_template = 'rules/parent.phtml';
    protected $_fieldset_heading = 'Parent Category Rules:';
}
