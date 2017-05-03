<?php
namespace common\user\controllers;
use Yii;
use dektrium\user\controllers\SecurityController as BaseSecurityController;

/**
 * Description of SecurityController
 *
 * @author Thomas
 */
class SecurityController extends BaseSecurityController{
  
    public function init() {
        if(Yii::$app->user->isGuest){
        $this->layout = '//main-login';
        
        }
      
    }
}
