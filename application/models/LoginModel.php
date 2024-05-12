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

    function InsertUtilisateur($nom , $dtn , $mail , $mdp  , $idsexe){
        $data = array(
            'nom' => $nom,
            'dtn' =>  $dtn,
            'email' =>  $mail,
            'mdp' =>  $mdp,
            'idsexe' => $idsexe
        );
        
        $this->db->insert('utilisateur', $data);
        return $this->db->insert_id();
    }

    function SelectSexe(){
        $this->load->database();
        $this->db->select('*');
        $this->db->from('sexe');
        $query = $this->db->get();
        return $query->result();
    }


}