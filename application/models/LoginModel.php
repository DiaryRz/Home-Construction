<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class LoginModel extends CI_Model {

    function SelectUtilisateur(){
        $this->load->database();
        $this->db->select('*');
        $this->db->from('utilisateur');
        $query = $this->db->get();
        return $query->result();
    }

}