<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/avatar.png" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p><?=Yii::$app->user->displayName ?></p>

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
                    'options' => ['class' => 'sidebar-menu'],
                    'items' => [
                        ['label' => 'Pupil data entry',
                            'icon' => 'fa  fa-users',
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
//                                'items' => [
//                                     ['label' => 'View', 'icon' => 'fa  fa-file', 'url' => ['/page']],
//                                    ['label' => 'New', 'icon' => 'fa fa-plus', 'url' => ['/page/create'], 'visible'=>Yii::$app->user->can("admin")],
//                                ]
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
                            'visible' => true, //Yii::$app->user->can("admin"),
                            'items' => [
                                ['label' => 'Classes', 'icon' => 'fa ', 'url' => ['/classes']],
                                ['label' => 'Pupils', 'icon' => 'fa fa-user', 'url' => ['/pupils']],
                                ['label' => 'Subjects', 'icon' => 'fa fa-tag', 'url' => ['#']],
                                ['label' => 'Statements', 'icon' => 'fa fa-file-code-o', 'url' => ['/statements']],
                                ['label' => 'Users', 'icon' => 'fa fa-file-code-o', 'url' => ['#']],
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

    </section>

</aside>
