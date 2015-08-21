<?php
require_once MODX_CORE_PATH.'components/msklad/model/msklad/uuid.class.php';

class mSkladProductPrepareProcessor extends modObjectProcessor {

    /* @var msklad $product */
    private $products=array();
    private $start, $total;
    public $languageTopics = array('msklad:api','msklad:product');


    public function initialize() {
        $this->config = $this->modx->msklad->config;
        $this->start = intval($this->getProperty('start'));
        $this->total = intval($this->getProperty('total'));

        $q = $this->modx->newQuery('msProduct', array('class_key' => 'msProduct','deleted'=>0));
        $q->select('id,parent');

        $this->total = $this->modx->getCount('msProduct', $q);

        $q->limit(500,$this->start);

        if ($q->prepare() && $q->stmt->execute()){ //
            $this->products = $q->stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        return true;
    }

    public function process() {
        if (count($this->products)==0) {
            return $this->failure($this->modx->lexicon('msklad_product_err_no_product'));
        }

        $stop=0;

        if($this->start==0) $this->modx->exec("UPDATE {$this->modx->getTableName('mSkladProductData')} SET active = 0");

        foreach($this->products as $product){
            if(! $data=$this->modx->getObject( 'mSkladProductData', array('product_id' => $product['id']) ) ){
                $data = $this->modx->newObject( 'mSkladProductData', array('product_id' => $product['id']) );
                $data->set( 'product_id',$product['id']);
                $data->save();
            }
            if(!$data->get('uuid_1c')){
                $uuid1c='';
                if($exchange=$this->modx->getObject( 'mSkladProductExchange', array('product_id' => $product['id']) ) ){
                    $uuid1c = $exchange->get('uuid_1c');
                }
                if(!$uuid1c){
                    $uuid = new uuid();
                    $uuid1c = $uuid->get();
                }
                $data->set('uuid_1c', $uuid1c);
                $data->save();
            }
            if(!$data->get('uuid')){
                if($exchange=$this->modx->getObject( 'mSkladProductExchange', array('product_id' => $product['id']) ) ){
                    $data->set('uuid',  $exchange->get('uuid'));
                    $data->save();
                }
            }
            if(!$data->get('price_uuid')){
                if($exchange=$this->modx->getObject( 'mSkladProductExchange', array('product_id' => $product['id']) ) ){
                    $data->set('price_uuid',  $exchange->get('price_uuid'));
                    $data->save();
                }
            }

            $data->set('active',  1);
            $data->save();
            unset($data);
        }

        if($this->start+500 > $this->total) $stop=1;
        return $this->success(array('total'=> $this->total,'stop'=>$stop));
    }

}

return 'mSkladProductPrepareProcessor';