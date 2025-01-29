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

if (!isset($_GET['id'])) {
    return;
}

$ordersProducts = $ordersProductsController->getOrdersProductsById($_GET['id']);


foreach ($ordersProducts as $orderProduct) {
    $products[] = $productsController->getProductsById($orderProduct->ID_Produto);
    $orders = $ordersController->getOrdersById($orderProduct->ID_Pedido);
    $payments = $paymentsController->getPaymentsById($orderProduct->ID_Pedido);
    foreach ($orders as $order) {
        $clients = $clienteController->getClientsById($order->ID_Cliente);
        $mainPrice = $order->Valor_Total;
    }
}

foreach ($clients as $client) {
    $nameClient = $client->Nome_Completo;
}

var_dump($products);

if (!$clients) {
    return;
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
                    <?php if ($products): ?>
                        <?php foreach ($products as $productArray): ?>
                            <?php
                            // Como cada item é um array contendo um objeto, pegamos o primeiro item
                            $product = $productArray[0];
                            ?>
                            <tr>
                                <td><?php echo $product->Nome; ?></td>
                                <td><?php echo $orderProduct->Quantidade; ?></td>
                                <td>R$ <?php echo number_format($product->Preco, 2, ',', '.'); ?></td>
                                <td>R$ <?php echo number_format($product->Preco * $orderProduct->Quantidade, 2, ',', '.'); ?>
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