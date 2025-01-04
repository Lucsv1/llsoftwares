<?php 

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes</title>
    <link rel="stylesheet" href="../../../projeto_futuro/public/styles/dashboard/clientes.css">
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Gestão de Clientes</h1>
        </div>

        <div>
            <form action="/projeto_futuro/painel">
                <button class="button_exit" type="submit">
                    <span class="info_exit"><img src="../../../projeto_futuro/public/assets/seta.png" alt=""> Voltar para o painel</span>
                </button>
            </form>
        </div>

        <div class="content">
            <!-- Formulário de Cadastro -->
            <section class="form-section">
                <h2 class="form-title">Cadastrar Novo Cliente</h2>
                <form action="" method="POST">
                    <div class="form-group">
                        <label for="nome">Nome Completo*</label>
                        <input type="text" id="nome" name="nome_completo" required>
                    </div>

                    <div class="form-group">
                        <label for="cpf">CPF*</label>
                        <input type="text" id="cpf" name="cpf" required>
                    </div>

                    <div class="form-group">
                        <label for="contato">Telefone</label>
                        <input type="tel" id="contato" name="contato">
                    </div>

                    <div class="form-group">
                        <label for="cep">CEP</label>
                        <input type="text" id="cep" name="cep">
                    </div>

                    <div class="form-group">
                        <label for="endereco">Endereço</label>
                        <input type="text" id="endereco" name="endereco">
                    </div>

                    <div class="form-group">
                        <label for="email">E-mail</label>
                        <input type="email" id="email" name="email">
                    </div>

                    <button type="submit" class="btn-submit">Cadastrar Cliente</button>
                </form>
            </section>

            <!-- Lista de Clientes -->
            <section class="table-section">
                <h2 class="table-title">Clientes Cadastrados</h2>
                <table class="clients-table">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>CPF</th>
                            <th>Contato</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Aqui você irá inserir os dados dos clientes via PHP -->
                        <?php foreach ($clientes as $cliente): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($cliente['nome_completo']); ?></td>
                                <td><?php echo htmlspecialchars($cliente['cpf']); ?></td>
                                <td><?php echo htmlspecialchars($cliente['contato']); ?></td>
                                <td class="action-buttons">
                                    <button class="btn-edit" onclick="editarCliente(<?php echo $cliente['id']; ?>)">Editar</button>
                                    <button class="btn-delete" onclick="deletarCliente(<?php echo $cliente['id']; ?>)">Excluir</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </section>
        </div>
    </div>
</body>

</html>