<?php
require_once('classes/session.php');
require_once('classes/utilisateur.php');
require_once('classes/chef.php');
require_once('classes/infos.php');
require_once('classes/ouvrier.php');
require_once('includes/functions.php');


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
?>
<!DOCTYPE html>
<html lang="en">

 <head>
    <meta charset="utf-8">
    <title>Rapports - Barcode Scan</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-responsive.min.css" rel="stylesheet">

    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">
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
      </div><!--/.nav-collapse -->

		</div> <!-- /container -->

	</div> <!-- /navbar-inner -->

</div> <!-- /navbar -->


<div class="subnavbar">
  <div class="subnavbar-inner">
    <div class="container">
      <ul class="mainnav">
        <li><a href="index.php"><i class="icon-dashboard"></i><span>Gestion</span> </a> </li>
        <li class="active"><a href="rapports.php"><i class="icon-list-alt"></i><span>Rapports</span> </a> </li>
        <!-- <li><a href="guidely.html"><i class="icon-facetime-video"></i><span>App Tour</span> </a></li> -->
        <li><a href="stats.php"><i class="icon-bar-chart"></i><span>Stats</span> </a> </li>
        <!-- <li><a href="shortcodes.html"><i class="icon-code"></i><span>Shortcodes</span> </a> </li> -->
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
</div> <!-- /subnavbar -->



<div class="main">
  <div class="main-inner">
    <div class="container">
      <div class="row">

                <?php if (isset($_GET['id'])) {
                    $ou = new Ouvrier();
                    $ou->find_by_id($_GET['id']);
                    $ou_data = $ou->get_ouvrier();
                    $infos=Infos::tous_infos_ouvrier($ou_data['o_id']);
                ?>

        <div class="span12">
            <div class="widget widget-table action-table">
                <div class="widget-header"> <i class="icon-th-list"></i>
                  <h3>Rapport - <?php echo escape($ou_data['o_prenom'] . ' ' . $ou_data['o_nom']); ?></h3>
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
                        <?php $id = $info['i_id']; ?>
                        <td><?php echo escape($info["i_jour"]); ?></td>
                        <td><?php echo escape($info["heure_debut"]); ?></td>
                        <td><?php echo escape($info["heure_fin"]); ?></td>
                        <td class="td-actions">
                        <a href="#deleteInfo<?php echo $id; ?>" role="button" data-toggle="modal" class="btn btn-danger btn-small">Supprimer <i class="btn-icon-only icon-remove"> </i></a></td>
                        <div id="deleteInfo<?php echo $id; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h3 id="myModalLabel">Êtes-vous sûr de vouloir supprimer cet enregistrement</h3>
                            </div>
                            <form action="process/delete.php" method="post">
                                <div class="modal-body pull-left">
                                    <input type="hidden" name="idinfo" value='<?php echo escape($id); ?>'>
                                    <input type="hidden" name="qrcode" value="<?php echo escape($ou_data['qrcode']); ?>" >
                                    <button class="btn btn-danger">Supprimer</button>
                                    <button class="btn" data-dismiss="modal" aria-hidden="true">Annuler</button>
                                </div>
                            </form>
                        </div>                
                      </tr>
                    <?php endforeach; ?>
                    </tbody>
                  </table> 
                    <?php } else {
                        $chefs=Chef::chefs();
                    ?>
                    <?php foreach ($chefs as $chef): 
                        $cid = $chef["c_id"]; 
                    ?>
                        <div class="span6">
                        <div class="widget widget-table action-table">
                            <div class="widget-header"> <i class="icon-th-list"></i>
                              <h3>Ouvriers - <a href="gestion.php?id=<?php echo $cid; ?>">
                                  <?php echo escape($chef['c_prenom'].' '.$chef['c_nom']); ?></a></h3>
                            </div>
                            <div class="widget-content">
                              <table class="table table-striped table-bordered">
                                <thead>
                                  <tr>
                                    <th class="td-photos"></th>
                                    <th> Nom </th>
                                    <th> Prenom</th>
                                    <th class="td-actions"> </th>
                                  </tr>
                                </thead>
                                <tbody>
                                <?php $ouvriers=Ouvrier::liste_ouvriers_chef($cid); 
                                    foreach ($ouvriers as $ouvrier):
                                ?>
                                  <tr>
                                  <td>
                                  <div class="from_user left"> 
                                      <img src="<?php if(empty($ouvrier["photo"])) {
                                          echo "img/message_avatar1.png";
                                      } else {
                                         echo  escape($ouvrier["photo"]);      
                                      }?>"/>
                                    </div>
                                  </td>
                                    <td><?php echo escape($ouvrier["o_nom"]); ?></td>
                                    <td><?php echo escape($ouvrier["o_prenom"]); ?></td>
                                    <td class="td-actions"><a href="rapports.php?id=<?php echo escape($ouvrier["o_id"]); ?>" class="btn btn-small btn-info">Détails<i class="btn-icon-only  icon-arrow-right"> </i></a>
                                    <a href="stats.php?id=<?php echo escape($ouvrier["o_id"]); ?>" class="btn btn-small btn-warning">Graphes<i class="btn-icon-only  icon-arrow-right"> </i></a></td>
                                  </tr>
                                  <?php endforeach; ?>
                                </tbody>
                              </table>
                            </div>
                            <!-- /widget-content --> 
                        </div>
                    </div>
                    <?php endforeach; } ?>
                </div>
            </div>
        </div>
	  </div> <!-- /row -->
	</div> <!-- /container -->
  </div> <!-- /main-inner -->
</div> <!-- /main -->




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
        <div class="span12"> Copyright &copy; <a href="http://www.houtelecom.com/">HouTelecom</a> 2014. Tous droits réservés. </div>
        <!-- /span12 -->
      </div>
      <!-- /row -->
    </div>
    <!-- /container -->
  </div>
  <!-- /footer-inner -->
</div>


<script src="js/jquery-1.7.2.min.js"></script>
<script src="js/excanvas.min.js"></script>
<script src="js/Chart.min.js" type="text/javascript"></script>
<script src="js/bootstrap.js"></script>
<script src="js/base.js"></script>
</body>

</html>
