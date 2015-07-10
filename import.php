<?php



// Подключаем
define('MODX_API_MODE', true);
require 'index.php';

// Включаем обработку ошибок
$modx->getService('error','error.modError');
$modx->setLogLevel(modX::LOG_LEVEL_FATAL);
$modx->setLogTarget(XPDO_CLI_MODE ? 'ECHO' : 'HTML');
$modx->error->message = null; // Обнуляем переменную

/*
$q=$modx->newQuery('modResource');
$q->where(array('id:>'=>496));
$res=$modx->getIterator('modResource',$q);

foreach ($res as $rs) {
    $rs->remove();
   /* $parent=$rs->get('parent');
    if ($parent) {
        $parentObj=$modx->getObject('modResource',$parent);

        if ($parentObj->get('pagetitle')==$rs->get('pagetitle')) {
            $rs->remove();
        }
     }
     //
}

die;
*/

// Логинимся в админку
$response = $modx->runProcessor('security/login', array('username' => 'admin', 'password' => '7469905'));
if ($response->isError()) {
    $modx->log(modX::LOG_LEVEL_ERROR, $response->getMessage());
    return;
}
$modx->initialize('mgr');

$base=file_get_contents('cat.txt');
$arr=explode(PHP_EOL,$base);

$ultraparent=14;

$parent=0;
foreach ($arr as $key=>$item) {
    if (preg_match('/\|/i',$item)) {
        $parent=$ultraparent;
        $item=str_replace('|', '', $item);
        $item=preg_replace('/\(.*\)/','',$item);
        $catname=$item;


    }else{
        

        if ( $res=$modx->getObject('modResource',array('pagetitle'=>$catname,'parent'=>$ultraparent))) {
            $parent=$res->get('id');
        }

         $item=preg_replace('/\(.*\)/','',$item);

    }
      
            if ($parent>0) {


                if (!$modx->getObject('modResource',array('pagetitle'=>$item,'parent'=>$parent))){
              // echo $parent.$item."<br/>";
                       //Создаем ресурс
                    $response = $modx->runProcessor('resource/create', array(
                        'pagetitle' => $item
                        ,'parent' => $parent
                        ,'content' => ''
                        ,'template' => 8
                        ,'isfolder' => 1
                        ,'published' => 1
                        ,'class_key'=>'msCategory'
                    ));   
                }

            }
        
    

}


if ($response->isError()) {
    $modx->log(modX::LOG_LEVEL_ERROR, $response->getMessage());
    return;
}
else {
    print_r($response->response);
}

?>