<div class="container d-flex flex-column">

    <h1 class="h1 mt-4">Recettes</h1>

    <?php
    include(__DIR__ . '/../common/searchbar.php');
    ?>

    <div class="mb-3 btn border rounded addContainer justify-content-around d-flex align-items-center align-self-end mx-5">
        <img src="<?= $vars['baseUrl'] ?>/public/images/create-svg.png" alt="add icon" id="addElement" class="addElement">
        <a class="addLink aria-label fs-4 " aria-describedby="addElement" href="<?=$vars['baseUrl'] ?>recipe/edit">Ajouter</a>
    </div>

    <table class="table table-hover table-sm">
        <thead>
            <tr>
                <th class="align-middle" scope="col">ID</th>
                <th class="align-middle" scope="col">Nom</th>
                <th class="align-middle" scope="col">Difficulté</th>
                <th class="align-middle" scope="col">Pour</th>
                <th class="align-middle" scope="col">Temps</th>
                <th class="align-middle" scope="col">Chef</th>
                <th class="align-middle" scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>

            <?php 
            
            formatUtil::dump($vars['entities']);
            foreach ($vars['entities'] as $recipe) { ?>
                <tr>
                    <td class="align-middle"><?= $recipe->getId(); ?></td>
                    <td class="align-middle"><?= $recipe->getName(); ?></td>
                    <td class="align-middle"><?= $recipe->getDifficulty(); ?></td>
                    <td class="align-middle"><?= $recipe->getPortions(); ?></td>
                    <td class="align-middle"><?= $recipe->getPreparationTime(); ?></td>
                    <td class="align-middle"><?= $recipe->getChef()->getLastName(); ?> </td>
                    <td class="align-middle">
                        <div class="d-flex flex-column">
                            <a class="editBtn" href="<?=
                                                        //TODO AJOUTER L'ID DANS L'ADRESSE POUR LA MODIF
                                                        $vars['baseUrl'] ?>recipe/edit">Modifier</a>
                            <a class="editBtn" href="<?= $vars['baseUrl'] ?>recipe/delete">Supprimer</a>

                        <?php } ?>
                        </div>
                    </td>

                </tr>

        </tbody>
    </table>


</div>