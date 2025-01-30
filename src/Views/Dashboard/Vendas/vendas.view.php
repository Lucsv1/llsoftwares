<?php

use Admin\Project\Auth\Class\UserManager;
use Admin\Project\Controllers\ClientsControllers;
use Admin\Project\Controllers\OrdersControllers;
use Admin\Project\Controllers\OrdersProductsControllers;
use Admin\Project\Controllers\PaymentsControllers;
use Admin\Project\Controllers\ProductsController;

$userManager = new UserManager();
$clientesController = new ClientsControllers();
$productsController = new ProductsController();
$orderController = new OrdersControllers();
$ordersProductsController = new OrdersProductsControllers();
$paymentsController = new PaymentsControllers();


header("Cache-Control: no-cache, must-revalidate");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Validate required fields
        if (!isset($_POST['cliente-id']) || empty($_POST['cliente-id'])) {
            throw new Exception("Cliente não selecionado");
        }

        if (!isset($_POST['produtos']) || !is_array($_POST['produtos']) || empty($_POST['produtos'])) {
            throw new Exception("Nenhum produto selecionado");
        }

        // Create the order first
        $orderController
            ->setIdClient($_POST['cliente-id'])
            ->setPrice($_POST['total']);
        $lastOrderId = $orderController->createOrders();

        if (!$lastOrderId) {
            throw new Exception("Erro ao criar pedido");
        }

        var_dump($_POST['produtos']);

        // Process each product
        foreach ($_POST['produtos'] as $produto) {
            if (
                !isset($produto['id']) || !isset($produto['quantidade']) ||
                empty($produto['id']) || empty($produto['quantidade'])
            ) {
                continue;
            }

       

            $ordersProductsController
                ->setIdPedido($lastOrderId)
                ->setIdProdutos($produto['id'])
                ->setQuantidade($produto['quantidade'])
                ->setValorTotal($_POST['total']);

            $ordersProductsController->createOrdersProducts();
        }

        $paymentsController
            ->setIdOrder($lastOrderId)
            ->setMethod($_POST['metodo_pagamento'])
            ->setValuePayment($_POST['total'])
            ->createPayments();

        // Redirect or show success message
        header("Refresh:0");
        exit;
    } catch (Exception $e) {
        var_dump($e);
        $error = $e->getMessage();
    }
}

$clients = $clientesController->listClients();
$products = $productsController->listProducts();
$ordersAll = $orderController->listOrders();

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Vendas</title>
    <link rel="stylesheet" href="/../../../public/styles/dashboard/sales.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Gestão de Vendas</h1>
        </div>

        <div>
            <form action="/painel">
                <button class="button_exit" type="submit">
                    <span class="info_exit"><img src="../../../public/assets/seta.png" alt=""> Voltar para o
                        painel</span>
                </button>
            </form>
        </div>

        <div class="content">
            <section class="form-section">
                <h2 class="form-title">Registrar Nova Venda</h2>
                <form action="" method="POST">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="cliente">Cliente*</label>
                            <select id="cliente" name="cliente-id" required>
                                <option value="">Selecione o cliente</option>
                                <?php if (isset($clients)): ?>
                                    <?php foreach ($clients as $client): ?>
                                        <option value="<?php echo $client->ID; ?>">
                                            <?php echo $client->Nome_Completo; ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>

                    <input type="hidden" id="cliente-id" name="cliente-id" value="">

                    <!-- Products container -->
                    <div class="produtos-container">
                        <div class="form-row produto-item">
                            <div class="form-group">
                                <label for="produto">Produto*</label>
                                <select name="produtos[0][id]" class="produto-select" required>
                                    <option value="">Selecione o produto</option>
                                    <?php if (isset($products)): ?>
                                        <?php foreach ($products as $product): ?>
                                            <option value="<?php echo $product->ID_Produto; ?>"
                                                data-price="<?php echo $product->Preco; ?>"
                                                data-stock="<?php echo $product->Quantidade_Estoque; ?>">
                                                <?php echo $product->Nome; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>

                            <input type="hidden" id="produto-id" name="produto-id" value="">
                            <div class="form-group">
                                <label for="quantidade">Quantidade*</label>
                                <input type="number" name="produtos[0][quantidade]" id="quantidade"
                                    class="quantidade-input" min="1" value="1" required>
                            </div>

                            <button type="button" class="btn-delete remover-produto">Remover</button>
                        </div>
                    </div>

                    <button type="button" class="btn-submit adicionar-produto">Adicionar Produto</button>

                    <!-- Payment method and total remain the same -->
                    <div class="form-row">
                        <div class="form-group">
                            <label for="pagamento">Método de Pagamento*</label>
                            <select name="metodo_pagamento" required>
                                <option value="">Selecione o método</option>
                                <option value="dinheiro">Dinheiro</option>
                                <option value="cartao">Cartão</option>
                                <option value="pix">PIX</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row total-section">
                        <div class="form-group">
                            <label>Total da Venda</label>
                            <input type="text" id="total" name="total" readonly>
                            <input type="hidden" id="totalHidden" name="produtos[0][total]" readonly>
                        </div>
                    </div>

                    <button type="submit" class="btn-submit">Finalizar Venda</button>
                </form>

            </section>

            <section class="table-section">
                <h2 class="table-title">Vendas Recentes</h2>
                <div class="search-container">
                    <input type="text" id="searchInput" class="search-input"
                        placeholder="Buscar por nome do cliente...">
                </div>
                <table class="clients-table">
                    <thead>
                        <tr>
                            <th>Cliente</th>
                            <th>Data</th>
                            <th>Valor Total</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($ordersAll): ?>
                            <?php foreach ($ordersAll as $orders): ?>
                                <?php $clients = $clientesController->getClientsById($orders->ID_Cliente); ?>
                                <?php foreach ($clients as $client): ?>
                                    <tr>
                                        <td><?php echo $client->Nome_Completo; ?></td>
                                    <?php endforeach; ?>
                                    <td><?php echo date('d/m/Y', strtotime($orders->Data)); ?></td>
                                    <td><?php echo $orders->Valor_Total; ?></td>
                                    <td class="action-buttons">
                                        <button class="btn-edit" data-id="<?php echo $orders->ID_Pedido; ?>">Detalhes</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </section>
        </div>
    </div>
    <script src="/../../../public/scripts/dashboard/sales.js"></script>
</body>

</html>