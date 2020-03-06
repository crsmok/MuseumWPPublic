<?php

namespace classes\database;

const DB_SERVER_NAME = "localhost";
const DB_USER_NAME = "museum";
const DB_PASSWORD = "123456";
const DB_NAME = "mus";

class DbManager
{
    var $conn;

    function __construct()
    {
        $this->DbManager();
    }

    function __destruct()
    {
        $this->destroy();
    }

    function DbManager()
    {

        $this->conn = mysqli_connect(DB_SERVER_NAME, DB_USER_NAME, DB_PASSWORD, DB_NAME);
        mysqli_query($this->conn, 'set names utf8');
        date_default_timezone_set('Europe/Minsk');
    }

    function destroy()
    {
        if (is_resource($this->conn) && get_resource_type($this->conn) === 'mysql link') {
            mysqli_close($this->conn);
        }

    }

    function executeQuery($query, $valuesArray, $paramTypes)
    {
        $res = mysqli_prepare($this->conn, $query);
        if ($valuesArray) {
            $inputArray[] = &$paramTypes;

            foreach ($valuesArray as $key => $value) {
                $inputArray[] = &$valuesArray[$key];
            }

            call_user_func_array(array($res, 'bind_param'), $inputArray);
        }
        $res->execute();
        $result = $res->get_result();
        mysqli_stmt_free_result($res);
        return $result;
    }

    function getRecordSet($resultQuery)
    {
        $rowIndex = 0;
        while ($rows = $resultQuery->fetch_row()) {
            $colIndex = 0;
            foreach ($rows as $row) {
                $data[$rowIndex][$colIndex] = $row;
                $colIndex++;
            }
            $rowIndex++;
        }

        return $data;
    }

    function insertRecordSet($data, $fields, $tableName)
    {
        $queryTypeParams = '';
        $query = 'insert into ' . $tableName . '(' . join(',', $fields) . ') values (';
        $i = 0;

        foreach ($fields as $field) {
            $fieldsValue[$i] = $data[$field]['value'];
            $i++;
            $queryTypeParams = $queryTypeParams . $data[$field]['type'];
            $query = $query . ' ? ,';
        }

        $query = substr_replace($query, ')', -1);
        $this->executeQuery($query, $fieldsValue, $queryTypeParams);
    }
}

?>