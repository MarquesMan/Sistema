<?php
/**
 * LoginController - Controller de exemplo
 *
 * @package TutsupMVC
 * @since 0.1
 */
class UserController extends MainController
{

	/**
	 * Carrega a página "/views/login/index.php"
	 */
    public function login() {
		// Título da página
		$this->title = 'Login';
		
		// Parametros da função
		$parametros = ( func_num_args() >= 1 ) ? func_get_arg(0) : array();
	
		// Login não tem Model
		
		/** Carrega os arquivos do view **/
		
		// /views/home/login-view.php
        require ABSPATH . '/views/user/login-view.php';
		
    } // login

	public function logoutaction(){
		$this->logout();
		echo '<meta http-equiv="Refresh" content="0; url="' . HOME_URI . '/user/login/">';
		echo '<script type="text/javascript">window.location.href = "'.HOME_URI.'/user/login/";</script>';
	}
	
} // class LoginController