importerMaisonEtTravaux

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ModifModel extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function SelectFinition() {
        $this->db->select('*');
        $this->db->from('typefinition');
        $query = $this->db->get();
        return $query->result();
    }

    public function ModifierValeurFinition($idfinition,$pourcentage){
        $this->db->trans_start();

        try {
            $data_insert = array(
                'idtypefinition' => $idfinition,
                'pourcentage' => $this->SelectFintionParIdFinition($idfinition)->pourcentage
            );
            $this->db->insert('historiquetypefinition', $data_insert);

            $data_update = array(
                'pourcentage' => $pourcentage
            );
            $this->db->where('idtypefinition', $idfinition);
            $this->db->update('typefinition', $data_update);

            $this->db->trans_commit();

            return true;
        } catch (Exception $e) {
            $this->db->trans_rollback();
            log_message('error', $e->getMessage());
            return false;
        }
    }

    public function SelectFintionParIdFinition($idfinition){
        $this->db->select('*');
        $this->db->from('typefinition');
        $this->db->where('idtypefinition' , $idfinition);
        $query = $this->db->get();
        return $query->row();
    }


    public function ModifierValeur($idtravaux,$numerotravaux,$nomtravax,$prixunitaire){
        $this->db->trans_start();
        $defaulttravaux = $this->SelectTravauxParIdTravaux($idtravaux) ;

        try {
            $data_insert = array(
                'idtravaux' => $idtravaux,
                'prix' => $defaulttravaux->prixunitaire
            );
            $this->db->insert('historiqueprix', $data_insert);

            $data_update = array(
                'numerotravaux' => $numerotravaux,
                'nomtypetravaux' => $nomtravax,
                'prixunitaire' => $prixunitaire
            );
            $this->db->where('idtravaux', $idtravaux);
            $this->db->update('travaux', $data_update);

            $this->db->trans_commit();

            return true;
        } catch (Exception $e) {
            $this->db->trans_rollback();
            log_message('error', $e->getMessage());
            return false;
        }
    }

    public function SelectTravauxParIdTravaux($idtravaux){
        $this->db->select('*');
        $this->db->from('travaux');
        $this->db->where('idtravaux' , $idtravaux);
        $query = $this->db->get();
        return $query->row();
    }
}