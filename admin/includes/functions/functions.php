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
    ** $msg: Msg to show before redirecting [Succes, Warning, Error]
    ** $url: redirect link 
    ** $seconds: seconds before redirecting, default: 3 seconds
    */
function redirectHome($theMsg, $url = null, $seconds = 3)
{
    if ($url === null) {
        $url = 'index.php';
        $link = 'Homepage';
    } else {
        if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== '') {
            $url = $_SERVER['HTTP_REFERER'];
            $link = 'Previous Page';
        } else {
            $url = 'index.php';
            $link = 'Homepage';
        }
    }
    echo $theMsg;
    echo "<div class='alert alert-info'>You Will Be Redirected to $link After $seconds Seconds.</div>";
    header("refresh:$seconds;url=$url");
    exit();
}

/*
    ** Function to check items in database
    ** Function parameters:
    ** $select : The item to select (example: username, itemID, category)
    ** $from : the table to select from (example: users, items, categories)
    ** $value: the values of the select
    */
function checkItem($select, $from, $value)
{
    global $db;
    $statement = $db->prepare("SELECT $select FROM $from WHERE $select = ?");
    $statement->execute(array($value));
    $count = $statement->rowCount();
    return $count;
}

/*
** Count Number of Items Function
** Function to count number of item in certain table
** $item: item to count
** $table: db table name
*/
function countItems($item, $table)
{
    global $db;
    $stmt = $db->prepare("SELECT COUNT($item) from $table");
    $stmt->execute();
    return $stmt->fetchColumn();
}


/*
** Get Latest Records Function 
** Function To Get Latest Items From Database [ Users, Items, Comments ]
** $select = Field To Select
** $table = The Table To Choose From
** $order = The Desc Ordering
** $limit = Number Of Records To Get
*/
function getLatest($select, $table, $order, $limit = 5)
{
    global $db;
    $getStmt = $db->prepare("SELECT $select FROM $table ORDER BY $order DESC LIMIT $limit");
    $getStmt->execute();
    $rows = $getStmt->fetchAll();
    return $rows;
}
