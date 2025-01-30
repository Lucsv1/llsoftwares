$(document).ready(function () {
    const $selectCliente = $('#cliente');
    const $inputClienteId = $('#cliente-id');

    // Cliente change event
    $selectCliente.on('change', function () {
        $inputClienteId.val($(this).val());
        console.log('Cliente ID:', $inputClienteId.val()); // Para debug
    });

    // Set initial value if exists
    if ($selectCliente.val()) {
        $inputClienteId.val($selectCliente.val());
    }

    const $container = $('.produtos-container');
    let productCount = 1;

    // Add new product row
    $('.adicionar-produto').on('click', function () {
        const $newRow = $('.produto-item').first().clone(true);

        // Update names for new row
        const $select = $newRow.find('select');
        const $input = $newRow.find('input');
        $select.attr('name', `produtos[${productCount}][id]`);
        $input.attr('name', `produtos[${productCount}][quantidade]`);

        // Reset values
        $select.val('');
        $input.val('1');

        // Add remove button functionality
        $newRow.find('.remover-produto').on('click', function () {
            if ($('.produto-item').length > 1) {
                $(this).closest('.produto-item').remove();
                updateTotal();
            }
        });

        $container.append($newRow);
        productCount++;
    });

    // Remove product row
    $('.remover-produto').on('click', function () {
        if ($('.produto-item').length > 1) {
            $(this).closest('.produto-item').remove();
            updateTotal();
        }
    });

    // Update total when quantity changes
    $container.on('change', '.quantidade-input, .produto-select', function () {
        updateTotal();
    });

    function updateTotal() {
        let total = 0;
        let productData = [];

        $('.produto-item').each(function () {
            
            const $select = $(this).find('.produto-select');
            const $quantityInput = $(this).find('.quantidade-input');
            const quantity = $quantityInput.val();
            const $option = $select.find(':selected');

            if ($option.length && $option.data('stock')) {
                $quantityInput.attr('max', $option.data('stock'));
                let limitQuantity = $option.data('stock');
                let priceLimit = parseFloat($option.data('price'));

                if (parseInt(quantity) > limitQuantity) {
                    $quantityInput.val(limitQuantity);
                    priceLimit = limitQuantity;
                }
                else if (quantity < 1 || isNaN(quantity)) {
                    $('#quantidade').val(1);
                    priceLimit = 1;
                }

                if ($option.data('price')) {
                    const quantityModified = $quantityInput.val();
                    const itemTotal = parseFloat($option.data('price')) * parseInt(quantityModified);
                    total += itemTotal;
                }
            }
        });

        $('#total').val(`R$ ${total.toFixed(2)}`);

    }

    // Search functionality
    const $searchInput = $('#searchInput');
    const $table = $('.clients-table');
    const $rows = $table.find('tr');

    $searchInput.on('keyup search', function () {
        const searchText = $(this).val().toLowerCase();

        $rows.slice(1).each(function () {
            const $row = $(this);
            const $clientName = $row.find('td').first();

            if ($clientName.length) {
                const nameText = $clientName.text();

                if (nameText.toLowerCase().indexOf(searchText) > -1) {
                    $row.show();

                    // Remove existing highlights and add new ones if there's a search term
                    if (searchText) {
                        const regex = new RegExp(searchText, 'gi');
                        $clientName.html(nameText.replace(regex, match =>
                            `<span class="highlight">${match}</span>`
                        ));
                    } else {
                        $clientName.html(nameText);
                    }
                } else {
                    $row.hide();
                }
            }
        });
    });

    // Edit button functionality
    $('.btn-edit').on('click', function () {
        const id = $(this).data('id');
        window.location.href = '/vendas/visualizar?id=' + id;
        console.log(id);
    });
});