<?php
/**
 * Created by PhpStorm.
 * User: andrey.rak
 * Date: 08.06.2018
 * Time: 10:42
 */

namespace classes;
use classes\database\TableManager;

class Dictionary extends TableManager{
    function __construct($dbManager, $table, $filter)
    {
        parent::__construct($dbManager, $table);
        $this->getRecord($filter);
    }

    function getRecord($filter){
        if($filter) {
            $query = 'select dict_valueid, dict_value from ' . $this->tableName . ' where dict_valueid= ?';
            $recordSet = $this->database->getRecordSet($this->database->executeQuery($query, [$filter], 'i'));
        } else {
            $query = 'select dict_valueid, dict_value from ' . $this->tableName ;
            $recordSet = $this->database->getRecordSet($this->database->executeQuery($query, null, null));
        }
        $i=0;
        foreach ($recordSet as $record)
        {
            foreach ($record as $key=>$field){
                $this->entityRecord[$i][$key] = $field;
            }
            $i++;
        }

    }

}