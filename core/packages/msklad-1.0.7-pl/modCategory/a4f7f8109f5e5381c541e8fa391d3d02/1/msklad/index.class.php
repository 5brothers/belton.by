<?php
/**
 * The main manager controller for mSklad.
 *
 * @package msklad
 */

require_once dirname(__FILE__) . '/model/msklad/msklad.class.php';

abstract class mSkladMainController extends modExtraManagerController {
	/** @var mSklad $mSklad */
	public $mSklad;

	public function initialize() {
		$this->mSklad = new mSklad($this->modx);
		
		$this->modx->regClientCSS($this->mSklad->config['cssUrl'].'mgr/main.css');
		$this->modx->regClientStartupScript($this->mSklad->config['jsUrl'].'mgr/msklad.js');
		$this->modx->regClientStartupHTMLBlock('<script type="text/javascript">
		Ext.onReady(function() {
			mSklad.config = '.$this->modx->toJSON($this->mSklad->config).';
			mSklad.config.connector_url = "'.$this->mSklad->config['connectorUrl'].'";
		});
		</script>');
		
		parent::initialize();
	}

	public function getLanguageTopics() {
		return array('msklad:default');
	}

	public function checkPermissions() { return true;}
}


class IndexManagerController extends mSkladMainController {
	public static function getDefaultController() { return 'home'; }
}