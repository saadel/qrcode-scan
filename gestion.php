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
        <li class="active"><a href="index.php"><i class="icon-dashboard"></i><span>Gestion</span> </a> </li>
        <li><a href="reports.html"><i class="icon-list-alt"></i><span>Rapports</span> </a> </li>
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
	                    <th> Nom </th>
	                    <th> Prénom </th>
	                    <th class="td-actions"> </th>
	                  </tr>
	                </thead>
	                <tbody>
	                <?php foreach($chefs as $chef):?>
	                  <tr>
	                    <td>
	                    <?php echo escape($chef["c_nom"]); ?></td>
	                    <td><?php echo escape($chef["c_prenom"]); ?></td>
	                    <td class="td-actions"><a href="gestion.php?id=<?php echo escape($chef["c_id"]); ?>" class="btn btn-small btn-invert"><i class="btn-icon-only  icon-group"> Ouvriers</i></a><a href="javascript:;" class="btn btn-danger btn-small"><i class="btn-icon-only icon-remove"> </i></a></td>
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
                        <!-- <p>One fine body…</p> -->
                            <div class="form-group">
                              <input name="nomchef" type="text" class="form-control" required placeholder="Nom">
                            </div>
                            <div class="form-group">
                              <input name="prenomchef" type="text" class="form-control" required placeholder="Prenom">
                          </div>
                      </div>
                      <div class="modal-footer">
                        <button class="btn" data-dismiss="modal" aria-hidden="true">Annuler</button>
                        <button class="btn btn-primary">Enregistrer</button>
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
	                    <th> Nom </th>
	                    <th> Prénom </th>
	                    <th class="td-actions"> </th>
	                  </tr>
	                </thead>
	                <tbody>
	                <?php foreach($ouvriers as $ouvrier):?>
	                  <tr>
	                    <td>
	                    <?php echo escape($ouvrier["o_nom"]); ?></td>
	                    <td><?php echo escape($ouvrier["o_prenom"]); ?></td>
	                    <td class="td-actions"><a href="rapports.php?id=<?php echo escape($ouvrier["o_id"]); ?>" class="btn btn-small btn-invert"><i class="btn-icon-only icon-time"> Rapport</i></a><a href="javascript:;" class="btn btn-danger btn-small"><i class="btn-icon-only icon-remove"> </i></a></td>
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
                        <!-- <p>One fine body…</p> -->
                        	<div class="form-group">
    	                      <input name="nomouvrier" type="text" class="form-control" required placeholder="Nom">
    	                    </div>
    	                    <div class="form-group">
    	                      <input name="prenomouvrier" type="text" class="form-control" required placeholder="Prenom">
    	                  </div>
    	                  <div class="form-group" id="qr">
                            <?php
                                $qrcode = md5($_GET['id'] + microtime());
                                $qrcode = substr($qrcode, -13, 7);
                                $qrsrc = 'qrs/qr' . $qrcode . '.png';
                                QRcode::png('qrcodescan.com?ouvrier' . $qrcode , $qrsrc, 'L', 4, 2);
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
                        <button class="btn" data-dismiss="modal" aria-hidden="true">Annuler</button>
                        <button class="btn btn-primary">Enregistrer</button>
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

<!-- /main -->
<div class="extra">
  <div class="extra-inner">
    <div class="container">
      <div class="row">
                    <div class="span3">
                        <h4>
                            About Free Admin Template</h4>
                        <ul>
                            <li><a href="javascript:;">EGrappler.com</a></li>
                            <li><a href="javascript:;">Web Development Resources</a></li>
                            <li><a href="javascript:;">Responsive HTML5 Portfolio Templates</a></li>
                            <li><a href="javascript:;">Free Resources and Scripts</a></li>
                        </ul>
                    </div>
                    <!-- /span3 -->
                    <div class="span3">
                        <h4>
                            Support</h4>
                        <ul>
                            <li><a href="javascript:;">Frequently Asked Questions</a></li>
                            <li><a href="javascript:;">Ask a Question</a></li>
                            <li><a href="javascript:;">Video Tutorial</a></li>
                            <li><a href="javascript:;">Feedback</a></li>
                        </ul>
                    </div>
                    <!-- /span3 -->
                    <div class="span3">
                        <h4>
                            Something Legal</h4>
                        <ul>
                            <li><a href="javascript:;">Read License</a></li>
                            <li><a href="javascript:;">Terms of Use</a></li>
                            <li><a href="javascript:;">Privacy Policy</a></li>
                        </ul>
                    </div>
                    <!-- /span3 -->
                    <div class="span3">
                        <h4>
                            Open Source jQuery Plugins</h4>
                        <ul>
                            <li><a href="http://www.egrappler.com">Open Source jQuery Plugins</a></li>
                            <li><a href="http://www.egrappler.com;">HTML5 Responsive Tempaltes</a></li>
                            <li><a href="http://www.egrappler.com;">Free Contact Form Plugin</a></li>
                            <li><a href="http://www.egrappler.com;">Flat UI PSD</a></li>
                        </ul>
                    </div>
                    <!-- /span3 -->
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
        <div class="span12"> &copy; 2014 <a href="http://www.houtelecom.com/">HouTelecom</a>. </div>
        <!-- /span12 --> 
      </div>
      <!-- /row --> 
    </div>
    <!-- /container --> 
  </div>
  <!-- /footer-inner --> 
</div>
<!-- /footer --> 
<!-- Le javascript
================================================== --> 
<!-- Placed at the end of the document so the pages load faster --> 
<script src="js/jquery-1.7.2.min.js"></script> 
<script src="js/excanvas.min.js"></script> 
<script src="js/chart.min.js" type="text/javascript"></script> 
<script src="js/bootstrap.js"></script>
<script language="javascript" type="text/javascript" src="js/full-calendar/fullcalendar.min.js"></script>
 
<script src="js/base.js"></script> 
</body>
</html>
