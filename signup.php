<?php
require_once('classes/session.php');
require_once ('process/users.php');
include('lib/phpqrcode/qrlib.php');

$session = new Session();

if($session->is_loggedin())
{
    header('Location: gestion.php');
}

?>

<!DOCTYPE html>
<html lang="en">
  
<head>
    <meta charset="utf-8">
    <title>Signup - QR Code Scan</title>

	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes"> 
    
<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css" />

<link href="css/font-awesome.css" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">
    
<link href="css/style.css" rel="stylesheet" type="text/css">
<link href="css/pages/signin.css" rel="stylesheet" type="text/css">

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
			
			<a class="brand" href="index.php">
            <?php            
              QRcode::png('Logo-qrscan', 'qrs/logo.png', 'L', 1, 2);
              echo '<img src="qrs/logo.png" />';
            ?>
            QR Code Scan</a>		
			
			<div class="nav-collapse">
				<ul class="nav pull-right">
					<li class="">						
						<a href="login.php" class="">
							Déja inscrit? connectes-toi
						</a>
						
					</li>
					<li class="">						
						<a href="index.php" class="">
							<i class="icon-chevron-left"></i>
							Page d'accueil
						</a>
						
					</li>
				</ul>
				
			</div><!--/.nav-collapse -->	
	
		</div> <!-- /container -->
		
	</div> <!-- /navbar-inner -->
	
</div> <!-- /navbar -->



<div class="account-container register">
	
	<div class="content clearfix">
		
		<form action="#" method="post">
		
			<h1>Inscription</h1>			
			
			<div class="login-fields">
				
				<p>Créer votre compte:</p>
				
				<div class="field">
					<label for="firstname">Prénom:</label>
					<input type="text" id="firstname" name="firstname" value="" placeholder="Prénom" class="login" />
				</div> <!-- /field -->
				
				<div class="field">
					<label for="lastname">Nom:</label>	
					<input type="text" id="lastname" name="lastname" value="" placeholder="Nom" class="login" />
				</div> <!-- /field -->
				
				
				<div class="field">
					<label for="email">Addresse Email:</label>
					<input type="text" id="email" name="email" value="" placeholder="Email" class="login"/>
				</div> <!-- /field -->
				
				<div class="field">
					<label for="password">Mot de passe:</label>
					<input type="password" id="password" name="password" value="" placeholder="Mot de passe" class="login"/>
				</div> <!-- /field -->
				
				<div class="field">
					<label for="confirm_password">Confirmer le mot de passe:</label>
					<input type="password" id="confirm_password" name="confirm_password" value="" placeholder="Confirmer le mot de passe" class="login"/>
				</div> <!-- /field -->
				
			</div> <!-- /login-fields -->
			
			<div class="login-actions">
				
				<!-- <span class="login-checkbox">
					<input id="Field" name="Field" type="checkbox" class="field login-checkbox" value="First Choice" tabindex="4" />
					<label class="choice" for="Field">Agree with the Terms & Conditions.</label>
				</span> -->
									
				<button class="button btn btn-primary btn-large">S'inscrire</button>
				
			</div> <!-- .actions -->
			
		</form>
		
	</div> <!-- /content -->
	
</div> <!-- /account-container -->


<!-- Text Under Box -->
<div class="login-extra">
	Déja inscrit? <a href="login.php"> connectes-toi.</a>
</div> <!-- /login-extra -->


<script src="js/jquery-1.7.2.min.js"></script>
<script src="js/bootstrap.js"></script>

<script src="js/signin.js"></script>

</body>

 </html>
