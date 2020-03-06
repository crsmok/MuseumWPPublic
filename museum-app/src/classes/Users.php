<?php
/**
 * Created by PhpStorm.
 * User: andrey.rak
 * Date: 05.06.2018
 * Time: 11:33
 */

namespace classes;

use classes\database\TableManager;

class Users extends TableManager
{
    var $userLogin, $userPassword;

    function __construct($dbManager, $login, $password)
    {
        parent::__construct($dbManager, 'users');
    }
}