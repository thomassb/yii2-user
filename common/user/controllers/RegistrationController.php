<?php
namespace common\user\controllers;
use Yii;
use dektrium\user\controllers\RegistrationController as BaseRegistrationController;

/**
 * Description of SecurityController
 *
 * @author Thomas
 */
class RegistrationController extends BaseRegistrationController{
  
    public function init() {
        if(Yii::$app->user->isGuest){
        $this->layout = '//main-login';
        
        }
      
    }
}
