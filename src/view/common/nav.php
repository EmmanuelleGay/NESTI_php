<nav class="navbar navbar-expand-lg navbar-dark py-lg-4" id="mainNav">
    <div class="container">
        <a class="navbar-brand text-uppercase text-expanded font-weight-bold d-lg-none" href="#">Start Bootstrap</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav mx-auto">
            <li class="nav-item <?= ($loc=='index')?'active':''; ?> px-lg-4">
                    <a class="nav-link text-uppercase text-expanded" href="index.php?loc=index">Home
                        <span class="sr-only">(current)</span>
                    </a>
                </li>
                
                <li class="nav-item <?= ($loc=='recipe')?'active':''; ?> px-lg-4">
                    <a class="nav-link text-uppercase text-expanded" href="index.php?loc=recipe">Recettes</a>
                </li>
                <li class="nav-item <?= ($loc=='article')?'active':''; ?> px-lg-4">
                    <a class="nav-link text-uppercase text-expanded" href="index.php?loc=article">Articles</a>
                </li>
                <li class="nav-item <?= ($loc=='user')?'active':''; ?> px-lg-4">
                    <a class="nav-link text-uppercase text-expanded" href="index.php?loc=user">Utilisateurs</a>
                </li>
                <li class="nav-item <?= ($loc=='statistiques')?'active':''; ?> px-lg-4">
                    <a class="nav-link text-uppercase text-expanded" href="index.php?loc=statistiques">Statistiques</a>
                </li>
            </ul>
        </div>
    </div>
</nav>