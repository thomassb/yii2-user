<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use frontend\models\forms\formReport;
use yii\data\ArrayDataProvider;
use \kartik\mpdf\Pdf;
use yii\helpers\ArrayHelper;
use PHPExcel;

/**
 * LevelController implements the CRUD actions for Levels model.
 */
class ReportController extends Controller {

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
     * Lists all Levels models.
     * @return mixed
     */
    public function actionIndex() {
        $formReport = new formReport();
        //  $searchModel = new LevelsSearch();
        //  $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'formReport' => $formReport,
                        //   'dataProvider' => $dataProvider,
        ]);
    }

    public static function PupilMaxLevel($puplID, $subjectID = null, $strandID = null) {
        $form = new formReport();
        $form->PupilID = $puplID;
        $form->subjectID = $subjectID;
        $form->strandID = $strandID;
        $me = new self([], []);
        $levels = $me->_MaxLevels($form, $puplID);
//        print_r($levels);
//        exit;
        if ($levels && isset($levels[0]['lid'])) {
            return $levels[0]['lid'];
//            $connection = Yii::$app->db;
//            $command = $connection->createCommand('CALL GetPupilCurrentLevel(:pupilID,:strandid,:levelid)');
//            $command->bindValue(':pupilID', $puplID);
//            $command->bindValue(':strandid', $levels[0]['id']);
//            $command->bindValue(':levelid', $levels[0]['lid']);
//            $levels = $command->queryAll();
//            return $levels;
        }
        return 0;
    }

    public static function _MaxLevels($reportForm, $pupilid) {
        /* SELECT  Strands.id ,max(levelid) as lid, SubjectAreas.SubjectID  FROM `PupilStatements` 
          join Statements on Statements.id = PupilStatements.StatementID
          join Strands on Strands.id = Statements.strandid
          JOIN SubjectAreas ON SubjectAreas.areaid = Strands.ID
          where pupilid = '1' and consolidateddate is not null and consolidateddate >0 group by SubjectAreas.SubjectID, strandid
         * 
         * 
         * This should fall back onto start levels if no max is found.
         */
        $connection = Yii::$app->db;
        $sqlbase = "SELECT Strands.id ,max(levelid) as lid, SubjectAreas.SubjectID FROM `PupilStatements`
                           join Statements on Statements.id = PupilStatements.StatementID
                           join Strands on Strands.id = Statements.strandid 
                            join SubjectAreas on SubjectAreas.areaid =  Strands.id";
        if ($reportForm->subjectID) {
            $sql = $sqlbase . "
                            where pupilid = :pupilID and SubjectAreas.subjectid = :subjectID ";
            if ($reportForm->strandID) {
                $sql.=' and Strands.id  = ' . intval($reportForm->strandID);
            }

            if ($reportForm->dateFrom) {
                $sql.=' and  (consolidateddate between  :startDate and :endDate
                       or PartiallyDate between  :startDate and :endDate or AchievedDate between  :startDate and :endDate)	
                       group by SubjectID, strandid';
                $command = $connection->createCommand($sql);
                $command->bindValue(':startDate', $reportForm->dateFrom);
                $command->bindValue(':endDate', $reportForm->dateTo);
            } else {
                $sql.=' and consolidateddate is not null and consolidateddate >0  group by SubjectID, strandid;';
                $command = $connection->createCommand($sql);
            }
            $command->bindValue(':subjectID', $reportForm->subjectID);
        } else {
            $sql = $sqlbase . ' where pupilid = :pupilID';
            if ($reportForm->dateFrom) {
                $sql.=' and  (consolidateddate between  :startDate and :endDate
                       or PartiallyDate between  :startDate and :endDate or AchievedDate between  :startDate and :endDate)	
                       group by SubjectID, strandid';
                $command = $connection->createCommand($sql);
                $command->bindValue(':startDate', $reportForm->dateFrom);
                $command->bindValue(':endDate', $reportForm->dateTo);
            } else {
                //  $command = $connection->createCommand('CALL GetPupilStatmentMaxLevels(:pupilID)');
                $sql.=' and consolidateddate is not null and consolidateddate >0
                       group by SubjectID, strandid';
                $command = $connection->createCommand($sql);
            }
        }

        $command->bindValue(':pupilID', $pupilid);
        $maxlevels = $command->queryAll();

        return $maxlevels;
    }

    public static function GetPupilCurrentLevel($pupilID, $straindID, $levelID, $subjectID, $dateTo = null) {
        /*
         * select Subject, StrandText, pupilid as pid,
          Statements.strandid as sid,

          (SELECT  count(PupilStatements.id )
          FROM `PupilStatements` join Statements on Statements.id = PupilStatements.StatementID
          where strandid =vastrandid and levelid =valevelid and pupilid= vapupilid and consolidateddate is not null and consolidateddate >0
          GROUP BY strandid, levelid) as statmentcount,

          (SELECT  count(id )
          FROM `Statements` where strandid =vastrandid and levelid =valevelid
          GROUP BY strandid, levelid) as totalstatments, (select statmentcount)/(select totalstatments)  as perc ,
          (
          SELECT LevelText
          FROM `LevelsText`
          WHERE levelid =valevelid
          AND levelpercentage <=CEIL(perc / 0.20) *0.02*1000 or levelid =(valevelid-1)
          ORDER BY levelid DESC, levelpercentage DESC
          LIMIT 1 ) as thelevel

          from  PupilStatements
          join Statements on Statements.id = PupilStatements.StatementID
          join Strands on Strands.id = Statements.strandid
          join SubjectAreas on SubjectAreas.AreaID = Statements.strandid
          join Subjects on Subjects.ID = SubjectAreas.SubjectID
          where pupilid=vapupilid and levelid = valevelid and strandid  =vastrandid
          group by strandid;
         */
        $sql = "select Subjects.ID as subjectid, Subject, StrandText, pupilid as pid,
 Statements.strandid as sid, 
";
        if ($dateTo === null) {
            $sql.=" (SELECT  count(PupilStatements.id )
                    FROM `PupilStatements` join Statements on Statements.id = PupilStatements.StatementID 
                    where strandid =:strandid and levelid =:levelID and pupilid= :pupilID and consolidateddate is not null and consolidateddate >0
                    GROUP BY strandid, levelid) as statmentcount,";
        } else {
            $sql.=" ( select(
                    SELECT  count(PupilStatements.id )
                    FROM `PupilStatements` join Statements on Statements.id = PupilStatements.StatementID 
                    where strandid =:strandid and levelid =:levelID and pupilid= :pupilID and consolidateddate is not null and consolidateddate <= :dateTo
                    GROUP BY strandid, levelid)) as statmentcount,";
        }

        $sql.=" (SELECT  count(id )
                FROM `Statements` where strandid =:strandid and levelid =:levelID
                GROUP BY strandid, levelid) as totalstatments, (select statmentcount)/(select totalstatments)  as perc ,
                (
                SELECT LevelText
                FROM `LevelsText`
                WHERE levelid =:levelID
                AND levelpercentage <=CEIL(perc / 0.20) *0.02*1000 or levelid =(:levelID-1)
                ORDER BY levelid DESC, levelpercentage DESC
                LIMIT 1 ) as thelevel

                from  PupilStatements 
                join Statements on Statements.id = PupilStatements.StatementID
                join Strands on Strands.id = Statements.strandid 
                join SubjectAreas on SubjectAreas.AreaID = Statements.strandid
                join Subjects on Subjects.ID = SubjectAreas.SubjectID  
                where pupilid=:pupilID and levelid = :levelID and strandid  =:strandid and Subjects.ID=:subjectID
                group by strandid;";
        $connection = Yii::$app->db;
        $command = $connection->createCommand($sql);
        $command->bindValue(':pupilID', $pupilID);
        $command->bindValue(':strandid', $straindID);
        $command->bindValue(':levelID', $levelID);
        $command->bindValue(':subjectID', $subjectID);
        $command->bindValue(':dateTo', $dateTo);
        $levels = $command->queryAll();
        return $levels;
    }

    public static function GetListOfStrands() {
        //TODO: Add strand/ subject ordering
//        $_listOfStrands=\frontend\models\Strands::find()->joinWith('subjectAreas')->joinWith('subject')->asArray()
//                                ->select(['Strands.ID', new \yii\db\Expression("CONCAT(`SubjectID`, ':' , `Strands`.`ID` ) as ssid"),
//                                    new \yii\db\Expression("CONCAT(`subject`, ': ' , `StrandText` ) as ss")])->where(['active' => 1])
//                                ->orderBy('SubjectID, Strands.ID')->all();
        $sql = "SELECT `Strands`.`ID`, CONCAT(`SubjectID`, ':' , `Strands`.`ID` ) as ssid, "
                . "CONCAT(`subject`, ': ' , `StrandText` ) as ss FROM `Strands` "
                . "LEFT JOIN `SubjectAreas` ON `Strands`.`ID` = `SubjectAreas`.`AreaID` "
                . "LEFT JOIN `Subjects` ON `SubjectAreas`.`SubjectID` = `Subjects`.`ID` "
                . "WHERE (`active`=1) ORDER BY `SubjectID`, `Strands`.`ID`";
        $connection = Yii::$app->db;
        $command = $connection->createCommand($sql);

        $_listOfStrands = $command->queryAll();
        return $_listOfStrands;
    }

    private function _SummaryDataToArray($pupilRange, $reportForm) {
        //$connection = Yii::$app->db;
        $pupilData = [];
        foreach ($pupilRange as $pupilid) {
            $pupil = \frontend\models\Pupils::findOne($pupilid);
            if ($pupil) {
                $maxlevels = $this->_MaxLevels($reportForm, $pupilid);
                // print_r($maxlevels);
                if (count($maxlevels) == 0) {
                    $blank = ['name' => $pupil->FullName, 'StrandText' => '-', 'thelevel' => '-', 'pid' => $pupilid];
                    $pupilData[$pupilid]['No Records'][] = $blank;
                } else {
                    foreach ($maxlevels as $level) {
//                        $command = $connection->createCommand('CALL GetPupilCurrentLevel(:pupilID,:strandid,:levelid)');
//                        $command->bindValue(':pupilID', $pupilid);
//                        $command->bindValue(':strandid', $level['id']);
//                        $command->bindValue(':levelid', $level['lid']);
//                        $levels = $command->queryAll();
                        $levels = $this->GetPupilCurrentLevel($pupilid, $level['id'], $level['lid'], $level['SubjectID']);
                        $levels[0]['name'] = $pupil->FullName;
                        $pupilData [$pupilid][$levels[0]['Subject']][] = $levels[0];
                    }
                }
            }
        }
//        print_r($pupilData);
//        exit;
        return $pupilData;
    }

    public function actionSummary() {
        $queryParams = Yii::$app->request->getQueryParams();
        $reportForm = new formReport();
        $reportForm->load(Yii::$app->request->getQueryParams());
        if (isset(Yii::$app->request->getQueryParams()['formReport']['classID'])) {

//exit;
            $pupilids = [];
            if ($reportForm->PupilID) {
                $pupilids = [$reportForm->PupilID];
            } elseif ($reportForm->classID) {
                if ($reportForm->PupilPremium == 1) {
                    $pupilids = ArrayHelper::map(\frontend\models\Pupils::find()->where(['ClassID' => $reportForm->classID, 'PupilPremium' => 1])->all(), 'ID', 'ID');
                } else {
                    $pupilids = ArrayHelper::map(\frontend\models\Pupils::find()->where(['ClassID' => $reportForm->classID])->all(), 'ID', 'ID');
                }
            } else {
                if ($reportForm->PupilPremium == 1) {
                    $pupilids = ArrayHelper::map(\frontend\models\Pupils::find()->where(['PupilPremium' => 1])->all(), 'ID', 'ID');
                } else {
                    $pupilids = ArrayHelper::map(\frontend\models\Pupils::find()->all(), 'ID', 'ID');
                }
            }
            if (isset($queryParams['pdf'])) {

                //all pupils
                $pupilData = $this->_SummaryDataToArray($pupilids, $reportForm);
                $providerPDF = new ArrayDataProvider([
                    'allModels' => $pupilData,
                    'pagination' => [
                        'pageSize' => -1,
                    ],
                ]);
                $date = date('jFY');
                $filename = "SummaryReport-{$date}.pdf";
                $filter = $reportForm->NiceFilterName();
                $title = 'Summary Report';
                return $this->SummaryReportPDF($providerPDF, $filename, $title, $filter);

                exit;
            }
            if (isset($queryParams['csv'])) {
                //all pupils
                $this->layout = false;
                $pupilData = $this->_SummaryDataToArray($pupilids, $reportForm);
                $providerCSV = new ArrayDataProvider([
                    'allModels' => $pupilData,
                    'pagination' => [
                        'pageSize' => -1,
                    ],
                ]);
                $date = date('jFY');
                $filename = "SummaryReport-{$date}.csv";
                $filter = $reportForm->NiceFilterName();
                $title = 'Summary Report';
                return $this->ClassPupilSummaryCSV($providerCSV, $filename, $title, $filter);
                exit;
                // \Yii::$app->response->sendContentAsFile($pdf, 'ClassReport.pdf');
            }
            ///$pupilids = range(1, 100);
            $pupilidsNoPerPage = (isset($queryParams['per-page']) ? (intval($queryParams['per-page'])) : 10);

            $pupilidsStart = (isset($queryParams['page']) ? (intval($queryParams['page'])) * $pupilidsNoPerPage - $pupilidsNoPerPage : 0);
            $pupilidsEnd = $pupilidsStart + $pupilidsNoPerPage;

            if (count($pupilids) > $pupilidsNoPerPage) {
                $pupilRange = array_slice($pupilids, $pupilidsStart, $pupilidsNoPerPage, true);
            } else {
                $pupilRange = $pupilids;
            }



            $pupilData = $this->_SummaryDataToArray($pupilRange, $reportForm);


            $pages = new \yii\data\Pagination(['totalCount' => count($pupilids),
                'pageSize' => $pupilidsNoPerPage,
            ]);
            $provider = new ArrayDataProvider([
                'allModels' => $pupilData,
                'pagination' => [
                    'pageSize' => $pupilidsNoPerPage,
                ],
            ]);
        } else {
            $provider = null;
            $pages = null;
        }

        return $this->render('pupilsummary3', [
                    'pupilData' => $provider,
                    'pages' => $pages,
                    'reportForm' => $reportForm
        ]);
    }

    private function _detailedReportData($reportForm, $pupilsNoPerPage, $pupilidsStart) {
        $connection = Yii::$app->db;

        $classID = $reportForm->classID;
        $subjectID = $reportForm->subjectID;
        $pupilid = $reportForm->PupilID;
        // $command = $connection->createCommand('CALL DetailedReport(:pupilID,:classID,:subjectID,:schoolID,:offset,:limit)');
        $sql = 'SELECT * FROM `PupilStatements` 
                join Statements on Statements.id = PupilStatements.StatementID
                join Strands on Strands.id = Statements.strandid 
                join SubjectAreas on SubjectAreas.AreaID = Statements.strandid
                join Subjects on Subjects.ID = SubjectAreas.SubjectID  
                join Pupils on Pupils.id = PupilStatements.pupilid
                where ';
        if ($reportForm->PupilPremium == 1) {
            $sql .=' Pupils.PupilPremium=1 and ';
        }
        $sql .='  (:pupilID is null or Pupils.id =:pupilID) 
                and (:classID is null or Pupils.classid=:classID) 
                and (:schoolID is null or Pupils.schoolid=:schoolID)
                and (:subjectID is null or Subjects.ID=:subjectID )
                order by pupilID, strandID';


// if ($pupilsNoPerPage) {
//            $sql .=  ' limit :offset, :limit';   
//        }
        $command = $connection->createCommand($sql);
//        if ($pupilsNoPerPage) {
//         
//            $command->bindValue(':limit', $pupilsNoPerPage);
//            $command->bindValue(':offset', $pupilidsStart);
//        }

        $command->bindValue(':classID', $classID);
        $command->bindValue(':schoolID', \Yii::$app->user->identity->SchoolID);
        $command->bindValue(':subjectID', $subjectID);
        $command->bindValue(':pupilID', $pupilid);


        $detailedReport = $command->queryAll();


        $pupildata = [];
//         print_r(array_slice($detailedReport,0,10));
//        exit;
        $levelsArray = ArrayHelper::map(\frontend\models\Levels::find()->all(), 'ID', 'LevelText');
        foreach ($detailedReport as $statment) {

            $pupildata[$statment['PupilID']][$statment['Subject']]['PupilName'] = $statment['FirstName'] . ' ' . $statment['LastName'];

            $pupildata[$statment['PupilID']][$statment['Subject']][$statment['StrandID']]['Strand'] = $statment['StrandText'];

            $pupildata[$statment['PupilID']]
                    [$statment['Subject']]
                    [$statment['StrandID']][$levelsArray[$statment['LevelID']]]
                    [$statment['StatementID']] = ['StatementText' => $statment['StatementText'],
                'ConsolidatedDate' => $statment['ConsolidatedDate'],
                'AchievedDate' => $statment['AchievedDate'],
                'PartiallyDate' => $statment['PartiallyDate'],];
        }

        return $pupildata;
    }

    public function actionDetailed() {
        $queryParams = Yii::$app->request->getQueryParams();
        $reportForm = new formReport();
        $reportForm->load(Yii::$app->request->getQueryParams());
        $provider = null;
        if (isset(Yii::$app->request->getQueryParams()['formReport']['classID'])) {

            if (isset($queryParams['pdf'])) {
                return $this->DetailedReportPDF($reportForm);

                exit;
            }
            if (isset($queryParams['csv'])) {
                //all pupils
                $this->layout = false;
                $pupildata = $this->_detailedReportData($reportForm, 100000, 0);
                $providerCSV = new ArrayDataProvider([
                    'allModels' => $pupildata,
                    'pagination' => [
                        'pageSize' => -1,
                    ],
                ]);
                $date = date('jFY');
                $filename = "DetailedReport-{$date}.csv";
                $filter = $reportForm->NiceFilterName();
                $title = 'Detailed Report';
                return $this->ClassPupilDetailedCSV($providerCSV, $filename, $title, $filter);
                exit;
                // \Yii::$app->response->sendContentAsFile($pdf, 'ClassReport.pdf');
            }
            $pupilsNoPerPage = (isset($queryParams['per-page']) ? (intval($queryParams['per-page'])) : 10);

            $pupilidsStart = (isset($queryParams['page']) ? (intval($queryParams['page'])) * $pupilsNoPerPage - $pupilsNoPerPage : 0);

            $pupildata = $this->_detailedReportData($reportForm, $pupilsNoPerPage, $pupilidsStart);


            $provider = new ArrayDataProvider([
                'allModels' => $pupildata,
                'pagination' => [
                    'pageSize' => 10,
                ],
            ]);
        }

        return $this->render('detailed/pupildetailed', [
                    'pupilData' => $provider,
//                    'pages' => $pages,
                    'reportForm' => $reportForm
        ]);
    }

    public function SummaryReportPDF($provider, $filename, $title, $filter) {
        // get your HTML raw content without any layouts or scripts

        $content = $this->renderPartial('pdf/_SummaryPDF', ['pupilData' => $provider]);
        return $this->_CreatePDF($filename, $title, $filter, $content);
    }

    public function DetailedReportPDF($reportForm) {
        // get your HTML raw content without any layouts or scripts
        $pupildata = $this->_detailedReportData($reportForm, 100000, 0);
        $providerPDF = new ArrayDataProvider([
            'allModels' => $pupildata,
            'pagination' => [
                'pageSize' => -1,
            ],
        ]);
        $date = date('jFY');
        $filename = "DetailedReport-{$date}.pdf";
        $filter = $reportForm->NiceFilterName();
        $title = 'Summary Report';
        $content = $this->renderPartial('pdf/_DetailedPDF', ['pupilData' => $providerPDF]);
//echo $content;
//exit;
        return $this->_CreatePDF($filename, $title, $filter, $content);
    }

    private function _CreatePDF($filename, $title, $filter, $content) {
        ini_set('memory_limit', '2560M');
        $content = '<html><tocentry level="0" content="Example Section"></tocentry>' . $content . '</html>';
        $date = date('j F Y');
        // setup kartik\mpdf\Pdf component
        $pdf = new \kartik\mpdf\Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_CORE,
            // A4 paper format
            'format' => Pdf::FORMAT_A4,
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT,
            // stream to browser inline
            'destination' => Pdf::DEST_DOWNLOAD,
            'filename' => $filename,
            // your html content input
            'content' => $content,
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting 
            //  'cssFile' => '@vendor/almasaeed2010/adminlte/dist/css/AdminLTE.min.css',
            'cssFile' => '',
            // any css to be embedded if required
            'cssInline' => 'body{font-family:"Helvetica Neue",Helvetica,Arial,sans-serif;font-size:14px;line-height:1.42857143;color:#333} '
            . '.active{background-color: #f5f5f5;} .info{background-color: #d9edf7;} .odd {  background-color: #f9f9f9;}'
            . '.warning{background-color: #fcf8e3;} table {    border-collapse: collapse;    border-spacing: 0; width: 100%;}  '
            . 'td { padding: 5px;} .spacer{height:50px;}',
            // set mPDF properties on the fly
            'options' => ['title' => $title],
            // 'simpleTables '=>true,
            // call mPDF methods on the fly
            'methods' => [
                'SetHeader' => [$date . ' ' . $title . ' - ' . $filter],
                'SetFooter' => ['{PAGENO}'],
            ]
        ]);

        // return the pdf output as per the destination setting
        return $pdf->render();
    }

    public function ClassPupilSummaryCSV($provider, $filename, $title, $filter) {

        $output = "$title\n";
        $output.= "$filter\n";
        $output.= "\"Pupil\",\"Subject\",\"Stand\",\"Level\"\n";
        foreach ($provider->getModels() as $subject) {
            foreach ($subject as $pupil) {
                foreach ($pupil as $p) {
//                    print_r($p);
//                    exit;
                    $name = (isset($p['name']) ? $p['name'] : '');
                    $subject = (isset($p['Subject']) ? $p['Subject'] : '');
                    $perc = (isset($p['perc'])) ? '(' . $p['perc'] * 100 . '%)' : '';
                    $StrandText = (isset($p['StrandText']) ? $p['StrandText'] : '');
                    $thelevel = (isset($p['thelevel']) ? $p['thelevel'] : '');
                    $output.= "\"{$name}\",\"{$subject}\",\"{$StrandText}\",\"{$thelevel} {$perc}\"" . "\n";
                }
            }
        }
        return \Yii::$app->response->sendContentAsFile($output, $filename);
    }

    public function ClassPupilDetailedCSV($provider, $filename, $title, $filter) {

        $output = "$title\n";
        $output.= "$filter\n";
        $output.= "\"Pupil\",\"Subject\",\"Stand\",\"Level\",\"Statment\",\"Consolidated\",\"Achieved\",\"Partially\"\n";
        foreach ($provider->getModels() as $subject) {
            foreach ($subject as $subkeyname => $pupil) {
                $name = (isset($pupil['PupilName']) ? $pupil['PupilName'] : '');
                $subjectName = $subkeyname;
                foreach ($pupil as $leveltext => $p) {
                    if (is_array($p)) {

                        $StrandText = (isset($p['Strand']) ? $p['Strand'] : '');
                        foreach ($p as $leveltext => $strand) {
                            if (is_array($strand)) {

                                foreach ($strand as $statment) {
                                    $StamentText = (isset($statment['StatementText']) ? $statment['StatementText'] : '');
                                    $Consolidated = (isset($statment['ConsolidatedDate']) ? $statment['ConsolidatedDate'] : '');
                                    $Achieved = (isset($statment['AchievedDate']) ? $statment['AchievedDate'] : '');
                                    $Partially = (isset($statment['PartiallyDate']) ? $statment['PartiallyDate'] : '');
                                    $level = (isset($leveltext) ? $leveltext : '');
                                    $output.= "\"{$name}\",\"{$subjectName}\",\"{$StrandText}\",\"{$level}\",\"{$StamentText}\",\"{$Consolidated}\",\"{$Achieved}\",\"{$Partially}\"\n";
                                }
                            }
                        }
                    }
                }
            }
        }
        return \Yii::$app->response->sendContentAsFile($output, $filename);
    }

    public function StartingLevelsCSV($provider, $filename, $title, $filter) {

        $output = "$title\n";
        $output.= "$filter\n";
        $output.= "\"Pupil\",\"Subject\",\"Stand\",\"Starting Level\",\"Date\"\n";
        foreach ($provider->getModels() as $pupil) {
            $name = (isset($pupil['name']) ? $pupil['name'] : '');
            foreach ($pupil as $key => $subjects) {
                $subject = $key;

                if (is_array($subjects)) {
                    foreach ($subjects as $p) {
                        foreach ($p as $level) {
                            $StrandText = (isset($level['strand']) ? $level['strand'] : '');
                            $thelevel = (isset($level['Level']) ? $level['Level'] : '');
                            $date = ($level['Date'] == '0000-00-00 00:00:00' ? '' : \Yii::$app->formatter->asDate($level['Date'], 'php:Y-m-d'));
                            $output.= "\"{$name}\",\"{$subject}\",\"{$StrandText}\",\"{$thelevel}\",\"{$date}\"" . "\n";
                        }
                    }
                }
            }
        }
        return \Yii::$app->response->sendContentAsFile($output, $filename);
    }

    public function actionStartingLevel($class = null) {
        $queryParams = Yii::$app->request->getQueryParams();
        $reportForm = new formReport();
        $reportForm->load(Yii::$app->request->getQueryParams());
        $pupilid = NULL;
        $subjectID = NULL;
        $classID = NULL;

        $provider = null;


        $startlingLevels = \frontend\models\PupilStartingLevel::find();
        if (isset(Yii::$app->request->getQueryParams()['formReport']['classID'])) {


            if ($reportForm->PupilID) {

                $pupilid = $reportForm->PupilID;
                $startlingLevels->andWhere(['PupilID' => $pupilid]);
            }
            if ($reportForm->classID) {
                $classID = $reportForm->classID;
                $startlingLevels->andWhere(['ClassID' => $classID]);
            }
            if ($reportForm->subjectID) {
                $subjectID = $reportForm->subjectID;
                $startlingLevels->andWhere(['SubjectID' => $subjectID]);
            }
            $pupilsNoPerPage = (isset($queryParams['per-page']) ? (intval($queryParams['per-page'])) : 10);

            $pupilidsStart = (isset($queryParams['page']) ? (intval($queryParams['page'])) * $pupilsNoPerPage - $pupilsNoPerPage : 0);
            $startlingLevels->joinWith('pupil');
            $startlingLevels->joinWith('strand');
            $startlingLevels->joinWith('level');
//$startlingLevels->joinWith('strand.subjectAreas');
            $startlingLevels->joinWith('strand.subjectAreas.subject');


            $levels = $startlingLevels->all();

            $pupildata = [];

            foreach ($levels as $level) {
                if (!isset($pupildata[$level['PupilID']]['name'])) {
                    $pupildata[$level['PupilID']]['name'] = $level->pupil->FullName;
                }

                $pupildata[$level['PupilID']]['levels'][$level->strand->subjectAreas[0]->subject->Subject][] = ['strand' => $level->strand->StrandText, 'Level' => $level->level->LevelText, 'Date' => $level->LevelDate];
            }

            if (isset($queryParams['pdf'])) {

                $providerPDF = new ArrayDataProvider([
                    'allModels' => $pupildata,
                    'pagination' => [
                        'pageSize' => -1,
                    ],
                ]);
                $date = date('jFY');
                $filename = "StartingLevelsReport-{$date}.pdf";
                $filter = $reportForm->NiceFilterName();
                $title = 'Starting Levels Report';
                $content = $this->renderPartial('pdf/_StartingLevelsPDF', ['pupilData' => $providerPDF]);
//echo $content;
//exit;
                return $this->_CreatePDF($filename, $title, $filter, $content);

                exit;
            }
            if (isset($queryParams['csv'])) {
                //all pupils
                $this->layout = false;

                $providerCSV = new ArrayDataProvider([
                    'allModels' => $pupildata,
                    'pagination' => [
                        'pageSize' => -1,
                    ],
                ]);
                $date = date('jFY');
                $filename = "StartingLevelsReport-{$date}.csv";
                $filter = $reportForm->NiceFilterName();
                $title = 'Starting Levels Report';
                return $this->StartingLevelsCSV($providerCSV, $filename, $title, $filter);
                exit;
                // \Yii::$app->response->sendContentAsFile($pdf, 'ClassReport.pdf');
            }

            $provider = new ArrayDataProvider([
                'allModels' => $pupildata,
                'pagination' => [
                    'pageSize' => 10,
                ],
            ]);
        }
        return $this->render('startinglevels/startinglevel', [
                    'pupilData' => $provider,
//                    'pages' => $pages,
                    'reportForm' => $reportForm
        ]);
    }

    public function actionCurrentLevelStatments() {
        $queryParams = Yii::$app->request->getQueryParams();
        $reportForm = new formReport();
        $reportForm->load(Yii::$app->request->getQueryParams());
        $provider = null;
        if (isset(Yii::$app->request->getQueryParams()['formReport']['classID'])) {
            if ($reportForm->PupilID == '' && $reportForm->classID == '') {
                \Yii::$app->getSession()->setFlash('error', 'Please enter a class or pupil');
                return $this->render('currentLevelStaments/currentLevelStatments', [
                            'pupilData' => $provider,
//                    'pages' => $pages,
                            'reportForm' => $reportForm
                ]);
            }

            if ($reportForm->PupilID != '') {
                $searchedPupils = [$reportForm->PupilID];
            } else {
                $searchedPupils = ArrayHelper::map(\frontend\models\Pupils::find()->asArray()->where(['classid' => $reportForm->classID])->select('ID')->all(), 'ID', 'ID');
            }


            if (isset($queryParams['pdf'])) {
                return $this->CurrentLevelStatmentsPDF($reportForm, $searchedPupils);

                exit;
            }
            if (isset($queryParams['csv'])) {
                //all pupils
                $this->layout = false;
                $pupildata = $this->_CurrentLevelStatments($searchedPupils);
                $providerCSV = new ArrayDataProvider([
                    'allModels' => $pupildata,
                    'pagination' => [
                        'pageSize' => -1,
                    ],
                ]);
                $date = date('jFY');
                $filename = "CurrentLevelStatments-{$date}.csv";
                $filter = $reportForm->NiceFilterName();
                $title = 'Current Level Statments Report';
                return $this->CurrentLevelStatmentsCSV($providerCSV, $filename, $title, $filter);
                exit;
                // \Yii::$app->response->sendContentAsFile($pdf, 'ClassReport.pdf');
            }
            $pupilsNoPerPage = 1;

            $pupilidsStart = (isset($queryParams['page']) ? (intval($queryParams['page'])) * $pupilsNoPerPage - $pupilsNoPerPage : 0);

            $pupildata = $this->_CurrentLevelStatments($searchedPupils);


            $provider = new ArrayDataProvider([
                'allModels' => $pupildata,
                'pagination' => [
                    'pageSize' => 1,
                ],
            ]);
        }

        return $this->render('currentLevelStaments/currentLevelStatments', [
                    'pupilData' => $provider,
//                    'pages' => $pages,
                    'reportForm' => $reportForm
        ]);
    }

    private function _CurrentLevelStatments($pupilIDs) {
        /*
         * For each of the subject strands find the pupils current level, if no level set do lowest level.
         * Find all statments in the current level populated with any data already added.
         */
        $subjectStands = \frontend\models\SubjectAreas::find()->all();
        $data = [];

        $pupildata = [];
        $strandArray = ArrayHelper::map(\frontend\models\Strands::find()->all(), 'ID', 'StrandText');
        $levelsArray = ArrayHelper::map(\frontend\models\Levels::find()->all(), 'ID', 'LevelText');
        $subjectArray = ArrayHelper::map(\frontend\models\Subjects::find()->all(), 'ID', 'Subject');
        foreach ($pupilIDs as $pupilID) {
            $pupil = \frontend\models\Pupils::findOne($pupilID);
            $pupildata[$pupilID]['PupilName'] = $pupil->FullName;
            $startlingLevels = ArrayHelper::map(\frontend\models\PupilStartingLevel::find()->where(['PupilID' => $pupilID])->all(), 'StrandID', 'StartingLevel');

            $form = new formReport();
            $form->PupilID = $pupilID;


            $_maxlevels = $this->_MaxLevels($form, $pupilID);
            $maxlevels = [];

            foreach ($_maxlevels as $_ml) {
                $maxlevels[$_ml['SubjectID'] . ':' . $_ml['id']] = $_ml['lid'];
            }
//            print_r($maxlevels);
//            exit;
            foreach ($subjectStands as $subjectStand) {
                $maxlevel = isset($maxlevels[$subjectStand->SubjectID . ':' . $subjectStand->AreaID]) ? $maxlevels[$subjectStand->SubjectID . ':' . $subjectStand->AreaID] : false;

                if (!$maxlevel) {
                    //  echo $subjectStand->SubjectID . ':' . $subjectStand->AreaID;
                    $maxlevel = isset($startlingLevels[$subjectStand->AreaID]) ? $startlingLevels[$subjectStand->AreaID] : 1;
                    //echo'lev: '. $maxlevel;
                }
                if ($maxlevel) {
                    $level = (isset($levelsArray[$maxlevel])) ? ['ID' => $maxlevel, 'LevelText' => $levelsArray[$maxlevel]] : false;
                    /*
                     * Statments should contain all the statments for that level and strand with pupil data
                     */

                    $connection = Yii::$app->db;
                    $sql = "Select  Statements.id, StatementText, StrandID, LevelID, PupilID, StatementID, PartiallyDate, AchievedDate, 
            ConsolidatedDate from Statements left join PupilStatements on Statements.id = PupilStatements.StatementID and PupilID= :pupilID "
                            . "where StrandID = :StrandID and LevelID=:LevelID";
                    $command = $connection->createCommand($sql);
                    $command->bindValue(':pupilID', $pupilID);
                    $command->bindValue(':StrandID', $subjectStand->AreaID);
                    $command->bindValue(':LevelID', $level['ID']);

                    $statments = $command->queryAll();

                    // $statments = \frontend\models\Statements::find()->where(['StrandID' => $subjectStand->AreaID, 'LevelID' => $level->ID])->all();
                } else {
                    $statments = '';
                }
//                $data[$pupilID][] = ['pupilName' => $pupil->FullName,
//                    "subjectName" => $subjectStand->subject->Subject, "subject" => $subjectStand->SubjectID,
//                    "strandName" => isset($strandArray[$subjectStand->AreaID]) ? $strandArray[$subjectStand->AreaID] : '',
//                    "strand" => $subjectStand->AreaID, "maxLevelID" => $maxlevel, "level" => (isset($level['LevelText'])) ? $level['LevelText'] : '',
//                    "statments" => $statments];

                if (is_array($statments)) {
                    foreach ($statments as $statment) {


                        $standText = isset($strandArray[$subjectStand->AreaID]) ? $strandArray[$subjectStand->AreaID] : '';
                        $strandName = isset($strandArray[$subjectStand->AreaID]) ? $strandArray[$subjectStand->AreaID] : '';
                        $subjectName = $subjectArray[$subjectStand->SubjectID]; //$subjectStand->subject->Subject;
                        //    $pupildata[$pupilID][$subjectName][$strandName]['Strand'] = $standText; //,'StrandName'=>'StrandSubject'=>$subjectName];
                        $pupildata[$pupilID][$subjectName]['Subject'] = $subjectName;
                        $pupildata[$pupilID]
                                [$subjectName]
                                [$subjectStand->AreaID]['Strand'] = ['strandText' => $standText, 'level' => (isset($level['LevelText']) ? $level['LevelText'] : '')];
                        $pupildata[$pupilID]
                                [$subjectName]
                                [$subjectStand->AreaID]
                                [$statment['id']] = ['StatementText' => $statment['StatementText'],
                            'ConsolidatedDate' => $statment['ConsolidatedDate'],
                            'AchievedDate' => $statment['AchievedDate'],
                            'PartiallyDate' => $statment['PartiallyDate'],
                            "Level" => (isset($level['LevelText'])) ? $level['LevelText'] : ''];
                    }
                }
            }
        }
//       print_r($pupildata);
//       exit;
        return $pupildata;
        /*
         * foreach ($detailedReport as $statment) {
          $pupildata[$statment['PupilID']][$statment['Subject']]['PupilName'] = $statment['FirstName'] . ' ' . $statment['LastName'];

          $pupildata[$statment['PupilID']][$statment['Subject']][$statment['StrandID']]['Strand'] = $statment['StrandText'];

          $pupildata[$statment['PupilID']]
          [$statment['Subject']]
          [$statment['StrandID']]
          [$statment['StatementID']] = ['StatementText' => $statment['StatementText'],
          'ConsolidatedDate' => $statment['ConsolidatedDate'],
          'AchievedDate' => $statment['AchievedDate'],
          'PartiallyDate' => $statment['PartiallyDate'],];
          }
         */
    }

    public function CurrentLevelStatmentsCSV($provider, $filename, $title, $filter) {

        $output = "$title\n";
        $output.= "$filter\n";
        $output.= "\"Pupil\",\"Subject\",\"Stand\",\"Level\",\"Statment\",\"Consolidated\",\"Achieved\",\"Partially\"\n";
        foreach ($provider->getModels() as $subject) {
            foreach ($subject as $subkeyname => $pupil) {
                $name = (isset($pupil['PupilName']) ? $pupil['PupilName'] : '');
                $subjectName = $subkeyname;
                if ($subkeyname != 'PupilName') {
                    foreach ($pupil as $p) {
                        if (is_array($p)) {
                            $StrandText = (isset($p['Strand']['strandText']) ? $p['Strand']['strandText'] : '');
                            $LevelText = (isset($p['Strand']['level']) ? $p['Strand']['level'] : '');

                            foreach ($p as $strand) {
                                //print_r($strand);

                                $StamentText = (isset($strand['StatementText']) ? $strand['StatementText'] : '');
                                $Consolidated = (isset($strand['ConsolidatedDate']) ? $strand['ConsolidatedDate'] : '');
                                $Achieved = (isset($strand['AchievedDate']) ? $strand['AchievedDate'] : '');
                                $Partially = (isset($strand['PartiallyDate']) ? $strand['PartiallyDate'] : '');

                                $output.= "\"{$name}\",\"{$subjectName}\",\"{$StrandText}\",\"{$LevelText}\",\"{$StamentText}\",\"{$Consolidated}\",\"{$Achieved}\",\"{$Partially}\"\n";
                            }
                        }
                    }
                }
            }
        }
        return \Yii::$app->response->sendContentAsFile($output, $filename, ['content' => 'application/octet-stream; charset=UTF-8']);
    }

    /*
     * Unused
     */

    public function CurrentLevelStatmentsPDF($reportForm, $pupilIDs) {
        // get your HTML raw content without any layouts or scripts
        $pupildata = $this->_CurrentLevelStatments($pupilIDs);
        $providerPDF = new ArrayDataProvider([
            'allModels' => $pupildata,
            'pagination' => [
                'pageSize' => -1,
            ],
        ]);
        $date = date('jFY');
        $filename = "CurrentLevelStatments-{$date}.pdf";
        $filter = $reportForm->NiceFilterName();
        $title = 'Current Level Statments Report';
        $content = $this->renderPartial('pdf/_currentLevelStatmentPDF', ['pupilData' => $providerPDF]);
//echo $content;
//exit;
        return $this->_CreatePDF($filename, $title, $filter, $content);
    }

    public function actionPupilSummary($class = null) {
        $pupilid = 1;
        $pupilData = [];
        $connection = Yii::$app->db;

        $command = $connection->createCommand('CALL GetPupilStatmentMaxLevels(:pupilID)');
        $command->bindValue(':pupilID', $pupilid);
        $maxlevels = $command->queryAll();
        //var_dump($maxlevels);
        //exit;
        foreach ($maxlevels as $level) {
            $levels = $this->GetPupilCurrentLevel($pupilid, $level['id'], $level['lid'], $level['SubjectID']);
//            $command = $connection->createCommand('CALL GetPupilCurrentLevel(:pupilID,:strandid,:levelid)');
//            $command->bindValue(':pupilID', $pupilid);
//            $command->bindValue(':strandid', $level['id']);
//            $command->bindValue(':levelid', $level['lid']);
//            $levels = $command->queryAll();
            $pupilData [$pupilid][$levels[0]['Subject']][] = $levels;
            //var_dump($levels);
        }
//       var_dump( $pupilData);
//       exit;
        $provider = new ArrayDataProvider([
            'allModels' => $pupilData,
//    'sort' => [
//        'attributes' => ['id', 'username', 'email'],
//    ],
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $this->render('pupilsummary', [
                    'pupilData' => $provider
        ]);
    }

    public function actionAjaxLevelStrand() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $cat_id = $parents[0];
                $r = \frontend\models\Statements::find()->select(['LevelID'])->joinWith('levels')->where(['StrandID' => $cat_id])->distinct()->all();
                $out = [];
                foreach ($r as $value) {
                    $out[] = ['id' => $value->level->ID, 'name' => $value->level->LevelText];
                }

                echo Json::encode(['output' => $out, 'selected' => '']);
                return;
            }
        }
        echo Json::encode(['output' => '', 'selected' => '']);
    }

    public function actionAssessmentGrid() {

        $reportForm = new formReport();
        if ($reportForm->load(Yii::$app->request->post()) && $reportForm->PupilID) {
            
        } else {
            return $this->render('assessment-grid', ['reportForm' => $reportForm
            ]);
        }
        $pupilid = $reportForm->PupilID;

        $pupil = \frontend\models\Pupils::findOne($pupilid);
        if (!$pupil) {
            \Yii::$app->getSession()->setFlash('error', 'Pupil not found');
            return $this->render('assessment-grid', ['reportForm' => $reportForm
            ]);
        }
//Find the pupil
        //Use dob to populate years to year 11 so dob +5years - but this in the excel function
        //Current date limit
        //For each term populate level
        $data = [];
        /*
         * $data [
         * pupil=>[name]
         * year=>[
         *      term=>[
         *          ['English: Speaking',...
         * ]
         */

        //$yeargroup = \frontend\models\YearGroups::getYearGroup($pupil->DoB);
        $daystoendofEYFS = \frontend\models\YearGroups::find()->where(['YearGroup' => 'Year 1'])->one()->DaysOld - 1;
        $DateAtEndofEYFS = strtotime($pupil->DoB) + ($daystoendofEYFS * 24 * 60 * 60);

        $years = [];
        for ($i = 0; $i <= 15; $i++) {
            $years[] = date('Y', $DateAtEndofEYFS) + $i;
        }
        $assessmentGridData = new assementgrid($years[0], $pupil);
//        echo '<pre>';
//        print_r($assessmentGridData);
//        exit;
//        $terms = [ '-03-10', '-08-19', '-12-30'];
//        $pupilData = [];
//        $excelData = new assementgrid();

        $listOfStrands = ArrayHelper::map($this->GetListOfStrands(), 'ssid', 'ss');
//echo '<pre>';
//        print_r($listOfStrands);
//exit;
//        foreach ($years as $year) {
//            foreach ($terms as $termnumber => $term) {
//                //TODO: Solve for EYFS as they only have 2
//                $reportForm = new formReport();
//                $reportForm->dateFrom = '2000-08-10';
//                $reportForm->dateTo = $year . $term; //'-12-30';
//                $maxlevels = $this->_MaxLevels($reportForm, $pupilid);
//                $connection = Yii::$app->db;
//                //echo $reportForm->dateTo;
//                //echo count($maxlevels)."\n";
//                if (count($maxlevels) == 0 || $maxlevels == NULL) {
//                    //   echo $year.' l '.$termnumber;
//                    $blank = ['StrandText' => '-', 'thelevel' => '-'];
//                    $pupilData[$year][$termnumber]['No Records'][] = $blank;
//                } else {
//                    foreach ($maxlevels as $level) {
//                        $command = $connection->createCommand('CALL GetPupilCurrentLevelDate(:pupilID,:strandid,:levelid, :dateto)');
//                        $command->bindValue(':pupilID', $pupilid);
//                        $command->bindValue(':strandid', $level['id']);
//                        $command->bindValue(':levelid', $level['lid']);
//                        $command->bindValue(':dateto', $reportForm->dateTo);
//                        $levels = $command->queryAll();
//                        // $levels[0]['name'] = $pupil->FullName;
////                        $row=[];
////                        foreach ($listOfStrands as $strandid =>$strand){
////                            $row[$strandid]='';
////                        }
//                        $pupilData [$year][$termnumber][$levels[0]['subjectid'] . ':' . $level['id']] = $levels[0];
//                        //  print_r($levels);
//                    }
//                }
//            }
//        }
//print_r($pupilData);
//exit;
        return $this->AssessmentGridExcel($pupil, $assessmentGridData, $listOfStrands);
    }

    function AssessmentGridExcel($pupil, $data, $listOfStrands) {


        $sheet = 0;
        $inputFileName = Yii::getAlias('@common') . '/templates/AssessmentGridV2.xlsx';


        $objPHPExcel = \PHPExcel_IOFactory::load($inputFileName);

        $StrandStyle = [
            'borders' => [ 'allborders' => [ 'style' => \PHPExcel_Style_Border::BORDER_THIN]],
            'font' => ['bold' => true],
            'fill' => ['type' => \PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => ['rgb' => 'a6a6a6']]
        ];
        $BlueStyle = [
            'light' => [
                'borders' => [ 'allborders' => [ 'style' => \PHPExcel_Style_Border::BORDER_THIN]],
                'font' => ['bold' => false],
                'fill' => ['type' => \PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => ['rgb' => '4bacc6']]],
            'dark' => [ 'borders' => [ 'allborders' => [ 'style' => \PHPExcel_Style_Border::BORDER_THIN]],
                'font' => ['bold' => true],
                'fill' => ['type' => \PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => ['rgb' => '0070c0']]],
        ];
        $OrangeStyle = [
            'light' => [
                'borders' => [ 'allborders' => [ 'style' => \PHPExcel_Style_Border::BORDER_THIN]],
                'font' => ['bold' => false],
                'fill' => ['type' => \PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => ['rgb' => 'fabf8f']]],
            'dark' => [ 'borders' => [ 'allborders' => [ 'style' => \PHPExcel_Style_Border::BORDER_THIN]],
                'font' => ['bold' => true],
                'fill' => ['type' => \PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => ['rgb' => 'b97034']]],
        ];
        $GreenStyle = [
            'light' => [
                'borders' => [ 'allborders' => [ 'style' => \PHPExcel_Style_Border::BORDER_THIN]],
                'font' => ['bold' => false],
                'fill' => ['type' => \PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => ['rgb' => '66e166']]],
            'dark' => [ 'borders' => [ 'allborders' => [ 'style' => \PHPExcel_Style_Border::BORDER_THIN]],
                'font' => ['bold' => true],
                'fill' => ['type' => \PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => ['rgb' => '50b050']]],
        ];
        $YellowStyle = [
            'light' => [
                'borders' => [ 'allborders' => [ 'style' => \PHPExcel_Style_Border::BORDER_THIN]],
                'font' => ['bold' => false],
                'fill' => ['type' => \PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => ['rgb' => 'ffff66']]],
            'dark' => [ 'borders' => [ 'allborders' => [ 'style' => \PHPExcel_Style_Border::BORDER_THIN]],
                'font' => ['bold' => true],
                'fill' => ['type' => \PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => ['rgb' => 'ffff00']]],
        ];

        //Years EYFS to year 11
//write out the stands a4+
        $objPHPExcel->setActiveSheetIndex($sheet);
        $rowstart = 4;
        $row = $rowstart;
        foreach ($listOfStrands as $strand) {
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $row, $strand);
            $row++;
        }
        $endrow = $row - 1;
        $objPHPExcel->getActiveSheet()->getStyle('A' . $rowstart . ':' . 'A' . ($endrow))->applyFromArray($StrandStyle);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->setCellValue('A2', $pupil->FullName);

        $colsInEYFS = 3;
        $colsInYears = 7;
