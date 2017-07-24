<?php

/**
 * Abstract Rule product condition data model - does not exist in magento prior
 * to 1.7 / 1.12
 *
 * @category  ProxiBlue
 * @package   DynCatProd
 * @author    Lucas van Staden <sales@proxiblue.com.au>
 * @copyright 2016 Lucas van Staden (ProxiBlue)
 * @license   http://www.proxiblue.com.au/eula EULA
 * @link      http://www.proxiblue.com.au
 */
class ProxiBlue_DynCatProd_Model_Rule_Condition_Abstract
    extends Mage_Rule_Model_Condition_Abstract
{

    /**
     * Internal cached helper object
     *
     * @var object
     */
    protected $_helper = null;

    /**
     * Attribute data key that indicates whether it should be used for rules
     *
     * @var string
     */
    protected $_isUsedForRuleProperty = 'is_used_for_promo_rules';
    protected $_operatorMap
        = array(
            '=='  => 'eq',
            '!='  => 'neq',
            '>='  => 'gteq',
            '<='  => 'lteq',
            '>'   => 'gt',
            '<'   => 'lt',
            '{}'  => 'in',
            '!{}' => 'nin',
            '()'  => 'finset',
            '!()' => 'nfinset',
            '!!'  => 'inrange',
            '!!!' => 'ninrange',
            '<D'  => 'xdaysago',
            '==|' => 'eq',
            '!=|' => 'neq',
        );
    protected $_operatorMapToSql
        = array(
            '=='  => '=',
            '!='  => '!=',
            '>='  => '>=',
            '<='  => '<=',
            '>'   => '>',
            '<'   => '<',
            '{}'  => 'in',
            '!{}' => 'not in',
            '()'  => 'finset',
            '!()' => 'nfinset',
            '==|' => '=',
            '!=|' => '!='
        );

    public function getHelper()
    {
        if ($this->_helper == null) {
            $this->_helper = mage::helper('dyncatprod');
        }

        return $this->_helper;
    }

    /**
     * validate wrapper
     * Deals globally with the need to set delayed processing (depricated from
     * v3)
     *
     * @param  Varien_Object $object Quote
     *
     * @return boolean
     */
    public function validate(Varien_Object $object)
    {
        return $this->_validate($object);
    }

    /**
     * Build the tooltip html block
     *
     * @return string
     */
    public function getHelpHtml()
    {
        $helpBlock = Mage::app()->getLayout()
            ->createBlock(
                'dyncatprod/adminhtml_help',
                'dyncatprod.help' . $this->getInputType()
            );
        $helpBlock->setInputType($this->getInputType());

        return $helpBlock->toHtml();
    }

    public function asStringRecursive($level = 0)
    {
        if ($level > 1) {
            $str
                = "\n" .
                str_pad('', $level, '=', STR_PAD_LEFT) . ">&nbsp;"
                . $this->asString();
        } else {
            $str = $this->asString();
        }

        return $str;

    }

}
