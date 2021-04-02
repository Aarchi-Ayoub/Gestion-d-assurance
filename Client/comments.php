<?php 
    session_start();
    if(!isset($_SESSION['id'])){
        header("Location:login.php");
    }else{
        include 'add.php';
        if($_SERVER['REQUEST_METHOD']=='POST'){
            $offer  = $_POST['offer'];
            $body   = $_POST['body'];
            $sql = 'INSERT INTO comment (idClt,idOfr,cmt) 
                VALUES  (?,?,?)';
            $req=$cnx->prepare($sql);
            $req->execute(array($_SESSION['id'],$offer,$body));
            header('Refresh:0,url=comments.php');
            exit();
        }
?>
<div class="container">
    <h1 class="text-center text-warning">Laisser un commentaire</h1>
    <div class="col-md-9 mx-auto">
        <form  action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
            <div class="form-group">
                <select name="offer" class="form-control" required>
                <option value="" disabled selected> ***_Offer_*** </option>
                    <?php
                        $rows = returnAssur("offer");
                        foreach($rows as $row){
                            echo "<option value='".$row['idOfr']."'>".$row['description']."</option>";
                        }
                    ?>   
                </select>
            </div>
            <div class="form-group">
                <textarea name="body" required class="form-control" rows="5" placeholder="Text of comment"></textarea>
            </div>
            <div class="float-right">
            <input type="submit" value="Commentez" name="cmt" class="btn btn-success">
            </div>
        </form>
    </div>
</div>
<?php        
        include "Include/template/footer.php";
    }
?>