<?php
/**
 * Created by PhpStorm.
 * User: kylep
 * Date: 9/26/18
 * Time: 7:06 PM
 */

main::start('myfile.csv');

class main{
    public static function start($fileName){
        $records = csv::getRecords($fileName);
        $page = html::createTable($records);
        system::printPage($page);
    }
}

class csv{
    public static function getRecords($fileName){
        $records = $fileName;
        return $records;
    }
}

class system{
    public static function printPage($page){
        echo $page;
    }
}

class html{
    public static function createTable($records){
        $html = '<table>';
        $html .= html::createTableRow($records);
        $html .= '</table>';
        return $html;
    }
    public static function createTableRow($row){
        $html = '<tr>';
        $html .= html::createTableData($row);
        $html .= '</tr>';
        return $html;
    }
    public static function createTableData($data){
        $html = '<td>';
        $html .= $data;
        $html .= '</td>';
        return $html;
    }
}