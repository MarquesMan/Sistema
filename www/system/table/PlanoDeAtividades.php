<?php

class PlanoDeAtividades
{
    private $db;

    public function __construct($db){
        $this->db = $db;
    }

    public function inserir($id_estagio, $horarios, $cargatotal, $descricao, $local, $data, $time_stamp, $status = "pendente"){
        $query = $this->db->insert("plano_de_atividades", array("estagio_id"    => $id_estagio,
                                                                "horarios"      => $horarios,
                                                                "descricao"     => $descricao,
                                                                "carga_horaria" => $cargatotal,
                                                                "local"         => $local,
                                                                "data"          => $data,
                                                                "hora_envio"    => $time_stamp,
                                                                "status"        => $status));

        return $query;
    }

    public function change_status($id_estagio, $status){
        $query = $this->db->update("plano_de_atividades", "estagio_id", $id_estagio, array("status" => $status) );

        return $query;
    }

    public function get($id, $fields = array("*")){
        $campos = "";

        if(!is_array($fields)){
            return array();
        }

        foreach($fields as $field){
            $campos .= $field.",";
        }

        $campos = substr($campos, 0, -1);

        // Simplesmente seleciona os dados na base de dados
        $string = "SELECT $campos FROM `plano_de_atividades` WHERE plano_id = ? LIMIT 1";
        $query = $this->db->query($string , array($id));

        // Verifica se a consulta está OK
        if ( ! $query ) {
            return array();
        }

        // Preenche a tabela com os dados do usuário
        return $query->fetchAll(PDO::FETCH_OBJ)[0];
    }

    public function get_estagio($id, $fields = array("*")){
        $campos = "";

        if(!is_array($fields)){
            return array();
        }

        foreach($fields as $field){
            $campos .= $field.",";
        }

        $campos = substr($campos, 0, -1);

        // Simplesmente seleciona os dados na base de dados
        $string = "SELECT $campos FROM `plano_de_atividades` WHERE estagio_id = ? LIMIT 1";
        $query = $this->db->query($string , array($id));

        // Verifica se a consulta está OK
        if ( ! $query ) {
            return array();
        }

        // Preenche a tabela com os dados do usuário
        return $query->fetchAll(PDO::FETCH_OBJ)[0];
    }
}