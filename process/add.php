<?php
require_once '../classes/database.php';
require_once '../classes/utilisateur.php';
require_once '../classes/session.php';
require_once '../classes/ouvrier.php';
require_once '../classes/chef.php';
require_once 'users.php';

$session = new Session();

if(!empty($_POST['prenomouvrier'])) {
	$ou = new Ouvrier();
	$register_data = array(
		'o_nom' => ucfirst($_POST['nomouvrier']),
		'o_prenom' => ucfirst($_POST['prenomouvrier']),
		'qrcode' => $_POST['qrcode'],
		'c_id' => $_POST['chef']
	);
	foreach ($register_data as $key => $value) {
		$ou->set_ouvrier($key,$value);
	}
	$ou->create();
	header('Location: ../gestion.php?id=' . $_POST['chef']);
}

if(!empty($_POST['prenomchef'])) {
	$ch = new Chef();
	$register_data = array(
		'c_nom' => ucfirst($_POST['nomchef']),
		'c_prenom' => ucfirst($_POST['prenomchef']),
	);
	foreach ($register_data as $key => $value) {
		$ch->set_chef($key,$value);
	}
	$ch->create();
	header('Location: ../gestion.php');
}