//EYFS
        $row = $rowstart;
        $col = 'B';

        $objPHPExcel = $this->_writeCol($objPHPExcel, $listOfStrands, $data->EYFS->endofEYFS, $col, $rowstart, $data->EYFS->startYearDate);
        $objPHPExcel->getActiveSheet()->getStyle($col . $rowstart . ':' . $col . ($endrow))->applyFromArray($BlueStyle['light']);
        $col++;
        $objPHPExcel = $this->_writeCol($objPHPExcel, $listOfStrands, $data->EYFS->summer2, $col, $rowstart, $data->EYFS->startYearDate);
        $objPHPExcel->getActiveSheet()->getStyle($col . $rowstart . ':' . $col . ($endrow))->applyFromArray($BlueStyle['light']);
        $col++;
        $objPHPExcel = $this->_writeCol($objPHPExcel, $listOfStrands, $data->EYFS->CompletedStatmentsPerSubject, $col, $rowstart, $data->EYFS->startYearDate);
        $objPHPExcel->getActiveSheet()->getStyle($col . $rowstart . ':' . $col . ($endrow))->applyFromArray($BlueStyle['light']);
        $col++;

        //Year 1 E
        $col = self::addLetters($col, 1);
        $objPHPExcel = $this->_writeYear($objPHPExcel, $listOfStrands, $data->Year1, $col, $rowstart, $endrow, $OrangeStyle);

        //year 2 L
        $col = self::addLetters($col, $colsInYears + 1);
        $objPHPExcel = $this->_writeYear($objPHPExcel, $listOfStrands, $data->Year2, $col, $rowstart, $endrow, $GreenStyle);
        //year 3 V
        $col = self::addLetters($col, $colsInYears + 1);
        $objPHPExcel = $this->_writeYear($objPHPExcel, $listOfStrands, $data->Year3, $col, $rowstart, $endrow, $YellowStyle);
        //Year 4 AD
        $col = self::addLetters($col, $colsInYears + 1);
        $objPHPExcel = $this->_writeYear($objPHPExcel, $listOfStrands, $data->Year4, $col, $rowstart, $endrow, $BlueStyle);
        //year 5 AG
        $col = self::addLetters($col, $colsInYears + 1);
        $objPHPExcel = $this->_writeYear($objPHPExcel, $listOfStrands, $data->Year5, $col, $rowstart, $endrow, $OrangeStyle);

        //year 6 AN
        $col = self::addLetters($col, $colsInYears + 1);
        $objPHPExcel = $this->_writeYear($objPHPExcel, $listOfStrands, $data->Year6, $col, $rowstart, $endrow, $GreenStyle);
        //year 7 AU
        $col = self::addLetters($col, $colsInYears + 1);
        $objPHPExcel = $this->_writeYear($objPHPExcel, $listOfStrands, $data->Year7, $col, $rowstart, $endrow, $YellowStyle);
        //Year 8 BB
        $col = self::addLetters($col, $colsInYears + 1);
        $objPHPExcel = $this->_writeYear($objPHPExcel, $listOfStrands, $data->Year8, $col, $rowstart, $endrow, $BlueStyle);
        //year 9 BI
        $col = self::addLetters($col, $colsInYears + 1);
        $objPHPExcel = $this->_writeYear($objPHPExcel, $listOfStrands, $data->Year9, $col, $rowstart, $endrow, $OrangeStyle);
        $col = self::addLetters($col, $colsInYears + 1);
        //year 10 BP
        $objPHPExcel = $this->_writeYear($objPHPExcel, $listOfStrands, $data->Year10, $col, $rowstart, $endrow, $GreenStyle);
        //year 11 BW
        $col = self::addLetters($col, $colsInYears + 1);
        $objPHPExcel = $this->_writeYear($objPHPExcel, $listOfStrands, $data->Year11, $col, $rowstart, $endrow, $YellowStyle);

        //Sheet 2
        $objPHPExcel->setActiveSheetIndex(1);
        $rowstart = 4;
        $row = $rowstart;
        foreach ($listOfStrands as $strand) {
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $row, $strand);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $row, '=UptoYear11!CM' . $row);
            $row++;
        }
        $endrow = $row - 1;
        $objPHPExcel->getActiveSheet()->getStyle('A' . $rowstart . ':' . 'A' . ($endrow))->applyFromArray($StrandStyle);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->setCellValue('A2', $pupil->FullName);

        $row = $rowstart;
        $col = 'B';


        $objPHPExcel->getActiveSheet()->getStyle($col . $rowstart . ':' . $col . ($endrow))->applyFromArray($BlueStyle['light']);
        $col++;



        //Year 12 D
        $col = self::addLetters($col, 1);
        $objPHPExcel = $this->_writeYear($objPHPExcel, $listOfStrands, $data->Year12, $col, $rowstart, $endrow, $OrangeStyle);
        //Year 13
        $col = self::addLetters($col, $colsInYears + 1);
        $objPHPExcel = $this->_writeYear($objPHPExcel, $listOfStrands, $data->Year13, $col, $rowstart, $endrow, $GreenStyle);
        //Year 13
        $col = self::addLetters($col, $colsInYears + 1);
        $objPHPExcel = $this->_writeYear($objPHPExcel, $listOfStrands, $data->Year14, $col, $rowstart, $endrow, $YellowStyle);
