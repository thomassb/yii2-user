<?php
namespace common\user\controllers;
use Yii;
use dektrium\user\controllers\RecoveryController as BaseRecoveryController;

/**
 * Description of SecurityController
 *
 * @author Thomas
 */
class RecoveryController extends BaseRecoveryController{
  
    public function init() {
        if(Yii::$app->user->isGuest){
        $this->layout = '//main-login';
        
        }
      
    }
}
