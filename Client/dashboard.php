<?php
    session_start();
    if(!isset($_SESSION['id'])){
        header("Location:login.php");
    }else{
        include "add.php";
?><br/>
<div class="container">
<?php
    $sql    = "SELECT * FROM user WHERE idUser=". $_SESSION['id']." ";
    $req    = $cnx->prepare($sql);
    $req->execute();
    $row    = $req->fetch();
    if($row['Tel'] == null && $row['Adresse'] == null ){    
?>
    <div class="col-md-9 mt-4 mx-auto"><div class="alert alert-info">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            Vous devez remplisser le formulaire par le reste de vos information !    
        </div></div><?php } require "product.php";?>
</div>
    









<?php        
        include "Include/template/footer.php";
    }
?>