<?php

class propertyUpdateProcessor extends modObjectUpdateProcessor {
	public $classKey = 'mSkladProductProperty';
	public $languageTopics = array('msklad');
	public $permission = 'edit_document';

	public function beforeSet() {
		if ($this->modx->getObject('mSkladProductProperty',array('source' => $this->getProperty('source'), 'id:!=' => $this->getProperty('id') ))) {
			$this->modx->error->addField('source', $this->modx->lexicon('msklad_err_ae'));
		}
		return parent::beforeSet();
	}

}

return 'propertyUpdateProcessor';