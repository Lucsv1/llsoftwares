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
                    <span class="info_exit"><img src="../../../public/assets/seta.png" alt=""> Voltar para o painel</span>
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
                            <select id="cliente" name="cliente" required>
                                <option value="">Selecione o cliente</option>
                                <?php if (isset($clients)): ?>
                                    <?php foreach ($clients as $client): ?>
                                        <option value="<?php echo $client->ID; ?>"><?php echo $client->Nome_Completo; ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>

                    <div class="produtos-container">
                        <div class="form-row produto-item">
                            <div class="form-group">
                                <label for="produto">Produto*</label>
                                <select name="produtos[]" required>
                                    <option value="">Selecione o produto</option>
                                    <?php if (isset($products)): ?>
                                        <?php foreach ($products as $product): ?>
                                            <option value="<?php echo $product->ID_Produto; ?>"><?php echo $product->Nome; ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="quantidade">Quantidade*</label>
                                <input type="number" name="quantidades[]" min="1" value="1" required>
                            </div>
                            <button type="button" class="btn-delete remover-produto">Remover</button>
                        </div>
                    </div>

                    <button type="button" class="btn-submit adicionar-produto">Adicionar Produto</button>

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
                            <input type="text" id="total" readonly>
                        </div>
                    </div>

                    <button type="submit" class="btn-submit">Finalizar Venda</button>
                </form>
            </section>

            <section class="table-section">
                <h2 class="table-title">Vendas Recentes</h2>
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
                        <?php if (isset($vendas)): ?>
                            <?php foreach ($vendas as $venda): ?>
                                <tr>
                                    <td><?php echo $venda->Nome_Cliente; ?></td>
                                    <td><?php echo date('d/m/Y', strtotime($venda->Data)); ?></td>
                                    <td>R$ <?php echo number_format($venda->Valor_Total, 2, ',', '.'); ?></td>
                                    <td class="action-buttons">
                                        <button class="btn-edit" data-id="<?php echo $venda->ID_Pedido; ?>">Detalhes</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </section>
        </div>
    </div>
    <script src="../../../public/scripts/dashboard/sales.js"></script>
</body>
</html>