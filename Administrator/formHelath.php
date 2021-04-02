<?php 
    session_start();
    if(!isset($_SESSION['id'])){
        header("Location:login.php");
    }
    include "add.php";
    if($_SERVER['REQUEST_METHOD']=='POST'){//Récuperer les valeurs du form
        $client     = $_POST['client'];      
        $naissance  = $_POST['naiss'];
        $rib        = $_POST['rib'];
        $nss        = $_POST['nss'];
        $caisse     = $_POST['caisse'];

        $sql = 'INSERT INTO forms (idF,naissance,RIB,nss,caisse) 
                VALUES  (?,?,?,?,?)';
        $req=$cnx->prepare($sql);
        $req->execute(array($client,$naissance,$rib,$nss,$caisse));
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
                    <div class="form-group col-md-12">
                        <input type="date" class="form-control"  name="naiss" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                    <input type="text" class='form-control' placeholder="Numero securité social" name="nss" required>  
                    </div>
                    <div class="form-group col-md-4">
                        <input type="text" class='form-control' placeholder="Relvé identité bancaire" name="rib" required>  
                    </div>
                    <div class="form-group col-md-4">
                        <input type="text" class='form-control' placeholder="Banque" name="caisse" required>  
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
