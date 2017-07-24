<?php

/**
 * Class IWD_OrderManager_Model_Confirm_Options_Abstract
 */
abstract class IWD_OrderManager_Model_Confirm_Options_Abstract
{
    /**
     * @return mixed
     */
    public abstract function toOption();

    /**
     * @return array
     */
    public function toOptionArray()
    {
        $optionsArray = array();

        $options = $this->toOption();
        foreach ($options as $value => $label) {
            $optionsArray[] = array('value' => $value, 'label' => $label);
        }

        return $optionsArray;
    }
}
