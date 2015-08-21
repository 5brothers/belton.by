<?php

interface mskladCatalogInterface {

    /* Initializes cart to context
     * Here you can load custom javascript or styles
     *
     * @param string $ctx Context for initialization
     *
     * @return boolean
     * */
    public function initialize($ctx = 'web');

    /* checkauth the catalog
     *
     * @return array|string $response
     * */
    public function checkauth();

    /* init the catalog
     *
     * @return array|string $response
     * */
    public function init();


    /* load catalog file
     *
     * @param string $filename The filename of catalog
     *
     * @param string $file The file of catalog
     *
     * @return array|string $response
     * */
    public function file($filename, $file);

    /* import catalog
     *
     * @param string $filename The filename of catalog
     *
     * @param string $file The file of catalog
     *
     * @return array|string $response
     * */
    public function import($filename, $file);

}


class mskladCatalogHandler implements mskladCatalogInterface {
    /* @var modX $modx */
    public $modx;
    protected $options = array();
	protected $properties = array();
    protected $catalog;

    function __construct(mSklad & $msklad, array $config = array()) {
        $this->msklad = & $msklad;
        $this->modx = & $msklad->modx;

        $this->config = array_merge(array(
            'json_response' => false
            ,'temp_dir' => $this->modx->getOption('msklad_assets_path', $config, $this->modx->getOption('assets_path').'components/msklad/1c_temp/')
            ,'sync_direction' => $this->modx->getOption('msklad_sync_direction', $config, 1)
            ,'quantity_tv' => $this->modx->getOption('msklad_quantity_tv')
			,'price_by_feature_tv' => $this->modx->getOption('msklad_price_by_feature_tv',null,'')
            ,'catalog_root_id' => $this->modx->getOption('msklad_catalog_root_id',$config,0)
            ,'catalog_context' => $this->modx->getOption('msklad_catalog_context',$config,'web')
            ,'user_id_import' => $this->modx->getOption('msklad_user_id_import',$config,1)
            ,'publish_default' => $this->modx->getOption('msklad_publish_default',$config,0)
			,'time_limit' => $this->modx->getOption('msklad_time_limit',$config,60)
			,'product_source' => $this->modx->getOption('ms2_product_source_default', $config, 1)
			,'product_template' => $this->modx->getOption('msklad_template_product_default', $config, '')
			,'category_template' => $this->modx->getOption('msklad_template_category_default', $config, '')
			,'create_properties_tv' => $this->modx->getOption('msklad_create_properties_tv',null,'')
			,'save_properties_to_tv' => $this->modx->getOption('msklad_save_properties_to_tv',null,'')
			,'import_all_prices' => $this->modx->getOption('msklad_import_all_prices',null,false)
			,'publish_by_quantity' => $this->modx->getOption('msklad_publish_by_quantity',null,false)
        ),$config);

        $this->catalog = & $this->config['catalog'];
        $this->modx->lexicon->load('msklad:catalog');

        if (empty($this->catalog) || !is_array($this->catalog)) {
            $this->catalog = array();
        }

		$this->config['start_time'] = microtime(true);
		$this->config['max_exec_time'] = min($this->config['time_limit'], @ini_get("max_execution_time"));
		if(empty($this->config['max_exec_time'])) $this->config['max_exec_time'] = 60;
		$this->modx->user = $this->modx->getObject('modUser', $this->config['user_id_import']);


		$this->options = array(
			'start'				=> (!isset($_SESSION['totalCategories']))? 1 : 0
			,'finish' 			=> isset($_SESSION['importFinish'])? $_SESSION['importFinish'] : 0
			,'lastCategory' 	=> isset($_SESSION['lastCategory'])? $_SESSION['lastCategory'] : 0
			,'totalCategories' 	=> isset($_SESSION['totalCategories'])? $_SESSION['totalCategories'] : 0
			,'lastProperty' 	=> isset($_SESSION['lastProperty'])? $_SESSION['lastProperty'] : -1
			,'totalProperties' 	=> isset($_SESSION['totalProperties'])? $_SESSION['totalProperties'] : 0
			,'lastImportProduct'=> isset($_SESSION['lastImportProduct'])? $_SESSION['lastImportProduct'] : 0
			,'lastProduct' 		=> isset($_SESSION['lastProduct'])? $_SESSION['lastProduct'] : 0
			,'totalProducts' 	=> isset($_SESSION['totalProducts'])? $_SESSION['totalProducts'] : 0
		);
    }


    /* @inheritdoc} */
    public function initialize($ctx = 'web') {
        return true;
    }

    /* @inheritdoc} */
    public function checkauth() {
		if($this->config['debug']){
			$this->modx->msklad->restLog('import_catalog_checkauth',$_SERVER);
		}

		if(!$this->checkCatalogRoot()) return 'failure'.PHP_EOL.'Please see errors in MODX log'.PHP_EOL;
        return 'success'.PHP_EOL.session_name().PHP_EOL.session_id();
    }

    /* @inheritdoc} */
    public function init() {
		if($this->config['debug']){
			$this->modx->msklad->restLog('import_catalog_init',$_SERVER);
		}

        $tmp_files = glob($this->config['temp_dir'].'*.*');
        if(is_array($tmp_files)){
            foreach($tmp_files as $v){
                unlink($v);
            }
		}

		unset($_SESSION['last_1c_offer']);
		unset($_SESSION['importFinish']);
        unset($_SESSION['lastCategory']);
        unset($_SESSION['totalCategories']);
		unset($_SESSION['lastProperty']);
		unset($_SESSION['totalProperties']);
		unset($_SESSION['lastImportProduct']);
		unset($_SESSION['lastProduct']);
		unset($_SESSION['totalProducts']);
        unset($_SESSION['categories_mapping']);
		unset($_SESSION['properties_mapping']);
		unset($_SESSION['feature_mapping']);
		unset($_SESSION['price_mapping']);

		$_SESSION['feature_mapping'] = array();

        return 'zip=no'.PHP_EOL.'file_limit=1000000'.PHP_EOL;
    }

    /* @inheritdoc} */
    public function file($filename='',$file) {
		if($this->config['debug']){
			$this->modx->msklad->restLog('import_catalog_file',$_REQUEST);
		}
        if($filename) {
            $filename = basename($filename);

            $f = fopen($this->config['temp_dir'].$filename, 'ab');
            fwrite($f, $file);
            fclose($f);
            return 'success'.PHP_EOL;
        }

		$this->modx->log(modX::LOG_LEVEL_ERROR, '[mSklad] Ошибка импорта каталога, передано пустое имя файла (переменная filename)');
        return 'failure'.PHP_EOL.'Please see errors in MODX log'.PHP_EOL;
     }

