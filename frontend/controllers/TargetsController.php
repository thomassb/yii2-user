<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Targets;
use frontend\models\search\Targets as TargetsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * TargetsController implements the CRUD actions for Targets model.
 */
class TargetsController extends Controller {

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
     * Lists all Targets models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new TargetsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $reportForm = new \frontend\models\forms\formReport();
        $pupilData = null;
        $pupil = null;
        $yeargroup = null;

        $listOfStrands = ArrayHelper::map(\frontend\models\Strands::find()->joinWith('subjectAreas')->joinWith('subject')->asArray()
                                ->select(['Strands.ID', '`Strands`.`ID` as ssid',
                                    new \yii\db\Expression("CONCAT(`subject`, ': ' , `StrandText` ) as ss")])->where(['active' => 1])
                                ->orderBy('SubjectID, Strands.ID')->all(), 'ssid', 'ss');

        $reportForm->load(Yii::$app->request->getQueryParams());

        //  $models = $this->createMultiple(Targets::classname());
        if (Yii::$app->request->post()) {
            foreach (Yii::$app->request->post('Targets') as $key => $value) {
//echo strpos($key, 'idd');
                if ($key == 'id') {
                    foreach ($value as $nonSavedTargetkey => $nonSavedTarget) {
                        $_t = new Targets();
                        $_t->PupilID = $reportForm->PupilID;
                        $_t->StrandID = preg_replace('/\D/', '', $nonSavedTargetkey);
                        $_t->load($nonSavedTarget, '');
                        $_t->save();
                    }
                } elseif (strpos($key, 'id') == 0) {
                    foreach ($value as $SavedTargetkey => $SavedTarget) {

                        $id = preg_replace('/\D/', '', $key);
                        $_t = Targets::findOne($id);
                        if (!$_t) {
                            $_t = new Targets();
                            $_t->PupilID = $reportForm->PupilID;
                            $_t->StrandID = preg_replace('/\D/', '', $SavedTargetkey);
                        }

                        $_t->load($SavedTarget, '');

                        //  $_t->created = date('Y-m-d H:i:s', time());
                        //echo'<pre>';
                        // print_r($_t);

                        $_t->save();
                        //  print_r($_t->getErrors());
                        //  /exit;
                    }
                }
            }
        }
        // exit;
        if (isset(Yii::$app->request->getQueryParams()['formReport']['classID'])) {
//            if ($model->load(Yii::$app->request->post()) && $model->save()) {
//                return $this->redirect(['view', 'formReport[pupilID]' => $model->id]);
//            }
//            foreach ($models as $value) {
//                $value->PupilID = $reportForm->pupilID;
//                $value->save();
//            }
            if ($reportForm->classID) {
                
            }
            if ($reportForm->PupilID > 0) {

                $pupil = \frontend\models\Pupils::findOne($reportForm->PupilID);
                if ($pupil) {
                    $yeargroup = \frontend\models\YearGroups::getYearGroup($pupil->DoB);

                    if ($yeargroup->YearGroup == 'N1' || $yeargroup->YearGroup == 'N2' || $yeargroup->YearGroup == 'Reception') {
                        //no targets needed
                        \Yii::$app->getSession()->setFlash('warning', 'Pupil is in early years');
                        return $this->render('index', [
                                    'searchModel' => $searchModel,
                                    'dataProvider' => $dataProvider,
                                    'reportForm' => $reportForm,
                                    'pupilData' => $pupilData,
                                    'pupil' => $pupil,
                                    'listOfStrands' => $listOfStrands,
                                    'yeargroup' => $yeargroup
                        ]);
                    }
                }
                $pupilData = Targets::find()->where(['pupilID' => $reportForm->PupilID])->all();

                if (!$pupilData) {
                    foreach ($listOfStrands as $key => $strand) {

                        $target = new Targets();
                        $target->PupilID = $reportForm->PupilID;
                        $target->StrandID = $key;
                        $pupilData[] = $target;
                    }
                }
            }
        }
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'reportForm' => $reportForm,
                    'pupilData' => $pupilData,
                    'pupil' => $pupil,
                    'listOfStrands' => $listOfStrands,
                    'yeargroup' => $yeargroup
        ]);
    }

    /**
     * Displays a single Targets model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Targets model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Targets();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Targets model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Targets model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Targets model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Targets the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Targets::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public static function createMultiple($modelClass, $multipleModels = [], $data = null) {
        $model = new $modelClass;
        $formName = $model->formName();
        // added $data=null to function arguments
        // modified the following line to accept new argument
        $post = empty($data) ? Yii::$app->request->post($formName) : $data[$formName];
        $models = [];

        if (!empty($multipleModels)) {
            $keys = array_keys(ArrayHelper::map($multipleModels, 'id', 'id'));
            $multipleModels = array_combine($keys, $multipleModels);
        }

        if ($post && is_array($post)) {
            foreach ($post as $i => $item) {
                if (isset($item['id']) && !empty($item['id']) && isset($multipleModels[$item['id']])) {
                    $models[] = $multipleModels[$item['id']];
                } else {
                    $models[] = new $modelClass;
                }
            }
        }

        unset($model, $formName, $post);

        return $models;
    }

}
