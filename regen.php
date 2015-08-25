<?php
define('MODX_API_MODE', true);
require 'index.php';		// Если файл лежит не в корне - здесь нужно указать верный путь
$modx->getService('error','error.modError');
$modx->setLogLevel(modX::LOG_LEVEL_INFO);
$modx->setLogTarget(XPDO_CLI_MODE ? 'ECHO' : 'HTML');

if (!isset($parents)) {$parents = 0;}		// Можно указать список категорий для поиска товаров
if (!isset($resources)) {$resources = '';}	// Можно указать конкретный список товаров

$pdo = $modx->getService('pdoFetch');
$condition = array('parents' => $parents);
$files = $pdo->getCollection('msProduct',
	array(
		'msProduct.class_key' => 'msProduct',
	),
	array(
		'class' => 'msProduct',
		'parents' => $parents,
		'resources' => $resources,
		'innerJoin' => array(
			'msProductFile' => array(
				'alias' => 'msProductFile',
				'on' => array(
					'msProduct.id = msProductFile.product_id',
					'msProductFile.parent' => 0,
					'msProductFile.type' => 'image',
				)
			)
		),
		'select' => array(
			'msProductFile' => 'all'
		),
		'sortby' => 'msProduct.id'
	)
);

echo '<pre>';
echo $pdo->getTime();
foreach ($files as $row) {
	$file = $modx->newObject('msProductFile');	
	$file->fromArray($row, '', true, true);
	
	$children = $file->getMany('Children');
	foreach ($children as $child) {
		$child->remove();
	}
	$file->generateThumbnails();
	
	// Обновляем thumb и image товара
	if ($product = $file->getOne('Product')) {
		$product->updateProductImage();
	}
}

echo microtime(true) - $modx->startTime;

?>