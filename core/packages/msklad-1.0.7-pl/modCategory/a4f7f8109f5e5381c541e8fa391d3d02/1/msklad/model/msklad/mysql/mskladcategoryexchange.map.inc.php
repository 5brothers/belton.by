<?php
$xpdo_meta_map['mSkladCategoryExchange']= array (
  'package' => 'msklad',
  'version' => '1.1',
  'table' => 'msklad_categories_exchange',
  'extends' => 'xPDOSimpleObject',
  'fields' => 
  array (
    'category_id' => 0,
    'uuid_1c' => '',
    'uuid' => '',
  ),
  'fieldMeta' => 
  array (
    'category_id' => 
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
  ),
);
