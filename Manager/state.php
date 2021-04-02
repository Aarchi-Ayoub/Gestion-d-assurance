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
    <div class="row"><div class="col mb-4">
        <form class="form-inline" action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
            <input class="form-control mr-sm-2" type="text" placeholder="Search" name="search">
            <button class="btn btn-light" type="submit"><i class="fa fa-search"></i></button>
        </form>
    </div></div>
    <table class="table text-center table-striped">
    <thead>
        <tr>
        <th scope="col">Nom et Prénom</th>
        <th scope="col">Type d'assurance</th>
        <th scope="col">Payé</th>
        <th scope="col">Resté</th>        
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
                    </tr>
                    ';
            }
        ?>   
    </tbody></table>
</div>
<?php            
        }
        include "Include/template/footer.php";
    }
?>