//        foreach ($data as $yearvalue => $year) {
//
//            foreach ($year as $term) {
//            
//                //add blanks cols
//                if ($col == 'D' || $col == 'K' || $col == 'K' || $col == 'Y') {
//                    $col++;
//                }
//                //year
//                $row = 3;
//                $objPHPExcel->getActiveSheet()
//                        ->setCellValue($col . $row, $yearvalue);
//                $row++;
//                foreach ($listOfStrands as $subjectStrandIdRow => $strandrow) {
//                    foreach ($term as $subjectStrandId => $strand) {
//
//
//                        // $objPHPExcel->getActiveSheet()->setCellValue($col . $row, $i);
//                        if ($subjectStrandIdRow == $subjectStrandId) {
//                            $objPHPExcel->getActiveSheet()->setCellValue($col . $row, $strand['thelevel']);
//                        }
//                    }
//                    $row++;
//                }
//
//
//                $col++;
//            }
//        }
//exit;


        header('Content-Type: application/vnd.ms-excel');
        $filename = str_replace(' ', '_', $pupil->FullName) . '_' . date("d-m-Y") . ".xls";
        header('Content-Disposition: attachment;filename=' . $filename . ' ');
        header('Cache-Control: max-age=0');

        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }

    public static function addLetters($letter, $lettersToAdd) {
        for ($i = 0; $i < $lettersToAdd; $i++) {
            $letter++;
        }
        return $letter;
    }

    private function _writeYear($objPHPExcel, $listOfStrands, $year, $col, $rowstart, $endrow, $style) {

        $objPHPExcel = $this->_writeCol($objPHPExcel, $listOfStrands, $year->autumn, $col, $rowstart, $year->startYearDate);
        $objPHPExcel->getActiveSheet()->getStyle($col . $rowstart . ':' . $col . ($endrow))->applyFromArray($style['light']);
        $col++;
        $objPHPExcel = $this->_writeCol($objPHPExcel, $listOfStrands, $year->spring, $col, $rowstart, $year->startYearDate + 1);
        $objPHPExcel->getActiveSheet()->getStyle($col . $rowstart . ':' . $col . ($endrow))->applyFromArray($style['light']);
        $col++;
        $objPHPExcel = $this->_writeCol($objPHPExcel, $listOfStrands, $year->summer1, $col, $rowstart, $year->startYearDate + 1);
        $objPHPExcel->getActiveSheet()->getStyle($col . $rowstart . ':' . $col . ($endrow))->applyFromArray($style['light']);
        $col++;
        //Target
        $objPHPExcel = $this->_writeCol($objPHPExcel, $listOfStrands, $year->target, $col, $rowstart, $year->startYearDate + 1);
        $objPHPExcel->getActiveSheet()->getStyle($col . $rowstart . ':' . $col . ($endrow))->applyFromArray($style['dark']);
        $col++;
        //Reviewed Target
        $objPHPExcel = $this->_writeCol($objPHPExcel, $listOfStrands, $year->reviewedTarget, $col, $rowstart, $year->startYearDate + 1);
        $objPHPExcel->getActiveSheet()->getStyle($col . $rowstart . ':' . $col . ($endrow))->applyFromArray($style['dark']);
        $col++;
        $objPHPExcel = $this->_writeCol($objPHPExcel, $listOfStrands, $year->summer2, $col, $rowstart, $year->startYearDate + 1);
        $objPHPExcel->getActiveSheet()->getStyle($col . $rowstart . ':' . $col . ($endrow))->applyFromArray($style['light']);
        $col++;
        $objPHPExcel = $this->_writeCol($objPHPExcel, $listOfStrands, $year->CompletedStatmentsPerSubject, $col, $rowstart, $year->startYearDate + 1);
        $objPHPExcel->getActiveSheet()->getStyle($col . $rowstart . ':' . $col . ($endrow))->applyFromArray($style['light']);

        return $objPHPExcel;
    }

    private function _writeCol($objPHPExcel, $listOfStrands, $term, $col, $row, $date) {
        //Year
        $objPHPExcel->getActiveSheet()->setCellValue($col . ($row - 1), $date);
        if (!is_array($term)) {
            return $objPHPExcel;
        }
        foreach ($listOfStrands as $subjectStrandIdRow => $strandrow) {
            foreach ($term as $subjectStrandId => $strand) {


                // $objPHPExcel->getActiveSheet()->setCellValue($col . $row, $i);
                if ($subjectStrandIdRow == $subjectStrandId) {
                    $value = '';
                    if (is_array($strand)) {
                        $value = $strand['thelevel'];
                    }
//                    elseif(is_array ($strand)){
//                        print_r($strand);
//                        exit;
//                      $value =  (string)$strand[0];
//                    }
                    else {
                        $value = (string) $strand;
                    }

                    $objPHPExcel->getActiveSheet()->setCellValue($col . $row, $value);
                }
            }
            $row++;
        }
        return $objPHPExcel;
    }

}

