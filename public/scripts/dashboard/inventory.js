$(document).ready(function() {
    // Máscara para preço do produto
    $('#preco').on('input', function() {
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
});