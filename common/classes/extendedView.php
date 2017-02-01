<?php
namespace common\classes;

use yii\base;

/**
 * Description of extendedView
 *
 * @author Thomas
 */
class extendedView extends \yii\web\View{
    public $strap = '';
    public $metaDescription;
    public $metaKeywords;
    public $directoryAsset2;

    function beforeRender($viewFile, $params) {
      //todo: add theme support
         $theme='sheringham';
          $this->directoryAsset2 = \Yii::$app->assetManager->getPublishedUrl('@web/themes/'.$theme.'/images');
           \Yii::$app->view->theme = new base\Theme([
            'pathMap' => ['@app/views' => [ '@app/themes/'.$theme,'@app/themes/main/'] ],
            'baseUrl' => '@web/themes/'.$theme,
           'basePath' => '@app/themes/'.$theme,

        ]);  
        return parent::beforeRender($viewFile, $params);
    }
    function init() {
          
        return parent::init();
    }
}