    /* @inheritdoc} */
    public function import($filename='',$file) {
		@set_time_limit($this->config['time_limit']);

		$this->config['start_time'] = microtime(true);
		if($this->config['debug']){
			$this->modx->msklad->restLog('import_catalog_import',array('REQUEST'=>$_REQUEST,'SESSION'=>$_SESSION));
		}
        $out='';
        if($filename) {
            $filename = basename($filename);

            switch ($filename) {
                case 'import.xml':
					$out ='';

                    if($this->config['sync_direction']==1){ //Не используем импорт товаров и категорий из 1c при режиме 0

                        if (!file_exists($this->config['temp_dir'].$filename)) {
							$this->modx->log(modX::LOG_LEVEL_ERROR, '[mSklad] Ошибка импорта каталога, не существует файл '.$this->config['temp_dir'].$filename);
							return 'failure'.PHP_EOL.'Please see errors in MODX log'.PHP_EOL;
                        }

						//Check import step
						$step = $this->checkImportCatalogStep();
						switch ($step){
							case 'importCategories':
								$out = $this->importCategories($filename);
								break;

							case 'prepareCategories':
								$out = $this->prepareCategories();
								break;

							case 'importProperties':
								$out = $this->importProperties($filename);
								break;

							case 'importProducts':
								$out = $this->importProducts($filename);
								break;

							case 'prepareProducts':
								$out = $this->prepareProducts();
								break;

							case 'finish':
								$this->clearCache();
								$out = 'success'.PHP_EOL.' Выгружено категорий:'.$this->options['totalCategories'].PHP_EOL.' Выгружено товаров:'.$this->options['totalProducts'];
								break;

						}
                    }
                    else {
                        unset($_SESSION['last_1c_import']);
						$this->clearCache();
						$out = 'success'.PHP_EOL; //Сразу возвращаем выполнено
                    }

					return $out;
                    break;

                case 'offers.xml': //Импорт остатков
					if(!$this->config['quantity_tv']) {
						//$this->modx->log(modX::LOG_LEVEL_ERROR, '[mSklad] Внимание! Не настроен параметр "Tv параметр остатков" (msklad_quantity_tv), синхронизация остатков не будет произведена');
					}
                    $last_offer = 0;
                    if(isset($_SESSION['last_1c_offer']))
                        $last_offer = $_SESSION['last_1c_offer'];

					if (!file_exists($this->config['temp_dir'].$filename)) {
						$this->modx->log(modX::LOG_LEVEL_ERROR, '[mSklad] Ошибка импорта каталога, не существует файл '.$this->config['temp_dir'].$filename);
						return 'failure'.PHP_EOL.'Please see errors in MODX log'.PHP_EOL;
					}

					$offers = new XMLReader();

					if($last_offer==0){
						$offers->open($this->config['temp_dir'].$filename);
						while ($offers->read() && $offers->name !== 'ТипЦены');
						while($offers->name === 'ТипЦены'){
							$xml = new SimpleXMLElement($offers->readOuterXML());
							$priceId = addslashes((string) $xml->Ид);
							if(isset($xml->Наименование)) $_SESSION['price_mapping'][$priceId] = addslashes((string) $xml->Наименование);

							$offers->next('ТипЦены');
						}
						$offers->close();
					}

					$offers->open($this->config['temp_dir'].$filename);
					while ($offers->read() && $offers->name !== 'Предложение');

					//load properties
					$q = $this->modx->newQuery('mSkladProductProperty', array('active' => 1));
					$q->select($this->modx->getSelectColumns('mSkladProductProperty', 'mSkladProductProperty', '', array('id','source','type','target','active','default')));
					$q->limit(0);
					if ($q->prepare() && $q->stmt->execute()){
						$properties = $q->stmt->fetchAll(PDO::FETCH_ASSOC);
						foreach($properties as $val) $this->properties[$val['source']]=$val;
					}

					$this->msOptionsPriceTarget=false;
					$this->msOptionsPriceSource=false;
					if($this->modx->getOption('msoptionsprice_ms_op_active',null,false)){
						if($this->msOptionsPriceTarget = $this->modx->getOption('msoptionsprice_ms_op_options',null,false)){
							foreach($this->properties as $propertyArray){
								$key = array_search($this->msOptionsPriceTarget, $propertyArray);
								if($key === false) continue;
								else {
									$this->msOptionsPriceSource = $propertyArray['source'];
									break;
								}
							}
						}
					}



					$this_offer_num = 0;

					while($offers->name === 'Предложение'){
						if($this_offer_num >= $last_offer){
							$xml = new SimpleXMLElement($offers->readOuterXML());

							//Остатки и цены
							$this->loadStock($xml);
							$_SESSION['last_1c_offer'] = $this_offer_num;

							$exec_time = microtime(true) - $this->config['start_time'];
							if($exec_time+1>=$this->config['max_exec_time']){
								return 'progress'.PHP_EOL.'Выгружено ценовых предложений:'.$this_offer_num.PHP_EOL;
							}
						}
						$offers->next('Предложение');
						$this_offer_num ++;
					}
					$offers->close();

					return 'success'.PHP_EOL.'Выгружено ценовых предложений:'.$this_offer_num.PHP_EOL;
                    break;

                default:
                    break;

            }
        }
		$this->modx->log(modX::LOG_LEVEL_ERROR, '[mSklad] Ошибка импорта каталога, передано пустое имя файла (переменная filename)');
		return 'failure'.PHP_EOL.'Please see errors in MODX log'.PHP_EOL;
    }

	/**
	 * Check step of import to catalog
	 *
	 * @return string
	 */
	private function checkImportCatalogStep(){
		$start = $this->options['start'];
		$finish = $this->options['finish'];

		$lastCategory = $this->options['lastCategory'];
		$totalCategories = $this->options['totalCategories'];

		$lastProperty = $this->options['lastProperty'];
		$totalProperties = $this->options['totalProperties'];

		$lastImportProduct = $this->options['lastImportProduct'];
		$lastProduct = $this->options['lastProduct'];
		$totalProducts = $this->options['totalProducts'];

		if($start) return 'importCategories';
		if($finish) return 'finish';

		if($lastCategory<$totalCategories) return 'prepareCategories';

		if($lastProperty<$totalProperties) return 'importProperties';

		if(!$totalProducts) return 'importProducts';

		if($lastProduct<$totalProducts) return 'prepareProducts';

		return 'finish';
	}

