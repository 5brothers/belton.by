<?php

require_once MODX_CORE_PATH.'components/msklad/model/rest/RestRequest.inc.php';

class mSkladCategoryUpdateSkladProcessor extends modObjectProcessor {
    private $config;
    private $start, $total, $level;
    public $languageTopics = array('msklad:category');

    public function initialize() {
        $this->config = $this->modx->msklad->config;
        $this->start = intval($this->getProperty('start'));
        $this->total = intval($this->getProperty('total'));
        $this->level = intval($this->getProperty('level'));

        return true;
    }

    public function process() {
        $stop=0;

        $c = $this->modx->newQuery('mSkladCategoryData');
        $c->select('category_id,uuid,level,active');
        $c->where(array(
            'active:=' => '1',
            'level:=' => $this->level,
        ));

        $this->total = $this->modx->getCount('mSkladCategoryData', $c);
        $c->limit(100,$this->start);

        if ($c->prepare() && $c->stmt->execute()){
            $categoriesData = $c->stmt->fetchAll(PDO::FETCH_ASSOC);
            $collection=array();

            if(is_array($categoriesData) && count($categoriesData)>0){
                foreach($categoriesData as $categoryData){

                    if($category=$this->modx->getObject( 'msCategory', array('id' => $categoryData['category_id']) ) ){
                        $name = trim(htmlspecialchars( html_entity_decode( $category->get('pagetitle'), ENT_COMPAT, 'UTF-8' ), ENT_QUOTES ));
                        $description = trim(htmlspecialchars( html_entity_decode( $category->get('description'), ENT_COMPAT, 'UTF-8' ), ENT_QUOTES ));

                        $parentUuid='';
                        if($categoryData['level']>1){
                            $parent_q= $this->modx->newQuery('msCategory', array('id'=>$category->get('parent')));
                            $parent_q->leftJoin('mSkladCategoryData', 'Data', 'Data.category_id = msCategory.id');
                            $parent_q->select('msCategory.id, Data.uuid, Data.uuid_1c');
                            $parent_q->limit(1);

                            //                        $parent_q->prepare();
                            //                        $this->modx->msklad->restLog('toSQL',print_r($parent_q->toSQL(),true));

                            if($parent_q->prepare() && $parent_q->stmt->execute()){
                                $parentRes = $parent_q->stmt->fetch(PDO::FETCH_ASSOC);
                                $parentUuid=!empty($parentRes['uuid'])? 'parentUuid="'.$parentRes['uuid'].'"' : '';
                            }
                        }


                        $collection[] = '
                            <goodFolder '.$parentUuid.' productCode="" name="'.$name.'">
                                <uuid>'.$categoryData['uuid'].'</uuid>
                                <description>'.$description.'</description>
                                <code>'.$categoryData['category_id'].'</code>
                                <externalcode>'.$categoryData['uuid_1c'].'</externalcode>
                            </goodFolder>
                        ';
                    }
                }

                $xml='<?xml version="1.0" encoding="UTF-8"?>
                        <collection>
                        '.implode('',$collection).'
                        </collection>';

                $request = new RestRequest($this->config['restUrl'].'GoodFolder/list/update', 'PUT',$xml);
                $request->setUsername($this->config['Username']);
                $request->setPassword($this->config['Password']);
                $request->execute();

                $responseInfo = $request->getResponseInfo();
                $http_code = $responseInfo['http_code'];


                if($this->config['debug']){
                    $this->modx->msklad->restLog('updateCategorySklad_'.$this->start.'_'.$this->level,$request);
                }

                if($http_code=='200'){
                    $xml = simplexml_load_string($request->getResponseBody());

                    $cc=0;
                    foreach($xml->id as $val){
                        if($categoryData=$this->modx->getObject( 'mSkladCategoryData', array('category_id' => $categoriesData[$cc]['category_id']) ) ){
                            $categoryData->set('uuid',$val);
                            $categoryData->save();
                        }
                        ++$cc;
                    }
                    unset($xml);
                }
                unset($categoriesData);
            }
            else{
                $this->level +=1;
            }
        }


        if($this->start==0 && !$this->total) $stop=1;

        return $this->success(array('total'=> $this->total,'level'=>$this->level,'stop'=>$stop));
    }

}

return 'mSkladCategoryUpdateSkladProcessor';