class assementgrid {

    public $EYFS, $Year1, $Year2, $Year3, $Year4, $Year5, $Year6, $Year7, $Year8, $Year9, $Year10, $Year11, $Year12, $Year13, $Year14;
    public $listOfStrands, $pupil, $targets;

    public function __construct($FirstYear, $pupil) {
        //TODO: Brake after current date
        $this->pupil = $pupil;
        $this->EYFS = new assessmentgridEYFS($FirstYear, $pupil->ID);
        // $FirstYear++;
        $this->Year1 = new assessmentgridYearData($FirstYear, $pupil->ID);
        $FirstYear++;
        $this->Year2 = new assessmentgridYearData($FirstYear, $pupil->ID);
        $FirstYear++;
        $this->Year3 = new assessmentgridYearData($FirstYear, $pupil->ID);
        $FirstYear++;
        $this->Year4 = new assessmentgridYearData($FirstYear, $pupil->ID);
        $FirstYear++;
        $this->Year5 = new assessmentgridYearData($FirstYear, $pupil->ID);
        $FirstYear++;
        $this->Year6 = new assessmentgridYearData($FirstYear, $pupil->ID);
        $FirstYear++;
        $this->Year7 = new assessmentgridYearData($FirstYear, $pupil->ID);
        $FirstYear++;
        $this->Year8 = new assessmentgridYearData($FirstYear, $pupil->ID);
        $FirstYear++;
        $this->Year9 = new assessmentgridYearData($FirstYear, $pupil->ID);
        $FirstYear++;
        $this->Year10 = new assessmentgridYearData($FirstYear, $pupil->ID);
        $FirstYear++;
        $this->Year11 = new assessmentgridYearData($FirstYear, $pupil->ID);
        $FirstYear++;
        $this->Year12 = new assessmentgridYearData($FirstYear, $pupil->ID);
        $FirstYear++;
        $this->Year13 = new assessmentgridYearData($FirstYear, $pupil->ID);
        $FirstYear++;
        $this->Year14 = new assessmentgridYearData($FirstYear, $pupil->ID);
        $this->targets = $this->targets();
    }

