<?php
class Oeditor_Ordereditor_Model_Authorizenet extends Mage_Paygate_Model_Authorizenet
{
		/**
		 * @todo uncomment the following if you want to refund the payment, or make a patial payment
		 */
		//protected $_canCapturePartial       = false;
		//protected $_canRefund               = false;
		
		protected $_canUseInternal          = true;
		protected $_canSaveCc = true;
	 
	
		/**
		 * It sets card`s data into additional information of payment model
		 * AuthorizeNet has added additional_information field in sale_flat_order_payment table
		 * where they savve credit card info, and disallow to save the card in other fields,
		 * This method is temprory and we need to fetch the card info from additional_information
		 * field.
		 * @param Mage_Paygate_Model_Authorizenet_Result $response
		 * @param Mage_Sales_Model_Order_Payment $payment
		 * @return Varien_Object
		 */
		protected function _registerCard(Varien_Object $response, Mage_Sales_Model_Order_Payment $payment)
		{	
			//$isAuth = Mage::getStoreConfig('editorder/general/reauth');
			//if(isset($isAuth) && $isAuth == 1) {
		
			$cardsStorage = $this->getCardsStorage($payment);
			$card = $cardsStorage->registerCard();
			$card
				->setRequestedAmount($response->getRequestedAmount())
				->setBalanceOnCard($response->getBalanceOnCard())
				->setLastTransId($response->getTransactionId())
				->setProcessedAmount($response->getAmount())
				->setCcType($payment->getCcType())
				->setCcOwner($payment->getCcOwner())
				->setCcLast4($payment->getCcLast4())
				->setCcExpMonth($payment->getCcExpMonth())
				->setCcExpYear($payment->getCcExpYear())
				->setCcSsIssue($payment->getCcSsIssue())
				->setCcSsStartMonth($payment->getCcSsStartMonth())
				->setCcSsStartYear($payment->getCcSsStartYear());
	 
			$cardsStorage->updateCard($card);
			//below is the only reason to override this method,
			//$this->_clearAssignedData($payment);
			return $card;
		//}
	}
}
?>
