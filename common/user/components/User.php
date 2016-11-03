<?php

namespace common\user\components;

use Yii;

/**
 * User component
 */
class User extends \yii\web\User
{
    /**
     * @inheritdoc
     */
    public $identityClass = 'common\user\models\User';

    /**
     * @inheritdoc
     */
    public $enableAutoLogin = true;

    /**
     * @inheritdoc
     */
    public $loginUrl = ["/user/login"];

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // check if user is banned. if so, log user out and redirect home
        /** @var \common\user\models\User $user */
//        $user = $this->getIdentity();
//        if ($user && $user->ban_time) {
//            $this->logout();
//            Yii::$app->getResponse()->redirect(['/'])->send();
//            return;
//        }
    }

    /**
     * Check if user is logged in
     *
     * @return bool
     */
    public function getIsLoggedIn()
    {
        return !$this->getIsGuest();
    }

    /**
     * @inheritdoc
     */
    public function afterLogin($identity, $cookieBased, $duration)
    {
        /** @var \common\user\models\User $identity */
        $identity->updateLoginMeta();
        parent::afterLogin($identity, $cookieBased, $duration);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfile()
    {
        $profile = Yii::$app->getModule("user")->model("Profile");
        $user = new \common\user\models\User();
        return $user->hasOne($profile::className(), ['user_id' => 'id']);
    }
    /**
     * Get user's display name
     *
     * @param string $default
     * @return string
     */
    public function getDisplayName($default = "")
    {
        /** @var \common\user\models\User $user */
        $user = $this->getIdentity();
        return $user ? $user->getDisplayName($default) : "";
    }

    /**
     * Check if user can do $permissionName.
     * If "authManager" component is set, this will simply use the default functionality.
     * Otherwise, it will use our custom permission system
     *
     * @param string $permissionName
     * @param array  $params
     * @param bool   $allowCaching
     * @return bool
     */
    public function can($permissionName, $params = [], $allowCaching = true)
    {
        // check for auth manager to call parent
        $auth = Yii::$app->getAuthManager();
        if ($auth) {
            return parent::can($permissionName, $params, $allowCaching);
        }

        // otherwise use our own custom permission (via the role table)
        /** @var \common\user\models\User $user */
        $user = $this->getIdentity();
        return $user ? $user->can($permissionName) : false;
    }
}
