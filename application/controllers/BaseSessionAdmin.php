<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BaseSessionAdmin extends CI_Controller {

    public function __construct(){
        parent::__construct();
        if(!$this->session->has_userdata('idUtilisateur')) {
            redirect('Login');
        } else {
            if($this->session->userdata('identifiant') != 1) {
                redirect('Login');
            }
        }
        
    }
}
