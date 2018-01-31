<?php
/**
 * Customer/Customer Address Attributes Installer
 */
try {
  
  /* @var $installer Mage_Customer_Model_Entity_Setup */ 
  $installer = $this;
  $installer->startSetup();
  
//  // Customer 'type' EAV attribute definition
//  $installer->addAttribute('customer', 'secure_payment_only', array(
//      'label'           => 'Secure Payment Methods Only',
//      'visible'         => true,
//      'required'        => true,
//      'user_defined'    => true,
//      'type'            => 'int',
//      'input'           => 'select',
//      'source'          => 'eav/entity_attribute_source_table',
//      'default_value'         => 0,
//  ));
//  
//  $tableOptions         = $installer->getTable('eav_attribute_option');
//  $tableOptionValues    = $installer->getTable('eav_attribute_option_value');
//  
//  $attributeId          = (int) $installer->getAttribute('customer', 'secure_payment_only', 'attribute_id');
//  
//  // Attribute options
//  $options = array(
//    'Yes', 
//    'No'
//  );
//  
//  // Add options
//  foreach ($options as $sortOrder => $label) {
//  
//      // Add option
//      $data = array(
//          'attribute_id'  => $attributeId,
//          'sort_order'    => $sortOrder,
//      );
//      
//      $installer->getConnection()->insert($tableOptions, $data);
//  
//      // Add option label
//      $optionId = (int) $installer->getConnection()->lastInsertId($tableOptions, 'option_id');
//      $data = array(
//          'option_id'     => $optionId,
//          'store_id'      => Mage_Core_Model_App::ADMIN_STORE_ID,
//          'value'         => $label
//      );
//      
//      $installer->getConnection()->insert($tableOptionValues, $data);
//  
//  }
//  
//  // Add attribute to customer forms
//  $attribute = Mage::getSingleton('eav/config')->getAttribute('customer', 'secure_payment_only');
//  
//  $attribute->setData('used_in_forms', array(
//      'adminhtml_customer',
//  ));
//  
//  $attribute->save();
//  
################################################################################
  
  // Customer Address 'telephone_landline' EAV attribute definition
  $installer->addAttribute('customer', 'credit_limit', array(
      'label'        => 'Credit Limit (incl. taxes)',
      'visible'      => true,
      'required'     => false,
      'user_defined' => true,
      'type'         => 'decimal',
      'input'        => 'text',
      'default_value' => 0.00,
      'source'          => 'eav/entity_attribute_source_table',
  ));
  
  // Add attribute to customer address forms
  $attribute = Mage::getSingleton('eav/config')->getAttribute('customer', 'credit_limit');
  $attribute->setData('used_in_forms', array(
      'adminhtml_customer',
  ));
  
  $attribute->save();
  
  $installer->endSetup();
 
} catch (Exception $e) {
    Mage::logException($e);
}