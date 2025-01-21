<?php
require_once __DIR__ . '/../config/connection.php';
require_once __DIR__ . '/User.php';
require_once __DIR__ . '/Inscription.php';

class Etudiant extends User
{
    public function __construct($nom, $email, $password, $role, $status)
    {
        parent::__construct($nom, $email, $password, $role, $status);
    }

    public function inscriptionCours($idCours)
    {
        $inscription = new Inscription($this->id, $idCours);
        return $inscription->inscriptionCours();
    }

    public function getMesCours()
    {
        $inscription = new Inscription();
        return $inscription->getCoursesByStudent($this->id);
    }
}