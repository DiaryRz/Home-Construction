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
    <title>Login form</title>
    <style>
        .lien{
        text-align : center;
      }
        .error {
            margin-left:2%;
            border: 2px solid darkred;
            background-color: #ffcccc; 
            color: black;
            padding: 10px; 
            border-radius: 5px;
            width: fit-content; 
        }
    </style> 
</head>
<body>    
  <div class="form_login">
        <h1>Connectez-vous!</h1>
        <?php echo validation_errors('<div class="error">', '</div>'); ?>
        <form action="<?php echo site_url('Login/LoginClient')?>" method="post">
            <div class="form-group">
                <Label>Numero : </Label>
                <input class="form-control" type="text" name="numero" placeholder="Entrez votre numero de telephone">
            </div>
            <div class="form-group">
                <input class="form-control btn btn-primary" type="submit" value="Se connecter">
            </div>
        </form>
  </div>          
</body>
</html>










