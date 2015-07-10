<?php
/**
 * revaluation class file for revaluation extra
 *
 * Copyright 2013 by Alex dir000@mail.ru
 * Created on 07-04-2013
 *
 * revaluation is free software; you can redistribute it and/or modify it under the
 * terms of the GNU General Public License as published by the Free Software
 * Foundation; either version 2 of the License, or (at your option) any later
 * version.
 *
 * revaluation is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * revaluation; if not, write to the Free Software Foundation, Inc., 59 Temple
 * Place, Suite 330, Boston, MA 02111-1307 USA
 *
 * @package revaluation
 */

class msRevaluation {
    public $config = array();
    public $modx = NULL;
    public $parent = NULL;
    public $id_vendor = NULL;
    public $percent = 0;
    public $revaluationDir = 1;
    public $formatePrice = 1;
    public $comment = '';
    public $revaluationsList = array();
    public $alredyDoned = array();
    public $revaluation_log_path = 'core/components/msrevaluation/log.txt';
    public $revaluation_history_path = 'assets/components/msrevaluation/history/';
    public $error = '';

    public function __construct(modX &$modx, $scriptProperties = array()){
        $this->modx =& $modx;
        $modx->addPackage('msrevaluation',MODX_BASE_PATH.'core/components/msrevaluation/model/');
        $this->config = $scriptProperties;
        $this->config['assets_path'] = $modx->getOption('assets_path').'components/msrevaluation/';
        $this->config['core_path'] = $modx->getOption('core_path').'components/msrevaluation/';
        $this->config['assets_url'] = $modx->getOption('assets_url').'components/msrevaluation/';
        $this->config['core_url'] = $modx->getOption('base_url').'core/components/msrevaluation/';
        $this->config['connectorUrl'] = $this->config['assets_url'].'connector.php';

        $protectedResources = array_merge(explode(',', $modx->getOption('protected_parents')), explode(',',$modx->getOption('protect_from_revaluation')));
        $this->config['protected'] = array();
        foreach($protectedResources as $parent){
            if(!$parent = (int)trim($parent)) continue;
            $childs = $modx->getChildIds($parent, 5, array('context'=>'web'));
            $this->config['protected'] = array_merge($this->config['protected'], $childs, array($parent));
        }
        return true;
    }

    // ПЕРЕОЦЕНКА -------------------------------------------------------------------------------

    public function process(){
        if($this->config['id_categiry']) $this->parent = $this->config['id_categiry'];

        if(!$this->config['percent']){
            $this->setErrors('Не указан процент изменения цены');
            return false;
        }
        $this->percent = $this->config['percent'];

        if($this->config['rev_dir']) $this->revaluationDir = $this->config['rev_dir'];

        if(!$this->config['coefficient']) $this->formatePrice = 0;

        if($this->config['comment']) $this->comment = $this->config['comment'];

        if(!$this->revaluationProcess()){
            $this->setErrors('Для категории id='.$this->parent.' переоценка запрещена');
            return false;
        }
        if($historyFile = $this->saveHistory()){
            return $historyFile;
        }
        else{
            $this->setErrors('Не удалось создать запись о переоценке в базе данных. Данные о изменении цен сохранены в файле '.MODX_BASE_PATH.$this->$revaluation_history_path);
            return false;
        }
    }

    public function revaluationProcess($parent = false){
        if(!$parent) $parent = $this->parent;
        // выборка товаров категории
        if(in_array($parent,$this->config['protected'])){
            $this->setErrors('Категория id='.$this->parent.' исключена из переоценки (переоценка запрещена системными настройками)');
            return false;
        }
        if($parent) $chengedProducts = $this->modx->getCollection('msProduct', array('parent'=>$parent));
        else $chengedProducts = $this->modx->getCollection('msProduct');
        // в цикле переоценка (с использованием функции формирвания "красивой цены" $this->formatPrice($price), если включена эта опция) и запись старых цен в массив $revaluationsList
        foreach($chengedProducts as $product){
            if(in_array($product->id, $this->alredyDoned))
                continue;
            $product = $this->modx->getObject('msProductData', $product->id);
            // если указан производитель и данный товар не того производителя
            if($this->config['id_vendor'] && $this->config['id_vendor'] > 0 && $product->vendor != $this->config['id_vendor'])
                continue;
            $price = $product->price;
            if($this->revaluationDir == 1){
                $price = $price * (100 + $this->percent) * 0.01;
            }
            else{
                $price = $price * (100 - $this->percent) * 0.01;
                $this->revaluationDir = 2;
            }

            $price = $this->formatPrice($price);
            $delta = $price - $product->price;
            $product->price = $price;
            if($product->save()){
                $this->revaluationsList[$product->id] = $delta;
                $this->alredyDoned[] = $product->id;
            }
            else{
                $this->revaluationsList[$product->id] = 0;
                $this->setErrors('Не удалось изменить цену для товара '.$product->pagetitle.'('.$product->id.')');
            }
        }
        $chengedCategory = $this->modx->getCollection('msCategory', array('parent'=>$parent));
        if(count($chengedCategory)){
            foreach($chengedCategory as $category){
                $this->revaluationProcess($category->id);
            }
        }
        return true;
    }

