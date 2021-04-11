

$(() => { // to delete an article
    $("#deleteModal").on("show.bs.modal", (e) => {
        var button = $(e.relatedTarget);
        var id = button.data("id");
        $("#confirmDelete").attr("href", baseUrl + "/article/confirmDelete/" + id);
    });

    
    // to show order details when clicking on order

    let numberOrderContainer = $("#numberOrderContainer"); // a la place du query selector pour recup la div
    let orderLineContainer = $("#orderLinesContainer");
    let titleOrderLine = $("#titleOrderLine")

    // on peut mettre n'importe quel element js a la place de clik
    $(".orderLink").click((e) => {
        var orderLink = $(e.target.closest("tr"));
        titleOrderLine.empty();
        titleOrderLine.append("Détails");
        titleOrderLine.addClass(titleOrderLine);

        // on récupère l'id de la cde
        // console.log(orderLink.data("id"));
        var orderId = orderLink.data("id");
        numberOrderContainer.empty();
        numberOrderContainer.append("N° " + orderId);
        numberOrderContainer.addClass("numberOrderContainer text-center p-2");

        // on met le nom de la fonction
        $.post(baseUrl + "article/orderDetailsAjax", {

            "orderId": orderId
        }, (response) => {
            let orderLines = JSON.parse(response);

            // on construit le détail des lignes
            // on le vide au cas ou il y ait un truc dedans (si on a deja cliqué)

            orderLineContainer.empty();
            orderLineContainer.addClass("orderLineContainer p-3");
            orderLines.forEach(orderLine => {
                orderLineContainer.append("<div>" + orderLine["unitQuantity"] + " " + orderLine["unitName"] + " de " + orderLine["articleName"] + " x" + orderLine["quantity"] + "</div>");

            })

        });
    });

})
