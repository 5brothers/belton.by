<?php
if ($modx->event->name == 'OnBeforeEmptyTrash') {
    $mSklad = $modx->getService('msklad','mSklad', $modx->getOption('core_path').'components/msklad/model/msklad/');
    $mSklad->initialize($modx->context->key);

    $deletedids = $modx->event->params['ids'];
    foreach ($deletedids as $resourceid) {
        if( $category = $modx->getObject( 'mSkladCategoryData', array('category_id' => $resourceid)) ){
            $category->remove();
        }
        if( $product = $modx->getObject( 'mSkladProductData', array('product_id' => $resourceid)) ){
            $product->remove();
        }
    }
}
return;