    public function saveHistory(){
        $fileName = time().'.php';
        if(file_exists(MODX_BASE_PATH.$this->revaluation_history_path.$fileName)){
            $i = 1;
            while(file_exists(MODX_BASE_PATH.$this->revaluation_history_path.$fileName)){
                $fileName = $i.'_'.$fileName;
                $i++;
            }
        }
        if(file_put_contents(MODX_BASE_PATH.$this->revaluation_history_path.$fileName, serialize($this->revaluationsList))) return $fileName;
        else{
            $this->setErrors('Не удалось сохранить файл истории');
            if($this->restorePrices($this->revaluationsList)){
                $this->setErrors('Внесенные изменения были отменены');
                return false;
            }
            else{
                $this->setErrors('Не удалось отменить внесенные изменения');
                return false;
            }
        }
    }


    // ОТКАТ ПЕРЕОЦЕНКИ --------------------------------------------------------------------------

    public function restoreProcess($buckupData = NULL){
        if(!$buckupData && $this->config['id']) {
            $buckupData = $this->config['id'];
        }
        if(!$buckupData){
            $this->setErrors('Не возможно восстановить цены. Не передан идентификатор переоценки');
            return false;
        }
        else if(is_array($buckupData) && count($buckupData) > 0) {
            // передаем массив на обработку методу restorePrices
            if(!$this->restorePrices($buckupData)) $this->setErrors('Не удалось восстановить цены');
            else return true;
        }
        else if(file_exists(MODX_BASE_PATH.$this->revaluation_history_path.$buckupData)){
            // достаем массив из файла
            $buckupData = unserialize(file_get_contents(MODX_BASE_PATH.$this->revaluation_history_path.$buckupData));
            // передаем массив на обработку методу restorePrices
            if(!$this->restorePrices($buckupData)){
                $this->setErrors('Не удалось восстановить цены');
                return false;
            }
            else{
                unlink(MODX_BASE_PATH.$this->revaluation_history_path.$buckupData);
                return true;
            }
        }
        else if(!is_numeric($buckupData)){
            $this->setErrors('Не возможно восстановить цены. Не корректный идентификатор переоценки');
            return false;
        }
        else if($record = $this->modx->getObject('Revaluation', (int)$buckupData)){
            if(!file_exists(MODX_BASE_PATH.$this->revaluation_history_path.$record->history_file)){
                $this->setErrors('Не удалось найти файл с данными о переоценке '.MODX_BASE_PATH.$this->revaluation_history_path.$record->history_file);
                return false;
            }
            $buckupData = file_get_contents(MODX_BASE_PATH.$this->revaluation_history_path.$record->history_file);
            if($this->restorePrices(unserialize($buckupData))){
                unlink(MODX_BASE_PATH.$this->revaluation_history_path.$record->history_file);
                return true;
            }
            else return false;
        }
        else{
            $this->setErrors('Не удалось восстановить массив с исходными данными');
            return false;
        }
    }

    public function restorePrices($revaluationsList){
        // в цикле по массиву $revaluationsList возвращает цены
        foreach($revaluationsList as $id => $oldPrice){
            $product = $this->modx->getObject('msProductData', $id);
            $product->price = $product->price - $oldPrice;
            if(!$product->save()){
                $this->setErrors('Не удалось изменить цену для ресурса с id '.$id);
                $this->invalid[] = $id;
            }
        }
        if(count($revaluationsList) == count($this->invalid)) return false;
        else return true;
    }


    // ВСПОМОГАТЕЛЬНЫЕ МЕТОДЫ --------------------------------------------------------------------

    public function formatPrice($price){
        // формирование "красивой цены"
        if($price < 0) $formatedPrice = 0;
        else{
            if($this->formatePrice) $formatedPrice = round($price/$this->config['coefficient'], 0)*$this->config['coefficient'];
            else $formatedPrice = round($price, 2);
        }
        return $formatedPrice;
    }

    public function setErrors($message){
        // Запись сообщения об ошибке в системный журнал, лог или вывод
        $this->modx->log(modX::LOG_LEVEL_ERROR, $message);
        file_put_contents(MODX_BASE_PATH.$this->revaluation_log_path, date('d.m.Y H:i:s')."\n".$message."\n\n", FILE_APPEND);
        $this->error = $message;
    }
}

?>