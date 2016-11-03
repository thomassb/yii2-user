<?php

use yii\helpers\Url;

/**
 * @var string $subject
 * @var \common\user\models\User $user
 * @var \common\user\models\Profile $profile
 * @var \common\user\models\UserKey $userKey
 */
?>

<h3><?= $subject ?></h3>

<p><?= Yii::t("user", "Please confirm your email address by clicking the link below:") ?></p>

<p><?= Url::toRoute(["/user/confirm", "key" => $userKey->key_value], true); ?></p>