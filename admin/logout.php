<?php

    session_start();    //Start the session
    session_unset();    //unset the data
    session_destroy();  //Destroy the session
    header('Location: index.php');  
    exit();
