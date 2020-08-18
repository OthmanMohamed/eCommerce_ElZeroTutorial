<?php

    /*
    ** Title function to echo the page title in case the page has the variable  $pageTitle defined
    ** else echo default for other pages
    */
    function getTitle()
    {
        global $pageTitle;
        if (isset($pageTitle)) {
            echo $pageTitle;
        } else {
            echo 'Default';
        }
    }

    /*
    ** Redirect Function | Parameters:
    ** $errorMsg: Msg to show before redirecting
    ** $seconds: seconds before redirecting, default: 3 seconds
    */
    function redirectHome($errorMsg, $seconds = 3)
    {
        echo "<div class='alert alert-danger'>$errorMsg</div>";
        echo "<div class='alert alert-danger'>You will be redirected to homepage after $seconds Seconds.</div>";
        header("refresh:$seconds; url=index.php");
    }
