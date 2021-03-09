<script>

</script>
<!-- 
<a href="#" id="monlien">test</a> 

 //le $(()=>{ va faire que dans tous les cas ca s'executera quand la page aura fini de charger-->

<div class="container-fluid">
    <div class="d-flex mt-4">
        <a href="<?= $vars['baseUrl'] ?>article" class="linkHead">Articles > </a>
        <p class="linkHead"> Commandes</p>
    </div>

    <h1 class="h1 mt-4">Commandes</h1>

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
                    <th class="align-middle" scope="col">Date</th>
                    <th class="align-middle" scope="col">Etat</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($vars['entities'] as $order) {
                ?>
                    <tr>
                        <td class="align-middle"><a href="#" data-id="<?= $order->getId(); ?>" class="orderLink"><?= $order->getId(); ?></a></td>
                        <td class="align-middle"><?= $order->getUsers()->getFirstName() . " " . $order->getUsers()->getLastName(); ?></td>
                        <td class="align-middle"><?= "somme a faire"; ?></td>
                        <td class="align-middle"><?= FormatUtil::formatDate($order->getDateCreation()); ?></td>
                        <td class="align-middle"><?= $order->getFlag(); ?></td>

                    <?php } ?>

                    </tr>

            </tbody>
        </table>

        <div class="mx-5 DetailsArticle">
            <div class= "d-flex justify-content-between mb-2">
                <h2 id="titleOrderLine"></h2>
                <div id="numberOrderContainer"></div>
            </div>
                <div id="orderLinesContainer"></div>
        </div>
    </div>



</div>