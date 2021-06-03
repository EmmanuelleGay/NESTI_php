// le $(()) => permet de n'excuter ce code qu'à la fin de la page (et donc après la création de la modale)
$(() => {
    $("#deleteModal").on("show.bs.modal", (e) => {
        var button = $(e.relatedTarget);
        var id = button.data("id");
        $("#confirmDelete").attr("href", baseUrl + "/users/confirmDelete/" + id);
    })


    // to show order details when clicking on order
    let numberOrderContainer = $("#numberOrderContainer");
    let orderLineContainer = $("#orderLinesContainer");
    let titleOrderLine = $("#titleOrderLine")

    $(".orderLink").click((e) => {
        var orderLink = $(e.target.closest("tr"));
        titleOrderLine.empty();
        titleOrderLine.append("Détails");
        titleOrderLine.addClass(titleOrderLine);

        var orderId = orderLink.data("id");
        numberOrderContainer.empty();
        numberOrderContainer.append("N° " + orderId);
        numberOrderContainer.addClass("numberOrderContainer text-center p-2");

        $.post(baseUrl + "article/orderDetailsAjax", {

            "orderId": orderId
        }, (response) => {
            let orderLines = JSON.parse(response);
            orderLineContainer.empty();
            orderLineContainer.addClass("orderLineContainer p-3");
            orderLines.forEach(orderLine => {
                orderLineContainer.append("<div>" + orderLine["unitQuantity"] + " " + orderLine["unitName"] + " de " + orderLine["articleName"] + " x" + orderLine["quantity"] + "</div>");
            })
        });
    });

    let moderateButtons = $(".commentTable .editBtn");
    moderateButtons.each((i, moderateButton) => {
        const commentRow = moderateButton.closest("tr");
        const statusCell = commentRow.querySelector("tr .statusCell");

        $(moderateButton).click(() => {
            let idRecipe = moderateButton.dataset.idrecipe;
            let idUser = moderateButton.dataset.iduser;
            let blocks = moderateButton.dataset.blocks;

            $.post(baseUrl + "users/moderateComment", {
                "idrecipe": idRecipe,
                "iduser": idUser,
                "blocks": blocks
            }, (flagResponse) => {
                let flag = JSON.parse(flagResponse);
                if (flag == "a") {
                    statusCell.innerHTML = "Approuvé";
                } else if (flag == "b") {
                    statusCell.innerHTML = "Bloqué"
                }
            });
        })
    })

    let passwordInput = $("#password");
    let passwordStrenght = $("#passwordStrenght");

    let minStrenght = 60;

    passwordInput.on("input",function(){
 
    let percentWidth = calculatePasswordStrength(passwordInput.val()) * 0.9 / minStrenght * 100;
    if(percentWidth>100){
        percentWidth = 100;
    }
    passwordStrenght.width(percentWidth + "%");
    passwordStrenght.removeClass();
    if(percentWidth >= 80){
        passwordStrenght.addClass("high");
    }
    else if(percentWidth > 50 ){
        passwordStrenght.addClass("medium");
    }
    else {
        passwordStrenght.addClass("low");
    }
})

    const calculatePasswordStrength = (password) => {
        let possibleChars = 1;
        
        if(/[0-9]/.test(password)){
            possibleChars += 10;
        }
        if(/[a-z]/.test(password)){
            possibleChars += 26;
        }
        if(/[A-Z]/.test(password)){
            possibleChars += 26;
        }
        return password.length * Math.log(possibleChars)/Math.log(2);
    }
    



})
