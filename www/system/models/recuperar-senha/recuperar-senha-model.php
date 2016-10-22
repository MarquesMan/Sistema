<?php
/**
 * Classe para registros de usuários
 *
 * @package TutsupMVC
 * @since 0.1
 */

class RecuperarSenhaModel
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

    public function validate_recovery_form(){
        // Configura os dados do formulário
        $this->form_data = array();

        // Verifica se algo foi postado
        if ( 'POST' == $_SERVER['REQUEST_METHOD'] && ! empty ( $_POST ) ) {

            // Faz o loop dos dados do post
            foreach ( $_POST as $key => $value ) {

                // Configura os dados do post para a propriedade $form_data
                $this->form_data[$key] = $value;

                if ( empty( $value ) ) {
                    // Configura a mensagem
                    $this->form_msg["dado"] = 'Campo não foi preenchido. Dados não foram enviados';
                    // Termina
                    return;
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

        if($this->form_data["tipo-dado"] == "email"){
            $db_check_email = $this->db->query(
                'SELECT `user_id` FROM `users` WHERE `email` = ?',
                array(
                    chk_array($this->form_data, 'dado')
                )
            );

            // Verifica se a consulta foi realizada com sucesso
            if ( ! $db_check_email ) {
                $this->form_msg["erro"] = '<p class="form_error">Erro Interno.</p>';
                return;
            }

            // Obtém os dados da base de dados MySQL
            $fetch_email = $db_check_email->fetch();

            //Caso nenhum dado tenha sido encontrado, informe o erro ao usuáiro
            if(empty($fetch_email["user_id"])){
                $this->form_msg["dado"] = 'E-mail não registado';
                return;
            }
        }

        else if($this->form_data["tipo-dado"] == "rga"){
            //pesquisa pelo RGA na base de dados
            $db_check_rga = $this->db->query(
                'SELECT `user_id` FROM `users` WHERE `rga` = ?',
                array(
                    chk_array($this->form_data, 'dado')
                )
            );

            // Verifica se a consulta foi realizada com sucesso
            if ( ! $db_check_rga ) {
                $this->form_msg["erro"] = '<p class="form_error">Erro Interno.</p>';
                return;
            }

            // Obtém os dados da base de dados MySQL
            $fetch_rga = $db_check_rga->fetch();

            //Caso nenhum dado tenha sido encontrado, informe o erro ao usuáiro
            if(empty($fetch_rga["user_id"])){
                $this->form_msg["dado"] = 'RGA não registrado';
                return;
            }

        }
        else if($this->form_data["tipo-dado"] == "user"){
            //pesquisa pelo RGA na base de dados
            $db_check_user = $this->db->query(
                'SELECT `user_id` FROM `users` WHERE `user` = ?',
                array(
                    chk_array($this->form_data, 'dado')
                )
            );

            // Verifica se a consulta foi realizada com sucesso
            if ( ! $db_check_user ) {
                $this->form_msg["erro"] = '<p class="form_error">Erro Interno.</p>';
                return;
            }

            // Obtém os dados da base de dados MySQL
            $fetch_user = $db_check_user->fetch();

            //Caso nenhum dado tenha sido encontrado, informe o erro ao usuáiro
            if(empty($fetch_user["user_id"])){
                $this->form_msg["dado"] = 'Nome de Usuário não registrado';
                return;
            }
        }
        else{
            $this->form_msg["erro"] = '<p class="form_error">Erro Interno. Dados não foram enviados.</p>';
            // Termina
            return;
        }

        //Enviar email com a redefinição de senha
    }
}