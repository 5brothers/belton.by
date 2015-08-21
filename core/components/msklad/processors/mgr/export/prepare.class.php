<?php

class mSkladExportPrepareProcessor extends modObjectProcessor {

    private $start, $total, $name;
    private $products=array();
    public $languageTopics = array('msklad:export');


    public function initialize() {
        $this->config = $this->modx->msklad->config;
        $this->start = intval($this->getProperty('start'));
        $this->total = intval($this->getProperty('total'));
        $this->name = $this->getProperty('name');
        if(trim($this->name) ==''){
            $this->name = date('d-m-Y_H-i');
        }

        $q = $this->modx->newQuery('msProduct', array('class_key' => 'msProduct','deleted'=>0));
        $this->total = $this->modx->getCount('msProduct',  $q);

        $q->limit(500,$this->start);

        $this->products =  $this->modx->getCollection('msProduct', $q);
        return true;
    }

    public function process() {
        if (count($this->products)==0) {
            return $this->failure($this->modx->lexicon('msklad_export_err_no_product'));
        }

        $stop=0;

        $filename = $this->config['assetsPath'].'export/ms2_products_'.$this->name.'.csv';
        setlocale(LC_ALL, "ru_RU");

        if($this->start==0){

            $targetDir = $this->config['assetsPath'].'export';
            if (is_dir($targetDir) && ($dir = opendir($targetDir))) {
                while (($file = readdir($dir)) !== false) {
                    $tmpfilePath = $targetDir.'/'.$file;
                    @unlink($tmpfilePath);
                }
                closedir($dir);
            }


            $head = array("Групы","Код","Наименование","Внешний код","Артикул","Единица измерения","Цена продажи","Валюта (Цена продажи)","Закупочная цена","Валюта (Закупочная цена)","Неснижаемый остаток","Штрихкод EAN13","Штрихкод EAN8","Штрихкод Code128","Описание","Минимальная цена","Страна","НДС","Поставщик","Архивный","Вес","Объем");
            $csv = fopen($filename, 'w+');
            fputcsv($csv, $head,';');
            fclose($csv);
        }

        $csv = fopen($filename, 'a');


        foreach($this->products as $product){

            $fields=array(
                "Групы"=>implode('/',array_reverse($this->getParents($product->get('parent'))))
                ,"Код"=>$product->get('id')
                ,"Наименование"=>$product->get('pagetitle')
                ,"Внешний код"=>$product->get('id')
                ,"Артикул"=>$product->get('article')
                ,"Единица измерения"=>'шт'
                ,"Цена продажи"=>$product->get('price')
                ,"Валюта (Цена продажи)"=>'руб'
                ,"Закупочная цена"=>''
                ,"Валюта (Закупочная цена)"=>''
                ,"Неснижаемый остаток"=>''
                ,"Штрихкод EAN13"=>''
                ,"Штрихкод EAN8"=>''
                ,"Штрихкод Code128"=>''
                ,"Описание"=>$product->get('introtext')
                ,"Минимальная цена"=>''
                ,"Страна"=>$product->get('made_in')
                ,"НДС"=>''
                ,"Поставщик"=>''
                ,"Архивный"=>'нет'
                ,"Вес"=>intval($product->get('weight'))
                ,"Объем"=>0
            );

            fputcsv($csv, $fields,';');
        }
        fclose($csv);



        if($this->start+500 > $this->total) $stop=1;
        return $this->success(array('total'=> $this->total,'stop'=>$stop,'name'=>$this->name));
    }

    public function getParents($parentId,$parent_group=array()){

        if($parentId==0) return $parent_group;

        $q = $this->modx->newQuery('modResource', array('id'=>$parentId));
        $q->select('pagetitle, parent, class_key');

        if($this->modx->getCount('modResource', $q)){
            if($q->prepare() && $q->stmt->execute()){
                $parentRes = $q->stmt->fetch(PDO::FETCH_ASSOC);

                $parentClass = $parentRes['class_key'];

                if(!empty($parentClass) && $parentClass == 'msCategory'){
                    $parent_group[]=$parentRes['pagetitle'];
                    $parent_group += $this->getParents($parentRes['parent'],$parent_group);
                }
            }
        }

        return $parent_group;
    }


}

return 'mSkladExportPrepareProcessor';