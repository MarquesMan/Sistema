<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Estagios
 *
 * Controlador responsável por carregar as páginas relacionadas ao gerenciamento de estágios
 */
class Estagios extends CI_Controller {

    public function index(){
        $this->load->model('estagios/estagios_aluno');
        if($this->estagios_aluno->check_login("estudante")){
            $this->aluno();
        }
        else{
            redirect('user');
        }
    }

    public function aluno(){
        $this->load->model('estagios/estagios_aluno');

        if(!$this->estagios_aluno->check_login("estudante")) {
            redirect('user');
            return;
        }


        //Dados obrigratórios para chamar o template header.php
        $data['title'] = 'Meus estágios';                                       //Titulo da página
        $data['user_permissions'] = $this->estagios_aluno->user_permissions();  //Nivel de permição do usuario

        //Dados dos estagios do aluno.
        $data['estagios']  = $this->estagios_aluno->estagios();

        //contador para auxiliar a inserir os dados nos estágios corretor
        $count = 0;

        foreach ($data['estagios'] as $row){

            //Obtém o nome dos dados referente aos identificadores na tabela estagios
            $empresa    = $this->estagios_aluno->empresa_estagio($row['empresa_id']);
            $supervisor = $this->estagios_aluno->supervisor_estagio($row['supervisor_id']);
            $area       = $this->estagios_aluno->area_estagio($row['area_id']);
            $carga      = $this->estagios_aluno->carga_estagio($row['id']);


            //Adiciona ao estágio o nome referente aos identificadores
            $data['estagios'][$count]['empresa_nome'] = $empresa->nome;
            $data['estagios'][$count]['supervisor_nome'] = $supervisor->user_name;
            $data['estagios'][$count]['area_nome'] = $area->nome;
            $data['estagios'][$count]['carga_horaria'] = $carga;


            //Altera a string Status para boa visualização do usuário
            if($row['status'] == 'alterar'){
                $data['estagios'][$count]['status'] = "Rejeitado";
            }
            elseif($row['status'] == 'finalizado'){
                $data['estagios'][$count]['status'] = "Finalizado";
            }
            elseif($row['status'] == 'supervisor' OR $row['status'] == 'presidente'){
                $data['estagios'][$count]['status'] = "Esperando Aprovação";
            }
            else{
                $data['estagios'][$count]['status'] = "Em andamento";
            }

            $count++;
        }


        //Variaveis para o formulário de novo estágio
        $data['novo_estagio']['empresas'] = $this->estagios_aluno->empresa_estagio();
        $data['novo_estagio']['supervisores'] = $this->estagios_aluno->supervisor_estagio();
        $data['novo_estagio']['areas'] = $this->estagios_aluno->area_estagio();

        $this->load->template('estagios/estagios_aluno', $data);
    }

    public function novo_estagio(){
        $this->load->model('estagios/estagios_aluno');

        if(!$this->estagios_aluno->check_login("estudante")) {
            redirect('user');
            return;
        }

        $data['title'] = 'Novo Estágio';                                       //Titulo da página
        $data['user_permissions'] = $this->estagios_aluno->user_permissions();  //Nivel de permição do usuario


        $data['empresas'] = $this->estagios_aluno->empresa_estagio();
        $data['supervisores'] = $this->estagios_aluno->supervisor_estagio();
        $data['areas'] = $this->estagios_aluno->area_estagio();

        $this->load->view('estagios/novo_estagios', $data);
    }

    public function inserir_estagio(){
        $this->load->library('form_validation');
        $this->load->model('estagios/estagios_aluno');

        if(!$this->estagios_aluno->check_login("estudante")) {
            redirect('user');
            return;
        }

        $hour_regex = "regex_match[/(([01]?[0-9]|2[0-3]):[0-5][0-9])?/]";

        $this->form_validation->set_rules('modalidade'       , 'Modalidade'     , 'required|regex_match[/[01]/]');
        $this->form_validation->set_rules('codigo_supervisor', 'Supervisor'     , 'required|numeric|callback_exists[users]');
        $this->form_validation->set_rules('cadigo_empresa'   , 'Empresa'        , 'required|numeric|callback_exists[empresas');
        $this->form_validation->set_rules('codigo_area'      , 'Area'           , 'required|numeric|callback_exists[areas]');
        $this->form_validation->set_rules('dataInicial'      , 'Data Inicial'   , 'required');
        $this->form_validation->set_rules('dataFinal'        , 'data Final'     , 'required');
        $this->form_validation->set_rules('segunda1'         , 'segunda'        , $hour_regex);
        $this->form_validation->set_rules('segunda2'         , 'segunda'        , $hour_regex);
        $this->form_validation->set_rules('terca1'           , 'terca'          , $hour_regex);
        $this->form_validation->set_rules('terca2'           , 'terca'          , $hour_regex);
        $this->form_validation->set_rules('quarta1'          , 'quarta'         , $hour_regex);
        $this->form_validation->set_rules('quarta2'          , 'quarta'         , $hour_regex);
        $this->form_validation->set_rules('quinta1'          , 'quinta'         , $hour_regex);
        $this->form_validation->set_rules('quinta2'          , 'quinta'         , $hour_regex);
        $this->form_validation->set_rules('sexta1'           , 'sexta'          , $hour_regex);
        $this->form_validation->set_rules('sexta2'           , 'sexta'          , $hour_regex);
        $this->form_validation->set_rules('sabado1'          , 'sabado'         , $hour_regex);
        $this->form_validation->set_rules('sabado2'          , 'sabado'         , $hour_regex);
        $this->form_validation->set_rules('descricao'        , 'Descrição'      , 'required');
        $this->form_validation->set_rules('local'            , 'Local'          , 'required');
        $this->form_validation->set_rules('carga'            , 'Carga Horaria'  , 'required|'.$hour_regex);
        $this->form_validation->set_rules('data'             , 'Data'           , 'required');

    }

    public function exists($str, $table){
        $this->load->model('estagios/estagios_aluno');

        $check = FALSE;

        if($table[0] == "users"){
            $check = $this->estagios_aluno->supervisor_estagio($str);
        }
        elseif($table[0] == "empresas"){
            $check = $this->estagios_aluno->empresa_estagio($str);
        }
        elseif($table[0] == "areas"){
            $check = $this->estagios_aluno->area_estagio($str);
        }

        if($check === FALSE){
            $this->form_validation->set_message('exists', 'O campo {field} deve contem um curso válido');
            return FALSE;
        }

        return TRUE;
    }

}
