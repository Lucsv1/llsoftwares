<?php

use Admin\Project\Auth\Class\UserManager;

$userManager = new UserManager();

$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

header("Cache-Control: no-cache, must-revalidate");

if (!$userManager->hasUserToken()) {
    header("Location: / ");
}

$token = $userManager->getUserToken();
$user = $token->getUser();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel</title>
    <link rel="stylesheet" href="/../../../public/styles/painel.css">
</head>

<body>
    <div class="container">
        <h1 class="title">Sistema de Gestão</h1>
        <div class="grid">
            <!-- Card Clientes -->
            <div class="card">
                <form action="/clientes" method="POST">
                    <button type="submit">
                        <div class="card-image">
                            <img src="../../../public/assets/icon_client.png" alt="Cadastro de Clientes">
                        </div>
                        <div class="card-title">Cadastro de Clientes</div>
                    </button>
                </form>
            </div>

            <!-- Card Vendas -->
            <div class="card">
                <form action="/vendas" method="POST">
                    <button type="submit">
                        <div class="card-image">
                            <img src="../../../public/assets/icon_gestao_vendas.png" alt="Gestão de Vendas">
                        </div>
                        <div class="card-title">Gestão de Vendas</div>
                    </button>
                </form>
            </div>

            <!-- Card Estoque -->
            <div class="card">
                <form action="/estoque" method="POST">
                    <button type="submit">
                        <div class="card-image">
                            <img src="../../../public/assets/product_Managent.png" alt="Controle de Estoque">
                        </div>
                        <div class="card-title">Controle de Estoque</div>
                    </button>
                </form>
            </div>

            <!-- Card Agendamento -->
            <div class="card">
                <form action="/agendamento" method="POST">
                    <button type="submit">
                        <div class="card-image">
                            <img src="../../../public/assets/icon_agendamento.png" alt="Agendamento de Serviços">
                        </div>
                        <div class="card-title">Agendamento de Serviços</div>
                    </button>
                </form>
            </div>

            <!-- Card Relatórios -->
            <div class="card">
                <form action="/relatorios" method="POST">
                    <button type="submit">
                        <div class="card-image">
                            <img src="../../../public/assets/icon_relatorio.png" alt="Relatórios Financeiros">
                        </div>
                        <div class="card-title">Relatórios Financeiros</div>
                    </button>
                </form>
            </div>

            <!-- Card Funcionários -->
            <div class="card">
                <form action="/funcionarios" method="POST">
                    <button type="submit">
                        <div class="card-image">
                            <img src="../../../public/assets/icon_gestao_funcionarios.png" alt="Gestão de Funcionários">
                        </div>
                        <div class="card-title">Gestão de Funcionários</div>
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>