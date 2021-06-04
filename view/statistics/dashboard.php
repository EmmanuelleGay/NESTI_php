<?php if (
    (UsersController::getLoggedInUser()->isModerator() == true && UsersController::getLoggedInUser()->isAdministrator() == false)
    ||
    (UsersController::getLoggedInUser()->isChef() == true && UsersController::getLoggedInUser()->isAdministrator() == false)

) {
?>
    <h1 class="m-5">Accès interdit</h1>
    <div class="mx-5 fst-italic">Vous n'avez pas les droits pour accéder à cette page</div>
<?php } else {
?>



    <div class="container-fluid">
        <div class="row">
            <div id="chartOrder" class="col-md-12 col-lg-5"></div>
            <div id="chartConnexionLog" class="col-md-12 col-lg-4 text-center"></div>
            <div class="mt-3 col-md-6 col-lg-2">
                <p>Top 10 utilisateurs</p>
                <div class="border p-3">
                    <?php
                    foreach ($vars['usersWithMostConnections'] as $user) { ?>
                        <div class="d-flex justify-content-between">
                            <p>
                                <?= $user->getFirstName() . " " . $user->getLastName()  ?>
                            </p>
                            <a class="seeBtn" href="<?= $vars['baseUrl'] ?>users/edit/<?= $user->getId() ?>">Voir</a>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
            <div class="col-lg-5 col-md-6">
                <p>Plus grosse commandes</p>
                <div class="border p-3">
                    <?php

                    foreach ($vars['ordersByTotal'] as $orders) { ?>
                        <div class="d-flex justify-content-between">
                            <p>Commande n° <?= $orders->getId() ?> </p>
                            <a class="seeBtn" href="<?= $vars['baseUrl'] ?>article/order/<?= $orders->getId() ?>">Voir</a>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-lg-6 col-md-12">
                <h2 class="m-3">Recettes</h2>
                <div class="container">
                    <div class="row">
                        <div class="col-6">
                            <p>TOP 10 CHEFS</p>
                            <div class="border p-3">
                                <?php
                                foreach ($vars["chefsByRecipe"] as $chef) { ?>
                                    <div class="d-flex justify-content-between">
                                        <p><?= $chef->getLastName() . " " . $chef->getFirstName() ?> </p>
                                        <a class="seeBtn" href="<?= $vars['baseUrl'] ?>users/edit/<?= $chef->getId() ?>">Voir</a>
                                    </div>

                                <?php
                                }
                                ?>
                            </div>
                        </div>
                        <div class="col-6">
                            <p>Top 10 recettes</p>
                            <div class="border p-3">
                                <?php
                                foreach ($vars["recipesByGrade"] as $recipe) { ?>
                                    <div class="d-flex justify-content-between">
                                        <a class="seeBtn" href="<?= $vars['baseUrl'] ?>recipe/edit/<?= $recipe["idRecipe"] ?>"><?= $recipe["name"] ?></a>
                                        <p> par <?= $recipe["firstName"] . $recipe["lastName"] ?></p>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 mt-3">
                <h2>ARTICLES</h2>
                <div id="chartArticle"></div>

                <h3>En rupture de stock</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th class="col align-middle" scope="col">Nom</th>
                            <th class="col align-middle" scope="col">Quantité vendue</th>
                            <th class="col align-middle" scope="col">Bénéfice (€)</th>
                            <th class="col align-middle">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($vars["articlesOutOfStock"] as $article) { ?>
                            <tr>
                                <td class="align-middle me-3"><?= $article->getProduct()->getName() ?></td>
                                <td class="align-middle me-3"><?= $article->getQuantitySold() ?></td>
                                <td class="align-middle me-3"><?= $article->getTotalSales() - $article->getTotalPurchases() ?></td>
                                <td class="align-middle me-3"><a class="seeBtn" href="<?= $vars['baseUrl'] ?>article/edit/<?= $article->getId() ?>">voir</a></td>
                            </tr>

                        <?php
                        }
                        ?>


                    </tbody>
                </table>

            </div>

        </div>

    </div>

<?php }