	/**
	 * Import categories to temp table
	 *
	 * @param $filename
	 *
	 * @return bool|int
	 */
	private function importCategories($filename){
		//clear temp category table
		$this->modx->exec("TRUNCATE TABLE {$this->modx->getTableName('mSkladCategoryTemp')}");

		//read xml file
		$reader = new XMLReader;
		$reader->open($this->config['temp_dir'].$filename);

		//search categories
		while ($reader->read() && $reader->name !== 'Группы');
		$xml = new SimpleXMLElement($reader->readOuterXML());
		$reader->close();

		$this->importCategory($xml);

		$totalCategories = intval($this->getTotalCategories());
		$this->options['totalCategories'] = $_SESSION['totalCategories'] = $totalCategories;

		return 'progress'.PHP_EOL.'Категории выгружены в временную таблицу'.PHP_EOL;
	}

	/**
	 * Import category to temp table
	 *
	 * @param $xml
	 * @param int $parent_id
	 * @param int $level
	 */
	private function importCategory($xml, $parent_id=0, $level=0) {
		if(isset($xml->Группа)){
			foreach ($xml->Группа as $xml_group){
				$cat_name = isset($xml_group->Наименование)? addslashes((string) $xml_group->Наименование): '';
				$cat_uuid = isset($xml_group->Ид)? addslashes((string) $xml_group->Ид) : '';

				$sql = "INSERT INTO ".$this->modx->getTableName('mSkladCategoryTemp')." (`name`, `uuid`, `parent_uuid`, `level`) VALUES
						('{$cat_name}', '{$cat_uuid}', '{$parent_id}', '{$level}');";

				$stmt = $this->modx->prepare($sql);
				$stmt->execute();

				if(isset($xml_group->Группы)) $this->importCategory($xml_group->Группы, $cat_uuid, $level+1);
			}
		}
	}

	/**
	 * Get total num categories in temp table
	 *
	 * @return bool|int
	 */
	private function getTotalCategories(){
		$c = $this->modx->newQuery('mSkladCategoryTemp');
		$total = $this->modx->getCount('mSkladCategoryTemp', $c);
		if($total) return $total;

		return false;
	}

	/**
	 * Prepare categories
	 *
	 * @return string
	 */
	private function prepareCategories(){
		$lastCategory = $this->options['lastCategory'];
		$totalCategories = $this->options['totalCategories'];

		//get 500 categories from temp table to import
		$q = $this->modx->newQuery('mSkladCategoryTemp');
		$q->select($this->modx->getSelectColumns('mSkladCategoryTemp', 'mSkladCategoryTemp', '', array('id','name','uuid','parent_uuid','level')));
		$q->sortby('level ASC, id','ASC');
		$q->limit(500,$lastCategory);

		if ($q->prepare() && $q->stmt->execute()){
			$categoriesData = $q->stmt->fetchAll(PDO::FETCH_ASSOC);

			if(is_array($categoriesData) && count($categoriesData)>0){
				foreach($categoriesData as $categoryData){
					$this->prepareCategory($categoryData);

					++$lastCategory;
					$_SESSION['lastCategory'] = $lastCategory;

					//if exec time more max time, break cycle
					$exec_time = microtime(true) - $this->config['start_time'];
					if($exec_time+1>=$this->config['max_exec_time']){
						break;
					}
				}
			}
		}

		return 'progress'.PHP_EOL.'Импортировано категорий '.$lastCategory.' из '.$totalCategories.PHP_EOL;
	}

	/**
	 * Prepare data to create or update miniShop2 category
	 *
	 * @param $categoryData
	 */
	private function prepareCategory($categoryData) {

		//write log
		if($this->config['debug']){
			$this->modx->msklad->restLog('import_catalog_updateCategory_'.$categoryData['uuid'],$categoryData);
		}

		//Checking prepare or not this category
		if(!isset($_SESSION['categories_mapping'][$categoryData['uuid']])){
			$categoryId=0;

			//get parent id
			$parent_uuid = $categoryData['parent_uuid'];
			if(!$parent_uuid){
				$parentId = $this->config['catalog_root_id'];
			}
			else $parentId = isset($_SESSION['categories_mapping'][$parent_uuid]) ? $_SESSION['categories_mapping'][$parent_uuid] : $this->config['catalog_root_id'];

			//clear modx errors
			$this->modx->error->message = null;
			$this->modx->error->errors = array();

			//get mSkladCategoryData object
			$catData=$this->modx->getObject( 'mSkladCategoryData', array('uuid_1c' => $categoryData['uuid']) );
			if($catData){
				$categoryId = $catData->get('category_id');

				//if isset msCategory object, then update
				if($category=$this->modx->getObject( 'msCategory', array('class_key' => 'msCategory','id' => $categoryId) ) ){
					$response = $this->updateMsCategory($parentId, $categoryId, $categoryData['name']);
				}
				//else create new msCategory object
				else{
					$response = $this->createMsCategory($parentId, $categoryData['name']);
					//add category id/uuid
					if($response){
						//update new mSkladCategoryData object
						$categoryId = $response->response['object']['id'];
						$catData->set('category_id',$categoryId);
						$catData->set('uuid_1c',$categoryData['uuid']);
						$catData->save();
					}
				}
			}
			//mSkladCategoryData object not found
			else{
				//create new msCategory object
				$response = $this->createMsCategory($parentId, $categoryData['name']);
				//add category id/uuid
				if($response){
					//create new mSkladCategoryData object
					$categoryId = $response->response['object']['id'];
					$newCatData = $this->modx->newObject('mSkladCategoryData');
					$newCatData->set('category_id',$categoryId);
					$newCatData->set('uuid_1c',$categoryData['uuid']);
					$newCatData->save();
				}
			}

			$_SESSION['categories_mapping'][strval($categoryData['uuid'])] = $categoryId;
		}
	}

