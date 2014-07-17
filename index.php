<?php
require_once('classes/session.php');
include "lib/phpqrcode/qrlib.php";

$session = new Session();

if($session->is_loggedin())
{
    header('Location: qrcode.php');
}

?>
<!DOCTYPE html>
<html lang="en">
  
<head>
    <meta charset="utf-8">
    <title>QR Code Scan</title>

	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes"> 
	    
	<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<link href="css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css" />
	
	<link href="css/font-awesome.css" rel="stylesheet">
	    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">
	    
	<link href="css/style.css" rel="stylesheet" type="text/css" />

</head>

<body>
	
	<div class="navbar navbar-fixed-top">
	
	<div class="navbar-inner">
		
		<div class="container">
			
			<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</a>
			
			<a class="brand" href="index.html">
				QR Code Scan				
			</a>					
	
		</div> <!-- /container -->
		
	</div> <!-- /navbar-inner -->
	
</div> <!-- /navbar -->



<div class="container">
	
	<div class="row">
		
		<div class="span12">
			
			<div class="error-container">
				<h1>QR Code Scan</h1>
				
				<h2>Bienvenue à QR Code Scan</h2>
				<div>
				<?php 					 
					QRcode::png('Ouvrier1', 'img/test.png', 'L', 4, 2);
					echo '<img src="img/test.png" />';
				?>
				</div>
				<div class="error-details">
					Le site web pour la gestion des ouvriers
					
				</div> <!-- /error-details -->				
				<div class="error-actions">
					<a href="login.php" class="btn btn-large btn-primary">
						&nbsp;
						Identification						
						<i class="icon-chevron-right"></i>
					</a>
					
					
					
				</div> <!-- /error-actions -->
							
			</div> <!-- /error-container -->			
			
		</div> <!-- /span12 -->
		
	</div> <!-- /row -->
	
</div> <!-- /container -->


<script src="js/jquery-1.7.2.min.js"></script>
<script src="js/bootstrap.js"></script>
</body>

</html>
