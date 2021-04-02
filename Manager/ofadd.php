<?php
    if($_SERVER['REQUEST_METHOD']=='POST'){
        $asr    = $_POST['Asr'];
        $desc   = $_POST['desc'];
        $tarif  = $_POST['tarif'];

        $sql = "INSERT INTO offer(idAsr,description,tarif) VALUES(?,?,?)";
        $req=$cnx->prepare($sql);
        $req->execute(array($asr,$desc,$tarif));
        
    }
?>
<form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
    <div class="form-group">
        <select name="Asr" class="form-control">
        <option value="" disabled selected>Assurance </option>
            <?php 
                $sql="SELECT * from insurance";
                $req=$cnx->prepare($sql);
                $req->execute();
                $rows=$req->fetchAll();
                foreach($rows as $row)
                {
                    echo '<option value="'.$row['idAsr'].'">'.$row['Nom'].'</option>';
                }
            ?>
        </select>
    </div>
    <div class="form-row">
        <div class="col">
            <input type="text" name="desc" placeholder="Description" class="form-control">
        </div>
        <div class="col">
            <input type="text" name="tarif" placeholder="Tarif" class="form-control">
        </div>
    </div>
    <button class="btn btn-primary float-right mt-2" id="insert">Create</button>
</form>
