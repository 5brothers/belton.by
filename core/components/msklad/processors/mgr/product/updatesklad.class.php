<?php

require_once MODX_CORE_PATH.'components/msklad/model/rest/RestRequest.inc.php';

class mSkladProductUpdateSkladProcessor extends modObjectProcessor {
    private $config;
    private $start, $total;
    public $languageTopics = array('msklad:product');

    public function initialize() {
        $this->config = $this->modx->msklad->config;
        $this->start = intval($this->getProperty('start'));
        $this->total = intval($this->getProperty('total'));

        return true;
    }

    public function process() {
        $stop=0;

        $c = $this->modx->newQuery('mSkladProductData');
        $c->innerJoin('msProduct', 'msProduct', 'msProduct.id=mSkladProductData.product_id');
        $c->innerJoin('msProductData', 'msProductData', 'msProductData.id=mSkladProductData.product_id');
        $c->sortby('mSkladProductData.product_id','ASC');
        $c->select('mSkladProductData.product_id,mSkladProductData.uuid,mSkladProductData.uuid_1c,mSkladProductData.price_uuid,mSkladProductData.active,msProduct.parent,msProduct.pagetitle,msProduct.longtitle,msProduct.description,msProductData.*');
        $c->where(array(
            'active:=' => '1',
        ));

        $this->total = $this->modx->getCount('mSkladProductData', $c);

        $c->limit(100,$this->start);

        $c->prepare();

        if ($c->stmt->execute()){ //$c->prepare() &&
            $productsData = $c->stmt->fetchAll(PDO::FETCH_ASSOC);
            $collection=array();

            if(is_array($productsData) && count($productsData)>0){
                foreach($productsData as $productData){

                        $name = trim(htmlspecialchars( html_entity_decode( $productData['pagetitle'], ENT_COMPAT, 'UTF-8' ), ENT_QUOTES ));
                        $description = trim(htmlspecialchars( html_entity_decode( $productData['description'], ENT_COMPAT, 'UTF-8' ), ENT_QUOTES ));
                        $price = str_replace(".","",$productData['price']).'.0';
                        $weight= $productData['weight'];

                        $code = $productData['product_id'];
                        $productCode = trim(htmlspecialchars( html_entity_decode( $productData['article'], ENT_COMPAT, 'UTF-8' ), ENT_QUOTES ));
                        $uuid =$productData['uuid'];
                        $priceUuid =$productData['price_uuid'];
                        $priceTypeUuid = $this->config['SalePriceType'];
                        $uomUuid=$this->config['Uom'];

                        $externalCode = $uuid_1c = $productData['uuid_1c'];

                        $parentUuid='';
                        if($productData['parent']){
                            $parent_q= $this->modx->newQuery('msCategory', array('id'=>$productData['parent']));
                            $parent_q->leftJoin('mSkladCategoryData', 'Data', 'Data.category_id = msCategory.id');
                            $parent_q->select('msCategory.id, Data.uuid');
                            $parent_q->limit(1);

                            if($parent_q->prepare() && $parent_q->stmt->execute()){
                                $parentRes = $parent_q->stmt->fetch(PDO::FETCH_ASSOC);
                                $parentUuid=!empty($parentRes['uuid'])? 'parentUuid="'.$parentRes['uuid'].'"' : '';
                            }
                        }

                        $collection[] = '
                            <good isSerialTrackable="false" uomUuid="'.$uomUuid.'" productCode="'.$productCode.'" name="'.$name.'" weight="'.$weight.'" '.$parentUuid.'>
                                <uuid>'.$uuid.'</uuid>
                                <code>'.$code.'</code>
                                <externalcode>'.$externalCode.'</externalcode>
                                <description>'.$description.'</description>
                                <salePrices>
                                    <price value="'.$price.'" priceTypeUuid="'.$priceTypeUuid.'">
                                        <uuid>'.$priceUuid.'</uuid>
                                    </price>
                                </salePrices>
                            </good>
                        ';
                }

                $xml='<?xml version="1.0" encoding="UTF-8"?>
                        <collection>
                        '.implode('',$collection).'
                        </collection>';

                $request = new RestRequest($this->config['restUrl'].'Good/list/update', 'PUT',$xml);
                $request->setUsername($this->config['Username']);
                $request->setPassword($this->config['Password']);
                $request->execute();

                $responseInfo = $request->getResponseInfo();
                $http_code = $responseInfo['http_code'];


                if($this->config['debug']){
                    $this->modx->msklad->restLog('updateProductSklad_'.$this->start,$request);
                }

                if($http_code=='200'){
                    $xml = simplexml_load_string($request->getResponseBody());

                    $cc=0;
                    foreach($xml->id as $val){
                        if($productData=$this->modx->getObject( 'mSkladProductData', array('product_id' => $productsData[$cc]['product_id']) ) ){
                            $productData->set('uuid',$val);
                            $productData->save();
                        }
                        ++$cc;
                    }
                    unset($xml);
                }

                unset($productsData);
            }

        }


        if($this->start+100 > $this->total) $stop=1;

        return $this->success(array('total'=> $this->total,'stop'=>$stop));
    }

}

return 'mSkladProductUpdateSkladProcessor';