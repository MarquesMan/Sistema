<?php
/**
 * Classe para registros de usuários
 *
 * @package TutsupMVC
 * @since 0.1
 */

class CadastrosModel
{

    /**
     * $form_data
     *
     * Os dados do formulário de envio.
     *
     * @access public
     */
    public $form_data;

    /**
     * $form_msg
     *
     * As mensagens de feedback para o usuário.
     *
     * @access public
     */
    public $form_msg;

    /**
     * $db
     *
     * O objeto da nossa conexão PDO
     *
     * @access public
     */
    public $db;

    /**
     * Construtor
     *
     * Carrega  o DB.
     *
     * @since 0.1
     * @access public
     */
    public function __construct( $db = false ) {
        $this->db = $db;
    }

    /**
     * Valida o formulário de envio
     *
     * Este método pode inserir ou atualizar dados dependendo do campo de
     * usuário.
     *
     * @since 0.1
     * @access public
     */
    public function validate_register_form () {

        // Configura os dados do formulário
        $this->form_data = array();

        // Verifica se algo foi postado
        if ( 'POST' == $_SERVER['REQUEST_METHOD'] && ! empty ( $_POST ) ) {

            // Faz o loop dos dados do post
            foreach ( $_POST as $key => $value ) {

                // Configura os dados do post para a propriedade $form_data
                $this->form_data[$key] = $value;

                if ( empty( $value ) ) {
                    if($this->form_data["tipo"] == "E") {
                        // Configura a mensagem
                        $this->form_msg["empty"] = '<p class="form_error">Alguns campos não foram preenchidos. Dados não foram enviados.</p>';

                        // Termina
                        return;
                    }

                    else if($this->form_data["tipo"] == "P" && $key != "rga" && $key != "id_curso"){
                        // Configura a mensagem
                        $this->form_msg["empty"] = '<p class="form_error">Alguns campos não foram preenchidos. Dados não foram enviados.</p>';

                        // Termina
                        return;
                    }

                    else if($this->form_data["tipo"] == "B" && $key != "complemento"){
                        // Configura a mensagem
                        $this->form_msg["empty"] = '<p class="form_error">Alguns campos não foram preenchidos. Dados não foram enviados.</p>';

                        // Termina
                        return;
                    }
                }
            }

        } else {

            // Termina se nada foi enviado
            return;

        }

        // Verifica se a propriedade $form_data foi preenchida
        if( empty( $this->form_data ) ) {
            return;
        }

        if($this->form_data["tipo"] == "E" || $this->form_data["tipo"] == "P") {

            //Se for cadastro de um estudande, verifica se o RGA já está cadastrado
            if($this->form_data["tipo"] == "E"){

                //pesquisa pelo RGA na base de dados
                $db_check_rga = $this->db->query(
                    'SELECT `user_id` FROM `users` WHERE `rga` = ?',
                    array(
                        chk_array($this->form_data, 'rga')
                    )
                );

                // Verifica se a consulta foi realizada com sucesso
                if ( ! $db_check_rga ) {
                    $this->form_msg["empty"] = '<p class="form_error">Erro Interno.</p>';
                    return;
                }

                // Obtém os dados da base de dados MySQL
                $fetch_rga = $db_check_rga->fetch();

                //Caso algum dado tenha sido encontrado, informe o erro ao usuáiro
                if(!empty($fetch_rga["user_id"])){
                    $this->form_msg["rga"] = 'RGA já cadastrado';
                }
            }

            //pesquisa pelo Nome de usuário na base de dados
            $db_check_user = $this->db->query(
                'SELECT `user_id` FROM `users` WHERE `user` = ?',
                array(
                    chk_array($this->form_data, 'user')
                )
            );

            //pesquisa pelo E-Mail na base de dados
            $db_check_email = $this->db->query(
                'SELECT `user_id` FROM `users` WHERE `email` = ?',
                array(
                    chk_array($this->form_data, 'email')
                )
            );

            // Verifica se as consultas foram realizadas com sucesso
            if ( ! $db_check_user || ! $db_check_email) {
                $this->form_msg = '<p class="form_error">Erro Interno.</p>';
                return;
            }

            // Obtém os dados da base de dados MySQL
            $fetch_user = $db_check_user->fetch();
            $fetch_email = $db_check_email->fetch();

            //Caso algum dado tenha sido encontrado, informe o erro ao usuáiro
            if(!empty($fetch_user["user_id"])){
                $this->form_msg["user"] = 'Nome de Usuário já cadastrado';
            }

            //Caso algum dado tenha sido encontrado, informe o erro ao usuáiro
            if(!empty($fetch_email["user_id"])){
                $this->form_msg["email"] = 'E-mail já cadastrado';
            }

            if(!empty($this->form_msg)){
                return;
            }

            // Precisaremos de uma instância da classe Phpass
            // veja http://www.openwall.com/phpass/
            $password_hash = new PasswordHash(8, FALSE);

            // Cria o hash da senha
            $password = $password_hash->HashPassword( $this->form_data['user_password'] );

            //Configura as permições
            if($this->form_data["tipo"] == "E")
                $permissions = serialize(array(0 => "estudante"));

            else if($this->form_data["tipo"] == "P") {
                $permissions = serialize(array(0 => "supervisor"));
                $this->form_data["rga"] = " ";
                $this->form_data["id_curso"] = "7";
            }

            // Executa a consulta
            $query = $this->db->insert('users', array(
                'user_name' => chk_array( $this->form_data, 'user_name'),
                'user' => chk_array( $this->form_data, 'user'),
                'rga' => chk_array( $this->form_data, 'rga'),
                'email' => chk_array( $this->form_data, 'email'),
                'curso' => chk_array( $this->form_data, 'id_curso'),
                'user_password' => $password,
                'user_session_id' => md5(time()),
                'user_permissions' => $permissions,
            ));

            // Verifica se a consulta está OK e configura a mensagem
            if ( ! $query ) {
                $this->form_msg["empty"] = '<p class="form_error">Internal error. Data has not been sent.</p>';

                // Termina
                return;
            }

            else {
                $this->form_msg["empty"] = '<p class="form_success">Usuário registrado com sucesso.</p>';

                // Termina
                return;
            }

        }

        else if($this->form_data["tipo"] == "B"){

            //pesquisa pelo Nome da Empresa na base de dados
            $db_check_nome = $this->db->query(
                'SELECT `id_empresa` FROM `empresas` WHERE `nome` = ?',
                array(
                    chk_array($this->form_data, 'nome_empresa')
                )
            );

            //pesquisa pelo E-Mail na base de dadoss
            $db_check_email = $this->db->query(
                'SELECT `id_empresa` FROM `empresas` WHERE `email` = ?',
                array(
                    chk_array($this->form_data, 'email_empresa')
                )
            );

            // Verifica se as consultas foram realizadas com sucesso
            if ($db_check_nome || ! $db_check_email ) {
                $this->form_msg = '<p class="form_error">Erro Interno.</p>';
                return;
            }

            // Obtém os dados da base de dados MySQL
            $fetch_nome = $db_check_nome->fetch();
            $fetch_email = $db_check_email->fetch();

            //Caso algum dado tenha sido encontrado, informe o erro ao usuáiro
            if(!empty($fetch_nome["id_empresa"])){
                $this->form_msg["nome_empresa"] = 'Nome de Empresa já cadastrado';
            }

            //Caso algum dado tenha sido encontrado, informe o erro ao usuáiro
            if(!empty($fetch_email["id_empresa"])){
                $this->form_msg["email_empresa"] = 'E-mail já cadastrado';
            }

            if(!empty($this->form_msg)){
                return;
            }

            // Executa a consulta
            $query = $this->db->insert('empresas', array(
                'nome' => chk_array( $this->form_data, 'nome_empresa'),
                'cep' => chk_array( $this->form_data, 'cep_empresa'),
                'rua' => chk_array( $this->form_data, 'rua_empresa'),
                'numero' => chk_array( $this->form_data, 'numero_empresa'),
                'bairro' => chk_array( $this->form_data, 'bairro_empresa'),
                'complemento' => chk_array( $this->form_data, 'complemento'),
                'telefone' => chk_array( $this->form_data, 'telefone_empresa'),
                'email' => chk_array( $this->form_data, 'email_empresa'),
            ));

            // Verifica se a consulta está OK e configura a mensagem
            if ( ! $query ) {
                $this->form_msg = '<p class="form_error">Internal error. Data has not been sent.</p>';

                // Termina
                return;
            }

            else {
                $this->form_msg = '<p class="form_success">Empresa registrada com sucesso.</p>';

                // Termina
                return;
            }
        }

    } // validate_register_form

    public function get_curso_list() {

        // Simplesmente seleciona os dados na base de dados
        $query = $this->db->query('SELECT * FROM `cursos`');

        // Verifica se a consulta está OK
        if ( ! $query ) {
            return array();
        }
        // Preenche a tabela com os dados do usuário
        return $query->fetchAll();
    } // get_user_list
}