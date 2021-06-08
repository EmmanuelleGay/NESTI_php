<div class="container-fluid">
    <div class="d-flex mt-4">
        <a href="<?= $vars['baseUrl'] ?>article" class="linkHead">Articles > </a>
        <p class="linkHead"> Article</p>
    </div>


    <?php
    if (($_GET['message'] ?? "") == 'success') :
        echo "<div class='importSuccessMessage successMessage text-center fw-bold my-5 py-3 w-50'>Edition réussie</div>";
    endif ?>

    <form class="row" method="post" enctype="multipart/form-data" action="<?= $vars['baseUrl'] ?>article/edit/<?= $vars['entity']->getId() ?>">

        <div class="col-lg-6 col-md-12">
            <div class="container">
                <h1>Edition d'un article</h1>
                
                <div class="row align-items-center mb-3">
                    <label class="col-12" for="nameArticle">Nom d'usine de l'article</label>
                    <div class="col-12">
                        <input type="text" name="Article[name]" class="form-control" id="nameArticle" value="<?= $vars['entity']->getProduct()->getName() ?>" readonly>
                    </div>
                </div>

                <div class="row align-items-center mb-3">
                    <label for="nameArticleForUser">Nom de l'article pour l'utilisateur</label>
                    <div class="col-12">
                        <input type="text" name="Article[nameForUser]" class="form-control" id="nameArticleForUser" value="<?= $vars['entity']->getNameToDisplay() ?>">
                    </div>
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
                <div class="row">
                    <button type="reset" class="btn cancelBtn fs-5 px-5 mx-3 mt-3 mb-5 col-3">Annuler</button>
                    <button type="submit" class="btn validButton fs-5 px-5 mt-3 mb-5 col-3">Valider</button>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-md-12">
            <div class="container">
                <div>
                    <?php
                    if ($vars['entity']->getImage() != null) { ?>
                        <img class="mb-3 photo" src="<?= $vars['baseUrl'] ?>/public/images/articles/<?= $vars['entity']->getImage()->getName() . '.' . $vars['entity']->getImage()->getFileExtension() ?>" alt="image de l'article">
                    <?php } else { ?>
                        <img class="mb-3 photo" src="<?= $vars['baseUrl'] ?>/public/images/noImage.jpg" alt="image de l'article">
                    <?php }
                    ?>

                </div>
                <div class="row">
                    <div class="col-12">Télécharger une nouvelle image</div>
                    <div class="col-8">
                        <input type="file" name="linkImage" class="form-control">
                    </div>

                </div>
            </div>
        </div>
        <input type="hidden" name="Article[flag]" value="a">

    </form>

</div>