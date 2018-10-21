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
        $recordsAsObjects = csv::createRecordsAsObjects($fileName);
        $tableHTML = html::createBootstrapTable($recordsAsObjects);
        system::printPage($tableHTML);
    }
}

class csv {
    public static function createRecordsAsObjects($fileName){
        $rawRecords = csv::readCSV($fileName);
        $records = array($rawRecords[0]);
        for($i = 1; $i < count($rawRecords); $i++) {
            $records[] = recordFactory::create($records[0], $rawRecords[$i]);
        }
        return $records;
    }
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
    static public function createBootstrapTable($recordsAsObjects){
        $html = html::addBootstrap();
        $html .= html::createTable($recordsAsObjects);
        return $html;
    }
    static public function createTable($recordsAsObjects){
        $table = html::createTableHead($recordsAsObjects[0]);
        $table .= html::createTableBody($recordsAsObjects);
        $table = html::addTableTag($table);
        return $table;
    }
    static public function createTableHead($properties){
        $tableHeadRow = html::createTableHeadRow($properties);
        $tableHead = html::addTHeadTag($tableHeadRow);
        return $tableHead;
    }
    static public function createTableHeadRow($properties){
        $row = html::addTHTagsToRow($properties);
        $tableHeadRow = html::addTRTag($row);
        return $tableHeadRow;
    }
    static public function addTHTagsToRow($row){
        $html = '';
        foreach($row as $data){
            $html .= html::addTHTag($data);
        }
        return $html;
    }
    static public function createTableBody($recordsAsObjects){
        $tableBodyRows = html::createTableBodyRows($recordsAsObjects);
        $tableBody = html::addTBodyTag($tableBodyRows);
        return $tableBody;
    }
    static public function createTableBodyRows($recordsAsObjects){
        $tableBodyRows = '';
        for($i = 1;$i < count($recordsAsObjects); $i++){
            $row = html::addTDTagsToRow($recordsAsObjects[$i]);
            $tableBodyRows .= html::addTRTag($row);
        }
        return $tableBodyRows;
    }
    static public function addTDTagsToRow($row){
        $html = '';
        foreach($row as $data){
            $html .= html::addTDTag($data);
        }
        return $html;
    }
    static public function addTableTag($data){
        $html = '<table class="table table-striped">';
        $html .= $data;
        $html .= '</table>';
        return $html;
    }
    static public function addTHeadTag($data){
        $html = $html = '<thead>';
        $html .= $data;
        $html .= '</thead>';
        return $html;
    }
    static public function addTBodyTag($data){
        $html = $html = '<tbody>';
        $html .= $data;
        $html .= '</tbody>';
        return $html;
    }
    static public function addTRTag($row) {
        $html = '<tr>';
        $html .= $row;
        $html .= '</tr>';
        return $html;
    }
    static public function addTHTag($header){
        $html = '<th>';
        $html .= $header;
        $html .= "</th>";
        return $html;
    }
    static public function addTDTag($data) {
        $html = '<td>';
        $html .= $data;
        $html .= '</td>';
        return $html;
    }
    static public function addBootstrap(){
        $html = '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">';
        $html .= '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">';
        $html .= '<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>';
        return $html;
    }
}

class system {
    public static function printPage($html) {
        echo $html;
    }
}