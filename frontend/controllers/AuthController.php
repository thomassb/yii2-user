<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Bulletins;
use frontend\models\search\Bulletins as BulletinsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BulletinsController implements the CRUD actions for Bulletins model.
 */
class AuthController extends Controller {

    public function actionInit() {
        $auth = Yii::$app->authManager;

        // add "createPost" permission
        $tracker = $auth->createPermission('tracker');
        $tracker->description = 'Add tracker data';
        $auth->add($tracker);

        // add "updatePost" permission
        $bulletins = $auth->createPermission('bulletins');
        $bulletins->description = 'Manage Bulletins';
        $auth->add($bulletins);

        $cal = $auth->createPermission('cal');
        $cal->description = 'Manage Callender Events';
        $auth->add($cal);

        $adminr = $auth->createPermission('adminrole');
        $adminr->description = 'Admin role';
        $auth->add($adminr);

        // add "author" role and give this role the "createPost" permission
        $teacher = $auth->createRole('teacher');
        $auth->add($teacher);
        $auth->addChild($teacher, $tracker);

        $exteacher = $auth->createRole('extendedteacher');
        $auth->add($exteacher);
        $auth->addChild($exteacher, $tracker);
        $auth->addChild($exteacher, $cal);
        $auth->addChild($exteacher, $bulletins);


        // add "admin" role and give this role the "updatePost" permission
        // as well as the permissions of the "author" role
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $tracker);
        $auth->addChild($admin, $cal);
        $auth->addChild($admin, $bulletins);
        $auth->addChild($admin, $adminr);

        // Assign roles to users. 1 and 2 are IDs returned by IdentityInterface::getId()
        // usually implemented in your User model.
        $auth->assign($teacher, 3);
        $auth->assign($exteacher, 2);
        $auth->assign($admin, 1);
    }

}
