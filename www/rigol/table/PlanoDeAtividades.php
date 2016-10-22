<?php

class PlanoDeAtividades
{
    private $db;

    public function __construct($db){
        $this->db = $db;
    }

    public function inserir($id_estagio, $horarios, $cargatotal, $descricao, $local, $data, $time_stamp){
            return true;
    }
}