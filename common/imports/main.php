<?php

namespace common\imports;

use PDO;

/**
 * Description of main
 *
 * @author Thomas
 */
class main {

    public function dbimport() {


        $mdb_file = '/var/www/spat/common/imports/Campaign_Template.mdb';
        $query = 'SELECT * FROM MyTable';

        $uname = explode(" ", php_uname());
        $os = $uname[0];
        switch ($os) {
            case 'Windows':
                $driver = '{Microsoft Access Driver (*.mdb)}';
                break;
            case 'Linux':
                $driver = 'MDBTools';
                break;
            default:
                exit("Don't know about this OS");
        }
        $dataSourceName = "odbc:Driver=MDBTools;DBQ=$mdb_file;";

        $connection = new \PDO($dataSourceName);

        $result = $connection->query($query)->fetchAll(\PDO::FETCH_ASSOC);
        print_r($result);



        $driver = 'MDBTools';


        $dataSourceName = "odbc:Driver={Microsoft Access Driver (*.mdb)};DBQ=$mdb_file;";
        $connection = new \PDO($dataSourceName);
        $result = $connection->query($query)->fetchAll(\PDO::FETCH_ASSOC);
        print_r($result);

        $connStr = 'odbc:Driver={Microsoft Access Driver (*.mdb, *.accdb)};' .
                'Dbq=C:\\Users\\Gord\\Desktop\\foo.accdb;';

        $dbh = new PDO($connStr);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $dbName = __DIR__ . "/SWSAssessmentTracker.accdb";
        echo $dbName . "<br />";

        if (!file_exists($dbName)) {
            die("Could not find database file.<br />" . $dbName);
        }
        try {
            $db = new PDO("odbc:DRIVER={Microsoft Access Driver (*.mdb)}; DBQ=$dbName; Uid=; Pwd=;");
//            $db = new PDO("odbc:DRIVER={Microsoft Access Driver (*.mdb)};Dbq=$dbName");
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage() . "<br />";
        }
    }

    public function parse($fileloc, $fieldArray) {



        $file = fopen($fileloc, 'r');

        while ($line = fgets($file)) {
            list($fieldArray) = explode(',', str_replace('"', '', $line));

            // do stuff with variables 
        }
    }

    public function doImport() {
        //flatten db
        //import
        ini_set('max_execution_time', 300);


        \frontend\models\Classes::deleteAll();
        $r = $this->runClasses();
        if ($r === false) {
            echo'Problem importing Classes';
            exit;
        }
        \frontend\models\Keystages::deleteAll();
        $r = $this->runKeyStages();
        if ($r === false) {
            echo'Problem importing Key Stages';
            exit;
        }
        \frontend\models\KeyStageYearGroups::deleteAll();
        $r = $this->runKeyStageYearGroups();
        if ($r === false) {
            echo'Problem importing Key Stage Year Groups';
            exit;
        }
        \frontend\models\Levels::deleteAll();
        $r = $this->runLevels();
        if ($r === false) {
            echo'Problem importing Levels';
            exit;
        }
        \frontend\models\LevelsText::deleteAll();
        $r = $this->runLevelsText();
        if ($r === false) {
            echo'Problem importing LevelText';
            exit;
        }
        \frontend\models\Pupils::deleteAll();
        $r = $this->runPupils();
        if ($r === false) {
            echo'Problem importing Pupils';
            exit;
        }
        \frontend\models\PupilStartingLevel::deleteAll();
        $r = $this->runPupilStartingLevel();
        if ($r === false) {
            echo'Problem importing PupilStartingLevel';
            exit;
        }
        \frontend\models\PupilStatements::deleteAll();
        $r = $this->runPupilStatement();
        if ($r === false) {
            echo'Problem importing PupilStatement';
            exit;
        }
        \frontend\models\Statements::deleteAll();
        $r = $this->runStatements();
        if ($r === false) {
            echo'Problem importing Statements';
            exit;
        }
        \frontend\models\Strands::deleteAll();
        $r = $this->runStrands();
        if ($r === false) {
            echo'Problem importing Strands';
            exit;
        }
        \frontend\models\SubjectAreas::deleteAll();
        $r = $this->runSubjectAreas();
        if ($r === false) {
            echo'Problem importing SubjectAreas';
            exit;
        }

        \frontend\models\Subjects::deleteAll();
        $r = $this->runSubjects();
        if ($r === false) {
            echo'Problem importing Subjects';
            exit;
        }
        return true;
    }

