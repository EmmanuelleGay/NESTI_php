<?php if (
    (UsersController::getLoggedInUser()->isChef() == true && UsersController::getLoggedInUser()->isAdministrator() == false)
) {
?>
    <h1 class="m-5">Accès interdit</h1>
    <div class="mx-5 fst-italic">Vous n'avez pas les droits pour accéder à cette page</div>
<?php } else {
?>


    <div class="container d-flex flex-column">

        <h1 class="h1 mt-4">Utilisateurs</h1>

        <?php
        include(__DIR__ . '/../common/searchbar.php');
        ?>


        <div class="mb-3 btn border rounded addContainer justify-content-around d-flex align-items-center align-self-end mx-5">
            <img src="<?= $vars['baseUrl'] ?>/public/images/create-svg.png" alt="add icon" id="addElement" class="addElement">
            <a class="addLink aria-label fs-4 " aria-describedby="addElement" href="<?= $vars['baseUrl'] ?>users/edit">Ajouter</a>
        </div>

        <table class="table table-hover table-sm">
            <thead>
                <tr>
                    <th class="align-middle" scope="col">ID</th>
                    <th class="align-middle" scope="col">Nom</th>
                    <th class="align-middle" scope="col">Rôle</th>
                    <th class="align-middle" scope="col">Dernière connexion</th>
                    <th class="align-middle" scope="col">Etat</th>
                    <th class="align-middle" scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>

                <?php

                foreach ($vars['entities'] as $users) { ?>
                    <tr>
                        <td class="align-middle"><?= $users->getId(); ?></td>
                        <td class="align-middle"><?= $users->getLastName(); ?></td>

                        <td><?= implode(',', $users->getRoles());  ?></td>

                        <td class="align-middle"><?= $users->getLatestConnection(); ?></td>
                        <td class="align-middle"><?= $users->getState(); ?></td>
                        <td class="align-middle">
                            <div class="d-flex flex-column">
                                <a class="editBtn" href="<?=
                                                            $vars['baseUrl'] ?>users/edit/<?= $users->getId() ?>">Modifier</a>
                                <a href="#deleteModal" class="editBtn" data-bs-toggle="modal" data-id="<?= $users->getId() ?>" data-bs-target="#deleteModal">
                                    Supprimer
                                </a>
                            </div>
                        </td>

                    </tr>
                <?php } ?>

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

<?php }
