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

    public function SelectDevisParIdDevis($iddevis){
        $this->load->database();
        $this->db->select('*');
        $this->db->from('v_devis');
        $this->db->where('iddevis' , $iddevis);
        $query = $this->db->get();
        return $query->row();
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

    public function SelectTypeTravaux(){
        $this->load->database();
        $this->db->select('*');
        $this->db->from('typetravaux');
        $query = $this->db->get();
        return $query->result();
    }

    public function SelectTravaux($limit,$offset){
        $this->load->database();
        $this->db->select('*');
        $this->db->from('travaux');
        $this->db->limit($limit,$offset);
        $query = $this->db->get();
        return $query->result();
    }

    public function NombreTravaux(){
        $this->load->database();
        $this->db->select('*');
        $this->db->from('travaux');
        $query = $this->db->get();
        return count($query->result());
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
        $this->db->from('typefinition');
        $this->db->where('idtypefinition' , $idfinition);
        $query = $this->db->get();
        return $query->row();
    }

    public function SelectPrixParTypeMaison($idtypemaison){
        $this->load->database();
        $this->db->select('*');
        $this->db->from('prixpartypemaisonsanspourcentage');
        $this->db->where('idtypemaison' , $idtypemaison);
        $query = $this->db->get();
        return $query->row();
    }

    public function SelectV_TravauxParTypeMaison($idtypemaison){
        $this->load->database();
        $this->db->select('*');
        $this->db->from('v_travauxpartypemaison');
        $this->db->where('idtypemaison' , $idtypemaison);
        $query = $this->db->get();
        return $query->result();
    }

    public function SelectTypeMaisonParIdTypeMaison($idtypemaison){
        $this->load->database();
        $this->db->select('*');
        $this->db->from('typemaison');
        $this->db->where('idtypemaison' , $idtypemaison);
        $query = $this->db->get();
        return $query->row();
    }

    public function InserertDevis($idclient , $idtypemaison , $idfinition , $datedetravaux , $totalprix , $pourcentage , $duree){
        $data = array(
            'idclient' => $idclient,
            'idtypemaison' => $idtypemaison,
            'idtypefinition' => $idfinition,
            'datededebuttravaux' => $datedetravaux,
            'totalprixdevis' => $totalprix,
            'pourcentagefinition' => $pourcentage,
            'duree' => $duree
        );
        
        $this->db->insert('devis', $data);
        return $this->db->insert_id();
    }

    public function InsertDetailsDevis($iddevis , $idtravaux , $prixunitaire , $quantiteunitaire , $quantite , $idunite){
        $data = array(
            'iddevis' => $iddevis,
            'idtravaux' => $idtravaux,
            'prixunitaire' => $prixunitaire,
            'quantiteunitaire' => $quantiteunitaire,
            'quantite' => $quantite,
            'idunite' => $idunite
        );

        $this->db->insert('detailsdevis', $data);
    }

    public function InsertDevisEtDetails($idclient ,$idtypemaison , $idfinition , $dateebutconstruction , $lieu ,$nomlieu , $ref_devis ){
        $prixtotal = $this->SelectPrixParTypeMaison($idtypemaison) ;
        $listedetails = $this->SelectV_TravauxParTypeMaison($idtypemaison);
        $finition = $this->SelectPourcentageParFinition($idfinition);
        $listetypemaison = $this->SelectTypeMaisonParIdTypeMaison($idtypemaison) ;

        $this->db->trans_start();

        $dataInsertDevis = array(
            'idclient' => $idclient,
            'idtypemaison' => $idtypemaison,
            'idtypefinition' => $idfinition,
            'datededebuttravaux' => $dateebutconstruction,
            'totalprixdevis' => $prixtotal->prixtotal,
            'pourcentagefinition' => $finition->pourcentage,
            'duree' => $listetypemaison->duree,
            'idlieu' => $lieu,
            'lieu' => $nomlieu,
            'ref_devis' => $ref_devis
        );

        $this->db->insert('devis' , $dataInsertDevis );

        $iddevis = $this->db->insert_id();
        foreach ($listedetails as $details) {
            $data = array(
                'iddevis' => $iddevis,
                'idtravaux' => $details->idtravaux,
                'prixunitaire' => $details->prixunitaire,
                'quantiteunitaire' => $details->quantiteparunite,
                'quantite' => $details->quantite, 
                'idunite' => $details->idunite
            );
            
            $this->db->insert( 'detailsdevis' , $data);
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo "La transaction a échoué.";
        } else {
            $this->db->trans_complete();
            echo "La transaction a été complétée avec succès.";
        }

    }

    public function Selectv_payement($iddevis){
        $this->load->database();
        $this->db->select('*');
        $this->db->from('v_payement');
        $this->db->where('iddevis' , $iddevis);
        $query = $this->db->get();
        return $query->row();
    }

    public function VerifierSiDejaPayerEntotalite($iddevis){
        $donne = $this->Selectv_payement($iddevis) ;
        if($donne != null){
            if($donne->resteapayer <= 0){
                return true;
            }
        }
        return false;
    }

    public function insererPayement($datedepayement,$iddevis,$montant){
        $data = array(
            'datepayement' => $datedepayement , 
            'iddevis' => $iddevis,
            'montant' => $montant
        );
        
        $this->db->insert('payement', $data);
    }

    public function payer($datedepayement,$iddevis,$montant){
        $verification = $this->VerifierSiDejaPayerEntotalite($iddevis) ;
        $payement = $this->Selectv_payement($iddevis) ;
        $date_aujourdhui = date("Y-m-d");
        $devis = $this->SelectDevisParIdDevis($iddevis);

        if($payement == null){
            if($datedepayement >= $date_aujourdhui){
                if($devis->totalprixdevis >= $montant ){
                    $this->insererPayement($datedepayement,$iddevis,$montant);
                }else{
                    throw new Exception("Le montant a payer doit etre inferieur a celle qui retse à payer");
                }
            }else{
                throw new Exception("La date séléctionné doit etre superieure ou égale à celle d'aujourd'hui");
            }
        }else{
            if($verification == false){
                if($datedepayement >= $date_aujourdhui){
                    if($payement->resteapayer >= $montant ){
                        $this->insererPayement($datedepayement,$iddevis,$montant);
                    }else{
                        throw new Exception("Le montant a payer doit etre inferieur a celle qui retse à payer");
                    }
                }else{
                    throw new Exception("La date séléctionné doit etre superieure ou égale à celle d'aujourd'hui");
                }
            }else{
                throw new Exception("Ce devis est déjà payer en totalité");
            }
        }
    }

//------------------------------------------ fonction pour admin ------------------------------------------------

    public function SelectDevisAvecResteAPayer($limit , $offset) {
        $this->db->select('*');
        $this->db->from('devisavecresteapayer');
        // $this->db->where('datededebuttravaux <= ' , date("Y-m-d"));
        // $this->db->where('datefin >= ' , date("Y-m-d"));
        $this->db->limit($limit , $offset);
        $query = $this->db->get();
        return $query->result();
    }

    public function NombreSelectDevisAvecResteAPayer() {
        $this->db->select('*');
        $this->db->from('devisavecresteapayer');
        // $this->db->where('datededebuttravaux <= ' , date("Y-m-d"));
        // $this->db->where('datefin >= ' , date("Y-m-d"));
        $query = $this->db->get();
        return count($query->result());
    }

    public function AvoirMontantDevisTotale(){
        $this->db->select('*');
        $this->db->from('montanttotaledevis');
        $query = $this->db->get();
        return $query->row();
    }

// histogramme
    public function SelectontantParMois($annee){
        $this->db->select('*');
        $this->db->from('montantparmois');
        $this->db->where('annees' , $annee);
        $query = $this->db->get();
        return $query->result();
    }

    public function MontantparAnnees(){
        $this->db->select('*');
        $this->db->from('montantparannee');
        $query = $this->db->get();
        return $query->result();
    }

    public function SelectLieu(){
        $this->db->select('*');
        $this->db->from('lieu');
        $query = $this->db->get();
        return $query->result();
    }

    public function SelectLieuParIdLieu($idlieu){
        $this->db->select('*');
        $this->db->from('lieu');
        $this->db->where('idlieu',$idlieu);
        $query = $this->db->get();
        return $query->row();
    }

    public function SelectDevisAvecResteAPayerParevis($iddevis) {
        $this->db->select('*');
        $this->db->from('devisavecresteapayer');
        $this->db->where('iddevis',$iddevis);
        $query = $this->db->get();
        return $query->result();
    }

    public function Selectmontanttotalprixdejapayer() {
        $this->db->select('*');
        $this->db->from('montanttotalprixdejapayer');
        $query = $this->db->get();
        return $query->row();
    }
}