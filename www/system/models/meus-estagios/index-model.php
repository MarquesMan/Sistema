<?php
/**
 * Classe para registros de usuários
 *
 * @package TutsupMVC
 * @since 0.1
 */

class IndexModel extends MainModel
{

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
     * $form_fields
     *
     * Array com uma lista de todos os campos que o formulário deve ter
     * Obs: Termo de compromisso precisa estar aqui, pois como é uma arquivo
     *      a validação é feita separada
     *
     * @access public
     */

    private $form_fields = [//Estagio
                            "Modalidade",
                            "Codigo_Area",
                            "Codigo_Empresa",
                            "dataInicial",
                            "dataFinal",
                            "Codigo_Supervisor",
                            //Plano de atividades
                            "segunda1",
                            "segunda2",
                            "terca1",
                            "terca2",
                            "quarta1",
                            "quarta2",
                            "quinta1",
                            "quinta2",
                            "sexta1",
                            "sexta2",
                            "sabado1",
                            "sabado2",
                            "descricao",
                            "local",
                            "carga",
                            "data"];


    /**
     * Construtor
     *
     * Carrega  o DB.
     *
     * @since 0.1
     * @access public
     */
    public function __construct( $db = false ) {
        parent::__construct($db);
    }

    protected function redirect(){
        $_SESSION["msg"]["error"] = $this->form_msg["msg"]["error"];
        $_SESSION["msg"]["success"] = $this->form_msg["msg"]["success"];

        echo '<meta http-equiv="Refresh" content="0; url=' . HOME_URI . '/meus-estagios">';
        die();
    }

