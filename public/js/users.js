
// le $(()) => permet de n'excuter ce code qu'à la fin de la page (et donc après la création de la modale)
$(()=>{
    $("#deleteModal").on("show.bs.modal", (e) => {
        var button = $(e.relatedTarget);
        var id = button.data("id");
        $("#confirmDelete").attr("href", baseUrl+"/users/confirmDelete/"+id);
    })
})
