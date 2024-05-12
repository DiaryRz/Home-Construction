<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class NettoyerBaseController extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model("NettoyerModel");
    }

	public function index(){
		$data['content'] = "page/Nettoyer";
		$this->load->view('pageAdmin',$data);
	}

    public function nettoyer(){
        $this->NettoyerModel->effacerDonnees();
        $this->index();
    }

}
