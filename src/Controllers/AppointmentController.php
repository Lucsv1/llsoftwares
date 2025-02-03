<?php

namespace Admin\Project\Controllers;

use Admin\Project\Models\Appointment;
use Admin\Project\Models\AppointmentModel;

class AppointmentController
{
    private $idClient;
    private $appointmentDate;
    private $startTime;
    private $endTime;
    private $status;
    private $observations;

    // Getters and Setters

    public function getIdClient()
    {
        return $this->idClient;
    }

    public function setIdClient($idClient): self
    {
        $this->idClient = $idClient;
        return $this;
    }

    public function getAppointmentDate()
    {
        return $this->appointmentDate;
    }

    public function setAppointmentDate($appointmentDate): self
    {
        $this->appointmentDate = $appointmentDate;
        return $this;
    }

    public function getStartTime()
    {
        return $this->startTime;
    }

    public function setStartTime($startTime): self
    {
        $this->startTime = $startTime;
        return $this;
    }

    public function getEndTime()
    {
        return $this->endTime;
    }

    public function setEndTime($endTime): self
    {
        $this->endTime = $endTime;
        return $this;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status): self
    {
        $this->status = $status;
        return $this;
    }

    public function getObservations()
    {
        return $this->observations;
    }

    public function setObservations($observations): self
    {
        $this->observations = $observations;
        return $this;
    }

    // Methods

    public function createAppointment()
    {
        $data_appointment = [
            "idClient" => $this->getIdClient(),
            "appointmentDate" => $this->getAppointmentDate(),
            "startTime" => $this->getStartTime(),
            "endTime" => $this->getEndTime(),
            "status" => $this->getStatus(),
            "observations" => $this->getObservations()
        ];

        $appointmentModel = new Appointment();
        $appointmentModel->saveAppointment($data_appointment);
    }

    public function listAppointments()
    {
        $appointmentModel = new Appointment();

        $data = $appointmentModel->getAppointments();

        if (empty($data)) {
            return false;
        }

        return $data;
    }

    public function getAppointmentById($id)
    {
        $appointmentModel = new Appointment();

        $data = $appointmentModel->getAppointmentById($id);

        return $data;
    }

    public function editAppointments($id)
    {
        $data_appointment = [
            "idClient" => $this->getIdClient(),
            "appointmentDate" => $this->getAppointmentDate(),
            "startTime" => $this->getStartTime(),
            "endTime" => $this->getEndTime(),
            "status" => $this->getStatus(),
            "observations" => $this->getObservations()
        ];

        $appointmentModel = new Appointment();
        $appointmentModel->editDatasAppointment($id, $data_appointment);
    }

    public function deleteAppointments($id)
    {
        $appointmentModel = new Appointment();
        $appointmentModel->delDatasAppointment($id);
    }
}