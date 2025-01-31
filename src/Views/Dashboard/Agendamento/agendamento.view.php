<?php

use Admin\Project\Controllers\AppointmentController;
use Admin\Project\Controllers\ClientsControllers;

$appointmentController = new AppointmentController();
$appointment = $appointmentController->listAppointments();

$clientController = new ClientsControllers();
$clients = $clientController->listClients();

$appointmentDetails = [];

if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['data_agendamento']) ) {
    try {
        $appointmentController
            ->setIdClient($_POST['id_cliente'])
            ->setAppointmentDate($_POST['data_agendamento'])
            ->setStartTime($_POST['hora_inicio'])
            ->setEndTime($_POST['hora_fim'])
            ->setStatus($_POST['status'])
            ->setObservations($_POST['observacoes'])
            ->createAppointment();

        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;

    } catch (Exception $e) {
        
    }

}

if($appointment){
    foreach ($appointment as $agendamento) {
    
        $clientInfo = $clientController->getClientsById($agendamento->ID_Cliente);
    
        $appointmentDetails[] = [
            'client' => $clientInfo[0],
            'idAgendamento' => $agendamento->ID_Agendamento,
            'data' => $agendamento->Data_Agendamento,
            'horarioInicio' => $agendamento->Hora_Inicio,
            'horarioFim' => $agendamento->Hora_Fim,
            'status' => $agendamento->Status
        ];
    
    }
}


if(isset($_POST['idDel'])){
    $appointmentController->deleteClients($_POST['idDel']);
}


?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendamentos</title>
    <link rel="stylesheet" href="../../../public/styles/dashboard/scheduling.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Gestão de Agendamentos</h1>
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
            <!-- Formulário de Agendamento -->
            <section class="form-section">
                <h2 class="form-title">Novo Agendamento</h2>
                <form action="/" method="POST">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="cliente">Cliente*</label>
                            <select id="cliente" name="id_cliente" required>
                                <option value="">Selecione o cliente</option>
                                <?php if (isset($clients)): ?>
                                    <?php foreach ($clients as $client): ?>
                                        <option value="<?php echo $client->ID; ?>">
                                            <?php echo $client->Nome_Completo; ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="data">Data do Agendamento*</label>
                            <input type="date" id="data" name="data_agendamento" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="hora_inicio">Hora Início*</label>
                            <input type="time" id="hora_inicio" name="hora_inicio" required>
                        </div>

                        <div class="form-group">
                            <label for="hora_fim">Hora Fim*</label>
                            <input type="time" id="hora_fim" name="hora_fim" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select id="status" name="status">
                                <option value="Agendado">Agendado</option>
                                <option value="Confirmado">Confirmado</option>
                                <option value="Cancelado">Cancelado</option>
                                <option value="Concluído">Concluído</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-column">
                        <div class="form-group">
                            <label for="observacoes">Observações</label>
                            <textarea id="observacoes" name="observacoes"></textarea>
                        </div>
                    </div>

                    <button type="submit" class="btn-submit">Criar Agendamento</button>
                </form>
            </section>

            <!-- Lista de Agendamentos -->
            <section class="table-section">
                <h2 class="table-title">Agendamentos</h2>
                <div class="search-container">
                    <input type="text" id="searchInput" class="search-input" placeholder="Buscar agendamento...">
                </div>
                <table class="clients-table">
                    <thead>
                        <tr>
                            <th>Cliente</th>
                            <th>Data</th>
                            <th>Horário</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($appointment): ?>
                            <?php foreach ($appointmentDetails as $agendamento): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($agendamento['client']->Nome_Completo); ?></td>
                                    <td><?php echo date('d/m/Y', strtotime($agendamento['data'])); ?></td>
                                    <td><?php echo date('H:i', strtotime($agendamento['horarioInicio'])) . ' - ' .
                                        date('H:i', strtotime($agendamento['horarioFim'])); ?></td>
                                    <td><?php echo htmlspecialchars($agendamento['status']); ?></td>
                                    <td class="action-buttons">
                                        <button class="btn-edit"
                                            data-id="<?php echo $agendamento['idAgendamento']; ?>">Editar</button>
                                        <button class="btn-delete"
                                            data-id="<?php echo $agendamento['idAgendamento']; ?>">Cancelar</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </section>
        </div>
    </div>
    <script src="../../../public/scripts/dashboard/scheduling.js"></script>
</body>

</html>