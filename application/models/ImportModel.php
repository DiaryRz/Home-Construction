importerMaisonEtTravaux

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ImportModel extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function formaterDate($date_string){
        $date_format = 'd/m/Y';
        $date_obj = DateTime::createFromFormat($date_format, $date_string);
        
        if ($date_obj && $date_obj->format($date_format) === $date_string) {
            return true;
        } else {
            return false;
        }
    } 

    function ConstruireTableauDonneesMaisonEtTravaux($nomtypemaison , $description , $surface , $numerotravaux , $nomtypetravaux , $nomunite ,$prixunitaire, $quantite , $duree){
        $tableauDonnes["nomtypemaison"] = $nomtypemaison ;
        $tableauDonnes["description"] = $description ;
        $tableauDonnes["surface"] = $surface ;
        $tableauDonnes["numerotravaux"] = $numerotravaux ;
        $tableauDonnes["nomtypetravaux"] = $nomtypetravaux ;
        $tableauDonnes["nomunite"] = $nomunite ;
        $tableauDonnes["quantite"] = $quantite ;
        $tableauDonnes["duree"] = $duree ;
        $tableauDonnes["prixunitaire"] = $prixunitaire ;
        return $tableauDonnes ; 
    }

    function RemplacerCote($string){
        return str_replace(",","",$string);
    }

    function ControleValeureMaisonEtTravaux($tableau) {
        $tableauErreur = array();
        $tableauDonnes = array(); 
        $i = 1;
        foreach ($tableau as $ligne) {
            $chacun = explode(";", $ligne);
            $nomtypemaison = trim($chacun[0]);
            $description = trim($chacun[1]);
            $surface = trim($chacun[2]);
            $numerotravaux = trim($chacun[3]);
            $nomtypetravaux = trim($chacun[4]);
            $nomunite = trim($chacun[5]);
            $prixunitaire = trim($chacun[6]);
            $quantite = trim($chacun[7]);
            $duree = trim($chacun[8]);
    
            if ($nomtypemaison != null && $description != null && $surface != null && $numerotravaux != null && $nomtypetravaux != null && $nomunite != null && $quantite != null && $duree != null && $prixunitaire != null) {
                $tableauDonnes[] = $this->ConstruireTableauDonneesMaisonEtTravaux($nomtypemaison, $description, $surface, $numerotravaux, $nomtypetravaux ,$nomunite , $prixunitaire, $quantite , $duree);
            } else {
                $tableauErreur[] = "une valeure ne peut pas être nulle, ligne " . $i;
            }
    
            $i++;
        }
        return array($tableauErreur, $tableauDonnes); 
    }

    function InsertMaisonEtTravaux($ligne){
        try{
            $data = array(
                'nomtypemaison' => $ligne['nomtypemaison'],
                'description' => $ligne['description'],
                'surface' => str_replace(",", ".", $ligne['surface']),
                'numerotravaux' => $ligne['numerotravaux'],
                'nomtypetravaux' => $ligne['nomtypetravaux'],
                'nomunite' => $ligne['nomunite'],
                'prixunitaire' => str_replace(",", ".", $ligne['prixunitaire']),
                'quantite' => str_replace(",", ".", $ligne['quantite']),
                'duree' => str_replace(",", ".", $ligne['duree'])
            );
            
            $this->db->insert('formulairemaisonettravaux', $data);
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }

    function InsertImportApresControle($tableau) {
        list($tableauErreur, $tab) = $this->ControleValeureMaisonEtTravaux($tableau);
        try {
            if (empty($tableauErreur)) {
                foreach ($tab as $ligne) {
                    $this->InsertMaisonEtTravaux($ligne);
                }
            } else {
                $sommeErreur = "";
                foreach ($tableauErreur as $erreur) {
                    $sommeErreur = $sommeErreur.$erreur."\n";
                }
                throw new Exception(nl2br($sommeErreur));
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function insertChaqueTableMaisonEtTravaux() {
        try {
            $this->load->database();
            $this->db->trans_start();
            $query1 = " INSERT INTO typemaison (nomtypemaison,duree,description,surface)
                        SELECT DISTINCT nomtypemaison,duree,description,surface
                        FROM formulaireMaisonEtTravaux
                        WHERE NOT EXISTS (
                            SELECT nomtypemaison FROM typemaison
                            WHERE typemaison.nomtypemaison = formulaireMaisonEtTravaux.nomtypemaison
                        )";

            $this->db->query($query1);
            $query2 = " INSERT INTO unite (nomunite)
                        SELECT DISTINCT nomunite
                        FROM formulaireMaisonEtTravaux
                        WHERE NOT EXISTS (
                            SELECT nomunite FROM unite
                            WHERE unite.nomunite = formulaireMaisonEtTravaux.nomunite
                        )";
            $this->db->query($query2);

            $query3 = " INSERT INTO travaux ( numerotravaux,nomtypetravaux,prixunitaire,idunite)
                        SELECT DISTINCT numerotravaux,nomtypetravaux,prixunitaire,idunite
                        FROM formulaireMaisonEtTravaux
                        join unite on unite.nomunite = formulaireMaisonEtTravaux.nomunite
                        WHERE NOT EXISTS (
                            SELECT numerotravaux FROM travaux
                            WHERE travaux.numerotravaux = formulaireMaisonEtTravaux.numerotravaux
                        )";
            $this->db->query($query3);

            $query4 = " INSERT INTO travauxpartypemaison ( idtypemaison,idtravaux,quantite,prixunitaire)
                        SELECT DISTINCT idtypemaison,idtravaux,quantite,formulaireMaisonEtTravaux.prixunitaire
                        FROM formulaireMaisonEtTravaux
                        join travaux on travaux.numerotravaux = formulaireMaisonEtTravaux.numerotravaux
                        join typemaison on typemaison.nomtypemaison = formulaireMaisonEtTravaux.nomtypemaison
                        WHERE NOT EXISTS (
                            SELECT typemaison.idtypemaison,travaux.idtravaux,quantite,formulaireMaisonEtTravaux.prixunitaire 
                            FROM travauxpartypemaison
                            join typemaison on typemaison.nomtypemaison = formulaireMaisonEtTravaux.nomtypemaison
                            join travaux on travaux.numerotravaux = formulaireMaisonEtTravaux.numerotravaux
                            WHERE typemaison.nomtypemaison  = formulaireMaisonEtTravaux.nomtypemaison 
                            AND travaux.nomtypetravaux = formulaireMaisonEtTravaux.nomtypetravaux
                            AND travauxpartypemaison.quantite = formulaireMaisonEtTravaux.quantite
                            AND travauxpartypemaison.prixunitaire = formulaireMaisonEtTravaux.prixunitaire
                        )";
                        
            $this->db->query($query4);

            
            $this->db->trans_complete();
        } catch(Exception $e) {
            echo $e->getMessage();
            $this->db->trans_rollback();
        }
    }

//--------------------------------------------Import de devis -------------------------------------------------
    public function detailsdevissansdevis(){
        $this->db->select('DISTINCT d.iddevis, d.idtypemaison', FALSE); // Ajoutez FALSE pour éviter que CodeIgniter ne protège les noms de colonne
        $this->db->from('devis d');
        $this->db->join('detailsdevis dd', 'd.iddevis = dd.iddevis', 'left');
        $this->db->where('dd.iddevis IS NULL');
        $query = $this->db->get();
        return $query->result();
    }


    function ConstruireTableauDonneesDevis($numero,$ref_devis,$typemaison,$typefinition,$pourcentagefinition,$datedevis,$datededebuttravaux,$lieu){
        $tableauDonnes["numero"] = $numero ;
        $tableauDonnes["ref_devis"] = $ref_devis ;
        $tableauDonnes["typemaison"] = $typemaison ;
        $tableauDonnes["typefinition"] = $typefinition ;
        $tableauDonnes["pourcentagefinition"] = $pourcentagefinition ;
        $tableauDonnes["datedevis"] = $datedevis ;
        $tableauDonnes["datededebuttravaux"] = $datededebuttravaux ;
        $tableauDonnes["lieu"] = $lieu ;
        return $tableauDonnes ; 
    } 

    function ControleValeureDevis($tableau) {
        $tableauErreur = array();
        $tableauDonnes = array(); 
        $i = 1;
        foreach ($tableau as $ligne) {
            $chacun = explode(";", $ligne);
            $numero = trim($chacun[0]);
            $ref_devis = trim($chacun[1]);
            $typemaison = trim($chacun[2]);
            $typefinition = trim($chacun[3]);
            $pourcentagefinition = trim($chacun[4]);
            $datedevis = trim($chacun[5]);
            $datededebuttravaux = trim($chacun[6]);
            $lieu = trim($chacun[7]);

            if ($numero != null && $ref_devis != null && $typemaison != null && $typefinition != null && $pourcentagefinition != null && $datedevis != null && $datededebuttravaux != null && $lieu != null) {
                if($this->formaterDate($datedevis) == true && $this->formaterDate($datededebuttravaux) == true){
                    $tableauDonnes[] = $this->ConstruireTableauDonneesDevis($numero,$ref_devis,$typemaison,$typefinition,$pourcentagefinition,$datedevis,$datededebuttravaux,$lieu);
                } else{
                    $tableauErreur[] = "Date pas valide, ligne " . $i;
                }
            } else {
                $tableauErreur[] = "une valeure ne peut pas être nulle, ligne " . $i;
                if($this->formaterDate($datedevis) == false || $this->formaterDate($datededebuttravaux) == false){
                    $tableauErreur[] = "Date pas valide, ligne " . $i;
                }
            }

            $i++;
        }
        return array($tableauErreur, $tableauDonnes); 
    }

    function InsertFormulaireDevis($ligne){
        try{
            $data = array(
                'numeroclient' => $ligne['numero'],
                'ref_devis' => $ligne['ref_devis'],
                'typemaison' => $ligne['typemaison'],
                'typefinition' => $ligne['typefinition'],
                'pourcentagefinition' => str_replace(",", ".", explode("%" , $ligne['pourcentagefinition'])[0]),
                'datedevis' => $ligne['datedevis'],
                'datededebuttravaux' => $ligne['datededebuttravaux'],
                'lieu' => $ligne['lieu']
            );
            
            $this->db->insert('formulairedevis', $data);
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }

    function InsertImportApresControleDevis($tableau) {
        list($tableauErreur, $tab) = $this->ControleValeureDevis($tableau);
        try {
            if (empty($tableauErreur)) {
                foreach ($tab as $ligne) {
                    $this->InsertFormulaireDevis($ligne);
                }
            } else {
                $sommeErreur = "";
                foreach ($tableauErreur as $erreur) {
                    $sommeErreur = $sommeErreur.$erreur."\n";
                }
                throw new Exception(nl2br($sommeErreur));
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function insertChaqueTableDevis() {
        try {
            $this->load->database();
            $this->load->model("DevisModel");
            $this->db->trans_start();
            $query1 = " INSERT INTO client (numero)
                        SELECT DISTINCT numeroclient
                        FROM formulairedevis
                        WHERE NOT EXISTS (
                            SELECT numero FROM client
                            WHERE client.numero = formulairedevis.numeroclient
                        )";

            $this->db->query($query1);

            $query2 = " INSERT INTO lieu (nomlieu)
                        SELECT DISTINCT lieu
                        FROM formulairedevis
                        WHERE NOT EXISTS (
                            SELECT nomlieu FROM lieu
                            WHERE lieu.nomlieu = formulairedevis.lieu
                        )";

            $this->db->query($query2);

            $query3 = " INSERT INTO typefinition (nomfinition,pourcentage)
                        SELECT DISTINCT typefinition , pourcentagefinition
                        FROM formulairedevis
                        WHERE NOT EXISTS (
                            SELECT nomfinition FROM typefinition
                            WHERE typefinition.nomfinition = formulairedevis.typefinition
                        )";

            $this->db->query($query3);

            $query4 = " INSERT INTO devis (ref_devis,datedevis,idclient,idtypemaison,idtypefinition,datededebuttravaux,totalprixdevis,pourcentagefinition,duree,idlieu,lieu)
                        SELECT DISTINCT ref_devis,datedevis,idclient,idtypemaison,idtypefinition,datededebuttravaux,prixtotal,pourcentage,duree,idlieu,nomlieu
                        FROM AInsererDansDevis
                        WHERE NOT EXISTS (
                            SELECT ref_devis,idtypemaison,datedevis FROM devis
                            WHERE devis.ref_devis = AInsererDansDevis.ref_devis
                            AND devis.idtypemaison = AInsererDansDevis.idtypemaison
                            AND devis.datedevis = AInsererDansDevis.datedevis
                        )";

            $this->db->query($query4);

            $listedevissansdetails = $this->detailsdevissansdevis();

            foreach ($listedevissansdetails as $details) {
                $query5 = " INSERT INTO detailsdevis(iddevis,idtravaux,prixunitaire,quantite,idunite)
                            SELECT DISTINCT ".$details->iddevis.", idtravaux,prixunitaire,quantite,idunite
                            from InsertionDetails 
                        ";
                 $this->db->query($query5);
            }
            

            $this->db->trans_complete();
        } catch(Exception $e) {
            echo $e->getMessage();
            $this->db->trans_rollback();
        }
    }

// ----------------------------------------Pyement----------------------------------------------------------------
    function ConstruireTableauPayement($ref_devis,$ref_paiement,$datepaiement,$montant){
        $tableauDonnes["ref_devis"] = $ref_devis ;
        $tableauDonnes["ref_payement"] = $ref_paiement ;
        $tableauDonnes["datepayement"] = $datepaiement ;
        $tableauDonnes["montant"] = $montant ;
        return $tableauDonnes ; 
    } 

    function ControleValeurePayement($tableau) {
        $tableauErreur = array();
        $tableauDonnes = array(); 
        $i = 1;
        foreach ($tableau as $ligne) {
            $chacun = explode(";", $ligne);
            $ref_payement = trim($chacun[0]);
            $ref_devis = trim($chacun[1]);
            $datepayement = trim($chacun[2]);
            $montant = trim($chacun[3]);

            if ($ref_payement != null && $ref_devis != null && $datepayement != null && $montant != null) {
                if($this->formaterDate($datepayement) == true){
                    $tableauDonnes[] = $this->ConstruireTableauPayement($ref_payement,$ref_devis,$datepayement,$montant);
                } else{
                    $tableauErreur[] = "Date pas valide, ligne " . $i;
                }
            } else {
                $tableauErreur[] = "une valeure ne peut pas être nulle, ligne " . $i;
                if($this->formaterDate($datepayement) == false){
                    $tableauErreur[] = "Date pas valide, ligne " . $i;
                }
            }

            $i++;
        }
        return array($tableauErreur, $tableauDonnes); 
    }

    function InsertFormulairePayement($ligne){
        try{
            $data = array(
                'ref_payement' => $ligne['ref_payement'],
                'ref_devis' => $ligne['ref_devis'],
                'datepayement' => $ligne['datepayement'],
                'montant' => $ligne['montant']
            );
            
            $this->db->insert('formulairepayement', $data);
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }

    function InsertImportApresControlePayement($tableau) {
        list($tableauErreur, $tab) = $this->ControleValeurePayement($tableau);
        try {
            if (empty($tableauErreur)) {
                foreach ($tab as $ligne) {
                    $this->InsertFormulairePayement($ligne);
                }
            } else {
                $sommeErreur = "";
                foreach ($tableauErreur as $erreur) {
                    $sommeErreur = $sommeErreur.$erreur."\n";
                }
                throw new Exception(nl2br($sommeErreur));
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function insertChaqueTablePayement() {
        try {
            $this->load->database();
            $this->db->trans_start();
            $query1 = " INSERT INTO payement ( ref_payement,datepayement,iddevis,montant)
                        SELECT DISTINCT ref_payement,datepayement,devis.iddevis,montant
                        FROM formulairepayement
                        join devis
                        on devis.ref_devis = formulairepayement.ref_devis
                        WHERE NOT EXISTS (
                            SELECT ref_payement,datepayement,devis.iddevis,montant FROM payement
                            join devis
                            on devis.ref_devis = formulairepayement.ref_devis
                            WHERE payement.ref_payement = formulairepayement.ref_payement
                            AND payement.datepayement = formulairepayement.datepayement
                            AND payement.montant = formulairepayement.montant
                            AND payement.iddevis = devis.iddevis
                        )";

            $this->db->query($query1);

            $this->db->trans_complete();
        } catch(Exception $e) {
            echo $e->getMessage();
            $this->db->trans_rollback();
        }
    }

}