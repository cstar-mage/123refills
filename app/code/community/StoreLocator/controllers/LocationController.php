<?php
/**
 * Unirgy_StoreLocator extension
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * @category   Unirgy
 * @package    Unirgy_StoreLocator
 * @copyright  Copyright (c) 2008 Unirgy LLC
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * @category   Unirgy
 * @package    Unirgy_StoreLocator
 * @author     Boris (Moshe) Gurevich <moshe@unirgy.com>
 */
class Unirgy_StoreLocator_LocationController extends Mage_Core_Controller_Front_Action
{
    public function mapAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    public function searchAction()
    {
        $dom = new DOMDocument("1.0");
        $node = $dom->createElement("markers");
        $parnode = $dom->appendChild($node);

        try {
            $num = (int)Mage::getStoreConfig('ustorelocator/general/num_results');
            $units = Mage::getStoreConfig('ustorelocator/general/distance_units');
            $collection = Mage::getModel('ustorelocator/location')->getCollection()
                ->addAreaFilter(
                    $this->getRequest()->getParam('lat'),
                    $this->getRequest()->getParam('lng'),
                    $this->getRequest()->getParam('radius'),
                    $this->getRequest()->getParam('units', $units)
                )
                ->addProductTypeFilter($this->getRequest()->getParam('type'));

            $privateFields = Mage::getConfig()->getNode('global/ustorelocator/private_fields');
            $i = 0;
            foreach ($collection as $loc){
                $node = $dom->createElement("marker");
                $newnode = $parnode->appendChild($node);
                $newnode->setAttribute("units", $units);
                $newnode->setAttribute("marker_label", ++$i);
                foreach ($loc->getData() as $k=>$v) {
                    if (!$privateFields->$k) {
                        $newnode->setAttribute($k, $v);
                    }
                }
            }
        } catch (Exception $e) {
            $node = $dom->createElement('error');
            $newnode = $parnode->appendChild($node);
            $newnode->setAttribute('message', $e->getMessage());
        }

        $this->getResponse()->setHeader('Content-Type', 'text/xml', true)->setBody($dom->saveXml());
    }
}
