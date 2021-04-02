<?php 
    session_start();
    if(!isset($_SESSION['id'])){
        header("Location:login.php");
    }else{
        include 'add.php';
        //Diviser l'url pour avoir l'action
        $client = isset($_GET['id'])? $_GET['id'] :'';
        $sql    = "SELECT * FROM user WHERE idUser = $client ";       
        $req    = $cnx->prepare($sql);
        $req->execute();
        $rows    = $req->fetchAll();
        echo '
        <div class="container">
            <h1 class="text-primary">Fiche des clients :</h1>
            <div class="fiche"><ul class="list-group ">
            ';    
            foreach($rows as $row){
                echo '<li class="list-group-item">'.$row['Nom'].' '.$row['Prenom'].'</li>';
                echo '<li class="list-group-item">'.$row['Tel'].'</li>';
                echo '<li class="list-group-item">'.$row['Email'].'</li>';
                echo '<li class="list-group-item">'.$row['Adresse'].'</li>';

                $sql    = "SELECT * FROM form WHERE idClt = $client ";       
                $req    = $cnx->prepare($sql);
                $req->execute();
                $rows    = $req->fetchAll();
                foreach($rows as $row)
                {
                    $sql    = "SELECT Nom FROM insurance WHERE insurance.idAsr =". $row['idAsr']." ";       
                    $req    = $cnx->prepare($sql);
                    $req->execute();
                    $col    = $req->fetchColumn();
                    echo '<li class="list-group-item">'.$col.'</li>';
                    echo '<li class="list-group-item">'.$row['debut'].'</li>';
                    echo '<li class="list-group-item">'.$row['fin'].'</li>';
                    echo '<li class="list-group-item">'.$row['paye'].'</li>';
                    echo '<li class="list-group-item">'.$row['reste'].'</li>';
                    echo '<li class="list-group-item text-warning text-center"> * Infos pour une autre contart *</li>';
 
                }
            }
        echo '</ul></div>
        </div>
        ';
        include "Include/template/footer.php";
    }
?>
