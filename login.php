<?php
require_once('classes/session.php');
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
    <title>Login - QR Code Scan</title>

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
              QRcode::png('Logo', 'qrs/logo.png', 'L', 1, 2);
              echo '<img src="qrs/logo.png" />';
            ?>
            QR Code Scan</a>		
			
			<div class="nav-collapse">
				<ul class="nav pull-right">
					
					<li class="">						
						<a href="signup.php" class="">
							Vous n'avez pas de compte?
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



<div class="account-container">
	
	<div class="content clearfix">
		
		<form action="process/login.php" method="post">
		
			<h1>Identification</h1>		
			
			<div class="login-fields">
					<?php 
	                    if ($session->message()) {
				            echo '<div class="alert alert-info">
				                    <button type="button" class="close" data-dismiss="alert">
				                    &times;</button>';
	                        echo $session->message(); 
	                        echo "</div>";    
	                    }
	                 ?> 
				<!-- <p>Please provide your details</p> -->
				
				<div class="field">
					<label for="username">Username</label>
					<input type="text" id="username" name="username" value="" placeholder="Utilisateur" class="login username-field" required/>
				</div> <!-- /field -->
				
				<div class="field">
					<label for="password">Password</label>
					<input type="password" id="pass" name="pass" value="" placeholder="Mot de passe" class="login password-field" required/>
				</div> <!-- /password -->
				
			</div> <!-- /login-fields -->
			
			<div class="login-actions">
				
				<span class="login-checkbox">
					<input id="Field" name="Field" type="checkbox" class="field login-checkbox" value="First Choice" tabindex="4" />
					<label class="choice" for="Field">Garder ma session active</label>
				</span>
									
				<button class="button btn btn-success btn-large">S'identifier</button>
				
			</div> <!-- .actions -->
			
			
			
		</form>
		
	</div> <!-- /content -->
	
</div> <!-- /account-container -->



<div class="login-extra">
	<a href="#">Mot de passe oublié</a>
</div> <!-- /login-extra -->


<script src="js/jquery-1.7.2.min.js"></script>
<script src="js/bootstrap.js"></script>

<script src="js/signin.js"></script>

</body>

</html>
