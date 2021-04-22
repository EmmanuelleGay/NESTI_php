<div class="container-fluid">
    <div class="d-flex mt-4">
        <a href="<?= $vars['baseUrl'] ?>recipe" class="linkHead">Recettes > </a>
        <p class="linkHead"> Recette</p>
    </div>

    <?php

    if (($_GET['message'] ?? "") == 'success') :
        echo "<div class='importSuccessMessage successMessage text-center fw-bold my-5 py-3 w-50'>Edition réussie</div>";
    endif ?>

    <form class="d-flex justify-content-around" method="post" enctype="multipart/form-data" action="<?= $vars['baseUrl'] ?>recipe/edit/<?= $vars['entity']->getId() ?>">
        <div>
            <?php
            if ($vars['entity']->getId() == null) {
                $title = "Création d'une recette";
            } else {
                $title = "Edition d'une recette";
            }; ?>

            <h1><?= $title ?></h1>
            <p>Nom de la recette</p>
            <input type="text" name="Recipe[name]" class="form-control" id="nameRecipe" value="<?= $vars['entity']->getName() ?>" autofocus>
            <p class="font-italic">Auteur de la recette : <?= $vars['loggedInUser']->getFirstName() . " " .  $vars['loggedInUser']->getLastName(); ?></p>
            <div class="row align-items-center mb-3">
                <label class="col-9" for="difficulty">Difficulté (note sur 5)</label>
                <div class="col-3"><input type="text" name="Recipe[difficulty]" class="form-control" id="difficulty" value="<?= $vars['entity']->getDifficulty() ?>"></div>
            </div>
            <div class="row align-items-center mb-3">
                <label class="col-9" for="portions">Nombres de personnes</label>
                <div class="col-3"><input type="text" name="Recipe[portions]" class="form-control" id="portions" value="<?= $vars['entity']->getPortions() ?>"></div>
            </div>
            <div class="row align-items-center">
                <label class="col-9" for="preparationTime">Temps de préparation en minutes</label>
                <div class="col-3"><input type="text" name="Recipe[preparationTime]" class="form-control" id="preparationTime" value="<?= $vars['entity']->getPreparationTime() ?>"></div>
            </div>
            <div>
                <button type="reset" class="btn cancelBtn fs-5 px-5 mx-3 mt-3 mb-5">Annuler</button>
                <button type="submit" class="btn validButton fs-5 px-5 mt-3 mb-5">Valider</button>
            </div>
        </div>
        <div>
            <div>
                <?php
                if ($vars['entity']->getImage() != null) { ?>
                    <img class="mb-3 photo" src="<?= $vars['baseUrl'] ?>/public/images/recipes/<?= $vars['entity']->getImage()->getName() . '.' . $vars['entity']->getImage()->getFileExtension() ?>" alt="image de recette">
                <?php } else { ?>
                    <img class="mb-3 photo" src="<?= $vars['baseUrl'] ?>/public/images/noImage.jpg" alt="image de recette">
                <?php }
                ?>

            </div>
            <div>Télécharger une nouvelle image</div>
            <input type="file" name="Recipe[linkImage]" class="form-control mb-3" id="nameRecipe" accept="image/png, image/jpeg">
        </div>
        <input type="hidden" name="Recipe[flag]" value="a">

    </form>

</div>

<div class="container-fluid grey">
    <div class="row">
        <div class="col-8 d-grid">
            <h2 class="titlePrep mt-5">Préparations</h2>
            <div id="contentParagraph">
            </div>
            <button id="createPreparationButton" class="btn createButton mb-5"><img src="<?= $vars['baseUrl'] ?>public/images/create-svg.png" alt="créer"></button>
        </div>

        <div class="col-4">
            <h2 class="mx-5 mt-5">Liste des ingrédients</h2>
            <div class="containerIngredient">

                <?php foreach ($vars['entity']->getIngredientRecipes() as $ingredientRecipe) : ?>
                    <div><?= FormatUtil::getFormattedQuantity($ingredientRecipe->getUnit()->getName(), $ingredientRecipe->getQuantity(), $ingredientRecipe->getIngredient()->getName());?>
                    </div>
                <?php endforeach ?>

            </div>

            <form class="justify-content-around mt-3 containerAddIngredient" method="post" action="<?= $vars['baseUrl'] ?>recipe/edit/<?= $vars['entity']->getId() ?>">

                <label for="ingredient">Ajouter un ingrédient</label>
                <input type="text" name="ingredient[name]" id="ingredient" class="form-control" placeholder="nom de l'ingredient">
                <div class="d-flex">
                    <input type="text" name="ingredient[quantity]" class="form-control mx-2  mt-3" placeholder="quantité">
                    <input type="text" name="ingredient[unit]" class="form-control mx-2 mt-3" placeholder="unité">
                    <button class="btn okButton mx-2 mt-3" type="submit">Ok</button>
                </div>
            </form>
        </div>
    </div>
</div>