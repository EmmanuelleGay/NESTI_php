<div class="container d-flex">

  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="<?= $vars['baseUrl'] ?>recipe">Recettes</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?= $vars['baseUrl'] ?>article">Articles</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?= $vars['baseUrl'] ?>users">Utilisateurs</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?= $vars['baseUrl'] ?>statistics">Statistiques</a>
          </li>
          <li class="nav-item">
            <p class="nav-link"><?php
                                echo  $vars['loggedInUser']->getFirstName() . " " .  $vars['loggedInUser']->getLastName();
                                ?></p>

          <li class="nav-item">
            <a class="nav-link" href="<?= $vars['baseUrl'] ?>users/logout">Déconnexion</a>
          </li>

        </ul>
      </div>
    </div>
  </nav>
</div>