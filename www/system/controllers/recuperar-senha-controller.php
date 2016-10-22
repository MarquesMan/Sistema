<?php
/**
 * UserRegisterController - Controller de exemplo
 *
 * @package TutsupMVC
 * @since 0.1
 */
class RecuperarSenhaController extends MainController
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
     * Carrega a página "/views/user-register/index.php"
     */
    public function index() {
        // Page title
        $this->title = 'Recuperação de senha';


        // Carrega o modelo para este view
        $modelo = $this->load_model('recuperar-senha/recuperar-senha-model');

        /** Carrega os arquivos do view **/


        // /views/recuperar-senha/recuperar-senha-view.php
        require ABSPATH . '/views/recuperar-senha/recuperar-senha-view.php';


    } // index

} // class home
