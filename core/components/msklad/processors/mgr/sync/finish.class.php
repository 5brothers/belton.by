<?php

require_once MODX_CORE_PATH.'components/msklad/model/rest/RestRequest.inc.php';

class mSkladFinishProcessor extends modObjectProcessor {
    private $config;
    public $languageTopics = array('msklad:default');

    public function initialize() {
        $this->config = $this->modx->msklad->config;
        return true;
    }

    public function process() {

        $updatedOn = $this->modx->getObject('modSystemSetting', 'msklad_on_update');
        $updatedOn->set('value', '0');
        $updatedOn->save();

        $this->modx->msklad->clearCache();
        return $this->success();
    }

}
return 'mSkladFinishProcessor';