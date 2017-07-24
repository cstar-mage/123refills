<?php

class Ranvi_Feed_Model_Observer
{
    protected function _isWrongTimeStamp(){
        $write = Mage::getSingleton('core/resource')->getConnection('core_write');
        $result = $write->query("SELECT vartimestamp FROM ranvi_feed WHERE id=1");
        /** @var  $result Varien_Db_Statement_Pdo_Mysql */
        $row = $result->fetchAll();
        $prev_timestamp = $row[0]['vartimestamp'] + (60 * 4);

       return ($prev_timestamp > time());
    }
    public function proccessFeeds()
    {
        if ($this->_isWrongTimeStamp()) {
            // Handle the exit
            return;
        }

        $collection = Mage::getResourceModel('ranvi_feed/item_collection')
            ->addFieldToFilter('restart_cron', '1')
            ->addFieldToFilter('upload_day', array(
                'like' => '%' . strtolower(date('D')) . '%'
            ));

        foreach ($collection as $feed) {
            try {
                /** @var $feed Ranvi_Feed_Model_Item */
                $feed->generateFeed();
                $feed->clearInstance();
                unset($feed);
                //  }
            } catch (Exception $e) {
                $feed->setData('restart_cron', intval($feed->getData('restart_cron')) + 1);
                $feed->save();
                continue;
            }
        }
    }

    static function generateAll()
    {
        $collection = Mage::getResourceModel('ranvi_feed / item_collection');
        foreach ($collection as $feed) {
            try {
                Mage::app()->setCurrentStore($feed->getStoreId());
                $feed->generate();
            } catch (Exception $e) {
                continue;
            }
        }
    }

}
