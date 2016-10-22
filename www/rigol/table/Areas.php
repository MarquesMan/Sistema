<?php

class Areas
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function lista() {
        // Simplesmente seleciona os dados na base de dados
        $query = $this->db->query('SELECT * FROM `areas`');

        // Verifica se a consulta está OK
        if ( ! $query ) {
            return array();
        }
        // Preenche a tabela com os dados do usuário
        return $query->fetchAll();
    } // lista

    public function get($id){
        $query = $this->db->query('SELECT * FROM `areas` WHERE Id_Area = ?', array($id));

        // Verifica se a consulta está OK
        if ( ! $query ) {
            return array();
        }

        // Preenche a tabela com os dados do usuário
        return $query->fetchAll();
    }
}