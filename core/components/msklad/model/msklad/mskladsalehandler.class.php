<?php

interface mskladSaleInterface {

    /* Initializes order to context
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

    /* query the catalog
     *
     * @return array|string $response
     * */
    public function query();

    /* success the catalog
     *
     * @return array|string $response
     * */
    public function success();

    /* import catalog
     *
     * @param string $filename The filename of catalog
     *
     * @param string $file The file of catalog
     *
     * @return array|string $response
     * */
    public function file($filename, $file);
}


class mskladSaleHandler implements mskladSaleInterface {
    /* @var modX $modx */
    public $modx;
    protected $config = array(
        'json_response' => false
    );
    protected $sale,$orders;

    function __construct(mSklad & $msklad, array $config = array()) {
        $this->msklad = & $msklad;
        $this->modx = & $msklad->modx;

        $this->config = array_merge(array(
            'json_response' => false
            ,'temp_dir' => $this->modx->getOption('msklad_assets_path', $config, $this->modx->getOption('assets_path').'components/msklad/1c_temp/')
            ,'accept_status_id' => $this->modx->getOption('msklad_order_accept_status_id')
			,'catalog_currency' => $this->modx->getOption('msklad_catalog_currency')
        ),$config);

        $this->sale = & $this->config['sale'];
        $this->modx->lexicon->load('msklad:sale');

        if (empty($this->sale) || !is_array($this->sale)) {
            $this->sale = array();
        }
    }



    /* @inheritdoc} */
    public function initialize($ctx = 'web') {
        return true;
    }


    /* @inheritdoc} */
    public function checkauth() {
        return 'success'.PHP_EOL.session_name().PHP_EOL.session_id();
    }

    /* @inheritdoc} */
    public function init() {
        $tmp_files = glob($this->config['temp_dir'].'*.*');
        if(is_array($tmp_files))
            foreach($tmp_files as $v)
            {
                //unlink($v);
            }
		unset($_SESSION['sale_order_ids']);
		$_SESSION['sale_order_ids']=array();
        return 'zip=no'.PHP_EOL.'file_limit=1000000'.PHP_EOL;
    }

