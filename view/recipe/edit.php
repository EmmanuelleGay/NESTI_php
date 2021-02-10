<div class="container-fluid">
    <div class="d-flex mt-4">
        <a href="<?= $vars['baseUrl'] ?>recipe" class="linkHead">Recettes > </a>
        <p class="linkHead"> Recette</p>
    </div>
    <?php

    if (@$_GET['message'] == 'success') : ?>
        <div>Bravo</div>
    <?php endif ?>

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
            <p class="font-italic">Auteur de la recette : <?php
                                                            echo  $vars['loggedInUser']->getFirstName() . " " .  $vars['loggedInUser']->getLastName();
                                                            ?></p>
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
            <img src="" alt="">
            <div>Télécharger une nouvelle image</div>
            <input type="file" name="Recipe[linkImage]" class="form-control" id="nameRecipe">
        </div>
        <input type="hidden" name="Recipe[flag]" value="a">

    </form>

</div>

<div class="container-fluid grey">
    <div class="row">
        <div class="col-8 mr-5">
            <h2 class="titlePrep mt-5">Préparations</h2>
          

                <?php foreach ($vars['entity']->getParagraphs() as $paragraphe) : ?>
                    <div class="mb-3 d-flex">
                        <div class="containerButton">
                            <button class="btn upButton"><img src="<?= $vars['baseUrl'] ?>public/images/up-svg.png" alt="monter" width="100%"></button>
                            <button class="btn downButton"><img src="<?= $vars['baseUrl'] ?>public/images/down-svg.png" alt="descendre" width="100%"></button>
                            <button class="btn binButton"><img src="<?= $vars['baseUrl'] ?>public/images/delete-svg.png" alt="supprimer" width="100%"></button>
                        </div>
                        <textarea name="Recipe[content]" class="form-control" rows="6">
                <?= $paragraphe->getContent();
                ?>
                </textarea>
                    </div>
                <?php endforeach ?>
            

        </div>
        <div class="col">
            <h2 class="mx-5 mt-5">Liste des ingrédients</h2>
            <div class="containerIngredient">


                <?php foreach ($vars['entity']->getIngredientRecipes() as $ingredientRecipe) : ?>
                    <div> <?= FormatUtil::getFormattedQuantity($ingredientRecipe->getUnit()->getName(), $ingredientRecipe->getQuantity(), $ingredientRecipe->getIngredient()->getName());
                            ?>
                    </div>
                <?php endforeach ?>

            </div>

            <form class="justify-content-around mt-3 containerAddIngredient" method="post" action="<?= $vars['baseUrl'] ?>recipe/edit/<?= $vars['entity']->getId() ?>">

                <label for="ingredient">Ajouter un ingrédient</label>
                <input type="text" name="ingredient[name]" id="ingredient" class="form-control ">

                <div class="d-flex">
                    <input type="text" name="ingredient[quantity]" class="form-control mx-2  mt-3">
                    <input type="text" name="ingredient[unit]" class="form-control mx-2 mt-3">
                    <button class="btn okButton mx-2 mt-3" type="submit">Ok</button>
                </div>

        </div>
    </div>
</div>
</div>