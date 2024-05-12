<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Login extends CI_Controller {

	public function index(){
		$this->load->view('login');
	}
	
	public function ValiderLogin(){
		$this->load->model('LoginModel');
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

	public function deconnexion(){
		$this->session->unset_userdata("idUtilisateur");
		$this->session->unset_userdata("identifiant");
		redirect("Login");
	}

}
