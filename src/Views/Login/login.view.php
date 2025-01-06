<?php

use Admin\Project\Auth\Class\User;
use Admin\Project\Auth\Class\UserManager;
use Admin\Project\Config\Database;

$db_config = new Database();
$userManager = new UserManager();

$pdo = $db_config->auth_db();



$msg_error = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($_POST['username']) || empty($_POST['password'])) {
        $msg_error = "Por favor, preencha todos os campos.";
    } else {

        $stmt = $pdo->prepare("SELECT * FROM Users WHERE username = :username");
        $stmt->bindParam(":username", $_POST['username']);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $userFromDataBase = $stmt->fetch();
            $user = (new User)
                ->setUserName($userFromDataBase['Username'])
                ->setPassword($userFromDataBase['Password'])
                ->setRoles(array("role" => 'admin'))
                ->setEnabled($userFromDataBase['Active']);

            if ($userManager->isPasswordValid($user, $_POST['password'])) {
                $userManager->createUserToken($user);
                header("Location: /painel");
                exit;
            } else {
                $msg_error = "Nome de usuario ou senha incorretos";
            }
            $msg_error = "Nome de usuario ou senha incorretos";
        }
        $msg_error = "Nome de usuario ou senha incorretos";
    }
}

if ($userManager->hasUserToken()) {
    header("Location: /painel");
    exit;
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="/../../../public/styles/login.css">
</head>

<body>
    <div class="login-container">
        <h2>Login</h2>
        <span class="msg_error"><?php echo $msg_error ?></span>
        <form action="" method="POST">
            <label for="username">Nome de Usuário</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Senha</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Entrar</button>
        </form>
    </div>
</body>

</html>