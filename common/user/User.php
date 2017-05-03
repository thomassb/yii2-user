<?php

namespace common\user;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use dektrium\user\models\User as BaseUser;

/**
 * Description of user
 *
 * @author Thomas
 */
class User extends BaseUser {

    public function getFullname() {
        $profile = $this->profile;
        if ($profile->name == '') {
            return $this->username;
        }
     return   $profile->name;
    }

}
