<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class User_model
 *
 * Clasee resposável por fazer o gerenciamneto dos estagios de um aluno
 */
class Estagios_aluno extends MY_Model {

    public function estagios(){
        $query = $this->db->query('SELECT user_id FROM users WHERE user = ?', array($this->session->userdata('user')));

        if($query->num_rows() > 0){
            $row = $query->row();

            $this->db->where('aluno_id', $row->user_id);
            $query = $this->db->get('estagios');

            if($query->num_rows() > 0){
                return $query->result_array();
            }
        }

        return FALSE;
    }

    public function empresa_estagio($id = NULL){
        $this->db->select('nome, id');
        if($id != NULL)
            $this->db->where('id', $id);
        $query = $this->db->get('empresas');

        if($query->num_rows() > 0){
            if($id != NULL)
                $row = $query->row();
            else
                $row = $query->result_array();
            return $row;
        }

        return FALSE;
    }

    public function supervisor_estagio($id = NULL){
        $this->db->select('user_name, user_id');
        if($id != NULL)
            $this->db->where('user_id', $id);
        $query = $this->db->get('users');

        if($query->num_rows() > 0){
            if($id != NULL)
                $row = $query->row();
            else
                $row = $query->result_array();
            return $row;
        }

        return FALSE;
    }

    public function area_estagio($id = NULL){
        $this->db->select('nome, id');
        if($id != NULL) {
            $this->db->where('id', $id);
        }
        $query = $this->db->get('areas');

        if($query->num_rows() > 0){
            if($id != NULL)
                $row = $query->row();
            else
                $row = $query->result_array();
            return $row;
        }

        return FALSE;
    }

    public function carga_estagio($id){
        $this->db->select('carga_horaria');
        $this->db->where('estagio_id', $id);
        $query = $this->db->get('plano_de_atividades');

        if($query->num_rows() > 0){
            if($id != NULL)
                $row = $query->row();
            else
                $row = $query->result_array();
            return $row->carga_horaria;
        }

        return FALSE;
    }

}

