<?php
    $server="localhost";
    $base="assurance";
    $user="root";
    $password="";
    try{
        $cnx=new PDO("mysql:local=".$server.";dbname=".$base."",$user,$password);
        $cnx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }catch(PDOException $e){
        echo "Erreur :".$e->getMessage();
    }
?>