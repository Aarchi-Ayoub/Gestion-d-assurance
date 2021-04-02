<?php
    session_start();
    if(!isset($_SESSION['id'])){
        header("Location:login.php");
    }else{
        include "add.php";
?><br/>
<div class="container">
    <h1 class="h1 text-center text-primary">Contract</h1>
    <?php  
        $sql    = " SELECT form.* , insurance.Nom as 'insurance'
                    FROM form
                    INNER JOIN user ON form.idClt = user.idUser
                    INNER JOIN insurance on insurance.idAsr = form.idAsr
                    WHERE idUser = ".$_SESSION['id']."";       
        $req    = $cnx->prepare($sql);
        $req->execute();
        $rows    = $req->fetchAll();
        if(empty($rows)){
            echo '<div class="col-md-12 mx-auto"><div class="alert alert-warning">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                Vous n\'avez aucun contrat pour le moment !    
            </div></div></div>';
        }else{
            echo '<div class="card-deck">';
            foreach($rows as $row){
                echo '
                <div class="card">
                <div class="card-body">
                  <h5 class="card-title text-center">'.$row['insurance'].'</h5>
                  <p class="card-text">
                  <ul class="list-unstyled">
                  <li>
                    <i class="fa fa-money" aria-hidden="true"></i> <b>Payé</b> :'.$row['paye'].'
                  </li>
                  <li>
                    <i class="fa fa-money" aria-hidden="true"></i> <b>Resté</b> :'.$row['reste'].'
                  </li>
                  <li>
                    <i class="fa fa-calendar fa-fw"></i> <b>Début</b> :'.$row['debut'].'
                  </li>
                  <li>
                    <i class="fa fa-calendar fa-fw"></i> <b>Fin</b> :'.$row['fin'].'
                  </li>
                  </ul>
                  
                  
                   
                  
                  </p>
                </div>
                </div>';
            }
            echo '</div>';
        }
    ?>
</div>
<?php        
        include "Include/template/footer.php";
    }
?>