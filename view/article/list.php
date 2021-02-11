<div class="container d-flex flex-column">

    <h1 class="h1 mt-4">Articles</h1>

    <?php
    include(__DIR__ . '/../common/searchbar.php');
    ?>
    <div class="d-flex align-self-end">
        <div class="mb-3 btn border rounded addContainer yellow justify-content-around d-flex align-items-center mx-3">
            <i class="fas fa-eye fa-2x"></i>
            <a class="addLink aria-label fs-4 " aria-describedby="addElement" href="<?= $vars['baseUrl'] ?>recipe/edit">Commandes</a>
        </div>

        <div class="mb-3 btn border rounded addContainer justify-content-around d-flex align-items-center mx-3">
            <img src="<?= $vars['baseUrl'] ?>/public/images/create-svg.png" alt="add icon" id="addElement" class="addElement">
            <a class="addLink aria-label fs-4 " aria-describedby="addElement" href="<?= $vars['baseUrl'] ?>recipe/edit">Importer</a>
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
                    <td><?=$article->getId(); ?></td>
                    <td><?= $article->getProduct()->getName(); ?></td>
                    <td><?= $article->getLastPrice(); ?></td>
                    <td>ingrédient</td>
                    <td><?= $article->getDateModification(); ?></td>

                    <td><?php foreach ($article->getLots() as $quantity) {
                           echo $quantity->getQuantity();
                        } ?></td>

                    <td class="align-middle">
                        <div class="d-flex flex-column">
                            <a class="editBtn" href="<?=
                                                        $vars['baseUrl'] ?>article/edit/<?= $article->getId() ?>">Modifier</a>
                            <a class="editBtn" href="<?= $vars['baseUrl'] ?>article/confirmDelete/<?= $article->getId() ?>">Supprimer</a>

                        <?php } ?>

                        </div>
                    </td>

                </tr>

        </tbody>
    </table>


</div>