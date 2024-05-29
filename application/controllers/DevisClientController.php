<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once FCPATH . 'vendor\autoload.php'; // Charger Dompdf

include('BaseSessionClient.php');

use Dompdf\Dompdf;
use Dompdf\Options;

class DevisClientController extends BaseSessionClient {

	public function __construct() {
        parent::__construct();
        $this->load->model("DevisModel");
        $this->load->library('pagination');
        $this->load->library('form_validation');
    }

	public function index(){
        $config['base_url'] = base_url('DevisClientController/index');
        $config['total_rows'] = $this->DevisModel->NombreDevisParClient($this->session->userdata('idutilisateur')); 
        $config['per_page'] = 2; 
        $config['full_tag_open'] = '<div class="pagination">';
        $config['full_tag_close'] = '</div>';
    
        $this->pagination->initialize($config);

        $data['listedevis'] = $this->DevisModel->SelectDevisParClient($this->session->userdata('idutilisateur'), $config['per_page'], $this->uri->segment(3)) ;
        $data['content'] = "page/ListeDevisParClient";
		$this->load->view('pageClient' , $data);
	}

    public function Exporter(){
        $iddevis = $_GET["iddevis"];
        $detailsdevis= $this->DevisModel->detailsDevis($iddevis) ;
        echo $iddevis;

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $dompdf = new Dompdf($options);

        $data['detailsdevis'] = $detailsdevis;
        $data['typetravaux'] = $this->DevisModel->SelectTypeTravaux();
        // Charger la vue avec les données spécifiques
        $html = $this->load->view('page/DetailsDevis', $data, TRUE);
    
        // Débogage : Affichez le HTML pour vérifier qu'il est correct
        var_dump($html);

        // Charger le HTML dans Dompdf
        $dompdf->loadHtml($html);

        // Rendre le PDF
        $dompdf->render();

        // Enregistrer le PDF dans un fichier
        $pdf_content = $dompdf->output();
        $file_path = "uploads\pdf\pdf_" . $iddevis . ".pdf";
        if (file_put_contents($file_path, $pdf_content) !== false) {
            echo "PDF généré avec succès : $file_path <br>";
        } else {
            echo "Erreur lors de la génération du PDF : $file_path <br>";
        }
    }

    public function FormulaireCreerDevis(){
        $data["listetypemaison"] = $this->DevisModel->SelectTypeMaison() ;
        $data["listetypefinition"] = $this->DevisModel->SelectTypeFinition();
        $data["listelieu"] = $this->DevisModel->SelectLieu();
        $data["content"] = "page/CreerDevis";
        $this->load->view("pageClient" , $data);
    }

    public function Inserer(){
        $this->form_validation->set_rules('date', 'Date', 'required');
        $this->form_validation->set_rules('typemaison', 'Type de maison', 'required');
        $this->form_validation->set_rules('typefinition', 'Type de finition', 'required');

		if ($this->form_validation->run() == FALSE) {
            echo "Erreur";
            $this->FormulaireCreerDevis();
        }else{
            $nomlieu = $this->DevisModel->SelectLieuParIdLieu($_POST['lieu'])->nomlieu;
            $this->DevisModel->InsertDevisEtDetails($this->session->userdata('idutilisateur') , $_POST['typemaison'] , $_POST['typefinition'] , $_POST['date'],$_POST['lieu'],$nomlieu,$_POST['ref_devis']);
            $this->FormulaireCreerDevis();
        }
    }

    public function FormulairePayement(){
        $data['content'] = "page/payementformulaire" ; 
        $data['iddevis'] = $_GET['iddevis'];
        $this->load->view("pageClient" , $data);
    }
	
    public function Payer(){
        $this->form_validation->set_rules('date', 'Date', 'required');
        $this->form_validation->set_rules('montant', 'Montant', 'required|numeric|greater_than_equal_to[0]');

		if ($this->form_validation->run() == FALSE) {
            $data['content'] = "page/payementformulaire" ; 
            if(isset($_POST["iddevis"])){
                $data['iddevis'] = $_POST["iddevis"];
            }else{
                $data['iddevis'] = $_GET["iddevis"];
            }
            $this->load->view("pageClient" , $data);
        }else{
            $iddevis = $_POST["iddevis"];
            $date = $_POST['date'];
            $montant = $_POST['montant'];
            try {
                $this->DevisModel->payer($date, $iddevis , $montant);
                redirect(site_url("DevisClientController"));
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }
    }


    // public function VerifierMontant(){
    //     $iddevis = $this->input->post('iddevis');
    //     $montant = $this->input->post('montant');
    
    //     echo $montant;
    //     // Code pour récupérer le montant total du devis en fonction de $iddevis
    //     $montantTotal = $this->DevisModel->SelectDevisAvecResteAPayerParevis($iddevis)->resteapayer;
    
    //     if($montant > $montantTotal){
    //         echo json_encode(array('error' => 'Le montant ne peut pas être supérieur au montant total du devis.'));
    //     } else {
    //         echo json_encode(array('success' => 'Montant valide.'));
    //     }
    // }
    

}
