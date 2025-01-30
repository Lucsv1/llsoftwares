$(document).ready(function () {

    function deletarAgendamento(id) {
        if (confirm('Tem certeza que deseja excluir este agendamento?')) {
            $.ajax({
                url: '/agendamento',
                method: 'POST',
                data: { idDel: id },
                success: function (response) {
                    console.log(id);
                    $(`tr[data-id="${id}"]`).fadeOut(400, function () {
                        $(this).remove();
                    });
                    alert('Cliente removido com sucesso!');
                    window.location.reload();
                },
                error: function () {
                    alert('Erro na requisição');
                }
            })
        }
    }


    $('.btn-edit').on('click', function() {
        const id = $(this).data('id');
        window.location.href = '/agendamento/editar?id=' + id;

    })

    $('.btn-delete').on('click', function() {
        const id = $(this).data('id');
        deletarAgendamento(id);
    })
});