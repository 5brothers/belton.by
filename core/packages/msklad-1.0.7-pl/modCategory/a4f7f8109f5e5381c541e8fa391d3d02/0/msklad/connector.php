<?php
/**
 * mSklad Connector
 *
 * @package msklad
 */
require_once dirname(dirname(dirname(dirname(__FILE__)))).'/config.core.php';
require_once MODX_CORE_PATH.'config/'.MODX_CONFIG_KEY.'.inc.php';
require_once MODX_CONNECTORS_PATH.'index.php';

$corePath = $modx->getOption('msklad_core_path',null,$modx->getOption('core_path').'components/msklad/');
require_once $corePath.'model/msklad/msklad.class.php';
$modx->msklad = new mSklad($modx);

$modx->lexicon->load('msklad:default');

/* handle request */
$path = $modx->getOption('processorsPath',$modx->msklad->config,$corePath.'processors/');
$modx->request->handleRequest(array(
    'processors_path' => $path,
    'location' => '',
));