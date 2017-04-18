<?php

namespace frontend\controllers;

use Yii;
use frontend\models\PupilStartingLevel;
use frontend\models\search\PupilStartingLevel as PupilStartingLevelSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PupilStartingLevelController implements the CRUD actions for PupilStartingLevel model.
 */
class PupilStartingLevelController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all PupilStartingLevel models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new PupilStartingLevelSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PupilStartingLevel model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PupilStartingLevel model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new PupilStartingLevel();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->ID]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing PupilStartingLevel model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->ID]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing PupilStartingLevel model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the PupilStartingLevel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PupilStartingLevel the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = PupilStartingLevel::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /*
     * Used to add a startling level
     */

    public function actionAdd() {
        $_params = Yii::$app->request->post();
        $_response = new \common\helpers\jsonResponse();
        if (isset($_params['strandid']) && isset($_params['levelid']) && isset($_params['pupil'])) {
            $level = intval($_params['levelid']);
            $strand = intval($_params['strandid']);
            $pupilid = intval($_params['pupil']);
            $date = Yii::$app->formatter->asDate(time(), 'php:Y-m-d H:i:s');


            $startinglevel = PupilStartingLevel::find()->where(['PupilID' => $pupilid, 'StrandID' => $strand])->one();
            if (!$startinglevel) {
                $newStartingLevel = new PupilStartingLevel();
                $newStartingLevel->PupilID = $pupilid;
                $newStartingLevel->StrandID = $strand;
                $newStartingLevel->StartingLevel = $level;
                $startinglevel->LevelDate = $date;
                $result = $newStartingLevel->save();
            } else {
                if ($startinglevel->StartingLevel != $level) {
                    $startinglevel->StartingLevel = $level;
                    $startinglevel->LevelDate = $date;
                  
                    $result = $startinglevel->save();
                }
            }

            if ($result === true) {//return 200
                $_response->status = \common\helpers\jsonResponse::STATUS_SUCCESS;
                $_response->encode();

                $_response->sendResponse(200, $_response->encodedData, 'text/json');
            } else {//return !200
                $_response->status = \common\helpers\jsonResponse::STATUS_ERROR;
                $_response->errors = $_response->errorsToString($newStartingLevel->errors);
                $_response->encode();


                $_response->sendResponse(200, $_response->encodedData, 'text/json');
            }
        } else {//return !200
            $_response->status = \common\helpers\jsonResponse::STATUS_ERROR;
            $_response->errors = 'No params';
            $_response->encode();

            $_response->sendResponse(200, $_response->encodedData, 'text/json');
        }
    }

    public function actionRemove() {
        $_params = Yii::$app->request->post();
        $_response = new \common\helpers\jsonResponse();

        if (isset($_params['rowid'])) {
            $startingLevel = PupilStartingLevel::findOne(intval($_params['rowid']));


            if ($startingLevel->delete()) {//return 200
                $_response->status = \common\helpers\jsonResponse::STATUS_SUCCESS;
                $_response->encode();

                $_response->sendResponse(200, $_response->encodedData, 'text/json');
            } else {//return !200
                $_response->status = \common\helpers\jsonResponse::STATUS_ERROR;
                $_response->errors = $_response->errorsToString($startingLevel->errors);
                $_response->encode();


                $_response->sendResponse(200, $_response->encodedData, 'text/json');
            }
        } else {//return !200
            $_response->status = \common\helpers\jsonResponse::STATUS_ERROR;
            $_response->errors = 'No params';
            $_response->encode();

            $_response->sendResponse(200, $_response->encodedData, 'text/json');
        }
    }

}
