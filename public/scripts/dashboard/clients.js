$(document).ready(function() {
    // Função para editar cliente
    

    // Função para deletar cliente
    function deletarCliente(id) {
        if(confirm('Tem certeza que deseja excluir este cliente?')) {
            $.ajax({
                url: '/clientes',
                method: 'POST',
                data: { idDel: id },
                success: function(response) {
                    console.log(id);
                    $(`tr[data-id="${id}"]`).fadeOut(400, function() {
                        $(this).remove();
                    });
                    alert('Cliente removido com sucesso!');
                    window.location.reload();
                },
                error: function() {
                    alert('Erro na requisição');
                }
            });
        }
    }

    // Máscara para CPF
    $('#cpf').on('input', function() {
        let value = $(this).val().replace(/\D/g, '');
        if(value.length > 11) value = value.slice(0, 11);
        value = value.replace(/(\d{3})(\d)/, '$1.$2');
        value = value.replace(/(\d{3})(\d)/, '$1.$2');
        value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
        $(this).val(value);
    });

    // Máscara para CEP
    $('#cep').on('input', function() {
        let value = $(this).val().replace(/\D/g, '');
        if(value.length > 8) value = value.slice(0, 8);
        value = value.replace(/(\d{5})(\d)/, '$1-$2');
        $(this).val(value);
    });

    // Máscara para telefone
    $('#contato').on('input', function() {
        let value = $(this).val().replace(/\D/g, '');
        if(value.length > 11) value = value.slice(0, 11);
        if(value.length > 10) {
            value = value.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
        } else if(value.length > 5) {
            value = value.replace(/(\d{2})(\d{4})(\d{0,4})/, '($1) $2-$3');
        } else if(value.length > 2) {
            value = value.replace(/(\d{2})(\d{0,5})/, '($1) $2');
        }
        $(this).val(value);
    });

    // Envio do formulário com AJAX
    $('#formCliente').on('submit', function(e) {
        e.preventDefault();
        
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if(response.success) {
                    alert('Cliente salvo com sucesso!');
                    // Recarrega a tabela ou adiciona nova linha
                    location.reload();
                } else {
                    alert('Erro ao salvar cliente: ' + response.message);
                }
            },
            error: function() {
                alert('Erro na requisição');
            }
        });
    });

    // Consulta CEP automaticamente
    $('#cep').on('blur', function() {
        let cep = $(this).val().replace(/\D/g, '');
        
        if(cep.length === 8) {
            $.ajax({
                url: `https://viacep.com.br/ws/${cep}/json/`,
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    if(!data.erro) {
                        $('#endereco').val(`${data.logradouro}, ${data.bairro}, ${data.localidade} - ${data.uf}`);
                    }
                }
            });
        }
    });

    $('.btn-edit').on('click', function() {
        const id = $(this).data('id');
        window.location.href = '/clientes/editar?id=' + id;
        // editarCliente(id);
        console.log(id);
    });

    $('.btn-delete').on('click', function() {
        const id = $(this).data('id');
        deletarCliente(id);
        console.log(id);
    });

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