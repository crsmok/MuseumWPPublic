<?php
    include("../classes/database/DbManager.php");
    include("../classes/database/TableManager.php");
    include("../classes/Users.php");

    $dbManager = new classes\database\DbManager();
    $dictionary = new classes\database\TableManager($dbManager,'users');

    foreach ($dictionary->tableListFields as $row){
        foreach ($row as $col){
            print ($col.' ');
        }
        print('<br>');
    }

    $dbManager->destroy();
?>