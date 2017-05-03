<?php

namespace common\user;

use Yii;
use dektrium\user\Module as BaseModule;

class Module extends BaseModule {

    public function runAction($route, $params = array()) {
        if (Yii::$app->user->isGuest) {
            $this->layout = '//main-login';
        }
        return parent::runAction($route, $params);
    }

    public function init() {

        return parent::init();
    }

}
