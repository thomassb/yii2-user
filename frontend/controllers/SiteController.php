<?php

namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use frontend\models\Bulletins;
use frontend\models\search\Bulletins as BulletinsSearch;

/**
 * Site controller
 */
class SiteController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
               // 'only' => ['index', 'create', 'update', 'view'],
                'rules' => [
                    // allow authenticated users
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                // everything else is denied
                ],
//            'access' => [
//                'class' => AccessControl::className(),
//                'only' => ['logout', 'signup'],
//                'rules' => [
//                    [
//                        'actions' => ['signup'],
//                        'allow' => true,
//                        'roles' => ['?'],
//                    ],
//                    [
//                        'actions' => ['*'],
//                        'allow' => true,
//                        'roles' => ['@'],
//                    ],
//                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex() {
        $BulletinssearchModel = new BulletinsSearch();
        $BulletinsdataProvider = $BulletinssearchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', ['BulletinsdataProvider' => $BulletinsdataProvider]);
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin() {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout() {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact() {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout() {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup() {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
                    'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset() {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
                    'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token) {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
                    'model' => $model,
        ]);
    }

    public function actionTest() {



     Yii::$app->mailer->compose()
     ->setFrom('spat@spat.sheringhamwoodfields.co.uk')
     ->setTo('tomferny@gmail.com')
     ->setSubject('Email sent from Yii2-Swiftmailer')
     ->send();
    }
public function actionUploadspatimportfiles(){
    
}
    public function actionSpatimport() {
         ini_set('max_execution_time', 300);
//          ini_set('post_max_size', "20M");
//          ini_set('upload_max_filesize', "20M");
         
          
        $importform = new \common\imports\form();
        $importfileDir = __DIR__ . '/../../common/imports/files';
        if (Yii::$app->request->isPost) {
            $importform->files = \yii\web\UploadedFile::getInstances($importform, 'files');
            if ($importform->files) {
                if ($importform->validate()) {
                    foreach ($importform->files as $file) {


                        $file->saveAs($importfileDir . '/' . $file->name);
                    }
                }
            } else {
                $importform->load(Yii::$app->request->post());

                if ($importform->doimport == 'yes') {
                    $_import =new \common\imports\main();
                    $r=$_import->doImport();
                    if($r===true){
                         Yii::$app->session->setFlash('success', 'Data successfully imported.');
                    }
                }
            }
        }


        $iterator = new \FilesystemIterator($importfileDir);
        $files = [];
        foreach ($iterator as $fileInfo) {
            if ($fileInfo->isFile()) {
                $cTime = new \DateTime();
                $cTime->setTimestamp($fileInfo->getCTime());
                $files[] = ['name' => $fileInfo->getFileName(), 'date' => $cTime->format('Y-m-d h:i:s')];
            }
        }

        $_fileList = ['Classes.txt', 'Keystages.txt', 'KeyStageYearGroups.txt', 'Levels.txt', 'LevelText.txt', 'Pupils.txt',
            'PupilStartingLevel.txt', 'PupilStatements.txt', 'Statements.txt', 'Strands.txt', 'SubjectAreas.txt', 'Subjects.txt'];
        $fileList = [];
        $allfiles = true;
        foreach ($_fileList as $seachfiled) {
            $hasfile = false;
            foreach ($files as $file) {
                if ($file['name'] == $seachfiled) {
                    $hasfile = true;
                }
            }
            if ($hasfile === false) {
                $allfiles = false;
            }
            $fileList[] = ['name' => $seachfiled, 'there' => $hasfile];
        }

        return $this->render('../import/index', [
                    'files' => $files,
                    'fileList' => $fileList,
                    'allfiles' => $allfiles,
                    'importform' => $importform
        ]);
    }

}
