<?php

use Admin\Project\Config\Database;

require_once __DIR__ .  '/vendor/autoload.php';
require_once __DIR__ . '/src/Config/Database.php';

$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$base = basename(dirname(__FILE__, 1));

$inicializationDb = new Database();
$inicializationDb->auth_db();


switch ($request) {
    case "/$base/":
        require_once __DIR__ . '/src/Views/Login/login.view.php';
        exit;
    case "/$base/painel":
        require_once __DIR__ . '/src/Views/Dashboard/painel.view.php';
        exit;
    case "/$base/clientes":
        require_once __DIR__ . '/src/Views/Dashboard/Clientes/clientes.view.php';
        exit;
    case "/$base/clientes/editar":
        require_once __DIR__ . '/src/Views/Dashboard/Clientes/ClientesEditar/clientesEditar.view.php';
        exit;
    case "/$base/vendas":
        require_once __DIR__ . '/src/Views/Dashboard/Vendas/vendas.view.php';
        exit;
    case "/$base/estoque":
        require_once __DIR__ . '/src/Views/Dashboard/Estoque/estoque.view.php';
        exit;
    case "/$base/agendamento":
        require_once __DIR__ . '/src/Views/Dashboard/Agendamento/agendamento.view.php';
        exit;
    case "/$base/relatorios":
        require_once __DIR__ . '/src/Views/Dashboard/Relatorios/relatorios.view.php';
        exit;
    case "/$base/funcionarios":
        require_once __DIR__ . '/src/Views/Dashboard/Funcionarios/funcionarios.view.php';
        exit;

    default:
        echo "404 - Página não encontrada";
        exit;
}
