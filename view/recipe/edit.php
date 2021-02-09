<div class="container-fluid">
    <div class="d-flex mt-4">
        <a href="<?= $vars['baseUrl'] ?>recipe" class="linkHead">Recettes > </a>
        <p class="linkHead"> Recette</p>
    </div>

    <form class="d-flex justify-content-around" method="post" enctype="multipart/form-data" action="<?= $vars['baseUrl'] ?>recipe">
        <div>
            <h1>Création d'une recette</h1>
            <p>Nom de la recette</p>
            <input type="text" name="Recipe[name]" class="form-control" id="nameRecipe" autofocus>
            <p class="font-italic">Auteur de la recette : <?php
                                                            echo  $vars['loggedInUser']->getFirstName() . " " .  $vars['loggedInUser']->getLastName();
                                                            ?></p>
            <div class="row align-items-center mb-3">
                <div class="col-9">Difficulté (note sur 5)</div>
                <div class="col-3"><input type="text" name="Recipe[difficulty]" class="form-control" id="difficulty"></div>
            </div>
            <div class="row align-items-center mb-3">
                <div class="col-9">Nombres de personnes</div>
                <div class="col-3"><input type="text" name="Recipe[portions]" class="form-control" id="difficulty"></div>
            </div>
            <div class="row align-items-center">
                <div class="col-9">Temps de préparation en minutes</div>
                <div class="col-3"><input type="text" name="Recipe[preparationTime]" class="form-control" id="difficulty"></div>
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

    </form>

</div>

<div class="container-fluid grey">
    <div class="row">
        <div class="col-8 mr-5">
            <h2 class="titlePrep mt-5">Préparations</h2>
            <div class="d-flex mb-3 align-items-center justify-content-center">
                <div class="containerButton">
                    <button class="btn downButton"><img src="<?= $vars['baseUrl'] ?>public/images/down-svg.png" alt="descendre" width="100%"></button>
                    <button class="btn binButton"><img src="<?= $vars['baseUrl'] ?>public/images/delete-svg.png" alt="supprimer" width="100%"></button>
                </div>
                <textarea name="Recipe[content]" class="form-control" rows="6"></textarea>
            </div>
            <div class="d-flex mb-3 align-items-center justify-content-center">
                <div class="containerButton">
                    <button class="btn upButton"><img src="<?= $vars['baseUrl'] ?>public/images/up-svg.png" alt="monter" width="100%"></button>
                    <button class="btn downButton"><img src="<?= $vars['baseUrl'] ?>public/images/down-svg.png" alt="descendre" width="100%"></button>
                    <button class="btn binButton"><img src="<?= $vars['baseUrl'] ?>public/images/delete-svg.png" alt="supprimer" width="100%"></button>
                </div>
                <textarea name="Recipe[content]" class="form-control" rows="6"></textarea>
            </div>
            <div class="d-flex mb-3 align-items-center justify-content-center">
                <div class="containerButton">
                    <button class="btn downButton"><img src="<?= $vars['baseUrl'] ?>public/images/down-svg.png" alt="supprimer" width="100%"></button>
                    <button class="btn binButton"><img src="<?= $vars['baseUrl'] ?>public/images/delete-svg.png" alt="supprimer" width="100%"></button>
                </div>
                <textarea name="Recipe[content]" class="form-control" rows="6"></textarea>
            </div>
        </div>
        <div class="col">
            <h2 class="mx-5 mt-5">Liste des ingrédients</h2>
            <div class="containerIngredient">
             
            <?php foreach ($vars['ingredients'] as $ingredient): ?>
                    <div><?= $ingredient->getName();
                         ?>
                    </div>
                    <?php endforeach ?>
            </div>
        </div>
    </div>
</div>