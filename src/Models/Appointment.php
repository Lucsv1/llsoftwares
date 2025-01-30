<?php

namespace Admin\Project\Models;

use Admin\Project\Config\Database;
use PDO;

class Appointment
{
    public function saveAppointment($data)
    {
        $db = new Database();
        $pdo = $db->auth_db();

        $stmt = $pdo->prepare("
            INSERT INTO Agendamentos (
                ID_Cliente, Data_Agendamento, Hora_Inicio, Hora_Fim, Status, Observacoes
            ) VALUES (
                :idClient, :appointmentDate, :startTime, :endTime, :status, :observations
            )
        ");

        $stmt->bindParam(":idClient", $data['idClient']);
        $stmt->bindParam(":appointmentDate", $data['appointmentDate']);
        $stmt->bindParam(":startTime", $data['startTime']);
        $stmt->bindParam(":endTime", $data['endTime']);
        $stmt->bindParam(":status", $data['status']);
        $stmt->bindParam(":observations", $data['observations']);

        $stmt->execute();
    }

    public function getAppointments()
    {
        $db = new Database();
        $pdo = $db->auth_db();

        $stmt = $pdo->query("SELECT * FROM Agendamentos");

        if ($stmt->rowCount() < 0) {
            return;
        }

        $data = $stmt->fetchAll(PDO::FETCH_OBJ);

        return $data;
    }

    public function getAppointmentById($id)
    {
        $db = new Database();
        $pdo = $db->auth_db();

        $stmt = $pdo->prepare("SELECT * FROM Agendamentos WHERE ID_Agendamento = :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        if ($stmt->rowCount() < 0) {
            return;
        }

        $data = $stmt->fetch(PDO::FETCH_OBJ);

        return $data;
    }

    public function delDatasAppointment($id)
    {
        $db = new Database();

        $pdo = $db->auth_db();

        $stmt = $pdo->prepare("DELETE FROM Agendamentos WHERE ID_Agendamento = :id");

        $stmt->bindParam(":id", $id);

        $stmt->execute();
    }

    public function editDatasAppointment($id, $data)
    {
        $db = new Database();
        $pdo = $db->auth_db();

        $stmt = $pdo->prepare("UPDATE Agendamentos SET ID_Cliente = :idCliente, Data_Agendamento = :dataAgendamento, Hora_Inicio = :horaInicio, Hora_Fim = :horaFim, Status = :status, Observacoes = :observacoes WHERE ID_Agendamento = $id");

        $stmt->bindParam(":idCliente", $data['idClient']);
        $stmt->bindParam(":dataAgendamento", $data['appointmentDate']);
        $stmt->bindParam(":horaInicio", $data['startTime']);
        $stmt->bindParam(":horaFim", $data['endTime']);
        $stmt->bindParam(":status", $data['status']);
        $stmt->bindParam(":observacoes", $data['observations']);

        $stmt->execute();

    }
}