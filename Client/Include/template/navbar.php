<nav class="navbar navbar-expand-sm navbar-dark bg-success">
    <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#collapsibleNavId" aria-controls="collapsibleNavId"
        aria-expanded="false" aria-label="Toggle navigation"><i class="fa fa-openid" aria-hidden="true"></i></button>
    <div class="collapse navbar-collapse" id="collapsibleNavId">
        <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="users.php?dir=profile&id=<?php echo $_SESSION['id']?>">
                    <?php echo  $_SESSION['nom']." ". $_SESSION['prenom']?>
                </a>
            </li>  
            <li class="nav-item">
                <a class="nav-link" href="dashboard.php">Acceuil</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="contract.php">Mes contrats</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="comments.php">Commentez</a>
            </li>
        </ul>
        <li class="nav-item">
            <a class="nav-link" href="users.php?dir=setting&id=<?php echo $_SESSION['id']?>"><i class="fa fa-cogs" aria-hidden="true"></i> Paramètres</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i> Quitter</a>
        </li>
        </ul>
        
    </div>
</nav>