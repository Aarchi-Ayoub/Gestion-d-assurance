<?php 
    session_start();
    if(!isset($_SESSION['id'])){
        header("Location:login.php");
    }
    include "add.php";
    if($_SERVER['REQUEST_METHOD']=='POST'){//Récuperer les valeurs du form
        $client     = $_POST['client'];
        $nature     = $_POST['nature'];
        $surfface   = $_POST['surfface'];
        $piece      = $_POST['piece'];
        $etage      = $_POST['etage'];
        if($_POST['annexe'] == 'Non'){
            $annexe = 'Non';
        }else{
            $annexe = $_POST['annexe-value'];
        }
        if($_POST['securite'] == 'Non'){
            $securite = 'Non';
        }else{
            $securite =$_POST['securite-value'];
        }
        $sql = 'INSERT INTO formlog (idF,nature,etages,surrface,pieces,annexe,securite) 
                VALUES  (?,?,?,?,?,?,?)';
        $req=$cnx->prepare($sql);
        $req->execute(array($client,$nature,$etage,$surfface,$piece,$annexe,$securite));
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
                        <select class='form-control'  required name='nature'>
                            <option value="" disabled selected> Nature </option>
                            <option value="Appartement">Appartement </option>
                            <option value="Villa">Villa </option>
                            <option value="Maison">Maison </option>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <input type="number" class="form-control" placeholder="Etages" name="etage" required>
                    </div>
                    <div class="form-group col-md-3">
                        <input type="number" class="form-control" placeholder="Surrface" min="0" name="surfface" required>
                    </div>
                    <div class="form-group col-md-3">
                        <input type="number" class="form-control" placeholder="Pieces" min="1" name="piece" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label>Annexe  :</label>
                        <input type="radio" value="Oui" name="annexe" id="annexe-oui" required> Oui 
                        <input type="radio" value="Non" name="annexe" id="annexe-no" checked required> Non
                    </div>
                    <div class="form-group col-md-6" id="annex-show">
                        <input type="text" class="form-control" placeholder="Type d'annexe" name="annexe-value" >
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label>Securite  :</label>
                        <input type="radio" value="Oui" name="securite" id="securite-oui" required> Oui 
                        <input type="radio" value="Non" name="securite" id="securite-no" checked required> Non
                    </div>
                    <div class="form-group col-md-6" id="securite-show">
                        <input type="text" class="form-control" placeholder="Systeme de securite" name="securite-value" >
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
