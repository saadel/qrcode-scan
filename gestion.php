<?php
require_once('classes/session.php');
require_once('classes/utilisateur.php');
require_once('classes/chef.php');
require_once('classes/ouvrier.php');
require_once('includes/functions.php');
include('lib/phpqrcode/qrlib.php');


$session = new Session();

if(!$session->is_loggedin())
{
  $session->message("vous devez s'authentifier");
  header('Location: login.php');
}
$_SESSION["last_date"]="";
$ut= new Utilisateur();
$ut->find_by_id($session->get_user_id());

$ut_data= $ut->get_utilisateur();
$chefs=Chef::chefs();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Gestion - QR Code Scan</title>
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
        <li class="active"><a href="index.php"><i class="icon-dashboard"></i><span>Gestion</span> </a> </li>
        <li><a href="rapports.php"><i class="icon-list-alt"></i><span>Rapports</span> </a> </li>
        <li><a href="stats.php"><i class="icon-bar-chart"></i><span>Stats</span> </a> </li>
        <li class="dropdown"><a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"> <i class="icon-long-arrow-down"></i><span>Autres</span> <b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li><a href="pages/utilisateurs.php">Utilisateurs</a></li>            
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
                  <h6>
                  <br>
                  &nbsp;&nbsp;&nbsp;&nbsp; <i class="icon-user"></i>&nbsp;Utilisateurs&nbsp;&nbsp;&nbsp;  
                  <i class="icon-user-md"></i>&nbsp;Chefs&nbsp;&nbsp; &nbsp; 
                  <i class="icon-group"></i>&nbsp;Ouvriers&nbsp;&nbsp; &nbsp; 
                  </h6>

                  <div id="big_stats" class="cf">
                    <!-- <div class="stat"> <i class="icon-anchor"></i> <span class="value">851</span> </div> -->
                    <!-- .stat -->
                    <div class="stat"> <i class="icon-user"></i><h3>
                    <?php 
                        echo $ut->count_all();
                        ?></h3> </div>
                    <!-- .stat -->
                    
                    <div class="stat"> <i class="icon-user-md"></i><h3><span>
                    <?php 
                        $ch = new Chef();
                        echo $ch->count_all();
                        ?></span></h3> </div>
                    <!-- .stat -->
                    <div class="stat"> <i class="icon-group"></i><h3><span>
                    <?php 
                        $ou = new Ouvrier();
                        echo $ou->count_all();
                        ?></span></h3> </div>
                    
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
            <br>
              <div class="shortcuts"> <a href="rapports.php" class="shortcut"><i class="shortcut-icon icon-list-alt"></i><span
                                        class="shortcut-label">Rapports</span> </a><a href="javascript:;" class="shortcut"><i
                                            class="shortcut-icon  icon-sitemap"></i><span class="shortcut-label">Plan du site</span> </a><a href="stats.php" class="shortcut"><i class="shortcut-icon icon-signal"></i> <span class="shortcut-label">Stats</span> </a><a href="pages/qrcodes.php" class="shortcut"> <i class="shortcut-icon icon-qrcode"></i><span class="shortcut-label">QR Codes</span> </a> </div>
              <!-- /shortcuts --> 
              <br>
            </div>
            <!-- /widget-content --> 
          </div>
          </div>
        <div class="span12">
          <div class="widget widget-table action-table">
            <div class="widget-header"> <i class="icon-th-list"></i>
            <?php 
            if (empty($_GET['id'])) { 
            ?>
                <h3>Chefs</h3>
          		</div>
	            <!-- /widget-header -->
	            <div class="widget-content">

	              <table class="table table-striped table-bordered">
	                <thead>
	                  <tr>
                        <th class="td-photos"></th>
	                    <th> Nom </th>
	                    <th> Prénom </th>
	                    <th class="td-actions"> </th>
	                  </tr>
	                </thead>
	                <tbody>
	                <?php foreach($chefs as $chef):?>
	                  <tr>
	                  	<?php $id = $chef["c_id"]; ?>
                        <td>
                      <div class="from_user left"> 
                          <img src="<?php if(empty($ouvrier["photo"]))
                          {
                              echo "img/message_avatar1.png";
                          }else
                          {
                             echo  escape($ouvrier["photo"]);      
                          }
                          ?>"/>
                        </div>
                      </td>
	                    <td>
	                    <?php echo escape($chef["c_nom"]); ?></td>
	                    <td><?php echo escape($chef["c_prenom"]); ?></td>
	                    <td class="td-actions"><a href="gestion.php?id=<?php echo escape($id); ?>" class="btn btn-small btn-invert"><i class="btn-icon-only  icon-group"> Ouvriers</i></a>
                      <a href="#deleteChef<?php echo $id; ?>" role="button" data-toggle="modal" class="btn btn-danger btn-small"><i class="btn-icon-only icon-remove"> </i></a>
  	                  <div id="deleteChef<?php echo $id; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h3 id="myModalLabel">Êtes-vous sûr de vouloir supprimer ce chef</h3>
                      </div>
                        <form action="process/delete.php" method="post">
                          <div class="modal-body pull-left">    
                          	<input type="hidden" name="idchef" value='<?php echo escape($id); ?>'>                      
                            <button class="btn btn-danger">Supprimer</button>
                            <button class="btn" data-dismiss="modal" aria-hidden="true">Annuler</button>
                          </div>
                        </form>
                    </div>
                    </td>
                    </tr>
					<?php endforeach; ?>
	                </tbody>
	              </table>
	            </div>
                <br /><div class="controls">
                <a href="#myModal" role="button" class="btn btn-info" data-toggle="modal">Ajouter un chef</a>
                </div>
                <!-- Modal -->
                <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 id="myModalLabel">Ajout d'un nouveau chef</h3>
                  </div>
                    <form action="process/add.php" method="post">
                      <div class="modal-body">
                            <div class="form-group">
                              <input name="nomchef" type="text" class="form-control" required placeholder="Nom">
                            </div>
                            <div class="form-group">
                              <input name="prenomchef" type="text" class="form-control" required placeholder="Prenom">
                          </div>
                      </div>
                      <div class="modal-footer">
                        <button class="btn btn-primary">Enregistrer</button>
                        <button class="btn" data-dismiss="modal" aria-hidden="true">Annuler</button>
                      </div>
                    </form>
                </div>


            <?php 
        	} else {
            	$ouvriers=Ouvrier::liste_ouvriers_chef($_GET['id']);
            ?>
        		<h3>Ouvriers</h3>
          		</div>
	            <!-- /widget-header -->
	            <div class="widget-content">

	              <table class="table table-striped table-bordered">
	                <thead>
	                  <tr>
                    <th class="td-photos"></th>
                      <th> Nom </th>
                      <th> Prénom </th>
                      <th class="td-actions"> </th>
	                  </tr>
	                </thead>
	                <tbody>
	                <?php foreach($ouvriers as $ouvrier):?>
	                  <tr>
	                  	<?php $oid = $ouvrier["o_id"]; ?>
	                    <td>
                      <div class="from_user left"> 
                      <!-- <a href="#" class="avatar"><img src="img/message_avatar1.png"/></a> -->
                          <img src="<?php if(empty($ouvrier["photo"]))
                          {
                              echo "img/message_avatar1.png";
                          }else
                          {
                             echo  escape($ouvrier["photo"]);      
                          }
                          ?>"/>
                     
                          <!-- Changer la photo <input type="file"> -->
                        </div>
                      </td>
                      <td>
	                    <?php echo escape($ouvrier["o_nom"]); ?></td>
	                    <td><?php echo escape($ouvrier["o_prenom"]); ?></td>
	                    <td class="td-actions"><a href="rapports.php?id=<?php echo escape($oid); ?>" class="btn btn-small btn-invert"><i class="btn-icon-only icon-time"> Rapport</i></a>
                        <a href="#deleteOuvrier<?php echo $oid; ?>"role="button" data-toggle="modal" class="btn btn-danger btn-small"><i class="btn-icon-only icon-remove"> </i></a></td>
	                    <div id="deleteOuvrier<?php echo $oid; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	                        <div class="modal-header">
	                        	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	                      	    <h3 id="myModalLabel">Êtes-vous sûr de vouloir supprimer cet ouvrier</h3>
	                        </div>
	                        <form action="process/delete.php" method="post">
	                        	<div class="modal-body pull-left">      
	                        		<input type="hidden" name="chefid" value="<?php echo $_GET['id']; ?>">
	                        		<input type="hidden" name="idouvrier" value='<?php echo escape($oid); ?>'>                      
	                            	<button class="btn btn-danger">Supprimer</button>
	                            	<button class="btn" data-dismiss="modal" aria-hidden="true">Annuler</button>
	                          	</div>
	                        </form>
	                    </div>

                    </tr>
					<?php endforeach; ?>
	                </tbody>
	              </table>	              
            	</div>
                <br /><div class="controls">
                <a href="#myModal" role="button" class="btn btn-info" data-toggle="modal">Ajouter un ouvrier</a>
                </div>
                <!-- Modal -->
                <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 id="myModalLabel">Ajout d'un nouveau ouvrier</h3>
                  </div>
                    <form method="post" action="process/add.php">
                      <div class="modal-body">
                        	<div class="form-group">
    	                      <input name="nomouvrier" type="text" class="form-control" required placeholder="Nom">
    	                    </div>
    	                    <div class="form-group">
    	                      <input name="prenomouvrier" type="text" class="form-control" required placeholder="Prenom">
    	                    </div>

                            <!-- <input  type="file" name="ophoto" class="form-control" required > -->
                        <!-- </div> -->
    	                  <div class="form-group" id="qr">
                            <?php
                                $qrcode = md5($_GET['id'] + microtime());
                                $qrcode = substr($qrcode, -13, 7);
                                $qrsrc = 'qrs/qr' . $qrcode . '.png';
                                QRcode::png('qrcodescan.com/qrcode.php?o=' . $qrcode , $qrsrc, 'L', 4, 2);
                            ?>
                            <script>
                                var DOM_img = document.createElement("img");
                                DOM_img.src = "<?php echo($qrsrc); ?>";
    	                    </script>
                            <input type="hidden" name="qrcode" value="<?php echo $qrcode; ?>">
                            <input type="hidden" name="chef" value="<?php echo $_GET['id']; ?>">
                            <button type="button" class="btn" onclick="document.getElementById('qr').appendChild(DOM_img)">Générer le QR Code</button>
    	                </div>
                      </div>
                      <div class="modal-footer">
                        <button class="btn btn-primary">Enregistrer</button>
                        <button class="btn" data-dismiss="modal" aria-hidden="true">Annuler</button>
                      </div>
                    </form>
                </div>
            <?php } ?>
            <!-- /widget-content --> 
        </div>
      </div>
    </div>
  </div>
</div>

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

<div class="footer">
  <div class="footer-inner">
    <div class="container">
      <div class="row">
        <div class="span12"> Copyright &copy; <a href="http://www.houtelecom.com/">HouTelecom</a> 2014.
            Tous droits réservés.
        </div>
      </div>
    </div>
  </div>
</div>

<script src="js/jquery-1.7.2.min.js"></script> 
<script src="js/excanvas.min.js"></script> 
<script src="js/chart.min.js" type="text/javascript"></script> 
<script src="js/bootstrap.js"></script>
<script language="javascript" type="text/javascript" src="js/full-calendar/fullcalendar.min.js"></script>
<script src="js/base.js"></script> 
</body>
</html>
