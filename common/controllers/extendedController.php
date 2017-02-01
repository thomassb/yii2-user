<?php
namespace common\controllers;

use yii\base;

/**
 * Description of extendedView
 *
 * @author Thomas
 */
class extendedController extends \yii\web\Controller{
    public $directoryAsset2;
  
    function beforeAction($action) {
      //todo: add theme support
         $theme='sheringham';
          $this->directoryAsset2 = \Yii::$app->assetManager->getPublishedUrl('@web/themes/'.$theme.'/images');
           \Yii::$app->view->theme = new base\Theme([
            'pathMap' => ['@app/views' => [ '@app/themes/'.$theme,'@app/themes/main/'] ],
            'baseUrl' => '@web/themes/'.$theme,
           'basePath' => '@app/themes/main',

        ]);  
        return parent::beforeAction($action);
    }
 
}