    /* @inheritdoc} */
    public function query() {
		$no_spaces = '<?xml version="1.0" standalone="yes"?>
        <КоммерческаяИнформация ВерсияСхемы="2.04" ДатаФормирования="' . date('Y-m-d'). '"></КоммерческаяИнформация>';

		$xml = new SimpleXMLElement ( $no_spaces );

		$lastSync = $this->modx->getObject('modSystemSetting', 'msklad_last_orders_sync')->get('value');
        $this->orders =  $this->modx->getCollection('msOrder', array("`createdon` >= '{$lastSync}' OR `updatedon` >= '{$lastSync}'")); //,array('status'=>1)
        foreach($this->orders as $order){
			$pls_order = $order->toArray();

			if($pls_profile = $order->getOne('UserProfile')){
				$pls_profile = $pls_profile->toArray('user.');
			}
			else $pls_profile = array();

			if($pls_address = $order->getOne('Address')){
				$pls_address = $pls_address->toArray('address.');
			}
			else $pls_address = array();

			if($pls_delivery = $order->getOne('Delivery')){
				$pls_delivery = $pls_delivery->toArray('delivery.');
			}
			else $pls_delivery = array();

			if($pls_payment = $order->getOne('Payment')){
				$pls_payment = $pls_payment->toArray('payment.');
			}
			else $pls_payment = array();

			$order_ext = array_merge($pls_order, $pls_profile, $pls_address, $pls_delivery, $pls_payment);
			if($pls_status = $order->getOne('Status')){
				$order_ext['statusName'] = $pls_status->get('name');
			}

            $prods = $order->getMany('Products');
            $c=0;
            foreach($prods as $prod){
                $prod_ext = $prod->getOne('Product');
				if(!$prod_ext) continue;
				$prodData=$this->modx->getObject( 'mSkladProductData', array('product_id' => $prod_ext->get('id')) );
				$parentData=$this->modx->getObject( 'mSkladCategoryData', array('category_id' => $prod_ext->get('parent')) );

                $order_ext['goods'][$c]=$prod->toArray();
                $order_ext['goods'][$c]['name']=$prod_ext->get('pagetitle');
                $order_ext['goods'][$c]['article']=$prod_ext->get('article');
				$order_ext['goods'][$c]['uuid_1c']= $prodData ? $prodData->get('uuid_1c') : '';
				$order_ext['goods'][$c]['parent_uuid_1c']= $parentData ? $parentData->get('uuid_1c') : '';
                ++$c;
            }

			$order_ext['address.full']='';
			if(!empty($order_ext['address.index'])) $order_ext['address.full'] .= 'Индекс '.htmlspecialchars($order_ext['address.index']);
			if(!empty($order_ext['address.region'])) $order_ext['address.full'] .= ', регион '.htmlspecialchars($order_ext['address.region']);
			if(!empty($order_ext['address.city'])) $order_ext['address.full'] .= ', город '.htmlspecialchars($order_ext['address.city']);
			if(!empty($order_ext['address.metro'])) $order_ext['address.full'] .= ', метро '.htmlspecialchars($order_ext['address.metro']);
			if(!empty($order_ext['address.street'])) $order_ext['address.full'] .= ', улица '.htmlspecialchars($order_ext['address.street']);
			if(!empty($order_ext['address.building'])) $order_ext['address.full'] .= ', дом '.htmlspecialchars($order_ext['address.building']);
			if(!empty($order_ext['address.room'])) $order_ext['address.full'] .= ', кв '.htmlspecialchars($order_ext['address.room']);


            $order_date = explode(' ',$order_ext['createdon']);

            $doc = $xml->addChild ("Документ");
            $doc->addChild ( "Ид", $order_ext['id']);
            $doc->addChild ( "Номер", $order_ext['num']);
            $doc->addChild ( "Дата", $order_date[0]);
            $doc->addChild ( "ХозОперация", "Заказ товара" );
            $doc->addChild ( "Роль", "Продавец" );
            $doc->addChild ( "Курс", "1" );
			$doc->addChild ( "Валюта", $this->config['catalog_currency'] );
            $doc->addChild ( "Сумма", $order_ext['cost']);
            $doc->addChild ( "Время",  $order_date[1]);
            $doc->addChild ( "Комментарий", htmlspecialchars($order_ext['address.comment']));
			if(!empty($order_ext['address.full'])) $doc->addChild ( "Комментарий", "Адрес доставки: ".$order_ext['address.full']);

            // Контрагенты
            $k1 = $doc->addChild ( 'Контрагенты' );
            $k1_1 = $k1->addChild ( 'Контрагент' );

			$userId = !empty($order_ext['user.internalKey'])? $order_ext['user.internalKey'] : '0#'.$order_ext['user.email'];
			$k1_2 = $k1_1->addChild ( "Ид", $userId);
			$k1_2 = $k1_1->addChild ( "Наименование", htmlspecialchars($order_ext['user.fullname']));
			$k1_2 = $k1_1->addChild ( "Роль", "Покупатель" );
            $k1_2 = $k1_1->addChild ( "ПолноеНаименование", htmlspecialchars($order_ext['user.fullname']) );

            // Доп параметры
            $addr = $k1_1->addChild ('АдресРегистрации');
            $addr->addChild ( 'Вид', 'Адрес доставки' );
            $addr->addChild ( 'Представление', $order_ext['address.full'] );

			if(!empty($order_ext['address.country'])){
				$addrField = $addr->addChild ( 'АдресноеПоле' );
				$addrField->addChild ( 'Тип', 'Страна' );
				$addrField->addChild ( 'Значение', $order_ext['address.country'] );
			}
			else{
				$addrField = $addr->addChild ( 'АдресноеПоле' );
				$addrField->addChild ( 'Тип', 'Страна' );
				$addrField->addChild ( 'Значение', 'RU' );
			}
			if(!empty($order_ext['address.index'])){
				$addrField = $addr->addChild ( 'АдресноеПоле' );
				$addrField->addChild ( 'Тип', 'Почтовый индекс' );
				$addrField->addChild ( 'Значение', $order_ext['address.index'] );
			}
			if(!empty($order_ext['address.region'])){
				$addrField = $addr->addChild ( 'АдресноеПоле' );
				$addrField->addChild ( 'Тип', 'Регион' );
				$addrField->addChild ( 'Значение', $order_ext['address.region'] );
			}
			if(!empty($order_ext['address.city'])){
				$addrField = $addr->addChild ( 'АдресноеПоле' );
				$addrField->addChild ( 'Тип', 'Город' );
				$addrField->addChild ( 'Значение', $order_ext['address.city'] );
			}
			if(!empty($order_ext['address.street'])){
				$addrField = $addr->addChild ( 'АдресноеПоле' );
				$addrField->addChild ( 'Тип', 'Улица' );
				$addrField->addChild ( 'Значение', htmlspecialchars($order_ext['address.street']) );
			}
			if(!empty($order_ext['address.building'])){
				$addrField = $addr->addChild ( 'АдресноеПоле' );
				$addrField->addChild ( 'Тип', 'Дом' );
				$addrField->addChild ( 'Значение', $order_ext['address.building'] );
			}
			if(!empty($order_ext['address.room'])){
				$addrField = $addr->addChild ( 'АдресноеПоле' );
				$addrField->addChild ( 'Тип', 'Квартира' );
				$addrField->addChild ( 'Значение', $order_ext['address.room'] );
			}

            $contacts = $k1_1->addChild ( 'Контакты' );
            $cont = $contacts->addChild ( 'Контакт' );
            $cont->addChild ( 'Тип', 'Телефон' );
            $cont->addChild ( 'Значение', $order_ext['address.phone'] );
            $cont = $contacts->addChild ( 'Контакт' );
            $cont->addChild ( 'Тип', 'Почта' );
            $cont->addChild ( 'Значение', $order_ext['user.email'] );


            //products
            $t1 = $doc->addChild ( 'Товары' );
            foreach($order_ext['goods'] as $purchase){
                $t1_1 = $t1->addChild ( 'Товар' );
                $t1_2 = $t1_1->addChild ( "Ид", $purchase['uuid_1c']); //$purchase['product_id']);
				if(!empty($purchase['uuid_1c'])) $t1_2 = $t1_1->addChild ( "ИдКаталога", $purchase['parent_uuid_1c']); //$purchase['product_id']);
                $t1_2 = $t1_1->addChild ( "Наименование", htmlspecialchars($purchase['name']));
                $t1_2 = $t1_1->addChild ( "Артикул", $purchase['article']);


                if(!isset($purchase['options']['color'])) $purchase['options']['color']='';
                if(!isset($purchase['options']['size'])) $purchase['options']['size']='';

                $t1_2 = $t1_1->addChild ( "ХарактеристикиТовара", 'color:'.$purchase['options']['color'].', size:'.$purchase['options']['size']);

                $t1_2 = $t1_1->addChild ( "ЦенаЗаЕдиницу", $purchase['price']);
                $t1_2 = $t1_1->addChild ( "Количество", $purchase['count'] );
                $t1_2 = $t1_1->addChild ( "Сумма", $purchase['cost']);

                $t1_2 = $t1_1->addChild ( "ЗначенияРеквизитов" );
                $t1_3 = $t1_2->addChild ( "ЗначениеРеквизита" );
                $t1_4 = $t1_3->addChild ( "Наименование", "ВидНоменклатуры" );
                $t1_4 = $t1_3->addChild ( "Значение", "Товар" );

                $t1_2 = $t1_1->addChild ( "ЗначенияРеквизитов" );
                $t1_3 = $t1_2->addChild ( "ЗначениеРеквизита" );
                $t1_4 = $t1_3->addChild ( "Наименование", "ТипНоменклатуры" );
                $t1_4 = $t1_3->addChild ( "Значение", "Товар" );


            }

            // Доставка
//            if($order->delivery_price>0 && !$order->separate_delivery){
			if(!$order->separate_delivery){
                $t1 = $t1->addChild ( 'Товар' );
                $t1->addChild ( "Ид", 'ORDER_DELIVERY');
                $t1->addChild ( "Наименование", 'Доставка');
                $t1->addChild ( "ЦенаЗаЕдиницу", $order_ext['delivery_cost']);
                $t1->addChild ( "Количество", 1 );
                $t1->addChild ( "Сумма", $order_ext['delivery_cost']);
                $t1_2 = $t1->addChild ( "ЗначенияРеквизитов" );
                $t1_3 = $t1_2->addChild ( "ЗначениеРеквизита" );
                $t1_4 = $t1_3->addChild ( "Наименование", "ВидНоменклатуры" );
                $t1_4 = $t1_3->addChild ( "Значение", "Услуга" );

                $t1_2 = $t1->addChild ( "ЗначенияРеквизитов" );
                $t1_3 = $t1_2->addChild ( "ЗначениеРеквизита" );
                $t1_4 = $t1_3->addChild ( "Наименование", "ТипНоменклатуры" );
                $t1_4 = $t1_3->addChild ( "Значение", "Услуга" );

            }


			$r1_1 = $doc->addChild ( "ЗначенияРеквизитов");

            // Статус
            $s1_3 = $r1_1->addChild ( "ЗначениеРеквизита" );
            $s1_3->addChild ( "Наименование", "Статус заказа" );
//            $s1_3->addChild ( "Значение", "[N] Принят" );
			$s1_3->addChild ( "Значение", $order_ext['statusName'] );

            $r1_2 = $r1_1->addChild ( "ЗначениеРеквизита" );
            $r1_2->addChild ( "Наименование", "Способ оплаты" );
            $r1_2->addChild ( "Значение", $order_ext['payment.name'] );

            $r1_2 = $r1_1->addChild ( "ЗначениеРеквизита" );
            $r1_2->addChild ( "Наименование", "Способ доставки" );
            $r1_2->addChild ( "Значение", $order_ext['delivery.name'] );

            $r1_2 = $r1_1->addChild ( "ЗначениеРеквизита" );
            $r1_2->addChild ( "Наименование", "Адрес доставки" );
            $r1_2->addChild ( "Значение", $order_ext['address.full'] );

			if($order_ext['status']==1) $_SESSION['sale_order_ids'][ $order_ext['id']] = $order_ext['id'];
        }

        $out =  $xml->asXML ();
		$out = iconv("UTF-8", "cp1251", $out);
		$out = str_replace('<?xml version="1.0" standalone="yes"?>','<?xml version="1.0" encoding="windows-1251" standalone="yes"?>',$out);
        return $out;
    }

    /* @inheritdoc} */
    public function success() {
		$this->orders =  $this->modx->getCollection('msOrder',array('status'=>1));

		foreach($this->orders as $order){
			if($this->config['accept_status_id']!='' && isset($_SESSION['sale_order_ids'][$order->get('id')])){
				$order->set('status',$this->config['accept_status_id']);
				$order->save();
			}
		}
		$lastSync = $this->modx->getObject('modSystemSetting', 'msklad_last_orders_sync');
		$lastSync->set('value', date("Y-m-d H:i:s"));
		$lastSync->save();

        return 'success'.PHP_EOL.session_name().PHP_EOL.session_id().PHP_EOL.date("Y-m-d H:i:s");
    }

    /* @inheritdoc} */
    public function file($filename='',$file) {
        if($filename) {
            $filename = basename($filename);

            $f = fopen($this->config['temp_dir'].$filename, 'ab');
            fwrite($f, $file);
            fclose($f);
            return 'success'.PHP_EOL;
        }
        return 'failure'.PHP_EOL;
    }


}