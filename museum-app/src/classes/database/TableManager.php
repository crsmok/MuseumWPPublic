<?php
/**
 * Created by PhpStorm.
 * User: andrey.rak
 * Date: 30.05.2018
 * Time: 13:58
 */

namespace classes\database;

use classes\database\DbManager;

class TableManager
{
    var $tableName, $tableListFields, $database, $entityRecord;

    function __construct($dbManager, $table)
    {
        $this->TableManager($dbManager, $table);
    }

    function TableManager($dbManager, $table){
        $this->tableName = $table;
        $this->database = $dbManager;

        $query = "SELECT COLUMN_NAME,upper(COLUMN_TYPE) FROM information_schema.columns WHERE table_schema='mus' AND table_name='".$table."'";
        $listFields = $dbManager->getRecordSet($dbManager->executeQuery($query, null, null));

        foreach ($listFields as $key=>$row){
            if(strpos($row[1],'(')){
                $fieldType = substr($row[1], 0, strpos($row[1], '('));
            } else{
                $fieldType = $row[1];
            }
            $this->tableListFields[$row[0]]['field_type'] = $row[1];

            if(in_array($fieldType, ['BIT', 'INT'])){
                $this->tableListFields[$row[0]]['type'] = 'i';
            } else if($fieldType == 'DOUBLE'){
                $this->tableListFields[$row[0]]['type'] = 'd';
            } else {
                $this->tableListFields[$row[0]]['type'] = 's';
            }
            $listFields[$key][1] = $fieldType;
        }
    }



}