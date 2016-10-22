<?php

class Estagios
{
    private $db;

    private $inteiros_estado_estagio = array('alterar'    => -2,
                                             'supervisor' => -1,
                                             'presidente' => -1,
                                             'termocomp'  => 0,
                                             'planoativ'  => 1,
                                             'relatorio'  => 2,
                                             'relatfinal' => 3,
                                             'declaracao' => 4,
                                             'finalizado' =>5);

    public function __construct($db){
        $this->db = $db;
    }

    public function lista_aluno(){
        // Simplesmente seleciona os dados na base de dados
        $query = $this->db->query('SELECT * FROM `estagios` WHERE aluno_id = ?', array($_SESSION['userdata']['user_id']));

        // Verifica se a consulta está OK
        if ( ! $query ) {
            return array();
        }
        // Preenche a tabela com os dados do usuário
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function change_status($id_estagio, $status){
        $query = $this->db->update("estagios", "id", $id_estagio, array("status" => $status) );

        return $query;
    }

    public function estado($estado){
        return $this->inteiros_estado_estagio[$estado];
    }

    public function inserir($Modalidade,$Codigo_Area,$Codigo_Empresa,$DataInicial,$DataFinal,$Codigo_Supervisor){

        $query = $this->db->insert("estagios", array("aluno_id"      => $_SESSION['userdata']['user_id'],
                                                    "empresa_id"    => $Codigo_Empresa,
                                                    "supervisor_id" => $Codigo_Supervisor,
                                                    "modalidade"    => $Modalidade,
                                                    "area_id"       => $Codigo_Area,
                                                    "data_inicio"   => $DataInicial,
                                                    "data_fim"      => $DataFinal,
                                                    "status"        => "pendente"));

        return $query;
    }

    public function get_estagio_inserido(){
        // Simplesmente seleciona os dados na base de dados
        $query = $this->db->query('SELECT * FROM `estagios` WHERE aluno_id = ? AND status = ? LIMIT 1', array($_SESSION['userdata']['user_id'], 'pendente'));

        // Verifica se a consulta está OK
        if ( ! $query ) {
            return false;
        }

        // Preenche a tabela com os dados do usuário
        return $query->fetchAll(PDO::FETCH_OBJ)[0];
    }

}