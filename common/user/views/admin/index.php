<?php

use yii\helpers\Html;
use yii\grid\GridView;

$user = Yii::$app->getModule("user")->model("User");
$role = Yii::$app->getModule("user")->model("Role");

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var common\user\models\search\UserSearch $searchModel
 * @var common\user\models\User $user
 * @var common\user\models\Role $role
 */
$this->title = Yii::t('user', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <div class="market-create">

        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse">
                        <i class="fa fa-minus"></i>
                    </button>
                    <button class="btn btn-box-tool" data-widget="remove">
                        <i class="fa fa-remove"></i>
                    </button>
                </div>
            </div>
            <div class="box-body">

                <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                <p>
                    <?=
                    Html::a(Yii::t('user', 'Create {modelClass}', [
                                'modelClass' => 'User',
                            ]), ['create'], ['class' => 'btn btn-success'])
                    ?>
                </p>

                <?=
                GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        'id',
                        [
                            'attribute' => 'role_id',
                            'label' => Yii::t('user', 'Role'),
                            'filter' => $role::dropdown(),
                            'value' => function($model, $index, $dataColumn) use ($role) {
                                $roleDropdown = $role::dropdown();
                                return $roleDropdown[$model->role_id];
                            },
                        ],
                        [
                            'attribute' => 'status',
                            'label' => Yii::t('user', 'Status'),
                            'filter' => $user::statusDropdown(),
                            'value' => function($model, $index, $dataColumn) use ($user) {
                                $statusDropdown = $user::statusDropdown();
                                return $statusDropdown[$model->status];
                            },
                        ],
                                    'username',
                        'email:email',
                        'profile.full_name',
                       // 'create_time',
                        // 'new_email:email',
                        // 'username',
                        // 'password',
                        // 'auth_key',
                        // 'api_key',
                        // 'login_ip',
                        // 'login_time',
                        // 'create_ip',
                        // 'create_time',
                        // 'update_time',
                        // 'ban_time',
                        // 'ban_reason',
                        ['class' => 'yii\grid\ActionColumn'],
                    ],
                ]);
                ?>
            </div>
        </div>

    </div>
</div>