	/**
	 * Create new miniShop2 category
	 *
	 * @param $parentId
	 * @param $categoryName
	 * @return bool|mixed
	 */
	private function createMsCategory($parentId, $categoryName){
		$processorProps = array(
			'class_key' => 'msCategory'
			,'pagetitle' => $categoryName
			,'parent' => $parentId
			,'published'=>$this->config['publish_default']
			,'context_key' => $this->config['catalog_context']
			,'template' => $this->config['category_template']
		);
		$response = $this->modx->runProcessor('mgr/extend/createmscategory', $processorProps, array('processors_path'=>$this->config['processorsPath']));


		if (!$response->isError()) {
			return $response;
		}
		else return false;
	}

	/**
	 * Update miniShop2 category
	 *
	 * @param $parentId
	 * @param $categoryId
	 * @param $categoryName
	 * @return bool|mixed
	 */
	private function updateMsCategory($parentId, $categoryId, $categoryName){
		$processorProps = array(
			'id'=>$categoryId
			,'class_key' => 'msCategory'
			,'pagetitle' => $categoryName
			,'context_key' => $this->config['catalog_context']
		);
		if($parentId) $processorProps['parent'] = $parentId;
		$response = $this->modx->runProcessor('mgr/extend/updatemscategory', $processorProps, array('processors_path'=>$this->config['processorsPath']));

		if (!$response->isError()) {
			return $response;
		}
		else return false;
	}

	private function importProperties($filename){
		$lastProperty = $this->options['lastProperty'];
		$totalProperties = $this->options['totalProperties'];
		if($lastProperty<0) $lastProperty=0;

		//read xml file
		$reader = new XMLReader;
		$reader->open($this->config['temp_dir'].$filename);

		//search properties
		while ($reader->read() && $reader->name !== 'Свойства');

		if($reader->name != 'Свойства') {
			$reader->close();
			$_SESSION['lastProperty'] = 0;
			return 'progress';
		}

		$xml = new SimpleXMLElement($reader->readOuterXML());
		if(isset($xml->Свойство)){
			$totalProperties = count($xml->Свойство);
			$this->options['totalProperties'] = $_SESSION['totalProperties'] = $totalProperties;

			foreach ($xml->Свойство as $xml_property){
				if(!isset($xml_property->Ид)) continue;
				$propertyId = addslashes((string) $xml_property->Ид);
				$property = array();

				if(isset($xml_property->Наименование)) $property['Наименование']=addslashes((string) $xml_property->Наименование);

				//Property values
				if(isset($xml_property->ВариантыЗначений)){
					$propertyValues = (array) $xml_property->ВариантыЗначений;
					if(!empty($propertyValues)){
						$property['Значения']=array();
						foreach($propertyValues['Справочник'] as $xml_property_val ){
							$property['Значения'][ addslashes((string) $xml_property_val->ИдЗначения) ]=addslashes((string) $xml_property_val->Значение);
						}
					}
				}

				if(!empty($property)) $_SESSION['properties_mapping'][$propertyId] = $property;
				$lastProperty++;
			}
		}
		$reader->close();
		$this->options['lastProperty'] = $_SESSION['lastProperty'] = $lastProperty;

		return 'progress'.PHP_EOL.'Импортированы типы свойств'.PHP_EOL;
	}
	/**
	 * Import products to temp table
	 *
	 * @param $filename
	 * @return string
	 */
	private function importProducts($filename){
		// Последний товар, на котором остановились
		$lastImportProduct = $this->options['lastImportProduct'];

		$firstImport = empty($lastImportProduct)? 1 : 0;

		//clear temp category table
		if($firstImport) $this->modx->exec("TRUNCATE TABLE {$this->modx->getTableName('mSkladProductTemp')}");

		$reader = new XMLReader;
		$reader->open($this->config['temp_dir'].$filename);

		//search products
		while ($reader->read() && $reader->name !== 'Товар');

		// Номер текущего товара
		$currentImportProduct = 0;

		$prodSql=array();
		while($reader->name === 'Товар'){
			if($firstImport || $currentImportProduct > $lastImportProduct){
				$xml = new SimpleXMLElement($reader->readOuterXML());

				$prod_name = isset($xml->Наименование)? addslashes((string) $xml->Наименование): '';
				$prod_description = isset($xml->Описание)? addslashes((string) $xml->Описание) : '';

				//standart properties
				$prod_article = isset($xml->Артикул)? addslashes((string) $xml->Артикул) : '';
				$prod_manufacturer = isset($xml->Изготовитель)? addslashes((string) $xml->Изготовитель->Наименование) : '';
				$prod_bar_code = isset($xml->Штрихкод)? addslashes((string) $xml->Штрихкод) : '';

				//additional properties
				$prod_properties = array();
				if(isset($xml->ЗначенияСвойств)){
					foreach($xml->ЗначенияСвойств->ЗначенияСвойства as $xml_property){
						$propertyId = addslashes((string) $xml_property->Ид);
						$propertyData = $_SESSION['properties_mapping'][$propertyId];
						$propertyName = $propertyData['Наименование'];
						$propertyVal = addslashes((string) $xml_property->Значение);
						if(isset($propertyData['Значения'])) $propertyVal = $propertyData['Значения'][$propertyVal];
						if(!empty($propertyVal)) $prod_properties[$propertyName]=$propertyVal;
					}

				}
				if(isset($xml->СписокСвойствОписания)){
					foreach($xml->СписокСвойствОписания->СвойствоОписания as $xml_property){
						$propertyName = addslashes((string) $xml_property->Наименование);
						$propertyVal = addslashes((string) $xml_property->Значение);
						if(!empty($propertyVal)){
							if(!isset($prod_properties[$propertyName]) && !empty($propertyVal)) $prod_properties[$propertyName]=$propertyVal;
						}
					}
				}
				if(isset($xml->ЗначенияРеквизитов)){
					foreach($xml->ЗначенияРеквизитов->ЗначениеРеквизита as $xml_property){
						$propertyName = addslashes((string) $xml_property->Наименование);
						$propertyVal = addslashes((string) $xml_property->Значение);
						if($propertyName == 'ВидНоменклатуры' || $propertyName=='ТипНоменклатуры') continue;
						if(!empty($propertyVal)){
							if(!isset($prod_properties[$propertyName]) && !empty($propertyVal)) $prod_properties[$propertyName]=$propertyVal;
						}
					}
				}
				$prod_properties = addslashes( $this->modx->msklad->utf_json_encode( $prod_properties ) );
				//

				$prod_images = addslashes( $this->modx->msklad->utf_json_encode((array) $xml->Картинка) );
				$prod_features = addslashes( $this->modx->msklad->utf_json_encode((array) $xml->ХарактеристикиТовара) );

				$prod_uuid = isset($xml->Ид)? addslashes((string) $xml->Ид) : '';
				$prod_parent_uuid = isset($xml->Группы->Ид)? addslashes((string) $xml->Группы->Ид) : '';
				$prod_status = isset($xml->Статус)? addslashes((string) $xml->Статус) : '';



				if(count($prodSql)<200){
					$prodSql[]="('{$prod_name}', '{$prod_article}', '{$prod_manufacturer}', '{$prod_images}', '{$prod_bar_code}', '{$prod_description}', '{$prod_features}', '{$prod_properties}', '{$prod_uuid}', '{$prod_parent_uuid}', '{$prod_status}')";
				}
				else{
					$sql = "INSERT INTO ".$this->modx->getTableName('mSkladProductTemp')." (`name`, `article`, `manufacturer`, `images`, `bar_code`, `description`, `features`, `properties`, `uuid`, `parent_uuid`, `status`) VALUES
						   ".implode(',',$prodSql).";";

					$stmt = $this->modx->prepare($sql);
					$stmt->execute();

					$prodSql=array();
				}

				$lastImportProduct = $_SESSION['lastImportProduct'] = $currentImportProduct;

				//if exec time more max time, break cycle
				$exec_time = microtime(true) - $this->config['start_time'];
				if($exec_time+1>=$this->config['max_exec_time']){
					break;
				}
			}
			$reader->next('Товар');
			$currentImportProduct++;
		}
		$reader->close();

		//if isset insert query
		if(count($prodSql)>0){
			$sql = "INSERT INTO ".$this->modx->getTableName('mSkladProductTemp')." (`name`, `article`, `manufacturer`, `images`, `bar_code`, `description`, `features`, `properties`, `uuid`, `parent_uuid`, `status`) VALUES
				   ".implode(',',$prodSql).";";

			$stmt = $this->modx->prepare($sql);
			$stmt->execute();
		}
		else{
			if($totalProducts = $this->getTotalProducts()){
				$this->options['totalProducts'] = $_SESSION['totalProducts'] = $totalProducts;
			}
			//no products, finish import
			else{
				$_SESSION['importFinish']=1;
			}
		}

		return 'progress'.PHP_EOL.' Выгружено товаров в временную базу '.$lastImportProduct.PHP_EOL;
	}

