<?php
  if(Yii::$app->user->isGuest){
    require(__DIR__ .'/main-login.php');
  }
else{
     require(__DIR__ .'/main-loggedin.php');
}

