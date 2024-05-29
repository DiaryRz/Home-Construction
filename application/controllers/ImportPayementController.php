
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include('BaseSessionAdmin.php');


class ImportPayementController extends BaseSessionAdmin {

	public function __construct() {
        parent::__construct();
        $this->load->model("ImportModel");
        $this->load->helper('file');
    }

    public function formulaire(){
        $data["content"] = "import/importpayement";
        $this->load->view("pageAdmin" , $data);
    }

    public function importPayement(){
        if(isset($_FILES['csv_file']) ) {
            $file_path = $_FILES['csv_file']['tmp_name'];
            $tableau = array();

            if (file_exists($file_path)) {
                $file = fopen($file_path, 'r');
    
                fgets($file);
    
                while (($line = fgetcsv($file, 1000, ','))  !== false) {
                    $tableau[] = implode(';', $line);
                }
                fclose($file);
                $this->ImportModel->InsertImportApresControlePayement($tableau);
                $this->ImportModel->insertChaqueTablePayement();
                $this->formulaire();
            } else {
                echo "Le fichier CSV u maisontravaux n'existe pas.";
            }
        } else {
            // echo $_FILES['csv_file']['error'];
            echo "Aucun fichier n'a été téléchargé.";
        }
    }
    

}
