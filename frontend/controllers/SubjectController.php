<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Subjects;
use frontend\models\search\Subjects as SubjectsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\data\ArrayDataProvider;

/**
 * SubjectController implements the CRUD actions for Subjects model.
 */
class SubjectController extends Controller {

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
     * Lists all Subjects models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new SubjectsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Subjects model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        $subject = $this->findModel($id);
        $strands = $subject->strands;
        return $this->render('view', [
                    'model' => $subject,
                    'strands' => $strands
        ]);
    }

    /**
     * Creates a new Subjects model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Subjects();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->ID]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Subjects model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $subject = $this->findModel($id);
        $strands = $subject->subjectAreas;
        $provider = new ArrayDataProvider([
            'allModels' => $strands,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        if ($subject->load(Yii::$app->request->post()) && $subject->save()) {
            return $this->redirect(['view', 'id' => $subject->ID]);
        } else {
            return $this->render('update', [
                        'model' => $subject,
                        'strands' => $provider
            ]);
        }
    }

    /**
     * Deletes an existing Subjects model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Subjects model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Subjects the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Subjects::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionAddstrand() {
        $_params = Yii::$app->request->post();
        $_response = new \common\helpers\jsonResponse();
        if (isset($_params['strandid']) && isset($_params['subjectid'])) {
            $sub = intval($_params['subjectid']);
            $strand = intval($_params['strandid']);
            $strandSubjectLink = \frontend\models\SubjectAreas::find(false)->where(['SubjectID' => $sub, 'AreaID' => $strand])->one();
            if (!$strandSubjectLink) {
                $strandSubjectLink = new \frontend\models\SubjectAreas();
                 $strandSubjectLink->SubjectID = $sub;
            $strandSubjectLink->AreaID = $strand;
            }
           
            $strandSubjectLink->active = 1;
            if ($strandSubjectLink->save()) {//return 200
                $_response->status = \common\helpers\jsonResponse::STATUS_SUCCESS;
                $_response->encode();

                $_response->sendResponse(200, $_response->encodedData, 'text/json');
            } else {//return !200
                $_response->status = \common\helpers\jsonResponse::STATUS_ERROR;
                $_response->errors = $_response->errorsToString($strandSubjectLink->errors);
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

    public function actionRemovestrand() {
        $_params = Yii::$app->request->post();
        $_response = new \common\helpers\jsonResponse();

        if (isset($_params['rowid'])) {
            $strandSubjectLink = \frontend\models\SubjectAreas::findOne(intval($_params['rowid']));


            if ($strandSubjectLink->delete()) {//return 200
                $_response->status = \common\helpers\jsonResponse::STATUS_SUCCESS;
                $_response->encode();

                $_response->sendResponse(200, $_response->encodedData, 'text/json');
            } else {//return !200
                $_response->status = \common\helpers\jsonResponse::STATUS_ERROR;
                $_response->errors = $_response->errorsToString($strandSubjectLink->errors);
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
