<?php
/**
 * MainController - Todos os controllers deverão estender essa classe
 *
 * @package TutsupMVC
 * @since 0.1
 */
class MainController extends UserLogin
{

	/**
	 * $db
	 *
	 * Nossa conexão com a base de dados. Manterá o objeto PDO
	 *
	 * @access public
	 */
	public $db;

	/**
	 * $phpass
	 *
	 * Classe phpass 
	 *
	 * @see http://www.openwall.com/phpass/
	 * @access public
	 */
	public $phpass;

	/**
	 * $title
	 *
	 * Título das páginas 
	 *
	 * @access public
	 */
	public $title;

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
	 * $parametros
	 *
	 * @access public
	 */
	public $parametros = array();

	protected $controlador;

	protected $content = "";

	/**
	 * Construtor da classe
	 *
	 * Configura as propriedades e métodos da classe.
	 *
	 * @since 0.1
	 * @access public
	 */
	public function __construct ( $parametros = array() ) {
	
		// Instancia do DB
		$this->db = new SistemaDB();
		
		// Phpass
		$this->phpass = new PasswordHash(8, false);
		
		// Parâmetros
		$this->parametros = $parametros;
		
		// Verifica o login
		$this->check_userlogin();
		
	} // __construct
	
	/**
	 * Load model
	 *
	 * Carrega os modelos presentes na pasta /models/.
	 *
	 * @since 0.1
	 * @access public
	 */
	public function load_model( $model_name = false ) {
	
		// Um arquivo deverá ser enviado
		if ( ! $model_name ) return;
		
		// Garante que o nome do modelo tenha letras minúsculas
		$model_name =  strtolower( $model_name );
		
		// Inclui o arquivo
		$model_path = ABSPATH . '/models/' . $model_name . '.php';
		
		// Verifica se o arquivo existe
		if ( file_exists( $model_path ) ) {
		
			// Inclui o arquivo
			require_once $model_path;
			
			// Remove os caminhos do arquivo (se tiver algum)
			$model_name = explode('/', $model_name);
			
			// Pega só o nome final do caminho
			$model_name = end( $model_name );
			
			// Remove caracteres inválidos do nome do arquivo
			$model_name = preg_replace( '/[^a-zA-Z0-9]/is', '', $model_name );
			
			// Verifica se a classe existe
			if ( class_exists( $model_name ) ) {
			
				// Retorna um objeto da classe
				return new $model_name( $this->db, $this );
			
			}
			
			// The end :)
			return;
			
		} // load_model
		
	} // load_model

	public function css($css_name = false){
		// Um arquivo deverá ser enviado
		if ( ! $css_name ) return;

		echo '<link rel="stylesheet" href="'.HOME_URI.'/views/_css/'.$css_name.'.css">';

		return;
	}

	public function js($js_name = false){
		// Um arquivo deverá ser enviado
		if ( ! $js_name ) return;

		echo '<script src="'.HOME_URI.'/views/_js/'.$js_name.'.js"></script>';

		return;
	}

	public function show_msg($msg){

		if(!empty($msg["success"])){
			echo '<div class="alert alert-success alert-dismissible text-center" role="alert" style="max-width: 1680px; margin-left: auto; margin-right: auto;">
  			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.
				$msg["success"]
				.'</div>';

			unset($msg["success"]);
		}

		if(isset($_SESSION["msg"]["success"]) && !empty($_SESSION["msg"]["success"]) ){
			echo '<div class="alert alert-success alert-dismissible text-center" role="alert" style="max-width: 1680px; margin-left: auto; margin-right: auto;">
  			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.
				$_SESSION["msg"]["success"]
				.'</div>';

			unset($_SESSION["msg"]["success"]);
		}

		if(!empty($msg["error"])){
			echo '<div class="alert alert-danger alert-dismissible text-center" role="alert" style="max-width: 1680px; margin-left: auto; margin-right: auto;">
  			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.
				$msg["error"]
			.'</div>';

			unset($msg["error"]);
		}

		if(isset($_SESSION["msg"]["error"]) && !empty($_SESSION["msg"]["error"])){
			echo '<div class="alert alert-danger alert-dismissible text-center" role="alert" style="max-width: 1680px; margin-left: auto; margin-right: auto;">
  			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.
				$_SESSION["msg"]["error"]
				.'</div>';

			unset($_SESSION["msg"]["error"]);
		}
	}

} // class MainController