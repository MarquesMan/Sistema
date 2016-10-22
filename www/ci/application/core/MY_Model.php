<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class MY_Model extends CI_Model {

    public function user_permissions(){
        $this->db->select('user_permissions');
        $this->db->where('user', $this->session->userdata('user'));
        $query = $this->db->get('users');

        $row = $query->row();

        if (isset($row))
        {
            return unserialize($row->user_permissions);
        }

        return NULL;
    }

    public function check_login($permissions_required){
        $permissions = explode('|', $permissions_required);

        if($this->session->userdata('is_logged_in')){
            $user_permission = $this->user_permissions();

            foreach($permissions as $permission){
                if (in_array($permission, $user_permission)) {
                    return TRUE;
                }
            }
        }

        return FALSE;
    }
}

