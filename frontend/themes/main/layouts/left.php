<?php

use yii\bootstrap\Html;
?>
<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <?= yii\bootstrap\Html::img('@web/uploads/users/' . \Yii::$app->user->identity->profile->myavatar, ['class' => 'img-circle square-215', 'alt' => "User Image"]) ?>

            </div>
            <div class="pull-left info">
                <p><?= Yii::$app->user->identity->profile->full_name ?></p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form -->
        <form action="#" method="get" class="sidebar-form" style="display: none">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
                <span class="input-group-btn">
                    <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                    </button>
                </span>
            </div>
        </form>
        <!-- /.search form -->

        <?=
        dmstr\widgets\Menu::widget(
                [
                    'options' => ['class' => 'sidebar-menu  margin-bottom'],
                    'items' => [
                        ['label' => 'Pupil data entry',
                            'icon' => 'fa  fa-user',
                            'url' => ['/tracker'],
//                                'items' => [
//                                     ['label' => 'View', 'icon' => 'fa fa-users', 'url' => ['/news']],
//                                    ['label' => 'New', 'icon' => 'fa fa-plus', 'url' => ['/news/create']],
//                                     ['label' => 'Categories', 'icon' => 'fa fa-plus', 'url' => ['/news/Categories']],
//                                ]
                        ],
                        ['label' => 'Reports',
                            'icon' => 'fa  fa-file',
                            'url' => '#',
                            'items' => [
                                  ['label' => 'Current Level Statments', 'icon' => 'fa  fa-file', 'url' => ['/report/current-level-statments']],
                                ['label' => 'Summary Report', 'icon' => 'fa  fa-file', 'url' => ['/report/summary']],
                                ['label' => 'Detailed Report', 'icon' => 'fa  fa-file', 'url' => ['/report/detailed']],
                                ['label' => 'Starting Levels', 'icon' => 'fa  fa-file', 'url' => ['/report/starting-level']],
                                ['label' => 'Assessment Grid', 'icon' => 'fa  fa-file', 'url' => ['/report/assessment-grid']],
                            ]
                        ],
//                     ['label' => 'Insures',
//                                'icon' => 'fa fa-briefcase',
//                                'url' => '#',
//                                'items' => [
//                                     ['label' => 'View', 'icon' => 'fa fa-file-code-o', 'url' => ['/insure']],
//                                    ['label' => 'New', 'icon' => 'fa fa-file-code-o', 'url' => ['/insure/create']],
//                                ]],
                        ['label' => 'Admin',
                            'icon' => 'fa fa-circle-o',
                            'url' => '#',
                            'visible' => Yii::$app->user->can("adminrole"),
                            'items' => [
                                ['label' => 'Targets', 'icon' => 'fa fa-bullseye', 'url' => ['/targets']],
                                ['label' => 'Classes', 'icon' => 'fa fa-users', 'url' => ['/classes']],
                                ['label' => 'Pupils', 'icon' => 'fa fa-child', 'url' => ['/pupils']],
                                ['label' => 'Subjects', 'icon' => 'fa fa-book', 'url' => ['/subject']],
                                ['label' => 'Strands', 'icon' => 'fa fa-tag', 'url' => ['/strand']],
                                ['label' => 'Statements', 'icon' => 'fa  fa-tags', 'url' => ['/statements']],
                                ['label' => 'Users', 'icon' => 'fa fa-user-circle', 'url' => ['/user/admin']],
                            ]],
                    // ['label' => 'Menu Yii2', 'options' => ['class' => 'header']],
                    //  ['label' => 'Gii', 'icon' => 'fa fa-file-code-o', 'url' => ['/gii']],
                    //   ['label' => 'Debug', 'icon' => 'fa fa-dashboard', 'url' => ['/debug']],
                    //['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
//                    [
//                        'label' => 'Same tools',
//                        'icon' => 'fa fa-share',
//                        'url' => '#',
//                        'items' => [
//                            ['label' => 'Gii', 'icon' => 'fa fa-file-code-o', 'url' => ['/gii'],],
//                            ['label' => 'Debug', 'icon' => 'fa fa-dashboard', 'url' => ['/debug'],],
//                            [
//                                'label' => 'Level One',
//                                'icon' => 'fa fa-circle-o',
//                                'url' => '#',
//                                'items' => [
//                                    ['label' => 'Level Two', 'icon' => 'fa fa-circle-o', 'url' => '#',],
//                                    [
//                                        'label' => 'Level Two',
//                                        'icon' => 'fa fa-circle-o',
//                                        'url' => '#',
//                                        'items' => [
//                                            ['label' => 'Level Three', 'icon' => 'fa fa-circle-o', 'url' => '#',],
//                                            ['label' => 'Level Three', 'icon' => 'fa fa-circle-o', 'url' => '#',],
//                                        ],
//                                    ],
//                                ],
//                            ],
//                        ],
//                    ],
                    ],
                ]
        )
        ?>
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1">

<?= Html::img($url = $this->theme->baseUrl . '/images/logo.jpg', ['class' => 'img-responsive img-rounded']) ?>
            </div>
        </div>
    </section>

</aside>
