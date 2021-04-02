<?php 
    session_start();
    if(!isset($_SESSION['id'])){
        header("Location:login.php");
    }
    include "add.php";
    if($_SERVER['REQUEST_METHOD']=='POST'){//Récuperer les valeurs du form
        $client     = $_POST['client'];
        $categorie  = $_POST['cat'];
        $usage      = $_POST['usage'];
        $km         = $_POST['km'];
        $marque     = $_POST['marque'];
        $model      = $_POST['model'];
        $annee      = $_POST['annee'];
        $vit        = $_POST['vit'];
        $chev       = $_POST['chev'];
        $carb       = $_POST['carb']; 
        $mat        = $_POST['mat'];
        $permis     = $_POST['permis'];
        $Cgris      = $_POST['crt-gris'];       
        
        $sql = 'INSERT INTO formv 
                (idF,categorie,formv.usage,km,marque,model,annee,matricule,permis,vitesse,cheveaux,Carbirant,carteGris) 
                VALUES  (?,?,?,?,?,?,?,?,?,?,?,?,?)';
        $req=$cnx->prepare($sql);
        $req->execute(array($client,$categorie,$usage,$km,$marque,$model,$annee,$mat,$permis,$vit,$chev,$carb,$Cgris));
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
                    <div class="form-group col-md-4">
                            <select class='form-control'  required name='cat'>
                                <option value="" disabled selected> Catégorie </option>
                                <option value="Auto">Auto </option>
                                <option value="Moto">Moto </option>
                                <option value="Camion">Camion </option>
                            </select>
                    </div>
                    <div class="form-group col-md-4">
                            <select class='form-control'  required name='usage'>
                                <option value="" disabled selected> Usage </option>
                                <option value="Personnel">Personnel </option>
                                <option value="Profesionnel">Profesionnel </option>
                                <option value="Travail">Travail </option>
                                <option value="Tournée réguliére">Tournée réguliére </option>
                            </select>
                    </div>
                    <div class="form-group col-md-4">
                        <input type="number" class="form-control" placeholder="killométrage" min="0" name="km" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <input type="text" class="form-control" placeholder="Marque" name="marque" required>
                    </div>
                    <div class="form-group col-md-4">
                        <input type="text" class="form-control" placeholder="Model" name="model" required>
                    </div>
                    <div class="form-group col-md-4">
                        <input type="text" class="form-control" placeholder="Année" name="annee" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <input type="text" class="form-control" placeholder="Vitesse" name="vit" required>
                    </div>
                    <div class="form-group col-md-4">
                        <input type="text" class="form-control" placeholder="Cheveaux" name="chev" required>
                    </div>
                    <div class="form-group col-md-4">
                        <input type="text" class="form-control" placeholder="Carbirant" name="carb" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <input type="text" class="form-control" placeholder="Matricule" name="mat" required>
                    </div>
                    <div class="form-group col-md-4">
                        <input type="text" class="form-control" placeholder="Permis" name="permis" required>
                    </div>
                    <div class="form-group col-md-4">
                        <input type="text" class="form-control" placeholder="Carte gris" name="crt-gris" required>
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
