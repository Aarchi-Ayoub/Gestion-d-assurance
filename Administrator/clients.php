<?php 
    session_start();
    if(!isset($_SESSION['id'])){
        header("Location:login.php");
    }else{
        include 'add.php';
        //Diviser l'url pour avoir l'action
        $direction=isset($_GET['dir'])? $_GET['dir'] :'';
        if($direction == 'activate'){
            //Récupérer l'id passer depuis l'url
            $userid=isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;
            $sql='UPDATE user SET Activate = 1, updated = ? WHERE idUser = ?';
            $req=$cnx->prepare($sql);
            $req->execute(array(date("Y-m-d H:i:s"),$userid));
            header('Refresh:0,url=clients.php');
            exit();
        }elseif($direction == 'delete'){
            //Récupérer l'id passer depuis l'url
            $userid=isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;
            $sql='DELETE FROM user WHERE idUser = '.$userid.'';
            $req=$cnx->prepare($sql);
            $req->execute();
            header('Refresh:0,url=clients.php');
            exit();
        }elseif($direction == 'cmt'){
            //Récupérer l'id passer depuis l'url
            $userid=isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;
            $sql = "SELECT comment.*,offer.description 
                    FROM user,comment,offer
                    WHERE user.idUser = comment.idClt
                    AND offer.idOfr = comment.idOfr 
                    AND idUser = $userid
                    ORDER BY idCmt DESC";
            $req    = $cnx->prepare($sql);
            $req->execute();
            $rows    = $req->fetchAll();
            if(!$rows){
                echo '<div class="container mt-3"><h1 class="text-center">Comments List</h1><div class="alert alert-secondary" role="alert">
                Pas de commentaire pour le moment !
                </div></div>';
            }else{
                echo '<div class="container mt-3"><h1 class="text-center">Comments List</h1>';
                foreach($rows as $row){ 
                    echo '<div class="card mb-2"><div class="card-body cmt">';
                    echo '<b>'.$row['description'].'</b>';
                    echo '<p>'.$row['cmt'].'</p>'; 
                    echo '</div></div>';
                }
                echo '</div>';
            }
        }elseif($direction == 'add'){
?>
<!-- Form add admins -->
<!-- Form pour modifier les données personnels -->
<div class="container"><div class="row mt-5">
    <div class="col mx-auto">
        <div class="card"><div class="card-body">
            <h1 class="text-center"><span class="text-primary">
                <i class="fa fa-user" aria-hidden="true"></i>  Ajouter un clients
            </span></h1>
            <form class="insert" action="?dir=Insert" method="POST">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <input type="text" class="form-control" placeholder="Nom" name="nom" id="nom" required>
                    </div>
                    <div class="form-group col-md-6">
                        <input type="text" class="form-control" placeholder="Prénom" name="prenom" id="prenom" required>
                    </div>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Adresse electronique" name="email" id="email" required >
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="tel" id="tel" placeholder="Téléphone"  required maxlength="10">
                </div>
                <div class="form-group">
                    <textarea name="adresse" id="adresse" class="form-control" cols="30" placeholder="Adresse locale" rows="4"></textarea>
                </div>
                <div class="form-group text-right">
                    <button class="btn btn-primary" id="insert">Ajouter</button>
                </div>
            </form>
        </div></div>
    </div>
</div></div>
<?php            
        }elseif($direction == 'Insert'){//Insérer dans la base
            //Récupérer les données des inputs
            if($_SERVER['REQUEST_METHOD']=='POST'){
                $nom     = $_POST['nom'];
                $prenom  = $_POST['prenom'];
                $email   = $_POST['email'];
                $tel     = $_POST['tel'];
                $adresse = $_POST['adresse'];
                $pass    = $nom.'@'.$prenom;
                //Appliquer la modification
                $sql='INSERT INTO user (Nom,Prenom,Email,Tel,Adresse,Password,GroupId,Activate,Added) VALUES  (:nom,:pre,:ema,:tel,:adrs,:pass,0,1,now())';
                $req=$cnx->prepare($sql);
                $req->execute(array(
                    'nom'   => $nom,
                    'pre'   => $prenom,
                    'ema'   => $email,
                    'tel'   => $tel,
                    'adrs'  => $adresse,
                    'pass'  => $pass
                ));
                header('Refresh:0,url=clients.php');
                exit();
            }
        }
        elseif($direction == ''){
?>
    <h1 class="display-2 admin-title text-center text-secondary">Liste des clients</h1>
    <div class="container">
<!-- Ajouter un admins -->    
<div class="row ml-4 mt-4">
    <div class="col md-4 ">
        <a role="button" href="?dir=add" class="btn btn-primary">
            <i class="fa fa-plus" aria-hidden="true"></i> Ajouter un client
        </a>    
    </div>
    <form class="form-inline" action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
        <input class="form-control mr-sm-2" type="text" placeholder="Search" name="search">
        <button class="btn btn-light" type="submit"><i class="fa fa-search"></i></button>
    </form>
    <div class="col md-4 mr-5">
        <h4 class="text-right admin-count">Total :
<?php
    //Récuperer les admins et les afficher
    $rows   = byOrder('user','*','GroupID','0','idUser');
    //Récuperer le count
    $col    = returnCount('user','*','GroupID','0');
    //Search
    if($_SERVER['REQUEST_METHOD']=='POST'){//Récuperer la valeur de search
        $search = $_POST['search'];
        $sql    = "SELECT * FROM user WHERE Nom LIKE('%$search%') OR Prenom LIKE('%$search%') AND GroupID = 0";      
        $req    = $cnx->prepare($sql);
        $req->execute();
        $rows    = $req->fetchAll();
        $sql    = "SELECT COUNT(*) FROM user WHERE Nom LIKE('%$search%') OR Prenom LIKE('%$search%') AND GroupID = 0";
        $req    = $cnx->prepare($sql);
        $req->execute();
        $col    = $req->fetchColumn();
    }
    //Afficher par order
    $show   = isset($_GET['show'])? $_GET['show'] :'';
    switch($show){
        case 'rec' : $rows    = byOrder('user','*','GroupID','0','idUser','ASC');
    break;
        case 'old' : $rows    = byOrder('user','*','GroupID','0','idUser');;
    break;
        case 'des' : $rows    = activate('0','0'); $col    = returnCountActivate('user','*','GroupID','0','0'); 
    break;
        case 'act' : $rows    = activate('1','0');  $col    = returnCountActivate('user','*','GroupID','0','1'); 
    break;
    }
    //Count des clients
        echo $col;
?>      </h4>
    </div>
</div>
<div class="col md-4 mr-5">
        <div class="col-md-12 text-center show-option">
            <a href="?show=rec" class="<?php if($show == 'rec'){echo 'active';} ?>">recent</a> |
            <a href="?show=old" class="<?php if($show == 'old'){echo 'active';} ?>">ancien</a> |
            <a href="?show=des" class="<?php if($show == 'des'){echo 'active';} ?>">deactivé</a> |
            <a href="?show=act" class="<?php if($show == 'act'){echo 'active';} ?>">activé</a> 
        </div>
</div>
<?php
        if($rows){
            echo '<div class="mt-4 row container row-cols-2 ml-2 mr-1 row-cols-md-5">';
            foreach($rows as $row){
?>
<!-- Afficher les admins --> 
        <div class="col mt-1 mb-4"><div class="card h-100 info-admin">
            <img src="../Upload/avatar/<?php  if(!empty($row['Avatar'])){echo $row['Avatar'];}else{echo "unknow.jpg";} ?>" class="card-img-top" alt="Profile pictur" id="profile-img">
            <div class="card-body text-center">
                <h5 class="card-title"><?php echo $row['Nom']." ".$row['Prenom'];?></h5>
                <?php if($row['Activate']==0){//Activate
                echo  ' <a role="button" id="activate" href="?dir=activate&id='.$row["idUser"].'" class="btn btn-success">
                                <i class="fa fa-thumbs-up" aria-hidden="true"></i> 
                        </a>';
                } ?><!-- Send Email -->
                <a role="button" href="mailto:<?php echo $row['Email'];?>" class="btn btn-primary">
                    <i class="fa fa-envelope-o" aria-hidden="true"></i> 
                </a><!-- Delete -->
                <a role="button" id="delete" href="?dir=delete&id=<?php echo $row['idUser'];?>" class="btn btn-danger">
                    <i class="fa fa-thumbs-down" aria-hidden="true"></i> 
                </a>
                </a><!-- Comment -->
                <a role="button" id="delete" href="?dir=cmt&id=<?php echo $row['idUser'];?>" class="btn btn-secondary">
                    <i class="fa fa-comment" aria-hidden="true"></i>
                </a>
            </div> 
        </div></div>
<?php
            }
            echo '</div></div>';
        }
        echo '</div>';
        }else{
            echo '<div class="container"><div class="alert mt-5 alert-danger" role="alert">
                    Url non-valid!
                 </div></div>';
        }
        include "Include/template/footer.php";
    }
?>
