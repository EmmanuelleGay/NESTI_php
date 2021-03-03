<p>ORDERS</p>
<script>
    $(() => {
        //on peut mettre n'importe quel element js a la place de clik
        $("#monlien").click(() => {
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
</script>

<a href="#" id="monlien">test</a>

<!-- //le $(()=>{ va faire que dans tous les cas ca s'exceutreta quand la page aura fini de charger -->