<?php

/**
 * Conditions combine for dynamic products
 * Backport code to make compatible with pre 1.6
 *
 * @category  ProxiBlue
 * @package   DynCatProd
 * @author    Lucas van Staden <sales@proxiblue.com.au>
 * @copyright 2016 Lucas van Staden (ProxiBlue)
 * @license   http://www.proxiblue.com.au/eula EULA
 * @link      http://www.proxiblue.com.au
 */
class ProxiBlue_DynCatProd_Model_Rule_Condition_Backport
    extends Mage_Rule_Model_Condition_Combine
{

    /**
     * Store all used condition models
     *
     * @var array
     */
    protected static $_conditionModels = array();
    protected $_prefix = null;

    public function __construct($args)
    {
        if (!empty($args['prefix'])) {
            $this->_prefix = $args['prefix'];
        }
        parent::__construct();
    }

    public function asStringRecursive($level = 0)
    {
        $str = $this->asString();
        foreach ($this->getConditions() as $cond) {
            $str .= $cond->asStringRecursive($level + 1) . "\n";
        }

        return $str;
    }

    public function asString($format = '')
    {
        $str = '';

        return $str;
    }

    /**
     * Get conditions, if current prefix is undefined use 'conditions' key
     *
     * @return array
     */
    public function getConditions()
    {
        $key = $this->getPrefix() ? $this->getPrefix() : 'conditions';
        $result = $this->getData($key);
        if (!is_array($result)) {
            $this->setConditions(array());
            $result = $this->getData($key);
        }

        return $result;
    }

    /**
     * Set conditions, if current prefix is undefined use 'conditions' key
     *
     * @param array $conditions
     *
     * @return Mage_Rule_Model_Condition_Combine
     */
    public function setConditions($conditions)
    {
        if (!empty($this->_prefix)) {
            $this->setPrefix($this->_prefix);
        }
        $key = $this->getPrefix() ? $this->getPrefix() : 'conditions';

        return $this->setData($key, $conditions);
    }

    public function setPrefix($value)
    {
        $this->_prefix = $value;
        $this->setData('prefix', $value);

        return $this;
    }

    /**
     * Retrieve new object for each requested model.
     * If model is requested first time, store it at static array.
     *
     * It's made by performance reasons to avoid initialization of same models
     * each time when rules are being processed.
     *
     * @param  string $modelClass
     *
     * @return Mage_Rule_Model_Condition_Abstract|bool
     */
    protected function _getNewConditionModelInstance($modelClass)
    {
        if (empty($modelClass)) {
            return false;
        }

        if (!array_key_exists($modelClass, self::$_conditionModels)) {
            $model = Mage::getModel($modelClass);
            self::$_conditionModels[$modelClass] = $model;
        } else {
            $model = self::$_conditionModels[$modelClass];
        }

        if (!$model) {
            return false;
        }

        $newModel = clone $model;

        return $newModel;
    }


}
