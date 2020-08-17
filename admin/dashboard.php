<?php
session_start();

if(isset($_SESSION['userName'])){

    $pageTitle = 'Dashboard';
    include "init.php";
    include $tpl."footer.php";

}else{
    
    echo 'You are not authorised to view this page';
    header('Location: index.php');
    exit();

}