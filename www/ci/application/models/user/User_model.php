<?php
 defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class User_model
 *
 * Clasee resposável por fazer o gerenciamneto de usuários e empresas
 */
class User_model extends MY_Model {

    /**
     * Esta função busca os dados do usuário no banco de dados,
     * caso estajam corretos retorna TRUE caso contrario retorna o erro
     * de login
     *
     * @return bool | string
     */
    public function validate_login(){
        $this->lang->load('mydictionary');

        require_once (APPPATH.'libraries/PasswordHash.php');

        $password_hash = new PasswordHash(8, FALSE);

        $this->db->where('user', $this->input->post('user'));
        $query = $this->db->get('users');

        if($query->num_rows() == 1){
            $fetch = $query->row();
            if($password_hash->CheckPassword( $this->input->post('password'), $fetch->user_password ))
                return true;
        }

        return $this->lang->line('login_error');
    }





    /**
     * Esta função permite receber um identificador de um curso.
     *
     * Caso receba um identificador, faz uma consulta no banco de dados e
     * retorna os valores do curso. Caso o curso não exista retorna FALSE.
     *
     * Caso não seja passado um identificador de curso, esta função retorna
     * uma lista com todos os cursos
     *
     * @param int $id  identificador de um curso
     *
     * @return bool | array
     */
    public function  get_cursos($id = NULL){
        if($id != NULL)
            $this->db->where('id', $id);
        $query = $this->db->get('cursos');

        if($query->num_rows() > 0){
            return $query->result_array();
        }

        return FALSE;
    }




    /**
     *
     * Função responsavél por fazer a inserção de um aluno no banco de dados.
     *
     * @return bool|string
     *
     * @obs Como os dados do aluno são divididos em duas tabelas(users e alunos),
     * as inserções no banco de dados são feitas em uma transação, para que caso
     * ocora erro em alguma das inserções, seja feito um rollback.
     */
    public function insert_estudante(){
        $this->lang->load('mydictionary');

        //Instacina classe para fazer hash da senha
        require_once (APPPATH.'libraries/PasswordHash.php');
        $password_hash = new PasswordHash(8, FALSE);

        //Faz hash da senha
        $password = $password_hash->HashPassword($this->input->post('user_password'));

        //Prepara dados a serem inseridos
        $data_user = array( 'user_name'         => $this->input->post('user_name'),
                            'user'              => $this->input->post('user'),
                            'email'             => $this->input->post('email'),
                            'user_password'     => $password,
                            'telefone'          => '99999999999',
                            'user_permissions'  => 'a:1:{i:0;s:9:"estudante";}'
        );

        $data_aluno = array('user_id'   => '',
                            'curso_id'  => $this->input->post('id_curso'),
                            'rga'       => $this->input->post('rga')
        );

        //Gera a string a ser executada
        $str_user  = $this->db->insert_string('users', $data_user);
        $str_aluno = $this->db->insert_string('alunos', $data_aluno);

        //Inicia trasação no banco de dados e executa as querys
        $this->db->trans_start();

            $this->db->query($str_user);
            $data_aluno['user_id'] = $this->db->insert_id();
            $this->db->query($str_aluno);

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE)
        {
            return sprintf($this->lang->line('insert_error'), 'Usuário');
        }

        return TRUE;
    }




    /**
     *
     * Função responsavél por fazer a inserção de um supervisor no banco de dados.
     *
     * @return bool|string
     *
     * @obs Como os dados do aluno são divididos em duas tabelas(users e supervisores),
     * as inserções no banco de dados são feitas em uma transação, para que caso
     * ocora erro em alguma das inserções, seja feito um rollback.
     */
    public function insert_supervisor(){
        $this->lang->load('mydictionary');

        //Instacina classe para fazer hash da senha
        require_once (APPPATH.'libraries/PasswordHash.php');
        $password_hash = new PasswordHash(8, FALSE);

        //Faz hash da senha
        $password = $password_hash->HashPassword($this->input->post('user_password'));

        //Prepara dados a serem inseridos
        $data_user = array( 'user_name'         => $this->input->post('user_name'),
                            'user'              => $this->input->post('user'),
                            'email'             => $this->input->post('email'),
                            'user_password'     => $password,
                            'telefone'          => '99999999999',
                            'user_permissions'  => 'a:1:{i:0;s:9:"estudante";}'
        );

        $data_supervisor = array(   'user_id'   => '',
                                    'nome_instituicao'  => 'FACOM-UFMS'
        );

        //Gera a string a ser executada
        $str_user       = $this->db->insert_string('users', $data_user);
        $str_supervisor = $this->db->insert_string('supervisores', $data_supervisor);

        //Inicia trasição no banco de dados e executa as querys
        $this->db->trans_start();

            $this->db->query($str_user);
            $data_supervisor['user_id'] = $this->db->insert_id();
            $this->db->query($str_supervisor);

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE)
        {
            return sprintf($this->lang->line('insert_error'), 'Usuário');
        }

        return TRUE;
    }






    /**
     *
     * Função responsavél por fazer a inserção de uma empresa no banco de dados.
     *
     * @return bool|string
     *
     * @obs A inserção no banco de dados é feita em uma transação, para que caso
     * ocora algum erro seja feito um rollback.
     */
    public function insert_empresa(){
        $this->lang->load('mydictionary');


        //Prepara dados a serem inseridos
        $data_user = array( 'nome'          => $this->input->post('nome_empresa'),
                            'email'         => $this->input->post('email_empresa'),
                            'telefone'      => $this->input->post('telefone_empresa'),
                            'rua'           => $this->input->post('rua_empresa'),
                            'cep'           => $this->input->post('cep_empresa'),
                            'numero'        => $this->input->post('numero_empresa'),
                            'bairro'        => $this->input->post('bairro_empresa'),
                            'complemento'   => $this->input->post('complemento')
        );



        //Gera a string a ser executada
        $str_empresa = $this->db->insert_string('empresas', $data_user);

        //Inicia trasição no banco de dados e executa as querys
        $this->db->trans_start();
            $this->db->query($str_empresa);
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE)
        {
            return sprintf($this->lang->line('insert_error'), 'Empresa');
        }

        return TRUE;
    }

    //TODO: envio de confirmação de e-mail

}

