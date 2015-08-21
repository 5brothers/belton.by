<?php
/**
 * The home manager controller for mSklad.
 *
 * @package msklad
 */
class mSkladHomeManagerController extends mSkladMainController {
	/* @var mSklad $mSklad */
	public $mSklad;


	public function process(array $scriptProperties = array()) {}
	

	public function getPageTitle() { return $this->modx->lexicon('msklad'); }


    public function getLanguageTopics() {
        return array('msklad:default','msklad:api','msklad:category','msklad:product','msklad:export');
    }
	

	public function loadCustomCssJs() {
        $this->modx->regClientStartupScript($this->mSklad->config['jsUrl'].'mgr/widgets/config.panel.js');
		$this->modx->regClientStartupScript($this->mSklad->config['jsUrl'].'mgr/widgets/sync.panel.js');
		$this->modx->regClientStartupScript($this->mSklad->config['jsUrl'].'mgr/widgets/standart-property.grid.js');
		$this->modx->regClientStartupScript($this->mSklad->config['jsUrl'].'mgr/widgets/property.grid.js');
		$this->modx->regClientStartupScript($this->mSklad->config['jsUrl'].'mgr/widgets/home.panel.js');
	 	$this->modx->regClientStartupScript($this->mSklad->config['jsUrl'].'mgr/sections/home.js');
	}
	

	public function getTemplateFile() {
		return $this->mSklad->config['templatesPath'].'home.tpl';
	}
}