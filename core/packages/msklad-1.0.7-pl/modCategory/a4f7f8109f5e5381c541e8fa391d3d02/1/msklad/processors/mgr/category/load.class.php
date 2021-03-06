<?php

require_once MODX_CORE_PATH.'components/msklad/model/rest/RestRequest.inc.php';

class mSkladCategoryLoadProcessor extends modObjectProcessor {
    private $config;
    /* @var msklad $category */
    private $start, $total;
    public $languageTopics = array('msklad:api','msklad:category');


    public function initialize() {
        $this->config = $this->modx->msklad->config;
        $this->start = intval($this->getProperty('start'));
        $this->total = intval($this->getProperty('total'));
        return true;
    }

    public function process() {
        $stop=0;
        if($this->start==0) $this->modx->exec("TRUNCATE TABLE {$this->modx->getTableName('mSkladCategoryExchange')}");

        $request = new RestRequest($this->config['restUrl'].'GoodFolder/list?start='.$this->start.'&count=500', 'GET');
        $request->setUsername($this->config['Username']);
        $request->setPassword($this->config['Password']);
        $request->execute();

        $responseInfo = $request->getResponseInfo();
        $http_code = $responseInfo['http_code'];


        if($this->config['debug']){
            $this->modx->msklad->restLog('loadCategory',$request);
        }

        if($http_code=='200'){
            $xml = simplexml_load_string($request->getResponseBody());
            $this->total = $xml->attributes()->total;

            foreach($xml->goodFolder as $val){
                $code = (isset($val->code) && preg_match("/^[\d\+]+$/",$val->code)) ? intval($val->code) : 0;
                $uuid = isset($val->uuid)? (string) $val->uuid : '';
                $uuid1c = isset($val->externalcode)? (string) $val->externalcode : '';

                $newCategory = $this->modx->newObject('mSkladCategoryExchange');

                $newCategory->fromArray(array(
                    'category_id' => $code,
                    'uuid_1c' => $uuid1c,
                    'uuid' => $uuid
                ));
                if (!$newCategory->save()) {
                    return $this->failure($this->modx->lexicon('msklad_api_err_db'));
                }
            }
            unset($xml);
        }
        else return $this->failure($this->modx->lexicon('msklad_api_err_connect'));


        if($this->start+500 > $this->total) $stop=1;
        return $this->success(array('total'=> $this->total,'stop'=>$stop));
    }

}

return 'mSkladCategoryLoadProcessor';