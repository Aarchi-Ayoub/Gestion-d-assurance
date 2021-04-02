<div class="container"><div class="row mt-5">
    <div class="col mx-auto">
        <div class="card"><div class="card-body">
            <form class="insert" action="" method="POST">
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <select class='form-control'  required name='client'>
                            <option value="" disabled selected>Nom Prénom </option>
                            <?php 
                                $sql="SELECT * from user where GroupId = 0";
                                $req=$cnx->prepare($sql);
                                $req->execute();
                                $rows=$req->fetchAll();
                                foreach($rows as $row)
                                {
                                    echo '<option value="'.$row['idUser'].'">'.$row['Nom'].' '.$row['Prenom'].'</option>';
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Début :</label>
                        <input type="date" name="debut" class="form-control" name="dateFrom" value="<?php echo date('Y-m-d'); ?>" />
                    </div>
                    <div class="form-group col-md-6">
                        <label>Fin :</label>
                        <input type="date" class="form-control"  name="fin" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Payé  :</label>
                        <input type="number" class="form-control" required placeholder="0000.00 MAD" min="0" name="paye" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Reste :</label>
                        <input type="number" class="form-control" placeholder="0000.00 MAD" min="0" name="reste" required>
                    </div>
                </div>
                <div class="form-group text-right">
                    <button class="btn btn-primary" id="insert">Ajouter</button>
                </div>
            </form>
        </div></div>
    </div>
</div></div>
<?php
    if($_SERVER['REQUEST_METHOD']=='POST'){//Récuperer les valeurs
        $respo  = $_SESSION['id'];
        $client = $_POST['client'];
        $debut  = date('Y-m-d',  strtotime($_POST['debut']));
        $fin    = date('Y-m-d',  strtotime($_POST['fin']));
        $paye   = $_POST['paye'];
        $reste  = $_POST['reste'];
        //ID de l'assur
        $idAsr  = idAsr($type);
        //Appliquer la modification
        $sql = 'INSERT INTO form (idAsr,idClt,idRes,debut,fin,paye,reste) 
                VALUES  ('.$idAsr.','.$client.','.$respo.','.$debut.','.$fin.','.$paye.','.$reste.')';
        $req=$cnx->prepare($sql);
        $req->execute();
        header('Refresh:0,url=form'.$type.'.php');
        exit();
        
    }
?>