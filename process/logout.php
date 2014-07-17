<?php
require_once('../classes/session.php');
$session = new Session();

if($session->is_loggedin())
{
	$session->logout();
	header('Location: ../index.php');
}
header('Location: ../index.php');
?>