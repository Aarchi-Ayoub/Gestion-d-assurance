<?php
    session_start();
    if(!isset($_SESSION['id'])){
        header("Location:login.php");
    }else{
        include "add.php";
        $direction=isset($_GET['option'])? $_GET['option'] :'';
?>
<div class="container">
    <div class="row mx-auto mt-5">
        <div class="col-md-6">
        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#add">Nouveau offre</button>
        <div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ajouter <i class="fa fa-plus" aria-hidden="true"></i></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php require 'ofadd.php';?>
                </div>
                </div>
            </div>
            </div>
        </div>
        <div class="col-md-6">
        <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#delet">Supprimer un offre</button>
        <div class="modal fade" id="delet" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Supprimer</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php require 'ofdlt.php';?>
                </div>
                </div>
            </div>
            </div>
        </div>
    </div>
    <div class="row mx-auto mt-3">
        <div class="col">
            <div class="card text-white bg-primary mb-3" style="max-width: 18rem;">
                <div class="card-header text-center">Clients</div>
                <div class="card-body text-center count">
                    <span><?php echo returnCount('user','*','GroupID','0');?></span>
                </div>
            </div>
        </div>
        
        <div class="col">
            <div class="card text-white bg-success mb-3" style="max-width: 18rem;">
                <div class="card-header text-center">Admins</div>
                <div class="card-body text-center count">
                    <span class="text-center"><?php echo returnCount('user','*','GroupID','1');?></span>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card text-white bg-warning mb-3" style="max-width: 18rem;">
                <div class="card-header text-center">Offres</div>
                <div class="card-body text-center count">
                    <span class="text-center"><?php echo returnCount('offer','*');?></span>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card text-white bg-dark mb-3" style="max-width: 18rem;">
                <div class="card-header text-center">Contracts</div>
                <div class="card-body text-center count">
                    <span class="text-center"><?php echo returnCount('form','*');?></span>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-2 mx-auto">
        <div class="col">
            <div class="in">
                <?php
                    $sql    = "SELECT SUM(paye) FROM form";
                    $req    = $cnx->prepare($sql);
                    $req->execute();
                    $col    = $req->fetchColumn();
                    echo $col.' MAD';
                ?>
            </div>
        </div>
        <div class="col">
            <div class="out">
            <?php
                    $sql    = "SELECT SUM(reste) FROM form";
                    $req    = $cnx->prepare($sql);
                    $req->execute();
                    $col    = $req->fetchColumn();
                    echo $col.' MAD';
                ?>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-9 mx-auto border comments">
            <h3 class="text-center mt-2">Comments :</h3>
            <?php 
                $req    = $cnx->prepare("SELECT * FROM comment WHERE activate = 1 ORDER BY idCmt DESC ");
                $req->execute();
                $rows    = $req->fetchAll();
                foreach($rows as $row){
                    echo '<p>'.$row['cmt'].'</p>';
                }
            ?>
        </div>
    </div>
</div>
<?php            
        include "Include/template/footer.php";
    }
?>