    function targets() {
        $query = new \yii\db\Query;
// compose the query
        $dataOut = [];
        $query->select('*')
                ->from('Targets')
                ->innerJoin('SubjectAreas', 'SubjectAreas.AreaID = Targets.StrandID')
                //->innerJoin('LevelText','LevelText.ID= Targets')
                ->where(['pupilid' => $this->pupil->ID]);
//                ->andwhere(['<=', 'ConsolidatedDate', $this->yearDate . self::Summer2TermEnd])
//                ->groupBy('subjectid, strandid');

        $rows = $query->all();
        $listofLevels = ArrayHelper::map(\frontend\models\LevelsText::find()->all(), 'ID', 'LevelText');
        $listofLevels[null] = '';
//          echo '<pre>';
//        print_r($listofLevels);
//        exit;
        foreach ($rows as $row) {
            $this->Year1->target[$row['SubjectID'] . ':' . $row['StrandID']] = $listofLevels[$row['year1Target']];
            $this->Year1->reviewedTarget[$row['SubjectID'] . ':' . $row['StrandID']] = $listofLevels[$row['year1ReviewedTarget']];

            $this->Year2->target[$row['SubjectID'] . ':' . $row['StrandID']] = $listofLevels[$row['year2Target']];
            $this->Year2->reviewedTarget[$row['SubjectID'] . ':' . $row['StrandID']] = $listofLevels[$row['year2ReviewedTarget']];

            $this->Year3->target[$row['SubjectID'] . ':' . $row['StrandID']] = $listofLevels[$row['year3Target']];
            $this->Year3->reviewedTarget[$row['SubjectID'] . ':' . $row['StrandID']] = $listofLevels[$row['year3ReviewedTarget']];

            $this->Year4->target[$row['SubjectID'] . ':' . $row['StrandID']] = $listofLevels[$row['year4Target']];
            $this->Year4->reviewedTarget[$row['SubjectID'] . ':' . $row['StrandID']] = $listofLevels[$row['year4ReviewedTarget']];

            $this->Year5->target[$row['SubjectID'] . ':' . $row['StrandID']] = $listofLevels[$row['year5Target']];
            $this->Year5->reviewedTarget[$row['SubjectID'] . ':' . $row['StrandID']] = $listofLevels[$row['year5ReviewedTarget']];

            $this->Year6->target[$row['SubjectID'] . ':' . $row['StrandID']] = $listofLevels[$row['year6Target']];
            $this->Year6->reviewedTarget[$row['SubjectID'] . ':' . $row['StrandID']] = $listofLevels[$row['year6ReviewedTarget']];

            $this->Year7->target[$row['SubjectID'] . ':' . $row['StrandID']] = $listofLevels[$row['year7Target']];
            $this->Year7->reviewedTarget[$row['SubjectID'] . ':' . $row['StrandID']] = $listofLevels[$row['year7ReviewedTarget']];

            $this->Year8->target[$row['SubjectID'] . ':' . $row['StrandID']] = $listofLevels[$row['year8Target']];
            $this->Year8->reviewedTarget[$row['SubjectID'] . ':' . $row['StrandID']] = $listofLevels[$row['year8ReviewedTarget']];

            $this->Year9->target[$row['SubjectID'] . ':' . $row['StrandID']] = $listofLevels[$row['year9Target']];
            $this->Year9->reviewedTarget[$row['SubjectID'] . ':' . $row['StrandID']] = $listofLevels[$row['year9ReviewedTarget']];

            $this->Year10->target[$row['SubjectID'] . ':' . $row['StrandID']] = $listofLevels[$row['year10Target']];
            $this->Year10->reviewedTarget[$row['SubjectID'] . ':' . $row['StrandID']] = $listofLevels[$row['year10ReviewedTarget']];

            $this->Year11->target[$row['SubjectID'] . ':' . $row['StrandID']] = $listofLevels[$row['year11Target']];
            $this->Year11->reviewedTarget[$row['SubjectID'] . ':' . $row['StrandID']] = $listofLevels[$row['year11ReviewedTarget']];

            $this->Year12->target[$row['SubjectID'] . ':' . $row['StrandID']] = $listofLevels[$row['year12Target']];
            $this->Year12->reviewedTarget[$row['SubjectID'] . ':' . $row['StrandID']] = $listofLevels[$row['year12ReviewedTarget']];

            $this->Year13->target[$row['SubjectID'] . ':' . $row['StrandID']] = $listofLevels[$row['year13Target']];
            $this->Year13->reviewedTarget[$row['SubjectID'] . ':' . $row['StrandID']] = $listofLevels[$row['year13ReviewedTarget']];

            $this->Year14->target[$row['SubjectID'] . ':' . $row['StrandID']] = $listofLevels[$row['year14Target']];
            $this->Year14->reviewedTarget[$row['SubjectID'] . ':' . $row['StrandID']] = $listofLevels[$row['year14ReviewedTarget']];
            //  $dataOut[$row['SubjectID'] . ':' . $row['StrandID']] = $row;
        }
        return $dataOut;
    }

}

