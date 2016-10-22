<?php


 class Empresas
 {
     private $db;

     public function __construct($db){
        $this->db = $db;
     }

     public function lista(){
         // Simplesmente seleciona os dados na base de dados
         $query = $this->db->query('SELECT * FROM `empresas`');

         // Verifica se a consulta está OK
         if ( ! $query ) {
             return array();
         }

         // Preenche a tabela com os dados do usuário
         return $query->fetchAll(PDO::FETCH_OBJ);
    }

     /**
      * @param $id
      * @param array $fields
      * @return array
      */
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
        $string = "SELECT $campos FROM `empresas` WHERE id = ? LIMIT 1";
        $query = $this->db->query($string , array($id));

        // Verifica se a consulta está OK
        if ( ! $query ) {
            return array();
        }

        // Preenche a tabela com os dados do usuário
        return $query->fetchAll(PDO::FETCH_OBJ)[0];
    }
 }