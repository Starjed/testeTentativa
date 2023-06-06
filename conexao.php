<?php

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "banco";

try{
    //Conexão com a porta
    $conn = new PDO("mysql:host=$host;dbname=" . $dbname, $user, $pass);

    //Conexão sem a porta
    //$conn = new PDO("mysql:host=$host;dbname=" . $dbname, $user, $pass);

}  catch(PDOException $err){
    echo "Erro: Conexão com banco de dados não foi realizada com sucesso. Erro gerado " . $err->getMessage();
}