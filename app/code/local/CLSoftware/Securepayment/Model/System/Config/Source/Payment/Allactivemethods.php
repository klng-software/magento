<?php

class CLSoftware_Securepayment_Model_System_Config_Source_Payment_Allactivemethods {
     public function toOptionArray()
    {
        $methods = array();
        $groups = array();
        $groupRelations = array();

        $payment = Mage::helper('payment')->getPaymentMethods(null);
        
        foreach ($payment as $code => $data) {
            if(!isset($data['active']) || !$data['active']){
                continue;
            }
            if ((isset($data['title']))) {
                $methods[$code] = $data['title'];
            } else {
                if (Mage::helper('payment')->getMethodInstance($code)) {
                    $methods[$code] = Mage::helper('payment')->getMethodInstance($code)->getConfigData('title', null);
                }
            }
            if ($withGroups && isset($data['group'])) {
                $groupRelations[$code] = $data['group'];
            }
        }
        
        $groups = Mage::app()->getConfig()->getNode(Mage::helper('payment')::XML_PATH_PAYMENT_GROUPS)->asCanonicalArray();
        foreach ($groups as $code => $title) {
            $methods[$code] = $title; // for sorting, see below
        }
        
        
        asort($methods);
        
        $labelValues = array();
        foreach ($methods as $code => $title) {
            $labelValues[$code] = array();
        }
        foreach ($methods as $code => $title) {
            if (isset($groups[$code])) {
                $labelValues[$code]['label'] = $title;
            } elseif (isset($groupRelations[$code])) {
                unset($labelValues[$code]);
                $labelValues[$groupRelations[$code]]['value'][$code] = array('value' => $code, 'label' => $title);
            } else {
                $labelValues[$code] = array('value' => $code, 'label' => $title);
            }
        }
        return $labelValues;
    }
}