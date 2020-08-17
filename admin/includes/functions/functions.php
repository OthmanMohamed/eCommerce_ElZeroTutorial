<?php

    /*
    ** Title function to echo the page title in case the page has the variable  $pageTitle defined
    ** else echo default for other pages
    */
    function getTitle(){
        global $pageTitle;
        if (isset($pageTitle)){
            echo $pageTitle;
        } else {
            echo 'Default';
        }
    }