	/**
	 * Get total num products in temp table
	 *
	 * @return bool|int
	 */
	private function getTotalProducts(){
		$c = $this->modx->newQuery('mSkladProductTemp');
		$total = $this->modx->getCount('mSkladProductTemp', $c);
		if($total) return $total;

		return false;
	}

	/**
	 * Prepare products
	 *
	 * @return string
	 */
	private function prepareProducts(){
		//Load properties
		$q = $this->modx->newQuery('mSkladProductProperty', array('active' => 1));
		$q->select($this->modx->getSelectColumns('mSkladProductProperty', 'mSkladProductProperty', '', array('id','source','type','target','active','default')));
		$q->limit(0);
		if ($q->prepare() && $q->stmt->execute()){
			$properties = $q->stmt->fetchAll(PDO::FETCH_ASSOC);
			foreach($properties as $val) $this->properties[$val['source']]=$val;
		}

		$lastProduct = $this->options['lastProduct'];
		$totalProducts = $this->options['totalProducts'];

		//get 500 products from temp table to import
		$q = $this->modx->newQuery('mSkladProductTemp');
		$q->select($this->modx->getSelectColumns('mSkladProductTemp', 'mSkladProductTemp', ''));
//		$q->select('mSkladProductTemp.*');
		$q->sortby('mSkladProductTemp.id','ASC');
		$q->limit(500,$lastProduct);


		if ($q->prepare() && $q->stmt->execute()){
			$productsData = $q->stmt->fetchAll(PDO::FETCH_ASSOC);
			if(is_array($productsData) && count($productsData)>0){
				foreach($productsData as $productData){
					$this->prepareProduct($productData);

					++$lastProduct;
					$_SESSION['lastProduct'] = $lastProduct;

					//if exec time more max time, break cycle
					$exec_time = microtime(true) - $this->config['start_time'];
					if($exec_time+1>=$this->config['max_exec_time']){
						break;
					}

				}
			}
		}
		return 'progress'.PHP_EOL.'Импортировано товаров '.$lastProduct.' из '.$totalProducts.PHP_EOL;
	}

