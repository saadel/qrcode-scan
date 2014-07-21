<?php
require_once('classes/session.php');
require_once('classes/utilisateur.php');
require_once('classes/infos.php');
require_once('classes/ouvrier.php');
require_once('includes/functions.php');
require_once('includes/qrs.php');
include('lib/phpqrcode/qrlib.php');


$session = new Session();

if(!$session->is_loggedin())
{
  $session->message("vous devez s'authentifier");
  header('Location: login.php');
}
$ut= new Utilisateur();
$ut->find_by_id($session->get_user_id());
$ut_data= $ut->get_utilisateur();

$ou = new Ouvrier();
if(!$ou->find_by_qrcode($_GET['o'])) {
    header('Location: gestion.php');
} else {
    $ou_data = $ou->get_ouvrier();
    $infos=Infos::tous_infos_ouvrier($ou_data['o_id']);

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Dashboard - QR Code Scan</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="apple-mobile-web-app-capable" content="yes">
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/bootstrap-responsive.min.css" rel="stylesheet">
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600"
        rel="stylesheet">
<link href="css/font-awesome.css" rel="stylesheet">
<link href="css/style.css" rel="stylesheet">
<link href="css/pages/dashboard.css" rel="stylesheet">
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
                    <a class="brand" href="index.php">
                    <?php            
                      QRcode::png('Logo', 'qrs/logo.png', 'L', 1, 2);
                      echo '<img src="qrs/logo.png" />';
                    ?>
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
              <li><a href="process/logout.php">Logout</a></li>
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
        <li><a href="index.php"><i class="icon-dashboard"></i><span>Gestion</span> </a> </li>
        <li class="active"><a href="rapports.php"><i class="icon-list-alt"></i><span>Rapports</span> </a> </li>
        <!-- <li><a href="guidely.html"><i class="icon-facetime-video"></i><span>App Tour</span> </a></li> -->
        <li><a href="charts.html"><i class="icon-bar-chart"></i><span>Charts</span> </a> </li>
        <!-- <li><a href="shortcodes.html"><i class="icon-code"></i><span>Shortcodes</span> </a> </li> -->
        <li class="dropdown"><a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"> <i class="icon-long-arrow-down"></i><span>Autres</span> <b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li><a href="icons.html">Icons</a></li>
            <li><a href="faq.html">FAQ</a></li>
            <!-- <li><a href="pricing.html">Pricing Plans</a></li> -->
            <!-- <li><a href="login.php">Login</a></li> -->
            <!-- <li><a href="signup.php">Signup</a></li> -->
            <li><a href="error.html">404</a></li>
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
        <div class="span12">
        	<?php 
        		checkIn($_GET['o']);
                
            ?>

	        <div class="widget widget-table action-table">
	            <div class="widget-header"> <i class="icon-th-list"></i>

                  <h3>Infos - <?php echo escape($ou_data['o_prenom'] . ' ' . $ou_data['o_nom']); ?></h3>
	          		</div>
	            <!-- /widget-header -->
	            <div class="widget-content">

	              <table class="table table-striped table-bordered">
	                <thead>
	                  <tr>
	                  	<th> Jour</th>
	                    <th> Heure d'entrée </th>
	                    <th> Heure de sortie </th>
	                    <th class="td-actions"> </th>
	                  </tr>
	                </thead>
	                <tbody>
	                <?php foreach($infos as $info):?>
	                  <tr>
	                  	<td><?php echo escape($info["i_jour"]); ?></td>
	                    <td><?php echo escape($info["heure_debut"]); ?></td>
	                    <td><?php echo escape($info["heure_fin"]); ?></td>
	                     <td class="td-actions"><a href="#editInfo" role="button" data-toggle="modal" class="btn btn-small btn-invert"><i class="btn-icon-only icon-edit"> Modifier</i></a>
                        <a href="#deleteInfo" role="button" data-toggle="modal" class="btn btn-danger btn-small"><i class="btn-icon-only icon-remove"> </i></a></td>
                        <div id="deleteInfo" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h3 id="myModalLabel">Êtes-vous sûr de vouloir supprimer cet enregistrement</h3>
                            </div>
                            <form action="process/delete.php" method="post">
                                <div class="modal-body pull-left">      
                                    <button class="btn btn-danger">Supprimer</button>
                                    <button class="btn" data-dismiss="modal" aria-hidden="true">Annuler</button>
                                </div>
                            </form>
                        </div>

                        <div id="editInfo" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h3 id="myModalLabel">Modification</h3>
                            </div>
                            <form action="process/edit.php" method="post">
                                <div class="modal-body pull-left">      
                                    <input type="text" placeholder="Heure d'entrée"><br>
                                    <input type="text" placeholder="Heure de sortie"><br><br>
                                    <button class="btn btn-primary">Enregistrer</button>
                                    <button class="btn" data-dismiss="modal" aria-hidden="true">Annuler</button>
                                </div>
                            </form>
                        </div>

                      </tr>
					<?php endforeach; } ?>
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
<script src="js/jquery-1.7.2.min.js"></script> 
<script src="js/excanvas.min.js"></script> 
<script src="js/chart.min.js" type="text/javascript"></script> 
<script src="js/bootstrap.js"></script>
<script language="javascript" type="text/javascript" src="js/full-calendar/fullcalendar.min.js"></script>
 
<script src="js/base.js"></script> 
</body>
</html>
