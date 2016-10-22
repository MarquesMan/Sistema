<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class User
 *
 * Controlador responsável por carregar as páginas relacionadas a usuários
 */
class User extends CI_Controller {

    /**
     * @var array que guarda os valores a serem passados para a view
     */
    protected $dados;



    /**
     * Método que invoca a página padrão do controlador
     * que nesse caso é uma view para efetuar o login
     */
    public function index()
    {
        //Helper para exibir erros de validação
        $this->load->helper(array('form'));

        $this->load->view('user/login', $this->dados);
    }



    /**
     * Método que faz a validação de usuário e senha
     *
     * Caso usuário ou senha estejam incorretos invoca a pagina index
     *
     * Caso estejam corretos configura os dados da sessão e redireciona para dentro do sistema
     */
    public function validate_credentials(){

        $this->load->library('form_validation');

        $this->form_validation->set_rules('user', 'Nome de usuário', 'trim|required');
        $this->form_validation->set_rules('password', 'Senha', 'trim|required');

        if ($this->form_validation->run() == FALSE)
        {
            $this->index();
        }

        else{
            $this->load->model('user/user_model');

            $query = $this->user_model->validate_login();

            if($query === true){
                $data = array(
                    'user' => $this->input->post('user'),
                    'is_logged_in' => true
                );

                $this->session->set_userdata($data);
                redirect("estagios");
            }

            else{
                $this->dados['error'] = $query;
                $this->dados['last_username'] = $this->input->post('user');
                $this->index();
            }
        }

    }



    /**
     *  Método que carrega a view para cadastro de alunos, supervisore ou empresas
     */
    public function register()
    {
        $this->load->helper(array('form'));
        $this->load->model('user/user_model');

        //Lista de curso usada no cadastro de alunos
        $this->dados["cursos"] = $this->user_model->get_cursos();

        $this->load->view('user/register', $this->dados);
    }



    /**
     * Método responsável por fazer o cadastro de um aluno
     *
     * Faz a verificação se todos os campos foram passados corretamnete
     *
     * Caso estejam todos corretos invoca o método do model para inserir
     * o estudante no banco de dados
     *
     * Caso contrário recarrega a página de registro
     */
    public function register_estudante (){
        $this->load->library('form_validation');


        $this->form_validation->set_rules('user_name', 'Nome', 'trim|required');
        $this->form_validation->set_rules('user', 'Nome de Usuário', 'trim|required|is_unique[users.user]');
        $this->form_validation->set_rules('id_curso', 'Curso', 'required|numeric|callback_is_curso');
        $this->form_validation->set_rules('rga', 'RGA', 'trim|required|numeric|is_unique[alunos.rga]');
        $this->form_validation->set_rules('email', 'E-mail', 'required|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('user_password', 'Senha', 'trim|required');
        $this->form_validation->set_rules('conf_password', 'Confirmar Senha', 'trim|required|matches[user_password]');

        if ($this->form_validation->run() == FALSE)
        {
            $this->register();
        }

        else{
            $this->load->model('user/user_model');

            $this->user_model->insert_estudante();

        }
    }



    /**
     * Método responsável por fazer o cadastro de um supervisor
     *
     * Faz a verificação se todos os campos foram passados corretamnete
     *
     * Caso estejam todos corretos invoca o método do model para inserir
     * o supervisor no banco de dados
     *
     * Caso contrário recarrega a página de registro
     */
    public function register_supervisor (){
        $this->load->library('form_validation');


        $this->form_validation->set_rules('user_name', 'Nome', 'trim|required');
        $this->form_validation->set_rules('user', 'Nome de Usuário', 'trim|required|is_unique[users.user]');
        $this->form_validation->set_rules('email', 'E-mail', 'required|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('user_password', 'Senha', 'trim|required');
        $this->form_validation->set_rules('conf_password', 'Confirmar Senha', 'trim|required|matches[user_password]');

        if ($this->form_validation->run() == FALSE)
        {
            $this->register();
        }

        else{
            $this->load->model('user/user_model');

            $this->user_model->insert_supervisor();

        }
    }



    /**
     * Método responsável por fazer o cadastro de uma empresa
     *
     * Faz a verificação se todos os campos foram passados corretamnete
     *
     * Caso estejam todos corretos invoca o método do model para inserir
     * a empresa no banco de dados
     *
     * Caso contrário recarrega a página de registro
     */
    public function register_empresa(){
        $this->load->library('form_validation');

        $this->form_validation->set_rules('nome_empresa', 'Nome da Empresa', 'required');
        $this->form_validation->set_rules('cep_empresa', 'CEP', 'trim|required');
        $this->form_validation->set_rules('rua_empresa', 'Rua', 'required');
        $this->form_validation->set_rules('numero_empresa', 'Número', 'required');
        $this->form_validation->set_rules('bairro_empresa', 'Bairro', 'required');
        $this->form_validation->set_rules('telefone_empresa', 'Telefone', 'required');
        $this->form_validation->set_rules('email_empresa', 'E-mail', 'required|valid_email|is_unique[empresas.email]');


        if ($this->form_validation->run() == FALSE)
        {
            $this->register();
        }

        else{
            $this->load->model('user/user_model');

            $this->user_model->insert_empresa();

        }

    }



    /**
     * Método usado para a validação de foormulário
     *
     * Verifica se existe um curso com o identificador passado como parâmetro
     *
     * @param $id
     * @return bool
     */
    public function is_curso($id){
        $this->load->model('user/user_model');

        $result = $this->user_model->get_cursos($id);

        if($result === FALSE){
            $this->form_validation->set_message('is_curso', 'O campo {field} deve contem um curso válido');
            return FALSE;
        }

        return TRUE;
    }
}
