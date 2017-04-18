<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Pupils;
use frontend\models\search\Pupils as PupilsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\data\ArrayDataProvider;

/**
 * PupilsController implements the CRUD actions for Pupils model.
 */
class PupilsController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    // allow authenticated users
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                // everything else is denied
                ],
            ],
        ];
    }

    /**
     * Lists all Pupils models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new PupilsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Pupils model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Pupils model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Pupils(['SchoolID' => \Yii::$app->user->identity->SchoolID,'UserID' => \Yii::$app->user->identity->id]);

        if ($model->load(Yii::$app->request->post()) &&  $model->save() ) {
           
           
            return $this->redirect(['view', 'id' => $model->ID]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Pupils model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        $startinglevels = $model->pupilStartingLevels;
        $provider = new ArrayDataProvider([
            'allModels' => $startinglevels,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
//$startinglevels=  \frontend\models\search\PupilStartingLevel::find()->where(['pupilid'=>$model->id]);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            \Yii::$app->getSession()->setFlash('success', 'Pupil Saved');
            return $this->refresh();
        } else {
            return $this->render('update', [
                        'model' => $model,
                        'startinglevels' => $provider
            ]);
        }
    }

    /**
     * Deletes an existing Pupils model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Pupils model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Pupils the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Pupils::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionAjaxClassPupil() {
        $post = Yii::$app->request->post();


        $out = [];
        if (isset($post['depdrop_parents'][0]) && $post['depdrop_parents'][0] != '') {
            $parents = $post['depdrop_parents'][0];

            $cat_id = $parents;
            $r = \frontend\models\Pupils::find()->where(['ClassID' => $cat_id])->all();
        } else {
            $r = \frontend\models\Pupils::find()->all();
        }
        //  $out = [];
        foreach ($r as $value) {
            $out[] = ['id' => $value->ID, 'name' => $value->FullName];
        }

        echo Json::encode(['output' => $out, 'selected' => '']);
        return;

        // echo Json::encode(['output' => '', 'selected' => '']);
    }

    public function actionAjaxPupilSearch($q = null, $id = null) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $query = new \yii\db\Query;
            $query->select('Pupils.id,  FirstName, LastName,`ClassName`')
                    ->from(Pupils::tableName())
                    ->rightJoin('Classes', 'Pupils.ClassID=Classes.id')
                    ->where(['like', 'FirstName', $q])
                    ->orWhere(['like', 'LastName', $q])
                    ->limit(20);
            $command = $query->createCommand();
            $data = $command->queryAll();
            $pupilout = [];
            foreach ($data as $pupil) {
                $pupilout[] = ['id' => $pupil['id'], 'text' => $pupil['FirstName'] . ' ' . $pupil['LastName'] . ' (' . $pupil['ClassName'] . ')'];
            }
            $out['results'] = array_values($pupilout);
        } elseif ($id > 0) {
            $out['results'] = ['id' => $id, 'text' => Pupils::find($id)->FullName];
        }
        return $out;
    }

}
