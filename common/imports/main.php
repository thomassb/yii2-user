<?php

namespace common\imports;

/**
 * Description of main
 *
 * @author Thomas
 */
class main {

    public function parse($fileloc, $fieldArray) {



        $file = fopen($fileloc, 'r');

        while ($line = fgets($file)) {
            list($fieldArray) = explode(',', str_replace('"', '', $line));

            // do stuff with variables 
        }
    }

    public function runPupilStatment() {

        $fileloc = __DIR__ . "/PupilStatements.txt";

        $file = fopen($fileloc, 'r');
        // $connection = \Yii::$app->db;
        //$transaction = $connection->beginTransaction();
        $data = [];

        while ($line = fgets($file)) {
            list($pupilid, $statmentid, $partiallydate, $achiieveddate, $consolidateddate) = explode(',', trim(str_replace('"', '', $line)));
            $data[] = [$pupilid, $statmentid,
                ($partiallydate ? \Yii::$app->formatter->asDatetime(strtotime(str_replace('/', '-', $partiallydate)), "php:Y-m-d") : NULL),
                ($achiieveddate ? \Yii::$app->formatter->asDatetime(strtotime(str_replace('/', '-', $achiieveddate)), "php:Y-m-d") : NULL),
                ($consolidateddate ? \Yii::$app->formatter->asDatetime(strtotime(str_replace('/', '-', $consolidateddate)), "php:Y-m-d") : NULL)];
//            $_ps = new \frontend\models\PupilStatements();
//           // var_dump( $consolidateddate);
//            $_ps->PupilID = $pupilid;
//            $_ps->StatementID = $statmentid;
//            $_ps->PartiallyDate = ($partiallydate?\Yii::$app->formatter->asDatetime(strtotime(str_replace('/', '-',$partiallydate)), "php:Y-m-d"):NULL);
//            $_ps->AchievedDate = ($achiieveddate?\Yii::$app->formatter->asDatetime(strtotime(str_replace('/', '-',$achiieveddate)), "php:Y-m-d"):NULL);
//            $_ps->ConsolidatedDate = ($consolidateddate?\Yii::$app->formatter->asDatetime(strtotime(str_replace('/', '-',$consolidateddate)), "php:Y-m-d"):NULL);
//           // var_dump($_ps);
//           
////            if($_ps->save())
////            {echo 'saved';}
////            else{
////                //yii\helpers\VarDumper::dumpAsString($var, $depth, $highlight);
////                var_dump( $_ps->errors);
////                }
//            
//            $_ps=null;
            // exit;
            // do stuff with variables 
        }
        // $transaction->commit();
        \Yii::$app->db->createCommand()->batchInsert(\frontend\models\PupilStatements::tableName(), ['PupilID', 'StatementID', 'PartiallyDate', 'AchievedDate', 'ConsolidatedDate'], $data
        )->execute();
    }

}
