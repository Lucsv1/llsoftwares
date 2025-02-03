$(document).ready(function () {

    const urlParams = new URLSearchParams(window.location.search);
    const id = urlParams.get("id");

    $.ajax({
        url: "",
        type: "GET",
        data: {
            id: id,
        },
        cache: true,
        success: function (response) {
           
        },
    });

    $(".btn-submit").click(function () {
        alert("Agendamento Atualizado");
    })

    $(".btn-cancel").click(function () {

        const idCancel = $(this).data('id');

        console.log(idCancel);

        $.ajax({
            url: "",
            method: "POST",
            data: {
                idCancel: idCancel,
            },
            cache: true,
            success: function (response) {
                console.log(id);
                window.location.reload();
            }
        })
    })

});