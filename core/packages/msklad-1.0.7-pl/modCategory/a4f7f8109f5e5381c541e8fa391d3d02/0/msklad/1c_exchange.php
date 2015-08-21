<?php
ini_set('display_errors', 1);
ini_set('error_reporting', 1);

if (empty($_REQUEST['type'])) {
    die('Access denied');
}
else {
    $type = $_REQUEST['type'];
    $mode = $_REQUEST['mode'];
}

define('MODX_API_MODE', true);
require_once dirname(dirname(dirname(dirname(__FILE__)))).'/index.php';

$modx->getService('error','error.modError');
$modx->getRequest();
$modx->setLogLevel(modX::LOG_LEVEL_ERROR);
$modx->setLogTarget('FILE');
$modx->error->message = null;

/* @var mSklad $mSklad */
$mSklad = $modx->getService('msklad','mSklad',$modx->getOption('msklad_core_path',null,$modx->getOption('core_path').'components/msklad/').'model/msklad/',array());
if ($modx->error->hasError() || !($mSklad instanceof mSklad)) {die('Error');}
$mSklad->initialize('web', array('json_response' => true));

if($mSklad->config['debug']){
	$mSklad->restLog('msklad_auth',$_SERVER);
}
if(!isset($_SERVER['PHP_AUTH_USER']) && !isset($_SERVER['PHP_AUTH_PW'])){
    /*
     * Add support on FastCGI mode
     * RewriteCond %{HTTP:Authorization} !^$
     * RewriteRule ^(.*)$ $1?http_auth=%{HTTP:Authorization} [QSA]
     */
    if(isset($_GET['http_auth'])){
        $d = base64_decode(substr($_GET['http_auth'],6) );
        list($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']) = explode(':', $d);
    }
}
$user = $_SERVER['PHP_AUTH_USER'];
$password = $_SERVER['PHP_AUTH_PW'];

$syncuser = $modx->getObject('modSystemSetting',array('key' => 'msklad_1c_sync_login'));
$syncpass = $modx->getObject('modSystemSetting',array('key' => 'msklad_1c_sync_pass'));

if ( ($user != $syncuser->get('value') || $password != $syncpass->get('value')) ) {
	$modx->log(modX::LOG_LEVEL_ERROR, '[mSklad] Ошибка авторизации импорта, проверьте правильность логина и пароля.');
    echo "failure\n";
    exit;
}


switch ($type) {
    //Остатки
    case 'catalog':
        switch ($mode) {
            case 'checkauth':
                $response = $mSklad->catalog->checkauth();
                break;
            case 'init':
                $response = $mSklad->catalog->init();
                break;
            case 'file':
                $response = $mSklad->catalog->file(@$_REQUEST['filename'], @file_get_contents("php://input"));
                break;
            case 'import':
                $response = $mSklad->catalog->import(@$_REQUEST['filename'], @file_get_contents("php://input"));
                break;
            default:
        }
        break;

    //Заказы
    case 'sale':
        switch ($mode) {
            case 'checkauth':
                $response = $mSklad->sale->checkauth();
                break;
            case 'init':
                $response = $mSklad->sale->init();
                break;
            case 'query':
                header ( "Content-type: text/xml; charset=windows-1251" );
//                print "\xEF\xBB\xBF";
                $response = $mSklad->sale->query();
                break;
            case 'success':
                $response = $mSklad->sale->success();
                break;
            case 'file':
                $response = $mSklad->sale->file(@$_REQUEST['filename'], @file_get_contents("php://input"));
                break;
            default:
        }
        break;
    default:
}

@session_write_close();
exit($response);