<?php
	require_once '../classes/database.php';
	require_once '../classes/utilisateur.php';
	require_once '../classes/session.php';
	require_once 'users.php';

  $session = new Session();

    if (!empty($_POST)) {
    	$username = trim($_POST['username']);
    	$pass = trim($_POST['pass']);
    }
    if (empty($_POST['username']) || empty($_POST['pass'])) {
    	$session->message( 'Veuillez entrer votre identifiant et votre mot de passe');
		header('Location: ../login.php');
    }
    elseif (!user_exists($username)) {
    	$session->message( 'Cet identifiant n\'est pas valable, êtes-vous inscrits?');
		header('Location: ../login.php');
    }
     elseif (!user_active($username)) {
     	$_SESSION['username'] = $username;
     	$session->message('Vous n\'avez pas encore activé votre compte.');
		header('Location: ../login.php');
    } else {
		$ut = new Utilisateur();
    	$login = $ut->authenticate($username, $pass);
    	if (!$login) {
    		$session->message( 'La combinaison identifiant/mot de passe n\'est pas valide');
			header('Location: ../login.php');
    	} else {
                $data=$ut->get_utilisateur();
				$session->login($data["u_id"],true);
				$session->remember_me();
				header('Location: ../gestion.php');
    	}
    }
?>