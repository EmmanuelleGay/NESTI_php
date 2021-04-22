// delete modal
$(() => {
    $("#deleteModal").on("show.bs.modal", (e) => {
        var button = $(e.relatedTarget);
        var id = button.data("id");
        $("#confirmDelete").attr("href", baseUrl + "/recipe/confirmDelete/" + id);
    })
})

// Image
$(() => {
    let preview = $('#image-upload__preview');

    const updatePreview = (property) => {
        preview.css('background-image', property);
        preview.hide();
        preview.fadeIn(500);
    }

    if (preview.css('background-image') == "none") {
        updatePreview(placeHolder);
    }

    $("#image-upload__add").change((e) => {
        let input = e.target;
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = (e) => {
                updatePreview('url(' + e.target.result + ')');
            };
            reader.readAsDataURL(input.files[0]);
        }
    });

    $("#image-upload__delete").click(() => {
        $("#image-upload__add").val(null).clone(true);
        updatePreview(placeHolder);
    });


    constructParagraphs();
    var addParagraphButton = document.getElementById("createPreparationButton");
    // on ne mets pas les parentheses pour que ca lance la fonction
    addParagraphButton.onclick = addParagraph;

})


// on fait une constant exactement comme si c'était une fonction (c'est pareil)
const constructParagraphs = () => { // var paragraphContentContainer = document.createElement("div");

    var paragraphContentContainer = document.getElementById("contentParagraph");

    $.post(baseUrl + "recipe/getParagraphs/" + vars['entity']['id'], {
        // dans le controleur => on envoie les données, ex si on ajoute un paragraphe
        // "maclé" => pourrait être un tableau
        "maclé": "mavaleur"
    }, (response) => {
        let paragraphs = JSON.parse(response);
        let paragraphContainerHtml = "";
        paragraphs.forEach(p => paragraphContainerHtml += constructParagraph(p));
        $("#contentParagraph").html(paragraphContainerHtml);
    });
}


const constructParagraph = (paragraph) => {
    return `
   <div class="mb-3 d-flex paragraph" data-id="${
        paragraph.idParagraph
    }">
        <div class="containerButton" >
            <button onclick="moveParagraph(-1)" class="btn upButton"><img src="${baseUrl}public/images/up-svg.png" alt="monter" width="100%"></button>
            <button onclick="moveParagraph(1)" class="btn downButton"><img src="${baseUrl}public/images/down-svg.png" alt="descendre" width="100%"></button>
            <button onclick="deleteParagraph()" class="btn binButton"><img src="${baseUrl}public/images/delete-svg.png" alt="supprimer" width="100%"></button>
        </div>
        <textarea onblur="saveParagraph()"  class="form-control" rows="6">${
        paragraph.content
    }</textarea>
    </div>`;
}

const addParagraph = () => {
    $.post(baseUrl + "recipe/addParagraph/" + vars['entity']['id'], (response) => {
        constructParagraphs();
    });
}

const saveParagraph = () => {
    let paragraph = event.target;
    let id = paragraph.closest(".paragraph").dataset.id;
    $.post(baseUrl + "recipe/saveParagraph/" + vars['entity']['id'], {
        "idParagraph": id,
        "content": paragraph.value
    });
}

const deleteParagraph = () => {
    let button = event.target;
    let id = button.closest(".paragraph").dataset.id;
    $.post(baseUrl + "recipe/deleteParagraph/" + vars['entity']['id'], {
        "idParagraph": id
    }, () => {
        constructParagraphs();
    });

}

const moveParagraph =(direction) =>{
let button = event.target;
let id = button.closest(".paragraph").dataset.id;
$.post(baseUrl + "recipe/moveParagraph/" + vars['entity']['id'], {
    "idParagraph": id,
    "direction" : direction
}, () => {
    constructParagraphs();
});
}

