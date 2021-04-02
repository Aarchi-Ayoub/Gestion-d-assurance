<?php 
    session_start();
    include 'add.php';
    $sql    = "SELECT distinct user.* , form.paye , form.reste FROM user,form WHERE user.idUser = form.idClt AND GroupID =0 ORDER BY idUser DESC LIMIT 10";       
    $req    = $cnx->prepare($sql);
    $req->execute();
    $rows    = $req->fetchAll();
    
    echo '<div class="mt-4 row container row-cols-2 ml-2 mr-1 row-cols-md-5">';
    foreach($rows as $row){
?>
<!-- Afficher les admins --> 
<div class="col mt-1 mb-4"><div class="card h-100 info-admin">
    <img src="Upload/avatar/<?php  if(!empty($row['Avatar'])){echo $row['Avatar'];}else{echo "unknow.jpg";} ?>" class="card-img-top" alt="Profile pictur" id="profile-img">
    <div class="card-body text-center">
        <h5 class="card-title"><?php echo $row['Nom']." ".$row['Prenom'];?></h5>
        <?php if($row['Activate']==0){//Activate
        echo  ' <a role="button" id="activate" href="?dir=activate&id='.$row["idUser"].'" class="btn btn-success">
                        <i class="fa fa-thumbs-up" aria-hidden="true"></i> 
                </a>';
        } ?>
    </div> 
</div></div>
<?php
    }
    echo '</div></div>';



    include "Include/template/footer.php";
