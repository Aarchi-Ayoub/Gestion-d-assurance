<nav class="navbar navbar-expand-lg  navbar-dark bg-dark">
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="clients.php">Clients</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="operations.php">Produits</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="state.php">Operations</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="cmt.php">Commentaires</a>
      </li>
    </ul>
  </div>
  <ul class="nav navbar-nav justify-content-end">
        <li class="nav-item">
            <a class="nav-link" href="profile.php"><i class="fa fa-user-circle" aria-hidden="true"></i></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="profile.php?dir=setting&id=<?php echo $_SESSION['id']?>"><i class="fa fa-cogs" aria-hidden="true"></i></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i></a>
        </li>
    </ul>
</nav>