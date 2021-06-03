<div class="container-fluid ">
    <div class="d-flex mt-4">
        <a href="<?= $vars['baseUrl'] ?>users" class="linkHead">Utilisateur > </a>
        <p class="linkHead"> Utilisateur</p>
    </div>

    <?php
    if (($_GET['message'] ?? "") == 'success') : ?>
        <div class="successMessage text-center w-25 mx-auto my-3 py-3">Vos informations ont bien été enregistrées</div>
    <?php endif ;

if (@$vars['message'] == 'errorFormLogin') {
    echo "<div class='errorMessage text-center w-25 mx-auto my-3 py-3'>Un compte utilisateur existe déjà avec ce login</div>";
}

if (@$vars['message'] == 'errorFormEmail') {
    echo "<div class='errorMessage text-center w-25 mx-auto my-3 py-3'>Un compte utilisateur existe déjà avec cet email</div>";
}

if (@$vars['message'] == 'strongPassword') {
    echo "<div class='errorMessage text-center w-25 mx-auto my-3 py-3'>Le mot de passe saisi n'est pas assez fort</div>";
}

?>

    <!------------------------------------ Edition of user------------------------- -->
    <div class="container d-flex justify-content-between">

        <form class="d-flex justify-content-around mx-5" method="post" action="<?= $vars['baseUrl'] ?>users/edit/<?= $vars['entity']->getId() ?>">
            <div>
                <?php
                if ($vars['entity']->getId() == null) {
                    $title = "Création d'un utilisateur";
                } else {
                    $title = "Edition d'un utilisateur";
                }; ?>

                <h1><?= $title ?></h1>

                <div class="align-items-center mt-5 mb-3">
                    
                    <label for="lastName">Nom</label>
                    <div><input type="text" name="Users[lastName]" class="form-control" id="lastName" value="<?= $vars['entity']->getLastName() ?>" required maxlength="50" minlength="2"></div>
                </div>
                <div class="align-items-center mb-3">
                    <label for="firstName">Prénom</label>
                    <div><input type="text" name="Users[firstName]" class="form-control" id="firstName" value="<?= $vars['entity']->getFirstName() ?>" required></div>
                </div>
                <div class="align-items-center mb-3">
                    <label for="login">Nom d'utilisateur</label>
                    <div><input type="text" name="Users[login]" class="form-control" id="login" value="<?= $vars['entity']->getLogin() ?>" required></div>
                </div>
                <div class="align-items-center mb-3">
                    <label for="email">Email</label>
                    <div><input type="email" name="Users[email]" class="form-control" id="email" value="<?= $vars['entity']->getEmail() ?>" required></div>
                </div>

                <div class="align-items-center mb-3">
                    Role
                    <div class="d-flex">
                        <div>
                            <input class="form-check-input mx-2" name=Users[chef] type="checkbox" value="chef" id="flexCheckDefault" <?php if ($vars['entity']->isChef()) {
                                                                                                                                        ?>checked <?php
                                                                                                                                                } ?>>
                            <label class="form-check-label" for="chef">Chef</label>
                        </div>

                        <div>
                            <input class="form-check-input mx-2" name=Users[moderator] type="checkbox" value="moderator" id="flexCheckDefault" <?php if ($vars['entity']->isModerator()) {
                                                                                                                                                ?>checked <?php
                                                                                                                                                        } ?>>
                            <label class="form-check-label" for="moderator">Modérateur</label>
                        </div>

                        <div>
                            <input class="form-check-input mx-2" name=Users[administrator] type="checkbox" value="administrator" id="flexCheckDefault" <?php if ($vars['entity']->isAdministrator()) {
                                                                                                                                                        ?>checked <?php
                                                                                                                                                                } ?>>
                            <label class="form-check-label" for="administrator">Administrateur</label>
                        </div>
                    </div>
                </div>
                <div class="align-items-center mb-3">
                    <label for="address1">Adresse</label>
                    <div><input type="text" name="Users[address1]" class="form-control" id="address1" value="<?= $vars['entity']->getAddress1() ?>"></div>
                </div>
                <div class="align-items-center mb-3">
                    <label for="address2">Complément d'adresse</label>
                    <div><input type="text" name="Users[address2]" class="form-control" id="address2" value="<?= $vars['entity']->getAddress2() ?>"></div>
                </div>
                <div class="align-items-center mb-3">
                    <label for="zipCode">Code postal</label>
                    <div><input type="text" name="Users[zipCode]" class="form-control" id="zipCode" value="<?= $vars['entity']->getZipCode() ?>" required></div>
                </div>

                <div class="align-items-center mb-3">
                    <label for="city">Ville</label>
                    <div><input type="text" name="Users[city]" class="form-control" id="city" value="<?php if ($vars['entity']->getCity() != null) {
                                                                                                            echo $vars['entity']->getCity()->getName();
                                                                                                        } ?>"></div>

                </div>


                <?php
                if ($vars['entity']->getId() == null) {
                ?>
                    <div class="align-items-center mb-3">
                        <label for="password">Mot de passe</label>
                        <div><input type="password" name="Users[password]" class="form-control" id="password"></div>
                        <small id="passwordHelpInline" class="text-muted">
                            Entre 8 et 20 caractères, dont au moins une lettre, un chiffre et un caractère spécial.
                        </small>
                        <div id="passwordStrenght"></div>
                    </div>

                <?php } ?>

                <div>
                    <button type="reset" class="btn cancelBtn fs-5 px-5 mx-3 mt-3 mb-5">Annuler</button>
                    <button type="submit" class="btn validButton fs-5 px-5 mt-3 mb-5">Valider</button>
                </div>

                <input type="hidden" name="Users[flag]" value="a">
            </div>

        </form>


        <?php
        if ($vars['entity']->getId() != null) {
        ?>

            <div class="mx-5  informationUser">

                <h2>Informations</h2>
                <div class="border px-5  py-4 w-100">
                    <div>Date de création : <?= FormatUtil::formatDate($vars['entity']->getDateCreation()) ?> </div>
                    <div>Dernière connexion : <?= FormatUtil::formatDate($vars['entity']->getLatestConnection()) ?> </div>

                    <div><?php if ($vars['entity']->isChef()) { ?>
                            <div class="bold mt-2">Chef patissier</div>
                            <div>Nombre de recettes : <?= @$vars['entity']->getRecipesNumber() ?></div>
                            <div>Dernière recette : <?= @$vars['entity']->getLastRecipe() ?></div>
                        <?php   } ?>
                    </div>

                    <div>
                        <div class="bold mt-2">Utilisateur</div>
                        <div>Nombre de commandes : <?= @$vars['entity']->getOrdersNumber() ?></div>
                        <div>Montant total des commandes : <?= @$vars['entity']->getSumOrder() ?> </div>
                        <div>Dernière commande : <?= FormatUtil::formatDate($vars['entity']->getLastOrder()) ?></div>
                    </div>

                    <div><?php if ($vars['entity']->isAdministrator()) { ?>
                            <div class="bold mt-2">Administrateur</div>
                            <div>Nombre d'importations faites : <?= @$vars['entity']->getImportationNumber() ?></div>
                            <div>Date de la dernière importation : <?= FormatUtil::formatDate($vars['entity']->getLastImportation()) ?> </div>
                        <?php   } ?>
                    </div>

                    <div><?php if ($vars['entity']->isModerator()) { ?>
                            <div class="bold mt-2">Moderateur</div>
                            <div>Nombre de commentaires bloqués : <?= @$vars['entity']->getBlockedCommentNumber() ?></div>
                            <div>Nombre de commentaires approuvés : <?= @$vars['entity']->getApprouvedCommentNumber() ?> </div>
                        <?php   } ?>
                    </div>
                </div>
                <a href="#" class=" btn buttonPassword border my-2 px-5 w-100">Réinitialisation du mot de passe</a>
            </div>


    </div>

    <!------------------------------------ users' orders------------------------- -->
    <div class="my-5 orders p-5">
        <h1 class="h1 mt-4">Ses commandes</h1>
        <div class="fst-italic">Consultation des commandes</div>

        <?php
            include(__DIR__ . '/../common/searchbar.php');
        ?>
        <div class="d-flex justify-content-around">
            <table class="table table-hover table-sm">
                <thead>
                    <tr>
                        <th class="align-middle" scope="col">ID</th>
                        <th class="align-middle" scope="col">Utilisateur</th>
                        <th class="align-middle" scope="col">Montant</th>
                        <th class="align-middle" scope="col">Nombre d'article</th>
                        <th class="align-middle" scope="col">Date</th>
                        <th class="align-middle" scope="col">Etat</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
          //          if (!empty($vars['userOrders'])) {
                        foreach ($vars['entity']->getOrders() as $order) {
                    ?>
                            <tr class="orderLink" data-id="<?= $order->getId(); ?>">
                                <td class="align-middle"><?= $order->getId(); ?></td>
                                <td class="align-middle"><?= $order->getUsers()->getFirstName() . " " . $order->getUsers()->getLastName(); ?></td>
                                <td class="align-middle"><?= $order->getTotal() . " €" ?></td>
                                <td class="align-middle"><?= $order->getQuantity(); ?></td>
                                <td class="align-middle"><?= FormatUtil::formatDate($order->getDateCreation()); ?></td>
                                <td class="align-middle"><?= $order->getState(); ?></td>
                            </tr>
                    <?php }
        //            }
                    ?>



                </tbody>
            </table>

            <div class="mx-5 DetailsArticle">
                <div class="d-flex justify-content-between mb-2">
                    <h2 id="titleOrderLine"></h2>
                    <div id="numberOrderContainer"></div>
                </div>
                <div id="orderLinesContainer"></div>
            </div>
        </div>


    </div>
    <!------------------------------------users' comment------------------------- -->
    <div class="my-5 p-5">
        <h1 class="h1 mt-4">Ses commentaires</h1>
        <div class="fst-italic">Modération des commentaires</div>



        <table class="table table-hover table-sm commentTable">
            <thead>
                <tr>
                    <th class="align-middle" scope="col">ID</th>
                    <th class="align-middle" scope="col">Titre</th>
                    <th class="align-middle" scope="col">Recette</th>
                    <th class="align-middle" scope="col">Contenu</th>
                    <th class="align-middle" scope="col">Date</th>
                    <th class="align-middle" scope="col">Etat</th>
                    <th class="align-middle" scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach ($vars['entity']->getComments() as $comments) {

                ?>
                        <tr>
                            <td class="align-middle"><?= $comments->getIdRecipe(); ?></td>
                            <td class="align-middle"><?= $comments->getCommentTitle() ?></td>
                            <td class="align-middle"><?= $comments->getRecipe()->getName() ?></td>
                            <td class="align-middle"><?= $comments->getCommentContent() ?></td>
                            <td class="align-middle"><?= $comments->getDateCreation() ?></td>
                            <td class="align-middle statusCell"><?= $comments->getState() ?></td>

                            <td class="align-middle">
                                <a class="editBtn" data-idrecipe="<?= $comments->getIdRecipe() ?>" data-iduser="<?= $comments->getIdUsers() ?>" data-blocks="false" href="javascript:void(0)">Approuver</a>
                                <br>
                                <a class="editBtn" data-idrecipe="<?= $comments->getIdRecipe() ?>" data-iduser="<?= $comments->getIdUsers() ?>" data-blocks="true" href="javascript:void(0)">Bloquer</a>
                            </td>
                        </tr>
                    <?php } ?>

            </tbody>
        </table>

    </div>
<?php 
            } ?>

</div>