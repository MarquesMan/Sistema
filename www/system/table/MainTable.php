<?php

class MainTable
{
    private $table_name;
    private $db;

    public function __construct($table, $db)
    {
        $this->table_name = $table;
        $this->db = $db;
    }

    public function imprime(){
        echo "essa classe pertence a tabela ".$this->table_name;
    }

    public function get($fields = array()){
        $fields = array(
            "id" => 1,
            "status" => 'pendente'

        );
        $query = $this->db->query("SELECT * FROM $this->table_name");

        if(!$query){
            return array("Não foi possivél recuperar os dados da tabela");
        }

        return $query->fetchAll(PDo::FETCH_OBJ);
    }


}