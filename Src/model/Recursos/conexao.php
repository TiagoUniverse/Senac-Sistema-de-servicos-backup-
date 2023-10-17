<?php
$servername = "SQLSERVER";
$dbname = "TermoAceite";
$username = "tiagolopes";
$pwd = "gti2022";
try{
     $pdo = new PDO ("sqlsrv:server=$servername ; Database=$dbname" , "$username" , "$pwd");
    // echo "Conectado com sucesso!";
    $pdo->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION);
} catch(Exception $e){
    die (print_r ($e->getMessage()));
}
