<?php
class msRevaluationHomeManagerController extends msRevaluationManagerController {
    public function process(array $scriptProperties = array()) {
 
    }
    public function getPageTitle(){
        return $this->modx->lexicon('minishop2').' :: '.$this->modx->lexicon('revaluation');
    }
    public function loadCustomCssJs(){
        $this->addJavascript($this->msRevaluation->config['assets_url'].'js/mgr/widgets/msrevaluation.grid.js');
        $this->addJavascript($this->msRevaluation->config['assets_url'].'js/mgr/widgets/msrevaluation.form.js');
        $this->addJavascript($this->msRevaluation->config['assets_url'].'js/mgr/widgets/home.panel.js');
        $this->addLastJavascript($this->msRevaluation->config['assets_url'].'js/mgr/sections/index.js');
    }
    public function getTemplateFile(){
        return $this->msRevaluation->config['core_path']."elements/templates/home.tpl";
    }
}
?>