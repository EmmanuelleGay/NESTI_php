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
<p><?php

        echo $vars['loggedInUser']->getFirstName();

        ?></p>

        <a href="$vars['baseUrl'] ?>users/logout"></a>
          
        </ul>
      </div>
    </div>
  </nav>

    <p></p>

<a href="" title="se déconnecter" class="text-center">
<img src="../public/photo/deconnexion.png" alt="bouton deconnexion" class="bouton_deconnexion mb-sm-3">
</div>