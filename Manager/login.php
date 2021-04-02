<?php 
    session_start();
    $navbar='';
    if(isset($_SESSION['id'])){
        header("Location:dashboard.php");
    }
    include "add.php";
    if($_SERVER['REQUEST_METHOD']=='POST'){
        $email  = $_POST['email'];
        $pass   = $_POST['password'];
        $error="";
        if(!empty($email) && !empty($pass)){
            $sql    = "SELECT * FROM user WHERE email=? AND password=? AND groupID= '1'";
            $req    = $cnx->prepare($sql);
            $req->execute(array($email,$pass));
            $row    = $req->fetch();
            $count  = $req->rowcount();
            if($count == 0){
               echo '
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
    }
?>
<div class="container"><div class="row mt-5">
    <div class="col-md-6 mx-auto">
        <div class="card"><div class="card-body">
            <h1 class="text-center"><span class="text-primary">
                <i class="fa fa-lock" aria-hidden="true"></i> Login
            </span></h1>
            <form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
                <div class="form-group">
                    <label for="email">Adresse Email :</label>
                    <input type="text" id="email" name="email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="pass">Mot de passe :</label>
                    <input type="password" id="pass" name="password" class="form-control" required>
                </div>
                <input class="btn btn-primary btn-block"  type="submit" value="Connexion">
                <button type="button" class="btn btn-link btn-block">Mot de passe oublié !</button>
                </form>
        </div></div>
    </div>
</div></div>
<script type="text/javascript">
        function testPass() {
            var email = document.getElementById("email").value;
            var passwrd = document.getElementById("pass").value;
            var creds = "email="+email+"&passwd="+passwrd;
            var ajx = new XMLHttpRequest();
            ajx.onreadystatechange = function () {
                if (ajx.readyState == 4 && ajx.status == 200) {
                    console.log(ajx.responseText);
                }
            };
            ajx.open("POST", "login.php", true);
            ajx.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            ajx.send(creds);
        }
    </script>
<?php
    include "Include/template/footer.php";
?>