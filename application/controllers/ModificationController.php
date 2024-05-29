<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include('BaseSessionAdmin.php');

class ModificationController extends BaseSessionAdmin {

	public function __construct() {
        parent::__construct();
        $this->load->model("ModifModel");
        $this->load->model("DevisModel");
        $this->load->library('pagination');
        $this->load->library('form_validation');
    }

    public function index(){
        $data['content'] = "modification/listefinition";
        $data['typefinition'] = $this->ModifModel->SelectFinition();
		$this->load->view('pageAdmin' , $data);
	}

    public function FormulaireFinition(){
        $data['content'] = "modification/finitionmodif";
        $data['idfinition'] = $_GET['idfinition'];
        $data['pourcentage'] = $_GET['pourcentage'];
		$this->load->view('pageAdmin' , $data);
    }

    public function ModifierFinition(){
        $this->form_validation->set_rules('idfinition', 'Type de finition', 'required');
        $this->form_validation->set_rules('pourcentage', 'Pourcentage', 'required|numeric');

		if ($this->form_validation->run() == FALSE) {
            $this->index();
        }else{
            $this->ModifModel->ModifierValeurFinition($_POST['idfinition'] , $_POST['pourcentage'] );
            $this->index();
        }
    }

    public function listetravaux(){
        $config['base_url'] = base_url('ModificationController/listetravaux');
        $config['total_rows'] = $this->DevisModel->NombreTravaux(); 
        $config['per_page'] = 2; 
        $config['full_tag_open'] = '<div class="pagination">';
        $config['full_tag_close'] = '</div>';
    
        $this->pagination->initialize($config);

        $data['listetravaux'] = $this->DevisModel->SelectTravaux($config['per_page'], $this->uri->segment(3));
        $data['content'] = "modification/ListeTravaux" ;

        $this->load->view('pageAdmin' , $data);
    }

    public function ModifierTravaux(){
        $donnee = json_decode(urldecode($_GET['data']), true);

        $data['default'] = $donnee ;
        $data['content'] = "modification/FormulaireTravaux";
        $this->load->view('pageAdmin' , $data);
    }

    public function modifierLeTravaux(){
        $this->ModifModel->ModifierValeur($_POST['idtravaux'],$_POST['numerotravaux'],$_POST['nomtypetravaux'],$_POST['prixunitaire']);
        $this->listetravaux();
    }
}
