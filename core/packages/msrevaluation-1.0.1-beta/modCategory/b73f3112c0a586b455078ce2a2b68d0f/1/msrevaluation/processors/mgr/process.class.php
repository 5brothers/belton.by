<?php

class msRevaluationProcessProcessor extends modObjectCreateProcessor  {
    public $classKey = 'Revaluation';
    public $languageTopics = array('msrevaluation:default');
    public $objectType = 'msrevaluation';
    public $historyFile;
    
    public function initialize(){
        if(!$this->historyFile = $this->modx->msrevaluation->process()){
            $this->failure($this->modx->msrevaluation->error);
        }
        return parent::initialize();
    }
    
    public function process() {
        /* Run the beforeSet method before setting the fields, and allow stoppage */
        $canSave = $this->beforeSet();
        if ($canSave !== true) {
            return $this->failure($canSave);
        }

        $props = array(
            'id_categiry' => $this->modx->msrevaluation->config['id_categiry'],
            'id_vendor' => $this->modx->msrevaluation->config['id_vendor'],
            'percent' => $this->modx->msrevaluation->config['percent'],
            'time' => time(),
            'action' => $this->modx->msrevaluation->config['rev_dir'],
            'comment' => $this->modx->msrevaluation->comment,
            'history_file' => $this->historyFile,
        );
        $this->object->fromArray($props);

        /* run the before save logic */
        $canSave = $this->beforeSave();
        if ($canSave !== true) {
            return $this->failure($canSave);
        }

        /* run object validation */
        if (!$this->object->validate()) {
            /** @var modValidator $validator */
            $validator = $this->object->getValidator();
            if ($validator->hasMessages()) {
                foreach ($validator->getMessages() as $message) {
                    $this->addFieldError($message['field'],$this->modx->lexicon($message['message']));
                }
            }
        }

        $preventSave = $this->fireBeforeSaveEvent();
        if (!empty($preventSave)) {
            return $this->failure($preventSave);
        }

        /* save element */
        if ($this->object->save() == false) {
            $this->modx->error->checkValidation($this->object);
            return $this->failure($this->modx->lexicon($this->objectType.'_err_save'));
        }

        $this->afterSave();

        $this->fireAfterSaveEvent();
        $this->logManagerAction();
        return $this->cleanup();
    }

}
return 'msRevaluationProcessProcessor';
?>