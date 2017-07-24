<?php

class IWD_OrderManager_Block_Adminhtml_Widget_Grid_Column_Filter_Multiselect
    extends Mage_Adminhtml_Block_Widget_Grid_Column_Filter_Select
{
    /**
     * @return string
     */
    public function getHtml()
    {
        $html = '<select name="' . $this->_getHtmlName() . '" id="' . $this->_getHtmlId() . '" class="no-changes" multiple>';
        $value = $this->getValue();

        foreach ($this->_getOptions() as $option) {
            if (isset($option['value']) && is_array($option['value'])) {
                $html .= '<optgroup label="' . $this->escapeHtml($option['label']) . '">';
                foreach ($option['value'] as $subOption) {
                    $html .= $this->_renderOption($subOption, $value);
                }
                $html .= '</optgroup>';
            } else {
                $html .= $this->_renderOption($option, $value);
            }
        }
        $html .= '</select>';
        return $html;
    }

    /**
     * @param array $option
     * @param string $value
     * @return string
     */
    protected function _renderOption($option, $value)
    {
        if (isset($option['value']) && $option['value'] !== null) {
            $value = trim($value);
            $value = (is_null($value) || $value == '') ? array() : explode(',', $value);
            $selected = ((in_array($option['value'], $value) && ($value !== null)) ? ' selected="selected"' : '');
            return '<option value="' . $this->escapeHtml($option['value']) . '"' . $selected . '>' .
                $this->escapeHtml($option['label']) . '</option>';
        }

        return '';
    }

    /**
     * @return array
     */
    protected function _getOptions()
    {
        $emptyOption = array();

        $optionGroups = $this->getColumn()->getOptionGroups();
        if ($optionGroups) {
            array_unshift($optionGroups, $emptyOption);
            return $optionGroups;
        }

        $colOptions = $this->getColumn()->getOptions();
        if (!empty($colOptions) && is_array($colOptions)) {
            $options = array($emptyOption);
            foreach ($colOptions as $value => $label) {
                $options[] = array('value' => $value, 'label' => $label);
            }
            return $options;
        }
        return array();
    }
}
