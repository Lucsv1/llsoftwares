document.addEventListener('DOMContentLoaded', function () {

    const selectCliente = document.getElementById('cliente');
    const inputClienteId = document.getElementById('cliente-id');

    // Adiciona o evento de change no select
    selectCliente.addEventListener('change', function () {
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
    document.querySelector('.adicionar-produto').addEventListener('click', function () {
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
        newRow.querySelector('.remover-produto').addEventListener('click', function () {
            if (document.querySelectorAll('.produto-item').length > 1) {
                this.closest('.produto-item').remove();
                updateTotal();
            }
        });

        container.appendChild(newRow);
        productCount++;
    });

    // Remove product row
    document.querySelector('.remover-produto').addEventListener('click', function () {
        if (document.querySelectorAll('.produto-item').length > 1) {
            this.closest('.produto-item').remove();
            updateTotal();
        }
    });

    // Update total when quantity changes
    container.addEventListener('change', function (e) {
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



            if (option && option.dataset.stock) {
                row.querySelector('.quantidade-input').max = option.dataset.stock;
                limitQuantity = option.dataset.stock;

                if (parseInt(quantity) > limitQuantity) {
                    row.querySelector('.quantidade-input').value = limitQuantity;

                }

                else if (quantity < 1 || isNaN(quantity)) {
                    document.getElementById('quantidade').value = 1;
                }

                if (option && option.dataset.price) {
                    const quantityModdified = row.querySelector('.quantidade-input').value;
                    total += parseFloat(option.dataset.price) * parseInt(quantityModdified);
                }
            }

        });

        document.getElementById('total').value = `R$ ${total.toFixed(2)}`;
        document.getElementById('totalByProducts').value = `R$ ${total.toFixed(2)}`;

    }

    const searchInput = document.getElementById('searchInput');
    const table = document.querySelector('.clients-table');
    const rows = table.getElementsByTagName('tr');

    searchInput.addEventListener('keyup', function (e) {
        const searchText = e.target.value.toLowerCase();

        // Start from index 1 to skip the header row
        for (let i = 1; i < rows.length; i++) {
            const clientName = rows[i].getElementsByTagName('td')[0];

            if (clientName) {
                const nameText = clientName.textContent || clientName.innerText;

                if (nameText.toLowerCase().indexOf(searchText) > -1) {
                    rows[i].style.display = '';

                    // Remove existing highlights
                    clientName.innerHTML = nameText;

                    // Add highlight if there's a search term
                    if (searchText) {
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
    searchInput.addEventListener('search', function () {
        if (this.value === '') {
            for (let i = 1; i < rows.length; i++) {
                rows[i].style.display = '';
                const clientName = rows[i].getElementsByTagName('td')[0];
                if (clientName) {
                    clientName.innerHTML = clientName.innerText;
                }
            }
        }
    });

});


$(document).ready(function () {
    $('.btn-edit').on('click', function () {
        const id = $(this).data('id');
        window.location.href = '/vendas/visualizar?id=' + id;
        // editarCliente(id);
        console.log(id);
    });
});