	/**
	 * Prepare data to create or update miniShop2 product
	 *
	 * @param $productData
	 */
	private function prepareProduct($productData) {

		if($this->config['debug']){
			$this->modx->msklad->restLog('import_catalog_updateProduct_'.$productData['uuid'],$productData);
		}

		$categoryId=$this->config['catalog_root_id'];
		// Ид категории
		if(isset($_SESSION['categories_mapping'][$productData['parent_uuid']]))
			$categoryId = $_SESSION['categories_mapping'][$productData['parent_uuid']];
		else{
			$q = $this->modx->newQuery('mSkladCategoryData', array('uuid_1c' => $productData['parent_uuid']) );
			$q->select('category_id');
			if($this->modx->getCount('mSkladCategoryData', $q)){
				if($q->prepare() && $q->stmt->execute()){
					$categoryRes = $q->stmt->fetch(PDO::FETCH_ASSOC);
					$categoryId = $categoryRes['category_id'];
				}
			}
		}

		//clear modx errors
		$this->modx->error->message = null;
		$this->modx->error->errors = array();


		/* Properties block */
		$productAddData=array();
		$productAddTv=array();
		//prepare standart properties
		$productAddData['pagetitle']=$productData['name'];
		if(!empty($productData['description'])) $productAddData['content']=$productData['description'];
		if(isset($this->properties['Изготовитель'])){
			if($this->properties['Изготовитель']['type']==1){
				$productAddData[$this->properties['Изготовитель']['target']]=$productData['manufacturer'];
			}
			elseif($this->properties['Изготовитель']['type']==2){
				$productAddTv[$this->properties['Изготовитель']['target']]=$productData['manufacturer'];
			}
		}
		if(isset($this->properties['Артикул'])){
			if($this->properties['Артикул']['type']==1){
				$productAddData[$this->properties['Артикул']['target']]=$productData['article'];
			}
			elseif($this->properties['Артикул']['type']==2){
				$productAddTv[$this->properties['Артикул']['target']]=$productData['article'];
			}
		}


		//prepare other properties
		$productProperties = json_decode($productData['properties'],1);
		foreach($productProperties as $propertyName=>$propertyValue){
			if(isset($this->properties[$propertyName])){
				if($this->properties[$propertyName]['type']==1){
					$productAddData[$this->properties[$propertyName]['target']]=stripslashes($propertyValue);
				}
				elseif($this->properties[$propertyName]['type']==2){
					$productAddTv[$this->properties[$propertyName]['target']]=stripslashes($propertyValue);
				}
			}
			else{
				//create properties in msklad
				if(!empty($this->config['create_properties_tv'])){
					if(!$property=$this->modx->getObject( 'mSkladProductProperty', array('source' => $propertyName) ) ){ //check property object
						$tv = $this->modx->newObject('modTemplateVar');
						$tv->fromArray(array(
								'name' => $propertyName,
								'caption' => $propertyName,
								'description' => '',
								'type' => 'text',
								'rank' => 10,
							)
						);
						$tv->save();

						if(!empty($this->config['product_template'])){
							$tvTpl = $this->modx->newObject('modTemplateVarTemplate');
							$tvTpl->set('tmplvarid', $tv->get('id'));
							$tvTpl->set('templateid', $this->config['product_template']);
							$tvTpl->save();
						}


						$propertyObjectArray = array(
							'source' => $propertyName,
							'type' => 2,
							'target' => $propertyName,
							'active' => 1,
							'default' => 0,
						);

						$propertyObject = $this->modx->newObject('mSkladProductProperty');
						$propertyObject->fromArray($propertyObjectArray);
						$propertyObject->save();

						$this->properties[$propertyName] = $propertyObjectArray;
						$productAddTv[$propertyName]=$propertyValue;
					}
				}
			}
		}


		// create/update vendor
		if(isset($productAddData['vendor'])) {
			$productAddData['vendor'] = $this->updateMsProductVendor($productAddData['vendor']);
		}
		// fix color
		if(isset($productAddData['color'])){
			$productAddData['color'] = $this->propertyToArray($productAddData['color']);
		}
		// fix size
		if(isset($productAddData['size'])){
			$productAddData['size'] = $this->propertyToArray($productAddData['size']);
		}
		// fix tags
		if(isset($productAddData['tags'])){
			$productAddData['tags'] = $this->propertyToArray($productAddData['tags']);
		}
		/* Properties block end */


		// Ищем товар
		$productMode = 'create';
		$q = $this->modx->newQuery('mSkladProductData', array('uuid_1c' => $productData['uuid']) );
		$q->select('product_id');
		//find mSkladProductData
		if($this->modx->getCount('mSkladProductData', $q)){
			if($q->prepare() && $q->stmt->execute()){
				$productRes = $q->stmt->fetch(PDO::FETCH_ASSOC);
				$productId = $productRes['product_id'];
			}

			//find msProduct object
			$q = $this->modx->newQuery('msProduct', array('class_key' => 'msProduct','id' =>$productId) );
			$q->select('id');
			if($this->modx->getCount('msProduct', $q)){
				$productMode = 'update';
				$response = $this->updateMsProduct($categoryId,$productId,$productAddData);//$productData['name'],$productArticle='');
			}
			else{
				$response = $this->createMsProduct($categoryId,$productAddData);//$productData['name'],$productData['article'],$productData['description']);
				//add product id/uuid
				if($response){
					$productId = $response->response['object']['id'];
					$prodData=$this->modx->getObject( 'mSkladProductData', array('uuid_1c' => $productData['uuid']) );
					$prodData->set( 'product_id',$categoryId);
					$prodData->set( 'uuid_1c',$productData['uuid']);
					$prodData->save();
				}
			}

			if(!empty($productData['images'])){
				$images = (array) json_decode($productData['images'],true);

				//upload product images
				$this->uploadImagesMsProduct($productId,$productData['name'],$images);
			}
		}
		else{
			$response = $this->createMsProduct($categoryId,$productAddData);//$productData['name'],$productData['article'],$productData['description']);

			//add product id/uuid
			if (!$response->isError()) {
				$productId = $response->response['object']['id'];
				$newProdData = $this->modx->newObject('mSkladProductData');
				$newProdData->set( 'product_id',$productId);
				$newProdData->set( 'uuid_1c',$productData['uuid']);
				$newProdData->save();

				if(!empty($productData['images'])){
					$images = (array) json_decode($productData['images'],true);

					$this->uploadImagesMsProduct($productId,$productData['name'],$images);
				}

			}
			else{
				$this->modx->log(modX::LOG_LEVEL_ERROR, '[mSklad] Ошибка создания товара ('.$productData['name'].'), импорт остановлен'."\r\n".print_r($response->getResponse(),1));
			}

		}

		//add properties to product
		$this->setProductTvs($productId,$productAddTv);

		if($product=$this->modx->getObject( 'msProduct', array('class_key' => 'msProduct','id' =>$productId) ) ){
			//save all properties to tv
			if(!empty($this->config['save_properties_to_tv']) && !empty($productData['properties'])){
				$product->setTVValue($this->config['save_properties_to_tv'], stripslashes($productData['properties']));
			}

			$this->modx->invokeEvent('mskladOnProductImport',array(
				'mode' 			=> $productMode,
				'resource'		=> &$product,
				'properties' 	=> json_decode($productData['properties'],1)
			));


			// Если нужно - удаляем вариант или весь товар
			if($productData['status'] == 'Удален'){
				if($product=$this->modx->getObject( 'msProduct', array('class_key' => 'msProduct','id' =>$productId) ) ){
					$product->set('deleted', 1);
					$product->set('deletedby', $this->config['user_id_import']);
					$product->set('deletedon', time());
					$product->save();
				}
			}
		}

	}

	/**
	 * Create new miniShop2 product
	 *
	 * @param $categoryId
	 * @param $productName
	 * @param string $productArticle
	 * @param string $productDescription
	 * @return bool|mixed
	 */
	private function createMsProduct($categoryId,$productAddData){ //$productName,$productArticle='',$productDescription=''){
		$processorProps = array_merge(array(
			'class_key' => 'msProduct'
			,'parent' => $categoryId
			,'published'=>$this->config['publish_default']
			,'context_key' => $this->config['catalog_context']
			,'source' => $this->config['product_source']
			,'template' => $this->config['product_template']
		),$productAddData);
		$response = $this->modx->runProcessor('mgr/extend/createmsproduct', $processorProps, array('processors_path'=>$this->config['processorsPath']));

		if (!$response->isError()) {
			return $response;
		}
		else {
			$this->modx->log(modX::LOG_LEVEL_ERROR, '[mSklad] Ошибка создания товара ('.$productAddData['pagetitle'].'), импорт остановлен'."\r\n".print_r($response->getResponse(),1));
			return false;
		}
	}