class assessmentgridYearData {

    public $startYearDate, $autumn, $spring, $summer1, $summer2, $target, $reviewedTarget;
    public $pupilID, $CompletedStatmentsPerSubject;
    private $yearDate;

    const SpringTermEnd = '-03-10';
    const Summer1TermEnd = '-06-19';
    const Summer2TermEnd = '-08-18';
    const AutumnTermEnd = '-12-30';

    function __construct($year, $pupilid) {
        $this->yearDate = $year;
        $this->startYearDate = $year;
        $this->pupilID = $pupilid;

        $this->autumn = $this->popOneData(self::AutumnTermEnd);
        $this->yearDate ++;
        $this->spring = $this->popOneData(self::SpringTermEnd);
        $this->summer1 = $this->popOneData(self::Summer1TermEnd);
        $this->summer2 = $this->popOneData(self::Summer2TermEnd);
        $this->popCompletedStatments();
    }

    function popCompletedStatments() {
        if (date('Y', time()) < $this->yearDate) {
            return;
        }
        $dataOut = [];
        $query = new \yii\db\Query;
// compose the query
        $query->select('count( PupilStatements.id ) as statementcount, strandid, subjectid')
                ->from('PupilStatements')
                ->innerJoin('Statements', 'Statements.id = PupilStatements.StatementID')
                //->innerJoin('Strands', 'Strands.ID = PupilStatements.StrandID')
                ->innerJoin('SubjectAreas', 'SubjectAreas.AreaID = Statements.StrandID')
                ->innerJoin('Subjects', 'Subjects.ID=SubjectAreas.SubjectID')
                ->where(['pupilid' => $this->pupilID])
                ->andwhere(['<=', 'ConsolidatedDate', $this->yearDate . self::Summer2TermEnd])
                ->groupBy('subjectid, strandid');

        $rows = $query->all();
        foreach ($rows as $row) {
            $dataOut[$row['subjectid'] . ':' . $row['strandid']] = $row['statementcount'];
        }
        $this->CompletedStatmentsPerSubject = $dataOut;
        return true;
//        print_r($dataOut);
//        exit;
//        //find all completed statments within acedemic year - link with subject ->where(['pupilid' => $this->pupilID])
//        $s = \frontend\models\PupilStatements::find()->joinWith('statement.strands.subject')->andWhere(['<=', 'ConsolidatedDate', $this->yearDate . self::Summer2TermEnd])->asArray()->all();
//        print_r($s);
//        exit;
//        $dataOut[$levels[0]['subjectid'] . ':' . $level['id']] = $levels[0];
    }

