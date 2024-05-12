<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class NettoyerModel extends CI_Model {
    public function __construct() {
        parent::__construct();
    }

    public function effacerDonnees(){
        $sql = "SELECT * FROM effacer_donnees_sauf_utilisateur()";
        $query = $this->db->query($sql);
    }

}