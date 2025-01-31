<?php

use Admin\Project\Controllers\AppointmentController;
use Admin\Project\Controllers\ClientsControllers;

$appointmentController = new AppointmentController();
$clientsController = new ClientsControllers();

header("Cache-Control: no-cache, must-revalidate");

if(!isset($_GET['id'])){
    return;
}

$agendamento = $appointmentController->getAppointmentById($_GET['id']);
$clients = $clientsController->getClientsById($agendamento->ID_Cliente);

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['id'])){
    try {
        // Remove the var_dump or use error_log for debugging
        // error_log($_POST['id_cliente']); // Use this instead of var_dump for debugging
        
        $appointmentController
            ->setIdClient($_POST['id_cliente'])
            ->setAppointmentDate($_POST['data_agendamento'])
            ->setStartTime($_POST['hora_inicio'])
            ->setEndTime($_POST['hora_fim'])
            ->setStatus($_POST['status'])
            ->setObservations($_POST['observacoes'])
            ->editAppointments($_GET['id']);

            header("Refresh:0");

    } catch(Exception $e) {
        error_log($e->getMessage()); // Use error_log instead of var_dump
    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Agendamento</title>
    <link rel="stylesheet" href="../../../public/styles/dashboard/scheduling.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Editar Agendamento</h1>
        </div>

        <div>
            <form action="/agendamento">
                <button class="button_exit" type="submit">
                    <span class="info_exit">
                        <img src="../../../public/assets/seta.png" alt="">
                        Voltar para agendamentos
                    </span>
                </button>
            </form>
        </div>

        <div class="content">
            <section class="form-section">
                <h2 class="form-title">Detalhes do Agendamento</h2>
                <?php if (isset($agendamento)): ?>
                    <form method="POST" >
                        <input type="hidden" name="id_agendamento" value="<?php echo $agendamento->ID_Agendamento; ?>">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="cliente">Cliente*</label>
                                <select id="cliente" name="id_cliente" required>
                                    <option value="">Selecione o cliente</option>
                                    <?php if (isset($clients)): ?>
                                        <?php foreach ($clients as $client): ?>
                                            <option value="<?php echo $client->ID; ?>" 
                                                <?php echo ($client->ID == $agendamento->ID_Cliente) ? 'selected' : ''; ?>>
                                                <?php echo $client->Nome_Completo; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="data">Data do Agendamento*</label>
                                <input type="date" id="data" name="data_agendamento" 
                                    value="<?php echo $agendamento->Data_Agendamento; ?>" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="hora_inicio">Hora Início*</label>
                                <input type="time" id="hora_inicio" name="hora_inicio" 
                                    value="<?php echo $agendamento->Hora_Inicio; ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="hora_fim">Hora Fim*</label>
                                <input type="time" id="hora_fim" name="hora_fim" 
                                    value="<?php echo $agendamento->Hora_Fim; ?>" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="status">Status*</label>
                                <select id="status" name="status" required>
                                    <?php
                                    $status_options = ['Agendado', 'Confirmado', 'Cancelado', 'Concluído'];
                                    foreach ($status_options as $status) {
                                        $selected = ($status == $agendamento->Status) ? 'selected' : '';
                                        echo "<option value='$status' $selected>$status</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-column">
                            <div class="form-group">
                                <label for="observacoes">Observações</label>
                                <textarea id="observacoes" name="observacoes" rows="4"><?php echo $agendamento->Observacoes; ?></textarea>
                            </div>
                        </div>

                        <div class="form-row button-group">
                            <button type="submit" class="btn-submit">Salvar Alterações</button>
                            <?php if ($agendamento->Status !== 'Cancelado'): ?>
                                <button type="button" class="btn-cancel" data-id="<?php echo $agendamento->ID_Agendamento; ?>">
                                    Cancelar Agendamento
                                </button>
                            <?php endif; ?>
                        </div>
                    </form>
                <?php endif; ?>
            </section>
        </div>
    </div>
    <script src="../../../public/scripts/dashboard/schedulingEdit.js"></script>
</body>

</html>