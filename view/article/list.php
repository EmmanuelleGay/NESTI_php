<div class="container">

    <h1 class="h1">Articles</h1>

    <form class="d-flex">
        <button class="btn btn-outline-success" type="submit">LOUPE</button>
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
    </form>

    <a href="">Commandes</a>
    <a href="">Importer</a>

    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Nom</th>
                <th scope="col">Prix de vente</th>
                <th scope="col">Type</th>
                <th scope="col">Dernière importation</th>
                <th scope="col">Stock</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>

            <?php foreach ($vars['entities'] as $article) { ?>
                <tr>
                    <td><?= 
                    
                    $article->getId(); ?></td>
                    <td>NAME</td>
                    <td><?= $article->getArticlePrices()->getPrice(); ?></td>
                    <td>TYPE</td>
                    <td><?= $article->getDateModification(); ?></td>

                    <td><?php
                        $recipe->getChef();
                    } ?></td>
                    <td>
                        <div class="d-flex flex-column">
                            <a href="<?=
                                        //TODO AJOUTER L'ID DANS L'ADRESSE POUR LA MODIF
                                        $vars['baseUrl'] ?>recipe/edit">Modifier</a>

                            <a href="<?= $vars['baseUrl'] ?>recipe/delete">Supprimer</a>
                        </div>
                    </td>

                </tr>

        </tbody>
    </table>


</div>