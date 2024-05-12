<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.104.2">
    <link href="<?php echo site_url("assets/bootstrap-5.0.2-dist/css/bootstrap.min.css") ?>" rel="stylesheet">
    <link href="<?php echo site_url("assets/Login.css") ?>" rel="stylesheet">
    <link rel="icon" type="image/png" href="<?php echo base_url() ?>/assets/img/logo.png">
    <title>Insription form</title>
    <style>
      .error {
          margin-left:2%;
          border: 2px solid darkred;
          background-color: #ffcccc; 
          color: black;
          padding: 10px; 
          border-radius: 5px;
          width: fit-content; 
      }
      .lien{
        text-align : center;
      }
  </style> 
</head>
<body>    
  <div class="form_login">
    
          <h1>Inscrivez-vous!</h1>
            <?php echo validation_errors('<div class="error">', '</div>'); ?>
            <form action="<?php echo base_url('Login/VerifierInscription')?>" method="post">
                <div class="form-group">
                  <Label>Nom : </Label>
                  <input class="form-control" type="text" name="nom" <?php if(validation_errors()) : ?> value="<?php echo set_value('nom', $this->session->userdata('current_client')); ?>" <?php endif; ?>>
                </div>
                <div class="form-group">
                  <Label>Email : </Label>
                  <input class="form-control" type="text" name="email" <?php if(validation_errors()) : ?> value="<?php echo set_value('email', $this->session->userdata('current_client')); ?>" <?php endif; ?>>
                </div>
                <div class="form-group">
                  <Label>Date de naissance : </Label>
                  <input class="form-control" type="date" name="dtn" <?php if(validation_errors()) : ?> value="<?php echo set_value('dtn', $this->session->userdata('current_client')); ?>" <?php endif; ?>>
                </div>
                <div class="form-group">
                  <Label>Sexe: </Label>
                  <select name="sexe" class="form-control">
                    <?php foreach ($sexe as $sexee) { ?>
                      <option value="<?php echo $sexee->idsexe ?>" <?php if(validation_errors()) : ?> <?php echo set_select('sexe', $sexee->idsexe, ($this->session->userdata('current_client') == $sexee->idsexe)); ?> <?php endif; ?>>
                          <?php echo $sexee->nomsexe ?>
                      </option>
                    <?php } ?>
                  </select>
                </div>
                <div class="form-group">
                  <Label>Mot de passe : </Label>
                  <input class="form-control" type="password" name="mdp">
                </div>
                <div class="form-group">
                  <input class="form-control btn btn-primary" type="submit" value="Se connecter">
                </div>
            </form>
            <div class="lien"><a href="<?php echo base_url('Login') ?>">Connectez-vous!</a></div>
  </div>          
</body>
</html>










