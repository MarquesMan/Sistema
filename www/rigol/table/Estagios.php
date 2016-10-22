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
        $query = $this->db->query('SELECT * FROM `estagio` WHERE Id_Aluno = ?', array($_SESSION['userdata']['user_id']));

        // Verifica se a consulta está OK
        if ( ! $query ) {
            return array();
        }
        // Preenche a tabela com os dados do usuário
        return $query->fetchAll();
    }

    public function estado($estado){
        return $this->inteiros_estado_estagio[$estado];
    }

    public function inserir($Modalidade,$Codigo_Area,$Codigo_Empresa,$DataInicial,$DataFinal,$Codigo_Supervisor){

        $query = $this->db->insert("estagio", array("Id_Aluno"      => $_SESSION['userdata']['user_id'],
                                                    "Id_Empresa"    => $Codigo_Empresa,
                                                    "Id_Supervisor" => $Codigo_Supervisor,
                                                    "Modalidade"    => $Modalidade,
                                                    "Area"          => $Codigo_Area,
                                                    "Data_inicio"   => $DataInicial,
                                                    "Data_fim"      => $DataFinal,
                                                    "Status"        => "supervisor"));

        return $query;
    }
}