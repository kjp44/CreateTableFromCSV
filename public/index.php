<?php
/**
 * Created by PhpStorm.
 * User: Kyle Payne
 * Date: 9/26/18
 * Time: 6:42 PM
 */
main::start('example.csv');

class main {
    static public function start($fileName) {
        $rawData = csv::readCSV($fileName);
        $properties = csv::getProperties($rawData);
        $records = csv::getRecords($rawData);
        $recordsAsObjects = (csv::convertRecordsToObjects($properties, $records));
        $tableHTML = html::createTable($properties, $recordsAsObjects);
        system::printPage($tableHTML);
    }
}

class csv {
    public static function readCSV($fileName)
    {
        $rawRecords = array();
        $file = fopen($fileName, "r");
        while (!feof($file)) {
            $rawRecords[] = fgetcsv($file);
        }
        fclose($file);
        return($rawRecords);
    }
    public static function getProperties($rawData){
        $properties = $rawData[0];
        return $properties;
    }
    public static function getRecords($rawData){
        $records = array();
        for($i = 1; $i < count($rawData); $i++){
            $records[] = $rawData[$i];
        }
        return $records;
    }
    public static function convertRecordsToObjects($properties, $rawRecords){
        $records = array();
        foreach($rawRecords as $rawRecord) {
            $records[] = recordFactory::create($properties, $rawRecord);
        }
        return $records;
    }
}

class recordFactory
{
    public static function create($properties, $rawRecord)
    {

        return new record($properties, $rawRecord);
    }
}

class record
{

    public function __construct($properties, $rawRecord)
    {
        for($i = 0; $i<count($properties); $i++) {
            $this->{$properties[$i]} = $rawRecord[$i];
        }
    }
}

class html {
    static public function createTable($properties, $recordsAsObjects) {
        array_unshift($recordsAsObjects, $properties);
        $count = 0;
        $html = '<table class="table table-striped">';
        foreach($recordsAsObjects as $recordAsObject){
            $dataHolder = '';
            if($count == 0){
                foreach($recordAsObject as $data){
                    $dataHolder .= html::createTableHeader($data);
                }
                $count++;
            }
            else{
                foreach($recordAsObject as $data){
                    $dataHolder .= html::createTableData($data);
                }
            }
            $html .= html::createTableRow($dataHolder);
        }
        $html .= '</table>';
        return $html;
    }
    static public function createTableHeader($header){
        $html = '<th scope="col">';
        $html .= $header;
        $html .= "</th>";
        return $html;
    }
    static public function createTableData($data) {
        $html = '<td>';
        $html .= $data;
        $html .= '</td>';
        return $html;
    }
    static public function createTableRow($row) {
            $html = '<tr>';
            $html .= $row;
            $html .= '</tr>';
        return $html;
    }
}

class system {
    public static function printPage($tableHTML) {
        $pageHTML = '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">';
        $pageHTML .= '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">';
        $pageHTML .= '<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>';
        $pageHTML .= $tableHTML;
        echo $pageHTML;
    }
}