<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magento.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magento.com for more information.
 *
 * @category    Mage
 * @package     Mage_Checkout
 * @copyright  Copyright (c) 2006-2017 X.commerce, Inc. and affiliates (http://www.magento.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * One page checkout status
 *
 * @category   Mage
 * @category   Mage
 * @package    Mage_Checkout
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class CLSoftware_Securepayment_Block_Checkout_Onepage_Payment_Methods extends Mage_Payment_Block_Form_Container
{
    public function getQuote()
    {
        return Mage::getSingleton('checkout/session')->getQuote();
    }

    /**
     * Check payment method model
     *
     * @param Mage_Payment_Model_Method_Abstract|null
     * @return bool
     */
    protected function _canUseMethod($method)
    {
        //Check if Payment method has to be secure.
        
        $bolCheckMethodIfSecure = false;
        $bolMethodAllowed = true;
        $securePayment = Mage::getSingleton('securepayment/securepayment');
        
        if(Mage::getSingleton('customer/session')->isLoggedIn()){
            
            $customer = Mage::getSingleton('customer/session')->getCustomer();
            $secure_payment_only = $customer->getData('secure_payment_only'); // 3 = yes; 4 = no
            $credit_limit = $customer->getData('credit_limit');
            
            if($secure_payment_only == 4 
                    && $credit_limit > 0 ){
                
                $objQuote = $this->getQuote();
                $base_subtotal = $objQuote->getData('base_subtotal_with_discount');
                
                if($base_subtotal < $credit_limit){
                    
                    $bolCheckMethodIfSecure = true;
                    
                }
            } elseif($secure_payment_only == 3) {
                
                $bolCheckMethodIfSecure = true;
                
            }
            
        } else {
           
            $bolCheckMethodIfSecure = true;
            
        }
        
        if($bolCheckMethodIfSecure){
            $bolMethodAllowed = $securePayment->paymentCheck($method);
            
        }
        
        return $method && $method->canUseCheckout() && parent::_canUseMethod($method) && $bolMethodAllowed;
    }

    /**
     * Retrieve code of current payment method
     *
     * @return mixed
     */
    public function getSelectedMethodCode()
    {
        if ($method = $this->getQuote()->getPayment()->getMethod()) {
            return $method;
        }
        return false;
    }

    /**
     * Payment method form html getter
     * @param Mage_Payment_Model_Method_Abstract $method
     */
    public function getPaymentMethodFormHtml(Mage_Payment_Model_Method_Abstract $method)
    {
         return $this->getChildHtml('payment.method.' . $method->getCode());
    }

    /**
     * Return method title for payment selection page
     *
     * @param Mage_Payment_Model_Method_Abstract $method
     */
    public function getMethodTitle(Mage_Payment_Model_Method_Abstract $method)
    {
        $form = $this->getChild('payment.method.' . $method->getCode());
        if ($form && $form->hasMethodTitle()) {
            return $form->getMethodTitle();
        }
        return $method->getTitle();
    }

    /**
     * Payment method additional label part getter
     * @param Mage_Payment_Model_Method_Abstract $method
     */
    public function getMethodLabelAfterHtml(Mage_Payment_Model_Method_Abstract $method)
    {
        if ($form = $this->getChild('payment.method.' . $method->getCode())) {
            return $form->getMethodLabelAfterHtml();
        }
    }
}
