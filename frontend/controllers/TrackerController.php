<?php

namespace frontend\controllers;

use Yii;

class TrackerController extends \yii\web\Controller {

    // public function init()
//{
//    parent::init();
//    $this->layoutPath = \Yii::getAlias('@app/themes/main/layouts/');
//    $this->layout = 'main';
//}
    public function actionIndex() {
//$p = \frontend\models\Pupils::findOne(['ID'=>1]);
//print_r($p->statementList);
//exit;
        
        // select all statements in the specific strand and level
        //join on pupil satments
        
        
        $searchModel = new \frontend\models\search\Statements();
//        $searchModel->PupilID = 1;
//        $queryParams["Statements"]["LevelID"] = 1;
//        $queryParams["Statements"]["StrandID"] = 1;
        $queryParams =  Yii::$app->request->getQueryParams();
        
        $dataProvider = $searchModel->search($queryParams);
        $pupil = \frontend\models\Pupils::findOne(['id'=>$searchModel->PupilID]);
        return $this->render('index', ['searchModel' => $searchModel, 'dataProvider' => $dataProvider,'pupil'=>$pupil]);
    }
    public function actionAjaxPupilPage() {
        
        //TODO: Limit to school
        $searchModel = new \frontend\models\search\Statements();
        
        $queryParams = Yii::$app->request->getQueryParams();
       
        $dataProvider = $searchModel->search($queryParams);
        $pupil = \frontend\models\Pupils::findOne(['id'=>$searchModel->PupilID]);
        return $this->renderAjax('pupilpageXeditable', ['searchModel' => $searchModel, 'dataProvider' => $dataProvider,'pupil'=>$pupil]);
    }
    public function actionAjaxPupilPageold() {
        $searchModel = new \frontend\models\search\PupilStatements();
        $searchparams = Yii::$app->request->queryParams;
        $searchparams['PupilStatements']['PupilID'] = 1;
        $searchparams['PupilStatements']["Statements"]["LevelID"] = 1;
        $searchparams['PupilStatements']["Statements"]["StrandID"] = 1;
        $dataProvider = $searchModel->search($searchparams);
        $dataProvider->pagination->pageSize = 10;
        return $this->render('pupilpage1', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
        $model = \frontend\models\PupilStatements::find()->where(['PupilID' => 1])->all();
        return $this->render('pupilpage', ['model' => $model]);
    }

    public function actionTest() {
        $s = \frontend\models\Statements::find()->limit(20)->all();
        foreach ($s as $value) {
            echo $value->StatementText . ' ' . $value->pupilStatement['PartiallyDate'] . '  <br>';
        }
    }
public function actionAjaxSave(){
   
    $trackersave = new \frontend\models\forms\TrackerSave();
    $trackersave->load(Yii::$app->request->queryParams,'');
    $trackersave->load(Yii::$app->request->post(),'');
   if($trackersave->save())
   {//return 200
       echo 'true';
   }
   else{//return !200
        Yii::$app->response->statusCode = 400;
       Yii::$app->response->content = \yii\bootstrap\Html::errorSummary($trackersave);
       return Yii::$app->response;
     
       }
   }
}

