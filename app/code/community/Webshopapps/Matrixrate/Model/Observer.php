<?php
class Webshopapps_Matrixrate_Model_Observer
{
    /**
     * Key:   Codes of methods that should have the carrier removed.
     * Value: The system config field name of the carrier title.
     *
     * @var array
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    protected $_shippingCodesToRemoveTitle = array(
        'matrixrate' => 'title',
    );
    /**
     * @param Varien_Event_Observer $observer
     * @author Joseph McDermott <code@josephmcdermott.co.uk>
     */
    public function removeCarrierFromDescription(Varien_Event_Observer $observer)
    {
        $quote = $observer->getEvent()->getQuote();
        $shippingAddress = $quote->getShippingAddress();
        if (!$shippingAddress instanceof Mage_Sales_Model_Quote_Address) {
            return;
        }
        $currentShippingMethod = $shippingAddress->getShippingMethod();
        foreach ($this->_shippingCodesToRemoveTitle as $_shippingCode => $_titleField) {
            if (substr($currentShippingMethod, 0, strlen($_shippingCode)) != $_shippingCode) {
                continue;
            }
            $path = 'carriers/' . $_shippingCode . '/' . $_titleField;
            $carrierTitle = Mage::getStoreConfig($path, $quote->getStoreId());
            $originalDescription = $shippingAddress->getShippingDescription();
            $newDescription = str_replace($carrierTitle . ' - ', '', $originalDescription);
            $shippingAddress->setShippingDescription(trim($newDescription));
            break;
        }
    }
}