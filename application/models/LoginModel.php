<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class LoginModel extends CI_Model {

    function SelectAdminBtp(){
        $this->load->database();
        $this->db->select('*');
        $this->db->from('adminbtp');
        $query = $this->db->get();
        return $query->result();
    }

    function SelectClient(){
        $this->load->database();
        $this->db->select('*');
        $this->db->from('client');
        $query = $this->db->get();
        return $query->result();
    }

    function VerifClient($numero){
        $ListeClient = $this->SelectClient();
        foreach ($ListeClient as $client) {
            if($client->numero == $numero){
                return true;
            }
        }
        return false;
    }

    public function InsertionClient($numero){
        $numero = strval($numero);
        $numero = trim($numero);
        $data = array(
            'numero' => $numero
        );
        
        $this->db->insert('client', $data);
        return $this->db->insert_id();
    }

    public function SelectClientParNumero($numero){
        $this->load->database();
        $this->db->select('*');
        $this->db->from('client');
        $this->db->where('numero' , $numero);
        $query = $this->db->get();
        return $query->row();
    }



}