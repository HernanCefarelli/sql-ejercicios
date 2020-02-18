<?php
    $dsn = 'mysql:host=localhost;dbname=movies_db;port=3306';
    $user = "root";
    $pass = "root";
    try
    {
        $bd = new PDO($dsn,$user,$pass);
    } catch(EXCEPTION $e)
    {
        echo "No se pudo conectar a la base de datos ".$e->getMessage();
        exit;
    }
?>