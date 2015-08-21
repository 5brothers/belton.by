<?php
class propertyRemoveProcessor extends modObjectRemoveProcessor {
	public $checkRemovePermission = true;
	public $classKey = 'mSkladProductProperty';
	public $languageTopics = array('msklad');

	public function beforeRemove() {
		return parent::beforeRemove();
	}

}
return 'propertyRemoveProcessor';