<?php 
    session_start();
    $navbar='';
    $error="";
    if(isset($_SESSION['id'])){
        header("Location:dashboard.php");
    }
    include "add.php";
    if($_SERVER['REQUEST_METHOD']=="POST"){
        /** LOGIN **/
        if(isset($_POST['cnx'])){
            /** Récupérer les infos */
            $email  = $_POST['mail'];
            $pass   = $_POST['pass'];
            if(!empty($email) && !empty($pass)){
                $sql    = "SELECT * FROM user WHERE email=? AND password=? AND groupID= '0'";
                $req    = $cnx->prepare($sql);
                $req->execute(array($email,$pass));
                $row    = $req->fetch();
                $count  = $req->rowcount();
                if($count == 0){
                    $error= '
                <br/><div class="container"><div class="col-md-6 mx-auto"><div class="alert alert-danger">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    Email address or Password invalid !    
                </div></div></div>';
                }else{
                    $_SESSION['id'] = $row['idUser'];
                    $_SESSION['nom'] = $row['Nom'];
                    $_SESSION['prenom'] = $row['Prenom'];
                    header("Location:dashboard.php");
                    exit();
                }
            }
        }else{
            /** SingIN */
            $nom    = $_POST['nom'];
            $pre    = $_POST['pre'];
            $email  = $_POST['email'];
            $pass1  = $_POST['pass1'];
            $pass2  = $_POST['pass2'];
            if(empty($pass1) || empty($pass2) ){
                $error= '
                <br/><div class="container"><div class="col-md-6 mx-auto"><div class="alert alert-danger">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    Les  mots de passes ne peuvent pas être vides !    
                </div></div></div>';
            }elseif( $pass1 !== $pass2){
                $error = '
                <br/><div class="container"><div class="col-md-6 mx-auto"><div class="alert alert-danger">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    Les 2 mots de passes ne se conviennt pas !    
                </div></div></div>';
            }
            else{
                $nom=filter_var($nom,FILTER_SANITIZE_STRING);
                $pre=filter_var($pre,FILTER_SANITIZE_STRING);
                $email=filter_var($email,FILTER_SANITIZE_EMAIL);
                if(empty($nom) && empty($pre) && empty($email) ){
                    $error = '
                    <br/><div class="container"><div class="col-md-6 mx-auto"><div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        Aucun chapms ne doit être vide !    
                    </div></div></div>';
                }else{
                    $sql='INSERT INTO user (Nom,Prenom,Email,Password,GroupId,Activate,Added) VALUES  (:nom,:pre,:ema,:pass,0,0,now())';
                    $req=$cnx->prepare($sql);
                    $req->execute(array(
                        'nom'   => $nom,
                        'pre'   => $pre,
                        'ema'   => $email,
                        'pass'  => $pass2
                    ));
                    $sql    = "SELECT * FROM user WHERE email=? AND password=? AND groupID= '0'";
                    $req    = $cnx->prepare($sql);
                    $req->execute(array($email,$pass2));
                    $row    = $req->fetch();
                    $_SESSION['id'] = $row['idUser'];
                    $_SESSION['nom'] = $row['Nom'];
                    $_SESSION['prenom'] = $row['Prenom'];
                    header("Location:dashboard.php");
                    exit();
                }
            }
        }
    }
?>
<div class="container">
    <div class="body-page">
        <h1 class="text-center mt-3">
            <span class="text-primary">Inscription</span> - <span class="text-success">Connexion</span>     
        </h1>
        <!--Login Start-->
        <div class="cnx my-5">
            <div class="frm-cnx col-md-6 mx-auto">
            <form class="cnx" action="<?php $_SERVER['PHP_SELF']?>" method="POST">
                <div class="form-group row">
                    <label for="mail" class="col-sm-4 col-form-label">Email :</label>
                    <div class="col-sm-8">
                        <input type="email" class="form-control" required name="mail" id="mail">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="pass" class="col-sm-4 col-form-label">Mot de passe :</label>
                    <div class="col-sm-8">
                        <input type="password" class="form-control" required name="pass" id="pass">
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-sm-4"></div>
                    <div class="col-sm-8">
                        <input type="submit" name="cnx" value="Connexion" class="btn btn-primary btn-block">
                    </div>
                </div>
            </form>
            </div>
        </div>
        <!--Login End-->
        <!--Sing In Start-->
        <div class="ins my-5">
            <div class="frm-ins col-md-6 mx-auto">
            <form class="ins" action="<?php $_SERVER['PHP_SELF']?>" method="POST">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="nom">Nom :</label>
                        <input type="text" class="form-control" id="nom" name="nom">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="pre">Prénom :</label>
                        <input type="text" class="form-control" id="pre" name="pre">
                    </div>
                </div>
                <div class="form-row">
                    <label for="email">Email :</label>
                    <div class="form-group col-md-12">
                        <input type="email" class="form-control" id="email" name="email">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="pass1">Mot de passe :</label>
                        <input type="password" class="form-control" id="pass1" name="pass1">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="pass2">Répéter le mot de passe :</label>
                        <input type="password" class="form-control" id="pass2" name="pass2">
                    </div>
                </div>
                <div class="form-row">
                 <input type="submit" class="btn btn-success btn-block" value="Inscription" name="ins">
                </div>
            </form>
            </div>
        </div>
        <!--Sing In End-->
        <?php echo $error;?>
    </div>
</div>

<?php
    include "Include/template/footer.php";
?>
