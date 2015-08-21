<?php
/**
 * Overrides the modResourceUpdateProcessor to provide custom processor functionality for the msCategory type
 *
 * @package mSklad
 */

require_once MODX_CORE_PATH.'model/modx/modprocessor.class.php';
require_once MODX_CORE_PATH.'model/modx/processors/resource/update.class.php';
require_once MODX_CORE_PATH.'components/minishop2/processors/mgr/category/update.class.php';

class extendModCategoryUpdateProcessor extends modResourceUpdateProcessor
{

	public static function getInstance(modX &$modx, $className, $properties = array())
	{
		$object = $modx->getObject('modResource',$properties['id']);
		$classKey = !empty($properties['class_key']) ? $properties['class_key'] : ($object ? $object->get('class_key') : 'modDocument');

		$className = 'msCategoryDisableCacheUpdateProcessor';
		$processor = new $className($modx, $properties);
		return $processor;
	}
}

class msCategoryDisableCacheUpdateProcessor extends msCategoryUpdateProcessor
{
	public function beforeSet() { //FIX disable lock
		$this->setProperties(array(
			'isfolder' => 1
		));

//		$locked = $this->addLock();
//		if ($locked !== true) {
//			if ($this->lockedUser) {
//				return $this->failure($this->modx->lexicon('resource_locked_by', array('id' => $this->object->get('id'), 'user' => $this->lockedUser->get('username'))));
//			} else {
//				return $this->failure($this->modx->lexicon('access_denied'));
//			}
//		}

		/* RTE workaround */
		$properties = $this->getProperties();
		if (isset($properties['ta'])) $this->setProperty('content', $properties['ta']);

		$this->workingContext = $this->modx->getContext($this->getProperty('context_key'));

		$this->trimPageTitle();
		$this->handleParent();
		$this->checkParentContext();
		$this->handleCheckBoxes();
		$this->checkFriendlyAlias();
		$this->setPublishDate();
		$this->setUnPublishDate();
		$this->checkPublishedOn();
		$this->checkPublishingPermissions();
		$this->checkForUnPublishOnSiteStart();
		$this->checkDeletedStatus();
		$this->handleResourceProperties();
		$this->unsetProperty('variablesmodified');

		return !$this->hasErrors();
	}


	public function cleanup() { //FIX disable clearCache and disable lock
//		$this->object->removeLock();
//		$this->clearCache();

		$returnArray = $this->object->get(array_diff(array_keys($this->object->_fields), array('content', 'ta', 'introtext', 'description', 'link_attributes', 'pagetitle', 'longtitle', 'menutitle', 'properties')));
		foreach ($returnArray as $k => $v) {
			if (strpos($k, 'tv') === 0) {
				unset($returnArray[$k]);
			}
		}
		$returnArray['class_key'] = $this->object->get('class_key');
		$this->workingContext->prepare(true);
		$returnArray['preview_url'] = $this->modx->makeUrl($this->object->get('id'), $this->object->get('context_key'), '', 'full');
		return $this->success('', $returnArray);
	}
}

return 'extendModCategoryUpdateProcessor';