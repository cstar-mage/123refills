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
 * */
class ProxiBlue_DynCatProd_Model_Rule_Condition_Additional_Conditions_Abstract
    extends ProxiBlue_DynCatProd_Model_Rule_Condition_Abstract
{

    /**
     * Load the given array into the object as rule data
     *
     * @param array  $arr
     * @param string $key
     *
     * @return object ProxiBlue_DynCatProd_Model_Rule_Condition_Additional_Conditions_Abstract
     */
    public function loadArray($arr, $key = 'conditions')
    {
        $this->setOperator(isset($arr['operator']) ? $arr['operator'] : false);
        $this->setWebsites(isset($arr['websites']) ? $arr['websites'] : false);
        $this->setAction(isset($arr['action']) ? $arr['action'] : false);

        parent::loadArray($arr, $key);

        return $this;
    }

    public function loadValueOptions()
    {
        $this->setValueOption(array());

        return array();
    }

    /**
     * Get this models Element Type
     *
     * @return type
     */
    public function getValueElementType()
    {
        return $this->_inputType;
    }

    /**
     * Get the renderer to use for this value type
     *
     * @return object
     */
    public function getValueElementRenderer()
    {
        return Mage::getBlockSingleton('rule/editable');
    }

    /**
     * Placed to fix backwards compatibility with magento < 1.6
     *
     * @return type
     */
    public function getValueSelectOptions()
    {
        $valueOption = $opt = array();
        if ($this->hasValueOption()) {
            $valueOption = (array)$this->getValueOption();
        }
        foreach ($valueOption as $k => $v) {
            $opt[] = array('value' => $k, 'label' => $v);
        }

        return $opt;
    }

    /**
     * Retrieve website element Instance
     * If the operator value is empty - define first available operator value as default
     *
     * @return Varien_Data_Form_Element_Select
     */
    public function getWebsiteElement()
    {
        $options = ProxiBlue_DynCatProd_Model_Rule_Condition_Product_Abstract::_websiteOptionsList();
        $firstWebsite = reset($options);
        $websites = (is_array($this->getWebsites())) ? $this->getWebsites() : array($firstWebsite['value']);
        $valueNames = array();
        foreach ($options as $option) {
            if (in_array($option['value'], $websites)) {
                $valueNames[] = $option['label'];
            }
        }
        $valueNames = (count($valueNames) > 0) ? implode(', ', $valueNames) : $firstWebsite['label'];
        $elementId = sprintf('%s__%s__websites', $this->getPrefix(), $this->getId());
        $elementName = sprintf('rule[%s][%s][websites]', $this->getPrefix(), $this->getId());
        $element = $this->getForm()->addField(
            $elementId, 'multiselect', array(
                'name'       => $elementName,
                'values'     => $options,
                'value'      => $websites,
                'value_name' => $valueNames
            )
        );
        $element->setRenderer(Mage::getBlockSingleton('rule/editable'));

        return $element;
    }

    /**
     * Retrieve action element Instance
     * If the action value is empty - define first available action value as default
     *
     * @return Varien_Data_Form_Element_Select
     */
    public function getActionElement()
    {
        $options = $this->getActionOption();
        $elementId = sprintf('%s__%s__action', $this->getPrefix(), $this->getId());
        $elementName = sprintf('rule[%s][%s][action]', $this->getPrefix(), $this->getId());
        $element = $this->getForm()->addField(
            $elementId, 'select', array(
                'name'       => $elementName,
                'values'     => $options,
                'value'      => $this->getAction(),
                'value_name' => $this->getActionName()
            )
        );
        $element->setRenderer(Mage::getBlockSingleton('rule/editable'));

        return $element;
    }

    /**
     * Placed to fix backwards compatibility with magento < 1.6
     *
     * @return type
     */
    public function getActionSelectOptions()
    {
        $valueOption = $opt = array();
        if ($this->hasActionOption()) {
            $valueOption = (array)$this->getActionOption();
        }
        foreach ($valueOption as $k => $v) {
            $opt[] = array('value' => $k, 'label' => $v);
        }

        return $opt;
    }

    public function getActionName()
    {
        $result = $this->getActionOption($this->getAction());
        if (is_array($result)) {
            $result = array_shift($result);
        }

        return $result;

    }


}
