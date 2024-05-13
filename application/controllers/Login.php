<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Login extends CI_Controller {

	public function __construct() {
        parent::__construct();
		$this->load->model('LoginModel');
		$this->load->library('form_validation');
    }

	public function index(){
		$this->load->view('login');
	}
	
	public function ValiderLogin(){
		$listeUtilisateur = $this->LoginModel->SelectAdminBtp();
		$email = $_POST['email'];
		$mdp = $_POST['mdp'];
		$variable = false;
		$identifiant = 1;
		foreach ($listeUtilisateur as $user) {
			if($user->email == $email && $user->mdp == $mdp){
				$variable = true; 
				$this->session->set_userdata("idutilisateur" , $user->idadminbtp);
				if ($this->session->has_userdata('identifiant')) {
					$this->session->unset_userdata('identifiant');
				}
				$this->session->set_userdata("identifiant" , $identifiant);
				break;
			}
		}
		if($variable == true){
			$this->acceuilBackOffice();
		}
		else{
			$tab['mailfaux'] = $_POST['email'];
			$this->load->view('login' , $tab);
		}
	}

	public function acceuilBackOffice(){
		$data['content'] = "page/accueilBackOffice" ;
		$this->load->view('pageAdmin' , $data);
	}

	public function acceuilFrontOffice(){
		$data['content'] = "page/accueilFrontOffice";
		$this->load->view('pageClient' , $data);
	}

	public function deconnexion(){
		$this->session->unset_userdata("idutilisateur");
		$this->session->unset_userdata("identifiant");
		redirect("Login");
	}

	public function FormulaireLoginClient(){
		$this->load->view('LoginClient');
	}

	public function LoginClient(){
		$this->form_validation->set_rules('numero', 'Numero de telephone', 'trim|required|numeric');

		if ($this->form_validation->run() == FALSE) {
            $this->FormulaireLoginClient();
        }else{
			$numero = $_POST['numero'] ;
			$SiClientExiste = $this->LoginModel->VerifClient($numero);
			$identifiant = 0;
			if($SiClientExiste == false){
				$id = $this->LoginModel->InsertionClient($numero);
				if ($this->session->has_userdata('identifiant')) {
					$this->session->unset_userdata('identifiant');
				}
				$this->session->set_userdata("idutilisateur" , $id);
				$this->session->set_userdata("identifiant" , 0);
				$this->acceuilFrontOffice();
			}else{
				$id = $this->LoginModel->SelectClientParNumero($numero)->idclient;
				if ($this->session->has_userdata('identifiant')) {
					$this->session->unset_userdata('identifiant');
				}
				$this->session->set_userdata("idutilisateur" , $id);
				$this->session->set_userdata("identifiant" , 0);
				$this->acceuilFrontOffice();
			}
		}
	}

}
