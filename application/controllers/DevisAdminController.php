
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include('BaseSessionAdmin.php');

class DevisAdminController extends BaseSessionAdmin {

	public function __construct() {
        parent::__construct();
        $this->load->model("DevisModel");
        $this->load->library('pagination');
        $this->load->library('form_validation');
    }

    public function index(){
        $config['base_url'] = base_url('DevisAdminController/index');
        $config['total_rows'] = $this->DevisModel->NombreSelectDevisAvecResteAPayer(); 
        $config['per_page'] = 5; 
        $config['full_tag_open'] = '<div class="pagination">';
        $config['full_tag_close'] = '</div>';
    
        $this->pagination->initialize($config);

        $data['listedevis'] = $this->DevisModel->SelectDevisAvecResteAPayer($config['per_page'], $this->uri->segment(3)) ;
        $data['content'] = "page/accueilBackOffice";
		$this->load->view('pageAdmin' , $data);
	}

    public function details(){
        $iddevis = $_GET['iddevis'];
        $data['listedevis'] = $this->DevisModel->detailsDevis($iddevis);
        $data['listedevis'] = $this->DevisModel->detailsDevis($iddevis);
        $data['content'] = "page/ListeDetailsDevis" ;
        $this->load->view("pageAdmin" , $data);
    }

    public function MontantTotalDevis(){
        $data['montant'] = $this->DevisModel->AvoirMontantDevisTotale();
        $data['prixdejapayer'] = $this->DevisModel->Selectmontanttotalprixdejapayer();
        $data['content'] = "page/MontantTotalDevis";
		$this->load->view('pageAdmin' , $data);
    }

    public function ChartParMois(){
        $data['title'] = 'Chiffre d\'affaire par mois ';
        $chart_data = $this->DevisModel->SelectontantParMois($_POST['annee']);
        $data['chart_data'] = $chart_data;
        $data['content'] = "page/HistogrammeParMois";
        $this->load->view('pageAdmin', $data);
    }

    public function FormulaireStat(){
        $data['content'] = "page/FormulaireHistogramme";
        $this->load->view('pageAdmin', $data);
    }
}
