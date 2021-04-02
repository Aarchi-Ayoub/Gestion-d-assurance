<?php 
    session_start();
    if(!isset($_SESSION['id']))
    {
        header("Location:login.php");
    }else{
        include 'add.php';
?>        
    <h1 class="display-2 admin-title text-center text-secondary">Liste des clients</h1>
    <div class="container">
<!-- Count -->    
<div class="row ml-4 mt-4">
    <div class="col md-12 mr-5">
        <h4 class="text-right admin-count">Total :
<?php   
        //Count clients
        $col = returnCount('user','*','GroupID','0');
        //Récuperer les admins et les afficher
        $rows    = byOrder('user','*','GroupID','0','idUser');
        //Afficher par order
        $show   = isset($_GET['show'])? $_GET['show'] :'';
        switch($show){
            case 'rec' : $rows    = byOrder('user','*','GroupID','0','idUser','ASC');
        break;
            case 'old' : $rows    = byOrder('user','*','GroupID','0','idUser');;
        break;
            case 'des' : $rows    = activate('0','0'); $col    = returnCountActivate('user','*','GroupID','0','0'); 
        break;
            case 'act' : $rows    = activate('1','0'); $col    = returnCountActivate('user','*','GroupID','0','1'); 
        break;
        }
        echo $col;
?>      </h4>
    </div>
<?php
    
?>
        <div class="col-md-12 text-center show-option">
            <a href="?show=rec" class="<?php if($show == 'rec'){echo 'active';} ?>">recent</a> |
            <a href="?show=old" class="<?php if($show == 'old'){echo 'active';} ?>">ancien</a> |
            <a href="?show=des" class="<?php if($show == 'des'){echo 'active';} ?>">desactivé</a> |
            <a href="?show=act" class="<?php if($show == 'act'){echo 'active';} ?>">activé</a> 
        </div>
<?php
        //Récuperer les clients et les afficher
        if($rows){
            echo '<div class="mt-4 row container row-cols-2 ml-3 mr-1 row-cols-md-3">';
            foreach($rows as $row){
?>
    <!-- Afficher les admins --> 
        <div class="col mb-4"><div class="card h-100 info-admin">
            <div class="card-body">
            <?php if($row['Activate']==0){//Activate
                echo  ' <span class="status-activate"> Non-activé</span>';
                } 
            ?>
            <img src="../Upload/avatar/<?php  if(!empty($row['Avatar'])){echo $row['Avatar'];}else{echo "unknow.jpg";} ?>" class="card-img-top" alt="Profile pictur" id="profile-img">
                <h5 class="card-title text-center mt-1"><?php echo $row['Nom']." ".$row['Prenom'];?></h5>
            </div>
        </div></div>
<?php
            }
            echo '</div></div>';
        }else{
            echo '</div>';
            echo '<div class="alert mt-3 text-center alert-warning" role="alert">
                    <p>Aucun client dans ce groupement !</p>
                 </div>';
        }
        echo '</div>';
        include "Include/template/footer.php";
    }
?>