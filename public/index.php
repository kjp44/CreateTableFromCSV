<?php
/**
 * Created by PhpStorm.
 * User: kwilliams
 * Date: 9/26/18
 * Time: 6:42 PM
 */

main::start('myFile.csv');

class main {

    static public function start($fileName) {
        $rawRecords = csv::readCSV($fileName);
        $properties = csv::getProperties($rawRecords);
        $recordsAsObjects = (csv::getRecordsAsObjects($properties, $rawRecords));
        foreach($recordsAsObjects as $recordsAsObject){
            foreach($properties as $property){
                print_r($recordsAsObject->{$property} . "<br/>");
            }
        }
        /*$page = html::createTable($records);
        system::printPage($page);*/
    }
}

/*class html {
    static public function createTable($records) {
        $html = '<table class="">'. "\n";
        $html .= html::createTableHeRow($records[0]);
        for($i = 1; $i < count($records); $i++){
            $html .= html::createTableRow($records[$i]);
        }

        $html .= '</table>'. "\n";

        return $html;
    }

    static public function createTableRow($row) {
            $html = '<tr>'. "\n";
            $html .= $row;
            $html .= '</tr>' . "\n";
        return $html;
    }
    static public function createTableHeader($data){
        $html = '<th>'. "\n";
        $html .= $data;
        $html .= '</th>'. "\n";
        return $html;
    }
    static public function createTableData($data) {
        $html = '<td>'. "\n";
        $html .= $data;
        $html .= '</td>' . "\n";
        return $html;
    }
}*/

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
    public static function getProperties($rawRecords){
        $properties = $rawRecords[0];
        return $properties;
    }
    public static function getRecordsAsObjects($properties, $rawRecords){
        $records = array();
        foreach($rawRecords as $rawRecord) {
            $records[] = RecordFactory::create($properties, $rawRecord);
        }
        return $records;
    }
}
/*class system {

    public static function printPage($page) {
        echo $page;
    }
}*/

class Record
{

    public function __construct($properties, $rawRecord)
    {
        for($i = 0; $i<count($properties); $i++) {
            $this->{$properties[$i]} = $rawRecord[$i];
        }
    }
 }

class RecordFactory
{
    public static function create($properties, $rawRecord)
    {
        return new Record($properties, $rawRecord);
    }
}