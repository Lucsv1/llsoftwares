<?php

use Admin\Project\Auth\Class\UserManager;
use Admin\Project\Controllers\ClientsControllers;
use Admin\Project\Models\Clients;

$userManger = new UserManager();
$clientsController = new ClientsControllers();

header("Cache-Control: no-cache, must-revalidate");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nome_completo'])) {

    $clientsController
        ->setNameClients($_POST['nome_completo'])
        ->setTelephoneClients($_POST['contato'])
        ->setCpfClients($_POST['cpf'])
        ->setCepClients($_POST['cep'])
        ->setAddressClients($_POST['endereco'])
        ->setEmailClients($_POST['email'])
        ->setObservation($_POST['observacao'])
        ->createClient();

    header("Location: /clientes");
}


if ($clientsController->listClients()) {
    $clients = $clientsController->listClients();
}

if (isset($_POST['idDel'])) {
    $result = $clientsController->deleteClients($_POST['idDel']);

    var_dump($result);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes</title>
    <link rel="stylesheet" href="../../../public/styles/dashboard/clients.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Gestão de Clientes</h1>
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
            <!-- Formulário de Cadastro -->
            <section class="form-section">
                <h2 class="form-title">Cadastrar Novo Cliente</h2>
                <form method="POST">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="nome">Nome Completo*</label>
                            <input type="text" id="nome" name="nome_completo" required>
                        </div>

                        <div class="form-group">
                            <label for="cpf">CPF*</label>
                            <input type="text" id="cpf" name="cpf" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="contato">Telefone</label>
                            <input type="tel" id="contato" name="contato">
                        </div>

                        <div class="form-group">
                            <label for="cep">CEP</label>
                            <input type="text" id="cep" name="cep">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="endereco">Endereço</label>
                            <input type="text" id="endereco" name="endereco">
                        </div>

                        <div class="form-group">
                            <label for="email">E-mail</label>
                            <input type="email" id="email" name="email">
                        </div>
                    </div>

                    <div class="form-column">
                        <div class="form-group">
                            <label for="endereco">Observação</label>
                            <textarea type="text" id="observacao" name="observacao"></textarea>
                        </div>
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
                        <?php if (isset($clients)): ?>
                            <?php foreach ($clients as $client): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($client->Nome_Completo); ?></td>
                                    <td><?php echo htmlspecialchars($client->CPF); ?></td>
                                    <td><?php echo htmlspecialchars($client->Contato); ?></td>
                                    <td class="action-buttons">
                                        <button class="btn-edit" data-id="<?php echo $client->ID ?>">Visualizar/Editar</button>
                                        <button class="btn-delete" data-id="<?php echo $client->ID; ?>">Excluir</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </section>
        </div>
    </div>
    <script src="../../../public/scripts/dashboard/clients.js"></script>
</body>

</html>