<?php
	require_once(__DIR__.'/../classes/database.php');
	require_once(__DIR__.'/../classes/utilisateur.php');
	require_once(__DIR__.'/../classes/session.php');
	//require_once(__DIR__.'/../classes/email.php');
	require_once(__DIR__.'/../lib/password.php');

	global $id;
    function user_exists($username)
	{
	    global $db;
		$sql = 'SELECT u_id FROM utilisateur WHERE username = :username';
		$re=$db->query($sql,array("username"=>$username));
		$resultat=$re->fetch();

		if (empty($resultat)) {
			return false;
		} else {
			$GLOBALS['id'] = $resultat['u_id'];
			return true;
		}
	}

	function user_active($username)
	{
	    global $db;
	    $sql = 'SELECT u_id FROM utilisateur WHERE username = ? AND validation = ?';
		$re=$db->query($sql,array($username, 1));
		$resultat=$re->fetch();
		
		if (empty($resultat)) {
			return false;
		} else {
			return true;
		}
	}

	function register_user($register_data)
	{
		global $db;
		$register_data['password'] = password_hash($register_data['password'], PASSWORD_BCRYPT);
		$ut = new Utilisateur();
		foreach ($register_data as $key => $value) {
			$ut->set_utilisateur($key,$value);
		}
		$ut->create();
	}
	function email_user($register_data ,$emailcode)
	{
		$em = new Email();
		$em->Email();
		if ($_SESSION['utilisateur'] == 'Etudiant') {
			$nomComplet = $register_data['e_nom'] . ' ' . $register_data['e_prenom'];
			$em->emailThisOne($register_data['e_email'], $nomComplet);
			$emailBody = 'Bonjour '. $register_data['e_prenom'] . ',<br />' . 
			'<p>Merci pour votre inscription.<br />Pour activer votre compte 
			veuillez copier et coller ce code dans la page de l\'activation :<br /><br /><br />' . 
			$emailcode . '<br /><br /></p>-- EtudesPro.';
		} else {
			$nomComplet = $register_data['pf_nom'] . ' ' . $register_data['pf_prenom'];
			$em->emailThisOne($register_data['pf_email'], $nomComplet);
			$emailBody = 'Bonjour,<br />' . 
			'<p>Merci pour votre inscription.<br />Pour activer votre compte 
			veuillez copier et coller ce code dans la page de l\'activation :<br /><br /><br />' . 
			$emailcode . '<br /><br /></p>-- EtudesPro.';
		}
		$em->setEmail("Confirmation d'inscription", $emailBody, true);
	}

	function activate($email)
	{
		global $db;
		$email = escape($email);
		if ($_SESSION['utilisateur'] == 'Etudiant') {
			$et = new Etudiant();
			$et->find_by_email($email);
			$et->set_etudiant('e_validation', 1);
			$et->update();
		} else {
			$pf = new Prof();
			$pf->find_by_email($email);
			$pf->set_prof('pf_validation', 1);
			$pf->update();
		}
	}

	function changeProfPassword($user_id, $password)
	{
		$password = password_hash($password, PASSWORD_BCRYPT);
		$pf = new Prof();
		$pf->find_by_id($user_id);
		$pf->set_prof('pf_password', $password);
		$pf->update();
	}

	function changePassword($user_id, $password)
	{
		$password = password_hash($password, PASSWORD_BCRYPT);
		$et = new Etudiant();
		$et->find_by_id($user_id);
		$et->set_etudiant('e_password', $password);
		$et->update();
	}

	function updateCNE($user_id, $cne)
	{
		$et = new Etudiant();
		$et->find_by_id($user_id);
		$et->set_etudiant('e_cne', $cne);
		$et->update();
	}

	function updateNumTel($user_id, $nTel)
	{
		$et = new Etudiant();
		$et->find_by_id($user_id);
		$et->set_etudiant('e_tel', $nTel);
		$et->update();
	}

	function updateEmail($user_id, $mail)
	{
		$et = new Etudiant();
		$et->find_by_id($user_id);
		$et->set_etudiant('e_email', $mail);
		$et->update();
	}

	function updateNom($user_id, $nom)
	{
		$et = new Etudiant();
		$et->find_by_id($user_id);
		$et->set_etudiant('e_nom', ucfirst($nom));
		$et->update();
	}

	function updatePrenom($user_id, $prenom)
	{
		$et = new Etudiant();
		$et->find_by_id($user_id);
		$et->set_etudiant('e_prenom', ucfirst($prenom));
		$et->update();
	}

	function recoverPass($person, $email)
	{
		$generated_pass = substr(md5(rand(999, 999999)), 0, 8);
		$em = new Email();
		$em->Email();

		if ($person == 'Etudiant') {
			$et = new Etudiant();
			$et->find_by_email($email);
			$et_data= $et->get_etudiant();
			changePassword($et_data['e_id'], $generated_pass);
			$nomComplet = $et_data['e_nom'] . ' ' . $et_data['e_prenom'];
		} else {
			$pf = new Prof();
			$pf->find_by_email($email);
			$pf_data= $pf->get_prof();
			changeProfPassword($pf_data['pf_id'], $generated_pass);
			$nomComplet = $pf_data['pf_nom'] . ' ' . $pf_data['pf_prenom'];
		}

		$em->emailThisOne($email, $nomComplet);
		$emailBody = 'Bonjour,<br />' . 
		'<p>Vous avez oublié votre mot de passe;<br />Veuillez vous connectez avec ce mot 
		de passe la prochaine fois :<br /><br /><br />' . 
		$generated_pass . '<br /><br /></p>-- EtudesPro.';
		$em->setEmail("Récupérer votre mot de passe", $emailBody, true);
	}
?>