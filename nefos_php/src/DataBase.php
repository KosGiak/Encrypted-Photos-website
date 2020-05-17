<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DataBase
 *
 * @author Alcohealism
 */
class DataBase {
    function __construct() {
        
    }

    //Connection with the First DB:    
    function NefosDB() {
        $conf['db']['db_Host'] = 'localhost';
	$conf['db']['db_Login'] = 'root';
	$conf['db']['db_PWord'] = '';
	$conf['db']['db_Name'] = 'NefosDB';
	$conf['db']['db_Port'] = '3306';

	$db1 = mysqli_connect($conf['db']['db_Host'], $conf['db']['db_Login'], $conf['db']['db_PWord'], $conf['db']['db_Name'], $conf['db']['db_Port']);
	mysqli_query($db1, 'SET NAMES utf8');
	//session_start();
	if (!$db1) {
		die('Connect Error (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
	}
        return $db1;
    }
    
    function PrivateKeys(){
        $conf['db']['db_Host'] = 'localhost';
	$conf['db']['db_Login'] = 'root';
	$conf['db']['db_PWord'] = '';
	$conf['db']['db_Name'] = 'nefosprivatekeysdb';
	$conf['db']['db_Port'] = '3306';

	$db2 = mysqli_connect($conf['db']['db_Host'], $conf['db']['db_Login'], $conf['db']['db_PWord'], $conf['db']['db_Name'], $conf['db']['db_Port']);
	mysqli_query($db2, 'SET NAMES utf8');
	//session_start();
	if (!$db2) {
		die('Connect Error (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
	}
        return $db2;
    }
}
