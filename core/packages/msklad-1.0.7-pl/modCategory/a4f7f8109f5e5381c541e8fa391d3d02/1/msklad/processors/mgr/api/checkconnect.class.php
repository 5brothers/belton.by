<?php

require_once MODX_CORE_PATH.'components/msklad/model/rest/RestRequest.inc.php';

class mSkladCheckConnectProcessor extends modObjectProcessor {
    private $config;
    public $languageTopics = array('msklad:api');

    public function initialize() {
        $this->config = $this->modx->msklad->config;
        return true;
    }

    public function process() {

        $request = new RestRequest($this->config['restUrl'].'MyCompany/list', 'GET');
        $request->setUsername($this->config['Username']);
        $request->setPassword($this->config['Password']);
        $request->execute();

        $responseInfo = $request->getResponseInfo();
        $http_code = $responseInfo['http_code'];

        if($http_code!='200'){
            return $this->failure($this->modx->lexicon('msklad_api_err_connect'));
        }

        $updatedOn = $this->modx->getObject('modSystemSetting', 'msklad_on_update');

        if($updatedOn->get('value')) {
            $diff = round( ( time() - strtotime($updatedOn->get('editedon')))/60 );
            if($diff<10) return $this->failure($this->modx->lexicon('msklad_api_err_onupdate'));
        }

        $updatedOn->set('value', '1');
        $updatedOn->save();


        $this->setSalePriceUuid();
        $this->setUomUuid();

        return $this->success();
    }

    public function setSalePriceUuid(){
        $request = new RestRequest($this->config['restUrl'].'PriceType/list', 'GET');
        $request->setUsername($this->config['Username']);
        $request->setPassword($this->config['Password']);
        $request->execute();

        $responseInfo = $request->getResponseInfo();
        $http_code = $responseInfo['http_code'];

        if($http_code=='200'){
            $xml = simplexml_load_string($request->getResponseBody());

            $cc=0;
            foreach($xml->priceType as $val){
                $name = (string)$val->attributes()->name;
                if($name=='Цена продажи'){
                    $salePriceType = $this->modx->getObject('modSystemSetting', 'msklad_price_type_uuid');
                    $salePriceType->set('value', $val->uuid);
                    $salePriceType->save();
                }
                ++$cc;
            }
            unset($xml);
        }
    }

    public function setUomUuid(){
        $request = new RestRequest($this->config['restUrl'].'Uom/list', 'GET');
        $request->setUsername($this->config['Username']);
        $request->setPassword($this->config['Password']);
        $request->execute();

        $responseInfo = $request->getResponseInfo();
        $http_code = $responseInfo['http_code'];

        if($http_code=='200'){
            $xml = simplexml_load_string($request->getResponseBody());

            $cc=0;
            foreach($xml->uom as $val){
                $name = (string)$val->attributes()->name;
                if($name=='шт'){
                    $uomType = $this->modx->getObject('modSystemSetting', 'msklad_uom_type_uuid');
                    $uomType->set('value', $val->uuid);
                    $uomType->save();
                }
                ++$cc;
            }
            unset($xml);
        }
    }

}
return 'mSkladCheckConnectProcessor';