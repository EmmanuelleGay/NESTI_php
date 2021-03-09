<div class="container d-flex flex-column">

    <h1 class="h1 mt-4">Articles</h1>

    <?php
    include(__DIR__ . '/../common/searchbar.php');
    ?>
    <div class="d-flex align-self-end">
        <div class="mb-3 btn border rounded addContainer yellow justify-content-around d-flex align-items-center mx-3">
            <i class="fas fa-eye fa-2x"></i>
            <a class="addLink aria-label fs-4 " aria-describedby="addElement" href="<?= $vars['baseUrl'] ?>article/order">Commandes</a>
        </div>

        <div class="mb-3 btn border rounded addContainer justify-content-around d-flex align-items-center mx-3">
            <img src="<?= $vars['baseUrl'] ?>/public/images/create-svg.png" alt="add icon" id="addElement" class="addElement">
            <a class="addLink aria-label fs-4 " aria-describedby="addElement" href="<?= $vars['baseUrl'] ?>article/importation">Importer</a>
        </div>
    </div>
    <table class="table table-hover table-sm">
        <thead>
            <tr>
                <th class="align-middle" scope="col">ID</th>
                <th class="align-middle" scope="col">Nom</th>
                <th class="align-middle" scope="col">Prix de vente</th>
                <th class="align-middle" scope="col">Type</th>
                <th class="align-middle" scope="col">Dernière importation</th>
                <th class="align-middle" scope="col">Stock</th>
                <th class="align-middle" scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>

            <?php foreach ($vars['entities'] as $article) { ?>
                <tr>
                    <td class="align-middle"><?=$article->getId(); ?></td>
                    <td class="align-middle"><?= $article->getProduct()->getName(); ?></td>
                    <td class="align-middle"><?= $article->getLastPrice(); ?></td>
                    <td class="align-middle">ingrédient</td>
                    <td class="align-middle"><?= FormatUtil::formatDate($article->getDateModification()); ?></td>

                    <td class="align-middle"><?= $article->getStockByArticle() ?></td>

                    <td class="align-middle">
                        <div class="d-flex flex-column">
                            <a class="editBtn" href="<?=
                                                        $vars['baseUrl'] ?>article/edit/<?= $article->getId() ?>">Modifier</a>
                            <a href="#deleteModal" class="editBtn" data-bs-toggle="modal" data-id="<?= $article->getId() ?>" data-bs-target="#deleteModal">
                                Supprimer
                            </a>

                        <?php } ?>

                        </div>
                    </td>

                </tr>

        </tbody>
    </table>
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Suppression d'un utilisateur</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Attention, cette action est définitive et irréversible.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>

                    <a id="confirmDelete" href="#">Confirmer</a>

                </div>
            </div>
        </div>
    </div>

</div>