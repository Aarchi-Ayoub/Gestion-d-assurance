<?php 
    session_start();
    if(!isset($_SESSION['id'])){
        header("Location:login.php");
    }else{
        include 'add.php';
        $direction=isset($_GET['dir'])? $_GET['dir'] :'';
        if($direction == ''){
        $sql = "SELECT user.Nom,user.Prenom,comment.*,comment.activate as 'dis',offer.description 
                FROM user,comment,offer
                WHERE user.idUser = comment.idClt
                AND offer.idOfr = comment.idOfr 
                ORDER BY idCmt DESC";
        $req    = $cnx->prepare($sql);
        $req->execute();
        $rows    = $req->fetchAll();
        $sql = "SELECT COUNT(*) FROM comment";
        $req    = $cnx->prepare($sql);
        $req->execute();
        $count    = $req->fetchColumn();
?>
<div class="container">
    <h1 class="text-center">Liste des commentaires</h1>    
    <div class="float-right">
        Count : <?php echo $count ;?>
    </div><br>
        <?php 
            if(!$rows){
                echo '<div class="alert alert-secondary" role="alert">
                No comments for the moments !
              </div>';
            }else{
                foreach($rows as $row){ 
                    echo '<div class="card mb-2"><div class="card-body cmt">';
                    echo '<b>'.$row['Nom'].' '.$row['Prenom'].'</b> : '.$row['description'];
                    if($row['dis'] ==0 ){echo '<span class="float-right">Désactivé</span>';}  
                    echo '<p>'.$row['cmt'].'</p>'; 
                    echo '<div class="float-right">'; 
                    if($row['dis'] ==0 ){           
                    echo '<a href="?dir=act&id='.$row["idCmt"].'" class="btn btn-success" role="button">Activer</a>';}
                    echo '<a id="delete" href="?dir=sup&id='.$row["idCmt"].'" class="btn btn-danger" role="button">Supprimer</a>';
                    echo '</div></div></div>';
                }
            }
        ?>  
</div>
<?php
        }elseif($direction == 'sup'){
            //Récupérer l'id passer depuis l'url
            $id=isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;
            $sql='DELETE FROM comment WHERE idCmt = ?';
            $req=$cnx->prepare($sql);
            $req->execute(array($id));
            header('Refresh:0,url=cmt.php');
            exit();
        }elseif($direction == 'act'){
            //Récupérer l'id passer depuis l'url
            $id=isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;
            $sql='UPDATE comment set activate = 1 WHERE idCmt = ?';
            $req=$cnx->prepare($sql);
            $req->execute(array($id));
            header('Refresh:0,url=cmt.php');
            exit();
        }
        include "Include/template/footer.php";
    }
?>