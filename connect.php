<?php

require_once "admin_middleware.php";

function getConnection()
{
    try {
        $dsn = "mysql:host=localhost;dbname=fiipractic";
        $connection = new PDO($dsn, "root", "Te0d0r4!");
    }catch (PDOException $exception) {
        echo "CANNOT_CONNECT_TO_DB";
        exit;
    }

    return $connection;
}




