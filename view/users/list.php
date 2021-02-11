<div class="container d-flex flex-column">

    <h1 class="h1 mt-4">Utilisateurs</h1>

    <?php
    include(__DIR__ . '/../common/searchbar.php');
    ?>


    <div class="mb-3 btn border rounded addContainer justify-content-around d-flex align-items-center align-self-end mx-5">
        <img src="<?= $vars['baseUrl'] ?>/public/images/create-svg.png" alt="add icon" id="addElement" class="addElement">
        <a class="addLink aria-label fs-4 " aria-describedby="addElement" href="<?= $vars['baseUrl'] ?>recipe/edit">Ajouter</a>
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
                            <p class="editBtn" data-bs-toggle="modal" data-bs-target="#exampleModal">Supprimer</p>

<!-- pour mettre le nom de l'utilsaiteur dans la modale, il faut faire en JS, et récupérer le TD concerné au click-->
                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Attention</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Vous êtes sur le point de supprimer l'utilisateur, souhaitez vous continuer?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                            <a href="<?= $vars['baseUrl'] ?>users/confirmDelete/<?= $users->getId() ?>">Valider</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?php } ?>
                        </div>
                    </td>

                </tr>

        </tbody>
    </table>


</div>