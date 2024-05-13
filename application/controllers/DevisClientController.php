<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once FCPATH . 'vendor\autoload.php'; // Charger Dompdf

use Dompdf\Dompdf;
use Dompdf\Options;

class DevisClientController extends CI_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->model("DevisModel");
        $this->load->library('pagination');
        $this->load->library('form_validation');
    }

	public function index(){
        $config['base_url'] = base_url('DevisClientController');
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

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $dompdf = new Dompdf($options);

        $data['detailsdevis'] = $detailsdevis;
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

    // public function recherche() {
    //     $textearechercher = $this->input->get('textearechercher');
    
    //     $config['base_url'] = base_url('ListeController/recherche');  
    //     $config['total_rows'] = $this->ListeModel->CountRechercheListe($textearechercher);
    //     // $config['uri_segment'] = 3;
    //     $config['per_page'] = 2;
    //     $config['full_tag_open'] = '<div class="pagination">';
    //     $config['full_tag_close'] = '</div>';
    //     $config['first_url'] = 'http://localhost/S6/BaseProjetEval/ListeController/recherche/0?textearechercher='.$textearechercher;
    //     $config['suffix'] = '?textearechercher='.$textearechercher;

    //     $this->pagination->initialize($config);
        
    //     $data['utilisateurs'] = $this->ListeModel->RechercheListe($textearechercher, $config['per_page'], $this->uri->segment(3));
    //     $data['content'] = "page/Liste";
    
    //     $this->load->view('page', $data);
    // } 

    public function FormulaireCreerDevis(){
        $data["listetypemaison"] = $this->DevisModel->SelectTypeMaison() ;
        $data["listetypefinition"] = $this->DevisModel->SelectTypeFinition() ;
        $data["content"] = "page/CreerDevis";
        $this->load->view("pageClient" , $data);
        
    }

    public function Inserer(){
        $this->form_validation->set_rules('date', 'Date', 'required');
        $this->form_validation->set_rules('typemaison', 'Type de maison', 'required');
        $this->form_validation->set_rules('typefinition', 'Type de finition', 'required');

		if ($this->form_validation->run() == FALSE) {
            $this->FormulaireCreerDevis();
        }else{}
    }
	

}
