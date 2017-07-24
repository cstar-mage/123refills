<?php

/**
 *  Dynamic Products rule
 *
 * @category  ProxiBlue
 * @package   DynCatProd
 * @author    Lucas van Staden <sales@proxiblue.com.au>
 * @copyright 2016 Lucas van Staden (ProxiBlue)
 * @license   http://www.proxiblue.com.au/eula EULA
 * @link      http://www.proxiblue.com.au
 */
class ProxiBlue_DynCatProd_Model_Rule extends ProxiBlue_DynCatProd_Model_Compatibility_Rule_Abstract
{


    const BY_PERCENT_ACTION = 'by_percent';
    const BY_FIXED_ACTION   = 'by_fixed';
    const TO_PERCENT_ACTION = 'to_percent';
    const TO_FIXED_ACTION   = 'to_fixed';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'dyncatprod_rule';

    /**
     * Parameter name in event
     *
     * In observe method you can use $observer->getEvent()->getRule() in this case
     *
     * @var string
     */
    protected $_eventObject = 'dyncatprodRule';

    /**
     * Conditions prefix
     *
     * @var null
     */
    protected $_prefix = null;


    /**
     * Constructor with parameters
     *
     * @param array $args
     */
    public function __construct(array $args = array())
    {
        if (!empty($args['prefix'])) {
            $this->_prefix = $args['prefix'];
        }
        $this->_init('dyncatprod/rule');
        $this->setIdFieldName('rule_id');
        parent::__construct();
    }


    /**
     * Get rule condition combine model instance
     *
     * @return object ProxiBlue_DynCatProd_Model_Rule_Condition_Combine
     */
    public function getConditionsInstance()
    {
        if (!empty($this->_prefix)) {
            $conditionsModel = Mage::getModel(
                'dyncatprod/rule_condition_combine',
                array('prefix' => $this->_prefix)
            );
        } else {
            $conditionsModel = Mage::getModel(
                'dyncatprod/rule_condition_combine'
            );
        }

        return $conditionsModel;
    }



    /**
     * Wrapper loadPost introduced in v3 to accommodate ability to
     * refactor rules to new format used in v3
     *
     * @param array  $data     Holds conditions in key called conditions
     * @param object $category The active category
     *
     * @return void
     */
    public function preLoadPost(array $data, $category)
    {
        $key = $this->_prefix ? $this->_prefix : 'conditions';
        $conditions = array();
        if (array_key_exists($key, $data)
            && is_string(
                $data[$key]
            )
        ) {
            try {
                $conditions = unserialize($data[$key]);
            } catch (Exception $e) {
                mage::logException($e);
            }
        }
        $conditions = $this->_convertLegacyRule($conditions, $category);

        $this->loadPost($conditions);
    }

    /**
     * Convert Pre v3 rules to v3 rules layout
     *
     * @param array  $value    The value of the rule
     * @param object $category The active category
     *
     * @return array
     */
    private function _convertLegacyRule($value, $category)
    {
        $arr = array();
        if (is_array($value)) {
            foreach ($value as $ruleKey => $ruleData) {
                $path = explode('--', $ruleKey);
                if (count($path) == 1) {
                    // this is a rule container, so what is it?
                    if (array_key_exists('type', $ruleData)) {
                        switch ($ruleData['type']) {
                            case "dyncatprod/rule_condition_product_found":
                                //ok, this should not be rule container 1, it is a legacy rule.
                                // convert it by injecting the combine comtainer as 1, and shift all
                                // rules by 1.
                                $arr['1'] = array('new_child'  => '',
                                                  'value'      => true,
                                                  'aggregator' => 'all',
                                                  'type'       => 'dyncatprod/rule_condition_combine'
                                );
                                // shift all rules
                                $splitout = 2;
                                foreach (
                                    $value as $shiftRuleKey => $shiftRuleData
                                ) {
                                    // split out legacy rules to new layers
                                    switch ($shiftRuleData['type']) {
                                        case "dyncatprod/rule_condition_additional_conditions_limiter":
                                            $arr['1--' . $splitout]
                                                = $shiftRuleData;
                                            $splitout++;
                                            break;
                                        case "dyncatprod/rule_condition_additional_conditions_transformations":
                                            $arr['1--' . $splitout]
                                                = array('new_child'  => '',
                                                        'value'      => true,
                                                        'aggregator' => 'all',
                                                        'type'       => 'dyncatprod/rule_condition_additional_conditions_transformations'
                                            );
                                            $arr['1--' . $splitout . '--1']
                                                = array(
                                                'value'    => $shiftRuleData['value'],
                                                'operator' => $shiftRuleData['operator'],
                                                'type'     => 'dyncatprod/rule_condition_additional_conditions_transformations_parents'
                                            );
                                        default:
                                            if ($shiftRuleData['type']
                                                != "dyncatprod/rule_condition_additional_conditions_transformations"
                                            ) {
                                                $arr['1--' . $shiftRuleKey]
                                                    = $shiftRuleData;
                                            }
                                            break;
                                    }
                                }
                                break;
                        }
                    }
                }
            }
        }
        if (count($arr) > 0) {
            $category->setDynamicAttributes(serialize($arr));
            try {
                $category->save();
            } catch (Exception $ex) {
                mage::logException($ex);
            }
            mage::log(
                'DYNCATPROD: Category ' . $category->getId()
                . ' rules were updated to new format'
            );

            return $arr;
        }

        return $value;
    }

    /**
     * Merge all the combined ruls to one ruleset.
     *
     * @param array  $value
     * @param object $category
     */

    public function mergeAndLoad($value, $category)
    {
        $arr = array();
        if (is_array($value)) {
            $haveContainer = false;
            $extra = 0;
            foreach ($value as $setKey => $ruleSet) {
                foreach ($ruleSet as $ruleKey => $ruleData) {
                    $path = explode('--', $ruleKey);
                    if (count($path) == 1 && $haveContainer == false) {
                        // this is a rule container,
                        // we only want one, so flag we got it
                        $haveContainer = true;
                        $arr["1"] = $ruleData;
                        continue;
                    }
                    if (count($path) == 1 && $haveContainer == true) {
                        continue;
                    }
                    $path[1] = $setKey + $path[1] + $extra;
                    $newRuleKey = implode('--', $path);
                    while (array_key_exists($newRuleKey, $arr)) {
                        $extra++;
                        $path[1]++;
                        $newRuleKey = implode('--', $path);
                    }
                    $arr[$newRuleKey] = $ruleData;
                }
            }
        }
        $conditions = $this->_convertLegacyRule($arr, $category);
        $this->loadPost($conditions);
    }


    /**
     * we don't really save, we just want the object with the data ready to save
     * which is then stored in the catgeory attribute dyncatprod_attributes
     *
     * @return \ProxiBlue_DynCatProd_Model_Rule
     */
    public function save()
    {
        return $this;
    }


}