    public function runClasses() {

        $fileloc = __DIR__ . "/files/Classes.txt";

        $file = fopen($fileloc, 'r');
        $data = [];
        $i = 0;
        while ($line = fgetcsv($file)) {
            list($classid, $classname) = $line;
            $data[] = [$classid, $classname,
            ];
            $i++;
        }
        fclose($file);
        $r = \Yii::$app->db->createCommand()->batchInsert(\frontend\models\Classes::tableName(), ['ID', 'ClassName'], $data
                )->execute();
        if ($r == $i) {
            return true;
        }
        return false;
    }

    public function runKeyStages() {

        $fileloc = __DIR__ . "/files/Keystages.txt";

        $file = fopen($fileloc, 'r');
        $data = [];
        $i = 0;
        while ($line = fgetcsv($file)) {
            list($ID, $KeyStage) = $line;
            $data[] = [$ID, $KeyStage];
            $i++;
        }
        fclose($file);
        $r = \Yii::$app->db->createCommand()->batchInsert(\frontend\models\Keystages::tableName(), ['ID', 'KeyStage'], $data
                )->execute();
        if ($r == $i) {
            return true;
        }
        return false;
    }

    public function runKeyStageYearGroups() {

        $fileloc = __DIR__ . "/files/KeyStageYearGroups.txt";

        $file = fopen($fileloc, 'r');
        $data = [];
        $i = 0;
        while ($line = fgetcsv($file)) {
            list($KeystageID, $YearGroupID) = $line;
            $data[] = [$KeystageID, $YearGroupID];
            $i++;
        }
        fclose($file);
        $r = \Yii::$app->db->createCommand()->batchInsert(\frontend\models\KeyStageYearGroups::tableName(), ['KeystageID', 'YearGroupID'], $data
                )->execute();
        if ($r == $i) {
            return true;
        }
        return false;
    }

    public function runLevels() {

        $fileloc = __DIR__ . "/files/Levels.txt";

        $file = fopen($fileloc, 'r');
        $data = [];
        $i = 0;
        while ($line = fgetcsv($file)) {
            list($ID, $LevelText) = $line;
            $data[] = [$ID, $LevelText];
            $i++;
        }
        fclose($file);
        $r = \Yii::$app->db->createCommand()->batchInsert(\frontend\models\Levels::tableName(), ['ID', 'LevelText'], $data
                )->execute();
        if ($r == $i) {
            return true;
        }
        return false;
    }

    public function runLevelsText() {

        $fileloc = __DIR__ . "/files/LevelText.txt";

        $file = fopen($fileloc, 'r');
        $data = [];
        $i = 0;
        while ($line = fgetcsv($file)) {
            list($ID, $LevelID, $LevelPercentage, $LevelValue, $LevelText) = $line;
            $data[] = [$ID, $LevelID, $LevelPercentage, $LevelValue, $LevelText];
            $i++;
        }
        fclose($file);
        $r = \Yii::$app->db->createCommand()->batchInsert(\frontend\models\LevelsText::tableName(), ['ID', 'LevelID', 'LevelPercentage', 'LevelValue', 'LevelText'], $data
                )->execute();
        if ($r == $i) {
            return true;
        }
        return false;
    }

    public function runPupils() {

        $fileloc = __DIR__ . "/files/Pupils.txt";

        $file = fopen($fileloc, 'r');
        $data = [];
        $i = 0;
        while ($line = fgetcsv($file)) {
            list($ID, $FirstName, $LastName, $ClassID, $DoB) = $line;
            $data[] = [$ID, $FirstName, $LastName, $ClassID, 
                  ($DoB ? \Yii::$app->formatter->asDatetime(strtotime(str_replace('/', '-', $DoB)), "php:Y-m-d") : NULL)
                ];
            $i++;
        }
        fclose($file);
        $r = \Yii::$app->db->createCommand()->batchInsert(\frontend\models\Pupils::tableName(), ['ID', 'FirstName', 'LastName', 'ClassID', 'DoB'], $data
                )->execute();
        if ($r == $i) {
            return true;
        }
        return false;
    }

    public function runPupilStartingLevel() {

        $fileloc = __DIR__ . "/files/PupilStartingLevel.txt";

        $file = fopen($fileloc, 'r');
        $data = [];
        $i = 0;
        while ($line = fgetcsv($file)) {
            list($PupilID, $StrandID, $StartingLevel) = $line;
            $data[] = [$PupilID, $StrandID, $StartingLevel];
            $i++;
        }
        fclose($file);
        $r = \Yii::$app->db->createCommand()->batchInsert(\frontend\models\PupilStartingLevel::tableName(), ['PupilID', 'StrandID', 'StartingLevel'], $data
                )->execute();
        if ($r == $i) {
            return true;
        }
        return false;
    }

