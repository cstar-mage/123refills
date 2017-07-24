<?php

/**
 * Class IWD_OrderManager_Model_System_Config_Backend_Settlementreport_Cron
 */
class IWD_OrderManager_Model_System_Config_Backend_Settlementreport_Cron extends Mage_Core_Model_Config_Data
{
    /**
     * Config xml pth
     */
    const CRON_STRING_PATH = 'crontab/jobs/iwd_settlementreport_email_report/schedule/cron_expr';

    /**
     * {@inheritdoc}
     */
    protected function _afterSave()
    {
        $enabled = $this->getData('groups/emailing/fields/enable/value');
        $time = $this->getData('groups/emailing/fields/start_time/value');

        $cron_expr = ($enabled) ? sprintf("%s %s * * *", intval($time[1]), intval($time[0])) : "";

        try {
            Mage::getModel('core/config_data')
                ->load(self::CRON_STRING_PATH, 'path')
                ->setValue($cron_expr)
                ->setPath(self::CRON_STRING_PATH)
                ->save();
        } catch (Exception $e) {
            Mage::throwException(Mage::helper('adminhtml')->__('Unable to save the cron expression.') . $e->getMessage());
        }
    }
}
