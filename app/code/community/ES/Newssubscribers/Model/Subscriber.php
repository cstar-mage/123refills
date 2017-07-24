<?php

class ES_Newssubscribers_Model_Subscriber extends Mage_Newsletter_Model_Subscriber
{
	const XML_PATH_ADMIN_EMAIL_CONFIRMATION_TEMPLATE 		= 'newsletter/general/admin_email_template';
	const STATUS_SUBSCRIBED     = 1;
	const STATUS_NOT_ACTIVE     = 2;
	const STATUS_UNSUBSCRIBED   = 3;
	const STATUS_UNCONFIRMED    = 4;
	
	const XML_PATH_CONFIRM_EMAIL_TEMPLATE       = 'newsletter/subscription/confirm_email_template';
	const XML_PATH_CONFIRM_EMAIL_IDENTITY       = 'newsletter/subscription/confirm_email_identity';
	const XML_PATH_SUCCESS_EMAIL_TEMPLATE       = 'newsletter/subscription/success_email_template';
	const XML_PATH_SUCCESS_EMAIL_IDENTITY       = 'newsletter/subscription/success_email_identity';
	const XML_PATH_UNSUBSCRIBE_EMAIL_TEMPLATE   = 'newsletter/subscription/un_email_template';
	const XML_PATH_UNSUBSCRIBE_EMAIL_IDENTITY   = 'newsletter/subscription/un_email_identity';
	const XML_PATH_CONFIRMATION_FLAG            = 'newsletter/subscription/confirm';
	const XML_PATH_ALLOW_GUEST_SUBSCRIBE_FLAG   = 'newsletter/subscription/allow_guest_subscribe';
	
	
    public function getCouponCode()
    {
        if (!Mage::getStoreConfig('newsletter/coupon/isactive'))
            return '';

        $model = Mage::getModel('salesrule/rule');
        $model->load(Mage::getStoreConfig('newsletter/coupon/roleid'));
        $massGenerator = $model->getCouponMassGenerator();
        $session = Mage::getSingleton('core/session');
        try {
            $massGenerator->setData(array(
                'rule_id' => Mage::getStoreConfig('newsletter/coupon/roleid'),
                'qty' => 1,
                'length' => Mage::getStoreConfig('newsletter/coupon/length'),
                'format' => Mage::getStoreConfig('newsletter/coupon/format'),
                'prefix' => Mage::getStoreConfig('newsletter/coupon/prefix'),
                'suffix' => Mage::getStoreConfig('newsletter/coupon/suffix'),
                'dash' => Mage::getStoreConfig('newsletter/coupon/dash'),
                'uses_per_coupon' => 1,
                'uses_per_customer' => 1
            ));
            $massGenerator->generatePool();
            $latestCuopon = max($model->getCoupons());
        } catch (Mage_Core_Exception $e) {
            $session->addException($e, $this->__('There was a problem with coupon: %s', $e->getMessage()));
        }
        catch (Exception $e) {
            $session->addException($e, $this->__('There was a problem with coupon.'));
        }

        return $latestCuopon->getCode();
    }
    
    public function sendConfirmationSuccessEmail()
    {
 
    	if ($this->getImportMode()) {
    		return $this;
    	}
    
    	if(!Mage::getStoreConfig(self::XML_PATH_SUCCESS_EMAIL_TEMPLATE)
    			|| !Mage::getStoreConfig(self::XML_PATH_SUCCESS_EMAIL_IDENTITY)
    	) {
    		return $this;
    	}
    
    	$translate = Mage::getSingleton('core/translate');
    	/* @var $translate Mage_Core_Model_Translate */
    	$translate->setTranslateInline(false);
    
    	$email = Mage::getModel('core/email_template');
    	$theme = Ideal_Evolved_Block_Evolved::getConfig();
    	$coupen = $theme['newsletter_coupon_code'];
    	$email->sendTransactional(
    			Mage::getStoreConfig(self::XML_PATH_SUCCESS_EMAIL_TEMPLATE),
    			Mage::getStoreConfig(self::XML_PATH_SUCCESS_EMAIL_IDENTITY),
    			$this->getEmail(),
    			$this->getName(),
    			array('subscriber'=>$this,'coupen'=>$coupen)
    	);
    	$email->sendTransactional(
    	 Mage::getStoreConfig(self::XML_PATH_ADMIN_EMAIL_CONFIRMATION_TEMPLATE),
    	 Mage::getStoreConfig(self::XML_PATH_SUCCESS_EMAIL_IDENTITY),
    	 Mage::getStoreConfig('trans_email/ident_general/email'),
    	 null,
    	 null
    	);
    	
    	$translate->setTranslateInline(true);
    
    	return $this;
    }
    
    
    /**
     * Subscribes by email
     *
     * @param string $email
     * @throws Exception
     * @return int
     */
    public function subscribe($email)
    {
    	$this->loadByEmail($email);
    	$customerSession = Mage::getSingleton('customer/session');
    
    	if(!$this->getId()) {
    		$this->setSubscriberConfirmCode($this->randomSequence());
    	}
    
    	$isConfirmNeed   = (Mage::getStoreConfig(self::XML_PATH_CONFIRMATION_FLAG) == 1) ? true : false;
    	$isOwnSubscribes = false;
    	$ownerId = Mage::getModel('customer/customer')
    	->setWebsiteId(Mage::app()->getStore()->getWebsiteId())
    	->loadByEmail($email)
    	->getId();
    	$isSubscribeOwnEmail = $customerSession->isLoggedIn() && $ownerId == $customerSession->getId();
    
    	if (!$this->getId() || $this->getStatus() == self::STATUS_UNSUBSCRIBED
    			|| $this->getStatus() == self::STATUS_NOT_ACTIVE
    	) {
    		if ($isConfirmNeed === true) {
    			// if user subscribes own login email - confirmation is not needed
    			$isOwnSubscribes = $isSubscribeOwnEmail;
    			if ($isOwnSubscribes == true){
    				$this->setStatus(self::STATUS_SUBSCRIBED);
    			} else {
    				$this->setStatus(self::STATUS_NOT_ACTIVE);
    			}
    		} else {
    			$this->setStatus(self::STATUS_SUBSCRIBED);
    		}
    		$this->setSubscriberEmail($email);
    	}
    
    	if ($isSubscribeOwnEmail) {
    		$this->setStoreId($customerSession->getCustomer()->getStoreId());
    		$this->setCustomerId($customerSession->getCustomerId());
    	} else {
    		$this->setStoreId(Mage::app()->getStore()->getId());
    		$this->setCustomerId(0);
    	}
    
    	$this->setIsStatusChanged(true);
    	
    	$this->setCreatedTime(now());
    
    	try {
    		$this->save();
    		if ($isConfirmNeed === true
    				&& $isOwnSubscribes === false
    		) {
    			$this->sendConfirmationRequestEmail();
    		} else {
    			$this->sendConfirmationSuccessEmail();
    		}
    
    		return $this->getStatus();
    	} catch (Exception $e) {
    		throw new Exception($e->getMessage());
    	}
    }
}