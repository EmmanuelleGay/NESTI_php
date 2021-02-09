<header class="d-flex justify-content-between">

  <nav class="navbar navbar-expand-lg w-75 pt-3 pb-3">
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav w-100 justify-content-around ">
        <li class="nav-item btn btn-nav">
          <a class="nav-link white active" aria-current="page" href="<?= $vars['baseUrl'] ?>recipe">
            <i class="fas fa-clipboard-list white"></i>
            Recettes</a>
        </li>

        <li class="nav-item btn btn-nav">
          <a class="nav-link white" href="<?= $vars['baseUrl'] ?>article">
            <i class="fas fa-utensils white"></i>
            Articles</a>
        </li>
        <li class="nav-item btn btn-nav">
          <a class="nav-link white" href="<?= $vars['baseUrl'] ?>users">
            <i class="fas fa-users white"></i>
            Utilisateurs</a>
        </li>
        <li class="nav-item btn btn-nav">
          <a class="nav-link white" href="<?= $vars['baseUrl'] ?>statistics">
            <i class="fas fa-chart-bar white"></i>
            Statistiques
          </a>
        </li>
      </ul>
    </div>
  </nav>
  <div>
    <div class="nav-link mt-3">
      <i class="far fa-user"></i>
      <?php
      echo  $vars['loggedInUser']->getFirstName() . " " .  $vars['loggedInUser']->getLastName();
      ?>
    </div>
  </div>
  <div>

    <a class="nav-link mt-3" href="<?= $vars['baseUrl'] ?>users/logout">
      <i class="fas fa-sign-out-alt"></i>
      Déconnexion</a>
  </div>

</header>