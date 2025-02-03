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

document.addEventListener('DOMContentLoaded', function(){
    
    const searchInput = document.getElementById('searchInput');
    const table = document.querySelector('.clients-table');
    const rows = table.getElementsByTagName('tr');

    searchInput.addEventListener('keyup', function(e) {
        const searchText = e.target.value.toLowerCase();
        
        // Start from index 1 to skip the header row
        for(let i = 1; i < rows.length; i++) {
            const clientName = rows[i].getElementsByTagName('td')[0];
            
            if(clientName) {
                const nameText = clientName.textContent || clientName.innerText;
                
                if(nameText.toLowerCase().indexOf(searchText) > -1) {
                    rows[i].style.display = '';
                    
                    // Remove existing highlights
                    clientName.innerHTML = nameText;
                    
                    // Add highlight if there's a search term
                    if(searchText) {
                        const regex = new RegExp(searchText, 'gi');
                        clientName.innerHTML = nameText.replace(regex, match => 
                            `<span class="highlight">${match}</span>`
                        );
                    }
                } else {
                    rows[i].style.display = 'none';
                }
            }
        }
    });
    
    // Clear search and reset display when input is cleared
    searchInput.addEventListener('search', function() {
        if(this.value === '') {
            for(let i = 1; i < rows.length; i++) {
                rows[i].style.display = '';
                const clientName = rows[i].getElementsByTagName('td')[0];
                if(clientName) {
                    clientName.innerHTML = clientName.innerText;
                }
            }
        }
    });

})