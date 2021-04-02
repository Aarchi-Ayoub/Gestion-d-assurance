<?php
        if(isset($_POST['btn'])){
        $ofr = $_POST['offer'];
        $req = $cnx->prepare("DELETE FROM offer WHERE idOfr  = $ofr");
        $req->execute();
        header('Location:dashboard.php');
        exit();
    }
?>
<div class="container">
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
    <div class="form-row">
        <div class="form-group col-md-12">
            <select class='form-control'  required name='offer'>
                <option value="" disabled selected>Offer </option>
                <?php 
                    $req  = $cnx->prepare("SELECT * FROM offer");
                    $req->execute();
                    $rows = $req->fetchAll();
                    foreach($rows as $row){
                    echo '
                        <option value="'.$row['idOfr'].'">'
                        .$row['description']
                        .'</option>';
                    } 
                ?>
            </select>
        </div>
    </div>
    <input type="submit" value="Delete" name="btn" class="btn btn-danger float-right mt-2">
    </form>
</div>