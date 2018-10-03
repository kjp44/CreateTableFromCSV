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
        csv::getRecordsAsObjects($rawRecords);
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
        $records = array();
        $file = fopen($fileName, "r");
        while (!feof($file)) {
            $records[] = fgetcsv($file);
        }
        fclose($file);
        return($records);
    }
    public static function getRecordsAsObjects($rawRecords){
        $records = array();
        foreach($rawRecords as $rawRecord) {
            $records[] = RecordFactory::create($rawRecord);
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

    public function __construct($record)
    {
        $this->componentID = $record[0];
        $this->componentName = $record[1];
        $this->componentGroup = $record[2];
        $this->componentMessage = $record[3];
        $this->redeemableStatus = $record[4];
        $this->inStockDate = $record[5];
    }
 }

class RecordFactory
{
    public static function create($rawRecord)
    {
        return new Record($rawRecord);
    }
}