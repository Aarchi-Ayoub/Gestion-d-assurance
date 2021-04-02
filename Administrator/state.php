<?php 
    session_start();
    if(!isset($_SESSION['id'])){
        header("Location:login.php");
    }else{
        include 'add.php';
        $direction=isset($_GET['dir'])? $_GET['dir'] :'';
        if($direction == ''){
            $sql    = " SELECT form.* , user.Nom as 'Nom',user.Prenom as 'Prenom', insurance.Nom as 'insurance'
                        FROM form
                        INNER JOIN user ON form.idClt = user.idUser
                        INNER JOIN insurance on insurance.idAsr = form.idAsr
                        WHERE user.GroupID = 0";       
            $req    = $cnx->prepare($sql);
            $req->execute();
            $rows    = $req->fetchAll();
            if(!$rows){
                echo '<div class="container"><div class="alert mt-5 alert-dark" role="alert">
                        La table des opérations est vide pour le momment
                    </div></div>';
            }
            if($_SERVER['REQUEST_METHOD']=='POST'){//Récuperer la valeur de search
                $search = $_POST['search'];
                $sql    = " SELECT form.* , user.Nom as 'Nom',user.Prenom as 'Prenom', insurance.Nom as 'insurance'
                            FROM form
                            INNER JOIN user ON form.idClt = user.idUser
                            INNER JOIN insurance on insurance.idAsr = form.idAsr
                            WHERE user.GroupID = 0 
                            AND user.Nom LIKE ('%$search%')
                            OR user.Prenom LIKE ('%$search%')
                            OR insurance.Nom LIKE ('%$search%')";      
                $req    = $cnx->prepare($sql);
                $req->execute();
                $rows    = $req->fetchAll();
                if(!$rows){
                    echo '<div class="container"><div class="alert mt-5 alert-dark" role="alert">
                            Aucun enregstrement avec cet indice !
                        </div></div>';
                        $sql    = " SELECT form.* ,user.Nom as 'Nom',user.Prenom as 'Prenom', insurance.Nom as 'insurance'
                        FROM form
                        INNER JOIN user ON form.idClt = user.idUser
                        INNER JOIN insurance on insurance.idAsr = form.idAsr
                        WHERE user.GroupID = 0";       
                        $req    = $cnx->prepare($sql);
                        $req->execute();
                        $rows    = $req->fetchAll();
                }
            }
?>
<div class="container">
    <h1 class="text-center h1 mt-3"> Liste des opérations</h1>
    <div class="row mx-auto">
        <div class="col mb-4">
            <form class="form-inline" action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
                <input class="form-control mr-sm-2" type="text" placeholder="Chercher" name="search">
                <button class="btn btn-light" type="submit"><i class="fa fa-search"></i></button>
            </form>
        </div>
    </div>
    <table class="table text-center table-striped">
    <thead>
        <tr>
        <th scope="col">Nom et Prénom</th>
        <th scope="col">Type d'assurance</th>
        <th scope="col">Payé</th>
        <th scope="col">Reste</th>
        <th scope="col">Action</th>
        
        </tr>     
    </thead>
    <tbody>
    <?php  
            foreach($rows as $row){
                echo'
                    <tr>
                        <td><a href="ficheClient.php?id='.$row['idClt'].'">'.$row['Nom'].' '.$row['Prenom'].'</a></td>
                        <td>'.$row['insurance'].'</td>
                        <td class="paye">'.$row[6].'</td>
                        <td class="reste">'.$row[7].'</td>
                        <td>
                            <a href="?dir=mdf&id='.$row["idFrm"].'" class="btn btn-warning" role="button">Modifier</a>
                            <a id="delete" href="?dir=sup&id='.$row["idFrm"].'" class="btn btn-danger" role="button">Supprimer</a>
                        </td>
                    </tr>
                    ';
            }
        ?>   
    </tbody></table>
</div>

<?php    
            
        }elseif($direction == 'sup'){
            //Récupérer l'id passer depuis l'url
            $id=isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;
            $sql='DELETE FROM form WHERE idFrm = ?';
            $req=$cnx->prepare($sql);
            $req->execute(array($id));
            header('Refresh:0,url=state.php');
            exit();
        }
        elseif($direction == 'mdf'){
            $id=isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;
            if($_SERVER['REQUEST_METHOD']=='POST'){//Récuperer les valeurs
                $respo  = $_SESSION['id'];
                $debut  = $_POST['dbt'];
                $fin    = $_POST['fn'];
                $paye   = $_POST['paye'];
                $reste  = $_POST['reste'];

                //Appliquer la modification
                $sql = "UPDATE form set idRes=".$respo.",debut=".$debut.",fin=".$fin.",paye=".$paye.",reste=".$reste." WHERE idFrm =".$id."";
                $req=$cnx->prepare($sql);
                $req->execute();
                header('Refresh:0,url=state.php');
                exit();
            }
            $sql    = "SELECT * FROM form WHERE idFrm = $id ";
            $req    = $cnx->prepare($sql);
            $req->execute();
            $row    = $req->fetch();    
?>
<div class="container"><div class="row mt-5">
    <div class="col mx-auto">
        <div class="card"><div class="card-body">
            <form class="insert" action="" method="POST">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Début :</label>
                        <input type="date" class="form-control" value="<?php echo $row['debut'];?>"  name="dbt" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Fin :</label>
                        <input type="date" class="form-control" value="<?php echo $row['fin'];?>"  name="fn" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Payé  :</label>
                        <input type="number" class="form-control" required value="<?php echo $row['paye'];?>" placeholder="0000.00 MAD" min="0" name="paye" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Reste :</label>
                        <input type="number" class="form-control" placeholder="0000.00 MAD" value="<?php echo $row['reste'];?>" min="0" name="reste" required>
                    </div>
                </div>
                <div class="form-group text-right">
                    <button class="btn btn-warning" id="insert">Modifier</button>
                </div>
            </form>
        </div></div>
    </div>
</div></div>

<?php            
        }
        include "Include/template/footer.php";
    }
?>
