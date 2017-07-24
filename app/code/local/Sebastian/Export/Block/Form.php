<?php

/**
 *
 * Copyright Sebastian Enzinger <sebastian@enzinger.de> www.sebastian-enzinger.de
 *
 * All rights reserved.
 *
**/

class Sebastian_Export_Block_Form extends Mage_Adminhtml_Block_Template
{
    public function getCalendarHtml($id)
    {
        $calendar = $this->getLayout()
            ->createBlock('core/html_date')
            ->setId($id)
            ->setName($id)
            ->setClass('input-text')
            ->setImage(Mage::getDesign()->getSkinUrl('images/grid-cal.gif'))
            ->setFormat(Mage::app()->getLocale()->getDateStrFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT));

        return $calendar->getHtml();
    }

    public function getGrid() {
      return $this->getLayout()->createBlock('export/grid_grid', 'export.grid')->getHtml();
    }

    public function getWebsitesOptionHtml()
      {
          $storeModel = Mage::getSingleton('adminhtml/system_store');
          /* @var $storeModel Mage_Adminhtml_Model_System_Store */
          $websiteCollection = $storeModel->getWebsiteCollection();
          $groupCollection = $storeModel->getGroupCollection();
          $storeCollection = $storeModel->getStoreCollection();

          $html  = '<select name="store" id="store" >';
          $html .= '<option value="">'.$this->__('Default Configuration').'</option>';

          foreach ($websiteCollection as $website) {
              $websiteShow = false;
              foreach ($groupCollection as $group) {
                  if ($group->getWebsiteId() != $website->getId()) {
                      continue;
                  }
                  $groupShow = false;
                  foreach ($storeCollection as $store) {
                      if ($store->getGroupId() != $group->getId()) {
                          continue;
                      }
                      if (!$websiteShow) {
                          $websiteShow = true;
                          $html .= '<optgroup label="' . $website->getName() . '"></optgroup>';
                      }
                      if (!$groupShow) {
                          $groupShow = true;
                          $html .= '<optgroup label="&nbsp;&nbsp;&nbsp;&nbsp;' . $group->getName() . '">';
                      }
                      $html .= '<option value="' . $store->getId() . '">&nbsp;&nbsp;&nbsp;&nbsp;' . $store->getName() . '</option>';

                  }
                  if ($groupShow) {
                      $html .= '</optgroup>';
                  }
              }
          }
          $html .= '</select>';
          return $html;
      }
}