<?php
$xpdo_meta_map['mSkladProductExchange']= array (
  'package' => 'msklad',
  'version' => '1.1',
  'table' => 'msklad_products_exchange',
  'extends' => 'xPDOSimpleObject',
  'fields' => 
  array (
    'product_id' => 0,
    'uuid_1c' => '',
    'uuid' => '',
    'price_uuid' => '',
  ),
  'fieldMeta' => 
  array (
    'product_id' => 
    array (
      'dbtype' => 'integer',
      'attributes' => 'unsigned',
      'precision' => '10',
      'phptype' => 'integer',
      'null' => false,
      'default' => 0,
    ),
    'uuid_1c' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '74',
      'phptype' => 'string',
      'null' => true,
      'default' => '',
    ),
    'uuid' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '74',
      'phptype' => 'string',
      'null' => true,
      'default' => '',
    ),
    'price_uuid' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '74',
      'phptype' => 'string',
      'null' => true,
      'default' => '',
    ),
  ),
);
