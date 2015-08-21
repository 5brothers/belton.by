<?php
/**
 * Overrides the modResourceCreateProcessor to provide custom processor functionality for the msProduct type
 *
 * @package mSklad
 */

require_once MODX_CORE_PATH.'model/modx/modprocessor.class.php';
require_once MODX_CORE_PATH.'model/modx/processors/resource/create.class.php';
require_once MODX_CORE_PATH.'components/minishop2/processors/mgr/product/create.class.php';

class extendModResourceCreateProcessor extends modResourceCreateProcessor
{

	public static function getInstance(modX &$modx, $className, $properties = array())
	{
		$classKey = !empty($properties['class_key']) ? $properties['class_key'] : 'modDocument';
		$object = $modx->newObject($classKey);

		$className = 'msProductDisableCacheCreateProcessor';
		$processor = new $className($modx, $properties);
		return $processor;
	}
}

class msProductDisableCacheCreateProcessor extends msProductCreateProcessor
{

	public function checkParentPermissions() { //FIX disable checkParentPermissions to add children
//		return parent::checkParentPermissions();
		return true;
	}

	/**
	 * {@inheritDoc}
	 * @return * @return string|mixed
	 */
	public function prepareAlias() {
		$alias='';
		if ($this->modx->getOption('ms2_product_id_as_alias')) {
			$alias = 'empty-resource-alias';
			$this->setProperty('alias', $alias);
		}
		else {
			/* friendly url alias checks */
			$pageTitle = $this->getProperty('pagetitle');
			if ($this->modx->getOption('friendly_urls', false) && (!$this->getProperty('reloadOnly',false) || !empty($pageTitle))) {
				if ($this->modx->getOption('automatic_alias', false)) {
					$alias = $this->object->cleanAlias($pageTitle);
				}
				if (empty($alias)) {
					$alias = 'empty-resource-alias';
				}
				if ($this->modx->getOption('msklad_alias_with_id', false)) {
					$alias .= '-'.$this->object->id;
				}

				$this->setProperty('alias',$alias);
			}
		}
		return $alias;
	}

	public function afterSave() {  //FIX disable "Updating resourceMap before OnDocSaveForm event" and disable lock
		if ($this->object->alias == 'empty-resource-alias') {
			$this->object->set('alias', $this->object->id);
			$this->object->save();
		}

		// Updating resourceMap before OnDocSaveForm event
		$results = $this->modx->cacheManager->generateContext($this->object->context_key);
		$this->modx->context->resourceMap = $results['resourceMap'];
		$this->modx->context->aliasMap = $results['aliasMap'];

//		$this->object->addLock();
		$this->setParentToContainer();
		$this->saveResourceGroups();
		$this->checkIfSiteStart();
		return true;
	}

	public function cleanup() { //FIX disable clearCache and disable lock
//		$this->object->removeLock();
//		$this->clearCache();
		return $this->success('', array('id' => $this->object->get('id')));
	}


}

return 'extendModResourceCreateProcessor';