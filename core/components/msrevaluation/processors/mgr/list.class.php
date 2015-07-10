<?php
class msRevaluationListProcessor extends modObjectGetListProcessor {
    public $classKey = 'Revaluation';
    public $languageTopics = array('msrevaluation:default');
    public $defaultSortField = 'time';
    public $defaultSortDirection = 'DESC';
    public $objectType = 'msrevaluation';
    
    /*public function process() {
        $beforeQuery = $this->beforeQuery();
        if ($beforeQuery !== true) {
            return $this->failure($beforeQuery);
        }
        $data = $this->getData();
        $list = $this->iterate($data);
        if($data['total'] == 0) $data['total'] = 1; 
        return $this->outputArray($list,$data['total']);
    }*/
    
    public function afterIteration(array $list) {
        /*if(!count($list)){
            $object['id_categiry'] = '';
            $object['time'] = '';
            $object['comment'] = $this->modx->lexicon('empty_grid');
            $object['action'] = '';
            $object['id'] = '';
            $list[] = $object;
        }
        else {*/
            foreach($list as $ind => $object){
                if(!$object['id_categiry']){
                    $object['id_categiry'] = 'Все';
                }
                else{
                    $cat = $this->modx->getObject('modResource', $object['id_categiry']);
                    $object['id_categiry'] = $cat->pagetitle;
                }
                if($object['action'] == 1) $object['action'] = '<div style="text-align:center;">+' . $object['percent'] . '%</div>';
                else $object['action'] = '<div style="text-align:center;">-' . $object['percent'] . '%</div>';
                $object['time'] = date('d.m.Y h:i', $object['time']);
                $list[$ind] = $object;
            }
        //}
        return $list;
    }
}
return 'msRevaluationListProcessor';
?>