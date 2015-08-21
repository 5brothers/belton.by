<?php
require_once MODX_CORE_PATH.'model/modx/modprocessor.class.php';
//require_once MODX_CORE_PATH.'model/modx/processors/resource/create.class.php';
require_once MODX_PROCESSORS_PATH.'resource/create.class.php';

class mskladCreateResourceClass  extends modResourceCreateProcessor{

	/**
	 * Create the modResource object for manipulation
	 * @return string|modResource
	 */
	public function initialize() {
		/* get the class_key to determine classKey and resourceDir */
		$classKey = $this->getProperty('class_key','modDocument');
		$this->classKey = !empty($classKey) ? $classKey : 'modDocument';
		$initialized = parent::initialize();
		if (!$initialized) return $this->modx->lexicon('resource_err_create');
		if (!$this->object instanceof $this->classKey) return $this->modx->lexicon('resource_err_class',array('class' => $this->classKey));

		return $initialized;
	}

	/**
	 * {@inheritDoc}
	 * @return mixed
	 */
	public function cleanup() {
		$this->object->removeLock();
		$this->modx->log(modX::LOG_LEVEL_ERROR, '[mSklad] cleanup');
		$this->modx->log(modX::LOG_LEVEL_ERROR, '[mSklad] syncsite '.$this->getProperty('syncsite',false));
		$this->modx->log(modX::LOG_LEVEL_ERROR, '[mSklad] clearCache '.$this->getProperty('clearCache',false));

		$this->clearCache();

		return $this->success('', array('id' => $this->object->get('id'), 'clear'=>'cleanup'));
//		return parent::cleanup();
	}

	public function clearCache() {
		$this->modx->log(modX::LOG_LEVEL_ERROR, '[mSklad] clearcache');
		$this->modx->log(modX::LOG_LEVEL_ERROR, '[mSklad] syncsite '.$this->getProperty('syncsite',false));
		$this->modx->log(modX::LOG_LEVEL_ERROR, '[mSklad] clearCache '.$this->getProperty('clearCache',false));

		$clear = $this->getProperty('syncsite',false) || $this->getProperty('clearCache',false);
		$this->modx->log(modX::LOG_LEVEL_ERROR, '[mSklad] clearcache clear='.$clear);
		if ($clear) {
			$this->modx->cacheManager->refresh(array(
				'db' => array(),
				'auto_publish' => array('contexts' => array($this->workingContext->get('key'))),
				'context_settings' => array('contexts' => array($this->workingContext->get('key'))),
				'resource' => array('contexts' => array($this->workingContext->get('key'))),
			));
		}
		return $clear;
	}
}

return 'mskladCreateResourceClass';