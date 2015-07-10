<?php

require_once dirname(dirname(dirname(dirname(__FILE__)))).'/config.core.php';
require_once MODX_CORE_PATH.'config/'.MODX_CONFIG_KEY.'.inc.php';
require_once MODX_CONNECTORS_PATH.'index.php';
$corePath = $modx->getOption('core_path').'components/msrevaluation/';
require_once $corePath.'model/msrevaluation/msrevaluation.class.php';

$modx->msrevaluation = new msRevaluation($modx, array_merge($scriptPropertis,$params));
$modx->lexicon->load('msrevaluation:default');
if($_POST['percent']){
    if($_POST['rev_dir'] == $modx->lexicon('increase')) $rev_dir = 1;
    else $rev_dir = 2;
    $modx->msrevaluation->config['rev_dir'] = $rev_dir;
    $modx->msrevaluation->config['percent'] = $_POST['percent'];
    $modx->msrevaluation->config['id_categiry'] = $_POST['id_categiry'];
    $modx->msrevaluation->config['coefficient'] = $_POST['coefficient'];
    $modx->msrevaluation->config['comment'] = $_POST['comment'];
}
else $params = array();
$path = $corePath.'processors/';
$modx->request->handleRequest(array(
    'processors_path' => $path,
    'location' => '',
)); ?>