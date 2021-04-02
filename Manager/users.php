<?php 
    session_start();
    if(!isset($_SESSION['id'])){
        header("Location:login.php");
    }else{
        include 'add.php';
        //Stocker l'id
        $userID = $_SESSION['id'];
        //Diviser l'url pour avoir l'action
        $direction=isset($_GET['dir'])? $_GET['dir'] :'';
        if($direction == 'profile'){
            //Récuperer les informations
            $row    = returnAllResultat('user','idUser',$userID);
?>
<!-- Afficher les infos-->
    <div class="container"><div class="row mt-2">
    <div class="col-md-6 mx-auto">
    <div class="card pt-2">
        <img src="../Upload/avatar/<?php  if(!empty($row['Avatar'])){echo $row['Avatar'];}else{echo "unknow.jpg";} ?>"  id="profile-img" class="card-img-top" alt="...">
        <div class="card-body text-center">
        <h5 class="card-title "><?php echo $row['Nom']." ".$row['Prenom']?></h5>
        <p class="card-text"><?php echo $row['Email']."<br>".$row['Tel']."<br>".$row['Adresse']?></p>
        <p class="card-text text-right"><small class="text-muted">Added on :<?php echo $row['Added']?></small><br><small class="text-muted">Updated on :<?php echo $row['Updated']; ?></small></p>
        <a href="users.php?dir=edit&id=<?php echo $_SESSION['id']?>" class="btn btn-warning"><i class="fa fa-pencil" aria-hidden="true"></i> Edit information</a>
    </div>
    </div></div>
    </div>
<?php   }elseif($direction == 'edit'){
            //Récuperer les informations
            $row    = returnAllResultat('user','idUser',$userID);
?>
<!-- Form pour modifier les données personnels -->
    <div class="container"><div class="row mt-5">
    <div class="col-md-6 mx-auto">
        <div class="card"><div class="card-body">
            <h1 class="text-center"><span class="text-primary">
                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>  Edit profile
            </span></h1>
            <form action="?dir=Update" method="POST" enctype="multipart/form-data">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <input type="text" class="form-control" value="<?php echo $row['Nom']?>" name="nom" required>
                    </div>
                    <div class="form-group col-md-6">
                        <input type="text" class="form-control" value="<?php echo $row['Prenom']?>" name="prenom" required>
                    </div>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" value="<?php echo $row['Email']?>" name="email" required >
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="tel" value="<?php echo $row['Tel']?>" required maxlength="10">
                </div>
                <div class="form-group">
                    <textarea name="adresse" class="form-control" cols="30" rows="4"><?php echo $row['Adresse']?></textarea>
                </div>
                <div class="form-group">
                    <input type="file" class="form-control-file" name="file">                    
                </div>
                <div class="form-group text-right">
                    <button type="rest" class="btn btn-link"><i class="fa fa-check-circle text-success" style="font-size:35px" aria-hidden="true"></i> </button>
                </div>
            </form>
        </div></div>
    </div>
</div></div>
<?php        
    }elseif($direction == 'Update'){//Appliquer la modification
        //Récupérer les données des inputs
        if($_SERVER['REQUEST_METHOD']=='POST'){
            $nom     = $_POST['nom'];
            $prenom  = $_POST['prenom'];
            $email   = $_POST['email'];
            $tel     = $_POST['tel'];
            $adresse = $_POST['adresse'];
            $avatar  = $_FILES['file'];
            //Upload attributs
            $avNom   = $_FILES['file']['name'];
            $avTmp   = $_FILES['file']['tmp_name'];
            $avTyp   = $_FILES['file']['type'];
            $avsiz   = $_FILES['file']['size'];
            //Non-télecharger
            if(!empty($avNom)){
                $avExt   = explode('.',$avNom);
                $avExt   = strtolower(end($avExt));
                if(!in_array($avExt,array('jpeg','jpg','png'))){
                $status = 0;
                echo '
                <div class="container mt-4 alert alert-danger">
                    <strong>Alert message :</strong><br> Extenstion not allowed to use
                </div>
                ';
                header("Refresh:3;url=users.php?dir=profile&id=".$_SESSION['id']);
                }else{
                    //Donner nom à la photo telecharger
                    $avName = $nom.'-'.$prenom.'-'.rand(0,1000000).'_'.$avNom;
                    move_uploaded_file($avTmp,'..\Upload\avatar\\'.$avName);
                    //Appliquer la modification
                    $sql='UPDATE user SET nom = ?,prenom = ?,email = ?,tel = ?,adresse = ?,updated = ?,avatar = ? WHERE idUser = ?';
                    $req=$cnx->prepare($sql);
                    $req->execute(array($nom,$prenom,$email,$tel,$adresse,date("Y-m-d H:i:s"),$avName,$userID));
                    header("Refresh:0;url=users.php?dir=profile&id=".$_SESSION['id']);
                    exit();
                }
            }else{
                //Appliquer la modification et garder l'ancien photo
                $sql='UPDATE user SET nom = ?,prenom = ?,email = ?,tel = ?,adresse = ?,updated = ? WHERE idUser = ?';
                $req=$cnx->prepare($sql);
                $req->execute(array($nom,$prenom,$email,$tel,$adresse,date("Y-m-d H:i:s"),$userID));
                header("Refresh:0;url=users.php?dir=profile&id=".$_SESSION['id']);
                exit();
            }
        }
    }elseif($direction == 'setting'){
        //Récuperer les informations
        $row    = returnAllResultat('user','idUser',$userID);
?>
<!--Form setting-->
<div class="container"><div class="row mt-5">
    <div class="col-md-6 mx-auto">
        <div class="card"><div class="card-body">
            <h1 class="text-center"><span class="text-secondary">
                <i class="fa fa-wrench" aria-hidden="true"></i> Change settings
            </span></h1>
            <form action="?dir=Change" method="POST">
                <div class="form-group">
                    <input type="password" class="form-control" value="<?php echo $row['Password']?>" hidden name="pass" required >
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="old" placeholder="Old password" required >
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="new" placeholder="New password" >
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="confirm" placeholder="Confirm password"  >
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-warning btn-block">Change</button>
                </div>
            </form>
        </div></div>
    </div>
</div></div>
<?php
    }elseif($direction == 'Change'){
        if($_SERVER['REQUEST_METHOD']=='POST'){
            //Récuperer les valeurs saisies
            $pass    = $_POST['pass'];
            $old     = $_POST['old'];
            $new     = $_POST['new'];
            $confirm = $_POST['confirm'];
            if($new != $confirm){//Comparer les deux mots de passes :false
                header('Refresh:2,url=users.php?dir=setting&id='. $_SESSION['id']);
                echo '<div class="alert mt-5 alert-danger alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <strong>Error :</strong> the two passwords are not alike !
            </div>';
            }else{ //Comparer les deux mots de passes :true
                $col    = returnOneColumn('user','Password','idUser',$userID);
                if($col == $old){//Comparer les deux mots de passes (saisie VS database) :true
                    $sql='UPDATE user SET password = ?,updated = ? WHERE idUser = ?';
                    $req=$cnx->prepare($sql);
                    $req->execute(array($new,date("Y-m-d H:i:s"),$userID));
                    header('Refresh:0,url=users.php?dir=setting&id='. $_SESSION['id']);
                    exit();
                }else{ //Comparer les deux mots de passes (saisie VS database) :false
                    echo '<div class="alert mt-5 alert-danger alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        <span class="sr-only">Close</span>
                    </button>
                    <strong>Error :</strong> the old password is wrong !
                    </div>';
                    header('Refresh:2,url=users.php?dir=setting&id='. $_SESSION['id']);
                }
            }
        }
     }
        include "Include/template/footer.php";
    }
?>