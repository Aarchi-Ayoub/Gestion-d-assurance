<?php 
    session_start();
    if(!isset($_SESSION['id'])){
        header("Location:login.php");
    }
    include "add.php";
    if($_SERVER['REQUEST_METHOD']=='POST'){//Récuperer les valeurs du form
        $client     = $_POST['client'];      
        $activite   = $_POST['activite'];
        if($_POST['club'] == 'Non'){
            $club = 'Non';
        }else{
            $club = $_POST['club-nom'];
        }
        
        $sql = 'INSERT INTO formloi (idF,activite,club) 
                VALUES  (?,?,?)';
        $req=$cnx->prepare($sql);
        $req->execute(array($client,$activite,$club));
        header('Refresh:0,url=operations.php');
        exit();
    }
?>    
<div class="container"><div class="row mt-5">
    <div class="col mx-auto">
        <div class="card"><div class="card-body">
            <form class="insert" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <select class='form-control'  required name='client'>
                            <option value="" disabled selected>Client </option>
                            <?php 
                                $req  = $cnx->prepare("SELECT f.idFrm,u.Nom,u.Prenom FROM form f ,user u WHERE u.idUser = f.idClt AND u.GroupID = 0 ");
                                $req->execute();
                                $rows = $req->fetchAll();
                                foreach($rows as $row){
                                    echo '
                                        <option value="'.$row['idFrm'].'">'
                                            .$row['Nom'].' '.$row['Prenom']
                                        .'</option>';
                                } 
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label>Adheration club  :</label>
                        <input type="radio" value="Oui" name="club" id="club-oui" required> Oui 
                        <input type="radio" value="Non" name="club" id="club-no" checked required> Non
                    </div>
                    <div class="form-group col-md-3">
                        <input type="text" class='form-control' placeholder="Nom du club" name="club-nom" id="club-nom" required>  
                    </div>
                    <div class="form-group col-md-6">
                        <input type="text" class='form-control' placeholder="Nom d'activité" name="activite" required>  
                    </div>
                </div>
                <div class="form-group text-right">
                    <button class="btn btn-primary" id="insert">Créer</button>
                </div>
            </form>
        </div></div>
    </div>
</div></div>

<?php
    include "Include/template/footer.php";
?> 
