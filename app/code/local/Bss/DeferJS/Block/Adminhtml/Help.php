<?php
/**
* BSS Commerce Co.
*
* NOTICE OF LICENSE
*
* This source file is subject to the EULA
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://bsscommerce.com/Bss-Commerce-License.txt
*
* =================================================================
*                 MAGENTO EDITION USAGE NOTICE
* =================================================================
* This package designed for Magento COMMUNITY edition
* BSS Commerce does not guarantee correct work of this extension
* on any other Magento edition except Magento COMMUNITY edition.
* BSS Commerce does not provide extension support in case of
* incorrect edition usage.
* =================================================================
*
* @category   BSS
* @package    Bss_DeferJS
* @author     Extension Team
* @copyright  Copyright (c) 2014-2105 BSS Commerce Co. ( http://bsscommerce.com )
* @license    http://bsscommerce.com/Bss-Commerce-License.txt
*/
class Bss_DeferJS_Block_Adminhtml_Help extends Mage_Adminhtml_Block_System_Config_Form_Fieldset
{
    public function render(Varien_Data_Form_Element_Abstract $element)
    {
        $html = '<tr id="row_deferjs_general_help">
        <td class="label">
        <label for="deferjs_general_help"> Help exclude javascript</label>
        </td>
        <td class="value">
            <p>- Add attribute <span style="font-weight:bold;color:red">nodefer</span> after <span style="font-weight:bold;color:red">&lt;script</span> for prevent defer.</p>
            <p>- Example:</p>
            <i>From: &lt;script type="text/javascript"&gt;...&lt;/script&gt;</i><br />
            <i>To: &lt;script nodefer type="text/javascript"&gt;...&lt;/script&gt;</i>
        </td>
    </tr>';

    return $html;
}
}