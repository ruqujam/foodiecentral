<?php

$serverName = 'iitsdgp.database.windows.net';
$uid = 'foodiecentral101';
$pwd = 'foodiepassword69!';
$connectionInfo = array( "UID"=>$uid,
    "PWD"=>$pwd,
    "Database"=>"FoodieCentral");

    $conn = sqlsrv_connect( $serverName, $connectionInfo);


function generateRandomString($length) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

