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
		$listeUtilisateur = $this->LoginModel->SelectUtilisateur();
		$email = $_POST['email'];
		$mdp = $_POST['mdp'];
		$variable = false;
		$identifiant = 0;
		foreach ($listeUtilisateur as $user) {
			if($user->email == $email && $user->mdp == $mdp){
				$variable = true; 
				$this->session->set_userdata("idUtilisateur" , $user->idutilisateur);
				$identifiant = $user->identifiant ;
				if ($this->session->has_userdata('identifiant')) {
					$this->session->unset_userdata('identifiant');
				}
				$this->session->set_userdata("identifiant" , $identifiant);
				break;
			}
		}
		if($variable == true){
			if($this->session->userdata('identifiant') == 1){
				echo "back".$this->session->userdata('identifiant');
				$this->acceuilBackOffice();
			}else{
				echo "front".$this->session->userdata('identifiant');
				$this->acceuilFrontOffice();
			}	
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

	public function pageInscription(){
		$data['sexe'] = $this->LoginModel->SelectSexe();
		$this->load->view("Inscription" , $data);
	}

	public function VerifierInscription(){
		$this->form_validation->set_rules('nom', 'Nom', 'trim|required');
		$this->form_validation->set_rules('email', 'E-Mail', 'trim|required|valid_email');
		$this->form_validation->set_rules('mdp', 'Mot de passe', 'required|min_length[4]');
		$this->form_validation->set_rules('dtn', 'Date de naissance', 'required');

		if ($this->form_validation->run() == FALSE) {
            $this->pageInscription();
        }else{
			$id = $this->LoginModel->InsertUtilisateur($_POST['nom'] , $_POST['dtn'] , $_POST['email'] ,  $_POST['mdp'] , $_POST['sexe']);
			$this->session->set_userdata("identifiant" , 0);
			$this->session->set_userdata("idUtilisateur" , $id);
			$this->acceuilFrontOffice();
		}
	}

	public function deconnexion(){
		$this->session->unset_userdata("idUtilisateur");
		$this->session->unset_userdata("identifiant");
		redirect("Login");
	}

}
