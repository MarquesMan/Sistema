<?php
/**
 * UserRegisterController - Controller de exemplo
 *
 * @package TutsupMVC
 * @since 0.1
 */
class CadastrosController extends MainController
{

    /**
     * $login_required
     *
     * Se a página precisa de login
     *
     * @access public
     */
    public $login_required = false;

    /**
     * $permission_required
     *
     * Permissão necessária
     *
     * @access public
     */
    public $permission_required = 'any';

    /**
     * Carrega a página "/views/cadastros/index.php"
     */
    public function index() {
        // Page title
        $this->title = 'Cadastros';

        // Parametros da função
        $parametros = ( func_num_args() >= 1 ) ? func_get_arg(0) : array();

        // Carrega o modelo para este view
        $modelo = $this->load_model('cadastros/cadastros-model');

        /** Carrega os arquivos do view **/

        // /views/user-register/index.php
        require ABSPATH . '/views/cadastros/cadastros-view.php';

    } // index

} // class home