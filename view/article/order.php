<!-- <script>
    $(() => {
        //on peut mettre n'importe quel element js a la place de clik
        $("#monlien").click(() => {
            //verifier mais il; doit falloir mettre usersController car la méthode est dedans
            $.post(baseUrl + "users/testAjax", {
                    "ma clé": "mavaleur"
            },
                (response) => {
                    // let result = JSON.parse(response);
                    console.log(response);
                    //on construit les leelments
                    let article = JSON.parse(response); 
                    //executer finction ex construireArticle
                }
            );
        });

    })
</script> -->
<!-- 
<a href="#" id="monlien">test</a>  -->

<!-- //le $(()=>{ va faire que dans tous les cas ca s'exceutreta quand la page aura fini de charger-->

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
                        <td class="align-middle"><?= $order->getId(); ?></td>
                        <td class="align-middle"><?= $order->getUsers()->getFirstName(). " ". $order->getUsers()->getLastName(); ?></td>
                        <td class="align-middle"><?="somme a faire" ; ?></td>
                        <td class="align-middle"><?= $order->getDateCreation(); ?></td>
                        <td class="align-middle"><?= $order->getFlag(); ?></td>

                    <?php } ?>

                    </tr>
            </tbody>
        </table>

        <div class="mx-5 DetailsArticle">Détails</div>

    </div>



</div>