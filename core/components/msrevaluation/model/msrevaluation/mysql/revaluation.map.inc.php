<?php
$xpdo_meta_map['Revaluation']= array (
  'package' => 'msrevaluation',
  'version' => '1.1',
  'table' => 'revaluation',
  'extends' => 'xPDOSimpleObject',
  'fields' => 
  array (
    'id_categiry' => NULL,
    'time' => NULL,
    'action' => 1,
    'percent' => NULL,
    'comment' => NULL,
    'history_file' => NULL,
  ),
  'fieldMeta' => 
  array (
    'id_categiry' => 
    array (
      'dbtype' => 'int',
      'precision' => '11',
      'phptype' => 'integer',
      'null' => true,
    ),
    'time' => 
    array (
      'dbtype' => 'int',
      'precision' => '11',
      'phptype' => 'integer',
      'null' => true,
    ),
    'action' => 
    array (
      'dbtype' => 'int',
      'precision' => '1',
      'phptype' => 'integer',
      'null' => false,
      'default' => 1,
    ),
    'percent' => 
    array (
      'dbtype' => 'int',
      'precision' => '3',
      'phptype' => 'integer',
      'null' => true,
    ),
    'comment' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'string',
      'null' => true,
    ),
    'history_file' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'string',
      'null' => true,
    ),
  ),
);
