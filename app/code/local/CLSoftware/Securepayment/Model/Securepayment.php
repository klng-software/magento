<?php

class CLSoftware_Securepayment_Model_Securepayment {
    
    public function paymentCheck($method){
        //check if the input method is a secure payment method as configured.
        $configValue = Mage::getStoreConfig('securepaymentmethods_prefs/payments/fld_secure_payment_methods');
        
        $arrSecurePaymentMethods = explode(',', $configValue);
        
        return in_array($method->getCode(), $arrSecurePaymentMethods);
        
    }
    
}