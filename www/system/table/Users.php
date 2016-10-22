<?php

class Users
{
    private $db;


    public function __construct($db)
    {
        $this->db = $db;
    }

    public function lista_supervisores(){
        // Simplesmente seleciona os dados na base de dados
        $serial = serialize(array("supervisor"));
        $query = $this->db->query('SELECT * FROM `users` WHERE `user_permissions` = ?', array($serial));

        // Verifica se a consulta está OK
        if ( ! $query ) {
            return array();
        }
        // Preenche a tabela com os dados do usuário
        return $query->fetchAll(PDO::FETCH_OBJ);
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
        $string = "SELECT $campos FROM `users` WHERE user_id = ? LIMIT 1";
        $query = $this->db->query($string , array($id));

        // Verifica se a consulta está OK
        if ( ! $query ) {
            return array();
        }

        // Preenche a tabela com os dados do usuário
        return $query->fetchAll(PDO::FETCH_OBJ)[0];
    }
}