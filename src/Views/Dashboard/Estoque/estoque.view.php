<?php

use Admin\Project\Auth\Class\UserManager;
use Admin\Project\Controllers\ProductsController;

$userManager = new UserManager();
$productsController = new ProductsController();

header("Cache-Control: no-cache, must-revalidate");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nome'])) {

    $productsController
        ->setNameProduct($_POST['nome'])
        ->setDescriptionProduct($_POST['descricao'])
        ->setQuantityStorage($_POST['quantidade'])
        ->setPriceProduct($_POST['preco'])
        ->createProduct();

    header("Location: /estoque");

}

$products = $productsController->listProducts();

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão de Estoque</title>
    <link rel="stylesheet" href="/../../../public/styles/dashboard/inventory.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Gestão de Estoque</h1>
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
            <!-- Formulário de Cadastro de Produtos -->
            <section class="form-section">
                <h2 class="form-title">Cadastrar Novo Produto</h2>
                <form action="" method="POST">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="nome">Nome do Produto*</label>
                            <input type="text" id="nome" name="nome" required>
                        </div>

                        <div class="form-group">
                            <label for="preco">Preço Unitário*</label>
                            <input type="number" id="preco" name="preco" step="0.01" min="0" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="quantidade">Quantidade em Estoque*</label>
                            <input type="number" id="quantidade" name="quantidade" min="0" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="descricao">Descrição do Produto</label>
                            <textarea id="descricao" name="descricao" rows="3"></textarea>
                        </div>
                    </div>

                    <button type="submit" class="btn-submit">Cadastrar Produto</button>
                </form>
            </section>

            <!-- Lista de Produtos em Estoque -->
            <section class="table-section">
                <h2 class="table-title">Produtos em Estoque</h2>
                <table class="clients-table">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Preço Unit.</th>
                            <th>Qtd. Estoque</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($products)): ?>
                            <?php foreach ($products as $product): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($product->Nome); ?></td>
                                    <td>R$ <?php echo number_format($product->Preco, 2, ',', '.'); ?></td>
                                    <td class="quantidade-cell <?php echo $product->Quantidade < 10 ? 'baixo-estoque' : ''; ?>">
                                        <?php echo $product->Quantidade_Estoque; ?>
                                    </td>
                                    <td class="action-buttons">
                                        <button class="btn-edit" data-id="<?php echo $product->ID_Produto; ?>">Editar</button>
                                        <button class="btn-delete"
                                            data-id="<?php echo $product->ID_Produto; ?>">Excluir</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </section>
        </div>
    </div>
    <script src="../../../public/scripts/dashboard/inventory.js"></script>
</body>

</html>