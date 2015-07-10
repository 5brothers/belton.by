<?php

class msRevaluationCancelProcessor extends modObjectRemoveProcessor {
    public $classKey = 'Revaluation';
    public $languageTopics = array('msrevaluation:default');
    public $objectType = 'msrevaluation';
    
    public function initialize(){
        if(!$restore = $this->modx->msrevaluation->restoreProcess($this->getProperty('id'))) $this->failure($this->modx->msrevaluation->error);
        return parent::initialize();
    }
}
return 'msRevaluationCancelProcessor';
?>