document.addEventListener('DOMContentLoaded', function() {

    const selectCliente = document.getElementById('cliente');
    const inputClienteId = document.getElementById('cliente-id');

    // Adiciona o evento de change no select
    selectCliente.addEventListener('change', function() {
        inputClienteId.value = this.value;
        console.log('Cliente ID:', inputClienteId.value); // Para debug
    });

    // Para garantir que o valor seja definido se já houver uma seleção
    if (selectCliente.value) {
        inputClienteId.value = selectCliente.value;
    }

    const container = document.querySelector('.produtos-container');
    let productCount = 1;

    // Add new product row
    document.querySelector('.adicionar-produto').addEventListener('click', function() {
        const newRow = document.querySelector('.produto-item').cloneNode(true);
        
        // Update names for new row
        const select = newRow.querySelector('select');
        const input = newRow.querySelector('input');
        select.name = `produtos[${productCount}][id]`;
        input.name = `produtos[${productCount}][quantidade]`;
        
        // Reset values
        select.value = '';
        input.value = '1';
        
        // Add remove button functionality
        newRow.querySelector('.remover-produto').addEventListener('click', function() {
            if (document.querySelectorAll('.produto-item').length > 1) {
                this.closest('.produto-item').remove();
                updateTotal();
            }
        });
        
        container.appendChild(newRow);
        productCount++;
    });

    // Remove product row
    document.querySelector('.remover-produto').addEventListener('click', function() {
        if (document.querySelectorAll('.produto-item').length > 1) {
            this.closest('.produto-item').remove();
            updateTotal();
        }
    });

    // Update total when quantity changes
    container.addEventListener('change', function(e) {
        if (e.target.classList.contains('quantidade-input') || 
            e.target.classList.contains('produto-select')) {
            updateTotal();
        }
    });

    function updateTotal() {
        let total = 0;
        const rows = document.querySelectorAll('.produto-item');
        
        rows.forEach(row => {
            const select = row.querySelector('.produto-select');
            const quantity = row.querySelector('.quantidade-input').value;
            const option = select.selectedOptions[0];
            
            if (option && option.dataset.price) {
                total += parseFloat(option.dataset.price) * parseInt(quantity);
            }
        });
        
        document.getElementById('total').value = `R$ ${total.toFixed(2)}`;
    }
});

