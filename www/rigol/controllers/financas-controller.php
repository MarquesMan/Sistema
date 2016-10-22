<?php
/**
 * UserRegisterController - Controller de exemplo
 *
 * @package TutsupMVC
 * @since 0.1
 */
class FinancasController extends MainController
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
    public $permission_required = 'familia';

    /**
     * Carrega a página "/views/financas/index.php"
     */
    public function index() {
        // Page title
        $this->title = 'Finanças';

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
        $modelo = $this->load_model('financas/financas-model');

        /** Carrega os arquivos do view **/

        require ABSPATH.'/views/_includes/header.php';

        // /views/financas/index.php
        require ABSPATH . '/views/financas/financas-view.php';

        require ABSPATH.'/views/_includes/footer.php';



    } // index

} // class home