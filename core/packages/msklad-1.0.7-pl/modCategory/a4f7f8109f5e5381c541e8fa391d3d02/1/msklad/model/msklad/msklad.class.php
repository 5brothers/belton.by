<?php
/**
 * The base class for mSklad.
 *
 * @package msklad
 */

class mSklad {
	/* @var modX $modx */
	public $modx;
	/* @var mSkladControllerRequest $request */
	protected $request;
	public $initialized = array();


	function __construct(modX &$modx,array $config = array()) {
		$this->modx =& $modx;

		$corePath = $this->modx->getOption('msklad_core_path', $config, $this->modx->getOption('core_path').'components/msklad/');
		$assetsUrl = $this->modx->getOption('msklad_assets_url', $config, $this->modx->getOption('assets_url').'components/msklad/');
		$connectorUrl = $assetsUrl.'connector.php';

		$this->config = array_merge(array(
			'assetsUrl' => $assetsUrl
			,'cssUrl' => $assetsUrl.'css/'
			,'jsUrl' => $assetsUrl.'js/'
			,'imagesUrl' => $assetsUrl.'images/'

			,'connectorUrl' => $connectorUrl

			,'corePath' => $corePath
            ,'assetsPath' => $this->modx->getOption('assets_path').'components/msklad/'
			,'modelPath' => $corePath.'model/'
			,'chunksPath' => $corePath.'elements/chunks/'
			,'templatesPath' => $corePath.'elements/templates/'
			,'chunkSuffix' => '.chunk.tpl'
			,'snippetsPath' => $corePath.'elements/snippets/'
			,'processorsPath' => $corePath.'processors/'

            ,'sync_direction'=>$this->modx->getOption('msklad_sync_direction')
            ,'debug'=>$this->modx->getOption('msklad_debug')
            ,'restUrl'=>'https://online.moysklad.ru/exchange/rest/ms/xml/'
            ,'Username'=>$this->modx->getOption('msklad_api_username')
            ,'Password'=>$this->modx->getOption('msklad_api_password')
            ,'SalePriceType'=>$this->modx->getOption('msklad_price_type_uuid')
            ,'Uom'=>$this->modx->getOption('msklad_uom_type_uuid')

            ,'commercMlLink'=> MODX_SITE_URL.'assets/components/msklad/1c_exchange.php'
		),$config);

		$this->modx->addPackage('msklad', $this->config['modelPath']);
		$this->modx->lexicon->load('msklad:default');
	}


	/**
	 * Initializes mSklad into different contexts.
	 *
	 * @access public
	 * @param string $ctx The context to load. Defaults to web.
	 */
	public function initialize($ctx = 'web', $scriptProperties = array()) {
		$this->config = array_merge($this->config, $scriptProperties);
		$this->config['ctx'] = $ctx;
		if (!empty($this->initialized[$ctx])) {
			return true;
		}
		switch ($ctx) {
			case 'mgr': break;
			case 'web':
                require_once dirname(__FILE__) . '/mskladcataloghandler.class.php';
                $catalog_class = $this->modx->getOption('msklad_catalog_handler_class', null, 'mskladCatalogHandler');
                if ($catalog_class != 'mskladCatalogHandler') {$this->loadCustomClasses('catalog');}
                if (!class_exists($catalog_class)) {$catalog_class = 'mskladCatalogHandler';}

                $this->catalog = new $catalog_class($this, $this->config);
                if (!($this->catalog instanceof mskladCatalogInterface) || $this->catalog->initialize($ctx) !== true) {
                    $this->modx->log(modX::LOG_LEVEL_ERROR, 'Could not initialize mSklad catalog handler class: "'.$catalog_class.'"');
                    return false;
                }

                require_once dirname(__FILE__) . '/mskladsalehandler.class.php';
                $sale_class = $this->modx->getOption('msklad_sale_handler_class', null, 'mskladSaleHandler');
                if ($sale_class != 'mskladSaleHandler') {$this->loadCustomClasses('catalog');}
                if (!class_exists($sale_class)) {$sale_class = 'mskladSaleHandler';}

                $this->sale = new $sale_class($this, $this->config);
                if (!($this->sale instanceof mskladSaleInterface) || $this->sale->initialize($ctx) !== true) {
                    $this->modx->log(modX::LOG_LEVEL_ERROR, 'Could not initialize mSklad sale handler class: "'.$sale_class.'"');
                    return false;
                }
			break;
			default:
				/* if you wanted to do any generic frontend stuff here.
				 * For example, if you have a lot of snippets but common code
				 * in them all at the beginning, you could put it here and just
				 * call $msklad->initialize($modx->context->get('key'));
				 * which would run this.
				 */
			break;
		}
	}


	/**
	 * Gets a Chunk and caches it; also falls back to file-based templates
	 * for easier debugging.
	 *
	 * @access public
	 * @param string $name The name of the Chunk
	 * @param array $properties The properties for the Chunk
	 * @return string The processed content of the Chunk
	 */
	public function getChunk($name,array $properties = array()) {
		$chunk = null;
		if (!isset($this->chunks[$name])) {
			$chunk = $this->modx->getObject('modChunk',array('name' => $name),true);
			if (empty($chunk)) {
				$chunk = $this->_getTplChunk($name,$this->config['chunkSuffix']);
				if ($chunk == false) return false;
			}
			$this->chunks[$name] = $chunk->getContent();
		} else {
			$o = $this->chunks[$name];
			$chunk = $this->modx->newObject('modChunk');
			$chunk->setContent($o);
		}
		$chunk->setCacheable(false);
		return $chunk->process($properties);
	}


	/**
	 * Returns a modChunk object from a template file.
	 *
	 * @access private
	 * @param string $name The name of the Chunk. Will parse to name.chunk.tpl by default.
	 * @param string $suffix The suffix to add to the chunk filename.
	 * @return modChunk/boolean Returns the modChunk object if found, otherwise
	 * false.
	 */
	private function _getTplChunk($name,$suffix = '.chunk.tpl') {
		$chunk = false;
		$f = $this->config['chunksPath'].strtolower($name).$suffix;
		if (file_exists($f)) {
			$o = file_get_contents($f);
			$chunk = $this->modx->newObject('modChunk');
			$chunk->set('name',$name);
			$chunk->setContent($o);
		}
		return $chunk;
	}


    /**
     * Write REST log
     * @return void
     */
    public function restLog($name,$request) {
        $file = fopen (MODX_CORE_PATH."components/msklad/logs/".date("dmy_His").'_'.round(microtime(1) * 1000).'_'.$name.".txt","w");
        if ( $file ){
            fputs ( $file, print_r($request,true));
        }
        fclose ($file);
    }

    /**
     * Clearing cache
     * @return void
     */
    public function clearCache($context = null) {
        $this->modx->cacheManager->refresh();
    }

	public function utf_json_encode($arr)
	{
		return preg_replace_callback(
			'/\\\u([0-9a-fA-F]{4})/', create_function('$_m', 'return mb_convert_encoding("&#" . intval($_m[1], 16) . ";", "UTF-8", "HTML-ENTITIES");'),
			json_encode($arr)
		);
	}
}