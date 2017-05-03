<?php

$pupils = range(1, 100);
$statements = range(1, 2500);
$break = 20000000;
$i = 0;
$fileloc = __DIR__ . "/PupilStatements.txt";

$file = fopen($fileloc, 'w');
foreach ($pupils as $pupil) {
    $pupildata='';
    foreach($statements as $statement){
        $pupildata.= "{$pupil},{$statement},18/09/2015 00:00:00,01/10/2015 00:00:00,20/10/2015 00:00:00\r\n";
        $i++;
    }
    fwrite($file, $pupildata);
    if ($i > $break) {
        break;
    }
}
fclose($file);
