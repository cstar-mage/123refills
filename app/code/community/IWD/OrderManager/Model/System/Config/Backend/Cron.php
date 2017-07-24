<?php

/**
 * Class IWD_OrderManager_Model_System_Config_Backend_Cron
 */
class IWD_OrderManager_Model_System_Config_Backend_Cron extends Mage_Core_Model_Config_Data
{
    /**
     * Config xml path
     */
    const CRON_STRING_PATH = 'crontab/jobs/iwd_archive_orders/schedule/cron_expr';

    /**
     * {@inheritdoc}
     */
    protected function _afterSave()
    {
        if (Mage::helper('iwd_ordermanager')->isEnterpriseMagentoEdition()) {
            return $this;
        }

        $enabled = $this->getData('groups/archive/fields/auto_archive_enable/value');
        $time = $this->getData('groups/archive/fields/auto_archive_start_time/value');
        $frequncy = $this->getData('groups/archive/fields/auto_archive_frequency/value');

        $frequencyWeekly = Mage_Adminhtml_Model_System_Config_Source_Cron_Frequency::CRON_WEEKLY;
        $frequencyMonthly = Mage_Adminhtml_Model_System_Config_Source_Cron_Frequency::CRON_MONTHLY;

        if ($enabled) {
            $day = ($frequncy == $frequencyMonthly) ? '1' : '*';
            $week = ($frequncy == $frequencyWeekly) ? '1' : '*';
            $cronExprArray = array(
                (int)($time[1]), # Minute
                (int)($time[0]), # Hour
                $day,             # Day of the Month
                '*',              # Month of the Year
                $week,            # Day of the Week
            );
            $cronExprString = join(' ', $cronExprArray);
        } else {
            $cronExprString = '';
        }

        try {
            Mage::getModel('core/config_data')
                ->load(self::CRON_STRING_PATH, 'path')
                ->setValue($cronExprString)
                ->setPath(self::CRON_STRING_PATH)
                ->save();
        } catch (Exception $e) {
            IWD_OrderManager_Model_Logger::log($e->getMessage());
            Mage::throwException(Mage::helper('adminhtml')->__('Unable to save the cron expression.'));
        }

        return $this;

    }
}