	/**
	 * Update miniShop2 product
	 *
	 * @param $categoryId
	 * @param $productId
	 * @param $productName
	 * @param string $productArticle
	 * @return bool|mixed
	 */
	private function updateMsProduct($categoryId,$productId,$productAddData){//,$productName,$productArticle=''){
		$processorProps = array_merge(array(
			'id'=>$productId
			,'class_key' => 'msProduct'
			,'context_key' => $this->config['catalog_context']
			,'source' => $this->config['product_source']
		),$productAddData);
		if(!empty($categoryId)) $processorProps['parent']=$categoryId;
		$response = $this->modx->runProcessor('mgr/extend/updatemsproduct', $processorProps, array('processors_path'=>$this->config['processorsPath']));
		if (!$response->isError()) {
			return $response;
		}
		else {
			$this->modx->log(modX::LOG_LEVEL_ERROR, '[mSklad] Ошибка обновления товара ('.$productAddData['pagetitle'].' '.$productId.'), импорт остановлен'."\r\n".print_r($response->getResponse(),1));
			return false;
		}
	}

	/**
	 * Upload images to miniShop2 product
	 *
	 * @param $productId
	 * @param $productName
	 * @param $images
	 */
	private function uploadImagesMsProduct($productId,$productName,$images){
		foreach($images as $image){
			$this->modx->error->message = null;
			$this->modx->error->errors = array();

			$image = basename($image);
			if (file_exists($this->config['temp_dir'].$image)) {
				$file = array('id'=>$productId,'name'=>$image, 'file'=>$this->config['temp_dir'].$image);

				$response = $this->modx->runProcessor('mgr/gallery/upload', $file, array('processors_path' => MODX_CORE_PATH.'components/minishop2/processors/'));
				if ($response->isError()) {

				}
			}
			else $this->modx->log(modX::LOG_LEVEL_ERROR, '[mSklad] Ошибка загрузки изображения товара ('.$productName.' '.$productId.'), файл ('.$this->config['temp_dir'].$image.') не найден'."\r\n");
			// Reset processor errors
			$this->modx->error->reset();
		}
	}

	/**
	 * Add aditional properties to miniShop2 product
	 *
	 * @param $productId
	 * @param array $tvsArray
	 * @return bool
	 */
	private function setProductTvs($productId,$tvsArray=array()){
		if(empty($tvsArray)) return false;

		if($product=$this->modx->getObject( 'msProduct', array('class_key' => 'msProduct','id' =>$productId) ) ){
			foreach($tvsArray as $k=>$v){
				$product->setTVValue($k, $v);
			}
		}
		return true;
	}

	/**
	 * Return msVendor id
	 *
	 * @param string $vendorName
	 * @return int
	 */
	private function updateMsProductVendor($vendorName=''){
		$vendorId=0;
		if(!$vendorName = trim($vendorName)) return $vendorId;

		if($vendor = $this->modx->getObject( 'msVendor', array('name' => $vendorName) ) ){
			$vendorId = $vendor->get('id');
		}
		else{
			$vendor = $this->modx->newObject('msVendor');
			$vendor->fromArray(array(
				'name' => $vendorName
			), '', true);
			$vendor->save();
			$vendorId = $vendor->get('id');
		}

		return $vendorId;
	}

	/**
	 * fix param to array
	 *
	 * @param $param
	 * @return array|string
	 */
	private function propertyToArray($param){
		if(!trim($param)) return '';
		$paramArray=array_map('trim', explode(',', $param));
		return $paramArray;
	}


