<?php

namespace common\user;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use dektrium\user\models\Profile as BaseProfile;

/**
 * Description of user
 *
 * @author Thomas
 */
class Profile extends BaseProfile {

   public function returnHashedProfileImage() {
        return md5($this->user_id . 'd');
    }
//    public function getAvatarUrl($size = 200)
//    {
//        return '//gravatar.com/avatar/' . $this->gravatar_id . '?s=' . $size;
//    }
//    public function getAvatarUrl($size = 200) {
//        if ($this->avatar) {
//            return $this->avatar;
//        } else {
//            return 'default.jpg';
//        }
//    }

}
