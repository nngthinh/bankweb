<?php

$link = startConnectToEB();
closeConnecttoEB($link);

// * Essential functions
// 1. Connect to DB
// Start connection to database
function startConnectToEB()
{
    $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
    if (!$link) {
        die('ERROR: Connection failed (' . mysqli_errno($link) . ')' . mysqli_error($link));
    }
    return $link;
}

// Close the connection
function closeConnectToEB(&$link)
{
    mysqli_close($link);
}
