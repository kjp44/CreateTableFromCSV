<?php
/**
 * Created by PhpStorm.
 * User: kwilliams
 * Date: 9/26/18
 * Time: 6:42 PM
 */


main::start('myfile.csv');

class main {

    static public function start($filename) {
        $records = csv::getRecords($filename);
        $page = html::createTable($records);
        system::printPage($page);
    }
}

class html {
    static public function createTable($records) {

        $html = '<table class="">'. "\n";
        $column = html::tableColumn($records);
        $html .= html::tableRow($column);
        $column = html::tableColumn($records);
        $html .= html::tableRow($column);
        $column = html::tableColumn($records);
        $html .= html::tableRow($column);
        $html .= '</table>'. "\n";

        return $html;
    }

    static public function tableRow($row) {
            $html = '<tr>'. "\n";
            $html .= $row;
            $html .= '</tr>' . "\n";
        return $html;
    }
    static public function tableColumn($column) {
        $html = '<td>'. "\n";
        $html .= $column;
        $html .= '</td>' . "\n";
        return $html;

    }
}

class csv {

    public static function getRecords($filename) {

        $record = RecordFactory::create($record);
        $records[] = $record;
        print_r($records);
        $records = $filename;
        return $records;
    }

}
class system {

    public static function printPage($page) {
        echo $page;
    }
}

class Record
{

    public function __construct($record)
    {

    }

 }

class RecordFactory
{
    public static function create($record)
    {
        return new Record($record);
    }
}