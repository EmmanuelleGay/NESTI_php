<div class="container-fluid">
    <div class="d-flex mt-4">
        <a href="<?= $vars['baseUrl'] ?>article" class="linkHead">Articles > </a>
        <p class="linkHead"> Article</p>
    </div>


    <?php
    if (($_GET['message'] ?? "") == 'success') : 
          echo "<div class='importSuccessMessage successMessage text-center fw-bold my-5 py-3 w-50'>Edition réussie</div>";
     endif ?>

    <form class="d-flex justify-content-around" method="post" enctype="multipart/form-data" action="<?= $vars['baseUrl'] ?>article/edit/<?= $vars['entity']->getId() ?>">

        <div>
            <h1>Edition d'un article</h1>
            <div class="row align-items-center mb-3">
                <label for="nameArticle">Nom d'usine de l'article</label>
                <input type="text" name="Article[name]" class="form-control" id="nameArticle" value="<?= $vars['entity']->getProduct()->getName() ?>" readonly>
            </div>

            <div class="row align-items-center mb-3">
                <label for="nameArticleForUser">Nom de l'article pour l'utilisateur</label>
                <input type="text" name="Article[nameForUser]" class="form-control" id="nameArticleForUser" value="<?= $vars['entity']->getNameToDisplay() ?>">
            </div>
            <div class="row align-items-center mb-3">
                <label class="col-9" for="idArticle">Identifiant</label>
                <div class="col-3"><input type="text" name="Article[id]" class="form-control" id="idArticle" value="<?= $vars['entity']->getId() ?>" readonly></div>
            </div>
            <div class="row align-items-center mb-3">
                <label class="col-9" for="price">Prix de vente</label>
                <div class="col-3"><input type="text" name="Article[price]" class="form-control" id="price" value="<?= $vars['entity']->getLastPrice() ?>" readonly></div>
            </div>
            <div class="row align-items-center">
                <label class="col-9" for="stock">Stock</label>
                <div class="col-3"><input type="text" name="Article[stock]" class="form-control" id="stock" value="<?= $vars['entity']->getStockByArticle() ?>" readonly></div>
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
                    <img class="mb-3 photo" src="<?= $vars['baseUrl'] ?>/public/images/articles/<?= $vars['entity']->getImage()->getName() . '.' . $vars['entity']->getImage()->getFileExtension() ?>" alt="image de l'article">
                <?php } else { ?>
                    <img class="mb-3 photo" src="<?= $vars['baseUrl'] ?>/public/images/noImage.jpg" alt="image de l'article">
                <?php }
                ?>

            </div>
            <div>Télécharger une nouvelle image</div>
            <input type="file" name="linkImage" class="form-control" id="nameArticle">
        </div>
        <input type="hidden" name="Article[flag]" value="a">

    </form>

</div>