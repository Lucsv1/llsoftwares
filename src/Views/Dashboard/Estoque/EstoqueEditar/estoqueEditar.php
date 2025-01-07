<?php 

use Admin\Project\Auth\Class\UserManager;
use Admin\Project\Controllers\ProductsController;

$userManager = new UserManager();
$productsController = new ProductsController();

header("Cache-Control: no-cache, must-revalidate");

if (!isset($_GET['id'])) {
    return;
}

$
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Produto</title>
    <link rel="stylesheet" href="/../../../public/styles/dashboard/inventory.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Editar Produto</h1>
        </div>

        <div>
            <form action="/estoque">
                <button class="button_exit" type="submit">
                    <span class="info_exit"><img src="../../../public/assets/seta.png" alt=""> Voltar para
                        Estoque</span>
                </button>
            </form>
        </div>

        <div class="content">
            <section class="form-section">
                <?php foreach($products as $product): ?>
                <h2 class="form-title">Dados do Produto</h2>
                <form action="" method="POST">
                    <input type="hidden" name="id_produto" value="<?php echo $product->ID_Produto; ?>">

                    <div class="form-row">
                        <div class="form-group">
                            <label for="nome">Nome do Produto*</label>
                            <input type="text" id="nome" name="nome"
                                value="<?php echo htmlspecialchars($product->Nome); ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="preco">Preço Unitário*</label>
                            <input type="number" id="preco" name="preco" step="0.01" min="0"
                                value="<?php echo $product->Preco; ?>" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="quantidade">Quantidade em Estoque*</label>
                            <input type="number" id="quantidade" name="quantidade_estoque" min="0"
                                value="<?php echo $product->Quantidade_Estoque; ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="estoque_minimo">Estoque Mínimo</label>
                            <input type="number" id="estoque_minimo" name="estoque_minimo" min="0"
                                value="<?php echo $product->Estoque_Minimo; ?>">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="preco_custo">Preço de Custo</label>
                            <input type="number" id="preco_custo" name="preco_custo" step="0.01" min="0"
                                value="<?php echo $product->Preco_Custo; ?>">
                        </div>

                        <div class="form-group">
                            <label for="codigo_barras">Código de Barras</label>
                            <input type="text" id="codigo_barras" name="codigo_barras"
                                value="<?php echo htmlspecialchars($product->Codigo_Barras); ?>">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="descricao">Descrição do Produto</label>
                            <textarea id="descricao" name="descricao"
                                rows="3"><?php echo htmlspecialchars($product->Descricao); ?></textarea>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="status">Status do Produto</label>
                            <select id="status" name="status">
                                <option value="Ativo" <?php echo $product->Status == 'Ativo' ? 'selected' : ''; ?>>Ativo
                                </option>
                                <option value="Inativo" <?php echo $product->Status == 'Inativo' ? 'selected' : ''; ?>>
                                    Inativo</option>
                                <option value="Sem_Estoque" <?php echo $product->Status == 'Sem_Estoque' ? 'selected' : ''; ?>>Sem Estoque</option>
                            </select>
                        </div>
                    </div>
                    <?php endforeach ?>

                    <!-- Seção de Movimentação de Estoque -->
                    <div class="form-section-divider">
                        <h3>Movimentação de Estoque</h3>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="tipo_movimentacao">Tipo de Movimentação</label>
                            <select id="tipo_movimentacao" name="tipo_movimentacao">
                                <option value="">Selecione o tipo</option>
                                <option value="Entrada">Entrada</option>
                                <option value="Saída">Saída</option>
                                <option value="Ajuste">Ajuste</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="quantidade_movimentacao">Quantidade</label>
                            <input type="number" id="quantidade_movimentacao" name="quantidade_movimentacao" min="1">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="motivo">Motivo da Movimentação</label>
                            <textarea id="motivo" name="motivo" rows="2"></textarea>
                        </div>
                    </div>

                    <div class="button-group">
                        <button type="submit" class="btn-submit">Salvar Alterações</button>
                        <button type="button" class="btn-delete"
                            onclick="window.location.href='/estoque'">Cancelar</button>
                    </div>
                </form>
            </section>

            <!-- Histórico de Movimentações -->
            <section class="table-section">
                <h2 class="table-title">Histórico de Movimentações</h2>
                <table class="clients-table">
                    <thead>
                        <tr>
                            <th>Data</th>
                            <th>Tipo</th>
                            <th>Quantidade</th>
                            <th>Motivo</th>
                            <th>Usuário</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($movimentacoes)): ?>
                            <?php foreach ($movimentacoes as $movimentacao): ?>
                                <tr>
                                    <td><?php echo date('d/m/Y H:i', strtotime($movimentacao->Data)); ?></td>
                                    <td><?php echo $movimentacao->Tipo; ?></td>
                                    <td><?php echo $movimentacao->Quantidade; ?></td>
                                    <td><?php echo htmlspecialchars($movimentacao->Motivo); ?></td>
                                    <td><?php echo htmlspecialchars($movimentacao->Nome_Usuario); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </section>
        </div>
    </div>
    <script src="../../../public/scripts/dashboard/edit/inventoryEdit.js"></script>
</body>

</html>