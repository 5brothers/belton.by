<?php
require_once MODX_CORE_PATH.'components/msklad/model/msklad/uuid.class.php';

class mSkladCategoryPrepareProcessor extends modObjectProcessor {

    /* @var msklad $category */
    private $categories=array();
    public $languageTopics = array('msklad:api','msklad:category');


    public function initialize() {
        $q = $this->modx->newQuery('msCategory', array('class_key' => 'msCategory','deleted'=>0));
        $q->select('id,parent');
        if ($q->prepare() && $q->stmt->execute()){
            $this->categories = $q->stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        return true;
    }

    public function process() {
        if (count($this->categories)==0) {
            return $this->failure($this->modx->lexicon('msklad_category_err_no_category'));
        }

        $this->modx->exec("UPDATE {$this->modx->getTableName('mSkladCategoryData')} SET active = 0");

        $this->fillCategoryData();
        $this->setCategoryLevel();

        return $this->success();
    }

    public function fillCategoryData(){
        foreach($this->categories as $category){
            if(! $data=$this->modx->getObject( 'mSkladCategoryData', array('category_id' => $category['id']) ) ){
                $data = $this->modx->newObject( 'mSkladCategoryData', array('category_id' => $category['id']) );
                $data->set( 'category_id',$category['id']);
                $data->save();
            }
            if(!$data->get('uuid_1c')){
                $uuid1c='';
                if($exchange=$this->modx->getObject( 'mSkladCategoryExchange', array('category_id' => $category['id']) ) ){
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
                if($exchange=$this->modx->getObject( 'mSkladCategoryExchange', array('category_id' => $category['id']) ) ){
                    $data->set('uuid',  $exchange->get('uuid'));
                    $data->save();
                }
            }

            $data->set('active',  1);
            $data->save();
            unset($data);
        }
        return true;
    }

    public function setCategoryLevel($startLevel=0){
        $startLevel = intval($startLevel);
        if($startLevel==0){

            foreach($this->categories as $category){
                $parentId = $category['parent'];

                if($parentId==0){
                    if(! $data=$this->modx->getObject( 'mSkladCategoryData', array('category_id' => $category['id']) ) ){
                        $data = $this->modx->newObject('mSkladCategoryData');
                        $data->set( 'category_id',$category['id']);
                        $data->save();
                    }

                    if(!$data->get('uuid')){
                        if($exchange=$this->modx->getObject( 'mSkladCategoryExchange', array('category_id' => $category['id']) ) ){
                            $data->set('uuid',  $exchange->get('uuid'));
                            $data->save();
                        }
                    }

                    $data->set('level',  1);
                    $data->save();

                    unset($data);
                }
                else{
                    $q = $this->modx->newQuery('modResource', array('id'=>$parentId));
                    $q->select('class_key');


                    if($this->modx->getCount('modResource', $q)){
                        if($q->prepare() && $q->stmt->execute()){
                            $parentRes = $q->stmt->fetch(PDO::FETCH_ASSOC);

                            $parentClass = $parentRes['class_key'];

                            if(!empty($parentClass) && $parentClass != 'msCategory'){

                                if(! $data=$this->modx->getObject( 'mSkladCategoryData', array('category_id' => $category['id']) ) ){
                                    $data = $this->modx->newObject('mSkladCategoryData');
                                    $data->set( 'category_id',$category['id']);
                                    $data->save();
                                }

                                if(!$data->get('uuid')){
                                    if($exchange=$this->modx->getObject( 'mSkladCategoryExchange', array('category_id' => $category['id']) ) ){
                                        $data->set('uuid',  $exchange->get('uuid'));
                                        $data->save();
                                    }
                                }

                                $data->set('level',  1);
                                $data->save();

                                unset($data);

                            }
                            unset($parentRes);
                        }
                    }
                }

            }
            $this->categories=array();

            $this->setCategoryLevel(1);
        }
        else {
            $q = $this->modx->newQuery('mSkladCategoryData', array('level'=>$startLevel, 'active'=>1));
            $q->select('category_id');

            if($this->modx->getCount('mSkladCategoryData', $q)){
                if ($q->prepare() && $q->stmt->execute()){
                    $categoriesData = $q->stmt->fetchAll(PDO::FETCH_ASSOC);

                    $newlevel = $startLevel+1;

                    foreach($categoriesData as $categoryData){
                        $parentId = $categoryData['category_id'];

                        $child_q = $this->modx->newQuery('msCategory', array('class_key' => 'msCategory', 'parent'=>$parentId, 'deleted'=>0));
                        $child_q->select('id');

                        if($this->modx->getCount('msCategory', $child_q)){
                            if ($child_q->prepare() && $child_q->stmt->execute()){
                                $children = $child_q->stmt->fetchAll(PDO::FETCH_ASSOC);

                                foreach($children as $child){
                                    if(! $data=$this->modx->getObject( 'mSkladCategoryData', array('category_id' => $child['id']) ) ){
                                        $data = $this->modx->newObject('mSkladCategoryData');
                                        $data->set( 'category_id',$child['id']);
                                        $data->save();
                                    }

                                    if(!$data->get('uuid')){
                                        if($exchange=$this->modx->getObject( 'mSkladCategoryExchange', array('category_id' => $child['id']) ) ){
                                            $data->set('uuid',  $exchange->get('uuid'));
                                            $data->save();
                                            unset($exchange);
                                        }
                                    }

                                    $data->set('level',  $newlevel);
                                    $data->save();
                                    unset($data);
                                }
                                unset($children);
                            }
                        }

                    }
                    unset($categoriesData);

                    $this->setCategoryLevel($newlevel);

                }
            }
        }
    }
}

return 'mSkladCategoryPrepareProcessor';