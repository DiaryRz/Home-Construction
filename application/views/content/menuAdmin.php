
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url() ?>/assets/img/logo.png">
  <link rel="icon" type="image/png" href="<?php echo base_url() ?>/assets/img/logo.png">
  <title>
    Home construction
  </title>
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="<?php echo base_url() ?>/assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="<?php echo base_url() ?>/assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link href="<?php echo base_url() ?>/assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- CSS Files -->
  <link id="pagestyle" href="<?php echo base_url() ?>/assets/css/soft-ui-dashboard.css?v=1.0.3" rel="stylesheet" />

  <style>
    .icone{
      width:140px;
      height : 50px;
    }
  </style>
</head>

<body class="g-sidenav-show  bg-gray-100">
  <!-- MENU -->
  <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 " id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
        <img src="<?php echo base_url() ?>/assets/img/maison.png" class="navbar-brand-img h-100 icone" alt="main_logo">
    </div>
    <hr class="horizontal dark mt-0">

    <!-- Effacer donnees -->
    <div class="collapse navbar-collapse  w-auto  max-height-vh-100 h-100" id="sidenav-collapse-main">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a 
            class="nav-link  " 
            href="<?php echo base_url("NettoyerBaseController") ?>"
          >
            <i class="fa fa-trash"></i>
            <span class="nav-link-text ms-1">Nettoyer les données</span>
          </a>
        </li>

      </ul>







    </div>
  </aside>