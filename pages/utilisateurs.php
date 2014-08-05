<?php
require_once '../classes/database.php';
require_once '../classes/utilisateur.php';
require_once '../classes/session.php';
require_once '../classes/ouvrier.php';
require_once '../classes/chef.php';
require_once '../includes/functions.php';

$session = new Session();

if(!$session->is_loggedin())
{
  $session->message("vous devez s'authentifier");
  header('Location: ../login.php');
}
$ut= new Utilisateur();
$ut->find_by_id($session->get_user_id());
$ut_data= $ut->get_utilisateur();

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Utilisateurs - QR Code Scan</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="apple-mobile-web-app-capable" content="yes">
<link href="../css/bootstrap.min.css" rel="stylesheet">
<link href="../css/bootstrap-responsive.min.css" rel="stylesheet">
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600"
        rel="stylesheet">
<link href="../css/font-awesome.css" rel="stylesheet">
<link href="../css/style.css" rel="stylesheet">
<link href="../css/pages/dashboard.css" rel="stylesheet">
<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>
<body>
<div class="navbar navbar-fixed-top">
  <div class="navbar-inner">
    <div class="container"> <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"><span
                    class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span> </a>
                    <a class="brand" href="../index.php">
                    <i class="shortcut-icon icon-qrcode"></i>
                    QR Code Scan</a>
      <div class="nav-collapse">
        <ul class="nav pull-right">
          <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i
                            class="icon-cog"></i> Compte <b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a href="javascript:;">Paramètres</a></li>
              <li><a href="javascript:;">Aide</a></li>
            </ul>
          </li>
          <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i
                            class="icon-user"></i> <?php echo $ut_data['username']; ?> <b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a href="profil.php">Profil</a></li>
              <li><a href="../process/logout.php">Logout</a></li>
            </ul>
          </li>
        </ul>
        <form class="navbar-search pull-right">
          <input type="text" class="search-query" placeholder="Recherche">
        </form>
      </div>
      <!--/.nav-collapse --> 
    </div>
    <!-- /container --> 
  </div>
  <!-- /navbar-inner --> 
</div>
<!-- /navbar -->
<div class="subnavbar">
  <div class="subnavbar-inner">
    <div class="container">
      <ul class="mainnav">
        <li><a href="../index.php"><i class="icon-dashboard"></i><span>Gestion</span> </a> </li>
        <li><a href="../rapports.php"><i class="icon-list-alt"></i><span>Rapports</span> </a> </li>
        <li><a href="../stats.php"><i class="icon-bar-chart"></i><span>Stats</span> </a> </li>
        <li class="dropdown active"><a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"> <i class="icon-long-arrow-down"></i><span>Autres</span> <b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li><a href="qrcodes.php">QR Codes</a></li>
            <li><a href="utilisateurs.php">Utilisateurs</a></li>
          </ul>
        </li>
      </ul>
    </div>
    <!-- /container --> 
  </div>
  <!-- /subnavbar-inner --> 
</div>
<!-- /subnavbar -->

