<?php

/**
 * Renderer for editable element in rules display
 *
 * @category  ProxiBlue
 * @package   DynCatProd
 * @author    Lucas van Staden <sales@proxiblue.com.au>
 * @copyright 2016 Lucas van Staden (ProxiBlue)
 * @license   http://www.proxiblue.com.au/eula EULA
 * @link      http://www.proxiblue.com.au
 */
class ProxiBlue_DynCatProd_Block_Rule_Editable extends Mage_Rule_Block_Editable
{

    /**
     * Render element
     *
     * @param  Varien_Data_Form_Element_Abstract $element
     *
     * @see    Varien_Data_Form_Element_Renderer_Interface::render()
     * @return string
     */
    public function render(Varien_Data_Form_Element_Abstract $element)
    {
        $element->addClass('element-value-changer');
        $valueName = $element->getValueName();

        if (is_null($valueName) || '' === $valueName) {
            return '';
        }

        if ($valueName === '' || is_array($valueName)) {
            $valueName = '...';
        }

        return $this->renderForReal($element, $valueName);
    }

    /**
     * Created to simply render method and decrease
     * CyclomaticComplexity test fail
     * ref:http://phpmd.org/rules/codesize.html
     */
    public function renderForReal($element, $valueName)
    {
        if ($element->getShowAsText()) {
            $html = ' <input type="hidden" class="hidden" id="'
                . $element->getHtmlId()
                . '" name="' . $element->getName() . '" value="'
                . $element->getValue() . '"/> '
                . htmlspecialchars($valueName) . '&nbsp;';
        } else {
            $html = ' <span class="rule-param" style="'
                . $element->getStyleInject() . '" '
                . ($element->getParamId() ?
                    ' id="' . $element->getParamId() . '"' : '') . '>'
                . '<a href="javascript:void(0)" class="label">';

            $translate = Mage::getSingleton('core/translate_inline');

            $html .= $translate->isAllowed()
                ? Mage::helper('core')->escapeHtml($valueName)
                :
                Mage::helper('core')->escapeHtml(
                    Mage::helper('core/string')->truncate($valueName, 33, '...')
                );
            $html .= '</a><span class="element"> ' . $element->getElementHtml();

            if ($element->getExplicitApply()) {
                $html
                    .= ' <a href="javascript:void(0)" class="rule-param-apply">'
                    . '<img src="'
                    . $this->getSkinUrl('images/rule_component_apply.gif')
                    . '" class="v-middle" alt="'
                    . $this->__('Apply') . '" title="' . $this->__('Apply')
                    . '" /></a> ';
            }

            $html .= '</span></span>&nbsp;';
            $html .= "<script>bindSelectChange('" . $element->getId()
                . "')</script>";
        }

        return $html;
    }

}
