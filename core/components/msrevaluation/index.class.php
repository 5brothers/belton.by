<?php
    error_reporting(E_ALL | E_STRICT);
    ini_set('display_errors', 1);
	require_once dirname(__FILE__) . '/model/msrevaluation/msrevaluation.class.php';
    abstract class msRevaluationManagerController extends modExtraManagerController {
        public $msrevaluation;
        public function initialize() {
            $this->msRevaluation = new msRevaluation($this->modx);
            
            $this->addJavascript($this->msRevaluation->config['assets_url'].'js/mgr/msrevaluation.js');
            $this->addHtml('<script type="text/javascript">
            Ext.onReady(function() {
                msRevaluation.config = '.$this->modx->toJSON($this->msRevaluation->config).';
            });
            </script>');
            return parent::initialize();
        }
        public function getLanguageTopics() {
            return array('msrevaluation:default');
        }
        public function checkPermissions() { return true;}
    }
    class IndexManagerController extends msRevaluationManagerController {
        public static function getDefaultController() { return 'home'; }
    }
?>