    function popOneData($termdate) {
        if (time() < strtotime($this->yearDate . $termdate)) {
            return;
        }
        //TODO: Solve for EYFS as they only have 2
        $reportForm = new formReport();
        $reportForm->dateFrom = '1970-08-10';
        $reportForm->dateTo = $this->yearDate . $termdate; //'-12-30';
        $maxlevels = ReportController::_MaxLevels($reportForm, $this->pupilID);
        $connection = Yii::$app->db;

        $dataOut = [];
        if (count($maxlevels) == 0 || $maxlevels == NULL) {
            //   echo $year.' l '.$termnumber;
            $blank = ['StrandText' => '-', 'thelevel' => '-'];
            $dataOut['No Records'][] = $blank;
        } else {

            foreach ($maxlevels as $level) {
//                $command = $connection->createCommand('CALL GetPupilCurrentLevelDate(:pupilID,:strandid,:levelid, :dateto)');
//                $command->bindValue(':pupilID', $this->pupilID);
//                $command->bindValue(':strandid', $level['id']);
//                $command->bindValue(':levelid', $level['lid']);
//                $command->bindValue(':dateto', $reportForm->dateTo);
//                $levels = $command->queryAll();
                $levels = ReportController::GetPupilCurrentLevel($this->pupilID, $level['id'], $level['lid'], $level['SubjectID'], $reportForm->dateTo);
                $dataOut[$levels[0]['subjectid'] . ':' . $level['id']] = $levels[0];
//                $this->CompletedStatmentsPerSubject[$levels[0]['subjectid'] . ':' . $level['id']] = 
//                        $levels[0]['statmentcount'];
            }
        }
        return $dataOut;
    }

}

