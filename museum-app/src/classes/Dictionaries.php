<?php
/**
 * Created by PhpStorm.
 * User: andrey.rak
 * Date: 05.06.2018
 * Time: 12:46
 */

namespace classes;
use classes\database\TableManager;
use classes\Dictionary;

class Dictionaries extends TableManager
{
    var $dictionariesData;

    function __construct($dbManager)
    {
        parent::__construct($dbManager, 'dictlist');
        $this->dictionariesData = $this->database->getRecordSet($this->database->executeQuery('select * from dictlist', null, null));
    }

    function getDictionaryId($dictionary){
        $query = 'select * from dictlist where dict_table = ?';
        return $this->database->getRecordSet($this->database->executeQuery($query, [$dictionary], 's'))[0][0];
    }

    function getDictionaryRecord($dictionary){
        $query = 'select * from '.$dictionary;
        return $this->database->getRecordSet($this->database->executeQuery($query, null, null));
    }

    function createDictionary($dictionary){

        $dictionaryId = $this->database->getRecordSet($this->database->executeQuery('select MAX(dict_id)from dictlist ', null, null))[0][0];

    }
}