<div class="main">
  <div class="main-inner">
    <div class="container">
      <div class="row">
        <div class="span6">
          <div class="widget widget-nopad">
            <div class="widget-header"> <i class="icon-list-alt"></i>
              <h3> Statistiques</h3>
            </div>
            <!-- /widget-header -->
            <div class="widget-content">
              <div class="widget big-stats-container">
                <div class="widget-content">
                  <h6 class="bigstats">
                  <!-- A fully responsive premium quality admin template built 
                  on Twitter Bootstrap by <a href="http://www.egrappler.com" target="_blank">EGrappler.com</a>.  
                  These are some dummy lines to fill the area.</h6> -->
                  <br>
                  &nbsp;&nbsp;&nbsp;&nbsp; <i class="icon-user"></i>&nbsp;Utilisateurs&nbsp;&nbsp;&nbsp;  
                  <i class="icon-user-md"></i>&nbsp;Chefs&nbsp;&nbsp; &nbsp; 
                  <i class="icon-group"></i>&nbsp;Ouvriers&nbsp;&nbsp; &nbsp; 
                  </h6>

                  <div id="big_stats" class="cf">
                    <!-- <div class="stat"> <i class="icon-anchor"></i> <span class="value">851</span> </div> -->
                    <!-- .stat -->
                    <div class="stat"> <i class="icon-user"></i> <span class="value">
                    <?php 
                        echo $ut->count_all();
                    ?></span> </div>
                    <!-- .stat -->
                    
                    <div class="stat"> <i class="icon-user-md"></i> <span class="value">
                    <?php 
                        $ch = new Chef();
                        echo $ch->count_all();
                    ?></span> </div>
                    <!-- .stat -->
                    <div class="stat"> <i class="icon-group"></i> <span class="value">
                    <?php 
                        $ou = new Ouvrier();
                        echo $ou->count_all();
                    ?></span> </div>
                    
                    <!-- .stat --> 
                  </div>
                </div>
                <!-- /widget-content --> 
                
              </div>
            </div>
          </div>
        </div>
        <div class="span6">
          <div class="widget">
            <div class="widget-header"> <i class="icon-bookmark"></i>
              <h3>Raccourcis</h3>
            </div>
            <!-- /widget-header -->
            <div class="widget-content">
              <div class="shortcuts"> <a href="../rapports.php" class="shortcut"><i class="shortcut-icon icon-list-alt"></i><span
                                        class="shortcut-label">Rapports</span> </a><a href="javascript:;" class="shortcut"><i
                                            class="shortcut-icon  icon-sitemap"></i><span class="shortcut-label">Plan du site</span> </a>
                                            <a href="../stats.php" class="shortcut"><i class="shortcut-icon icon-signal"></i> <span class="shortcut-label">Stats</span> </a>
                                            <a href="../pages/qrcodes.php" class="shortcut"> <i class="shortcut-icon icon-qrcode"></i><span class="shortcut-label">QR Codes</span> </a>
                                            <a href="../pages/utilisateurs.php" class="shortcut"><i class="shortcut-icon icon-user"></i><span
                                            class="shortcut-label">Utilisateurs</span> </a><a href="javascript:;" class="shortcut"><i
                                            class="shortcut-icon icon-file"></i><span class="shortcut-label">Notes</span> </a>
                                            <a href="javascript:;" class="shortcut"><i class="shortcut-icon icon-picture"></i> <span class="shortcut-label">Photos</span> </a>
                                            <a href="javascript:;" class="shortcut"> <i class="shortcut-icon icon-calendar"></i><span class="shortcut-label">Calendrier</span> </a> </div>
              <!-- /shortcuts --> 
            </div>
            <!-- /widget-content --> 
          </div>
          </div>
        <div class="span12">
            <div class="widget widget-table action-table">
            <div class="widget-header"> <i class="icon-th-list"></i>
            <?php 
                $utilisateurs=Utilisateur::utilisateurs();
            ?>
                <h3>Utilisateurs</h3>
                </div>
                <!-- /widget-header -->
                <div class="widget-content">

                  <table class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th> Nom </th>
                        <th> Prénom </th>
                        <th> identifiant </th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php foreach($utilisateurs as $utilisateur):?>
                      <tr>
                        <td>
                        <?php echo escape($utilisateur["u_nom"]); ?></td>
                        <td><?php echo escape($utilisateur["u_prenom"]); ?></td>
                        <td><?php echo escape($utilisateur["username"]); ?></td>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
            </div>



        </div>
      </div>
    </div>
  </div>
</div>

<!-- /main -->
<div class="extra">
  <div class="extra-inner">
    <div class="container">
        <div class="row">
            <!-- Copyright © HouTelecom 2014. Tous droits réservés.  -->
        </div>
      <!-- /row --> 
    </div>
    <!-- /container --> 
  </div>
  <!-- /extra-inner --> 
</div>
<!-- /extra -->
<div class="footer">
  <div class="footer-inner">
    <div class="container">
      <div class="row">
        <div class="span12"> Copyright &copy; <a href="http://www.houtelecom.com/">HouTelecom</a> 2014. Tous droits réservés. </div>
        <!-- /span12 --> 
      </div>
      <!-- /row --> 
    </div>
    <!-- /container --> 
  </div>
  <!-- /footer-inner --> 
</div>
<!-- /footer --> 
<script src="../js/jquery-1.7.2.min.js"></script> 
<script src="../js/excanvas.min.js"></script> 
<script src="../js/chart.min.js" type="text/javascript"></script> 
<script src="../js/bootstrap.js"></script>
<script language="javascript" type="text/javascript" src="../js/full-calendar/fullcalendar.min.js"></script>
 
<script src="../js/base.js"></script> 
</body>
</html>
