<?php

use Admin\Project\Auth\Class\UserManager;
use Admin\Project\Controllers\ClientsControllers;

$userManager = new UserManager();
$clientesController = new ClientsControllers();

header("Cache-Control: no-cache, must-revalidate");

if (!$userManager->hasUserToken()) {
    header("Location: / ");
}

if (!isset($_GET['id'])) {
    return;
}

$clients = $clientesController->getClientsById($_GET['id']);

$msg_sucess = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['id'])) {
    $clientesController
        ->setNameClients($_POST['nome_completo'])
        ->setTelephoneClients($_POST['contato'])
        ->setCpfClients($_POST['cpf'])
        ->setCepClients($_POST['cep'])
        ->setAddressClients($_POST['endereco'])
        ->setEmailClients($_POST['email'])
        ->setObservation($_POST['observacao'])
        ->editClients($_GET['id']);

        header('Location: ' . $_SERVER['PHP_SELF']);
}

// var_dump($client);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cliente</title>
    <link rel="stylesheet" href="../../../public/styles/dashboard/clients.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Editar Cliente</h1>
        </div>

        <div>
            <form action="/clientes">
                <button class="button_exit" type="submit">
                    <span class="info_exit"><img src="../../../public/assets/seta.png" alt=""> Voltar para Clientes</span>
                </button>
            </form>
        </div>

        <div class="content">
            <!-- Formulário de Edição -->
            <section class="form-section">
                <?php foreach ($clients as $client): ?>
                    <div class="infos_init">
                        <h2 class="form-title">Editar Informações do Cliente</h2>
                        <span><?php echo $msg_sucess?></span>
                        <span><?php echo date("d/m/Y H:i:s", strtotime($client->Created_At)); ?></span>
                    </div>
                    <form action="" method="POST">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="nome">Nome Completo*</label>
                                <input type="text" id="nome" name="nome_completo" value="<?php echo htmlspecialchars($client->Nome_Completo); ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="cpf">CPF*</label>
                                <input type="text" id="cpf" name="cpf" value="<?php echo htmlspecialchars($client->CPF); ?>" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="contato">Telefone</label>
                                <input type="tel" id="contato" name="contato" value="<?php echo htmlspecialchars($client->Contato); ?>">
                            </div>

                            <div class="form-group">
                                <label for="cep">CEP</label>
                                <input type="text" id="cep" name="cep" value="<?php echo htmlspecialchars($client->CEP); ?>">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="endereco">Endereço</label>
                                <input type="text" id="endereco" name="endereco" value="<?php echo htmlspecialchars($client->Endereco); ?>">
                            </div>

                            <div class="form-group">
                                <label for="email">E-mail</label>
                                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($client->Email); ?>">
                            </div>
                        </div>

                        <div class="form-column">
                            <div class="form-group">
                                <label for="endereco">Observação</label>
                                <textarea type="text" id="observacao" name="observacao"><?php echo $client->Observacoes ?  htmlspecialchars($client->Observacoes) : "";?></textarea>
                            </div>
                        </div>

                
                        <button type="submit" class="btn-submit">Atualizar Cliente</button>
                    </form>
                <?php endforeach ?>
            </section>
        </div>
    </div>
    <script src="../../../public/scripts/dashboard/edit/clientEdit.js"></script>
    <script src="../../../public/scripts/dashboard/clients.js"></script>
</body>

</html>