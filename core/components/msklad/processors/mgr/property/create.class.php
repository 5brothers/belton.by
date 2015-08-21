<?php
class propertyCreateProcessor extends modObjectCreateProcessor {
	public $classKey = 'mSkladProductProperty';
	public $languageTopics = array('msklad:properties');
	public $permission = 'new_document';

	public function beforeSet() {
		if ($this->modx->getObject('mSkladProductProperty',array('source' => $this->getProperty('source')))) {
			$this->modx->error->addField('source', $this->modx->lexicon('msklad_prop_source_err_ae'));
		}
		return !$this->hasErrors();
	}

}

return 'propertyCreateProcessor';