	private function loadStock($xml){
		$uuid_1c = (array) explode('#',(string)$xml->Ид); //$uuid_1c = substr((string)$xml->Ид,0,74);

		$pricePropertyType = false; $pricePropertyTarget=false;
		if(isset($this->properties['Цена'])){
			$pricePropertyType = $this->properties['Цена']['type'];
			$pricePropertyTarget = $this->properties['Цена']['target'];
		}

		$prodData=$this->modx->getObject( 'mSkladProductData', array('uuid_1c' => $uuid_1c[0]) );
		if($prodData){
			$product_id = $prodData->get('product_id');
			if($product=$this->modx->getObject( 'msProduct', array('class_key' => 'msProduct','id' =>$product_id) ) ){
				$productFeatureExist=true;
				if(!in_array($product_id, $_SESSION['feature_mapping'])){
					$productFeatureExist=false;
					array_push($_SESSION['feature_mapping'], $product_id);
				}

				//update quantity
				if(isset($this->properties['Количество'])){
					$quantity = intval($xml->Количество);

					$feature=false;
					if(isset($xml->ХарактеристикиТовара->ХарактеристикаТовара->Значение)) $feature = (string) $xml->ХарактеристикиТовара->ХарактеристикаТовара->Значение;
					if(isset($xml->Характеристика)) $feature = (string) $xml->Характеристика;
					if($feature){
						if($productFeatureExist){
							if($this->properties['Количество']['type']==1){
								$oldQuantity = $product->get($this->properties['Количество']['target']);
								$oldQuantity = (array) explode('||',$oldQuantity);

								$processorProps = array(
									'id'=>$product_id
									,'class_key' => 'msProduct'
									,'context_key' => $this->config['catalog_context']
								);
								$processorProps[$this->properties['Количество']['target']] = implode('||',array_merge(array($feature.'=='.$quantity),$oldQuantity));
								$response = $this->modx->runProcessor('mgr/extend/updatemsproduct', $processorProps, array('processors_path'=>$this->config['processorsPath']));
							}
							elseif($this->properties['Количество']['type']==2){
								$oldQuantity = $product->getTVValue($this->properties['Количество']['target']);
								$oldQuantity = (array) explode('||',$oldQuantity);

								$product->setTVValue($this->properties['Количество']['target'], implode('||',array_merge(array($feature.'=='.$quantity),$oldQuantity)) );
							}
						}
						else{
							if($this->properties['Количество']['type']==1){
								$processorProps = array(
									'id'=>$product_id
									,'class_key' => 'msProduct'
									,'context_key' => $this->config['catalog_context']
								);
								$processorProps[$this->properties['Количество']['target']] = $feature.'=='.$quantity;
								$response = $this->modx->runProcessor('mgr/extend/updatemsproduct', $processorProps, array('processors_path'=>$this->config['processorsPath']));
							}
							elseif($this->properties['Количество']['type']==2){
								$product->setTVValue($this->properties['Количество']['target'], $feature.'=='.$quantity);
							}
						}
					}
					else{
						if($this->properties['Количество']['type']==1){
							$processorProps = array(
								'id'=>$product_id
								,'class_key' => 'msProduct'
								,'context_key' => $this->config['catalog_context']
							);
							$processorProps[$this->properties['Количество']['target']] = $quantity;

							//publish by quantity
							if($this->config['publish_by_quantity']){
								if($quantity)
									$processorProps['published']=true;
								else
									$processorProps['published']=false;
							}


							$response = $this->modx->runProcessor('mgr/extend/updatemsproduct', $processorProps, array('processors_path'=>$this->config['processorsPath']));
						}
						elseif($this->properties['Количество']['type']==2){
							$product->setTVValue($this->properties['Количество']['target'], $quantity);
						}
					}



				}

				//update price
				$selectedPrice=0;
				if($this->config['import_all_prices']){
					//Импортируем цены согласно связям
					$c=0;
					foreach($xml->Цены->Цена as $price){
						$priceTypeId = addslashes((string) $price->ИдТипаЦены);
						$priceTypeName='';
						if(isset($_SESSION['price_mapping'][$priceTypeId])) $priceTypeName = $_SESSION['price_mapping'][$priceTypeId];
						if(!empty($priceTypeName)){
							if(!isset($this->properties[$priceTypeName])) continue;
							$priceSum = addslashes((string) $price->ЦенаЗаЕдиницу);
							if($c==0) $selectedPrice=$priceSum;

							if($this->properties[$priceTypeName]['type']==1){
								$processorProps = array(
									'id'=>$product_id
									,'class_key' => 'msProduct'
									,'context_key' => $this->config['catalog_context']
								);
								$processorProps[$this->properties[$priceTypeName]['target']] = $priceSum;
								$response = $this->modx->runProcessor('mgr/extend/updatemsproduct', $processorProps, array('processors_path'=>$this->config['processorsPath']));
							}
							elseif($this->properties[$priceTypeName]['type']==2){
								$product->setTVValue($this->properties[$priceTypeName]['target'], $priceSum);
							}
						}
						++$c;
					}
				}
				else{
					//импортируем только первую цену
					$price = (string) $xml->Цены->Цена->ЦенаЗаЕдиницу;
					if($price  && $pricePropertyType){
						$selectedPrice=$price;
						if($pricePropertyType==1 && !$productFeatureExist){
							$processorProps = array(
								'id'=>$product_id
								,'class_key' => 'msProduct'
								,'context_key' => $this->config['catalog_context']
							);
							$processorProps[$pricePropertyTarget] = $price;
							$response = $this->modx->runProcessor('mgr/extend/updatemsproduct', $processorProps, array('processors_path'=>$this->config['processorsPath']));
						}
						elseif($pricePropertyType==2){
							$product->setTVValue($pricePropertyTarget, $price);
						}


					}
				}


				//импортирем цену в соответствии с размером
				$feature=false;
				if(isset($xml->ХарактеристикиТовара->ХарактеристикаТовара->Значение)) $feature = (string) $xml->ХарактеристикиТовара->ХарактеристикаТовара->Значение;
				if(isset($xml->Характеристика)) $feature = (string) $xml->Характеристика;
				if($feature && !empty($this->config['price_by_feature_tv']) ){
					if($productFeatureExist){
						$oldFeaturePrice = $product->getTVValue($this->config['price_by_feature_tv']);
						$oldFeaturePrice = (array) explode('||',$oldFeaturePrice);

						$product->setTVValue($this->config['price_by_feature_tv'], implode('||',array_merge(array($feature.'=='.$selectedPrice),$oldFeaturePrice)));
					}
					else{
						$product->setTVValue($this->config['price_by_feature_tv'], $feature.'=='.$selectedPrice);
					}
				}

				//импрорт цены в msOptionsPrice
				if( $feature && $this->msOptionsPriceTarget && $this->msOptionsPriceSource){

					if(isset($this->properties[$this->msOptionsPriceSource])) {
						//add property to product
						if($this->properties[$this->msOptionsPriceSource]['type']==1){
							$processorProps = array(
								'id'=>$product_id
								,'class_key' => 'msProduct'
								,'context_key' => $this->config['catalog_context']
							);

							// fix size
							if($this->msOptionsPriceTarget=='size'){
								if($productFeatureExist) $newSize = array_unique( array_merge($product->get('size'),$this->propertyToArray($feature)) );
								else $newSize = $this->propertyToArray($feature);
								$processorProps[$this->properties[$this->msOptionsPriceSource]['target']] = $newSize;
							}
							else $processorProps[$this->properties[$this->msOptionsPriceSource]['target']] = $feature;
							$response = $this->modx->runProcessor('mgr/extend/updatemsproduct', $processorProps, array('processors_path'=>$this->config['processorsPath']));
						}

						//add price to product $selectedPrice
						$product->setProperty($feature,$selectedPrice,'msoptionsprice');
						$product->save();
					}
				}


				$this->modx->invokeEvent('mskladOnProductOffers',array(
					'mode' 			=> 'update',
					'resource'		=> &$product
				));
			}
		}
	}

	private function checkCatalogRoot() {
		$catalog_root_id = $this->config['catalog_root_id'];
		if(!$catalog_root_id) {
			$this->modx->log(modX::LOG_LEVEL_ERROR, '[mSklad] Ошибка импорта каталога, не настроен параметр "Id категории каталога" (msklad_catalog_root_id)');
			return false;
		}
		if(!$this->modx->getObject('modResource', array('class_key' => 'msCategory','id' => $catalog_root_id))) {
			$this->modx->log(modX::LOG_LEVEL_ERROR, '[mSklad] Ошибка импорта каталога, категория каталога предназначенная для импорта не является "категорией с товарами" (miniShop2)');
			return false;
		}
		return true;
	}

	public function clearCache() {
		$this->modx->cacheManager->refresh();
		return true;
	}

}