<header class="d-flex justify-content-between">

  <nav class="navbar navbar-expand-lg w-75 pt-3 pb-3">

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <i class="fas fa-bars"></i>
    </button>

    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav w-100 justify-content-around ">
        <li class="nav-item">
          <a class="nav-link btn-nav white text-center" aria-current="page" href="<?= $vars['baseUrl'] ?>recipe">
            <i class="fas fa-clipboard-list white"></i>
            Recettes</a>
        </li>

        <li class="nav-item">
          <a class="nav-link btn-nav white text-center" href="<?= $vars['baseUrl'] ?>article">
            <i class="fas fa-utensils white"></i>
            Articles</a>
        </li>
        <li class="nav-item">
          <a class="nav-link btn-nav white text-center" href="<?= $vars['baseUrl'] ?>users">
            <i class="fas fa-users white"></i>
            Utilisateurs</a>
        </li>
        <li class="nav-item">
          <a class="nav-link btn-nav white text-center" href="<?= $vars['baseUrl'] ?>statistics">
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