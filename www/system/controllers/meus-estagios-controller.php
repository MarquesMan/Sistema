<?php

class MeusEstagiosController extends MainController
{

    /**
     * $login_required
     *
     * Se a página precisa de login
     *
     * @access public
     */
    public $login_required = true;

    /**
     * $permission_required
     *
     * Permissão necessária
     *
     * @access public
     */
    public $permission_required = 'estudante';

    protected $controlador = "meus-estagios";

    protected $content = "";

    public function index() {
        // Page title
        $this->title = 'Meus Estágios';

        // Verifica se o usuário está logado
        if ( ! $this->logged_in ) {

            // Se não; garante o logout
            $this->logout();

            // Redireciona para a página de login
            $this->goto_login();

            // Garante que o script não vai passar daqui
            return;

        }

        // Verifica se o usuário tem a permissão para acessar essa página
        if (!$this->check_permissions($this->permission_required, $this->userdata['user_permissions'])) {

            // Exibe uma mensagem
            echo 'Você não tem permissões para acessar essa página.';

            // Finaliza aqui
            return;
        }

        // Parametros da função
        $parametros = ( func_num_args() >= 1 ) ? func_get_arg(0) : array();

        // Carrega o modelo para este view
        $modelo = $this->load_model('meus-estagios/index-model');

        $modelo->verifica_novo_estagio();

        $modelo->load_tables();


        $modelo->plano_de_atividades_t->imprime();

        /** Carrega os arquivos do view **/


        //Arquivo da view
        $this->content = 'meus-estagios/index-view';

        // /views/_includes/header.php
        require ABSPATH . '/views/_includes/header.php';

    } // index

    public function novoestagio(){
        // Page title
        $this->title = 'Novo Estágio';

        // Verifica se o usuário está logado
        if ( ! $this->logged_in ) {

            // Se não; garante o logout
            $this->logout();

            // Redireciona para a página de login
            $this->goto_login();

            // Garante que o script não vai passar daqui
            return;

        }

        // Verifica se o usuário tem a permissão para acessar essa página
        if (!$this->check_permissions($this->permission_required, $this->userdata['user_permissions'])) {

            // Exibe uma mensagem
            echo 'Você não tem permissões para acessar essa página.';

            // Finaliza aqui
            return;
        }

        $modelo = $this->load_model('meus-estagios/novo-estagio-model');

        require ABSPATH . '/views/meus-estagios/novo-estagio-alt.php';

    }

} // class home