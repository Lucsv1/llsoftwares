<?php

use Admin\Project\Controllers\ClientsControllers;
use Admin\Project\Controllers\OrdersControllers;
use Admin\Project\Controllers\OrdersProductsControllers;
use Admin\Project\Controllers\PaymentsControllers;
use Admin\Project\Controllers\ProductsController;

$ordersProductsController = new OrdersProductsControllers();
$productsController = new ProductsController();
$ordersController = new OrdersControllers();
$clienteController = new ClientsControllers();
$paymentsController = new PaymentsControllers();

header("Cache-Control: no-cache, must-revalidate");

// No início do arquivo, após obter o ID do pedido
if (!isset($_GET['id'])) {
    return;
}

// Busca os produtos do pedido
$ordersProducts = $ordersProductsController->getOrdersProductsById($_GET['id']);

// Array para armazenar os detalhes dos produtos
$orderDetails = [];

// Para cada produto no pedido, busca suas informações
foreach ($ordersProducts as $orderProduct) {
    // Busca os detalhes do produto
    $productInfo = $productsController->getProductsById($orderProduct->ID_Produto);

    // Armazena as informações necessárias
    $orderDetails[] = [
        'product' => $productInfo[0], // Assumindo que getProductsById retorna um array
        'quantity' => $orderProduct->Quantidade
    ];
}

// Busca informações do pedido
$orders = $ordersController->getOrdersById($_GET['id']);
$payments = $paymentsController->getPaymentsById($_GET['id']);

foreach ($orders as $order) {
    $clients = $clienteController->getClientsById($order->ID_Cliente);
    $mainPrice = $order->Valor_Total;
}

foreach ($clients as $client) {
    $nameClient = $client->Nome_Completo;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/../../../public/styles/dashboard/edit/salesView.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <title>Document</title>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Venda - <?php echo $nameClient ?></h1>
        </div>

        <div>
            <form action="/vendas">
                <button class="button_exit" type="submit">
                    <span class="info_exit">
                        <img src="../../../public/assets/seta.png" alt="Voltar">
                        Voltar para vendas
                    </span>
                </button>
            </form>
        </div>

        <section class="sale-section">
            <div class="sale-info">
                <div class="info-item">
                    <span class="info-label">Cliente</span>
                    <span class="info-value"><?php echo $nameClient ?></span>
                </div>
                <?php foreach ($payments as $payment): ?>
                    <div class="info-item">
                        <span class="info-label">Data da Venda</span>
                        <span class="info-value"><?= $payment->Data ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Método de Pagamento</span>
                        <span class="info-value"><?= $payment->Metodo_Pagamento ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Número do Pedido</span>
                        <span class="info-value">#<?= $payment->ID_Pedido ?></span>
                    </div>
                <?php endforeach ?>
            </div>

            <table class="products-table">
                <thead>
                    <tr>
                        <th>Produto</th>
                        <th>Quantidade</th>
                        <th>Preço Unitário</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                <tbody>
                    <?php if (!empty($orderDetails)): ?>
                        <?php foreach ($orderDetails as $detail): ?>
                            <tr>
                                <td><?php echo $detail['product']->Nome; ?></td>
                                <td><?php echo $detail['quantity']; ?></td>
                                <td>R$ <?php echo number_format($detail['product']->Preco, 2, ',', '.'); ?></td>
                                <td>R$
                                    <?php echo number_format($detail['product']->Preco * $detail['quantity'], 2, ',', '.'); ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
                </tbody>
            </table>

            <div class="total-section">
                <span class="total-label">Total da Venda</span>
                <span class="total-value"><?= $mainPrice ?></span>
            </div>
        </section>
    </div>
</body>

</html>