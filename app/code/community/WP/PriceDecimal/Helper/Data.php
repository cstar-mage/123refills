<?php

class WP_PriceDecimal_Helper_Data extends Mage_Core_Helper_Abstract
{
    public static function getParams()
    {
        $backtrace      = Varien_Debug::backtrace(true, false);
        $config         = Mage::getStoreConfig('price_decimal/general');
        $moduleName     = Mage::app()->getRequest()->getModuleName();
        $id             = Mage::app()->getRequest()->getParam('id', '');

        $skeep          = !$config['enabled'];

        if ($config['exclude_product_options']) {
            if (strpos($backtrace, 'Mage_Bundle_Block_Catalog_Product_View_Type_Bundle_Option_Radio') !== false
                || strpos($backtrace, 'Mage_Bundle_Block_Catalog_Product_View_Type_Bundle_Option_Checkbox') !== false
                || strpos($backtrace, 'Mage_Bundle_Block_Catalog_Product_View_Type_Bundle_Option_Multi') !== false
                || strpos($backtrace, 'Mage_Bundle_Block_Catalog_Product_View_Type_Bundle_Option_Select') !== false) $skeep = true;
        }

        if ($moduleName == 'checkout' && $config['exclude_cart'] && !$id) $skeep = true;
        if ($moduleName == 'admin') $skeep = true; // --- skeep if backand

        $precision = 0;
        if (isset($config['precision']) && ($config['precision'] + 0) >= 0)
            $precision = $config['precision'] + 0;

        return array(
            'skeep'     => $skeep,
            'precision' => $precision,
        );
    }

    public static function trimZeroRight($price, $precision)
    {
        if (!Mage::getStoreConfig('price_decimal/general/trim_zero_right')) return $precision;
        $xPrice = Zend_Locale_Math::normalize(Zend_Locale_Math::round($price, $precision));
        $xPrice = sprintf("%." . $precision . "F", $xPrice);
        //Mage::log($xPrice);
        $decimal = strrchr($xPrice, '.');
        $c1 = strlen($decimal);
        $decimal = rtrim($decimal, '0');
        $c2 = strlen($decimal);
        $xPrecision = $precision - ($c1 - $c2);
        return $xPrecision;
    }
}
