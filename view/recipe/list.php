<div class="container">

    <h1 class="h1">Recettes</h1>


    <form class="d-flex">
        <button class="btn btn-outline-success" type="submit">LOUPE</button>
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
    </form>

    <a href="">Ajouter</a>

    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Nom</th>
                <th scope="col">Difficulté</th>
                <th scope="col">Pour</th>
                <th scope="col">Temps</th>
                <th scope="col">Chef</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>

            <?php foreach ($vars['entities'] as $recipe) { ?>
                <tr>
                    <td><?= $recipe->getId(); ?></td>
                    <td><?= $recipe->getName(); ?></td>
                    <td><?= $recipe->getDifficulty(); ?></td>
                    <td><?= $recipe->getPortions(); ?></td>
                    <td><?= $recipe->getPreparationTime(); ?></td>

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