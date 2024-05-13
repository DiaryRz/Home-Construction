<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DevisModel extends CI_Model {
    public function __construct() {
        parent::__construct();
    }

    public function SelectDevisParClient($idClient , $limit , $offset){
        $this->load->database();
        $this->db->select('*');
        $this->db->from('v_devis');
        $this->db->where('idclient' , $idClient);
        $this->db->limit($limit , $offset);
        $query = $this->db->get();
        return $query->result();
    }

    public function NombreDevisParClient($idClient){
        $this->load->database();
        $this->db->select('*');
        $this->db->from('v_devis');
        $this->db->where('idclient' , $idClient);
        $query = $this->db->get();
        return count($query->result());
    }

    public function detailsDevis($iddevis){
        $this->load->database();
        $this->db->select('*');
        $this->db->from('v_detailsdevis');
        $this->db->where('iddevis' , $iddevis);
        $query = $this->db->get();
        return $query->result();
    }

    public function SelectTypeMaison(){
        $this->load->database();
        $this->db->select('*');
        $this->db->from('typemaison');
        $query = $this->db->get();
        return $query->result();
    }

    public function SelectTypeFinition(){
        $this->load->database();
        $this->db->select('*');
        $this->db->from('typefinition');
        $query = $this->db->get();
        return $query->result();
    }

    public function SelectPourcentageParFinition($idfinition){
        $this->load->database();
        $this->db->select('*');
        $this->db->from('typefinition;');
        $this->db->where('idtypefinition' , $idfinition);
        $query = $this->db->get();
        return $query->row();
    }

    public function SelectPrixParTypeMaison($idtypemaison){
        $this->load->database();
        $this->db->select('*');
        $this->db->from('PrixParTypeMaison');
        $this->db->where('idtypemaison' , $idtypemaison);
        $query = $this->db->get();
        return $query->row();
    }


}