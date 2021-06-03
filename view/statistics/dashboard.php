<?php if(
    (UsersController::getLoggedInUser()->isModerator() == true && UsersController::getLoggedInUser()->isAdministrator()==false)
    ||
    (UsersController::getLoggedInUser()->isChef() == true && UsersController::getLoggedInUser()->isAdministrator()==false)

){
    ?>
    <h1 class="m-5">Accès interdit</h1>
     <div class="mx-5 fst-italic">Vous n'avez pas les droits pour accéder à cette page</div>
 <?php }
 else {
 ?>
 


<div class="container-fluid">
    <div class="d-flex border justify-content-around">
        <div id="chartOrder"></div>
        <div id="chartConnexionLog"></div>
        <div class="m-3">
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
    </div>

    <div class="d-flex justify-content-between">
        <div>
            <div>
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
            <h2 class="m-3">Recettes</h2>
            <div class="d-flex">

                <div class="m-3">
                    <p>Top 10 chefs</p>

                    <div class="border p-3">
                        <?php
                        foreach ($vars["chefsByRecipe"] as $chef) { ?>
                            <div class="d-flex justify-content-between">
                                <p><?= $chef->getLastName() . " " . $chef->getFirstName() ?> </p>
                                <a class="seeBtn" href="<?= $vars['baseUrl'] ?>user/edit/<?= $chef->getId() ?>">Voir</a>
                            </div>

                        <?php
                        }
                        ?>
                    </div>
                </div>


                <div class="m-3">
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
        <div>
            <div id="chartArticle"></div>
            <div>
                <p>En rupture de stock</p>
                <table>
                    <thead>
                        <tr>
                            <th class="align-middle" scope="col">Nom</th>
                            <th class="align-middle" scope="col">Quantité vendue</th>
                            <th class="align-middle" scope="col">Bénéfice (€)</th>
                            <th class="align-middle" scope="col">Action</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php
                        foreach ($vars["articlesOutOfStock"] as $article) { ?>
                            <tr>
                                <td class="align-middle"><?= $article->getProduct()->getName() ?></td>
                                <td class="align-middle"><?= $article->getQuantitySold() ?></td>
                                <td class="align-middle"><?= $article->getTotalSales() - $article->getTotalPurchases()?></td>
                                <td class="align-middle"><a class="seeBtn" href="<?= $vars['baseUrl'] ?>article/edit/<?= $article->getId() ?>">voir</a></td>
                            </tr>

                        <?php
                        }
                        ?>


                    </tbody>
                </table>
            </div>
        </div>

    </div>

</div>

<?php }