class assessmentgridEYFS {

    public $startYearDate, $endofEYFS, $summer2, $pupilid, $CompletedStatmentsPerSubject;
    private $yearDate;

    function __construct($year, $pupilid) {
        $this->yearDate = $year;
        $this->startYearDate = $year;
        $this->pupilid = $pupilid;

        $this->endofEYFS = $this->popOneData(assessmentgridYearData::Summer1TermEnd);
        $this->summer2 = $this->popOneData(assessmentgridYearData::Summer2TermEnd);
        $this->popCompletedStatments();
    }

    function popCompletedStatments() {
        if (date('Y', time()) <= $this->yearDate) {
            return;
        }
        $dataOut = [];
        $query = new \yii\db\Query;
// compose the query
        $query->select('count( PupilStatements.id ) as statementcount, strandid, subjectid')
                ->from('PupilStatements')
                ->innerJoin('Statements', 'Statements.id = PupilStatements.StatementID')
                //->innerJoin('Strands', 'Strands.ID = PupilStatements.StrandID')
                ->innerJoin('SubjectAreas', 'SubjectAreas.AreaID = Statements.StrandID')
                ->innerJoin('Subjects', 'Subjects.ID=SubjectAreas.SubjectID')
                ->where(['pupilid' => $this->pupilid])
                ->andwhere(['<=', 'ConsolidatedDate', $this->yearDate . assessmentgridYearData::Summer2TermEnd])
                ->groupBy('subjectid, strandid');

        $rows = $query->all();
        foreach ($rows as $row) {
            $dataOut[$row['subjectid'] . ':' . $row['strandid']] = $row['statementcount'];
        }
        $this->CompletedStatmentsPerSubject = $dataOut;
        return true;
//        print_r($dataOut);
//        exit;
//        //find all completed statments within acedemic year - link with subject ->where(['pupilid' => $this->pupilID])
//        $s = \frontend\models\PupilStatements::find()->joinWith('statement.strands.subject')->andWhere(['<=', 'ConsolidatedDate', $this->yearDate . self::Summer2TermEnd])->asArray()->all();
//        print_r($s);
//        exit;
//        $dataOut[$levels[0]['subjectid'] . ':' . $level['id']] = $levels[0];
    }

    function popOneData($termdate) {
        if (time() < strtotime($this->yearDate . $termdate)) {
            return;
        }

        $reportForm = new formReport();
        $reportForm->dateFrom = '1970-08-10';
        $reportForm->dateTo = $this->yearDate . $termdate; //'-12-30';
        $maxlevels = ReportController::_MaxLevels($reportForm, $this->pupilid);
        //  $connection = Yii::$app->db;
        //echo $reportForm->dateTo;
        //echo count($maxlevels)."\n";
        $dataOut = [];
        if (count($maxlevels) == 0 || $maxlevels == NULL) {
            //   echo $year.' l '.$termnumber;
            $blank = ['StrandText' => '-', 'thelevel' => '-'];
            $dataOut['No Records'][] = $blank;
        } else {

            foreach ($maxlevels as $level) {
//                $command = $connection->createCommand('CALL GetPupilCurrentLevelDate(:pupilID,:strandid,:levelid, :dateto)');
//                $command->bindValue(':pupilID', $this->pupilid);
//                $command->bindValue(':strandid', $level['id']);
//                $command->bindValue(':levelid', $level['lid']);
//                $command->bindValue(':dateto', $reportForm->dateTo);
//                $levels = $command->queryAll();
                $levels = ReportController::GetPupilCurrentLevel($this->pupilid, $level['id'], $level['lid'], $level['SubjectID'], $reportForm->dateTo);
                $dataOut[$levels[0]['subjectid'] . ':' . $level['id']] = $levels[0];
                $this->CompletedStatmentsPerSubject[$levels[0]['subjectid'] . ':' . $level['id']] = isset($this->CompletedStatmentsPerSubject[$levels[0]['subjectid'] . ':' . $level['id']]) ?
                        $levels[0]['statmentcount'] + $this->CompletedStatmentsPerSubject[$levels[0]['subjectid'] . ':' . $level['id']] : $levels[0]['statmentcount'];
            }
        }
        return $dataOut;
    }

}
