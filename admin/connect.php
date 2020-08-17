<?php

    $dsn = 'mysql:host=localhost;dbname=shop'; //Data Source Name
    $user = 'root';
    $pass = '';
    $options = array(
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
    );

    try {
        $db = new PDO($dsn, $user, $pass, $options); //Start New Connection with PDO class
        $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOException $e){
        echo 'Failed '.$e -> getMessage(); 
    }