    public function verifica_novo_estagio(){
        $this->form_msg["msg"]["error"] = "";
        $this->form_msg["msg"]["success"] = "";

        // Configura os dados do formulário
        $this->form_data = array();


        // Se nada foi postado, não faça nada
        if ( 'POST' != $_SERVER['REQUEST_METHOD'] ||  empty ( $_POST ) ) {
            // Termina se nada foi enviado
            return;
        }


        //
        // Verifica se todos os campos foram enviados
        //
        if(!chk_form_fields($this->form_fields)){
            $this->form_msg["msg"]["error"] = "Erro no envio do formulário. Por Favor tente novamente.";
            // Termina se os campos nõs estiverem certos
            return;
        }

        //campos que podem estar vazios
        $empty_fields = ["segunda1","segunda2","terca1", "terca2" , "quarta1" , "quarta2", "quinta1" , "quinta2" , "sexta1" , "sexta2", "sabado1" , "sabado2" ];


        // Faz o loop dos dados do post
        foreach ( $_POST as $key => $value ) {

            // Configura os dados do post para a propriedade $form_data
            $this->form_data[$key] = $value;

            if ( $value == "" ){
                //Campos na variavel nome pode ser vazios
                if (!in_array($key, $empty_fields)) {
                    // Configura a mensagem
                    $this->form_msg["msg"]["error"] = "Alguns campos não foram preenchidos. Dados não foram enviados.";

                    // Termina
                    return;
                }
            }
        }

        // Verifica se a propriedade $form_data foi preenchida
        if( empty( $this->form_data ) ) {
            $this->form_msg["msg"]["error"] = "Alguns campos não foram preenchidos. Dados não foram enviados.";
            return;
        }

        /*********************************************
        *
        * Começa a validação de dados
        *
        *********************************************/



        //////////////////////////////////////////////////////////////////////////////////////////////////////////
        //Começa Validação do Estagio

            //Os campos que são ID's devem ser números
            $id_fields = ["Modalidade", "Codigo_Area", "Codigo_Empresa", "Codigo_Supervisor"];
            foreach($id_fields as $field){
                if(!ctype_digit($this->form_data[$field])){
                    $this->form_msg["error"][$field] = "Valor enviado é inválido";
                    unset($this->form_data[$field]);
                }
            }

            //Converte as datas para o formato do bd
            $estagio_datainicial = DateTime::createFromFormat('d/m/Y', $this->form_data['dataInicial']);
            $estagio_datafinal   = DateTime::createFromFormat('d/m/Y', $this->form_data['dataFinal']);


            //Verificar se as datas são validas
            if(!$estagio_datainicial){
                $this->form_msg["error"]['dataInicial'] = "Este campo deve conter uma data válida";
                unset($this->form_data['dataInicial']);
            }

            if(!$estagio_datafinal){
                $this->form_msg["error"]['dataFinal'] = "Este campo deve conter uma data válida";
                unset($this->form_data['dataFinal']);
            }

            $estagio_datainicial = date_format($estagio_datainicial, 'Y-m-d');
            $estagio_datafinal   = date_format($estagio_datafinal, 'Y-m-d');

        //Termina validação do Estágio
        //////////////////////////////////////////////////////////////////////////////////////////////////////////




        //////////////////////////////////////////////////////////////////////////////////////////////////////////
        //Começa validação do Plano de atividades

            $dias = ["segunda", "terca", "quarta", "quinta", "sexta", "sabado"];
            $pattern = "/(2[0-3]|[01][0-9]):([0-5][0-9])/"; //Expressão regular das horas
            $cargatotal = 0;                                //Carga horarária total de trabalho
            $horarios = "";                                 //Lista com os Horários

            foreach($dias as $dia){
                $hora1 = $this->form_data[$dia."1"];
                $hora2 = $this->form_data[$dia."2"];

                //Verifica se possui o formato certo
                if(preg_match($pattern, $hora1) &&
                    preg_match($pattern, $hora2) ){

                    //Criação da string contendo todos os horários separados por ';'
                    $horarios .= $hora1.";".$hora2.";";

                    $hora1 = strtotime($hora1);
                    $hora2 = strtotime($hora2);

                    $intervalo = $hora2 - $hora1;

                    if($intervalo <= 0){
                        $this->form_msg["error"][$dia] = 'Intervalo inválido.';
                        unset($this->form_data[$dia."1"], $this->form_data[$dia."2"]);
                    }

                    else{
                        $cargatotal += $intervalo;
                    }

                }

                //Se estiverem preenchidos mas o formato é errado
                else if($hora1 != "" || $hora2 != ""){
                    $this->form_msg["error"][$dia] = 'Formato de hora inválido.';
                    unset($this->form_data[$dia."1"], $this->form_data[$dia."2"]);
                }

                //Caso os horarios atuais estejam vazios apenas coloque o ';'
                else{
                    $horarios .= ";;";
                }
            }

            //Se a carga total é 0 nenhum horario foi enviado corretamente
            if($cargatotal == 0){
                $this->form_msg["error"]['horarios'] = 'Pelo menos um intervalo de horários deve ser informado.';
                foreach($dias as $dia){
                    unset($this->form_data[$dia."1"], $this->form_data[$dia."2"]);
                }
            }

            //Carga horario total não pode exceder 30 horas semanais
            else if($cargatotal > 108000){
                $this->form_msg["error"]['cargatotal'] = 'A carga horária não pode exceder 30 horas semanais.';
            }

            //Converter $cargatotal para o formato de horas
            date_default_timezone_set('UTC');
            $cargatotal = date('H:i', $cargatotal);

            //Converter data para o formato do bd e verificar se elá é valida
            $plano_data = DateTime::createFromFormat('d/m/Y', $this->form_data['data']);
            if(!$plano_data){
                $this->form_msg["error"]['data'] = 'Este campo deve conter uma data válida';
                unset($this->form_data['data']);
            }

            $plano_data = date_format($plano_data, 'Y-m-d');

            date_default_timezone_set('America/Campo_Grande');
            $time_stamp = date('d/m/Y H:i:s', time());

        //Termina validação do Plano de atividades
        //////////////////////////////////////////////////////////////////////////////////////////////////////////



        //////////////////////////////////////////////////////////////////////////////////////////////////////////
        //Começa validação do Termo de Compromisso

            if($_FILES['termo_arquivo']['size'] > 0)
            {
                if($_FILES['termo_arquivo']['type'] == 'application/pdf'){
                    $NomeArquivo 	 = $_FILES['termo_arquivo']['name'];
                    $NomeTemporario  = $_FILES['termo_arquivo']['tmp_name'];
                    $TamanhoArquivo  = $_FILES['termo_arquivo']['size'];
                    $TipoArquivo 	 = $_FILES['termo_arquivo']['type'];

                    $fp       = fopen($NomeTemporario, 'r');
                    $conteudo = fread($fp, filesize($NomeTemporario));
                    $conteudo = addslashes($conteudo);
                    fclose($fp);
                }

                else{
                    $this->form_msg["error"]['termo_arquivo'] = 'O arquivo deve estar no formato pdf';
                }

            }else{
                $this->form_msg["error"]['termo_arquivo'] = 'Algum arquivo deve ser enviado.';
            }

        //Termina validação do Termo de Compromisso
            //caso tena algum erro pare a inserção
            if(isset($this->form_msg["error"])){
                return;
            }
        //////////////////////////////////////////////////////////////////////////////////////////////////////////


        /*********************************************
        *
        * Termina Validação de dados
        *
        *********************************************/



        /*********************************************
        *
        * Começa inserção
        *
        *********************************************/

        //
        //Inserir estágio
        //
            $query = $this->estagios->inserir($this->form_data['Modalidade'],
                                              $this->form_data['Codigo_Area'],
                                              $this->form_data['Codigo_Empresa'],
                                              $estagio_datainicial,
                                              $estagio_datafinal,
                                              $this->form_data['Codigo_Supervisor']);


            //Verificar se estágio foi inserido com sucesso
            if(!$query){
                $this->form_msg["msg"]["error"] = 'Estágio não pode ser inserido. Por Favor tente novamente.';
                return;
            }
            else{
                $this->form_msg["msg"]["success"] = 'Estágio iserido com sucesso.<br>';
            }

            //Recupera o id do estágio adicionado
            $query = $this->estagios->get_estagio_inserido();

            if(!$query){
                $this->form_msg["msg"]["error"] = 'Não foi possível recuperar o estágio inserido. Por favor reenvie os documentos na aba do seu estágio.';
                $this->redirect();
            }
            else{
                $id_estagio = $query->id;
            }




        //
        //Inserir Plano de atividade
        //
            $query = $this->plano_atividades->inserir($id_estagio,
                                                       $horarios,
                                                       $cargatotal,
                                                       $this->form_data['descricao'],
                                                       $this->form_data['local'],
                                                       $plano_data,
                                                       $time_stamp);


            //Verificar se Plano de atividade foi inserido com sucesso
            if(!$query){
                $this->form_msg["msg"]["error"] = 'Plano de atividade não pode ser inserido. Por Favor tente novamente na aba do seu estágio.<br>';
                $termo_status = "pendente";
            }
            else{
                $this->form_msg["msg"]["success"] .= 'Plano de atividade iserido com sucesso.<br>';
                $termo_status = "supervisor";
            }


        //
        //Inserir Termo de compromisso
        //
            $query = $this->termo_compromisso->inserir($id_estagio, $NomeArquivo, $TamanhoArquivo, $TipoArquivo, $conteudo, $termo_status);

            if(!$query){
                $this->form_msg["msg"]["error"] .= 'Termo de compromisso não pode ser inserido. Por Favor tente novamente.';
            }
            else{
                $this->form_msg["msg"]["success"] .= 'Termo de compromisso iserido com sucesso.';

                if($termo_status == "supervisor"){

                    $query =  $this->plano_atividades->change_status($id_estagio, "supervisor");

                    if($query){
                        $this->estagios->change_status($id_estagio, "supervisor");
                    }
                }
            }

        $this->redirect();


        /*********************************************
        *
        * Termina inserção
        *
        *********************************************/



    }


}