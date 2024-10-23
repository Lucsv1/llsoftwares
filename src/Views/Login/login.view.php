<?php

require_once __DIR__ .  '/../../../vendor/autoload.php';

use Admin\Project\Auth\Class\User;
use Admin\Project\Auth\Class\UserManager;
use Admin\Project\Config\Database;

$db_config = new Database();

$pdo = $db_config->auth_db();

$stmt = $pdo->prepare("SELECT * FROM Users WHERE username = :username");
$stmt->bindValue(":username", $_POST['username']);
$userFromDataBase = $stmt->fetch();

$user = (new User)
->setUserName($userFromDataBase['username'])
->setPassword($userFromDataBase['password'])
->setRoles(json_decode($userFromDataBase['roles']))
->setEnabled($userFromDataBase['active']);

$userManager = new UserManager();

if($userManager->isPasswordValid($user, $_POST['password'])){
    $userManager->createUserToken($user);
}else{
    echo "Credencias Erradas";
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="login-container">
        <h2>Login</h2>
        <form action="login.php" method="POST">
            <label for="username">Nome de Usuário</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Senha</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Entrar</button>
        </form>
    </div>
</body>
</html>

<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f7f7f7;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
    }

    .login-container {
        background: #fff;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        width: 300px;
        text-align: center;
    }

    .login-container h2 {
        margin-bottom: 20px;
    }

    .login-container label {
        display: block;
        margin: 10px 0 5px;
    }

    .login-container input {
        width: 100%;
        padding: 10px;
        margin: 10px 0;
        border: 1px solid #ddd;
        border-radius: 5px;
    }

    .login-container button {
        width: 100%;
        padding: 10px;
        background-color: #5cb85c;
        border: none;
        border-radius: 5px;
        color: white;
        font-size: 16px;
        cursor: pointer;
    }

    .login-container button:hover {
        background-color: #4cae4c;
    }
</style>