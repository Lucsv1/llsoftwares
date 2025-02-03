$(document).ready(function() {
    // Máscara para preço do produto
    $('#preco, #precoCusto').on('input', function() {
        let value = $(this).val().replace(/[^\d.,]/g, ''); // Remove tudo exceto números, ponto e vírgula
        value = value.replace(',', '.'); // Converte vírgula para ponto
        
        // Garante que só há dois decimais
        if (value.includes('.')) {
            let parts = value.split('.');
            if (parts[1].length > 2) {
                parts[1] = parts[1].substring(0, 2);
                value = parts.join('.');
            }
        }
        
        // Formata o número com duas casas decimais
        const numValue = parseFloat(value);
        if (!isNaN(numValue)) {
            $(this).val(numValue.toFixed(2));
        }
    });

    // Máscara para quantidade (apenas números inteiros positivos)
    $('#quantidade').on('input', function() {
        let value = $(this).val().replace(/\D/g, ''); // Remove tudo exceto números
        $(this).val(value);
    });

    // Função para deletar produto
    function deletarProduto(id) {
        if(confirm('Tem certeza que deseja excluir este produto?')) {
            $.ajax({
                url: '/estoque',
                method: 'POST',
                data: { idDel: id },
                success: function(response) {
                    alert('Produto removido com sucesso!');
                    window.location.reload();
                },
                error: function() {
                    alert('Erro ao remover o produto');
                }
            });
        }
    }


    // Eventos para botões de editar e deletar
    $('.btn-edit').on('click', function() {
        const id = $(this).data('id');
        window.location.href = '/estoque/editar?id=' + id;
    });

    $('.btn-delete').on('click', function() {
        const id = $(this).data('id');
        deletarProduto(id);
    });

    // Destaque visual para produtos com baixo estoque
    $('.quantidade-cell').each(function() {
        const quantidade = parseInt($(this).text());
        if (quantidade < 10) {
            $(this).addClass('baixo-estoque');
        }
    });


    function updateQuantityMax(selectElement) {
        var selectedOption = $(selectElement).find(':selected');
        var quantityInput = $(selectElement).closest('.produto-item').find('.quantidade-input');
        
        if (selectedOption.val()) {
            var maxStock = selectedOption.data('stock');
            quantityInput.attr('max', maxStock);
            
            // Se a quantidade atual for maior que o estoque, ajusta para o máximo
            if (parseInt(quantityInput.val()) > parseInt(maxStock)) {
                quantityInput.val(maxStock);
            }
        } else {
            quantityInput.removeAttr('max');
        }
    }

    // Evento change para selects existentes
    $(document).on('change', '.produto-select', function() {
        updateQuantityMax(this);
    });

    // Opcionalmente, você pode chamar a função na inicialização para selects que já tenham um valor
    $('.produto-select').each(function() {
        if ($(this).val()) {
            updateQuantityMax(this);
        }
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