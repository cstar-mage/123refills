<?php 

class Oeditor_Ordereditor_Model_Order_Invoice extends Mage_Sales_Model_Order_Invoice
{  
//Sales Flat Invoice Grid
//Sales Flat Invoice
/*<sales>
	  <rewrite>
		  <order_invoice>Rank_Pagerank_Model_Order_Invoice</order_invoice>
	  </rewrite>
	</sales>
*/
	const STATE_OPEN       = 1;
    const STATE_PAID       = 2;
    const STATE_CANCELED   = 3;
	 protected static $_states;
	/**
     * Retrieve invoice states array
     *
     * @return array
     */
    public static function getStates()
    {
		  if (is_null(self::$_states)) {
            self::$_states = array(
                self::STATE_OPEN       => Mage::helper('sales')->__('Pending'),
                self::STATE_PAID       => Mage::helper('sales')->__('Paid'),
                self::STATE_CANCELED   => Mage::helper('sales')->__('Canceled'),
            );
         }
		 
		// echo '<pre>';print_r( self::$_states);die;
		 
			$invoiceStatus = Mage::getStoreConfig('editorder/opermission/edit_order_invoice_status'); 
			$invoiceStatusArr = @unserialize($invoiceStatus);		
			if($invoiceStatusArr) {
				$i = 4 ;
				 foreach($invoiceStatusArr as $field) {
				 	 
					$invoice_state = $field['feature'];
					self::$_states[$i] = $invoice_state ;
					//echo '<pre>';print_r( self::$_states);die;
					$i++ ;
				 }
			 }
			 
      
        return self::$_states;
    }
	
	public function getStateName($stateId = null)
    {

		$invoiceId = Mage::app()->getRequest()->getParam('invoice_id');
		$invoice = Mage::getModel('sales/order_invoice')
                    ->load($invoiceId);
			$stateId = $invoice->getState();

 
			
        if (is_null($stateId)) {
            $stateId = $this->getState();
        }

        if (is_null(self::$_states)) {
            self::getStates();
        }
        if (isset(self::$_states[$stateId])) {
            return self::$_states[$stateId];
        }
        return Mage::helper('sales')->__('Unknown State');
    }
	
}

?>