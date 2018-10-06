<?php
/**
 * Created by PhpStorm.
 * User: kwilliams
 * Date: 9/26/18
 * Time: 6:42 PM
 */
main::start('example.csv');

class main {
    static public function start($fileName) {
        $rawRecords = csv::readCSV($fileName);
        $properties = $rawRecords[0];
        array_splice($rawRecords,0,1);
        $recordsAsObjects = (csv::convertRecordsToObjects($properties, $rawRecords));
        $tableHTML = html::createTable($properties, $recordsAsObjects);
        system::printPage($tableHTML);
    }
}

class html {
    static public function createTable($properties, $recordsAsObjects) {
        $html = '<table class="table table-striped">';
        $html .= html::createTableHeader($properties);
        foreach($recordsAsObjects as $recordAsObject){
            $html .= html::createTableRow($properties, $recordAsObject);
        }
        $html .= '</table>';
        return $html;
    }
    static public function createTableHeader($properties){
        $html = "<thead>";
        $html .= "<tr>";
        foreach($properties as $property){
            $html .= html::createTableHeaderData($property);
        }
        $html .= "</tr>";
        $html .= "</thead>";
        return $html;
    }
    static public function createTableHeaderData($property){
        $html = '<th scope="col">';
        $html .= $property;
        $html .= "</th>";
        return $html;
    }
    static public function createTableRow($properties, $recordAsObject) {
            $html = '<tr>';
            $html .= '<th scope="row">';
            $html .= $recordAsObject->{$properties[0]};
            $html .= '</th>';
            for($i = 1; $i < count($properties); $i++){
                $html .= html::createTableRowData($recordAsObject->{$properties[$i]});
            }
            $html .= '</tr>';
        return $html;
    }
    static public function createTableRowData($data) {
        $html = '<td>';
        $html .= $data;
        $html .= '</td>';
        return $html;
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
    public static function convertRecordsToObjects($properties, $rawRecords){
        $records = array();
        foreach($rawRecords as $rawRecord) {
            $records[] = RecordFactory::create($properties, $rawRecord);
        }
        return $records;
    }
}

class system {
    public static function printPage($tableHTML) {
        echo $tableHTML;
    }
}

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