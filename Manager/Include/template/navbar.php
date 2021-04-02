<nav class="navbar navbar-expand-lg navbar-light navbar-light" style="background-color: #e3f2fd;">  
    <div class="collapse navbar-collapse" id="navbarNav">  
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
                <a class="nav-link" href="admins.php">Admins</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="clients.php">Clients</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="state.php">Statistiques</a>
            </li>
        </ul>
    </div>
    <ul class="nav navbar-nav justify-content-end">
        <li class="nav-item">
            <a class="nav-link" href="users.php?dir=setting&id=<?php echo $_SESSION['id']?>"><i class="fa fa-cogs" aria-hidden="true"></i> Réglages</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i> Quittez</a>
        </li>
    </ul>
</nav>