    public function runPupilStatement() {

        $fileloc = __DIR__ . "/files/PupilStatements.txt";

        $file = fopen($fileloc, 'r');
        // $connection = \Yii::$app->db;
        //$transaction = $connection->beginTransaction();
        $data = [];
        $i = 0;
        $o = 0;
        $result = 0;
        while ($line = fgetcsv($file)) {
            list($pupilid, $statmentid, $partiallydate, $achiieveddate, $consolidateddate) = $line;
            $data[] = [$pupilid, $statmentid,
                ($partiallydate ? \Yii::$app->formatter->asDatetime(strtotime(str_replace('/', '-', $partiallydate)), "php:Y-m-d") : NULL),
                ($achiieveddate ? \Yii::$app->formatter->asDatetime(strtotime(str_replace('/', '-', $achiieveddate)), "php:Y-m-d") : NULL),
                ($consolidateddate ? \Yii::$app->formatter->asDatetime(strtotime(str_replace('/', '-', $consolidateddate)), "php:Y-m-d") : NULL)];
            $o++;
            $i++;
            if ($o > 10000) {
                $r = \Yii::$app->db->createCommand()->batchInsert(\frontend\models\PupilStatements::tableName(), ['PupilID', 'StatementID', 'PartiallyDate', 'AchievedDate', 'ConsolidatedDate'], $data
                        )->execute();
                $result+=$r;
                $data = [];
                $o = 0;
            }
        }
        fclose($file);
        $r = \Yii::$app->db->createCommand()->batchInsert(\frontend\models\PupilStatements::tableName(), ['PupilID', 'StatementID', 'PartiallyDate', 'AchievedDate', 'ConsolidatedDate'], $data
                )->execute();
        $result+=$r;
        if ($result == $i) {
            return true;
        }
        return false;
    }

    public function runStatements() {

        $fileloc = __DIR__ . "/files/Statements.txt";

        $file = fopen($fileloc, 'r');
        $data = [];
        $i = 0;
        while ($line = fgetcsv($file)) {
            list($ID, $StatementText, $StrandID, $LevelID) = $line;
            $data[] = [$ID, trim($StatementText), $StrandID, $LevelID];
            $i++;
        }
        fclose($file);

        $r = \Yii::$app->db->createCommand()->batchInsert(\frontend\models\Statements::tableName(), ['ID', 'StatementText', 'StrandID', 'LevelID'], $data
                )->execute();
        if ($r == $i) {
            return true;
        }
        return false;
    }

    public function runStrands() {

        $fileloc = __DIR__ . "/files/Strands.txt";

        $file = fopen($fileloc, 'r');
        $data = [];
        $i = 0;
        while ($line = fgetcsv($file)) {
            list($ID, $StrandText) = $line;
            $data[] = [$ID, $StrandText];
            $i ++;
        }
        fclose($file);

        $r = \Yii::$app->db->createCommand()->batchInsert(\frontend\models\Strands::tableName(), ['ID', 'StrandText'], $data
                )->execute();
        if ($r == $i) {
            return true;
        }
        return false;
    }

    public function runSubjectAreas() {

        $fileloc = __DIR__ . "/files/SubjectAreas.txt";

        $file = fopen($fileloc, 'r');
        $data = [];
        $i = 0;
        while ($line = fgetcsv($file)) {
            list($SubjectID, $AreaID) = $line;
            $data[] = [$SubjectID, $AreaID];
            $i++;
        }
        fclose($file);

        $r = \Yii::$app->db->createCommand()->batchInsert(\frontend\models\SubjectAreas::tableName(), ['SubjectID', 'AreaID'], $data
                )->execute();
        if ($r == $i) {
            return true;
        }
        return false;
    }

    public function runSubjects() {

        $fileloc = __DIR__ . "/files/Subjects.txt";

        $file = fopen($fileloc, 'r');
        $data = [];
        $i = 0;
        while ($line = fgetcsv($file)) {
            list($ID, $Subject) = $line;
            $data[] = [$ID, $Subject];
            $i++;
        }

        $r = \Yii::$app->db->createCommand()->batchInsert(\frontend\models\Subjects::tableName(), ['ID', 'Subject'], $data
                )->execute();
        if ($r == $i) {
            return true;
        }
        return false;
    }

}
